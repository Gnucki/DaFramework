<?php

/**
 * The Framework class page.
 * @package DaFramework
 * @subpackage Core_Toolbox_Extension
 */
namespace DaFramework\Core\Toolbox\Extension
{
	/**
	 * The Framework class represents the DaFramework base module
	 * and allows to build objects for the extension mechanism.
	 */
	class Framework extends Module
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
			$this->_namespaceName = '\\Core\\';
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