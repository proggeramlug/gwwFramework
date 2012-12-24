<?php
/**
 * Language plugin
 * 
 * Loads from the language files.
 * 
 * @author Ralph Küpper
 * 
 * This script is part of the gwwFramework.
 * 
 * */

class Language extends Plugin
{
	
	public function init()
	{
		include(FRAMEWORK_BASE."plugins/Language/Lang.class.php");
	}
	
	public function compileTemplateString($string)
	{
		return Lang::getString($string);
	}
	
	public function execute()
	{
		
	}
}
?>
