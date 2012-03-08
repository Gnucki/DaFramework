<?php

/**
 * The ExtendedSingletonObject abstract class page.
 * @package DaFramework
 * @subpackage Core_Toolbox_Extension
 */
namespace DaFramework\Core\Toolbox\Extension
{
	/**
	 * The ExtendedSingletonObject abstract class allow to create extended singleton object.
	 */
	abstract class ExtendedSingletonObject
	{
		/*************************************/
		// CLASS PROPERTIES
		//	
		/**
		 * Store an instance of the singleton classes. 
		 */
		private static $_instances = array();
		
		/**
		 * Magic function which handles the get properties accessibility.
		 * @param string $propertyName The property name.
		 */
		public function __get($propertyName)
		{
			$class = new \ReflectionClass($this);
			if ($class->hasProperty($propertyName))
			{
				$property = $class->getProperty($propertyName);
				$property->setAccessible(true);
				return $property->getValue($this);
			}
			else if ($class->hasProperty('_'.$propertyName))
			{
				$property = $class->getProperty('_'.$propertyName);
				$property->setAccessible(true);
				return $property->getValue($this);
			}
			// EXCEPTION!!
			return null;
		}

		
		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/*************************************/
		/**
		 * Constructor.
		 */
		final private function __construct()
		{
		}
		
		/** 
		 * Prevent to clone the unique instance.
		 */
		final private function __clone()
		{
		}
     
		/**
		 * Get the unique instance of the class (singleton pattern).
		 * @return __CLASS__ The unique instance of the class.
		 */
		final public static function getInstance()
		{
			$calledClass = get_called_class(); 
			if(!isset(self::$_instances[$calledClass])) 
				self::$_instances[$calledClass] = new $calledClass(); 
			return self::$_instances[$calledClass];
		}

		
		/*************************************/
		// CLASS METHODS
		//
		/**
		 * Magic function which handles dynamic functions calls.
		 * @param string $methodName The method name.
		 * @param array $arguments The arguments table.
		 */
		public function __call($methodName, $arguments)
		{
			$class = new \ReflectionClass($this);
			if ($class->hasMethod($methodName))
			{
				$method = $class->getMethod($methodName);
				//$method->setAccessible(true);
				return $method->invokeArgs($this, $arguments);
			}
			// EXCEPTION!!
			return null;
		}
	}
}

?>