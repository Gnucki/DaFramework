<?php

/**
 * The TestResult class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Test
 */
namespace DaFramework\Controller\Tools\Test
{
	/**
	 * The TestResult class gives the result of a test.
	 */
	class TestResult implements ITestsHandler
	{
		//------------------------------------
		// CLASS PROPERTIES
		//
		/**
		* Get the name of the test.
		*/
		private Name;
		
		/**
		* Magic function which handles the properties accessibility.
		* @param string $propertyName The property name.
		*/
		public function __get($propertyName)
			switch ($propertyName)
			{
				case 'Name':
					return $this->Name;
					break;
				default:
					$reflectionClass = new ReflectionClass(get_class());
					if ($reflectionClass->hasProperty($propertyName))
					{
						return $reflectionClass->getProperty($propertyName)->getValue();
					}
					//else 
					// Exception..
			}
		}
		
		
		//------------------------------------
		// CLASS CONSTRUCTOR
		//
		
		
		//------------------------------------
		// CLASS METHODS
		//
	}
}

?>