<?php
/**
 * The file which the .htaccess calls. From here everything else will be called.
 * 
 * @author Ralph Küpper, Serhiy Medvedyev
 * 
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


//$path = realpath(dirname($_SERVER['SCRIPT_FILENAME']))."/";



// define some globals for the app
define("WEBAPP_BASE", $_FRAMEWORK['webappPath']);
define("FRAMEWORK_BASE", $_FRAMEWORK['frameworkPath']);


// the includes
include($_FRAMEWORK['frameworkPath']."core/Logger.class.php");
include($_FRAMEWORK['frameworkPath']."core/Input.class.php");
include($_FRAMEWORK['frameworkPath']."core/GetInput.class.php");
include($_FRAMEWORK['frameworkPath']."core/PostInput.class.php");
include($_FRAMEWORK['frameworkPath']."core/Cookie.class.php");
include($_FRAMEWORK['frameworkPath']."core/Output.class.php");
include($_FRAMEWORK['frameworkPath']."core/Config.class.php");
include($_FRAMEWORK['frameworkPath']."core/Module.class.php");
include($_FRAMEWORK['frameworkPath']."core/StringOutput.class.php");
include($_FRAMEWORK['frameworkPath']."core/Plugin.class.php");
include($_FRAMEWORK['frameworkPath']."core/Core.class.php");


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


?>
