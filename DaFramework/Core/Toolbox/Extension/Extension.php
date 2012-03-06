<?php

/**
 * The Extension class page.
 * @package DaFramework
 * @subpackage Toolbox_Extension
 */
namespace Toolbox\Extension
{
	/**
	 * The Extension class represents an extension of the DaFramework
	 * and allows to build objects for the extension mechanism.
	 */
	class Extension extends Module
	{
		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/**
		 * Constructor.
		 * @param string $namespaceName The root namespace name of the extension.
		 */
		public function __construct($namespaceName)
		{
			$this->__set('_namespaceName', $namespaceName);
		}
		
		
		/*************************************/
		// CLASS METHODS
		//			
		/**
		 * Decorate an extendable object component (decorator pattern).
		 * @param \DaFramework\Controller\Tools\Extension\IExtendableObjectComponent $extendableObject The extendable object component.
		 */
		public function decorateExtendableObject(IExtendableObjectComponent $extendableObject)
		{
			// Get the list of parent extendable classes.
			$class = new \ReflectionClass($extendableObject);
			$classesToExtend = array();
			$classesToExtend[] = $class;
			$parent = $class;
			while ($parent = $parent->getParentClass())
			{
				if ($parent->implementsInterface('\\DaFramework\\Controller\\Tools\\Extension\\IExtendableObjectComponent'))
					$classesToExtend[] = $parent;
				else
					break;
			}
			
			// Decorate the extendable object with its decorators and its parents decorators (begin with the "oldest" one and end with itself).
			for ($i = count($classesToExtend) - 1; $i >= 0; $i--)
			{
				$class = $classesToExtend[$i];
				// 12 is the length of "DaFramework\".
				$className = $this->_namespaceName.substr($class->getName(), 12);
				if (isFileExists($className))
				{
					$class = new \ReflectionClass($className);
					$extendableObject = $extendableObjectClass->newInstance($extandableObject);
				}
			}
			
			return $extendableObject;
		}
	}
}

?>