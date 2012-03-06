<?php

/**
 * The ExtendableObjectDecorator abstract class page.
 * @package DaFramework
 * @subpackage Core_Toolbox_Extension
 */
namespace DaFramework\Core\Toolbox\Extension
{
	/**
	 * The ExtendableObjectDecorator abstract class is the base class whom abstract decorator	 
	 * for extension classes shall inherit in the extension mechanism.
	 */
	abstract class ExtendableObjectDecorator extends ExtendableObject
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		 * The base extendable object (decorator pattern).
		 * @var IExtendableObject
		 */
		private $_baseExtendableObject = null;

		/**
		 * Magic function which handles the properties accessibility.
		 * @param string $propertyName The property name.
		 */
		public function __get($propertyName)
		{
			switch ($propertyName)
			{
				case '_baseExtendableObject':
					return $this->_baseExtendableObject;
				default:
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
					else
					{
						$baseClass = new \ReflectionClass($_baseExtendableObject);
						$method = $baseClass->getMethod('__get');
						return $method->invoke($this, $propertyName);
					}
					return null;
			}
		}
		
		
		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/**
		 * Constructor.
		 * @param \DaFramework\Controller\Tools\Extension\IExtendableObject $baseExtendableObject The base extendable object (decorator pattern).
		 */
		public function __construct(\DaFramework\Controller\Tools\Extension\IExtendableObject $baseExtendableObject)
		{
			$this->_baseExtendableObject = $baseExtendableObject;
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
				$method->setAccessible(true);
				return $method->invokeArgs($this, $arguments);
			}
			else
			{
				$baseClass = new \ReflectionClass($this->_baseExtendableObject);
				return $baseClass->getMethod($methodName)->invokeArgs($this->_baseExtendableObject, $arguments);
			}
		}
	}
}

?>