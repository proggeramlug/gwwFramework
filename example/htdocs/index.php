<?php

// Basic configuration to set up where everything is.
// It is recommended to have one copy of the framework used by multiple webapp instances.
$_FRAMEWORK['frameworkPath'] = "../framework/";
$_FRAMEWORK['webappPath'] = "../webapp/";
$_FRAMEWORK['cachePath'] = "../cache/";
$_FRAMEWORK['configPath'] = "../webapp/config/config.cfg";
$_FRAMEWORK['name'] = "Example";

// Call the framework (which calls the webapp)
include($_FRAMEWORK['frameworkPath']."Framework.php");

?>
