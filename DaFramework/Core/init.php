<?php

namespace DaFramework\Core
{
	//require_once(ClassNameToFileName('DaFramework\Constants\constants'));
	//require_once(ClassNameToFileName('DaFramework\Controller\Tools\Extension\ExtensionsHandler'));


	foreach ($_app_modules_map as $moduleName)
	{
		if ($moduleName !== __NAMESPACE__) // DaFramework is not an extention.
			Toolbox\Extension\ExtensionsHandler::addExtension($moduleName);
	}
}

?>