<?php

/**
 * The ExceptionHandler class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Exception
 */
namespace DaFramework\Controller\Tools\Exception
{
	/**
	 * The ExceptionHandler class allows to process thrown exceptions.
	 */
	class ExceptionHandler extends \DaFramework\Controller\Tools\Extension\ExtendableObjectComponent implements IExceptionHandler
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		 * The unique instance of the class (singleton pattern) .
		 * @var \DaFramework\Controller\Tools\Exception\ExceptionHandler
		 */
		private static $_instance = null;


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		private function __construct()
		{
		}

		/**
		 * Get the unique instance of the class (singleton pattern).
		 * @return \DaFramework\Controller\Tools\Exception\ExceptionHandler The unique instance of the class.
		 */
		public static function getInstance()
		{
			if (self::$_instance === null)
				self::$_instance = new ExceptionHandler();
			return self::$_instance;
		}

		
		/*************************************/
		// CLASS METHODS
		//
		/** 
		 * Process an exception.
		 * @param \DaFramework\Controller\Tools\Exception\IException $exception The exception to process.
		 */
		public function processException(IException $exception)
		{
			error_log($exception->getMessage(), 0);
		}
	}
}

?>