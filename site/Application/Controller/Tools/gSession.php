<?php

require_once 'cst.php';
require_once INC_GCONTEXTE;
require_once INC_CSTBASE;
require_once INC_CSTLIBELLES;
require_once INC_GREFERENTIEL;
require_once INC_GDROIT;
require_once INC_GTEXTE;
require_once PATH_METIER.'mListeLibellesLibres.php';
require_once PATH_METIER.'mListeLibellesTextesLibres.php';


define ('NAVIGATEUR_IE', 'MSIE');
define ('NAVIGATEUR_FIREFOX', 'Firefox');
define ('NAVIGATEUR_OPERA', 'Opera');
define ('NAVIGATEUR_CHROME', 'Chrome');
define ('NAVIGATEUR_SAFARI', 'Safari');
define ('NAVIGATEUR_AUTRE', 'Autre');


class GSession
{
	private static $startSession;
	private static $listeLib;
	private static $listeLibText;
	private static $listeLibMem;
	private static $libCharges;
	private static $poidsJavascript;
	private static $presentationChargee;
	private static $page;

	public static function Demarrer()
	{
		if (self::$startSession !== 1)
		{
			session_start();
			header('Content-Type: text/xml; charset=utf-8');
			self::$startSession = 1;

			self::Page(self::LirePost('idPage'));

			if (self::GetValeur('initialisee') !== 1)
				self::Initialiser();
			if (self::GetValeurPage('initialisee') !== 1)
				self::InitialiserPage();

			self::$poidsJavascript = 0;
			self::$listeLib = new MListeLibellesLibres();
			self::$listeLibText = new MListeLibellesTextesLibres();
			self::$listeLibMem = self::LireSession('libellesMemorises');
			if (self::$listeLibMem === NULL)
				self::$listeLibMem = array();
			self::$libCharges = false;
			self::$presentationChargee = false;

			self::CheckSession();

			GDroit::Charger();
			GContexte::Charger();
			GReferentiel::Initialiser();
		}
	}

	public static function Terminer()
	{
		if (self::$startSession === 1)
		{
		   	GReferentiel::Sauvegarder();
		   	GContexte::Sauvegarder();
		   	self::EcrireSession('libellesMemorises', self::$listeLibMem);
		}
	}

	public static function TraiterLibelles()
	{
		if (self::$startSession === 1)
		{
			self::ChargerLibelles();
		}
	}

	public static function Initialiser()
	{
		self::SetValeur(1, 'initialisee');

		// Création d'une valeur aléatoire.
	    $numCheck = mt_rand();
	    // Stockage de cette valeur en session qui devra être passée à tout formulaire.
	    self::SetValeur($numCheck, 'checkFormulaire');

	   	// Valeurs spécifiques au navigateur utilisé.
	    $httpUserAgent = $_SERVER["HTTP_USER_AGENT"];
		if (stripos($httpUserAgent, NAVIGATEUR_IE) !== false)
		{
		    self::SetValeur(NAVIGATEUR_IE, 'navigateur', 'nom');
		    self::SetValeur(100, 'navigateur', 'poidsJavascriptMax');
		}
		else if (stripos($httpUserAgent, NAVIGATEUR_FIREFOX) !== false)
		{
		    self::SetValeur(NAVIGATEUR_FIREFOX, 'navigateur', 'nom');
		    self::SetValeur(250, 'navigateur', 'poidsJavascriptMax');
		}
		else if (stripos($httpUserAgent, NAVIGATEUR_OPERA) !== false)
		{
		    self::SetValeur(NAVIGATEUR_OPERA, 'navigateur', 'nom');
		    self::SetValeur(250, 'navigateur', 'poidsJavascriptMax');
		}
		else if (stripos($httpUserAgent, NAVIGATEUR_CHROME) !== false)
		{
		    self::SetValeur(NAVIGATEUR_CHROME, 'navigateur', 'nom');
		    self::SetValeur(500, 'navigateur', 'poidsJavascriptMax');
		}
		else if (stripos($httpUserAgent, NAVIGATEUR_SAFARI) !== false)
		{
		    self::SetValeur(NAVIGATEUR_SAFARI, 'navigateur', 'nom');
		    self::SetValeur(500, 'navigateur', 'poidsJavascriptMax');
		}
		else
		{
		    self::SetValeur(NAVIGATEUR_AUTRE, 'navigateur', 'nom');
		    self::SetValeur(100, 'navigateur', 'poidsJavascriptMax');
		}
	}

	public static function InitialiserPage()
	{
		self::SetValeurPage(1, 'initialisee');

		self::Langue(COL_ID);
		$communauteId = self::Communaute(COL_ID);

		require_once PATH_METIER.'mGroupe.php';

		$mGroupe = new MGroupe();
		$mGroupe->AjouterColSelection(COL_ID);
		$mGroupe->AjouterColSelection(COL_NOM);
		$mGroupe->AjouterColSelection(COL_DESCRIPTION);
		$mGroupe->AjouterColCondition(COL_TYPEGROUPE, TYPEGROUPE_COMMUNAUTE);
		$mGroupe->AjouterColCondition(COL_COMMUNAUTE, $communauteId);
		$mGroupe->Charger();

		GSession::Groupe(COL_ID, $mGroupe->Id(), true);
		GSession::Groupe(COL_NOM, $mGroupe->Nom(), true);
		GSession::Groupe(COL_DESCRIPTION, $mGroupe->Description(), true);
		GSession::Groupe(COL_TYPEGROUPE, TYPEGROUPE_COMMUNAUTE, true);
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

	public static function GetDroits(&$droitsGroupes, &$droitsCommunautesJeux, &$droitsJeux, &$droitsCommunautes, &$droitsGlobaux)
	{
	   	$droits = self::GetValeur('droits');

	   	if ($droits !== NULL)
		{
	   	   	$droitsGroupes = $droits['Gr'];
		   	$droitsCommunautesJeux = $droits['CJ'];
		   	$droitsJeux = $droits['J'];
		   	$droitsCommunautes = $droits['C'];
		   	$droitsGlobaux = $droits['Gl'];
		   	return true;
		}

		return false;
	}

	public static function SetDroits($droitsGroupes, $droitsCommunautesJeux, $droitsJeux, $droitsCommunautes, $droitsGlobaux)
	{
	   	$droits = array();
	   	$droits['Gr'] = $droitsGroupes;
	   	$droits['CJ'] = $droitsCommunautesJeux;
	   	$droits['J'] = $droitsJeux;
	   	$droits['C'] = $droitsCommunautes;
	   	$droits['Gl'] = $droitsGlobaux;

		self::SetValeur($droits, 'droits');
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

	public static function Page($page = NULL)
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

	private static function ChargerLibelles()
	{
		if (self::$libCharges === false)
		{
			self::$libCharges = true;
			if (self::$listeLib->GetNbElements() > 0)
			{
				self::$listeLib->AjouterColSelection(COL_ID);
				self::$listeLib->AjouterColSelection(COL_LIBELLE);
				self::$listeLib->AjouterFiltreEgal(COL_LANGUE, GSession::Langue(COL_ID));
				self::$listeLib->EstListeId(true);
				self::$listeLib->Charger();
			}
		}
		else
			GLog::LeverException(EXG_0060, 'GSession::ChargerLibelles, les libellés ont déjà été chargés.');
	}

	public static function Libelle($id, $memoriser = false, $chargementImmediat = false)
	{
	   	if (array_key_exists($id, self::$listeLibMem))
				return self::$listeLibMem[$id];

		$libelle = '';
		if ($memoriser === true || $chargementImmediat === true)
		{
		   	// Si l'id est supérieur à 20000 alors on à un libellé texte, sinon c'est un libellé normal à 255 caractères.
		   	if (intval($id) >= 200000)
		   	{
				$mLibelleTexteLibre = new MLibelleTexteLibre($id);
				$mLibelleTexteLibre->Langue(GSession::Langue(COL_ID));
				$mLibelleTexteLibre->Charger();
				$libelle = $mLibelleTexteLibre->Libelle();
			}
			else
			{
			   	$mLibelleLibre = new MLibelleLibre($id);
			   	$mLibelleLibre->Langue(GSession::Langue(COL_ID));
				$mLibelleLibre->Charger();
				$libelle = $mLibelleLibre->Libelle();
			}

			if ($memoriser === true)
			   	self::$listeLibMem[$id] = $libelle;

			return $libelle;
		}

		if (self::$libCharges === false)
		{
		   	// Si l'id est supérieur à 20000 alors on à un libellé texte, sinon c'est un libellé normal à 255 caractères.
		   	if (intval($id) >= 200000)
		   	   	self::$listeLibText->AjouterElementAvecId($id);
			else
			   	self::$listeLib->AjouterElementAvecId($id);
			return intval($id);
		}
		else
		{
		   	// Si l'id est supérieur à 20000 alors on à un libellé texte, sinon c'est un libellé normal à 255 caractères.
		   	if (intval($id) >= 200000)
			{
		   		$mLibelleTexteLibre = self::$listeLibText->GetElementById($id);
				if ($mLibelleTexteLibre !== NULL)
					return $mLibelleTexteLibre->Libelle();
		   	}
			else
			{
			  	$mLibelleLibre = self::$listeLib->GetElementById($id);
				if ($mLibelleLibre !== NULL)
					return $mLibelleLibre->Libelle();
			}

			GLog::LeverException(EXG_0061, 'GSession::Libelle, le libellé n\'a pas été chargé pour l\'id ['.$id.'].');
			return '';
		}
	}

	public static function Connecte($connecte = NULL)
	{
	   	if ($connecte === true)
	   		GSession::SetValeurPage(true, 'connecte');
	   	else if ($connecte !== NULL)
	   		GSession::SetValeurPage(false, 'connecte');
	   	return GSession::GetValeurPage('connecte');
	}

	public static function Langue($cle = NULL, $valeur = NULL)
	{
	   	$set = true;

	   	if ($valeur === NULL)
	   	{
		   	$valeur = self::GetValeurPage('langue', $cle);
		   	$set = false;
		}

		if ($cle === COL_ID && $valeur === NULL)
		{
		   	require_once INC_GLOCALISATION;
			$valeur = GLocalisation::Langue();
			$set = true;
		}
		else if ($cle === NULL && $valeur === NULL)
		{
		   	require_once INC_GLOCALISATION;
			$valeur = array();
			$valeur[COL_ID] = GLocalisation::Langue();
			$set = true;
		}

		if ($valeur !== NULL && $set === true)
			self::SetValeurPage($valeur, 'langue', $cle);

		// Sinon, on a un bug sur Chrome et Safari. Pourquoi??
		$retour = $valeur;
		return $retour;
	}

	public static function Communaute($cle = NULL, $valeur = NULL)
	{
	   	$set = true;

	   	if ($valeur === NULL)
	   	{
		   	$valeur = self::GetValeurPage('communaute', $cle);
		   	$set = false;
		}

		if ($cle === COL_ID && $valeur === NULL)
		{
		   	require_once INC_GLOCALISATION;
			$langueId = self::Langue(COL_ID);
			$valeur = GLocalisation::Communaute($langueId);
			$set = true;
		}
		else if ($cle === NULL && $valeur === NULL)
		{
		   	require_once INC_GLOCALISATION;
			$valeur = array();
			$langueId = self::Langue(COL_ID);
			$valeur[COL_ID] = GLocalisation::Communaute($langueId);
			$set = true;
		}

		if ($valeur !== NULL && $set === true)
			self::SetValeurPage($valeur, 'communaute', $cle);

		// Sinon, on a un bug sur Chrome et Safari. Pourquoi??
		$retour = $valeur;
		return $retour;
	}

	public static function Joueur($cle = NULL, $valeur = NULL, $forcerModif = false)
	{
	   	if ($valeur === NULL && $forcerModif === false)
		   	return self::GetValeur('joueur', $cle);
		else
			self::SetValeur($valeur, 'joueur', $cle);
	}

	public static function Groupe($cle = NULL, $valeur = NULL, $forcerModif = false)
	{
	   	if ($valeur === NULL && $forcerModif === false)
		   	return self::GetValeurPage('groupe', $cle);
		else
		{
			self::SetValeurPage($valeur, 'groupe', $cle);
			// Si on modifie le groupe auquel on est connecté.
			if ($cle === COL_ID)
			{
			   	if ($valeur == NULL)
				{
			   		self::PresentationActive(NULL, true);
					self::PresentationModif(NULL, true);
			   	}
			   	else
			   	{
			   	   	require_once PATH_METIER.'mPresentation.php';
					require_once PATH_METIER.'mGroupe.php';
					require_once PATH_METIER.'mPresentationGroupe.php';

				   	// On change la présentation active et la présentation modifiée.
				   	$mPresentationGroupe = new MPresentationGroupe();
				   	$mPresentationGroupe->AjouterColSelection(COL_PRESENTATION);
				   	$mPresentationGroupe->Groupe($valeur);
				   	$mPresentationGroupe->Charger(false, false, false, false);
					self::PresentationActive($mPresentationGroupe->Presentation()->Id(), true);
					self::PresentationModif($mPresentationGroupe->Presentation()->Id(), true);
				}
			}
		}
	}

	public static function Jeu($cle = NULL, $valeur = NULL, $forcerModif = false)
	{
	   	if ($valeur === NULL && $forcerModif === false)
		   	return self::GetValeurPage('jeu', $cle);
		else
			self::SetValeurPage($valeur, 'jeu', $cle);
	}

	public static function PresentationActive($valeur = NULL, $forcerModif = false)
	{
	   	if ($valeur === NULL && $forcerModif === false)
		   	return self::GetValeurPage('presentation', 'active');
		else
		{
		   	$ancienneValeur = self::GetValeurPage('presentation', 'active');

		  	if ($ancienneValeur !== $valeur)
			{
		  		self::SetValeurPage($valeur, 'presentation', 'active');
		  		self::RechargerPresentation();
			}
		}
	}

	public static function RechargerPresentation()
	{
	   	require_once INC_GCSS;
	   	require_once INC_GJS;
		require_once PATH_METIER.'mListePresentationsModules.php';
		require_once PATH_METIER.'mListeTypesPresentationsModules.php';

		$valeur = self::GetValeurPage('presentation', 'active');
		self::$presentationChargee = true;

		// Chargement de la présentation par défaut.
		if ($valeur == NULL)
		{
			$mListeTypesPresentationsModules = new mListeTypesPresentationsModules();
			$mListeTypesPresentationsModules->AjouterColSelection(COL_ID);
			$mListeTypesPresentationsModules->AjouterColSelection(COL_NOMFICHIER);
			$mListeTypesPresentationsModules->AjouterFiltreEgal(COL_ACTIF, true);
			$mListeTypesPresentationsModules->Charger();

			foreach($mListeTypesPresentationsModules->GetListe() as $mTypePresentationModule)
			{
				GReponse::AjouterElementCSS($mTypePresentationModule->Id(), PATH_SERVER_HTTP.GCss::GetCheminFichierBase().$mTypePresentationModule->NomFichier().'.css');
				GReponse::AjouterElementJS($mTypePresentationModule->Id(), PATH_SERVER_HTTP.GJs::GetCheminFichierBase().$mTypePresentationModule->NomFichier().'.js');
			}
		}
		// Chargement de la présentation spécifique au groupe.
		else
		{
			$mListePresentationsModules = new mListePresentationsModules();
			$mListePresentationsModules->AjouterColSelection(COL_RESSOURCECSS);
			$mListePresentationsModules->AjouterColSelection(COL_RESSOURCEJS);
			$mListePresentationsModules->AjouterFiltreEgal(COL_PRESENTATION, $valeur);
			$numJointure = $mListePresentationsModules->AjouterJointure(COL_TYPEPRESENTATIONMODULE, COL_ID, 0, SQL_RIGHT_JOIN);
			$mListePresentationsModules->AjouterColSelectionPourJointure($numJointure, COL_ID);
			$mListePresentationsModules->AjouterFiltreEgalPourJointure($numJointure, COL_ACTIF, true);
			$mListePresentationsModules->Charger();

			foreach($mListePresentationsModules->GetListe() as $mPresentationModule)
			{
			   	if ($mPresentationModule->RessourceCSS() != NULL)
				   	GReponse::AjouterElementCSS($mPresentationModule->TypePresentationModule()->Id(), PATH_SERVER_HTTP.$mPresentationModule->RessourceCSS());
				else
				   	GReponse::AjouterElementCSS($mPresentationModule->TypePresentationModule()->Id(), '');

				if ($mPresentationModule->RessourceJS() != NULL)
				   	GReponse::AjouterElementJS($mPresentationModule->TypePresentationModule()->Id(), PATH_SERVER_HTTP.$mPresentationModule->RessourceJS());
				else
				   	GReponse::AjouterElementJS($mPresentationModule->TypePresentationModule()->Id(), '');
			}
		}
	}

	public static function PresentationModif($valeur = NULL, $forcerModif = false)
	{
	   	if ($valeur === NULL && $forcerModif === false)
		   	return self::GetValeurPage('presentation', 'modif');
		else
			self::SetValeurPage($valeur, 'presentation', 'modif');
	}

	public static function PresentationModule($module = NULL, $presentation = NULL, $forcerModif = false)
	{
	   	if ($presentation === NULL && $forcerModif === false)
		   	return self::GetValeurPage('presentation', 'module', $module);
		else
			self::SetValeurPage($presentation, 'presentation', 'module', $module);
	}

	public static function Referentiel($nom, $type, $liste = NULL)
	{
	   	if ($liste === NULL)
	   		return self::GetValeurPage('ref', $type, $nom);
	   	else
	   	   	self::SetValeurPage($liste, 'ref', $type, $nom);
	}

	public static function MenuCharge($id)
	{
	   	$retour = self::GetValeurPage('menus', $id);
	   	if ($retour !== 1)
		   return false;
		return true;
	}

	public static function AjouterMenu($id)
	{
	   	self::SetValeurPage(1, 'menus', $id);
	}

	public static function SupprimerMenu($id)
	{
	   	self::SetValeurPage(0, 'menus', $id);
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

	public static function LireSession($cle)
	{
		self::Demarrer();

		if (array_key_exists($cle, $_SESSION))
			return $_SESSION[$cle];

		return self::GetValeurParDefaut($cle);
	}

	public static function EcrireSession($cle, $valeur)
	{
		self::Demarrer();

		if ($valeur == NULL)
			unset($_SESSION[$cle]);
		else
			$_SESSION[$cle] = $valeur;
	}

	private static function SetValeur($valeur, $cle1, $cle2 = NULL, $cle3 = NULL, $cle4 = NULL, $cle5 = NULL, $cle6 = NULL, $cle7 = NULL)
	{
	   	if ($cle1 !== NULL)
	   	{
	   	   	if ($cle2 === NULL)
	   	   	{
		   	   	$_SESSION[$cle1] = $valeur;
		   	   	return;
		   	}
	   	   	else if (!array_key_exists($cle1, $_SESSION) || !is_array($_SESSION[$cle1]))
	   	   		$_SESSION[$cle1] = array();

			if ($cle3 === NULL)
	   	   	{
		   	   	$_SESSION[$cle1][$cle2] = $valeur;
		   	   	return;
		   	}
	   	   	else if (!array_key_exists($cle2, $_SESSION[$cle1]) || !is_array($_SESSION[$cle1][$cle2]))
	   	   		$_SESSION[$cle1][$cle2] = array();

	   	   	if ($cle4 === NULL)
	   	   	{
		   	   	$_SESSION[$cle1][$cle2][$cle3] = $valeur;
		   	   	return;
		   	}
	   	   	else if (!array_key_exists($cle3, $_SESSION[$cle1][$cle2]) || !is_array($_SESSION[$cle1][$cle2][$cle3]))
	   	   		$_SESSION[$cle1][$cle2][$cle3] = array();

	   		if ($cle5 === NULL)
	   	   	{
		   	   	$_SESSION[$cle1][$cle2][$cle3][$cle4] = $valeur;
		   	   	return;
		   	}
	   	   	else if (!array_key_exists($cle4, $_SESSION[$cle1][$cle2][$cle3]) || !is_array($_SESSION[$cle1][$cle2][$cle3][$cle4]))
	   	   		$_SESSION[$cle1][$cle2][$cle3][$cle4] = array();

	   	   	if ($cle6 === NULL)
	   	   	{
		   	   	$_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5] = $valeur;
		   	   	return;
		   	}
	   	   	else if (!array_key_exists($cle5, $_SESSION[$cle1][$cle2][$cle3][$cle4]) || !is_array($_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5]))
	   	   		$_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5] = array();

	   	   	if ($cle7 === NULL)
	   	   	{
		   	   	$_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6] = $valeur;
		   	   	return;
		   	}
	   	   	else if (!array_key_exists($cle6, $_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5]) || !is_array($_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6]))
	   	   		$_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6] = array();

	   	   	$_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6][$cle7] = $valeur;
		}
		else
		   	GLog::LeverException(EXG_0062, 'GSession::SetValeur, la première clé est nulle.');
	}

	private static function SetValeurPage($valeur, $cle1, $cle2 = NULL, $cle3 = NULL, $cle4 = NULL, $cle5 = NULL)
	{
	   	self::SetValeur($valeur, 'pages', self::Page(), $cle1, $cle2, $cle3, $cle4, $cle5);
	}

	private static function GetValeur($cle1, $cle2 = NULL, $cle3 = NULL, $cle4 = NULL, $cle5 = NULL, $cle6 = NULL, $cle7 = NULL)
	{
	   	$valeur = NULL;

	   	if (array_key_exists($cle1, $_SESSION))
	   	{
		   	if ($cle2 !== NULL && is_array($_SESSION[$cle1]) && array_key_exists($cle2, $_SESSION[$cle1]))
			{
		   	   	if ($cle3 !== NULL && is_array($_SESSION[$cle1][$cle2]) && array_key_exists($cle3, $_SESSION[$cle1][$cle2]))
				{
			   	   	if ($cle4 !== NULL && is_array($_SESSION[$cle1][$cle2][$cle3]) && array_key_exists($cle4, $_SESSION[$cle1][$cle2][$cle3]))
					{
				   	   	if ($cle5 !== NULL && is_array($_SESSION[$cle1][$cle2][$cle3][$cle4]) && array_key_exists($cle5, $_SESSION[$cle1][$cle2][$cle3][$cle4]))
						{
					   	   	if ($cle6 !== NULL && is_array($_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5]) && array_key_exists($cle6, $_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5]))
							{
						   	   	if ($cle7 !== NULL && is_array($_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6]) && array_key_exists($cle7, $_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6]))
							   	   	$valeur = $_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6][$cle7];
							   	else if ($cle7 === NULL)
								   	$valeur = $_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5][$cle6];
						   	}
						   	else if ($cle6 === NULL)
					   		  	$valeur = $_SESSION[$cle1][$cle2][$cle3][$cle4][$cle5];
					   	}
					   	else if ($cle5 === NULL)
					   		$valeur = $_SESSION[$cle1][$cle2][$cle3][$cle4];
				   	}
				   	else if ($cle4 === NULL)
					   	$valeur = $_SESSION[$cle1][$cle2][$cle3];
			   	}
			   	else if ($cle3 === NULL)
					$valeur = $_SESSION[$cle1][$cle2];
		   	}
		   	else if ($cle2 === NULL)
				$valeur = $_SESSION[$cle1];
		}

	   	if ($valeur === NULL)
	   		$valeur = self::GetValeurParDefaut($cle1, $cle2, $cle3, $cle4, $cle5, $cle6);

	   	return $valeur;
	}

	private static function GetValeurPage($cle1, $cle2 = NULL, $cle3 = NULL, $cle4 = NULL, $cle5 = NULL)
	{
	   	return self::GetValeur('pages', self::Page(), $cle1, $cle2, $cle3, $cle4, $cle5);
	}

	private static function GetValeurParDefaut($cle1, $cle2 = NULL, $cle3 = NULL, $cle4 = NULL, $cle5 = NULL, $cle6 = NULL, $cle7 = NULL)
	{
	   	$valeur = NULL;

		switch($cle1)
		{
			case 'joueurFuseauHoraire':
				$valeur = 'UTC';
				break;
			case 'navigateur':
			   	if ($cle2 === 'poidsJavascriptMax')
			   		$valeur = 150;
		}

		return $valeur;
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

?>