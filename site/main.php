<?php

namespace
{
	require(__DIR__.'/config.php');
	require(__DIR__.'/init.php');

	// Headers.
	header('Content-Type: text/html; charset='._APP_ENCODING);

	// Framework, extensions and application loading.
	foreach ($_app_modules_map as $moduleName)
	{
		include(NamespaceNameToPathName($moduleName).'config.php');
		include(NamespaceNameToPathName($moduleName).'init.php');
	}
	$_app_extensions_loaded = true;

	// Request processing..
	//FrontController()->ProcessRequest();
	Controller::getFrontController()->ProcessRequest();
	
	require(__DIR__.'/test.php');
}

?>