<?php

/**
 * The ExtensionsHandler class page.
 * @package DaFramework
 * @subpackage Core_Toolbox_Extension
 */
namespace DaFramework\Core\Toolbox\Extension
{
	require_once __DIR__.'/Module.php';
	require_once __DIR__.'/Extension.php';
	require_once __DIR__.'/Framework.php';
	require_once __DIR__.'/ExtendableObject.php';
	require_once __DIR__.'/ExtendableSingletonObject.php';
	require_once __DIR__.'/ExtendedObject.php';
	require_once __DIR__.'/ExtendedSingletonObject.php';
	
	
	/**
	 * The ExtensionsHandler supports the extension mechanism which allows to 
	 * dynamically overload a class which uses this mechanism.
	 */
	class ExtensionsHandler// extends \Singleton
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		 * The unique instance of the class (singleton pattern).
		 * @var array
		 */
		private static $_instance = null;
		
		/**
		 * The unique instance of the class (singleton pattern).
		 * @var array
		 */
		private static $_framework = null;
		
		/**
		 * The unique instance of the class (singleton pattern).
		 * @var array
		 */
		private static $_extensions = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var array
		 */
		private static $_modules = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var array
		 */
	//	private $_extendableObjects = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var array
		 */
	//	private $_extendableSingletonObjects = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var array
		 */
	//	private $_extendableObjectPrototypes = array();
		
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var array
		 */
	//	private $_extendableObjectConstructors = array();

		/**
		 * The classes' prototypes to build instances.
		 * @var array
		 */
		private $_classesPropototypes = array();
		
		
		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/**
		 * Constructor.
		 */
		final private function __construct()
		{
			self::$_framework = Framework::getInstance();
			self::$_modules[0] = self::$_framework;
			$this->reloadClasses();
		}
		
		/** 
		 * Prevent to clone the unique instance.
		 */
		final private function __clone()
		{
		}
     
		/**
		 * Get the unique instance of the class (singleton pattern).
		 *@return \DaFramework\Controller\Tools\Extension\ExtensionsHandler The unique instance of the class.
		 */
		final public static function getInstance()
		{
			if (!isset(self::$_instance))
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
			if (isset(self::$_instance))
				$this->reloadClasses();
			else
				$extension = new Extension($extensionNamespaceName);
				
			$moduleNumber = count(self::$_modules) + 1;
			self::$_extensions[$moduleNumber] = $extension;
			self::$_modules[$moduleNumber] = &self::$_extensions[$moduleNumber];
			
			return $extension;
		}
		
		/**
		 * Load a class.
		 * @param string $fullClassName The full class name.
		 */
		public function loadClass($fullClassName)
		{
			$isClassAlreadyExisting = false;
			if (isset($this->_classesPropototypes[$fullClassName]))
				$isClassAlreadyExisting = true;
				
			// Load all modules' class' objects.
			$mainNamespaceEndPos = strpos($fullClassName, '\\', 1);
			$className = substr($fullClassName, $mainNamespaceEndPos);
			$isSingleton = false;
			$classModulesObjects = array();
			foreach (self::$_modules as $module)
			{
				$moduleReflectionClass = $module->loadClass($className);
				if (isset($moduleReflectionClass))
				{
					if ($moduleReflectionClass->isSubclassOf('\\DaFramework\\Core\\Toolbox\\Extension\\ExtendableObjectSingleton'))
						$isSingleton = true;
					$classModulesObjects[] = array('constructor' => $moduleReflectionClass->getConstructor(), 'instance' => $moduleReflectionClass->newInstance());
				}
			}
			$this->_classesPropototypes[$fullClassName] = $classModulesObjects;
			
			// Create the class dynamically.
			if (!$isClassAlreadyExisting)
			{
				$namespaceEndPos = strrpos($fullClassName, '\\');
				$className = substr($fullClassName, $namespaceEndPos + 1);
				$namespaceName = substr($fullClassName, 0, $namespaceEndPos);
				if ($isSingleton)
					eval('namespace '.$namespaceName.' { class '.$className.' extends \\DaFramework\\Core\\Toolbox\\Extension\\ExtendedSingletonObject {} }');
				else
					eval('namespace '.$namespaceName.' { class '.$className.' extends \\DaFramework\\Core\\Toolbox\\Extension\\ExtendedObject {} }');
			}
		}
		
		/**
		 * Reload all classes.
		 */
		public function reloadClasses()
		{
			foreach ($this->_classesPropototypes as $fullClassName => $classModuleObjects)
			{
				$this->loadClass($fullClassName);
			}
		}
		
		/**
		 * Get the class modules' objects of a class.
		 * @param string $fullClassName The full class name.
		 * @return array The class modules' objects.
		 */
		public function getClassModulesObjects($fullClassName)
		{
			$arguments = func_get_args();
			array_shift($arguments);
			
			$classModulesObjects = array();
			foreach ($this->_classesPropototypes[$fullClassName] as $classModuleObject)
			{
				// Clone the object prototype.
				$instance = clone $classModuleObject['instance'];
				
				// Execute the constructor if needed.
				$constructor = $classModuleObject['constructor'];
				if (isset($constructor))
				{
					if ($constructor->isPrivate())
						throw new \Exception('You cannot use a private constructor for the extendable object of class ['.$fullClassName.'].');
					if (empty($arguments))
						$constructor->invoke($instance);
					else
						$constructor->invokeArgs($instance, $arguments);
				}
				
				$classModulesObjects[] = $instance;
			}
			
			return $classModulesObjects;
		}
		
		/**
		 * Get an existing singleton or a new extendable object using the extension mechanism.
		 * @param string $className The module relative class name.
		 */
		/*public function getExtendableObject($className)
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
		}*/
		
		/**
		 * Get an extendable object component.
		 * @param string $className The module relative class name.
		 */
		/*private function _getExtendableObjectComponent($className, &$isSingleton, &$constructor)
		{
			$extendableObject = null;
			foreach (self::$_modules as $module)
			{
				$extendableObject = $module->getExtendableObjectComponent($className, $isSingleton, $constructor);
				if ($extendableObject !== null)
					break;
			}
			return $extendableObject;
		}*/
		
		/**
		 * Decorate an extendable object component (decorator pattern).
		 * @param \DaFramework\Controller\Tools\Extension\IExtendableObjectComponent $extendableObjectComponent The extendable object component.
		 */
		/*private function _decorateExtendableObject(IExtendableObjectComponent $extendableObject)
		{
			foreach (self::$_extensions as $extension)
			{
				$extendableObject = $extension->decorateExtendableObject($extendableObject);
			}
			return $extendableObject;
		}*/
		
		/**
		 * Decorate all extendable objects with an extension (decorator pattern).
		 * @param \DaFramework\Controller\Tools\Extension\IExtension $extension The extension used for decoration.
		 */
		/*private function _decorateExtendableObjectsWithExtension(IExtension $extension)
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
		}*/
	}
}

?>