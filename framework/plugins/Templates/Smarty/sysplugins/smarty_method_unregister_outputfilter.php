<?php

/**
* Smarty method Unregister_Outputfilter
* 
* Unregister a outputfilter
* 
* @package Smarty
* @subpackage SmartyMethod
* @author Uwe Tews 
*/

/**
* Unregister a outputfilter
*/

/**
* Registers an output filter function to apply
* to a template output
* 
* @param callback $function 
*/
function unregister_outputfilter($smarty, $function)
{
    unset($smarty->registered_filters['output'][$smarty->_get_filter_name($function)]);
} 

?>
