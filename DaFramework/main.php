<?php

namespace
{
	ini_set('display_errors', 1); 
	ini_set('log_errors', 1); 
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
	error_reporting(E_ALL);

	echo 0;
	require(__DIR__.'/config.php');
	echo 1;
	require(__DIR__.'/init.php');
	echo 2;

	// Headers.
	header('Content-Type: text/html; charset='._APP_ENCODING);

	// Framework, extensions and application loading.
	foreach ($_app_modules_map as $moduleName)
	{
		include NamespaceNameToPathName($moduleName).'config.php';
		include NamespaceNameToPathName($moduleName).'init.php';
	}
	$_app_extensions_loaded = true;

	echo 8;
	// Request processing..
	//FrontController()->ProcessRequest();
	//Controller::getFrontController()->ProcessRequest();
	
	require(__DIR__.'/test.php');
	
	echo 9;
}

?>