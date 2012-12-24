<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */


/**
 * Smarty {fetch} plugin
 *
 * Type:     function<br>
 * Name:     fetch<br>
 * Purpose:  fetch file, web or ftp data and display results
 * @link http://smarty.php.net/manual/en/language.function.fetch.php {fetch}
 *       (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param array $params parameters
 * @param object $smarty Smarty object
 * @param object $template template object
 * @return string|null if the assign parameter is passed, Smarty assigns the
 *                     result to a template variable
 */
function smarty_function_language($params, $smarty, $template)
{
	$keys = array_keys($params);
	//return print_r($params,true);
	//return print_r($keys,true);
    return Lang::getString($keys[0]);
}

?>
