<?php

require_once 'cst.php';
require_once INC_SBALISE;
require_once INC_GLOG;
require_once INC_GSESSION;


define ('XML_XML','XML');

define ('XML_REPONSENONATT','reponseNA');
define ('XML_REPONSE','reponse');

define ('XML_ELEMENT','element');

define ('XML_CREAT','creat');
define ('XML_CREATCAT','creatCat');
define ('XML_MODIF','modif');
define ('XML_SUPP','supp');
define ('XML_SUPPCAT','suppCat');
define ('XML_SEL','sel');

define ('XML_ACTIVER','activer');
define ('XML_ACTION','action');
define ('XML_CADRE','cadre');
define ('XML_CAT','cat');
define ('XML_CHARGE','charge');
define ('XML_CLASSE','classe');
define ('XML_CLASSEUR','classeur');
define ('XML_CODE','code');
define ('XML_CONTENU','contenu');
define ('XML_CONTEXTE','contexte');
define ('XML_DESC','desc');
define ('XML_FONCCHARG','fonctionChargement');
define ('XML_ID','id');
define ('XML_LIB','lib');
define ('XML_MODULE','module');
define ('XML_NBPAGES','nbPages');
define ('XML_NOM','nom');
define ('XML_NOUVTYPESYNCHRO','nouvTypeSynchro');
define ('XML_NUMERO','numero');
define ('XML_ORDRE','ordre');
define ('XML_PARAM','param');//'valeur');
define ('XML_REF','ref');
define ('XML_SOURCE','source');
define ('XML_TYPE','type');
define ('XML_TYPESYNCHRO','typeSynchro');
define ('XML_VALEUR','valeur');
define ('XML_VISUALISEUR','visualiseur');

define ('XML_TYPE_CLASSEUR','classeur');
define ('XML_TYPE_CONTENU','contenu');
define ('XML_TYPE_ERREUR','erreur');
define ('XML_TYPE_WARNING','warning');
define ('XML_TYPE_LISTE','liste');
define ('XML_TYPE_SELECT','select');
define ('XML_TYPE_TEXT','text');
define ('XML_TYPE_ONGLET','onglet');
define ('XML_TYPE_SUITE','suite');
define ('XML_TYPE_CSS','css');
define ('XML_TYPE_JS','js');

define ('XML_TYPEACTION','typeAction');
define ('XML_TYPEACTION_AJOUTCONTENU','ajoutContenu');
define ('XML_TYPEACTION_CREAT','creat');
define ('XML_TYPEACTION_MODIF','modif');
define ('XML_TYPEACTION_SUPP','supp');


class GReponse
{
	protected static $init;
	protected static $reponse;
	protected static $elemCourant;
	protected static $elemContenu;
	protected static $balRattacheParam;
	protected static $suite;

	public static function Debut()
	{
		GSession::Demarrer();
		self::$init = true;
		self::$suite = array();
		header('Content-Type: text/xml; charset=UTF-8');
		echo "<?xml version=\"1.0\"?>\n";
		echo '<'.XML_XML.'><'.XML_REPONSENONATT.'>';
		self::$reponse = new SBalise(XML_REPONSE);
		self::$elemContenu = array();
	}

	public static function Fin()
	{
		GSession::TraiterLibelles();
		if (self::$init === true)
		{
			echo '</'.XML_REPONSENONATT.'>';
			echo self::$reponse->BuildHTML();
			echo '</'.XML_XML.'>';
		}
		else
			GLog::LeverException(EXG_0000, 'La réponse n\'a pas été initialisée.');
		GSession::Terminer();
	}

	private static function AjouterElement($type)
	{
		self::$elemCourant = self::AjouterBalToBal(self::$reponse, XML_ELEMENT);
		self::AjouterBalToBal(self::$elemCourant, XML_TYPE, $type);
	}

	public static function AjouterParam($classe, $valeur)
	{
		$balParam = self::AjouterBalToBal(self::$balRattacheParam, XML_PARAM);
		self::AjouterBalToBal($balParam, XML_CLASSE, $classe);
		self::AjouterBalToBal($balParam, XML_VALEUR, $valeur);
	}

	private static function AjouterBalToBal($parent, $nom, $valeur = '')
	{
		if (self::$init === true && $parent != NULL)
		{
			$bal = new SBalise($nom);
			if (is_string($valeur) || is_int($valeur))
				$bal->SetText($valeur);
			else
				$bal->Attach($valeur);
			$parent->Attach($bal);
			return $bal;
		}

		GLog::LeverException(EXG_0001, 'La réponse n\'a pas été initialisée.');
		return NULL;
	}

	// Type Contenu.
	public static function AjouterElementContenu($cadre, $contenu)
	{
		if (!array_key_exists($cadre, self::$elemContenu))
		{
			self::AjouterElement(XML_TYPE_CONTENU);
			self::AjouterBalToBal(self::$elemCourant, XML_CADRE, strval($cadre));

			self::$elemContenu[$cadre] = self::AjouterBalToBal(self::$elemCourant, XML_CONTENU, $contenu);
		}
		else
			self::$elemContenu[$cadre]->Attach($contenu);
	}

	// Type Erreur.
	public static function AjouterElementErreur($code, $lib)
	{
		self::AjouterElement(XML_TYPE_ERREUR);
		self::AjouterBalToBal(self::$elemCourant, XML_CODE, strval($code));
		self::AjouterBalToBal(self::$elemCourant, XML_LIB, $lib);
	}

	// Type Warning.
	public static function AjouterElementWarning($code, $lib)
	{
		self::AjouterElement(XML_TYPE_WARNING);
		self::AjouterBalToBal(self::$elemCourant, XML_CODE, strval($code));
		self::AjouterBalToBal(self::$elemCourant, XML_LIB, $lib);
	}

	// Type Liste.
	public static function AjouterElementListe($typeSynchro, $nbPages = -1, $numero = -1, $nouveauTypeSynchro = '')
	{
		self::AjouterElement(XML_TYPE_LISTE);
		self::AjouterBalToBal(self::$elemCourant, XML_TYPESYNCHRO, $typeSynchro);
		if ($nbPages >= 1)
		   	self::AjouterBalToBal(self::$elemCourant, XML_NBPAGES, strval($nbPages));
		// Si on vise une liste spécifique.
		if ($numero >= 0)
		{
		    self::AjouterBalToBal(self::$elemCourant, XML_NUMERO, strval($numero));
			if ($nouveauTypeSynchro !== '')
			   	self::AjouterBalToBal(self::$elemCourant, XML_NOUVTYPESYNCHRO, $nouveauTypeSynchro);
		}
	}

	public static function AjouterElementListeAjoutContenu($id, $contenu)
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_ACTION);
		self::AjouterBalToBal(self::$balRattacheParam, XML_TYPEACTION, XML_TYPEACTION_AJOUTCONTENU);
		self::AjouterBalToBal(self::$balRattacheParam, XML_ID, strval($id));
		self::AjouterBalToBal(self::$balRattacheParam, XML_CONTENU, $contenu);
	}

	public static function AjouterElementListeCreation($contenu)
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_ACTION);
		self::AjouterBalToBal(self::$balRattacheParam, XML_TYPEACTION, XML_TYPEACTION_CREAT);
		self::AjouterBalToBal(self::$balRattacheParam, XML_CONTENU, $contenu);
	}

	public static function AjouterElementListeModification($contenu)
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_ACTION);
		self::AjouterBalToBal(self::$balRattacheParam, XML_TYPEACTION, XML_TYPEACTION_MODIF);
		self::AjouterBalToBal(self::$balRattacheParam, XML_CONTENU, $contenu);
	}

	public static function AjouterElementListeSuppression($id)
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_ACTION);
		self::AjouterBalToBal(self::$balRattacheParam, XML_TYPEACTION, XML_TYPEACTION_SUPP);
		self::AjouterBalToBal(self::$balRattacheParam, XML_ID, strval($id));
	}

	// Type Select.
	public static function AjouterElementSelect($referentiel)
	{
		self::AjouterElement(XML_TYPE_SELECT);
		self::AjouterBalToBal(self::$elemCourant, XML_REF, $referentiel);
	}

	public static function AjouterElementSelectCreationCategorie($categorieId, $categorieLib)
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_CREATCAT);
		self::AjouterBalToBal(self::$balRattacheParam, XML_ID, strval($categorieId));
		self::AjouterBalToBal(self::$balRattacheParam, XML_LIB, $categorieLib);
	}

	public static function AjouterElementSelectSuppressionCategorie($categorieId)
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_SUPPCAT);
		self::AjouterBalToBal(self::$balRattacheParam, XML_ID, strval($categorieId));
	}

	public static function AjouterElementSelectCreation($id, $lib, $desc, $activer = NULL, $categorie = '')
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_CREAT);
		self::AjouterBalToBal(self::$balRattacheParam, XML_ID, strval($id));
		self::AjouterBalToBal(self::$balRattacheParam, XML_LIB, $lib);
		self::AjouterBalToBal(self::$balRattacheParam, XML_DESC, $desc);
		if ($activer === true)
		   	self::AjouterBalToBal(self::$balRattacheParam, XML_ACTIVER, '1');
		else if ($activer === false)
		   	self::AjouterBalToBal(self::$balRattacheParam, XML_ACTIVER, '0');
		if ($categorie !== '')
		   	self::AjouterBalToBal(self::$balRattacheParam, XML_CAT, strval($categorie));
	}

	public static function AjouterElementSelectModification($id, $lib, $desc)
	{
		self::$balRattacheParam = self::AjouterBalToBal(self::$elemCourant, XML_MODIF);
		self::AjouterBalToBal(self::$balRattacheParam, XML_ID, strval($id));
		self::AjouterBalToBal(self::$balRattacheParam, XML_LIB, $lib);
		self::AjouterBalToBal(self::$balRattacheParam, XML_DESC, $desc);
	}

	public static function AjouterElementSelectSuppression($id)
	{
		$balSupp = self::AjouterBalToBal(self::$elemCourant, XML_SUPP);
		self::AjouterBalToBal($balSupp, XML_ID, strval($id));
	}

	public static function AjouterElementSelectSelection($id)
	{
		$balSel = self::AjouterBalToBal(self::$elemCourant, XML_SEL);
		self::AjouterBalToBal($balSel, XML_ID, strval($id));
	}

	// Type Text.
	public static function AjouterElementText()
	{
		self::AjouterElement(XML_TYPE_TEXT);
	}

	public static function AjouterElementTextModification($lib)
	{
		$balModif = self::AjouterBalToBal(self::$elemCourant, XML_MODIF);
		self::AjouterBalToBal($balModif, XML_LIB, $lib);
	}

	// Type Classeur/Onglet.
	public static function AjouterElementOnglet($classeurId, $nom, $contenu, $fonctionChargement, $param, $charge, $activer)
	{
	   	if ($charge === true)
	   	   	$charge = 1;
	   	else if ($charge === false)
	   	   	$charge = 0;

	   	if ($activer === true)
	   	   	$activer = 1;
	   	else if ($activer === false)
	   	   	$activer = 0;

	   	self::AjouterElement(XML_TYPE_ONGLET);
	   	self::AjouterBalToBal(self::$elemCourant, XML_CLASSEUR, strval($classeurId));
		self::AjouterBalToBal(self::$elemCourant, XML_NOM, $nom);
		self::AjouterBalToBal(self::$elemCourant, XML_CONTENU, $contenu);
		self::AjouterBalToBal(self::$elemCourant, XML_FONCCHARG, to_ajax($fonctionChargement));
		self::AjouterBalToBal(self::$elemCourant, XML_PARAM, to_ajax($param));
		self::AjouterBalToBal(self::$elemCourant, XML_CHARGE, strval($charge));
		self::AjouterBalToBal(self::$elemCourant, XML_ACTIVER, strval($activer));
	}

	public static function AjouterElementClasseurRechargement($classeurId)
	{
	   	self::AjouterElement(XML_TYPE_CLASSEUR);
	   	self::AjouterBalToBal(self::$elemCourant, XML_ID, strval($classeurId));
	}

	// Type Suite (chargement par blocks).
	public static function AjouterElementSuite($contexte)
	{
	   	if (!array_key_exists($contexte, self::$suite))
		{
		   	self::AjouterElement(XML_TYPE_SUITE);
		   	self::AjouterBalToBal(self::$elemCourant, XML_CONTEXTE, $contexte);
		   	self::$suite[$contexte] = 1;
		}
	}

	// Type CSS.
	public static function AjouterElementCSS($module, $source)
	{
		self::AjouterElement(XML_TYPE_CSS);
		self::AjouterBalToBal(self::$elemCourant, XML_MODULE, 'css'.$module);
		self::AjouterBalToBal(self::$elemCourant, XML_SOURCE, $source);
	}

	// Type JS.
	public static function AjouterElementJS($module, $source, $visualiseur = false)
	{
		self::AjouterElement(XML_TYPE_JS);
		self::AjouterBalToBal(self::$elemCourant, XML_MODULE, 'js'.$module);
		self::AjouterBalToBal(self::$elemCourant, XML_SOURCE, $source);
		if ($visualiseur === true)
		   	self::AjouterBalToBal(self::$elemCourant, XML_VISUALISEUR, '1');
	}
}

?>