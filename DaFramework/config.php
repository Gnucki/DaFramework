<?php

// This config.php is the general config file for your website.
// Absolute root path (where this file and the main.php are).
define('_APP_ABSOLUTE_ROOT_PATH', 'C:/Divers/Workspace/plap/DaFramework');

// Encoding.
define('_APP_ENCODING', 'utf-8');

// Main database.
define('_APP_DB_DSN', 'mysql:host=localhost;dbname=superbase3');
define('_APP_DB_USERNAME', 'utilstand');
define('_APP_DB_PASSWORD', 'xxxTPx92$');

// Mapping between namespace/class and path/file.
// It is highly recommended to have a physical filetree similar to your namespaces. In that case you
// don't have to fill this array.
// It allows you to precise namespace in place of path in class' methods and functions so it's possible
// to change path easily.
//
// Exemple: $_app_mapping_namespaceclass_pathfile = array('\Application\Model\ClassName' => 'Application/Model/ClassFileName.php',
//													  ... => ...,
//													  ... => ...);
$_app_mapping_namespaceclass_pathfile = array();

// Application Map (relative to the absolute root path).
// In dependencies order.
//
// Exemple: $_app_map = array('DaFramework', 'Extension1', 'Extension2', 'Application');
// DaFramework is Daframework!
// Extension1 depends on DaFramework (for exemple a multilanguage extension).
// Extension2 depends on DaFramework.
// Application is your application and depends on Extension1 and Extension2.
//
// Each element must be the root namespace of the extension.
// You can have a config.php file at the root path to configure your extension's features.
$_app_modules_map = array('Core',
						  'Internationalization',
				  		  'Application');

?>