<?php

/**
* Smarty method setPluginsDir
* 
* Sets directory of plugin files
* 
* @package Smarty
* @subpackage SmartyMethod
* @author Uwe Tews 
*/

/**
* Sets directory of plugin files
*/

/**
* Sets directory of plugin files
* 
* @param string $ plugins folder
* @return 
*/
function SetPluginsDir($smarty, $plugins_dir)
{
    $smarty->plugins_dir = (array)$plugins_dir;
    return;
} 

?>
