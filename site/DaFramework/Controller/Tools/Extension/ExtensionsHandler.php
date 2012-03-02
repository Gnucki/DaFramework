<?php

/**
 * The ExtensionsHandler class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Extension
 */
namespace DaFramework\Controller\Tools\Extension
{
	/**
	 * The ExtensionsHandler supports the extension mechanism which allows to 
	 * dynamically overload a class which uses this mechanism.
	 */
	class ExtensionsHandler
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private static $_instance = null;
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private static $_framework = null;
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private static $_extensions = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private static $_modules = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private $_extendableObjects = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private $_extendableSingletonObjects = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private $_extendableObjectPrototypes = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Extension\ExtensionsHandler
		 */
		private $_extendableObjectConstructors = array();


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/**
		 * Constructor.
		 */
		private function __construct()
		{
			self::$_framework = Framework::getInstance();
			self::$_modules[0] = self::$_framework;
			
			// Allow to use the extension mechanism with the IModule classes too.
			foreach (self::$_extensions as $extension)
			{
				$this->_decorateExtendableObjectsWithExtension($extension);
			}
		}
		
		/**
		 * Get the unique instance of the class (singleton pattern).
		 *@return \DaFramework\Controller\Tools\Extension\ExtensionsHandler The unique instance of the class.
		 */
		public static function getInstance()
		{
			if (self::$_instance === null)
				self::$_instance = new ExtensionsHandler();
			return self::$_instance;
		}


		/*************************************/
		// CLASS METHODS
		//
		/**
		 * Add an extension to the extension mechanism.
		 * @param string $extensionNamespaceName The extension namespace name.
		 */
		public static function addExtension($extensionNamespaceName)
		{
			$extension = null;
			// If instance already exists you add an extension dynamically, be careful!
			if (self::$_instance !== null)
				$extension = self::$_instance->getExtendableObject('Controller\\Tools\\Extension\\Extension');
			else
				$extension = new Extension($extensionNamespaceName);
				
			$moduleNumber = count(self::$_modules) + 1;
			self::$_extensions[$moduleNumber] = $extension;
			self::$_modules[$moduleNumber] = &self::$_extensions[$moduleNumber];
			
			return $extension;
		}
		
		/**
		 * Get an existing singleton or a new extendable object using the extension mechanism.
		 * @param string $className The module relative class name.
		 */
		public function getExtendableObject($className)
		{
			try
			{
				$arguments = func_get_args();
				array_shift($arguments);
				
				if (array_key_exists($className, $this->_extendableSingletonObjects))
					return $this->_extendableSingletonObjects[$className];
				else
				{
					if (!array_key_exists($className, $this->_extendableObjectPrototypes))
					{
						// Build the object prototype with the extension mechanism.
						$isSingleton = false;
						$extendableObject = $this->_getExtendableObjectComponent($className, $isSingleton, $this->_extendableObjectConstructors[$className]);
						if ($extendableObject !== null)
							$extendableObject = $this->_decorateExtendableObject($extendableObject);
						else
							throw new \Exception('The ['.$className.'] class does not exist.');

						$this->_extendableObjectPrototypes[$className] = &$extendableObject;
						if (array_key_exists($className, $this->_extendableObjects))
							$this->_extendableObjects[$className] = array();
						$this->_extendableObjects[$className][] = &$extendableObject;
					}
				
					// Clone the object prototype.
					$extendableObjectClone = clone $this->_extendableObjectPrototypes[$className];
					
					if (!$isSingleton)
					{
						// Call the constructor method with given arguments.
						$classConstructor = $this->_extendableObjectConstructors[$className];
						if ($classConstructor !== null)
						{
							if (empty($arguments))
								$classConstructor->invoke($extendableObjectClone);
							else
								$classConstructor->invokeArgs($extendableObjectClone, $arguments);
						}
					}
					$this->_extendableObjects[$className] = &$extendableObjectClone;
					
					return $extendableObjectClone;
				}
			}
			catch(\Exception $exception)
			{
				ExceptionHandler()->Log($exception);
				return null;
			}
		}
		
		/**
		 * Get an extendable object component.
		 * @param string $className The module relative class name.
		 */
		private function _getExtendableObjectComponent($className, &$isSingleton, &$constructor)
		{
			$extendableObject = null;
			foreach (self::$_modules as $module)
			{
				$extendableObject = $module->getExtendableObjectComponent($className, $isSingleton, $constructor);
				if ($extendableObject !== null)
					break;
			}
			return $extendableObject;
		}
		
		/**
		 * Decorate an extendable object component (decorator pattern).
		 * @param \DaFramework\Controller\Tools\Extension\IExtendableObjectComponent $extendableObjectComponent The extendable object component.
		 */
		private function _decorateExtendableObject(IExtendableObjectComponent $extendableObject)
		{
			foreach (self::$_extensions as $extension)
			{
				$extendableObject = $extension->decorateExtendableObject($extendableObject);
			}
			return $extendableObject;
		}
		
		/**
		 * Decorate all extendable objects with an extension (decorator pattern).
		 * @param \DaFramework\Controller\Tools\Extension\IExtension $extension The extension used for decoration.
		 */
		private function _decorateExtendableObjectsWithExtension(IExtension $extension)
		{
			// Extends the modules.
			foreach (self::$_modules as &$module)
			{
				$module = $extension->decorateExtendableObject($module);
			}
			
			// Extends all other objects.
			foreach ($this->_extendableObjects as &$extendableObject)
			{
				$extendableObject = $extension->decorateExtendableObject($extendableObject);
			}
		}
	}
}

?>