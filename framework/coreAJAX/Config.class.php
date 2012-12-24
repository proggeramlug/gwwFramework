<?php
/**
 * Config class
 * 
 * Loads the config from the webapp dir.
 * 
 * @author Ralph Küpper
 * 
 *  This script is part of the gwwFramework. Developed and produced by Skelpo - hot software.
 *  If you have any questions, recommendations or general requests visit our website
 *  http://www.skelpo.com or write an email to info@skelpo.com
 * 
 *  Copyright (C) 2012  Skelpo
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * */


class Config
{
	// the path to the configuration
	private $path;
	// the vars in the config
	private $vars;
	
	// the global config instance
	public static $CONFIG = null;
	
	// create a config instance
	public function __construct($path)
	{
		Logger::log("Loading config in $path");
		$this->path = $path;
		$this->vars = array();
		$this->load();
	}
	/**
	 * Loads the data.
	 * */
	private function load()
	{
		global $_FRAMEWORK;
		
		// predefined config dir, if no other is given
		$path = WEBAPP_BASE."../cache/".md5($this->path."GWW");
		
		if ($_FRAMEWORK['cachePath']!="")
		{
			$path = $_FRAMEWORK['cachePath'].md5($this->path."GWW");
		}
		
		if (file_exists($path))
		{
			$this->loadFromCache($path);
		}
		else {

			if (is_file($this->path))
			{
				$lines = file($this->path);

				foreach($lines as $line)
				{
					if (substr($line,0,1)!="#"&&trim($line)!='')
					{
							
						$data = explode("=", $line);
						$name = trim($data[0]);
						$value = trim($data[1]);
						if (is_numeric($value)) $value = intval($value);
						$this->vars[$name] = $value;
						
					}
				}
			}
			$this->writeToCache($path);
		}
	}
	/**
	 * Returns a value of the vars-array.
	 * @return value of the array
	 * */
	public function getConfiguration($name) 
	{
		$value = "";
		
		// check it before
		if (array_key_exists($name, $this->vars))
		{
			$value = $this->vars[$name];
		}
		else {
			// log if there is an error
			Logger::log("Configuration key ".$name." does not exist.","warning");
		}
		
		return $value;
	}
	/**
	 * Sets a value of the vars-array.
	 * @return value of the array
	 * */
	public function setConfiguration($name, $value) 
	{
		$this->vars[$name] = $value;
	}
	/**
	 * Returns the configuration by the name.
	 * @param $name the name of the configuration.
	 * */
	public static function getConfig($name)
	{
		global $_FRAMEWORK;
		$path = $_FRAMEWORK['webappPath'];
		
		if (Config::$CONFIG == null) {
			if ($_FRAMEWORK['configPath']!="")
			{
				Config::$CONFIG = new Config($_FRAMEWORK['configPath']);
			}
			else {
				Config::$CONFIG = new Config($path."config/config.cfg");
			}
		}
		return Config::$CONFIG->getConfiguration($name);
	}
	/**
	 * Set the configuration by the name.
	 * @param $name the name of the configuration.
	 * @param $value the value of the configuration.
	 * */
	public static function setConfig($name, $value)
	{
		global $_FRAMEWORK;
		$path = $_FRAMEWORK['webappPath'];
		
		if (Config::$CONFIG == null) {
			if ($_FRAMEWORK['configPath']!="")
			{
				Config::$CONFIG = new Config($_FRAMEWORK['configPath']);
			}
			else {
				Config::$CONFIG = new Config($path."config/config.cfg");
			}
		}
		return Config::$CONFIG->setConfiguration($name, $value);
	}
	/**
	 * Generates the cache-output.
	 * @return php-valid code
	 */
	private function compileConfig()
	{
		$retCode = "<?php function getConfigVars() {\$a = array();";
		
		foreach ($this->vars as $key=>$var)
		{
			$retCode .= "\$a['".$key."'] =  '".$var."'; ";
			
		}
		$retCode = $retCode ." return \$a; } ?>";
		
		return $retCode;
	}
	/**
	 * Saves the current config file as a php-file.
	 * @param $path The path where to write the file.
	 */
	private function writeToCache($path)
	{
		$file = fopen($path,"w");
		fwrite($file,$this->compileConfig());
		fclose($file);
		
	}
	/**
	 * Loads all variables of this config file from a given path.
	 * @param $path The path of the file.
	 */
	private function loadFromCache($path)
	{
		require_once($path);
		$this->vars = getConfigVars();
		
	}
}

?>