<?php

/**
 * Core class
 * 
 * The main core class which manages everything of the framework.
 * 
 * @author Ralph Küpper, Serhiy Medvedyev
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



abstract class Core
{
	public $files;
	/** The cookies. */
	private $cookies;
	/** The get variables. */
	private $gets;
	/** The posts variables. */
	private $posts;
	/** The outputs. */
	private $outputs;
	/** The queries. (foo/bar/...) */
	public $queries;
	/** The plugins. */
	private $plugins;
	
	public $renderMode;
	
	
	
	/**
	 * Just create the core.
	 * 
	 * */
	public function __construct()
	{
		$this->outputs = array();
		$this->loadPlugins();
		$this->init();	
	}
	/**
	 * Init function for all subclasses of core.
	 */
	public function init() 
	{
		// nothing special
	}
	/**
	 * This function will be called when the main process is finished.
	 */
	public function afterAll()
	{
		// nothing special
	}
	/**
	 * Loads all plugins from the given plugin path. If there is no specific path, core tries to load from "plugin/".
	 * If there is no rule for loading plugins core loads every plugin which is inside the folder (not very performant).
	 */
	public function loadPlugins()
	{
		$pluginsToLoad = Config::getConfig("plugins");

		$pluginDir = PLUGIN_PATH;

		if ($pluginsToLoad == "")
		{
			// check the plugin folder

			$dir = opendir($pluginDir);

			Logger::log("Reading plugins...");
		
			// an array for all plugins, to start them after inclusion
			$this->plugins = array();

			// read the files
			while ($file = readdir($dir))
			{
				if ($file != "." && $file != "..")
				{
					$this->loadPlugin($file);
				}
			}
		}
		else {
			
			Logger::log("Loading given plugins '".$pluginsToLoad."' ...");

			// an array for all plugins, to start them after inclusion
			$this->plugins = array();
			
			$pluginsToLoadArray = explode(",", $pluginsToLoad);

			// read the files
			foreach ($pluginsToLoadArray as $file)
			{
				$this->loadPlugin(ucwords($file));
			}
			
		}
	}
	/**
	 * Loads a plugin. You just have to give the name and the script will load it like the "loadPlugins" function.
	 * @param string $pluginName
	 */
	protected function loadPlugin($pluginName,  $dir = "")
	{
		$pluginDir = "plugins/";

		if ($dir != "")
		{
			$pluginDir = $dir;
		}
		
		if (Config::getConfig("plugin_dir") != "" && $dir == "") $pluginDir = Config::getConfig("plugin_dir");

		if (file_exists($pluginDir.$pluginName."/".$pluginName.".plugin.php"))
		{
			// load the plugin

			require_once($pluginDir.$pluginName."/".$pluginName.".plugin.php");


			Logger::log("Loading: ".$pluginName);


			// create the class
if($pluginName!='JError'){/* !!! - continue from here */
			$plugin = new $pluginName($this);


			// set the name

			$plugin->name = $pluginName;

			// call init
			$plugin->init();


			$this->plugins[] = $plugin;
}
		}
		else {
			// log the error
			Logger::log("Plugin '".$pluginName."' not found.", "error");
		}
	}
	/**
	 * Sends the header to redirect the user to an url. If $dieAfter is true, the script stops after sending.
	 * @param string $where
	 * @param boolea $dieAfter [optional]
	 */
	public function redirect($where, $dieAfter = true)
	{
		header("Location: ".$where);
		if ($dieAfter == true) 
		{
			$this->afterAll();
			die();
		}
	}
	public function isPlugin($name)
	{
		foreach ($this->plugins as $plugin)
		{
			if ($plugin->name == $name)
			{
				return true;
			}
		}
		return false;
	}
	/**
	 * Returns a plugin which is loaded before. If there is none loaded, it will be loaded here.
	 * @param string $name
	 * @return Plugin
	 */
	public function getPlugin($name)
	{
		// find it in the local list
		foreach ($this->plugins as $plugin)
		{
			if ($plugin->name == $name)
			{
				return $plugin;
			}
		}
		// nothing found, try to load it
		$this->loadPlugin($nam);
		
		return null;
	}
	/**
	 * This function starts all plugins.
	 */
	private function startPlugins()
	{
		// start the plugins 
		foreach ($this->plugins as $plugin)
		{
			Logger::log("Starting plugin: ".$plugin->name);
			
			// execute the plugin
			$plugin->execute();
		}
	}
	/**
	 * This function calls the after running function in every loaded plugin.
	 */
	private function afterRunningPlugins()
	{
		foreach ($this->plugins as $plugin)
		{
			Logger::log("Afterrunning plugin: ".$plugin->name);
			// call after-runnig
			$plugin->afterRunning();
		}
	}
	
	private function frameworkIncludes()
	{
		global $HTML_HEAD_DATA;
		global $HTML_HEAD_DATA_ARR;
		global $HTML_HEAD_FILES;
		global $HTML_HEAD_FILES_EXCLUSIONS;
		
		// http static files

		foreach ( $HTML_HEAD_DATA_ARR as $str => $tag ) {
		if ( isset($HTML_HEAD_FILES_EXCLUSIONS[$tag])) continue ;
	
			$HTML_HEAD_DATA.= $str;
		}
		foreach ( $HTML_HEAD_FILES as $item ) {
			$str = '';
	
			if ( isset($HTML_HEAD_FILES_EXCLUSIONS[$item['tag']])) continue ;
		
			$itemPath = ( substr($item['path'], 0, 4) == 'http' ) ? $item['path'] : ( Config::getConfig('base') . $item['path'] ) ;
			
			if ( $item['type'] == 'js' ) {
				$str.= '<script src="'.$itemPath.'" type="text/javascript"></script>';
			} else if ( $item['type'] == 'css' ) {
				$str.= '<link href="'.$itemPath.'" rel="stylesheet" type="text/css">';
			}
	
			$HTML_HEAD_DATA.= $str;
		}
	}
	
	/**
	 * The function which starts the module and things like this.
	 * */
	public function execute()
	{ 
		$this->startPlugins();
		// index is the stanart start module, if none is set
		$moduleName = "Index";

		// is another module set?
		if (count($this->queries)>0)
		{
			// get the name
			if (trim($this->queries[0])!="") $moduleName = ucwords($this->queries[0]);
			// cut php, html etc.
			$cuts = array(".php", ".html", ".css",".js");
			$moduleName = str_replace($cuts,"", $moduleName);
		}
		// run the module
		$this->runModule($moduleName);
		// call the function to quit the plugins (after-running)
		$this->afterRunningPlugins();
		// put all data and included files in global HTML_HEAD_DATA
		$this->frameworkIncludes();
		// call our own after-all function in subclasses
		$this->afterAll();
	}
	/**
	 * Runs a module.
	 * @param string $moduleName
	 */
	public function runModule($moduleName)
	{
		global $_FRAMEWORK;
		
		// default path
		$defaultWebappDir = "../webapp/";
		// same dir as the webapp
		$webappDir = $defaultWebappDir;
		// is another path set?
		if ($_FRAMEWORK['webappPath'] != "")
		{
			// set it ..
			$webappDir = $_FRAMEWORK['webappPath'];
		}
		// if path is incorrect
		if (!is_dir($webappDir))
		{
			Logger::log("Webapp not found","error");
			return;
		}
		// the module dir
		$moduleDir = $webappDir."modules/";
		// if the module dir is set in the config
		if (Config::getConfig("ajax_module_dir") != "") $moduleDir = Config::getConfig("ajax_module_dir");

		// define it
		define("MODULE_DIR",$moduleDir);

		// if every path is correct ...
		if (is_dir($moduleDir.$moduleName) && is_file($moduleDir.$moduleName."/".$moduleName.".module.php"))
		{
			Logger::log("Starting $moduleName...");
			
			// load the file
			require_once $moduleDir.$moduleName."/".$moduleName.".module.php";
			// create the instanc for the module
			$module = new $moduleName($this);
			// execute the modul
			$module->execute();
		}
		else {
			Logger::log("No module(".$moduleDir.$moduleName."/".$moduleName.".module.php) is found. Please install the webapp.", "error");
		}
	}
	
	public function loadModule($moduleName)
	{
		// if every path is correct ...
		if (is_dir(MODULE_DIR.$moduleName) && is_file(MODULE_DIR.$moduleName."/".$moduleName.".module.php"))
		{
			// load the file
			require_once MODULE_DIR.$moduleName."/".$moduleName.".module.php";
		}
		else {
			Logger::log("No module(".MODULE_DIR.$moduleName."/".$moduleName.".module.php) is found. Please install the webapp.", "error");
		}
	}
	
	/**
	 * Adds an output.
	 * @param Output $output
	 * @return 
	 */
	public function addOutput($output)
	{
		$this->outputs[] = $output;
	}
	
	/**
	 * Returns the rendered content of the page in the given mode.
	 * @param $mode - The mode to render.
	 * @return the rendered content
	 * */
	public function render($mode = "")
	{
		$outputString = "";
		
		if ($this->renderMode == "" && $mode == "") $mode = "html";
		if ($this->renderMode != "") $mode = $this->renderMode;
		
		
		foreach ($this->outputs as $output)
		{
			$outputString .= is_string($output) ? $output : $output->render($mode, $this);
		}
		
		return $outputString;
	}
	
	/**
	 * Returns the headers.
	 * @return the headers.
	 * */
	public function getHeaders()
	{
		return "";
	}
	public function setHeader($header)
	{
		header($header);
	}
	/**
	 * Returns the instance of a post input.
	 * @param $key the key of the input
	 * @return PostInput
	 * */
	public function getPost($key)
	{
		$k = md5($key);
		if ( isset($this->posts[$k]) ) return $this->posts[$k];
		return null;
	}
	/**
	 * Returns the instance of a get input.
	 * @param $key the key of the input
	 * @return GetInput
	 * */
	public function getGet($key)
	{
		return $this->gets[md5($key)];
	}
	/**
	 * Returns a cookie instance.
	 * @param $key the key of the cookie
	 * @return Cookie
	 * */
	public function getCookie($key)
	{
		return $this->cookie[md5($key)];
	}
	/**
	 * Sets the posts.
	 * @param $posts array of posts (no instances)
	 * */
	public function setPosts($posts)
	{
		foreach ($posts as $key=>$value)
		{
			$this->posts[md5($key)] = new PostInput($key, $value);
		}
	}
	
	public function getPosts()
	{
		return $this->posts;
	}
	/**
	 * Sets the gets.
	 * @param $gets array of gets (no instances)
	 * */
	public function setGets($gets)
	{
		foreach ($gets as $key=>$value)
		{
			$this->gets[md5($key)] = new GetInput($key, $value);
		}
	}
	/**
	 * Generates the queries in this class. 
	 * @param String $from [optional]
	 */
	public function generateQueries($from = "query")
	{
		$this->queries = explode("/", ($this->getGet($from) ? $this->getGet($from)->value : '' ));
	}
	
	/**
	 * Sets the cookies.
	 * @param $cookies array of cookies (no instances)
	 * */
	public function setCookies($cookies)
	{
		foreach ($cookies as $key=>$value)
		{
			$this->cookies[md5($key)] = new Cookie($key, $value);
		}
	}
	
	public function createCookie($name = "", $value = "", $path = "", $domain = "", $time = "")
	{
		if (Config::getConfig('cookie_domain')!="") $domain = Config::getConfig('cookie_domain');
		$cookie = new Cookie($name, $value, $path, $domain, $time);
		setcookie($name, $value, intval($time), $path, $domain);
		return $cookie;
	}
	
	/**
	 * Returns the ip of the user.
	 */
	public static function getIP()
	{
		return getenv("REMOTE_ADDR");
	}
	/**
	 * Returns the user agent user. 
	 */
	public static function getUserAgent()
	{
		return getenv("HTTP_USER_AGENT");
	}
	/**
	 * Returns the browser of the user.
	 * @return 
	 */
	public static function getBrowser()
	{
		return getenv("HTTP_USER_AGENT");
	}
	
}
