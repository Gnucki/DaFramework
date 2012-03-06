<?php

/**
* The Exception class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Exception
 */
namespace DaFramework\Controller\Tools\Exception
{
	/**
	 * The Exception class represents an exception that can be thrown.
	 */
	class Exception extends \DaFramework\Controller\Tools\Extension\ExtendableObjectComponent implements IException
	{
		/*************************************/
		// CLASS PROPERTIES
		//


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		public function __construct(\Exception $exception)
		{
		}
	}
}

?>