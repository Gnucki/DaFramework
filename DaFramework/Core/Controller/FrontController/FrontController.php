<?php

/**
* The FrontController class page.
 * @package DaFramework
 * @subpackage Controller_FrontController
 */
namespace DaFramework\Controller\FrontController
{
	/**
	 * The Front controller class is the unique entry point for request processing
	 * (front controller pattern).
	 */
	class FrontController extends \DaFramework\Controller\Tools\Extension\ExtendableObjectComponent implements IFrontController
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		/**
		 * The unique instance of the class (singleton pattern) (public get).
		 * @var \DaFramework\Controller\FrontController\FrontController The unique instance of the class.
		 */
		private static $_instance = null;


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
		 * @return \DaFramework\Controller\FrontController\FrontController The unique instance of the class.
		 */
		public static function getInstance()
		{
			if (self::$_instance === null)
				self::$_instance = new FrontController();
			return self::$_instance;
		}
		

		/*************************************/
		// CLASS METHODS
		//
		/**
		 * Unique entry point for request processing (front controller pattern).
		 */
		public function ProcessRequest()
		{
			switch (\Controller::getContextHandler()->df_r)
			{
				case 'df_decorator':
					echo '<?xml version="1.0" encoding="'._APP_ENCODING.'"?>';
					echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n\n";
					echo '<html><body>DECORATOR<br/>';
					ExtensionsHandler()->ExtendableObject('\DaFramework\Controller\Tools\Decorator\Decorator')->buildForClass('\DaFramework\Controller\Tools\Context\ContextHandler');
					echo '</body></html>';
					break;
				case 'df_test':
					echo '<?xml version="1.0" encoding="'._APP_ENCODING.'"?>';
					echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n\n";
					echo '<html><body>TEST';

					echo '</body></html>';
					break;
				default:
					echo '<?xml version="1.0" encoding="'._APP_ENCODING.'"?>';
					echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n\n";
					echo '<html><body>';
					
					echo '_';
					//SessionHandler()->Langue();
					//SessionHandler()->VariableValue('test', '7');
					//echo SessionHandler()->VariableValue('test');
					/*$tab = Locator()->LanguageTimeZones();
					echo $tab['sv'][0];
					echo '_';
					Locator()->Bip();
					Locator()->Bop();
					echo '_';
					ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\SqlRequest')->Select('t1', array('id', 'taille', 'nom'))->Execute();
					echo '_';*/

					echo '</body></html>';
			}
		}
	}
}

?>