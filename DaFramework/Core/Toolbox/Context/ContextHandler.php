<?php

/**
* The Decorator class page.
 * @package DaFramework
 * @subpackage Controller_Tools_Context
 */
namespace DaFramework\Controller\Tools\Context
{
	/**
	 * The class ContextHandler allows to handle the global and the page context (variable values).
	 */
	class ContextHandler extends \DaFramework\Controller\Tools\Extension\ExtendableObjectComponent implements IContextHandler
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		* The unique instance of the class (singleton pattern) (public get).
		* @var \DaFramework\Controller\Tools\Context\ContextHandler
		*/
		private static $_instance = null;
		
		/**
		* Magic function which handles the properties accessibility.
		* @param string $propertyName The property name.
		*/
		public function __get($propertyName)
		{
			switch ($propertyName)
			{
				default:
					$value = null;
					// Get - Post - Cookie.
					if (array_key_exists($propertyName, $_GET))
						$value = $_GET[$propertyName];
					else if (array_key_exists($propertyName, $_POST))
						$value = $_POST[$propertyName];
					else if (array_key_exists($propertyName, $_COOKIE))
						$value = $_COOKIE[$propertyName];
					// Case of an array.
					if (is_array($value))
					{
						array_walk_recursive($value, array($this, 'cleanValue'));
						return $value;
					}
					// Else.
					return $this->cleanValue($value);
			}
		}


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/**
		* Constructor.
		*/
		private function __construct()
		{
		}

		/**
		* Get the unique instance of the class (singleton pattern).
		* @return \DaFramework\Controller\Tools\Context\ContextHandler The unique instance of the class.
		*/
		public static function getInstance()
		{
			if (self::$_instance === null)
				self::$_instance = new ContextHandler();
			return self::$_instance;
		}


		/*************************************/
		// CLASS METHODS
		//
		/**
		* Clean a variable value.
		* @param mixed $value The variable value.
		*/		
		public function cleanValue($value)
		{
			if ($value !== null)
			{
				if (is_string($value))
					$value = $this->convertToCurrentEncoding($value);
				if (get_magic_quotes_gpc())
					$value = stripslashes($value);
			}
			return $value;
		}
		
		/**
		* Convert a string to the current encoding.
		* @param string $string The string to convert.
		*/
		public function convertToCurrentEncoding($string)
		{
			$convertedString = $string;
			mb_convert_variables(_APP_ENCODING, mb_detect_encoding($string.'a', 'UTF-8, ISO-8859-1, EUC-JP, SJIS, GBK, ISO-8859-15, ASCII, JIS'), $convertedString);
			return $convertedString;
		}

		/**
		* Convert a string to a HTML string.
		* @param string $string The string to convert.
		*/
		public function convertToHtml($string)
		{
			$convertedString = htmlspecialchars($this->convertToCurrentEncoding($string), ENT_NOQUOTES, _APP_ENCODING);
			return htmlspecialchars($convertedString, ENT_NOQUOTES, _APP_ENCODING);
		}

		/**
		* Convert a string to a javascript string.
		* @param string $string The string to convert.
		*/
		function convertToJavascript($string)
		{
			return htmlspecialchars($this->convertToCurrentEncoding($string), ENT_NOQUOTES, _APP_ENCODING);
		}
	}
}

?>