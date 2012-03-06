<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_GREPONSE;


define ('CONTEXTE_VAR', 'var');
define ('CONTEXTE_CHARGE', 'charge');
define ('CONTEXTE_RECHARGEMENT', 'recharg');
define ('CONTEXTE_RECHARGEMENTINITIALISATION', 'recharginit');
define ('CONTEXTE_RECHARGEMENTPERIODE', 'rechargperiode');
define ('CONTEXTE_DERNIERRECHARGEMENT', 'derrecharg');
define ('CONTEXTE_LISTES', 'listes');
define ('CONTEXTE_ACTIF', 'actif');
define ('CONTEXTE_PERMANENT', 'perm');
define ('CONTEXTE_REFERENTIELS', 'ref');


define ('CONTEXTE_ONGLET_CLASSEUR', 'classeurId');
define ('CONTEXTE_ONGLET_NOM', 'nom');
define ('CONTEXTE_ONGLET_CONTENU', 'contenu');
define ('CONTEXTE_ONGLET_FONCCHARG', 'foncCharg');
define ('CONTEXTE_ONGLET_PARAM', 'param');
define ('CONTEXTE_ONGLET_CHARGE', 'charge');
define ('CONTEXTE_ONGLET_ACTIVER', 'activer');

define ('CONT_ACCUEIL', 'accueil');
define ('CONT_ACTIVATION', 'activation');
define ('CONT_ADMINISTRATION', 'administration');
define ('CONT_AIDE', 'aide');
define ('CONT_CATEGORIE', 'categorie');
define ('CONT_COMMUNAUTE', 'communaute');
define ('CONT_CONNEXION', 'connexion');
define ('CONT_CONTEXTE', 'context');
define ('CONT_DECONNEXION', 'deconnexion');
define ('CONT_ETATRECRUTEMENT', 'etatRec');
define ('CONT_FONCTIONNALITE', 'fonctionnalite');
define ('CONT_FORUM', 'forum');
define ('CONT_GRADECOMMUNAUTE', 'gradeC');
define ('CONT_GRADECOMMUNAUTEJEU', 'gradeCJ');
define ('CONT_GRADEJEU', 'gradeJ');
define ('CONT_GRADEGLOBAL', 'gradeGl');
define ('CONT_GRADEGROUPE', 'gradeGr');
define ('CONT_GROUPE', 'groupe');
define ('CONT_IDENTIFICATION', 'identif');
define ('CONT_JEU', 'jeu');
define ('CONT_LANGUE', 'langue');
define ('CONT_LIBELLELIBRE', 'libelleLibre');
define ('CONT_LIBELLETEXTELIBRE', 'libelleTexteLibre');
define ('CONT_LOCALISATION', 'localisation');
define ('CONT_MENU', 'menu');
define ('CONT_MESSAGE', 'message');
define ('CONT_MONNAIE', 'monnaie');
define ('CONT_NAVIGATION', 'navigation');
define ('CONT_NOUVGROUPE', 'nouvGroupe');
define ('CONT_NOUVJEU', 'nouvJeu');
define ('CONT_ORIENTATION', 'orientation');
define ('CONT_PRESENTATION', 'presentation');
define ('CONT_PRESENTATIONMODULE', 'presmod');
define ('CONT_SUJET', 'sujet');
define ('CONT_SUPERGRADE', 'superGrade');
define ('CONT_TYPEGROUPE', 'typeGroupe');
define ('CONT_TYPEJEU', 'typeJeu');
define ('CONT_TYPELIBELLE', 'typeLibelle');
define ('CONT_TYPEPRESENTATIONMODULE', 'typePresMod');
define ('CONT_VERSION', 'version');
define ('CONT_VIDE', 'vide');


class GContexte
{
	private static $contextes;
	private static $contextesARecharger;
	private static $contextesARechargerBis;
	private static $contenus;
	private static $listes;
	private static $listesDejaRechargees;
	private static $onglets;
	private static $contextesChanges;
	private static $initialisation;
	private static $contexteCourant;

	public static function Charger()
	{
		self::$contextes = GSession::Contextes();
		self::$contextesChanges = false;
		if (self::$contextes == NULL)
			self::$contextes = array();
		self::$contextesARecharger = array();
		self::$contextesARechargerBis = array();
		self::$initialisation = false;
		self::$listesDejaRechargees = NULL;
		self::$contexteCourant = NULL;
	}

	public static function Sauvegarder()
	{
		GSession::Contextes(self::$contextes);
	}

	public static function Initialisation($valeur = NULL)
	{
	   	if ($valeur !== NULL)
	   	   	self::$initialisation = $valeur;
	   	return self::$initialisation;
	}

	private static function InitContexte($nomContexte, $rechargement, $rechargementInitialisation, $rechargementPeriode, $permanent)
	{
		self::$contextes[$nomContexte] = array();
		self::$contextes[$nomContexte][CONTEXTE_VAR] = array();
		self::$contextes[$nomContexte][CONTEXTE_CHARGE] = false;
		self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENT] = $rechargement;
		self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENTINITIALISATION] = $rechargementInitialisation;
		if ($rechargement === true && $rechargementPeriode <= 0)
			$rechargementPeriode = PERIODERECH_NORMALE;
		self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENTPERIODE] = $rechargementPeriode;
		self::$contextes[$nomContexte][CONTEXTE_DERNIERRECHARGEMENT] = -1;
		self::$contextes[$nomContexte][CONTEXTE_PERMANENT] = $permanent;
		self::$contextes[$nomContexte][CONTEXTE_LISTES] = array();
		self::$contextes[$nomContexte][CONTEXTE_ACTIF] = true;
		self::InitContexteVariables($nomContexte);
	}

	public static function ResetEtatChargeContextes()
	{
		foreach (self::$contextes as &$contexte)
		{
		   	$contexte[CONTEXTE_CHARGE] = false;
		}
	}

	public static function ResetReferentielsContextes()
	{
		foreach (self::$contextes as $nomContexte => $contexte)
		{
		   	unset(self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS]);
		}
	}

	public static function LirePost($cle, $exception = true)
	{
		$contexte = GSession::LirePost(self::$contexteCourant);
		return self::LireVariable($contexte, $cle, self::$contexteCourant, $exception);
	}

	public static function LireVariablePost($nomContexte, $cle, $exception = true)
	{
		$contexte = GSession::LirePost($nomContexte);
		return self::LireVariable($contexte, $cle, $nomContexte, $exception);
	}

	public static function LireVariableSession($nomContexte, $cle, $exception = true)
	{
		$contexte = self::$contextes[$nomContexte][CONTEXTE_VAR];
		return self::LireVariable($contexte, $cle, $nomContexte, $exception);
	}

	public static function EcrireVariableSession($nomContexte, $cle, $valeur)
	{
		self::$contextes[$nomContexte][CONTEXTE_VAR][$cle] = $valeur;
	}

	private static function LireVariable($contexte, $cle, $nomContexte, $exception = true)
	{
	   	if ($cle === NULL)
	   		return $contexte;
		if ($contexte != NULL && is_array($contexte) && array_key_exists($cle, $contexte))
			return $contexte[$cle];

		if ($contexte == NULL || !is_array($contexte))
			{}//GLog::LeverException(EXG_0012, 'GContexte::LireVariable, le contexte ['.$nomContexte.'] n\'existe pas.');
		else if (array_key_exists($cle, $contexte) && $exception === true)
			GLog::LeverException(EXG_0013, 'GContexte::LireVariable, la variable ['.$cle.'] n\'existe pas pour le contexte ['.$nomContexte.'].');

		return NULL;
	}

	public static function Referentiel($nomContexte, $nom, $type, $liste = NULL)
	{
	   	if ($nomContexte !== NULL)
	   	{
	   	   	if ($liste !== NULL)
			{
		   	   	if (!array_key_exists(CONTEXTE_REFERENTIELS, self::$contextes[$nomContexte]))
		   	   		self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS] = array();
		   	   	if (!array_key_exists($type, self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS]))
		   	   		self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS][$type] = array();
			   	self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS][$type][$nom] = $liste;
			}
			else
			{
			   	if (array_key_exists(CONTEXTE_REFERENTIELS, self::$contextes[$nomContexte]) &&
				   	array_key_exists($type, self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS]) &&
				   	array_key_exists($nom, self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS][$type]))
		   	   		return self::$contextes[$nomContexte][CONTEXTE_REFERENTIELS][$type][$nom];
		   	   	return NULL;
			}
		}
	   	else
	   	   	return GSession::Referentiel($nom, $type, $liste);
	}

	public static function Liste($nomContexte, $typeSynchro, $liste = NULL)
	{
	   	if ($liste === NULL)
		{
		   	if (!array_key_exists($nomContexte, self::$contextes))
		   	   	GLog::LeverException(EXG_0017, 'GContexte::Liste, le contexte ['.$nomContexte.'] n\'existe pas.');
		   	else if (array_key_exists($typeSynchro, self::$contextes[$nomContexte][CONTEXTE_LISTES]))
		   	   	$liste = self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['liste'];

			return $liste;
		}
		else
		{
		   	if (!array_key_exists($nomContexte, self::$contextes))
		   	   	GLog::LeverException(EXG_0018, 'GContexte::Liste, le contexte ['.$nomContexte.'] n\'existe pas.');
		   	else
		   	{
		   	   	if (!array_key_exists($typeSynchro, self::$contextes[$nomContexte][CONTEXTE_LISTES]) || self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro] === NULL)
				{
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro] = array();
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['page'] = array();
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['liste'] = NULL;
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['nbListes'] = 0;
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'] = array();
		   	   	}
		   	   	self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['liste'] = $liste;
		   	}
		}
	}

	public static function ListePageCourante($nomContexte, $typeSynchro, $numero, $pageCourante = -1)
	{
	   	if ($pageCourante < 0)
		{
		   	if (!array_key_exists($nomContexte, self::$contextes))
		   	   	GLog::LeverException(EXG_0019, 'GContexte::ListePageCourante, le contexte ['.$nomContexte.'] n\'existe pas.');
		   	else if (array_key_exists($typeSynchro, self::$contextes[$nomContexte][CONTEXTE_LISTES]) && array_key_exists($numero, self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['page']))
		   	   	$pageCourante = self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['page'][$numero];

		  	if ($pageCourante <= 0 || $pageCourante === NULL)
		  		$pageCourante = 1;

			return $pageCourante;
		}
		else
		{
		   	if (!array_key_exists($nomContexte, self::$contextes))
		   	   	GLog::LeverException(EXG_0020, 'GContexte::ListePageCourante, le contexte ['.$nomContexte.'] n\'existe pas.');
		   	else
		   	{
		   	   	if (!array_key_exists($typeSynchro, self::$contextes[$nomContexte][CONTEXTE_LISTES]) || self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro] === NULL)
				{
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro] = array();
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['page'] = array();
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['liste'] = NULL;
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['nbListes'] = 0;
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'] = array();
		   	   	}
		   	   	self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['page'][$numero] = $pageCourante;
		   	}
		}
	}

	public static function ListeActive($nomContexte, $typeSynchro, $desactiver = false)
	{
	   	if (!array_key_exists($nomContexte, self::$contextes))
		   	GLog::LeverException(EXG_0021, 'GContexte::ListeActive, le contexte ['.$nomContexte.'] n\'existe pas.');
	   	else if ($desactiver === true)
		{
		   	self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['nbListes']--;
		   	if (self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['nbListes'] <= 0)
		   	   	self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro] = NULL;
		}
		else
		   	self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['nbListes']++;
	}

	public static function ListeElementEtageCharge($nomContexte, $typeSynchro, $numero, $elementId, $etageCharge, $charge = NULL)
	{
	   	if ($charge === NULL)
		{
		   	if (!array_key_exists($nomContexte, self::$contextes))
		   	   	GLog::LeverException(EXG_0022, 'GContexte::ListeEtageCharge, le contexte ['.$nomContexte.'] n\'existe pas.');
		   	else if (array_key_exists($numero, self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'])
			   	  && array_key_exists($elementId, self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'][$numero])
				  && array_key_exists($etageCharge, self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'][$numero][$elementId]))
		   	   	return self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'][$numero][$elementId][$etageCharge];

			return false;
		}
		else
		{
		   	if (!array_key_exists($nomContexte, self::$contextes))
		   	   	GLog::LeverException(EXG_0023, 'GContexte::ListeEtageCharge, le contexte ['.$nomContexte.'] n\'existe pas.');
		   	else
		   	{
		   	   	if (!array_key_exists($typeSynchro, self::$contextes[$nomContexte][CONTEXTE_LISTES]) || self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro] === NULL)
				{
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro] = array();
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['page'] = array();
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['liste'] = NULL;
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['nbListes'] = 0;
		   	   		self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'] = array();
		   	   	}

				if (!array_key_exists($numero, self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage']))
				   	 self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'][$numero] = array();
				if (!array_key_exists($elementId, self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'][$numero]))
				   	 self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'][$numero][$elementId] = array();
		   	   	self::$contextes[$nomContexte][CONTEXTE_LISTES][$typeSynchro]['etage'][$numero][$elementId][$etageCharge] = $charge;
		   	}
		}
	}

	public static function FormaterVariable($nomContexte, $cle)
	{
	   	$cleFormatee = $cle;
	   	if (is_array($cle))
		{
	   		$cleFormatee = '';
	   		foreach ($cle as $cleElem)
	   		{
	   		   	if ($cleFormatee !== '')
	   		   		$cleFormatee .= ',';
			   	$cleFormatee .= $cleElem;
			}
	   	}
		if ($nomContexte != NULL && $nomContexte !== '' && $cleFormatee !== '')
			return $nomContexte.'['.$cleFormatee.']';
		return '';
	}

	protected static function NomContexteGeneral($nomContexte)
	{
	   	$nom = $nomContexte;
	   	$posU = strpos($nom, '_');

	   	if ($posU !== false)
			$nom = substr($nom, 0, $posU);

		return $nom;
	}

	public static function NomContexteSuffixe($nomContexte)
	{
	   	$suffixe = '';
	   	$posU = strpos($nomContexte, '_');

	   	if ($posU !== false)
			$suffixe = substr($nomContexte, $posU + 1);

		return $suffixe;
	}

	public static function InitContexteVariables($nomContexte)
	{
	   	// Suppression des anciennes variables.
		self::$contextes[$nomContexte][CONTEXTE_VAR] = NULL;
		// Ajout des nouvelles variables.
		self::$contextes[$nomContexte][CONTEXTE_VAR] = GSession::LirePost($nomContexte);
	}

	public static function IsContexteExiste($nomContexte, $actif = NULL)
	{
	   	$existe = false;

	   	if (array_key_exists($nomContexte, self::$contextes))
		{
	   		if ($actif !== NULL && $actif === self::$contextes[$nomContexte][CONTEXTE_ACTIF])
				$existe = true;
	   		else if ($actif === NULL)
	   		   	$existe = true;
	   	}

		return $existe;
	}

	public static function ContexteCourant($nomContexte = NULL)
	{
	   	if ($nomContexte !== NULL)
	   		self::$contexteCourant = $nomContexte;

	   	return self::$contexteCourant;
	}

	public static function SetContexte($nomContexte, $rechargement = false, $rechargementInitialisation = true, $rechargementPeriode = -1)
	{
		self::ResetContextes();
		self::$contextes[$nomContexte][CONTEXTE_ACTIF] = true;
		self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENT] = $rechargement;
		self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENTINITIALISATION] = $rechargementInitialisation;
		self::$contextes[$nomContexte][CONTEXTE_PERMANENT] = false;
		self::InitContexte($nomContexte, $rechargement, $rechargementInitialisation, $rechargementPeriode, false);
	}

	public static function AjouterContexte($nomContexte, $rechargement = false, $rechargementInitialisation = true, $rechargementPeriode = -1)
	{
	   	self::$contextesChanges = true;
		if (array_key_exists($nomContexte, self::$contextes))
		{
		   	self::$contextes[$nomContexte][CONTEXTE_ACTIF] = true;
		   	self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENT] = $rechargement;
			self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENTINITIALISATION] = $rechargementInitialisation;
			self::$contextes[$nomContexte][CONTEXTE_PERMANENT] = false;
		}
		else
			self::InitContexte($nomContexte, $rechargement, $rechargementInitialisation, $rechargementPeriode, false);
	}

	public static function AjouterContextePermanent($nomContexte, $rechargement = false, $rechargementInitialisation = true, $rechargementPeriode = -1)
	{
	   	self::$contextesChanges = true;
		if (array_key_exists($nomContexte, self::$contextes))
		{
		   	self::$contextes[$nomContexte][CONTEXTE_ACTIF] = true;
		   	self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENT] = $rechargement;
			self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENTINITIALISATION] = $rechargementInitialisation;
			self::$contextes[$nomContexte][CONTEXTE_PERMANENT] = true;
		}
		else
			self::InitContexte($nomContexte, $rechargement, $rechargementInitialisation, $rechargementPeriode, true);
	}

	public static function DesactiverContexte($nomContexte)
	{
	   	if (array_key_exists($nomContexte, self::$contextes))
		   	self::$contextes[$nomContexte][CONTEXTE_ACTIF] = false;
	}

	public static function SupprimerContexte($nomContexte)
	{
		if (array_key_exists($nomContexte, self::$contextes))
		{
		   	$contextes = self::$contextes;
			//$contextes[$nomContexte] = NULL;
			unset($contextes[$nomContexte]);
			self::$contextes = $contextes;
		}
	}

	public static function SupprimerContextesDesactives()
	{
	   	foreach (self::$contextes as $nomContexte => $contexte)
	   	{
		   	if ($contexte[CONTEXTE_ACTIF] === false && $contexte[CONTEXTE_PERMANENT] === false)
		   		self::SupprimerContexte($nomContexte);
		}
	}

	public static function ResetContextes()
	{
	   	self::$contextesChanges = true;

		foreach(self::$contextes as $nomContexte => $contexte)
	   	{
	   	   	if ($contexte[CONTEXTE_PERMANENT] === false)
		   	   	unset(self::$contextes[$nomContexte]);
		}
	}

	public static function DoitRechargerContexte($nomContexte)
	{
	   	$rechargement = false;
   	   	if (array_key_exists($nomContexte, self::$contextes))
   	   	   	 $rechargement = self::$contextes[$nomContexte][CONTEXTE_RECHARGEMENT];

   		return $rechargement;
	}

	public static function AjouterAuReferentiel($nomContexte, $nomReferentiel)
	{
	   	self::$listes = array();
	   	self::ContexteCourant($nomContexte);

	   	switch (self::NomContexteGeneral($nomContexte))
		{
			case CONT_GRADEGLOBAL:
				include PATH_FONCTIONS.'Droit/fAjouterAuReferentielGradeGlobal.php';
				break;
			case CONT_JEU:
				include PATH_FONCTIONS.'Jeu/fAjouterAuReferentielJeu.php';
				break;
			case CONT_NOUVJEU:
				include PATH_FONCTIONS.'Jeu/fAjouterAuReferentielNouveauJeu.php';
				break;
		}

		self::$listesDejaRechargees = array();
		foreach (self::$listes as $liste)
		{
			self::MiseAJourListe($liste);
		}
	}

	public static function SupprimerDuReferentiel($nomContexte, $nomReferentiel)
	{
	   	self::$listes = array();
	   	self::ContexteCourant($nomContexte);

	   	switch (self::NomContexteGeneral($nomContexte))
		{
			case CONT_GRADEGLOBAL:
				include PATH_FONCTIONS.'Droit/fSupprimerDuReferentielGradeGlobal.php';
				break;
			case CONT_JEU:
				include PATH_FONCTIONS.'Jeu/fSupprimerDuReferentielJeu.php';
				break;
			case CONT_NOUVJEU:
				include PATH_FONCTIONS.'Jeu/fSupprimerDuReferentielNouveauJeu.php';
				break;
		}

		self::$listesDejaRechargees = array();
		foreach (self::$listes as $liste)
		{
			self::MiseAJourListe($liste);
		}
	}

	public static function ChargerReferentielContexte($nomContexte, $nomReferentiel)
	{
	   	self::$listes = array();
	   	self::ContexteCourant($nomContexte);

	   	switch (self::NomContexteGeneral($nomContexte))
		{
			case CONT_COMMUNAUTE:
				include PATH_FONCTIONS.'Communaute/fChargerReferentielsCommunaute.php';
				break;
			case CONT_GRADEGLOBAL:
				include PATH_FONCTIONS.'Droit/fChargerReferentielsGradeGlobal.php';
				break;
			case CONT_GROUPE:
				include PATH_FONCTIONS.'Groupe/fChargerReferentielsGroupe.php';
				break;
			case CONT_JEU:
				include PATH_FONCTIONS.'Jeu/fChargerReferentielsJeu.php';
				break;
			case CONT_LANGUE:
				include PATH_FONCTIONS.'Langue/fChargerReferentielsLangue.php';
				break;
			case CONT_LOCALISATION:
				include PATH_FONCTIONS.'Groupe/fChargerReferentielsGroupeConnexion.php';
				break;
			case CONT_NOUVGROUPE:
				include PATH_FONCTIONS.'Groupe/fChargerReferentielsNouveauGroupe.php';
				break;
			case CONT_NOUVJEU:
				include PATH_FONCTIONS.'Jeu/fChargerReferentielsNouveauJeu.php';
				break;
			case CONT_PRESENTATIONMODULE:
			   	include PATH_FONCTIONS.'Presentation/fChargerReferentielsPresentationModule.php';
			   	break;
		}

		self::$listesDejaRechargees = array();
		foreach (self::$listes as $liste)
		{
			self::MiseAJourListe($liste);
		}
		self::RechargerContextes();
	}

	public static function CliquerContexte($nomContexte)
	{
	   	$rechargement = self::DoitRechargerContexte($nomContexte);
	   	self::ContexteCourant($nomContexte);

	   	switch ($nomContexte)
		{
			case CONT_GROUPE:
				include PATH_FONCTIONS.'Groupe/fCliquerGroupe.php';
				self::RechargerContexte(CONT_LOCALISATION);
				break;
		}

		if (self::$contextesChanges === true)
			self::ChargerContextes();
		else if ($rechargement === true)
		   	self::ChargerContexte($nomContexte);
		self::RechargerContextes();
	}

	public static function AjouterAuContexte($nomContexte)
	{
	   	if (self::CheckFormulaire() === true)
	   	{
	   	   	$rechargement = self::DoitRechargerContexte($nomContexte);
	   	   	self::ContexteCourant($nomContexte);

			switch (self::NomContexteGeneral($nomContexte))
			{
			   	case CONT_ADMINISTRATION:
					include PATH_FONCTIONS.'Administration/fAjouterAdministration.php';
					break;
				case CONT_CATEGORIE:
					include PATH_FONCTIONS.'Forum/Categories/fAjouterCategorie';
					break;
				case CONT_COMMUNAUTE:
					include PATH_FONCTIONS.'Communaute/fAjouterCommunaute.php';
					self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_CONNEXION:
					include PATH_FONCTIONS.'Connexion/fCreerCompte.php';
					//self::RechargerContexte(CONT_IDENTIFICATION);
					self::RechargerContexte(CONT_NAVIGATION);
					break;
				case CONT_CONTEXTE:
					include PATH_FONCTIONS.'Contexte/fAjouterContexte.php';
					break;
				case CONT_ETATRECRUTEMENT:
					include PATH_FONCTIONS.'Recrutement/fAjouterEtatRecrutement.php';
					break;
				case CONT_FONCTIONNALITE:
					include PATH_FONCTIONS.'Fonctionnalite/fAjouterFonctionnalite.php';
					break;
				case CONT_FORUM:
					include PATH_FONCTIONS.'Forum/fAjouterForum.php';
					break;
				case CONT_GRADECOMMUNAUTE:
					include PATH_FONCTIONS.'Droit/fAjouterGradeCommunaute.php';
					break;
				case CONT_GRADECOMMUNAUTEJEU:
					include PATH_FONCTIONS.'Droit/fAjouterGradeCommunauteJeu.php';
					break;
				case CONT_GRADEJEU:
					include PATH_FONCTIONS.'Droit/fAjouterGradeJeu.php';
					break;
				case CONT_GRADEGLOBAL:
					include PATH_FONCTIONS.'Droit/fAjouterGradeGlobal.php';
					break;
				case CONT_GRADEGROUPE:
					include PATH_FONCTIONS.'Droit/fAjouterGradeGroupe.php';
					break;
				case CONT_GROUPE:
					include PATH_FONCTIONS.'Groupe/fAjouterGroupe.php';
					break;
				case CONT_LANGUE:
					include PATH_FONCTIONS.'Langue/fAjouterLangue.php';
					self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_LIBELLELIBRE:
					include PATH_FONCTIONS.'Libelle/fAjouterLibelleLibre.php';
					break;
				case CONT_LIBELLETEXTELIBRE:
					include PATH_FONCTIONS.'Libelle/fAjouterLibelleTexteLibre.php';
					break;
				case CONT_MENU:
					include PATH_FONCTIONS.'Menu/fAjouterMenu.php';
					self::RechargerContexte(CONT_NAVIGATION);
					break;
				case CONT_MESSAGE:
					include PATH_FONCTIONS.'Forum/Messages/fAjouterMessage';
					break;
				case CONT_MONNAIE:
					include PATH_FONCTIONS.'Monnaie/fAjouterMonnaie.php';
					break;
				case CONT_NOUVGROUPE:
					include PATH_FONCTIONS.'Groupe/fAjouterNouveauGroupe.php';
					self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_NOUVJEU:
					include PATH_FONCTIONS.'Jeu/fAjouterNouveauJeu.php';
					break;
				case CONT_ORIENTATION:
					include PATH_FONCTIONS.'General/fChargerOrientation.php';
					break;
				case CONT_PRESENTATION:
					include PATH_FONCTIONS.'Presentation/fAjouterPresentation.php';
					break;
				case CONT_SUJET:
					include PATH_FONCTIONS.'Forum/Sujets/fAjouterSujet';
					break;
				case CONT_SUPERGRADE:
					include PATH_FONCTIONS.'Droit/fAjouterSuperGrade.php';
					break;
				case CONT_TYPEGROUPE:
					include PATH_FONCTIONS.'Groupe/fAjouterTypeGroupe.php';
					break;
				case CONT_TYPEJEU:
					include PATH_FONCTIONS.'Jeu/fAjouterTypeJeu.php';
					break;
				case CONT_TYPELIBELLE:
					include PATH_FONCTIONS.'Libelle/fAjouterTypeLibelle.php';
					break;
				case CONT_TYPEPRESENTATIONMODULE:
					include PATH_FONCTIONS.'Presentation/fAjouterTypePresentationModule.php';
					break;
				case CONT_VERSION:
					include PATH_FONCTIONS.'Version/fAjouterVersion.php';
					break;
				default:
					return;
			}

			if (self::$contextesChanges === true)
				self::ChargerContextes();
			else if ($rechargement === true)
			   	self::ChargerContexte($nomContexte);
			self::RechargerContextes();
		}
		else
		{
		   	$checkFormulaire = GSession::LireSession('checkFormulaire');
	   		$cf = GSession::LirePost('cf');
		   	GLog::LeverException(EXG_0014, 'Le formulaire d\'ajout n\'a pas pu être validé pour le contexte ['.$nomContexte.']. Codes: ['.$checkFormulaire.']-['.$cf.'].');
		}
	}

	public static function ModifierDansContexte($nomContexte)
	{
	   	if (self::CheckFormulaire() === true)
		{
			$rechargement = self::DoitRechargerContexte($nomContexte);
			self::ContexteCourant($nomContexte);

			switch (self::NomContexteGeneral($nomContexte))
			{
			   	case CONT_ACTIVATION:
					include PATH_FONCTIONS.'Joueur/fActivation.php';
					break;
				case CONT_CATEGORIE:
					include PATH_FONCTIONS.'Forum/Categories/fModifierCategorie';
					break;
				case CONT_COMMUNAUTE:
					include PATH_FONCTIONS.'Communaute/fModifierCommunaute.php';
					self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_CONTEXTE:
					include PATH_FONCTIONS.'Contexte/fModifierContexte.php';
					break;
				case CONT_ETATRECRUTEMENT:
					include PATH_FONCTIONS.'Recrutement/fModifierEtatRecrutement.php';
					break;
				case CONT_FONCTIONNALITE:
					include PATH_FONCTIONS.'Fonctionnalite/fModifierFonctionnalite.php';
					break;
				case CONT_FORUM:
					include PATH_FONCTIONS.'Forum/fModifierForum.php';
					break;
				case CONT_GRADECOMMUNAUTE:
					include PATH_FONCTIONS.'Droit/fModifierGradeCommunaute.php';
					break;
				case CONT_GRADECOMMUNAUTEJEU:
					include PATH_FONCTIONS.'Droit/fModifierGradeCommunauteJeu.php';
					break;
				case CONT_GRADEJEU:
					include PATH_FONCTIONS.'Droit/fModifierGradeJeu.php';
					break;
				case CONT_GRADEGLOBAL:
					include PATH_FONCTIONS.'Droit/fModifierGradeGlobal.php';
					break;
				case CONT_GRADEGROUPE:
					include PATH_FONCTIONS.'Droit/fModifierGradeGroupe.php';
					break;
				case CONT_GROUPE:
					include PATH_FONCTIONS.'Groupe/fModifierGroupe.php';
					break;
				case CONT_JEU:
					include PATH_FONCTIONS.'Jeu/fModifierJeu.php';
					break;
				case CONT_LANGUE:
					include PATH_FONCTIONS.'Langue/fModifierLangue.php';
					self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_LIBELLELIBRE:
					include PATH_FONCTIONS.'Libelle/fModifierLibelleLibre.php';
					break;
				case CONT_LIBELLETEXTELIBRE:
					include PATH_FONCTIONS.'Libelle/fModifierLibelleTexteLibre.php';
					break;
				case CONT_LOCALISATION:
					include PATH_FONCTIONS.'Groupe/fModifierGroupeConnexion.php';
					self::RechargerContexte(CONT_NAVIGATION);
					//self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_MENU:
					include PATH_FONCTIONS.'Menu/fModifierMenu.php';
					self::RechargerContexte(CONT_NAVIGATION);
					break;
				case CONT_MESSAGE:
					include PATH_FONCTIONS.'Forum/Messages/fModifierMessage';
					break;
				case CONT_MONNAIE:
					include PATH_FONCTIONS.'Monnaie/fModifierMonnaie.php';
					break;
				case CONT_PRESENTATION:
					include PATH_FONCTIONS.'Presentation/fModifierPresentation.php';
					//self::RechargerContexte(self::LireVariableSession($nomContexte, 'ongletContexte'));
					break;
				case CONT_PRESENTATIONMODULE:
				   	$module = self::NomContexteSuffixe($nomContexte);
				   	include PATH_FONCTIONS.'Presentation/fModifierPresentationModule.php';
				   	break;
				case CONT_SUJET:
					include PATH_FONCTIONS.'Forum/Sujets/fModifierSujet';
					break;
				case CONT_SUPERGRADE:
					include PATH_FONCTIONS.'Droit/fModifierSuperGrade.php';
					break;
				case CONT_TYPEGROUPE:
					include PATH_FONCTIONS.'Groupe/fModifierTypeGroupe.php';
					break;
				case CONT_TYPEJEU:
					include PATH_FONCTIONS.'Jeu/fModifierTypeJeu.php';
					break;
				case CONT_TYPELIBELLE:
					include PATH_FONCTIONS.'Libelle/fModifierTypeLibelle.php';
					break;
				case CONT_TYPEPRESENTATIONMODULE:
					include PATH_FONCTIONS.'Presentation/fModifierTypePresentationModule.php';
					break;
				case CONT_VERSION:
					include PATH_FONCTIONS.'Version/fModifierVersion.php';
					break;
				default:
					return;
			}

			if (self::$contextesChanges === true)
				self::ChargerContextes();
			else if ($rechargement === true)
			   	self::ChargerContexte($nomContexte);
			self::RechargerContextes();
		}
		else
		{
		   	$checkFormulaire = GSession::LireSession('checkFormulaire');
	   		$cf = GSession::LirePost('cf');
		   	GLog::LeverException(EXG_0015, 'Le formulaire de modification n\'a pas pu être validé pour le contexte ['.$nomContexte.']. Codes: ['.$checkFormulaire.']-['.$cf.'].');
		}
	}

	public static function SupprimerDuContexte($nomContexte)
	{
	   	if (self::CheckFormulaire() === true)
		{
			$rechargement = self::DoitRechargerContexte($nomContexte);
			self::ContexteCourant($nomContexte);

			switch (self::NomContexteGeneral($nomContexte))
			{
				case CONT_CATEGORIE:
					include PATH_FONCTIONS.'Forum/Categories/fSupprimerCategorie';
					break;
				case CONT_COMMUNAUTE:
					include PATH_FONCTIONS.'Communaute/fSupprimerCommunaute.php';
					self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_CONTEXTE:
					include PATH_FONCTIONS.'Contexte/fSupprimerContexte.php';
					break;
				case CONT_ETATRECRUTEMENT:
					include PATH_FONCTIONS.'Recrutement/fSupprimerEtatRecrutement.php';
					break;
				case CONT_FONCTIONNALITE:
					include PATH_FONCTIONS.'Fonctionnalite/fSupprimerFonctionnalite.php';
					break;
				case CONT_FORUM:
					include PATH_FONCTIONS.'Forum/fSupprimerForum.php';
					break;
				case CONT_GRADECOMMUNAUTE:
					include PATH_FONCTIONS.'Droit/fSupprimerGradeCommunaute.php';
					break;
				case CONT_GRADECOMMUNAUTEJEU:
					include PATH_FONCTIONS.'Droit/fSupprimerGradeCommunauteJeu.php';
					break;
				case CONT_GRADEJEU:
					include PATH_FONCTIONS.'Droit/fSupprimerGradeJeu.php';
					break;
				case CONT_GRADEGLOBAL:
					include PATH_FONCTIONS.'Droit/fSupprimerGradeGlobal.php';
					break;
				case CONT_GRADEGROUPE:
					include PATH_FONCTIONS.'Droit/fSupprimerGradeGroupe.php';
					break;
				case CONT_GROUPE:
					include PATH_FONCTIONS.'Groupe/fSupprimerGroupe.php';
					break;
				case CONT_LANGUE:
					include PATH_FONCTIONS.'Langue/fSupprimerLangue.php';
					self::RechargerContexte(CONT_LOCALISATION);
					break;
				case CONT_LIBELLELIBRE:
					include PATH_FONCTIONS.'Libelle/fSupprimerLibelleLibre.php';
					break;
				case CONT_LIBELLETEXTELIBRE:
					include PATH_FONCTIONS.'Libelle/fSupprimerLibelleTexteLibre.php';
					break;
				case CONT_MENU:
					include PATH_FONCTIONS.'Menu/fSupprimerMenu.php';
					self::RechargerContexte(CONT_NAVIGATION);
					break;
				case CONT_MESSAGE:
					include PATH_FONCTIONS.'Forum/Messages/fSupprimerMessage';
					break;
				case CONT_MONNAIE:
					include PATH_FONCTIONS.'Monnaie/fSupprimerMonnaie.php';
					break;
				case CONT_SUJET:
					include PATH_FONCTIONS.'Forum/Sujets/fSupprimerSujet';
					break;
				case CONT_SUPERGRADE:
					include PATH_FONCTIONS.'Droit/fSupprimerSuperGrade.php';
					break;
				case CONT_TYPEGROUPE:
					include PATH_FONCTIONS.'Groupe/fSupprimerTypeGroupe.php';
					break;
				case CONT_TYPEJEU:
					include PATH_FONCTIONS.'Jeu/fSupprimerTypeJeu.php';
					break;
				case CONT_TYPELIBELLE:
					include PATH_FONCTIONS.'Libelle/fSupprimerTypeLibelle.php';
					break;
				case CONT_TYPEPRESENTATIONMODULE:
					include PATH_FONCTIONS.'Presentation/fSupprimerTypePresentationModule.php';
					break;
				case CONT_VERSION:
					include PATH_FONCTIONS.'Version/fSupprimerVersion.php';
					break;
				default:
					return;
			}

			if (self::$contextesChanges === true)
				self::ChargerContextes();
			else if ($rechargement === true)
			   	self::ChargerContexte($nomContexte);
			self::RechargerContextes();
		}
		else
		{
		   	$checkFormulaire = GSession::LireSession('checkFormulaire');
	   		$cf = GSession::LirePost('cf');
		   	GLog::LeverException(EXG_0016, 'Le formulaire de suppression n\'a pas pu être validé pour le contexte ['.$nomContexte.']. Codes: ['.$checkFormulaire.']-['.$cf.'].');
		}
	}

	public static function RechargerContexte($nomContexte, $bis = false)
	{
	   	if (self::IsContexteExiste($nomContexte))
	   	{
	   	   	if ($bis === false)
		   	   	self::$contextesARecharger[] = $nomContexte;
		   	else
		   	   	self::$contextesARechargerBis[] = $nomContexte;
	   	}
	}

	public static function RechargerContextes($bis = false)
	{
	   	if ($bis === false)
		{
		   	foreach(self::$contextesARecharger as $i => $nomContexte)
			{
			   	unset(self::$contextesARecharger[$i]);
				self::ChargerContexte($nomContexte, true);
			}

			self::$contextesARecharger = array();
		}
		else
		{
		   	foreach(self::$contextesARechargerBis as $i => $nomContexte)
			{
			   	unset(self::$contextesARechargerBis[$i]);
				self::ChargerContexte($nomContexte, true);
			}
		}
	}

	public static function ChargerContextes($auto = false)
	{
	   	$rechargement = true;
	   	self::$contextesChanges = false;

	   	while ($rechargement === true)
		{
		   	$rechargement = false;
			$contextes = self::$contextes;

			if (count($contextes) == 0)
			{
			   	self::AjouterContextePermanent(CONT_IDENTIFICATION, true);
			   	self::ChargerContexte(CONT_IDENTIFICATION);
				self::AjouterContextePermanent(CONT_LOCALISATION, false, true, PERIODERECH_LOCALISATION);
				self::ChargerContexte(CONT_LOCALISATION);
				self::AjouterContextePermanent(CONT_NAVIGATION, false, true, PERIODERECH_NAVIGATION);
				self::ChargerContexte(CONT_NAVIGATION);
				self::AjouterContextePermanent(CONT_ORIENTATION);
				self::ChargerContexte(CONT_ORIENTATION);
			}
			else
			{
			   	// On recharge d'abord les contextes temporaires.
				foreach ($contextes as $nomContexte => $contexte)
				{
				   	if ($contexte !== NULL && $contexte[CONTEXTE_ACTIF] === true && $contexte[CONTEXTE_PERMANENT] === false)
					{
					   	// Rechargement automatique.
					   	if ($auto === true && $contexte[CONTEXTE_RECHARGEMENTPERIODE] >= 1 && (time() - $contexte[CONTEXTE_DERNIERRECHARGEMENT] >= $contexte[CONTEXTE_RECHARGEMENTPERIODE] - 10000 || $contexte[CONTEXTE_DERNIERRECHARGEMENT] === -1))
							self::ChargerContexte($nomContexte, true);
					   	else
						   	self::ChargerContexte($nomContexte);
						// Si dans le chargement d'un contexte on a changé les contextes, on recharge.
						if (self::$contextesChanges === true)
						{
							$rechargement = true;
							self::$contextesChanges = false;
							break;
						}
					}
				}

				// On recharge ensuite les contextes permanents.
				if ($rechargement === false)
				{
					foreach ($contextes as $nomContexte => $contexte)
					{
					   	if ($contexte !== NULL && $contexte[CONTEXTE_ACTIF] === true && $contexte[CONTEXTE_PERMANENT] === true)
						{
						   	// Rechargement automatique.
							if ($auto === true && $contexte[CONTEXTE_RECHARGEMENTPERIODE] >= 1 && (time() - $contexte[CONTEXTE_DERNIERRECHARGEMENT] >= $contexte[CONTEXTE_RECHARGEMENTPERIODE] - 10000 || $contexte[CONTEXTE_DERNIERRECHARGEMENT] === -1))
							   	self::ChargerContexte($nomContexte, true);
						   	else
							   	self::ChargerContexte($nomContexte);
							// Si dans le chargement d'un contexte on a changé les contextes, on recharge.
							if (self::$contextesChanges === true)
							{
								$rechargement = true;
								self::$contextesChanges = false;
								break;
							}
						}
					}
				}
			}
		}
	}

	public static function ChargerContexte($nomContexte, $forcage = false)
	{
		$contexte = self::$contextes[$nomContexte];
		$dejaCharge = $contexte[CONTEXTE_CHARGE];
		$rechargement = $contexte[CONTEXTE_RECHARGEMENT];
		$rechargementInitialisation = $contexte[CONTEXTE_RECHARGEMENTINITIALISATION];
		self::$listes = array();
		self::$contenus = array();
		self::$onglets = array();
		self::$contextesARechargerBis = array();

		// Ne charge le contexte que si:
		// - on est dans le cas d'un rechargement automatique.
		// - on charge la suite du contexte (dans le cas d'un contexte trop volumineux pour être chargé en une fois).
		// - il n'a pas été chargé et l'utilisateur charge la page pour la première fois ou a appuyé sur F5.
		// - on est dans le cas d'un rechargement et le contexte accepte le rechargement.
		if ($forcage === true || (($dejaCharge === true && $rechargement === true) || $dejaCharge === false) && (($rechargementInitialisation === true && self::$initialisation === true) || self::$initialisation === false))
		{
		   	if ($dejaCharge === false)
		   	   	self::$contextes[$nomContexte][CONTEXTE_CHARGE] = true;
		   	self::ContexteCourant($nomContexte);
		   	if ($contexte[CONTEXTE_RECHARGEMENTPERIODE] >= 1)
		   	   	self::$contextes[$nomContexte][CONTEXTE_DERNIERRECHARGEMENT] = time();

			switch (self::NomContexteGeneral($nomContexte))
			{
			   	case CONT_ACCUEIL:
					include PATH_FONCTIONS.'Accueil/fChargerAccueil.php';
					break;
			   	case CONT_ACTIVATION:
					include PATH_FONCTIONS.'Joueur/fChargerActivation.php';
					break;
				case CONT_ADMINISTRATION:
					include PATH_FONCTIONS.'Administration/fChargerAdministration.php';
					break;
				case CONT_AIDE:
					include PATH_FONCTIONS.'Aide/fChargerAide.php';
					break;
				case CONT_COMMUNAUTE:
					include PATH_FONCTIONS.'Communaute/fChargerCommunautesAdmin.php';
					break;
				case CONT_CONNEXION:
					include PATH_FONCTIONS.'Connexion/fConnexion.php';
					//self::RechargerContexte(CONT_IDENTIFICATION, true);
					self::RechargerContexte(CONT_NAVIGATION, true);
					break;
				case CONT_CONTEXTE:
					include PATH_FONCTIONS.'Contexte/fChargerContextesAdmin.php';
					break;
				case CONT_DECONNEXION:
					include PATH_FONCTIONS.'Connexion/fDeconnexion.php';
					//self::RechargerContexte(CONT_IDENTIFICATION, true);
					self::RechargerContexte(CONT_NAVIGATION, true);
					break;
				case CONT_CATEGORIE:
					include PATH_FONCTIONS.'Forum/Categories/fChargerCategories.php';
					break;
				case CONT_ETATRECRUTEMENT:
					include PATH_FONCTIONS.'Recrutement/fChargerEtatsRecrutement.php';
					break;
				case CONT_FONCTIONNALITE:
					include PATH_FONCTIONS.'Fonctionnalite/fChargerFonctionnalitesAdmin.php';
					break;
				case CONT_FORUM:
					include PATH_FONCTIONS.'Forum/fChargerForums.php';
					break;
				case CONT_GRADECOMMUNAUTE:
					include PATH_FONCTIONS.'Droit/fChargerGradeCommunautesAdmin.php';
					break;
				case CONT_GRADECOMMUNAUTEJEU:
					include PATH_FONCTIONS.'Droit/fChargerGradeCommunautesJeuxAdmin.php';
					break;
				case CONT_GRADEJEU:
					include PATH_FONCTIONS.'Droit/fChargerGradeJeuxAdmin.php';
					break;
				case CONT_GRADEGLOBAL:
					include PATH_FONCTIONS.'Droit/fChargerGradesGlobauxAdmin.php';
					break;
				case CONT_GRADEGROUPE:
					include PATH_FONCTIONS.'Droit/fChargerGradesGroupesAdmin.php';
					break;
				case CONT_GROUPE:
					include PATH_FONCTIONS.'Groupe/fChargerGroupes.php';
					break;
				case CONT_IDENTIFICATION:
					include PATH_FONCTIONS.'Connexion/fChargerConnexion.php';
					break;
				case CONT_JEU:
					include PATH_FONCTIONS.'Jeu/fChargerJeu.php';
					break;
				case CONT_LANGUE:
					include PATH_FONCTIONS.'Langue/fChargerLanguesAdmin.php';
					break;
				case CONT_LIBELLELIBRE:
					include PATH_FONCTIONS.'Libelle/fChargerLibellesLibresAdmin.php';
					break;
				case CONT_LIBELLETEXTELIBRE:
					include PATH_FONCTIONS.'Libelle/fChargerLibellesTextesLibresAdmin.php';
					break;
				case CONT_LOCALISATION:
					include PATH_FONCTIONS.'Communaute/fChargerCommunautes.php';
					include PATH_FONCTIONS.'Langue/fChargerLangues.php';
					include PATH_FONCTIONS.'Groupe/fChargerGroupeConnexion.php';
					break;
				case CONT_MENU:
					include PATH_FONCTIONS.'Menu/fChargerMenusAdmin.php';
					break;
				case CONT_MESSAGE:
					include PATH_FONCTIONS.'Forum/Messages/fChargerMessages.php';
					break;
				case CONT_MONNAIE:
					include PATH_FONCTIONS.'Monnaie/fChargerMonnaiesAdmin.php';
					break;
				case CONT_NAVIGATION:
					include PATH_FONCTIONS.'Menu/fChargerNavigation.php';
					break;
				case CONT_NOUVGROUPE:
					include PATH_FONCTIONS.'Groupe/fChargerNouveauGroupe.php';
					break;
				case CONT_NOUVJEU:
					include PATH_FONCTIONS.'Jeu/fChargerNouveauJeu.php';
					break;
				case CONT_ORIENTATION:
					include PATH_FONCTIONS.'General/fChargerOrientation.php';
					break;
				case CONT_PRESENTATION:
					include PATH_FONCTIONS.'Presentation/fChargerPresentation.php';
					break;
				case CONT_PRESENTATIONMODULE:
				   	$module = self::NomContexteSuffixe($nomContexte);
					include PATH_FONCTIONS.'Presentation/fChargerPresentationModule'.$module.'.php';
				   	break;
				case CONT_SUJET:
					include PATH_FONCTIONS.'Forum/Sujets/fChargerSujets.php';
					break;
				case CONT_SUPERGRADE:
					include PATH_FONCTIONS.'Droit/fChargerSuperGradesAdmin.php';
					break;
				case CONT_TYPEGROUPE:
					include PATH_FONCTIONS.'Groupe/fChargerTypesGroupesAdmin.php';
					break;
				case CONT_TYPEJEU:
					include PATH_FONCTIONS.'Jeu/fChargerTypesJeuxAdmin.php';
					break;
				case CONT_TYPELIBELLE:
					include PATH_FONCTIONS.'Libelle/fChargerTypesLibellesAdmin.php';
					break;
				case CONT_TYPEPRESENTATIONMODULE:
					include PATH_FONCTIONS.'Presentation/fChargerTypesPresentationsModulesAdmin.php';
					break;
				case CONT_VERSION:
					include PATH_FONCTIONS.'Version/fChargerVersionsAdmin.php';
					break;
				case CONT_VIDE:
					include PATH_FONCTIONS.'General/fChargerVide.php';
					break;
				default:
					return;
			}

			if ($dejaCharge !== true)
			{
				$contenus = self::$contenus;
				while (list($cadre, $contenu) = each($contenus))
				{
					GReponse::AjouterElementContenu($cadre, $contenu);
				}

				$onglets = self::$onglets;
				while (list($i, $onglet) = each($onglets))
				{
					GReponse::AjouterElementOnglet($onglet[CONTEXTE_ONGLET_CLASSEUR], $onglet[CONTEXTE_ONGLET_NOM], $onglet[CONTEXTE_ONGLET_CONTENU], $onglet[CONTEXTE_ONGLET_FONCCHARG], $onglet[CONTEXTE_ONGLET_PARAM], $onglet[CONTEXTE_ONGLET_CHARGE], $onglet[CONTEXTE_ONGLET_ACTIVER]);
				}
			}
			else
			{
			   	self::$listesDejaRechargees = array();
				foreach (self::$listes as $liste)
				{
			   	   	self::MiseAJourListe($liste);
			   	}

			   	foreach (self::$contenus as $cadre => $contenu)
				{
					GReponse::AjouterElementContenu($cadre, $contenu);
				}

				foreach (self::$onglets as $onglet)
				{
					GReponse::AjouterElementOnglet($onglet[CONTEXTE_ONGLET_CLASSEUR], $onglet[CONTEXTE_ONGLET_NOM], $onglet[CONTEXTE_ONGLET_CONTENU], $onglet[CONTEXTE_ONGLET_FONCCHARG], $onglet[CONTEXTE_ONGLET_PARAM], $onglet[CONTEXTE_ONGLET_CHARGE], $onglet[CONTEXTE_ONGLET_ACTIVER]);
				}
			}

			self::RechargerContextes(true);
		}
	}

	protected static function MiseAJourListe($liste)
	{
	   	// On vérifie qu'une liste identique n'a pas déjà fait le travail.
	   	if (!array_key_exists($liste->TypeSynchroPage(), self::$listesDejaRechargees))
		{
	   		$listeDejaRechargee[$liste->TypeSynchroPage()] = true;

		   	$elements = $liste->GetElementsPourRechargement();
		   	$listeModifiee = false;
			foreach ($elements as $element)
			{
			   	if (array_key_exists(LISTE_ELEMENT_ACTION, $element))
			   	{
				   	if ($element[LISTE_ELEMENT_ACTION] === LISTE_ELEMACTION_MODIF && array_key_exists(LISTE_ELEMENT_MODIFIE, $element) && $element[LISTE_ELEMENT_MODIFIE] === true)
				   	   	$listeModifiee = true;
				   	else if ($element[LISTE_ELEMENT_ACTION] !== LISTE_ELEMACTION_MODIF)
				   	   	$listeModifiee = true;
				}
			}

			if ($listeModifiee === true)
			{
		   	   	if ($liste->ChangementPage() === true)
		   	   		GReponse::AjouterElementListe($liste->AncienTypeSynchroPage(), $liste->NbPages(), $liste->Numero(), $liste->TypeSynchroPage());
		   	   	else
			   	   	GReponse::AjouterElementListe($liste->TypeSynchroPage(), $liste->NbPages());

			   	// On met d'abord les éléments supprimés.
			   	foreach ($elements as $element)
				{
				   	if (array_key_exists(LISTE_ELEMENT_ACTION, $element) && $element[LISTE_ELEMENT_ACTION] === LISTE_ELEMACTION_SUPP)
				   	   	GReponse::AjouterElementListeSuppression($element[LISTE_ELEMENT_ID]);
			   	}

			   	// Puis on met les éléments créés et modifiés dans l'ordre de la liste.
				foreach ($elements as $element)
				{
				   	if (array_key_exists(LISTE_ELEMENT_ACTION, $element))
			   		{
					   	switch ($element[LISTE_ELEMENT_ACTION])
					   	{
					   	   	case LISTE_ELEMACTION_AJOUTCONTENU:
					   	   	   	GReponse::AjouterElementListeAjoutContenu($element[LISTE_ELEMENT_ID], $element[LISTE_ELEMENT_CONTENU]);
					   	   	   	break;
						   	case LISTE_ELEMACTION_CREAT:
					   	   	   	GReponse::AjouterElementListeCreation($element[LISTE_ELEMENT_CONTENU]);
					   	   	   	break;
				   	   		case LISTE_ELEMACTION_MODIF:
				   	   		   	if (array_key_exists(LISTE_ELEMENT_MODIFIE, $element) && $element[LISTE_ELEMENT_MODIFIE] === true)
					   	   	   	   	GReponse::AjouterElementListeModification($element[LISTE_ELEMENT_CONTENU]);
					   	   	   	break;
				   	   	}
				   	}
			   	}
			}
			else
			   	GReponse::AjouterElementListe($liste->TypeSynchroPage(), $liste->NbPages());
		}
	}

	public static function AjouterListe($liste)
	{
		if (is_array(self::$listes))
		{
		   	if (self::$listesDejaRechargees === NULL)
			   	self::$listes[] = $liste;
			else
			   	self::MiseAJourListe($liste);
		}
	}

	public static function AjouterContenu($cadre, $contenu)
	{
		if (is_array(self::$contenus))
			self::$contenus[$cadre] = $contenu;
	}

	public static function AjouterOnglet($classeurId, $nom, $contenu, $fonctionChargement, $param, $charge, $activer)
	{
		if (is_array(self::$onglets))
		{
		   	$onglet = array();
		   	$onglet[CONTEXTE_ONGLET_CLASSEUR] = $classeurId;
		   	$onglet[CONTEXTE_ONGLET_NOM] = $nom;
		   	$onglet[CONTEXTE_ONGLET_CONTENU] = $contenu;
		   	$onglet[CONTEXTE_ONGLET_FONCCHARG] = $fonctionChargement;
		   	$onglet[CONTEXTE_ONGLET_PARAM] = 'cf='.GSession::NumCheckFormulaire().'&'.$param;
		   	$onglet[CONTEXTE_ONGLET_CHARGE] = $charge;
		   	$onglet[CONTEXTE_ONGLET_ACTIVER] = $activer;
			self::$onglets[] = $onglet;
		}
	}

	private static function CheckFormulaire()
	{
	   	$checkFormulaire = GSession::LireSession('checkFormulaire');
	   	$cf = GSession::LirePost('cf');
	   	if ($checkFormulaire !== NULL && $cf !== NULL && intval($checkFormulaire) === intval($cf))
	   	   	return true;
	   	return false;
	}
}

?>