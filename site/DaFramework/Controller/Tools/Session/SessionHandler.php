<?php

namespace DaFramework\Controller\Tools\Session
{
	define ('_DF_NAVIGATEUR_IE', 'MSIE');
	define ('_DF_NAVIGATEUR_FIREFOX', 'Firefox');
	define ('_DF_NAVIGATEUR_OPERA', 'Opera');
	define ('_DF_NAVIGATEUR_CHROME', 'Chrome');
	define ('_DF_NAVIGATEUR_SAFARI', 'Safari');
	define ('_DF_NAVIGATEUR_AUTRE', 'Autre');


	/*************************************************************/
	/* Session handler class.
	/*************************************************************/
	class SessionHandler implements ISessionHandler
	{
		/*************************************/
		// CLASS FIELDS
		//
		private static $instance;
		private static $isSessionStarted;


		/*************************************/
		// CLASS PROPERTIES
		//
		public static function Instance()
		{
			if (self::$instance === null)
				self::$instance = new SessionHandler();
			return self::$instance;
		}


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		private function __construct()
		{
		}


		/*************************************/
		// CLASS METHODS
		//
		// Start the session.
		public function Start()
		{
			if ($this->isSessionStarted !== true)
			{
				session_start();
				$this->isSessionStarted = true;
				$this->Page($this->Post('_df_pageNumber'));
				if ($this->VariableValue('_df_init') !== 1)
					$this->Initialize();
				if ($this->PageVariableValue('_df_init') !== 1)
					$this->InitializePage();

				$this->Check();
			}
		}

		// End the session.
		public function End()
		{
		}

		// Initialize global session variables.
		public function Initialize()
		{
			$this->SetVariableValue(1, '_df_init');

			// Value to give to all forms (avoid CSRF).
			$this->SetVariableValue(mt_rand(), '_df_formKey');

			// Specific values for browser types.
			$httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
			if (stripos($httpUserAgent, _DF_NAVIGATEUR_IE) !== false)
			{
				$this->VariableValue(array('_df_browser', '_df_nom'), _DF_NAVIGATEUR_IE);
				$this->VariableValue(array('_df_browser', '_df_poidsJavascriptMax'), 100);
			}
			else if (stripos($httpUserAgent, _DF_NAVIGATEUR_FIREFOX) !== false)
			{
				$this->VariableValue(array('_df_browser', '_df_nom'), _DF_NAVIGATEUR_FIREFOX);
				$this->VariableValue(array('_df_browser', '_df_poidsJavascriptMax'), 250);
			}
			else if (stripos($httpUserAgent, _DF_NAVIGATEUR_OPERA) !== false)
			{
				$this->VariableValue(array('_df_browser', '_df_nom'), _DF_NAVIGATEUR_OPERA);
				$this->VariableValue(array('_df_browser', '_df_poidsJavascriptMax'), 250);
			}
			else if (stripos($httpUserAgent, _DF_NAVIGATEUR_CHROME) !== false)
			{
				$this->VariableValue(array('_df_browser', '_df_nom'), _DF_NAVIGATEUR_CHROME);
				$this->VariableValue(array('_df_browser', '_df_poidsJavascriptMax'), 500);
			}
			else if (stripos($httpUserAgent, _DF_NAVIGATEUR_SAFARI) !== false)
			{
				$this->VariableValue(array('_df_browser', '_df_nom'), _DF_NAVIGATEUR_SAFARI);
				$this->VariableValue(array('_df_browser', '_df_poidsJavascriptMax'), 500);
			}
			else
			{
				$this->VariableValue(array('_df_browser', '_df_nom'), _DF_NAVIGATEUR_AUTRE);
				$this->VariableValue(array('_df_browser', '_df_poidsJavascriptMax'), 100);
			}
		}

		// Initialize specific session variables for the browser page which sent the request.
		public function InitializePage()
		{
			$this->VariableValue('_df_init', 1);
		}

		public static function InitialiserOnRechargement()
		{
			if (self::$presentationChargee === false)
				self::RechargerPresentation();
		}

		public static function GetRechargeListe()
		{
			if (!self::$sRechargeListe)
				self::$sRechargeListe = new SRechargeListe();
			return self::$sRechargeListe;
		}

		public static function NumCheckFormulaire()
		{
			return self::GetValeur('checkFormulaire');
		}

		private static function CheckSession()
		{
			$timeCheckSession = self::LireSession('timeCheckSession');
			if ($timeCheckSession == NULL || (time() > ($timeCheckSession + 60)))
			{
				$dejaBuild = false;
				// Vérification de l'existence de la valeur de check de la session.
				if (!array_key_exists('checkSession', $_SESSION))
				{
					self::BuildCheckSession();
					$dejaBuild = true;
				}

				// Vérification si ce sont des entiers (c'est difficile d'écrire un entier dans un fichier alors qu'une chaîne de caractères..).
				if (!ctype_digit($_COOKIE['checkSession']) || !ctype_digit(self::LireSession('checkSession')))
					self::PurgeSession();
				// Comparaison de la valeur du cookie avec la valeur de la session.
				else if ($_COOKIE['checkSession'] != $_SESSION['checkSession'])
					self::PurgeSession();
				// Tout va bien!
				else if (!$dejaBuild)
					self::BuildCheckSession();

				// On réinitialise le temps de check de la session.
				self::EcrireSession('timeCheckSession', time());
			}
		}

		public static function PageNumber($page = NULL)
		{
			if ($page !== NULL)
			{
				self::$page = $page;
				if (self::GetValeurPage('ancienne') === NULL)
				{
					self::CopierPageActive();
					self::SetValeurPage('ancienne', 1);
				}
			}

			return self::$page;
		}

		private static function CopierPageActive()
		{
			if (array_key_exists('pageActive', $_COOKIE))
			{
				self::SetValeur(self::GetValeur('pages', $_COOKIE['pageActive']), 'pages', self::Page());
				setcookie('pageActive', self::Page(), 0, '/');
			}
		}

		private static function BuildCheckSession()
		{
			// Création d'une valeur aléatoire.
			$numCheck = mt_rand();
			// Stockage de cette valeur en session.
			self::EcrireSession('checkSession', $numCheck);
			// Stockage de cette valeur dans le cookie.
			setcookie('checkSession', $numCheck, 0, '/');
			$_COOKIE['checkSession'] = $numCheck;
			// On réinitialise le temps de check de la session.
			self::EcrireSession('timeCheckSession', time());
		}

		public static function PurgeSession()
		{
			$_SESSION = array();
			if (self::$startSession === 1)
			{
				setcookie('checkSession', '', time() - 3600, '/');
				setcookie(session_name(), '', time() - 3600, '/');
				session_destroy();
				self::$startSession = 0;
			}
		}

		public static function Referentiel($nom, $type, $liste = NULL)
		{
			if ($liste === NULL)
				return self::GetValeurPage('ref', $type, $nom);
			else
				self::SetValeurPage($liste, 'ref', $type, $nom);
		}

		public static function Contextes($valeur = NULL)
		{
			if ($valeur === NULL)
			{
				$contextes = self::GetValeurPage('contextes');
				if ($contextes === NULL)
					$contextes = array();
				return $contextes;
			}
			else
				self::SetValeurPage($valeur, 'contextes');
		}

		public static function LirePost($cle)
		{
			if (array_key_exists($cle, $_POST))
				return $_POST[$cle];

			return NULL;
		}

		public static function IsRequeteGet()
		{
			if (count($_GET) >= 1)
				return true;

			return false;
		}

		public static function LireGet($cle)
		{
			if (array_key_exists($cle, $_GET))
				return $_GET[$cle];

			return NULL;
		}

		// Get/set a global session variable.
		public function VariableValue($variableName, $value = UNDEFINED)
		{
			$sessionVariable = &$_SESSION;
			if ($value !== UNDEFINED)
			{
				if (is_array($variableName))
				{
					$variableNameSize = count($variableName);
					for ($i = 0; $i < $variableNameSize; $i++)
					{
						if ($i === ($variableNameSize - 1))
							$sessionVariable[$variableName[$i]] = $value;
						else
						{
							if (!array_key_exists($variableName[$i], $sessionVariable))
								$sessionVariable[$variableName[$i]] = array();
							$sessionVariable = &$sessionVariable[$variableName[$i]];
						}
					}
				}
				else
					$sessionVariable[$variableName] = $value;
				return $this;
			}
			else
			{
				$value = UNDEFINED;
				if (is_array($variableName))
				{
					$variableNameSize = count($variableName);
					for ($i = 0; $i < $variableNameSize; $i++)
					{
						if (is_array($sessionVariable) && array_key_exists($variableName[$i], $sessionVariable))
						{
							if ($i === ($variableNameSize - 1))
								$value = $sessionVariable[$variableName[$i]];
							else
								$sessionVariable = $sessionVariable[$variableName[$i]];
						}
					}
				}
				else if (is_array($sessionVariable) && array_key_exists($variableName, $sessionVariable))
					$value = $sessionVariable[$variableName];
				return $value;
			}
		}

		// Get/set a specific session variable for the browser page which sent the request.
		public function PageVariableValue($variableName, $value = UNDEFINED)
		{
			if (is_array($variableName))
				array_unshift($variableName, '_df_pages', $this->PageNumber());
			else
				$variableName = array('_df_pages', $this->PageNumber(), $variableName);
			return $this->VariableValue($variableName, $value);
		}

		public static function PoidsJavascript($increment = NULL)
		{
			if ($increment != NULL)
				self::$poidsJavascript += $increment;
			return self::$poidsJavascript;
		}

		public static function PoidsJavascriptMax()
		{
			return self::GetValeur('navigateur', 'poidsJavascriptMax');
		}
	}
}

?>