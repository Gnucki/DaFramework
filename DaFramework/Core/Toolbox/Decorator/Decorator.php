<?php

/**
* The Decorator class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Decorator
 */
namespace DaFramework\Controller\Tools\Decorator
{
	/**
	 * The Decorator class allows to build the interface and the extension file from 
	 * one class which shall use the extension mechanism.
	 */
	class Decorator implements IDecorator
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		* The unique instance of the class (singleton pattern) (public get).
		* @var Decorator
		*/
		private static $_instance = null;
		
		/**
		* Magic function which handles the static get properties accessibility.
		* @param string $propertyName The property name.
		*/
		public static function __getStatic($propertyName)
		{
			switch ($propertyName)
			{
				case 'instance':
					if (self::$_instance === null)
						self::$_instance = new Decorator();
					return self::$_instance;
			}
		}


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/**
		* Constructor.
		*/
		private function __construct()
		{
		}


		/*************************************/
		// CLASS METHODS
		//
		/**
		* Build the extension mechanism interface and extension file for the class.
		* @param string $className The class name (with namespace name).
		*/
		public function	buildForClass($className)
		{
			if (file_exists(ClassNameToFileName($className)))
			{
				echo 'FICHIER TROUVE';
			}
			else
				echo 'FICHIER NON TROUVE';
		}
	}
}

?>