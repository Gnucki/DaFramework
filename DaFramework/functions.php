<?php

namespace
{
	// Convert error into exception depending on severity.
	function ErrorHandler($severity, $message, $fileName, $lineNo)
	{
		global $_app_extensions_loaded;
		try
		{
			throw new ErrorException($message, 0, $severity, $fileName, $lineNo);
		}
		catch (Exception $exception)
		{
			if ($_app_extensions_loaded === true)
				ExceptionHandler()->Log($exception);
			else
			{
				if ((bool)($severity & ini_get('error_reporting')))
					error_log($message, 0);
				return false;
			}
		}
		return false;
	}
	set_error_handler("ErrorHandler");

	// Autoload classes on need if the name of the class and namespace are similar to the filetree.
	function __autoload($className)
	{
		require_once(ClassNameToFileName($className));
	}

	/**
	* Convert a namespace name to an absolute path name.
	* @param string $className The class name (with namespace name).
	*/
	function NamespaceNameToPathName($namespaceName, $openName = false)
	{
		global $_app_mapping_namespaceclass_pathfile;
		$parentNamespaceName = '';
		$mappedNamespaceName = '';
		$namespaceNameArray = explode('\\', $namespaceName);

		foreach ($namespaceNameArray as $namespaceName)
		{
			if ($namespaceName !== '')
			{
				if ($parentNamespaceName !== '')
					$parentNamespaceName .= '\\';
				$parentNamespaceName .= $namespaceName;
				if (array_key_exists($parentNamespaceName, $_app_mapping_namespaceclass_pathfile))
					$mappedNamespaceName = $_app_mapping_namespaceclass_pathfile[$parentNamespaceName];
				else if (array_key_exists('\\'.$parentNamespaceName, $_app_mapping_namespaceclass_pathfile))
					$mappedNamespaceName = $_app_mapping_namespaceclass_pathfile['\\'.$parentNamespaceName];
				else
					$mappedNamespaceName .= '\\'.$namespaceName;
			}
		}

		$firstMappedNamespaceNameCharacter = substr($mappedNamespaceName, 0, 1);
		$lastAbsoluteRootPathCharacter = substr(_APP_ABSOLUTE_ROOT_PATH, -1);
		if (($firstMappedNamespaceNameCharacter === '/' || $firstMappedNamespaceNameCharacter === '\\') &&
			($lastAbsoluteRootPathCharacter === '/' || $lastAbsoluteRootPathCharacter === '\\'))
			$mappedNamespaceName = substr($mappedNamespaceName, 1);
		$pathName = str_replace('\\', '/', _APP_ABSOLUTE_ROOT_PATH.$mappedNamespaceName);
		if ($openName === false && substr($pathName, -1) !== '/')
			$pathName .= '/';
		return $pathName;
	}

	// Return the absolute file name from a class name.
	function ClassNameToFileName($className)
	{
		return NamespaceNameToPathName($className, true).'.php';
	}
}

?>