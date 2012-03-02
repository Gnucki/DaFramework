<?php

/**
 * The Framework class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Extension
 */
namespace DaFramework\Controller\Tools\Extension
{
	/**
	 * The Framework class represents the DaFramework base module
	 * and allows to build objects for the extension mechanism.
	 */
	class Framework extends \DaFramework\Controller\Tools\Extension\Module implements IFramework
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\Framework
		 */
		private static $_instance = null;
		

		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/**
		 * Constructor.
		 */
		private function __construct()
		{
			$this->_namespaceName = '\\DaFramework\\';
		}
		
		/**
		 * Get the unique instance of the class (singleton pattern).
		 * @return \DaFramework\Controller\Tools\Extension\Framework The unique instance of the class.
		 */
		public static function getInstance()
		{
			if (self::$_instance === null)
				self::$_instance = new Framework();
			return self::$_instance;
		}
	}
}

?>