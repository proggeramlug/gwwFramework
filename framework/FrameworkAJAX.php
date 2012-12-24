<?php
/**
 * Framework for use in AJAX scripts.
 * 
 * @author Ralph Küpper, Serhiy Medvedyev
 * 
 * This script is part of the gwwFramework.
 * 
 *
 */


/*
 * Needed infos from the calling index.php
 * 
 * $_FRAMEWORK['frameworkPath'] = "";
 * $_FRAMEWORK['webappPath'] = "";
 * $_FRAMEWORK['name'] = "";
 * 
 */

if (
	$_FRAMEWORK['name'] == '' ||
	$_FRAMEWORK['webappPath'] == '' ||
	$_FRAMEWORK['frameworkPath'] == ''
)
{
	die('no correctly set up framework');
}

require_once($_FRAMEWORK['frameworkPath']."common.php");


ob_start();

$HTML_HEAD_DATA = ''; // additional html head section data
$HTML_HEAD_DATA_ARR = array(); // array of strings(to prevent duplicating)
$HTML_HEAD_FILES = array(); // array of files to insert
$HTML_HEAD_FILES_NAMES = array(); // names of inserting files
$HTML_HEAD_FILES_EXCLUSIONS = array();

function includeJSFile($path, $tag = 'Common')
{
	global $HTML_HEAD_FILES;
	global $HTML_HEAD_FILES_NAMES;
	if ( isset($HTML_HEAD_FILES_NAMES[$path] ) ) return ;

	array_push($HTML_HEAD_FILES, array('path' => $path, 'tag' => $tag, 'type' => 'js'));
}

function includeCSSFile($path, $tag = 'Common')
{
	global $HTML_HEAD_FILES;
	global $HTML_HEAD_FILES_NAMES;
	if ( isset($HTML_HEAD_FILES_NAMES[$path] ) ) return ;

	array_push($HTML_HEAD_FILES, array('path' => $path, 'tag' => $tag, 'type' => 'css'));
}

function unincludeFiles($tag)
{
	global $HTML_HEAD_FILES_EXCLUSIONS;
	$HTML_HEAD_FILES_EXCLUSIONS[$tag] = 1;
}

function addHTMLHeader($str, $tag = 'Common')
{
	global $HTML_HEAD_DATA_ARR;

	if( !isset($HTML_HEAD_DATA_ARR[$str]) ) {
		$HTML_HEAD_DATA_ARR[$str] = $tag;
	}
}


$coreFolder = 'coreAJAX';



// define some globals for the app
define("WEBAPP_BASE", $_FRAMEWORK['webappPath']);
define("FRAMEWORK_BASE", $_FRAMEWORK['frameworkPath']);


// the includes
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Logger.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Input.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/GetInput.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/PostInput.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Cookie.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Output.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Config.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Module.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/StringOutput.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Plugin.class.php");
include($_FRAMEWORK['frameworkPath'].$coreFolder."/Core.class.php");

// define plugin path
$pluginPath = Config::getConfig("plugin_dir");
define("PLUGIN_PATH",$pluginPath);


// start time - to controll the length of time
$startTime = microtime();


// fetch the complete input
$gets = $_GET;
$posts = $_POST;
$server = $_SERVER;
$cookies = $_COOKIE;
$files = $_FILES; 

include_once($_FRAMEWORK['webappPath'].$_FRAMEWORK['name'].".class.php");
$name = $_FRAMEWORK['name'];
$core = new $name();

// set the inputs
$core->setPosts($posts);
$core->setGets($gets);
$core->setCookies($cookies);
$core->generateQueries();

// the main process
$core->execute();

// set the headers
header($core->getHeaders());

// echo the rendered output
$content = $core->render();

// end time
$endTime = microtime();

// the used time
$usedTime = $endTime-$startTime;

// log the time...
Logger::log("Used time: ".$usedTime);



if (Config::getConfig("show_log") == "true")
{
	$content = str_replace("{log}", "<div id=\"frameworklog\">".Logger::$logger->getLog()."</div>", $content);
}
else {
	$content = str_replace("{log}", "", $content);
}
ob_end_clean();
ob_start();
echo $content;
ob_end_flush();



