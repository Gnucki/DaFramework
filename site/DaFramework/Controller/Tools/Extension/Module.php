<?php

/**
 * The Module class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Extension
 */
namespace DaFramework\Controller\Tools\Extension
{
	/**
	 * The Module abstract class represents a module of the DaFramework
	 * and allows to build objects for the extension mechanism.
	 */
	abstract class Module extends \DaFramework\Controller\Tools\Extension\ExtendableObjectComponent implements IModule
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		 * The extension namespace name (public get/set).
		 * @var string
		 */
		protected $_namespaceName;
		
		/**
		 * Magic function which handles the get properties accessibility.
		 * @param string $propertyName The property name.
		 */
		public function __get($propertyName)
		{
			switch ($propertyName)
			{
				case '_namespaceName':
				case 'namespaceName':
					return $this->_namespaceName;
				default:
					return parent::$$propertyName;
			}
		}
		
		/**
		 * Magic function which handles the set properties accessibility.
		 * @param string $propertyName The property name.
		 */
		public function __set($propertyName, $propertyValue)
		{
			switch ($propertyName)
			{
				case '_namespaceName':
				case 'namespaceName':
					if (substr($propertyValue, 1) !== '\\')
						$propertyValue = '\\'.$propertyValue;
					if (substr($propertyValue, -1) !== '\\')
						$propertyValue .= '\\';
					$this->_namespaceName = $propertyValue;
					break;
				default:
					parent::$$propertyName = $propertyValue;
			}
		}
		
		
		/*************************************/
		// CLASS METHODS
		//
		/**
		 * Get an extendable object component.
		 * @param string $className The module relative class name.
		 */
		public function getExtendableObjectComponent($className, &$isSingleton, &$constructor)
		{
			$extendableObject = null;
			if (isFileExists($this->_namespaceName.$className))
			{
				$class = new \ReflectionClass($this->_namespaceName.$className);
				if ($class !== false && $class->implementsInterface('\\DaFramework\\Controller\\Tools\\Extension\\IExtendableObjectComponent'))
				{
					$isSingleton = false;
					$constructor = $class->getConstructor();
					if ($constructor !== null && $constructor->isPrivate())
						$isSingleton = true;
					// Cas d'une classe singleton.
					if ($isSingleton)
					{
						if ($class->hasMethod('getInstance'))
						{
							$method = $class->getMethod('getInstance');
							$extendableObject = $method->invoke(null);
						}
						else
							throw new \Exception('The ['.$className.'] singleton class must implement a getInstance() method which returns the unique instance of the class to use the extension mechanism.');
					}
					// Autres cas.
					else
						$extendableObject = $class->newInstance();
				}
			}
			return $extendableObject;
		}
	}
}

?>