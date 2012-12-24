<?php

class JSON extends Plugin
{
	public function init()
	{
		$pluginDir = FRAMEWORK_BASE."plugins/";
		if (Config::getConfig("plugin_dir") != "") $pluginDir = Config::getConfig("plugin_dir");
		
		include($pluginDir . "JSON/JSONObject.class.php");
		include($pluginDir . "JSON/JSONOutput.class.php");
	}
	
	public function execute()
	{
		
	}
}
