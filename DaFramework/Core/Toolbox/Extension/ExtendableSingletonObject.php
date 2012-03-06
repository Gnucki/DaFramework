<?php

/**
 * The ExtendableObject abstract class page.
 * @package DaFramework
 * @subpackage Core_Toolbox_Extension
 */
namespace DaFramewor\kCore\Toolbox\Extension
{
	/**
	 * The ExtendableSingletonObject abstract class is the base class for singleton objects in the extension mechanism.
	 */
	abstract class ExtendableSingletonObject
	{
		/*************************************/
		// CLASS PROPERTIES
		//		
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