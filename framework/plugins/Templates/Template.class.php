<?php
/**
 * Template class
 * 
 * A template in the gwwFramework is just a normal output loaded by a file. In other versions you 
 * will have the possibility to interact in the files (like smarty) but for now that is enough.
 * 
 * A template has a name and the content. It the mode is json (ajax), the template just returns the name and the content.
 * A html output just returns the content - the name is cut out.
 * 
 * A template can use if-conditions like this:
 * $t = new Template("Module/Template");
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


class Template extends Output {
	
	private $smarty; // smarty instance
	
	public $path;
	public $subdir; 
	// the vars to be replaced
	private $vars = array();
	// the "plain" content
	private $plainContent;
	// the rendered content
	private $renderedContent;
	
	private $commands;
	
	private $core;
	
	private $deletedContents;
	
	private $caching;
	private $cacheTime;
	private $cacheId;
	
	public static $TPL_PATH;
	
	/**
	 * Loads the file from the template_dir-path, the subdir and the filename (without tpl)
	 * @param $fileName The filename.
	 * @param $subdir The subdir .. for modules etc.
	 * */
	public function __construct($fileName, $subdir = "")
	{
		if (Template::$TPL_PATH == "")
		{
			Template::$TPL_PATH = Config::getConfig("template_dir").($this->subdir!=""?$this->subdir."/":"");
		}
		$this->deletedContents = false;
		$this->subdir = $subdir;
		$this->name = $fileName;
		$this->path = Template::$TPL_PATH.$this->name.".tpl";
		$this->commands = array();
		$this->setVar("BASE",Config::getConfig("base"));
		
		$this->caching = false;
		$this->cacheTime = 1;
		
		// load
		$this->load();
	}
	
	public static function setTplPath($tplPath)
	{
		Template::$TPL_PATH = $tplPath;
	}
	
	public function setCaching($c, $time = 0, $key = "")
	{
		$this->caching = $c;
		$this->cacheTime = $time;
		$this->cacheId = $key;
	}
	
	public function recreateTemplate($fileName)
	{
		$this->name = $fileName;
		$this->path = Template::$TPL_PATH.$this->name.".tpl";
	}
	
	protected function load()
	{
		// load the template
		if (file_exists($this->path))
		{
			Logger::log("Loading template '".$this->name."' in: ".$this->path);
			$this->plainContent = file_get_contents($this->path);
			
			//if ($this->name=="footer") die($this->path."/".$this->plainContent);
		}
		else {
			Logger::log("Template does not exist in ".$this->path."", "error");
		}
	}
	public function needsRefresh()
	{
		
		if (!$this->smarty) {
			$this->initSmarty();
		}
		
		if ($this->smarty->is_cached($this->path, $this->cacheId))
		{
			return false;
		}
		return true;
	}
	private function initSmarty()
	{
		global $_FRAMEWORK;
		
		$cacheKey = $this->cacheId;
		if ($cacheKey == "") $cacheKey = md5(rand(0,1000).microtime());		
		$this->cacheId = $cacheKey;
		
		$path = WEBAPP_BASE . "../cache/";
		
		if ($_FRAMEWORK['cachePath']!="")
		{
			$path = $_FRAMEWORK['cachePath'];
		}
        
		$this->smarty = new Smarty();	
		$this->smarty->setCacheDir($path);
		$this->smarty->setCompileDir($path ."compile/");
		$this->smarty->setTemplateDir(Config::getConfig("template_dir").($this->subdir!=""?$this->subdir."/":""));
		$this->smarty->debugging = false;
		
		if ($this->caching)
		{
			$this->smarty->caching = true;
			$this->smarty->cache_lifetime = $this->cacheTime;
		}
		else {
			$this->smarty->caching = false;
		}
	}
	/**
	 * Generates the content.
	 * */
	public function generateContent() 
	{
        Logger::log("Generating content of template '".$this->name."'");
        $cacheKey = $this->cacheId;
		
        $this->renderedContent = $this->plainContent;
	
		if (!$this->smarty) {
			$this->initSmarty();
		}
		
		
		
		foreach ($this->vars as $key=>$value)
		{
			if (is_object($value))
			{
				if (is_subclass_of($value, "Output"))
				{
					$value = $value->render("html",null);
				}
			}
			$this->smarty->assign($key, $value);
		}
		
		$this->renderedContent = $this->smarty->fetch($this->path,$cacheKey);
		$this->renderedContent = preg_replace("/##(.+?)##/e","Lang::getString('\\1')",$this->renderedContent);
        
	}
	
	
	/**
	 * Compiles a string in the template. {PluginName:Parameter} calls $core->getPlugin("PluginName")->compileTemplateString("Parameter");
	 * @param string $string
	 * @return 
	 */
	private function compileString($string)
	{

		if (strpos($string,":")>0)
		{
			if (is_null($this->core))
			{
				Logger::log("Core is missing in Templates ('".$this->name."'): ".$string.".","error");
			}
			$command = substr($string,0,strpos($string,":"));
			$atts = substr($string,strpos($string,":")+1);
			
			$plugin = $this->core->getPlugin($command);
			
			if (method_exists($plugin, "compileTemplateString"))
			{
				return $plugin->compileTemplateString($atts);
			}
			else {
				return $atts;
			}
		}

		return "{".$string."}";
	}
	
	/**
	 * Sets a variable.
	 * */
	public function setVar($key, $value)
	{
		$this->vars[$key] = $value;
	}
	/**
	 * Adds an array to the values.
	 * @param array $ar
	 * @return 
	 */
	public function addVars($ar)
	{
		foreach ($ar as $key=>$value)
		{
			$this->setVar($key, $value);
		}
	}
	
	/**
	 * Renders the template
	 * @param string $mode [optional]
	 * @param Core $core [optional]
	 * @param boolean $regenerate [optional]
	 * @return string
	 */
	public function render($mode = "html",$core = null, $regenerate = false)
	{
		$this->core = $core;
		
		if ($this->deletedContents) return "";
		$this->core = $core;
		if ($this->renderedContent == "" || $regenerate == true) $this->generateContent();
		//if ($this->name == "header") return $this->renderedContent." / ".$this->plainContent;
		if ($mode == "html")
		{
			return $this->renderedContent;
		}
		else {
			
			$this->addJSONOutput("content", $this->renderedContent);
			$this->addJSONOutput("name", $this->name);
			return $this->getJSONOutput();
		}
	}
	/**
	 * Delete the whole content of this template.
	 * @return void
	 */
	public function deleteContent()
	{
		$this->plainContent = "";
		$this->deletedContents = true;
		$this->generateContent();
	}
	
}
