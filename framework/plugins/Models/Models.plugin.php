<?php
/**
 * Models is a plugin for rapid and good data access in databases. It's part of the mvc-philosophie of gww. 
 * 
 * Copyright 2010 by Ralph Küpper and Skelpo UG
 */


class Models extends Plugin
{
	public function init() 
	{
		$pluginDir = FRAMEWORK_BASE."plugins/";
		if (Config::getConfig("plugin_dir") != "") $pluginDir = Config::getConfig("plugin_dir");
		
		include($pluginDir . "Models/Model.class.php");
		include($pluginDir . "Models/ModelCreator.class.php");
		
	}
	
	
	public function execute()
	{
		
	}
	
}
?>