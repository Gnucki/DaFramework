<?php

require_once 'cst.php';
require_once INC_SELEMORG;
require_once INC_GCONTEXTE;
require_once INC_SFORM;


define ('LISTECLASS','_liste');
define ('LISTECLASS_TITRE','_liste_titre');
define ('LISTECLASS_TITREELEM','_liste_titreelem');
define ('LISTECLASS_ELEMENT','_liste_elem');
define ('LISTECLASS_ELEMCONSULT','_liste_elemconsult');
define ('LISTECLASS_ELEMMODIF','_liste_elemmodif');
define ('LISTECLASS_ELEMCREAT','_liste_elemcreat');
define ('LISTECLASS_ELEMMENU','_liste_elemmenu');
define ('LISTECLASS_ELEMMENU_ELEM','_liste_elemmenu_elem');
define ('LISTECLASS_ELEMCHAMP','_liste_elemchamp');
define ('LISTECLASS_BARDEF','_liste_bardef');
define ('LISTECLASS_BARDEF_PREMPAGE','_liste_bardef_prempage');
define ('LISTECLASS_BARDEF_DERPAGE','_liste_bardef_derpage');
define ('LISTECLASS_BARDEF_PAGEPREC','_liste_bardef_pageprec');
define ('LISTECLASS_BARDEF_PAGESUIV','_liste_bardef_pagesuiv');
define ('LISTECLASS_BARDEF_SCROLLBARRE','_liste_bardef_scrollbarre');
define ('LISTECLASS_BARDEF_BARRE','_liste_bardef_barre');

define ('LISTE_CHAMPLISTE_VALEURPARDEFAUT','valeurParDefaut');
define ('LISTE_CHAMPLISTE_ESTID','estId');
define ('LISTE_CHAMPLISTE_RETOURINVISIBLE','retourInvisible');
define ('LISTE_CHAMPLISTE_INPUTMODIFPARDEFAUT','inputModif');
define ('LISTE_CHAMPLISTE_INPUTCREATPARDEFAUT','inputCreat');
define ('LISTE_CHAMPLISTE_MIN','min');
define ('LISTE_CHAMPLISTE_MAX','max');
define ('LISTE_CHAMPLISTE_LONGUEURMIN','longmin');
define ('LISTE_CHAMPLISTE_LONGUEURMAX','longmax');
define ('LISTE_CHAMPLISTE_REGEXP','regexp');
define ('LISTE_CHAMPLISTE_NONNUL','nonnul');
define ('LISTE_CHAMPLISTE_INFO','info');
define ('LISTE_CHAMPLISTE_ERREUR','erreur');
define ('LISTE_CHAMPLISTE_AUTRESDONNEES','autre');
define ('LISTE_CHAMPLISTE_ENSESSION','enSession');

define ('LISTE_CHAMPTYPE_CONSULT','consult');
define ('LISTE_CHAMPTYPE_MODIF','modif');
define ('LISTE_CHAMPTYPE_CREAT','creat');

//define ('LISTE_AUTRESDONNEES_SELECTDEPENDCHAMP','depchamp');
define ('LISTE_AUTRESDONNEES_SELECTIMPACT','simpact');
define ('LISTE_AUTRESDONNEES_SELECTDEPENDANCE','sdep');
define ('LISTE_AUTRESDONNEES_SELECTCOLID','scid');
define ('LISTE_AUTRESDONNEES_SELECTCOLLIB','sclib');
define ('LISTE_AUTRESDONNEES_SELECTCOLDESC','scdesc');
define ('LISTE_AUTRESDONNEES_SELECTRECHARGEFONC','recfonc');
define ('LISTE_AUTRESDONNEES_SELECTRECHARGEPARAM','recparam');
define ('LISTE_AUTRESDONNEES_TEXTTAILLE','ttaille');
define ('LISTE_AUTRESDONNEES_IMAGEVISUALISEUR','imgvisu');
define ('LISTE_AUTRESDONNEES_IMAGETYPE','imgtype');
define ('LISTE_AUTRESDONNEES_CHAMPFORMATE','cformat');
define ('LISTE_AUTRESDONNEES_CHAMPLABEL','clabel');

define ('LISTE_INPUTTYPE_SELECT','select');
define ('LISTE_INPUTTYPE_FIND','find');
define ('LISTE_INPUTTYPE_FILE','file');
define ('LISTE_INPUTTYPE_IMAGE','image');
define ('LISTE_INPUTTYPE_TEXT','text');
define ('LISTE_INPUTTYPE_CHECKBOX','checkbox');
define ('LISTE_INPUTTYPE_LISTE','liste');
define ('LISTE_INPUTTYPE_LISTEDB','listedb');

define ('LISTE_CONTEXTE_ORDRE','ordre');
define ('LISTE_CONTEXTE_CHAMPS','champs');

define ('LISTE_MENU_ELEMENTS','menuElem');
define ('LISTE_MENU_ELEMENT_FONC','fonc');
define ('LISTE_MENU_ELEMENT_LIB','lib');
define ('LISTE_MENU_ELEMENT_AJAX','ajax');
define ('LISTE_MENU_ELEMENT_PARAM','param');
define ('LISTE_MENU_ELEMENT_CADRE','cadre');
define ('LISTE_MENU_ELEMENT_RESET','reset');

define ('LISTE_ETAGE_CONSULT','1');
define ('LISTE_ETAGE_MODIF','2');

define ('LISTE_ELEMENT_ID','le_id');
define ('LISTE_ELEMENT_ORDRE','le_ordre');
define ('LISTE_ELEMENT_RETOUR','le_retour');
define ('LISTE_ELEMENT_CONTENU','le_contenu');
define ('LISTE_ELEMENT_ACTION','le_action');
define ('LISTE_ELEMENT_VALEURCONSULT','le_consult');
define ('LISTE_ELEMENT_VALEURMODIF','le_modif');
define ('LISTE_ELEMENT_MODIFIE','le_modifie');
define ('LISTE_ELEMENT_OBJET','le_objet');

define ('LISTE_ELEMACTION_AJOUTCONTENU','ajoutContenu');
define ('LISTE_ELEMACTION_CREAT','creat');
define ('LISTE_ELEMACTION_MODIF','modif');
define ('LISTE_ELEMACTION_SUPP','supp');

define ('LISTE_JQ','jq_liste');
define ('LISTE_JQ_STATIQUE','jq_liste_statique');
define ('LISTE_JQ_TYPE','jq_liste_type');
define ('LISTE_JQ_TYPESYNCHRO','jq_liste_typesynchro');
define ('LISTE_JQ_NUMERO','jq_liste_numero');
define ('LISTE_JQ_NIVEAU','jq_liste_niveau');
define ('LISTE_JQ_SORTABLE','jq_liste_sortable');
define ('LISTE_JQ_SORTABLE_FONCININ','jq_liste_sortable_foncinin');
define ('LISTE_JQ_SORTABLE_FONCINOUT','jq_liste_sortable_foncinout');
define ('LISTE_JQ_SORTABLE_FONCOUTIN','jq_liste_sortable_foncoutin');
define ('LISTE_JQ_SORTABLE_PARAMININ','jq_liste_sortable_paraminin');
define ('LISTE_JQ_SORTABLE_PARAMINOUT','jq_liste_sortable_paraminout');
define ('LISTE_JQ_SORTABLE_PARAMOUTIN','jq_liste_sortable_paramoutin');
define ('LISTE_JQ_NBELEMPARPAGE','jq_liste_nbelemparpage');
define ('LISTE_JQ_ELEMENTMODELE','jq_liste_elementmodele');
define ('LISTE_JQ_ELEMENTCREATION','jq_liste_elementcreat');
define ('LISTE_JQ_LISTE','jq_liste_liste');
define ('LISTE_JQ_ELEM','jq_liste_elem');
define ('LISTE_JQ_ELEM_MENUS','jq_liste_elem_menus');
define ('LISTE_JQ_ELEM_MENU','jq_liste_elem_menu');
define ('LISTE_JQ_ELEM_MENUELEM','jq_liste_elem_menuelem');
define ('LISTE_JQ_ELEM_MENUELEM_BOUTON','jq_liste_elem_menuelem_bouton');
define ('LISTE_JQ_ELEM_CHAMP','jq_liste_elem_champ');
define ('LISTE_JQ_ELEM_CHAMP_NOM','jq_liste_elem_champ_nom');
define ('LISTE_JQ_ELEM_CHAMP_TYPE','jq_liste_elem_champ_type');
define ('LISTE_JQ_ELEM_ETAGE','jq_liste_elem_etage');
define ('LISTE_JQ_ELEM_ETAGE_NUM','jq_liste_elem_etage_num');
define ('LISTE_JQ_ELEM_ETAGE_CHARGEFONC','jq_liste_elem_etage_chargefonc');
define ('LISTE_JQ_ELEM_ETAGE_CHARGEPARAM','jq_liste_elem_etage_chargeparam');
define ('LISTE_JQ_ELEM_PLIANT','jq_liste_elem_pliant');
define ('LISTE_JQ_ELEM_TITRE','jq_liste_elem_titre');
define ('LISTE_JQ_ELEM_INDIC','jq_liste_elem_indic');
define ('LISTE_JQ_ELEM_CONTENU','jq_liste_elem_contenu');
define ('LISTE_JQ_ELEM_CONTENU_CHARGEFONC','jq_liste_elem_contenu_chargefonc');
define ('LISTE_JQ_ELEM_CONTENU_CHARGEPARAM','jq_liste_elem_contenu_chargeparam');
define ('LISTE_JQ_ELEMENT','jq_liste_element');
define ('LISTE_JQ_ELEMENT_ID','jq_liste_element_id');
define ('LISTE_JQ_ELEMENT_ORDRE','jq_liste_element_ordre');
define ('LISTE_JQ_ELEMENT_FONCTION','jq_liste_element_fonction');
define ('LISTE_JQ_ELEMENT_PARAM','jq_liste_element_param');
define ('LISTE_JQ_ELEMENT_MENUS','jq_liste_element_menus');
define ('LISTE_JQ_ELEMENT_MENU','jq_liste_element_menu');
define ('LISTE_JQ_ELEMENT_MENUELEM','jq_liste_element_menuelem');
define ('LISTE_JQ_ELEMENT_MENUELEM_LIB','jq_liste_element_menuelem_lib');
define ('LISTE_JQ_ELEMENT_MENUELEM_BOUTONCADRE','jq_liste_element_menuelem_boutoncadre');
define ('LISTE_JQ_ELEMENT_MENUELEM_BOUTONFONC','jq_liste_element_menuelem_boutonfonc');
define ('LISTE_JQ_ELEMENT_MENUELEM_BOUTONAJAX','jq_liste_element_menuelem_boutonajax');
define ('LISTE_JQ_ELEMENT_MENUELEM_BOUTONPARAM','jq_liste_element_menuelem_boutonparam');
define ('LISTE_JQ_ELEMENT_MENUELEM_BOUTONRESET','jq_liste_element_menuelem_boutonreset');
define ('LISTE_JQ_ELEMENT_CHAMPS','jq_liste_element_champs');
define ('LISTE_JQ_ELEMENT_CHAMP','jq_liste_element_champ');
define ('LISTE_JQ_ELEMENT_CHAMP_VALEUR','jq_liste_element_champ_valeur');
define ('LISTE_JQ_ELEMENT_CHAMP_NOM','jq_liste_element_champ_nom');
define ('LISTE_JQ_ELEMENT_CHAMP_TYPE','jq_liste_element_champ_type');
define ('LISTE_JQ_PAGE_CHANGEFONC','jq_liste_page_changefonc');
define ('LISTE_JQ_PAGE_CHANGEPARAM','jq_liste_page_changeparam');
define ('LISTE_JQ_PAGE_NAVIGATEUR','jq_liste_page_navigateur');
define ('LISTE_JQ_PAGE_BARREDEFILEMENT','jq_liste_page_barredefilement');
define ('LISTE_JQ_PAGE_PREC','jq_liste_page_prec');
define ('LISTE_JQ_PAGE_COURANTE','jq_liste_page_courante');
define ('LISTE_JQ_PAGE_SUIV','jq_liste_page_suiv');
define ('LISTE_JQ_PAGE_PREM','jq_liste_page_prem');
define ('LISTE_JQ_PAGE_DER','jq_liste_page_der');

define ('LISTE_JQFONCTION_MENUPOP','menuPop');
define ('LISTE_JQFONCTION_ETAGEGO','etageGo');

define ('LISTE_JQCADRE_ETAGE','etage');


// Mode d'emploi de la classe.
// 1 - Créer une classe dérivée.
// 2 - Surcharger la méthode InitialiserChamps().
// 3 - Surcharger la méthode AjouterElement().
// 4 - Surcharger la méthode GetElemListeMenu() si vous voulez changer les menus accessibles via le menu déroulant de l'élément.
// 5 - Surcharger les méthodes de gestion des droits: HasDroitConsultation($element), HasDroitModification($element), HasDroitCreation(), HasDroitSuppression($element).
// 6 - Surcharger la méthode ConstruireLigneTitre() si vous voulez mettre une barre de titre à votre liste (pour les listes tableaux).
// 7 - Surcharger les méthodes de création de l'affichage: ConstruireElemConsultation(), ConstruireElemModification(), ConstruireElemCreation(), en appelant la fontion parent et récupérant le retour:
//	$conteneur = parent::Construire...(); $elem = new ...(); ...; $conteneur->Attach($elem); return $conteneur;

// Pour les exemples:
// define ('ID', 'id');
// define ('PRENOM', 'prenom');
// define ('NOM', 'nom');

// Classe servant de base pour les différentes listes complexes (liste de personnages, de forums, d'amis, de grades, d'événements, ...) du programme.
class SListe extends SElement
{
   	static protected $nbListesEnregistrees;
   	static protected $changementPage;
   	static protected $chargementEtage;
   	static protected $chargementContenu;
   	static protected $listeElemChargee;

   	protected $numero;
   	protected $niveau;
	protected $elements;
	protected $champs;
	protected $menus;
	protected $contexte;
	protected $typeSynchro;
	protected $listeContexte;
	protected $listeSuppressions;
	protected $rechargement;
	protected $nbElementsParPage;
	protected $nbElementsTotal;
	protected $numPageCourante;
	protected $numAnciennePage;
	protected $triable;
	protected $typeLiaison;
	protected $prefixIdClass;
	protected $foncAjaxCreation;
	protected $foncAjaxModification;
	protected $foncAjaxSuppression;
	protected $foncAjaxRechargement;
	protected $foncJsOnClick;
	protected $foncAjaxTriCreation;
	protected $foncAjaxTriModification;
	protected $foncAjaxTriSuppression;
	protected $chargement;
	protected $chargementModifDiffere;
	protected $referentiels;
	protected $referentielsElements;
	protected $sousListes;
	protected $sousListesListe;
	protected $sousListesElements;
	protected $sousListesElementsListe;
	protected $listeParente;
	protected $hasListeParente;
	protected $idListeParente;
	protected $statique;
	protected $nomFichierPresMod;
	protected $presentation;

    public function __construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage = 20, $nbElementsTotal = -1, $triable = false, $typeLiaison = '', $chargementModifDiffere = true, $foncJsOnClick = '', $foncAjaxTriCreation = '', $foncAjaxTriModification = AJAXFONC_MODIFIERDANSCONTEXTE, $foncAjaxTriSuppression = '', $foncAjaxCreation = AJAXFONC_AJOUTERAUCONTEXTE, $foncAjaxModification = AJAXFONC_MODIFIERDANSCONTEXTE, $foncAjaxSuppression = AJAXFONC_SUPPRIMERDUCONTEXTE, $foncAjaxRechargement = AJAXFONC_RECHARGER)
    {
       	$this->prefixIdClass = $prefixIdClass;

		if (self::$nbListesEnregistrees === NULL)
			self::$nbListesEnregistrees = array();

		// Affectation d'un numéro à la liste qui permet, avec son typeSynchro, de la rendre unique et identifiable.
		if (!array_key_exists($typeSynchro, self::$nbListesEnregistrees))
		{
		   	$this->numero = 1;
			self::$nbListesEnregistrees[$typeSynchro] = 1;
		}
		else
		{
		   	$this->numero = self::$nbListesEnregistrees[$typeSynchro];
		   	self::$nbListesEnregistrees[$typeSynchro]++;
		}

		if (self::$listeElemChargee === NULL)
		   	self::$listeElemChargee = array();

       	parent::__construct('', false);

		$this->elements = array();
		$this->champs = array();
		$this->menus = array();
		$this->chargement = true;
		$this->contexte = $contexte;
		$this->typeSynchro = $typeSynchro;
		$this->nbElementsParPage = $nbElementsParPage;
		$this->nbElementsTotal = $nbElementsTotal;
		if ($this->statique !== true)
		   	 $this->numPageCourante = GContexte::ListePageCourante($contexte, $typeSynchro, $this->numero);
		$this->numAnciennePage = $this->numPageCourante;
		$this->triable = $triable;
		if ($this->triable === true)
			$this->typeLiaison = $typeLiaison;
		$this->foncAjaxCreation = $foncAjaxCreation;
		$this->foncAjaxModification = $foncAjaxModification;
		$this->foncAjaxSuppression = $foncAjaxSuppression;
		$this->foncAjaxRechargement = $foncAjaxRechargement;
		$this->foncJsOnClick = $foncJsOnClick;
		$this->foncAjaxTriCreation = $foncAjaxTriCreation;
		$this->foncAjaxTriModification = $foncAjaxTriModification;
		$this->foncAjaxTriSuppression = $foncAjaxTriSuppression;
		if ($this->statique !== true)
		{
			$this->listeContexte = GContexte::Liste($contexte, $this->TypeSynchroPage());
			$this->listeSuppressions = $this->listeContexte;
			if ($this->listeContexte === NULL)
			    $this->listeContexte = array();
		}
		$this->rechargement = false;
		$this->chargementModifDiffere = $chargementModifDiffere;
		$this->referentiels = array();
		$this->referentielsElements = array();
		$this->sousListes = array();
		$this->sousListesListe = array();
		$this->sousListesElements = array();
		$this->sousListesElementsListe = array();
		$this->listeParente = NULL;
		$this->hasListeParente = false;
		$this->idListeParente = '';
		$this->niveau = -1;
		$this->nomFichierPresMod = '';
		$this->presentation = -1;

		$this->InitialiserChamps();
		$this->InitialiserReferentiels();
		$this->InitialiserListes();

		$this->AddClass(LISTE_JQ);
	}

	public function __destruct()
	{
	   	unset($this->listeParente);
	}

	static public function SetChangementPage($page)
	{
	   	self::$changementPage = $page;
	}

	static public function SetChargementEtage($etage)
	{
	   	self::$chargementEtage = $etage;
	}

	static public function IsChargementEtage()
	{
	   	if (self::$chargementEtage === NULL)
	   		return false;
	   	return true;
	}

	static public function SetChargementContenu($contenu)
	{
	   	self::$chargementContenu = $contenu;
	}

	// Initialisation des champs.
	protected function InitialiserChamps()
	{
	   	// $this->AjouterChamp(ID, -1, true, true);
		// $this->AjouterChamp(PRENOM, 'John');
		// $this->AjouterChamp(NOM, 'Doe');
		// ...
	}

	protected function NomFormate($nom)
	{
	   	$nomRef = '';
		if (is_array($nom))
		{
			foreach ($nom as $nomCol)
			{
			   	if ($nomRef !== '')
			   	   	$nomRef .= ',';
			   	$nomRef .= $nomCol;
			}
		}
		else
		   	$nomRef = $nom;

		return $nomRef;
	}

	protected function NomRefFormate($nom)
	{
	   	return $this->PrefixeNomFromParent().$this->NomFormate($nom).$this->SuffixeNomFromParent();
	}

	protected function NomListeFormate($nom)
	{
	   	return $this->PrefixeNomFromParent().$this->NomFormate($nom).$this->SuffixeNomFromParent().'_'.$this->contexte;
	}

	protected function NomsListeChampsFormates($noms)
	{
	   	$nomsFormates = $noms;
	   	if (is_array($noms))
		{
		   	$nomsFormates = '';
	   		foreach ($noms as $nom)
	   		{
	   		   	if ($nomsFormates !== '')
					$nomsFormates .= ';';
			   	$nomsFormates .= $this->NomFormate($nom);
			}
	   	}
	   	return $nomsFormates;
	}

	// Initialisation des référentiels pour tous les éléments.
	protected function InitialiserReferentiels()
	{
	   	/*$mListe = new MListePrenoms();
		$this->AjouterReferentiel(PRENOM, $mListe);*/
	}

	// Initialisation des référentiels d'un élément en particulier.
	protected function InitialiserReferentielsElement($element)
	{
	   	/*$mListe = new MListePrenoms();
		$this->AjouterReferentielElement($element, PRENOM, $mListe);*/
	}

	// Initialisation des sous listes pour tous les éléments.
	protected function InitialiserListes()
	{
	   	/*$mListe = new MListePrenoms();
		$this->AjouterListe(PRENOM, $mListe);*/
	}

	// Initialisation des sous listes d'un élément en particulier.
	protected function InitialiserListesElement($element)
	{
	   	/*$mListe = new MListePrenoms();
		$this->AjouterListeElement($element, PRENOM, $mListe);*/
	}

	// Ajout d'un référentiel.
	protected function AjouterReferentiel($nom, MListeObjetsMetiers $mListe, $sauveCols = NULL, $dejaCharge = false)
	{
	   	$nomRef = $this->NomFormate($nom);
		$this->referentiels[$nomRef] = true;
	   	GReferentiel::AjouterReferentiel($this->NomRefFormate($nomRef), $mListe, $sauveCols, $dejaCharge);
	}

	// Ajout d'un référentiel pour un élément.
	protected function AjouterReferentielElement($element, $nom, MListeObjetsMetiers $mListe, $sauveCols = NULL, $dejaCharge = false)
	{
	   	$nomRef = $this->NomFormate($nom);
		$id = $element[LISTE_ELEMENT_ID];
		if (!array_key_exists($id, $this->referentielsElements))
			$this->referentielsElements[$id] = array();
		$this->referentielsElements[$id][$nomRef] = true;
	   	GReferentiel::AjouterReferentiel($this->NomRefFormate($nomRef).'_'.$id, $mListe, $sauveCols, $dejaCharge);
	}

	// Ajout d'un référentiel fichiers.
	protected function AjouterReferentielFichiers($nom, $chemin, $extensions)
	{
	   	$this->referentiels[$nom] = true;
	   	GReferentiel::AjouterReferentielFichiers($this->NomRefFormate($nom), $chemin, $extensions);
	}

	// Ajout d'une sous liste.
	protected function AjouterListe($nomChamp, MListeObjetsMetiers $mListe)
	{
	   	$nomRef = $this->NomFormate($nomChamp);
		$this->sousListes[$nomRef] = $mListe;
	}

	// Ajout d'une sous liste pour une élément.
	protected function AjouterListeElement($element, $nomChamp, MListeObjetsMetiers $mListe)
	{
	   	if ($mListe !== NULL)
	   	{
		   	$nomRef = $this->NomFormate($nomChamp);
		   	$id = $element[LISTE_ELEMENT_ID];
			if (!array_key_exists($id, $this->sousListesElements))
				$this->sousListesElements[$id] = array();
			$this->sousListesElements[$id][$nomRef] = $mListe;
		}
	}

	// Mise à jour d'un référentiel fichier pour un inputSelect.
	protected function GetDifferentielReferentielFichiersForSelect($nom)
	{
	   	GReferentiel::GetDifferentielReferentielFichiersForSelect($this->NomRefFormate($nom));
	}

	// Mise à jour d'un référentiel fichier pour un inputSelect pour un élément.
	protected function GetDifferentielReferentielFichiersForSelectElement($element, $nom)
	{
	   	GReferentiel::GetDifferentielReferentielFichiersForSelect($this->NomRefFormate($nom).'_'.$element[LISTE_ELEMENT_ID]);
	}

	// Mise à jour d'un référentiel pour un inputSelect.
	protected function GetDifferentielReferentielForSelect($nom, $colId, $colLib, $colDesc)
	{
	   	GReferentiel::GetDifferentielReferentielForSelect($this->NomRefFormate($nom), $colId, $colLib, $colDesc);
	}

	// Mise à jour d'un référentiel pour un inputSelect pour un élément.
	protected function GetDifferentielReferentielForSelectElement($element, $nom, $colId, $colLib, $colDesc)
	{
	   	GReferentiel::GetDifferentielReferentielForSelect($this->NomRefFormate($nom).'_'.$element[LISTE_ELEMENT_ID], $colId, $colLib, $colDesc);
	}

	// Mise à jour d'une inputListe (sous liste).
	protected function GetDifferentielForListe($nomChamp)
	{
		//switch ($nomChamp)
		//{
		//	case ...:
	   	//		$mListe = $this->sousListes[$nomChamp];
	   	//		$sListe = new SListe($this->prefixIdClass, $this->NomListeFormate($nomChamp), $this->contexte);
	   	//		if ($mListe->ListeChargee() === false)
		//		   	$mListe->Charger();
	   	//		$sListe->InjecterListeObjetsMetiers($mListe, true);
	   	//		GContexte::AjouterListe($sListe);
	   	//		break;
	   	// 		...
	   	//}
	}

	// Mise à jour d'une inputListe (sous liste) pour un élément.
	protected function GetDifferentielForListeElement($element, $nomChamp)
	{
	   	//switch ($nomChamp)
		//{
		//	case ...:
	   	//		$dejaChargee = false;
	   	//		$id = $element[LISTE_ELEMENT_ID];
	   	//		$mListe = $this->sousListesElements[$id][$nomChamp];
	   	//		$sListe = new SListe($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_'.$id, $this->contexte);
	   	//		if ($mListe->ListeChargee() === false)
		//		   	$mListe->Charger();
	   	//		$sListe->InjecterListeObjetsMetiers($mListe, true);
	   	//		GContexte::AjouterListe($sListe);
		//		break;
		//	...
		//}
	}

	// Mise à jour d'une inputListe (sous liste) pour l'élément création.
	protected function GetDifferentielForListeElementCreation($nomChamp)
	{
	   	//switch ($nomChamp)
		//{
		//	case ...:
	   	//		$mListe = $this->sousListesElements[$id][$nomChamp];
	   	//		$sListe = new SListe($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_', $this->contexte);
	   	//		if ($mListe->ListeChargee() === false)
		//		   	$mListe->Charger();
	   	//		$sListe->InjecterListeObjetsMetiers($mListe, true);
	   	//		GContexte::AjouterListe($sListe);
		//		break;
		//	...
		//}
	}

	// Vérifie l'existence d'un référentiel.
	protected function HasReferentiel($nom)
	{
	   	return array_key_exists($nom, $this->referentiels);
	}

	// Vérifie l'existence d'un référentiel pour un élément.
	protected function HasReferentielElement($element, $nom)
	{
	   	return (array_key_exists($element[LISTE_ELEMENT_ID], $this->referentielsElements) && array_key_exists($nom, $this->referentielsElements[$element[LISTE_ELEMENT_ID]]));
	}

	// Vérifie l'existence d'une sous liste.
	protected function HasListe($nom)
	{
	   	return array_key_exists($nom, $this->sousListes);
	}

	// Vérifie l'existence d'une sous liste pour un élément.
	protected function HasListeElement($element, $nom)
	{
	   	return (array_key_exists($element[LISTE_ELEMENT_ID], $this->sousListesElements) && array_key_exists($nom, $this->sousListesElements[$element[LISTE_ELEMENT_ID]]));
	}

	// A implémenter selon le cas (dans les classes dérivées).
	// On peut décider de ne pas s'en servir et directement injecter une liste d'objets métiers
	// avec la fonction InjecterListeObjetsMetiers($mListeObjetsMetiers).
	public function AjouterElement(/* $id, $prenom, $nom, $textNom*/)
	{
		//$element = array();
		//$this->SetElemValeurChamp($element, ID, $id);
		//$this->SetElemValeurChamp($element, PRENOM, $prenom);
		//$this->SetElemValeurChamp($element, NOM, $nom, $textNom);
		//...
		//$this->elements[] = $element;
	}

	// Permet de récupérer les informations d'une liste d'objets métiers:
	// - informations sur les champs (obligatoire, taille min/max, regexp, ...),
	// - liste des éléments à afficher.
	public function InjecterListeObjetsMetiers(MListeObjetsMetiers $mListeObjetsMetiers, $dejaChargee = false)
	{
	   	// Si on est dans le cas d'un changement de page, on vérifie que c'est bien cette liste qui est visée.
	   	if (self::$changementPage !== NULL && self::$changementPage !== '')
	   	{
		    if (array_key_exists($this->TypeSynchro(), self::$changementPage) && array_key_exists($this->numero, self::$changementPage[$this->TypeSynchro()]))
			{
			   	// Si on change effectivement de page.
			   	if ($this->numPageCourante != self::$changementPage[$this->TypeSynchro()][$this->numero] && $this->statique !== true)
				{
				   	$this->numPageCourante = self::$changementPage[$this->TypeSynchro()][$this->numero];
				   	GContexte::ListePageCourante($this->contexte, $this->TypeSynchro(), $this->numero, $this->numPageCourante);
			   		GContexte::ListeActive($this->contexte, $this->AncienTypeSynchroPage(), true);
				}
			   	else
			   	   	$this->chargement = false;
			}
		    else
		       	$this->chargement = false;
		}
		// Si on est dans le cas d'un chargement d'étage, on vérifie que c'est bien cette liste qui est visée.
		else if (self::$chargementEtage !== NULL && self::$chargementEtage !== '')
			$this->chargement = $this->ChargementEtageListeParente();
		// Si on est dans le cas d'un chargement d'étage, on vérifie que c'est bien cette liste qui est visée.
		else if (self::$chargementContenu !== NULL && self::$chargementContenu !== '')
			$this->chargement = $this->ChargementContenuListeParente();

		if ($this->chargement === true)
		{
		   	// Récupération des informations complémentaires sur les champs.
		   	// Pour que cela fonctionne, il faut que le nom du champ défini dans InitialisationChamps soit le même que
		   	// celui auquel il est lié dans l'objet métier de la liste.
		   	$mObjetMetier = $mListeObjetsMetiers->GetObjetMetierReference();
			foreach ($this->champs as $nomChamp => &$champ)
		   	{
			   	$noms = $nomChamp;
				if (strpos($nomChamp, ',') !== false)
			   	   	$noms = explode(',', $nomChamp);

			   	$nomPremChamp = $noms;
			   	if (is_array($noms))
			   		$nomPremChamp = $noms[0];

			   	if ($mObjetMetier->IsChampExiste($nomPremChamp) === true)
		   	   	{
			   	   	$champ[LISTE_CHAMPLISTE_MIN] = $mObjetMetier->GetChampMinFromTableau($noms);
			   	   	$champ[LISTE_CHAMPLISTE_MAX] = $mObjetMetier->GetChampMaxFromTableau($noms);
			   	   	$champ[LISTE_CHAMPLISTE_LONGUEURMIN] = $mObjetMetier->GetChampLongueurMinFromTableau($noms);
			   	   	$champ[LISTE_CHAMPLISTE_LONGUEURMAX] = $mObjetMetier->GetChampLongueurMaxFromTableau($noms);
			   	   	$champ[LISTE_CHAMPLISTE_REGEXP] = $mObjetMetier->GetChampRegExpFromTableau($noms);
			   	   	if ($champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] === NULL)
			   	   	   	$champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] = $mObjetMetier->GetChampValeurParDefautFromTableau($noms);
					$champ[LISTE_CHAMPLISTE_NONNUL] = $mObjetMetier->IsChampNonNulFromTableau($noms);
				}
		   	}

		   	// Récupération du nombre total d'éléments.
		   	if ($this->nbElementsTotal < 0 && $this->nbElementsParPage >= 1)
				$this->nbElementsTotal = $mListeObjetsMetiers->GetNbElementsFromBase();

			// On vérifie que le contenu de la liste n'a pas déjà été chargé par une autre liste de même type.
			$listeElem = NULL;
			if (array_key_exists($this->TypeSynchroPage(), self::$listeElemChargee))
			{
			   	$listeElem = self::$listeElemChargee[$this->TypeSynchroPage()];
				$dejaChargee = true;
			}

		   	if ($dejaChargee === false)
		   	{
		   	   	// Si le nombre total d'éléments est supérieur au nombre d'éléments qu'on affiche dans une page de la liste.
		   	   	if ($this->nbElementsParPage >= 1 && $this->nbElementsParPage < $this->nbElementsTotal)
		   	   	{
		   	   	   	// Si la liste est triable, on affiche l'élément de la page d'avant afin qu'on puisse faire changer l'élément de page.
		   	   	   	if ($this->triable === true && $this->numPageCourante >= 2)
		   	   		   	$mListeObjetsMetiers->Charger($this->nbElementsParPage + 1, (($this->numPageCourante - 1) * $this->nbElementsParPage) - 1);
		   	   		else
		   	   		   	$mListeObjetsMetiers->Charger($this->nbElementsParPage, ($this->numPageCourante - 1) * $this->nbElementsParPage);
		   		}
		   	   	else
		   		   	$mListeObjetsMetiers->Charger();

		   		// On enregistre le contenu de la liste dans une variable globale aux listes, notamment pour éviter
				// de recharger 2 fois le contenu pour 2 listes identiques.
		   		if (self::$listeElemChargee === NULL)
		   			self::$listeElemChargee = array();
		   		self::$listeElemChargee[$this->TypeSynchroPage()] = $mListeObjetsMetiers->GetListe();
		   	}

		   	if ($listeElem === NULL)
		   		$listeElem = $mListeObjetsMetiers->GetListe();

			// Récupération des éléments de la liste métier et injection dans la liste graphique.
		   	foreach ($listeElem as $mObjetMetier)
			{
			   	$element = array();
			   	foreach ($this->champs as $nomChamp => &$champ)
			   	{
			   	   	$noms = $nomChamp;
					if (strpos($nomChamp, ',') !== false)
			   	   		$noms = explode(',', $nomChamp);

				   	if ($mObjetMetier->IsChampExiste($noms) === true)
			   	   	{
						$champValeur = $mObjetMetier->GetChampSQLFromTableau($noms);
						$element[LISTE_ELEMENT_OBJET] = $mObjetMetier;

						if ($champValeur !== NULL)
							$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $champValeur;
						else
							$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $this->ChampValeurParDefaut($nomChamp);
					}
					else
					   	$this->SetElemValeurChampSpec($element, $nomChamp);
			   	}
			   	$this->elements[] = $element;
		   	}
		}
	}

	public function AjouterListeObjetsMetiersToExistante(MListeObjetsMetiers $mListeObjetsMetiers)
	{
	   	foreach ($this->listeContexte as $element)
	   	{
	   	   	$mListeObjetsMetiers->AjouterElementFromTableau($element[LISTE_CONTEXTE_CHAMPS], true, true);
		}

		$this->InjecterListeObjetsMetiers($mListeObjetsMetiers, true);
	}

	public function SupprimerListeObjetsMetiersFromExistante(MListeObjetsMetiers $mListeObjetsMetiers, $nomChampId = COL_ID)
	{
	   	//$listeIdSupp = $mListeObjetsMetiers->GetListeId();
	   	$listeIdSupp = $mListeObjetsMetiers->ExtraireChamp($nomChampId);
	   	foreach ($this->listeContexte as $element)
	   	{
	   	   	$mListeObjetsMetiers->AjouterElementFromTableau($element[LISTE_CONTEXTE_CHAMPS], true, true);
		}

		foreach ($listeIdSupp as $idSupp)
	   	{
	   	   	$mListeObjetsMetiers->SupprimerElement($idSupp, $nomChampId);
	   	}

		$this->InjecterListeObjetsMetiers($mListeObjetsMetiers, true);
	}

	// Un élément possède un ensemble de champs.
	protected function AjouterChamp($nom, $valeurParDefaut = NULL, $estId = false, $retourInvisible = false, $inputModifParDefaut = NULL, $inputCreatParDefaut = NULL, $info = NULL, $erreur = NULL, $autresDonnees = NULL, $enSession = true)
	{
		$champ[] = array();
		// Valeur par défaut du champ (Utilisé si pas de valeur ou pour les champs non éditables lors de la création).
		$champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] = $valeurParDefaut;
		// Est ce que le champ est l'identifiant unique pour l'élément.
		$champ[LISTE_CHAMPLISTE_ESTID] = $estId;
		// Est ce que le champ est invisible et doit être retourner en argument aux fonctions ajax.
		$champ[LISTE_CHAMPLISTE_RETOURINVISIBLE] = $retourInvisible;
		// Type de l'input par défaut du champ pour la modification d'un élément.
		$champ[LISTE_CHAMPLISTE_INPUTMODIFPARDEFAUT] = $inputModifParDefaut;
		// Type de l'input par défaut du champ pour la création d'un élément.
		$champ[LISTE_CHAMPLISTE_INPUTCREATPARDEFAUT] = $inputCreatParDefaut;
		// Message d'info qui pop sur les inputs du champ.
		$champ[LISTE_CHAMPLISTE_INFO] = $info;
		// Message d'erreur qui pop sur les inputs du champ.
		$champ[LISTE_CHAMPLISTE_ERREUR] = $erreur;
		// Autres données nécessaires à la description du champ.
		$champ[LISTE_CHAMPLISTE_AUTRESDONNEES] = $autresDonnees;
		// Doit on mettre la valeur du champ en session pour voir si changement lors d'un rechargement.
		$champ[LISTE_CHAMPLISTE_ENSESSION] = $enSession;

		// Si le nom du champ est un tableau, on le transforme en chaîne de caractères.
		$nomChamp = '';
		if (is_array($nom))
		{
			foreach ($nom as $nomCol)
			{
			   	if ($nomChamp !== '')
			   	   	$nomChamp .= ',';
			   	$nomChamp .= $nomCol;
			}
		}
		else
		   	$nomChamp = $nom;
		$this->champs[$nomChamp] = $champ;
	}

	// Remplissage des inputs de type select (select, file, image).
	public function RemplirSelect($element, $nomChamp, $select, $colId = NULL, $colLib = NULL, $colDesc = NULL)
	{
	   	$champ = $this->champs[$nomChamp];
	   	$nomRef = $this->NomRefFormate($nomChamp);
	   	if (($element !== NULL && $this->HasReferentielElement($element, $nomChamp)) || $champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTDEPENDANCE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
		{
		   	$id = '';
		   	if ($element !== NULL)
		   	   	$id = $element[LISTE_ELEMENT_ID];
		   	$nomRef .= '_'.$id;
		}

		switch ($nomChamp)
		{
			default:
			   	if ($colId !== NULL)
			   		$select->AjouterElementsFromListe($nomRef, $colId, $colLib, $colDesc);
			   	else
			   	   	$select->AjouterElementsFromListe($nomRef);
		}
	}

	// Remplissage des inputs de type select find.
	public function RemplirFind($element, $nomChamp, $select, $colId = NULL, $colLib = NULL, $colDesc = NULL)
	{
	   	$champ = $this->champs[$nomChamp];
	   	$nomRef = $this->NomRefFormate($nomChamp);
	   	if (($element !== NULL && $this->HasReferentielElement($element, $nomChamp)) || $champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTDEPENDANCE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
		{
		   	$id = '';
		   	if ($element !== NULL)
		   	   	$id = $element[LISTE_ELEMENT_ID];
		   	$nomRef .= '_'.$id;
		}

		switch ($nomChamp)
		{
			default:
			   	if ($colId !== NULL)
			   		$select->AjouterElementsFromListe($nomRef, $colId, $colLib, $colDesc);
			   	else
			   	   	$select->AjouterElementsFromListe($nomRef);
		}
	}

	// Remplissage des inputs de type liste.
	public function RemplirListe($element, $nomChamp, $liste)
	{
		/*switch ($nomChamp)
		{
			default:
		}*/
	}

	// Remplissage des inputs de type liste double.
	public function RemplirListeDouble($element, $nomChamp, $liste)
	{
		/*switch ($nomChamp)
		{
			default:
		}*/
	}

	// Récupération d'une sous-liste globale.
	public function GetSousListe($nomChamp)
	{
	   	$mListe = $this->sousListes[$nomChamp];
	   	if ($mListe->ListeChargee() === false)
			$mListe->Charger();
	   	if (array_key_exists($nomChamp, $this->sousListesListe))
	   	   	$mListe->SetListe($this->sousListesListe[$nomChamp]);
	   	$this->sousListesListe[$nomChamp] = $mListe->GetListe();
		return $mListe;
	}

	// Récupération d'une sous-liste d'un élément.
	public function GetSousListeElement($element, $nomChamp)
	{
	   	$id = $element[LISTE_ELEMENT_ID];
	   	$mListe = $this->sousListesElements[$id][$nomChamp];
	   	if ($mListe->ListeChargee() === false)
			$mListe->Charger();
		if (!array_key_exists($id, $this->sousListesElementsListe))
		   	$this->sousListesElementsListe[$id] = array();
	   	else if (array_key_exists($nomChamp, $this->sousListesElementsListe[$id]))
	   	   	$mListe->SetListe($this->sousListesElementsListe[$id][$nomChamp]);
	   	$this->sousListesElementsListe[$id][$nomChamp] = $mListe->GetListe();
		return $mListe;
	}

	// Récupération du type de synchro global de la liste.
	public function TypeSynchro()
	{
		return $this->typeSynchro;
	}

	// Récupération du type de synchro complet de la liste.
	public function TypeSynchroPage()
	{
	   	if ($this->nbElementsParPage <= 0)
	   		return $this->TypeSynchro();
		return $this->typeSynchro.'_p'.$this->numPageCourante;
	}

	// Récupération de l'ancien type de synchro complet de la liste.
	public function AncienTypeSynchroPage()
	{
	   	if ($this->nbElementsParPage <= 0)
	   		return $this->TypeSynchro();
		return $this->typeSynchro.'_p'.$this->numAnciennePage;
	}

	// Récupération du type de synchro abrégé.
	public function TypeSynchroAbrege()
	{
	   	$typeSynchro = $this->typeSynchro;
	   	$posT = strpos($typeSynchro, '-');
	   	$posU = strpos($typeSynchro, '_');

	   	if ($posT !== false || $posU !== false)
	   	{
			if ($posT === false)
				$typeSynchro = substr($typeSynchro, 0, $posU);
			else if ($posU === false)
			   	$typeSynchro = substr($typeSynchro, 0, $posT);
			else if ($posT <= $posU)
			   	$typeSynchro = substr($typeSynchro, 0, $posT);
			else
			   	$typeSynchro = substr($typeSynchro, 0, $posU);
		}

		return $typeSynchro;
	}

	// Récupération du fait que la page courante a changée.
	public function ChangementPage()
	{
		return ($this->numPageCourante !== $this->numAnciennePage);
	}

	// Récupération du nombre de pages.
	public function NbPages()
	{
	   	$nbPages = 1;
	   	if ($this->nbElementsTotal > 0 && $this->nbElementsParPage !== 0)
	   	{
			$nbPages = $this->nbElementsTotal / $this->nbElementsParPage;
			if ($nbPages > intval($nbPages))
				$nbPages = intval($nbPages) + 1;
			else
			   	$nbPages = intval($nbPages);
		}
		return $nbPages;
	}

	// Récupération du numéro de la liste.
	public function Numero()
	{
		return $this->numero;
	}

	// Rend la liste triable et/ou récupère le fait qu'elle le soit.
	public function Triable($typeLiaison = NULL, $foncAjaxTriCreation = '', $foncAjaxTriModification = AJAXFONC_MODIFIERDANSCONTEXTE, $foncAjaxTriSuppression = '')
	{
	   	if ($typeLiaison != NULL)
		{
	   		$this->triable = true;
	   		$this->typeLiaison = $typeLiaison;
	   		$this->foncAjaxTriCreation = $foncAjaxTriCreation;
			$this->foncAjaxTriModification = $foncAjaxTriModification;
			$this->foncAjaxTriSuppression = $foncAjaxTriSuppression;
	   	}
	   	return $this->triable;
	}

	// Récupération de la liste parente de la liste.
	public function &GetListeParente()
	{
		return $this->listeParente;
	}

	// Récupération de la liste parente de la liste.
	public function SetListeParente(SListe &$listeParente, $idListeParente = '')
	{
	   	$this->hasListeParente = true;
	   	$this->listeParente = $listeParente;
	   	$this->idListeParente = $idListeParente;
	   	$this->niveau = -1;
	}

	// Récupération du niveau de la liste.
	public function Niveau($niveau = -1)
	{
	   	if ($this->niveau === -1 || $niveau !== -1)
	   	{
			$niveau++;
			$listeParente = $this->GetListeParente();
			if ($listeParente !== NULL)
				$niveau = $listeParente->Niveau($niveau);
			$this->niveau = $niveau;
		}

		return $this->niveau;
	}

	// Récupération du préfixe des noms pour les référentiels.
	public function PrefixeNomFromParent()
	{
	   	$prefixe = $this->TypeSynchroAbrege();

		/*$listeParente = $this->GetListeParente();
		if ($listeParente !== NULL)
		   	$prefixe = $listeParente->PrefixeNomFromParent().$prefixe;*/

		return $prefixe;
	}

	// Récupération du suffixe des noms pour les référentiels.
	public function SuffixeNomFromParent()
	{
	   	$suffixe = '';
	   	if ($this->idListeParente !== '')
		{
		   	for ($i = 0; $i < $this->Niveau(); $i++)
		   	{
			   $suffixe .= '-';
			}
			$suffixe .= strval($this->idListeParente);
		}

		$listeParente = $this->GetListeParente();
		if ($listeParente !== NULL)
		   	$suffixe .= $listeParente->SuffixeNomFromParent();

		return $suffixe;
	}

	// Récupération du fait que la liste appartient ou pas à la liste qui effectue le chargement d'un étage.
	public function ChargementEtageListeParente()
	{
	   	$chargement = true;

	   	if ($this->hasListeParente === true)
	   	   	$chargement = $this->GetListeParente()->ChargementEtageListeParente();
		else if (!array_key_exists($this->TypeSynchro(), self::$chargementEtage) || !array_key_exists($this->numero, self::$chargementEtage[$this->TypeSynchro()]))
			$chargement = false;

		return $chargement;
	}

	// Récupération du fait que la liste appartient ou pas à la liste qui effectue le chargement d'un contenu.
	public function ChargementContenuListeParente()
	{
	   	$chargement = true;

	   	if ($this->hasListeParente === true)
	   	   	$chargement = $this->GetListeParente()->ChargementContenuListeParente();
		else if (!array_key_exists($this->TypeSynchro(), self::$chargementContenu) || !array_key_exists($this->numero, self::$chargementContenu[$this->TypeSynchro()]))
			$chargement = false;

		return $chargement;
	}

	// Récupération de la valeur par défaut pour le champ.
	protected function ChampValeurParDefaut($nomChamp)
	{
		return $this->champs[$nomChamp][LISTE_CHAMPLISTE_VALEURPARDEFAUT];
	}

	// Récupération du fait que le champ soit le champ identifiant ou non.
	protected function ChampEstId($nomChamp)
	{
		return $this->champs[$nomChamp][LISTE_CHAMPLISTE_ESTID];
	}

	// Récupération du type d'input par défaut pour le champ lors de la modification d'un élément.
	protected function InputModifParDefaut($nomChamp)
	{
		return $this->champs[$nomChamp][LISTE_CHAMPLISTE_INPUTMODIFPARDEFAUT];
	}

	// Récupération du type d'input par défaut pour le champ lors de la création d'un élément.
	protected function InputCreatParDefaut($nomChamp)
	{
		return $this->champs[$nomChamp][LISTE_CHAMPLISTE_INPUTCREATPARDEFAUT];
	}

	// Remplissage de la valeur d'un champ pour un élément.
	protected function SetElemValeurChamp(&$element, $nomChamp, $valeurConsultation = NULL, $valeurModification = NULL)
	{
	   	$element[$nomChamp] = array();

		if ($valeurConsultation !== NULL)
			$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $valeurConsultation;
		else
			$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $this->ChampValeurParDefaut($nomChamp);

		if ($valeurModification !== NULL)
			$element[$nomChamp][LISTE_ELEMENT_VALEURMODIF] = $valeurModification;
		else
			$element[$nomChamp][LISTE_ELEMENT_VALEURMODIF] = $this->ChampValeurParDefaut($nomChamp);
	}

	// Remplissage de la valeur d'un champ spécifique pour un élément.
	protected function SetElemValeurChampSpec(&$element, $nomChamp)
	{
	   	switch ($nomChamp)
	   	{
		   	/*case PRENOM:
		   	   	$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = 'Tom';
		   	   	break;
		   	...*/
		   	default:
		   	   	$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = NULL;
		}
	}

	// Récupération du fait qu'un étage a été chargé pour un élément.
	public function ElementEtageCharge($element, $etage, $charge = NULL)
	{
	   	return GContexte::ListeElementEtageCharge($this->contexte, $this->TypeSynchro(), $this->Numero(), $element[LISTE_ELEMENT_ID], $etage, $charge);
	}

	// Récupération de la liste des éléments.
	public function GetListeElements()
	{
	   	return $this->elements;
	}

	// Récupération de la liste des menus pour un élément.
	protected function GetElemListeMenus($element)
	{
	   	$menus = array();

	   	if ($this->HasDroitModification($element))
	   	{
	   	   	$this->AjouterMenuToListe($menus, 0, GSession::Libelle(LIB_LIS_MODIFIER, true, true), LISTE_JQFONCTION_MENUPOP.';'.LISTE_JQFONCTION_ETAGEGO, '1;2');
	   	   	$this->AjouterMenuToListe($menus, 1, GSession::Libelle(LIB_LIS_VALIDERMODIFICATION, true, true), $this->foncAjaxModification.';'.LISTE_JQFONCTION_MENUPOP.';'.LISTE_JQFONCTION_ETAGEGO, $element[LISTE_ELEMENT_RETOUR].';0;1', true, LISTE_JQCADRE_ETAGE.'2');
	   	   	$this->AjouterMenuToListe($menus, 1, GSession::Libelle(LIB_LIS_ANNULERMODIFICATION, true, true), LISTE_JQFONCTION_MENUPOP.';'.LISTE_JQFONCTION_ETAGEGO, '0;1');
	   	}
	   	if ($this->HasDroitSuppression($element))
	   	{
	   	   	$this->AjouterMenuToListe($menus, 0, GSession::Libelle(LIB_LIS_SUPPRIMER, true, true), LISTE_JQFONCTION_MENUPOP, 2);
	   	   	$this->AjouterMenuToListe($menus, 2, GSession::Libelle(LIB_LIS_VALIDERSUPPRESSION, true, true), $this->foncAjaxSuppression, $element[LISTE_ELEMENT_RETOUR], true);
	   	   	$this->AjouterMenuToListe($menus, 2, GSession::Libelle(LIB_LIS_ANNULERSUPPRESSION, true, true), LISTE_JQFONCTION_MENUPOP, 0);
	   	}

		return $menus;
	}

	// Récupération de la liste des menus pour l'élément création.
	protected function GetElemCreationListeMenus()
	{
	   	$menus = array();

	   	if ($this->HasDroitCreation())
	   	   	$this->AjouterMenuToListe($menus, 0, GSession::Libelle(LIB_LIS_CREER, true, true), $this->foncAjaxCreation, 'contexte='.$this->contexte, true, LISTE_JQCADRE_ETAGE.'1', true);

		return $menus;
	}

	// Récupération de la valeur d'un champ pour la consultation de l'élément.
	protected function GetElemChampValeurConsultation($element, $nomChamp, $formatage = false)
	{
	  	return $this->GetElemChampValeur($element, $nomChamp, LISTE_CHAMPTYPE_CONSULT, $formatage);
	}

	// Récupération de la valeur d'un champ pour la modification de l'élément.
	protected function GetElemChampValeurModification($element, $nomChamp, $formatage = false)
	{
	  	return $this->GetElemChampValeur($element, $nomChamp, LISTE_CHAMPTYPE_MODIF, $formatage);
	}

	// Récupération de la valeur d'un champ pour la création de l'élément.
	protected function GetElemChampValeurCreation($nomChamp)
	{
	  	return $this->GetElemChampValeur(NULL, $nomChamp, LISTE_CHAMPTYPE_CREAT);
	}

	// Récupération de la valeur d'un champ.
	protected function GetElemChampValeur($element, $nomChamp, $type, $formatage = false)
	{
	   	$valeur = NULL;
	   	$champ = $this->champs[$nomChamp];
	   	$id = '';
	   	if ($element !== NULL)
	   		$id = $element[LISTE_ELEMENT_ID];

	   	if ($type === LISTE_CHAMPTYPE_CONSULT && array_key_exists(LISTE_ELEMENT_VALEURCONSULT, $element[$nomChamp]))
	   	{
	   	   	if ($formatage === true && $champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPFORMATE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
			   	$valeur = $this->GetElemChampValeurFormatee($element, $nomChamp, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPFORMATE]);
			else if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPFORMATE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
			   	$valeur = $this->GetElemChampValeurFormatee($element, $nomChamp, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPFORMATE], false);
			else
	   	   	   	$valeur = $element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT];
	   	}
	   	else if ($type === LISTE_CHAMPTYPE_MODIF && array_key_exists(LISTE_ELEMENT_VALEURMODIF, $element[$nomChamp]))
	   	   	$valeur = $element[$nomChamp][LISTE_ELEMENT_VALEURMODIF];

	   	$inputParDefaut = NULL;
	   	if ($type === LISTE_CHAMPTYPE_MODIF)
	   		$inputParDefaut = $this->InputModifParDefaut($nomChamp);
	   	else if ($type === LISTE_CHAMPTYPE_CREAT)
	   		$inputParDefaut = $this->InputCreatParDefaut($nomChamp);

	   	// Si on est en mode chargement de la liste pour les parties modification et création.
	   	if ($valeur == NULL && $inputParDefaut !== NULL)
		{
		   	if (!array_key_exists(LISTE_CHAMPLISTE_INFO, $champ) || $champ[LISTE_CHAMPLISTE_INFO] === NULL)
	   			$champ[LISTE_CHAMPLISTE_INFO] = '';
	   		if (!array_key_exists(LISTE_CHAMPLISTE_ERREUR, $champ) || $champ[LISTE_CHAMPLISTE_ERREUR] === NULL)
	   			$champ[LISTE_CHAMPLISTE_ERREUR] = '';
	   		$niveau = $this->Niveau();

	   		$prefixIdClass = $this->prefixIdClass;
	   		if ($type === LISTE_CHAMPTYPE_CONSULT)
	   		{
	   		   	$niveau .= '_1';
	   		   	if (strpos($nomChamp, 'champ_') === false)
	   		   	   	$prefixIdClass .= '_'.$nomChamp;
	   		}
	   		else if ($type === LISTE_CHAMPTYPE_MODIF)
	   		{
	   		   	$niveau .= '_2';
	   		   	if (strpos($nomChamp, 'champ_') === false)
	   		   	   	$prefixIdClass .= '_'.$nomChamp;
	   		}
	   		else if ($type === LISTE_CHAMPTYPE_CREAT)
	   		{
	   		   	$niveau .= '_3';
	   		   	if (strpos($nomChamp, 'champ_') === false)
	   		   	   	$prefixIdClass .= '_'.$nomChamp;
	   		}

	   		switch ($inputParDefaut)
			{
			   	case LISTE_INPUTTYPE_SELECT:
			   	case LISTE_INPUTTYPE_FIND:
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_VALEURPARDEFAUT, $champ) || $champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] = '';
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_NONNUL, $champ) || $champ[LISTE_CHAMPLISTE_NONNUL] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_NONNUL] = false;
	   			   	$rechargeFonc = '';
	   			   	$rechargeParam = '';
	   			   	$type = '';
	   			   	if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTRECHARGEFONC, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$rechargeFonc = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTRECHARGEFONC];
	   			   	if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTRECHARGEPARAM, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$rechargeParam = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTRECHARGEPARAM];
					$dependance = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTDEPENDANCE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   	{
				   	   	$rechargeFonc = AJAXFONC_CHARGERREFERENTIELCONTEXTE;
				   		$rechargeParam = 'contexte='.$this->contexte;
				   		$type = $nomChamp;
				   		$dependance = $this->NomsListeChampsFormates($champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTDEPENDANCE]);
					}
					$impact = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTIMPACT, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   	{
						$impact = $this->NomsListeChampsFormates($champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTIMPACT]);
						$type = $nomChamp;
					}
					$colId = COL_ID;
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTCOLID, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$colId = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTCOLID];
					$colLib = array(COL_LIBELLE, COL_LIBELLE);
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTCOLLIB, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$colLib = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTCOLLIB];
	   			   	$colDesc = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTCOLDESC, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$colDesc = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTCOLDESC];
	   			 	$label = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPLABEL, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$label = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPLABEL];

	   			 	if ($inputParDefaut === LISTE_INPUTTYPE_SELECT)
					{
						$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, $champ[LISTE_CHAMPLISTE_NONNUL], GContexte::FormaterVariable($this->contexte, $nomChamp), $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], $type, $impact, $dependance, $rechargeFonc, $rechargeParam, '', '', $niveau);
						$this->RemplirSelect($element, $nomChamp, $select, $colId, $colLib, $colDesc);
						if ($label !== '')
							$valeur = new SInputLabel($this->prefixIdClass, $label, $select, INPUTLABELPLACE_GAUCHE, $champ[LISTE_CHAMPLISTE_NONNUL], false, $niveau, true);
						else
						   	$valeur = $select;
					}
					else
					{
					   	if ($rechargeFonc === '')
					   	{
					   		$rechargeFonc = AJAXFONC_CHARGERREFERENTIELCONTEXTE;
					   		$type = $nomChamp;
					   	}
				   		if ($rechargeParam === '')
						   	$rechargeParam = 'contexte='.$this->contexte;
					   	$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTEFIND, $champ[LISTE_CHAMPLISTE_NONNUL], GContexte::FormaterVariable($this->contexte, $nomChamp), $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], $type, $impact, $dependance, $rechargeFonc, $rechargeParam, '', '', $niveau);
						$this->RemplirFind($element, $nomChamp, $select, $colId, $colLib, $colDesc);
						if ($label !== '')
							$valeur = new SInputLabel($this->prefixIdClass, $label, $select, INPUTLABELPLACE_GAUCHE, $champ[LISTE_CHAMPLISTE_NONNUL], false, $niveau, true);
						else
						   	$valeur = $select;
					}
					break;
				case LISTE_INPUTTYPE_FILE:
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_VALEURPARDEFAUT, $champ) || $champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] = '';
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_NONNUL, $champ) || $champ[LISTE_CHAMPLISTE_NONNUL] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_NONNUL] = false;
	   			   	$label = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPLABEL, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$label = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPLABEL];
	   				$file = new SInputFile($this->prefixIdClass, INPUTFILE_TYPE_LISTEFICHIER, $champ[LISTE_CHAMPLISTE_NONNUL], GContexte::FormaterVariable($this->contexte, $nomChamp), '', '', '', $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], '', $this->contexte, $niveau);
					$this->RemplirSelect($element, $nomChamp, $file);
					if ($label !== '')
						$valeur = new SInputLabel($this->prefixIdClass, $label, $file, INPUTLABELPLACE_GAUCHE, $champ[LISTE_CHAMPLISTE_NONNUL], false, $niveau, true);
					else
					   	$valeur = $file;
	   			   	break;
	   			case LISTE_INPUTTYPE_IMAGE:
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_VALEURPARDEFAUT, $champ) || $champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] = '';
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_NONNUL, $champ) || $champ[LISTE_CHAMPLISTE_NONNUL] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_NONNUL] = false;
	   			   	$typeImage = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_IMAGETYPE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$typeImage = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_IMAGETYPE];
	   				$label = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPLABEL, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$label = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPLABEL];
					$image = new SInputImage($this->prefixIdClass, INPUTFILE_TYPE_LISTEIMAGE, $champ[LISTE_CHAMPLISTE_NONNUL], GContexte::FormaterVariable($this->contexte, $nomChamp), '', '', $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], $typeImage, $this->contexte, $niveau);
					$this->RemplirSelect($element, $nomChamp, $image);
					if ($label !== '')
						$valeur = new SInputLabel($this->prefixIdClass, $label, $image, INPUTLABELPLACE_GAUCHE, $champ[LISTE_CHAMPLISTE_NONNUL], false, $niveau, true);
					else
					   	$valeur = $image;
	   			   	break;
	   			case LISTE_INPUTTYPE_TEXT:
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_MIN, $champ) || $champ[LISTE_CHAMPLISTE_MIN] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_MIN] = NULL;
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_MAX, $champ) || $champ[LISTE_CHAMPLISTE_MAX] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_MAX] = NULL;
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_LONGUEURMIN, $champ) || $champ[LISTE_CHAMPLISTE_LONGUEURMIN] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_LONGUEURMIN] = NULL;
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_LONGUEURMAX, $champ) || $champ[LISTE_CHAMPLISTE_LONGUEURMAX] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_LONGUEURMAX] = NULL;
					$taille = $champ[LISTE_CHAMPLISTE_LONGUEURMAX];
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_TEXTTAILLE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
					   	$taille = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_TEXTTAILLE];
					if (!array_key_exists(LISTE_CHAMPLISTE_REGEXP, $champ) || $champ[LISTE_CHAMPLISTE_REGEXP] === NULL)
						$champ[LISTE_CHAMPLISTE_REGEXP] = '';
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_VALEURPARDEFAUT, $champ) || $champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] = '';
	   			   	if (!array_key_exists(LISTE_CHAMPLISTE_NONNUL, $champ) || $champ[LISTE_CHAMPLISTE_NONNUL] === NULL)
	   			   		$champ[LISTE_CHAMPLISTE_NONNUL] = false;
	   				$label = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPLABEL, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$label = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPLABEL];
					$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, $champ[LISTE_CHAMPLISTE_NONNUL], GContexte::FormaterVariable($this->contexte, $nomChamp), $champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT], $champ[LISTE_CHAMPLISTE_LONGUEURMIN], $champ[LISTE_CHAMPLISTE_LONGUEURMAX], $taille, true, '', $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], $champ[LISTE_CHAMPLISTE_REGEXP], $champ[LISTE_CHAMPLISTE_MIN], $champ[LISTE_CHAMPLISTE_MAX], $niveau);
	   				if ($label !== '')
						$valeur = new SInputLabel($this->prefixIdClass, $label, $text, INPUTLABELPLACE_GAUCHE, $champ[LISTE_CHAMPLISTE_NONNUL], false, $niveau, true);
					else
					   	$valeur = $text;
	   			   	break;
	   			case LISTE_INPUTTYPE_CHECKBOX:
	   			   	$valeurCheck = NULL;
	   			   	if ($element !== NULL)
	   			   	   	$valeurCheck = $this->GetElemChampValeurConsultation($element, $nomChamp);
	   			   	if ($valeurCheck === NULL && (!array_key_exists(LISTE_CHAMPLISTE_VALEURPARDEFAUT, $champ) || $champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT] === NULL))
	   			   		$valeurCheck = false;
	   			   	else if ($valeurCheck === NULL)
	   			   	   	$valeurCheck = $champ[LISTE_CHAMPLISTE_VALEURPARDEFAUT];
	   			   	$label = '';
					if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPLABEL, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
	   			   		$label = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPLABEL];
					$checkbox = new SInputCheckbox($this->prefixIdClass, INPUTCHECKBOX_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $nomChamp), $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], $niveau);
	   			   	$checkbox->AjouterCheckbox('', '', $valeurCheck);
					if ($label !== '')
						$valeur = new SInputLabel($this->prefixIdClass, $label, $checkbox, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true);
					else
					   	$valeur = $checkbox;
	   			   	break;
	   			case LISTE_INPUTTYPE_LISTE:
	   			   	$valeur = new SInputListe($this->prefixIdClass, INPUTLISTE_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $nomChamp), $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], $niveau);
	   			   	$this->RemplirListe($element, $nomChamp, $valeur);
					break;
	   			case LISTE_INPUTTYPE_LISTEDB:
	   			   	$valeur = new SInputListeDouble($this->prefixIdClass, INPUTLISTEDB_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $nomChamp), $champ[LISTE_CHAMPLISTE_INFO], $champ[LISTE_CHAMPLISTE_ERREUR], $niveau);
	   			   	$this->RemplirListeDouble($element, $nomChamp, $valeur);
	   			   	break;
			}
	   	}
	   	// Si on est en modification et qu'on n'a pas d'input, on prend la valeur de consultation.
	   	else if ($inputParDefaut === NULL && $type === LISTE_CHAMPTYPE_MODIF)
	   	{
	   	   	if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPFORMATE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
			   	$valeur = $this->GetElemChampValeurFormatee($element, $nomChamp, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_CHAMPFORMATE]);
			else
		       	$valeur = $element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT];
		}
	   	// Si on est en mode rechargement de la liste, on regarde s'il y a des référentiels ou des listes à recharger.
	   	else if ($this->rechargement === true && $type === LISTE_CHAMPTYPE_CONSULT)
		{
		   	$inputModif = $this->InputModifParDefaut($nomChamp);
		   	$inputCreat = $this->InputCreatParDefaut($nomChamp);

			if ($inputModif === LISTE_INPUTTYPE_SELECT || $inputCreat === LISTE_INPUTTYPE_SELECT)
		   	{
		   	   	$champ = $this->champs[$nomChamp];
			   	$nomRef = $nomChamp;
			   	//if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTDEPENDANCE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
		   		 //  	$nomRef .= '_'.$id;
				$colId = COL_ID;
				if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTCOLID, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
   			   		$colId = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTCOLID];
   				$colLib = array(COL_LIBELLE, COL_LIBELLE);
				if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTCOLLIB, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
   			   		$colLib = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTCOLLIB];
   			   	$colDesc = '';
				if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTCOLDESC, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
   			   		$colDesc = $champ[LISTE_CHAMPLISTE_AUTRESDONNEES][LISTE_AUTRESDONNEES_SELECTCOLDESC];

				// Rechargement des référentiels.
			  	if ($this->HasReferentiel($nomRef) === true)
			  	   	 $this->GetDifferentielReferentielForSelect($nomRef, $colId, $colLib, $colDesc);
			  	if ($this->HasReferentielElement($element, $nomRef) === true)
				   	 $this->GetDifferentielReferentielForSelectElement($element, $nomRef, $colId, $colLib, $colDesc);
		   	}

			// Si on est dans le cas d'une liste d'images ou de fichiers.
		   	if ($inputModif === LISTE_INPUTTYPE_FILE || $inputModif === LISTE_INPUTTYPE_IMAGE || $inputCreat === LISTE_INPUTTYPE_FILE || $inputCreat === LISTE_INPUTTYPE_IMAGE)
			{
			   	$champ = $this->champs[$nomChamp];
			   	$nomRef = $nomChamp;
			   	//if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_SELECTDEPENDANCE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
		   		  // 	$nomRef .= '_'.$id;
				// Rechargement des référentiels.
				if ($this->HasReferentiel($nomRef) === true)
					$this->GetDifferentielReferentielFichiersForSelect($nomRef);
				if ($this->HasReferentielElement($element, $nomRef) === true)
		   		   	$this->GetDifferentielReferentielFichiersForSelectElement($element, $nomRef);
		   	}

		   	// Si on est dans le cas d'une liste ou d'une liste double.
		   	if ($inputModif === LISTE_INPUTTYPE_LISTE || $inputModif === LISTE_INPUTTYPE_LISTEDB || $inputCreat === LISTE_INPUTTYPE_LISTE || $inputCreat === LISTE_INPUTTYPE_LISTEDB)
			{
			   	$champ = $this->champs[$nomChamp];
			   	$nomRef = $nomChamp;//.'_'.$id;

				// Rechargement des listes.
		   		if ($this->HasListe($nomRef) === true)
					$this->GetDifferentielForListe($nomRef);
				if ($this->HasListeElement($element, $nomRef) === true)
		   		   	$this->GetDifferentielForListeElement($element, $nomRef);
		   	}
		}

	   	return $valeur;
	}

	// Récupération de la valeur formatée d'un champ.
	protected function GetElemChampValeurFormatee($element, $nomChamp, $format, $affichage = true)
	{
	   	$valeur = $element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT];
	   	$valeur = GTexte::Formater($valeur, $format, $affichage);
	   	return $valeur;
	}

	public function AjouterMenuToListe(&$menus, $numMenu, $libelle, $fonction, $param = '', $ajax = false, $cadre = '', $reset = false)
	{
	   	if (!array_key_exists($numMenu, $menus))
	   	   	$menus[$numMenu] = array();
	   	$nbMenus = count($menus[$numMenu]);
	   	$menus[$numMenu][$nbMenus][LISTE_MENU_ELEMENT_LIB] = $libelle;
	   	$menus[$numMenu][$nbMenus][LISTE_MENU_ELEMENT_FONC] = $fonction;
	   	// On ajoute la clé de sécurité des formulaires.
		if ($ajax === true)
		{
	   		if ($param !== '')
	   			$param = '&'.$param;
	   		$param = 'cf='.GSession::NumCheckFormulaire().$param;
	   	}
	   	$menus[$numMenu][$nbMenus][LISTE_MENU_ELEMENT_PARAM] = $param;
	   	$menus[$numMenu][$nbMenus][LISTE_MENU_ELEMENT_CADRE] = $cadre;
	   	$menus[$numMenu][$nbMenus][LISTE_MENU_ELEMENT_AJAX] = $ajax;
	   	$menus[$numMenu][$nbMenus][LISTE_MENU_ELEMENT_RESET] = $reset;
	}

	// Gestion des droits de Consultation. Ce droit peut être spécifique à un élément.
	protected function HasDroitConsultation($element)
	{
		return true;
	}

	// Gestion des droits de Modification. Ce droit peut être spécifique à un élément.
	protected function HasDroitModification($element)
	{
		return false;
	}

	// Gestion des droits de Création. Ce droit n'est pas spécifique à un élément.
	protected function HasDroitCreation()
	{
		return false;
	}

	// Gestion des droits de Suppression. Ce droit peut être spécifique à un élément.
	protected function HasDroitSuppression($element)
	{
		return false;
	}

	// Construction de la ligne de titre de la liste (Noms des colonnes si la liste est organisée en tableau par exemple).
	protected function ConstruireLigneTitre()
	{
		$elem = new SElement($this->prefixIdClass.LISTECLASS_TITRE.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_TITRE.$this->Niveau());
		return $elem;
	}

	// Construction de la ligne de changement de page.
	protected function ConstruireChangementPage()
	{
	   	$elem = NULL;

	   	if ($this->nbElementsParPage >= 1)
		{
		   	$elem = new SElemOrg(1, 3, $this->prefixIdClass.LISTECLASS_BARDEF.$this->Niveau(), true, false, false);
		   	$elem->AjouterClasse(LISTECLASS_BARDEF.$this->Niveau());
		   	$elem->AddClass(LISTE_JQ_PAGE_NAVIGATEUR);
		   	$elem->AddStyle('display: none;');
		  	$elem->SetCelluleDominante(1, 2);

		   	// Indicateur première page.
			$elemPremPage = new SElement($this->prefixIdClass.LISTECLASS_BARDEF_PREMPAGE.$this->Niveau());
	   		$elemPremPage->AjouterClasse(LISTECLASS_BARDEF_PREMPAGE.$this->Niveau());
	   		$elemPremPage->AddClass(LISTE_JQ_PAGE_PREM);
	   		$elemPremPage->SetText('1');
	   		$elem->AttacherCellule(1, 1, $elemPremPage);

			// Barre de défilement indicateur de la page courante.
			$elemDef = new SElement($this->prefixIdClass.LISTECLASS_BARDEF_SCROLLBARRE.$this->Niveau());
			$elemDef->AjouterClasse(LISTECLASS_BARDEF_SCROLLBARRE.$this->Niveau());
			$elemDef->AddClass(LISTE_JQ_PAGE_BARREDEFILEMENT);
			$elemDefPrec = new SElement($this->prefixIdClass.LISTECLASS_BARDEF_PAGEPREC.$this->Niveau());
			$elemDefPrec->AjouterClasse(LISTECLASS_BARDEF_PAGEPREC.$this->Niveau());
			$elemDefPrec->AddClass(LISTE_JQ_PAGE_PREC);
			$elemDef->Attach($elemDefPrec);
			$divDefBarre = new SBalise(BAL_DIV);
			$divDefBarre->AddClass('jq_fill');
			$elemDefBarre = new SElement($this->prefixIdClass.LISTECLASS_BARDEF_BARRE.$this->Niveau());
			$elemDefBarre->AjouterClasse(LISTECLASS_BARDEF_BARRE.$this->Niveau());
			$elemDefBarre->AddClass(LISTE_JQ_PAGE_COURANTE);
			$elemDefBarre->SetText(strval($this->numPageCourante));
			$divDefBarre->Attach($elemDefBarre);
			$elemDef->Attach($divDefBarre);
			$elemDefSuiv = new SElement($this->prefixIdClass.LISTECLASS_BARDEF_PAGESUIV.$this->Niveau());
			$elemDefSuiv->AjouterClasse(LISTECLASS_BARDEF_PAGESUIV.$this->Niveau());
			$elemDefSuiv->AddClass(LISTE_JQ_PAGE_SUIV);
			$elemDef->Attach($elemDefSuiv);
			$elem->AttacherCellule(1, 2, $elemDef);

			// Indicateur dernière page.
			$elemDerPage = new SElement($this->prefixIdClass.LISTECLASS_BARDEF_DERPAGE.$this->Niveau());
	   		$elemDerPage->AjouterClasse(LISTECLASS_BARDEF_DERPAGE.$this->Niveau());
	   		$elemDerPage->AddClass(LISTE_JQ_PAGE_DER);
	   		$elemDerPage->SetText(strval($this->NbPages()));
	   		$elem->AttacherCellule(1, 3, $elemDerPage);
	   	}

	   	return $elem;
	}

	// Construction d'un élément de la ligne de titre.
	protected function ConstruireTitreElem($libelle)
	{
		$elem = new SElement($this->prefixIdClass.LISTECLASS_TITREELEM.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_TITREELEM.$this->Niveau());
	   	$elem->SetText($libelle);
		return $elem;
	}

	// Construction du menu déroulant d'un élément.
	protected function ConstruireElemMenus($element)
	{
	   	$divMenus = new SBalise(BAL_DIV);
	   	$divMenus->AddClass(LISTE_JQ_ELEMENT_MENUS);
	   	$divMenus->AddProp(PROP_STYLE, 'display:none');

	   	$menus = $this->GetElemListeMenus($element);
	   	foreach ($menus as $menu)
	   	{
	   	   	$divMenu = new SBalise(BAL_DIV);
	   	   	$divMenu->AddClass(LISTE_JQ_ELEMENT_MENU);
	   	   	$divMenus->Attach($divMenu);

	   	   	foreach ($menu as $menuElem)
	   	   	{
	   	   	   	$divMenuElem = new SBalise(BAL_DIV);
	   	   		$divMenuElem->AddClass(LISTE_JQ_ELEMENT_MENUELEM);
	   	   		$divMenu->Attach($divMenuElem);

	   	   		if ($menuElem[LISTE_MENU_ELEMENT_AJAX] === true)
	   	   		   	$divMenuElem->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONAJAX);

	   	   	   if ($menuElem[LISTE_MENU_ELEMENT_RESET] === true)
	   	   		   	$divMenuElem->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONRESET);

		   	   	$divMenuElemLib = new SBalise(BAL_DIV);
		   	   	$divMenuElemLib->AddClass(LISTE_JQ_ELEMENT_MENUELEM_LIB);
		   	   	$divMenuElemLib->SetText($menuElem[LISTE_MENU_ELEMENT_LIB]);
		   	   	$divMenuElem->Attach($divMenuElemLib);

		   	   	$divMenuElemFonc = new SBalise(BAL_DIV);
		   	   	$divMenuElemFonc->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONFONC);
		   	   	$divMenuElemFonc->SetText($menuElem[LISTE_MENU_ELEMENT_FONC]);
		   	   	$divMenuElem->Attach($divMenuElemFonc);

		   	   	$divMenuElemParam = new SBalise(BAL_DIV);
		   	   	$divMenuElemParam->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONPARAM);
		   	   	$divMenuElemParam->SetText(to_ajax(strval($menuElem[LISTE_MENU_ELEMENT_PARAM])));
		   	   	$divMenuElem->Attach($divMenuElemParam);

		   		$divMenuElemCadre = new SBalise(BAL_DIV);
		   	   	$divMenuElemCadre->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONCADRE);
		   	   	$divMenuElemCadre->SetText(strval($menuElem[LISTE_MENU_ELEMENT_CADRE]));
		   	   	$divMenuElem->Attach($divMenuElemCadre);
		   	}
		}

	   	return $divMenus;
	}

	// Construction des champs d'un élément.
	protected function ConstruireElemChamps(&$element)
	{
	   	$divChamps = new SBalise(BAL_DIV);
	   	$divChamps->AddClass(LISTE_JQ_ELEMENT_CHAMPS);

	   	// Premier chargement de la liste.
	   	if ($this->rechargement === false)
		  	  $this->ConstruireElemChampsPourCreation($element, $divChamps);
		// Rechargement.
		else
		{
		   	// Création.
		   	if (!array_key_exists($element[LISTE_ELEMENT_ID], $this->listeContexte) || !array_key_exists(LISTE_CONTEXTE_CHAMPS, $this->listeContexte[$element[LISTE_ELEMENT_ID]]))
			   	$this->ConstruireElemChampsPourCreation($element, $divChamps);
		   	// Modification.
			else
		  	   	$this->ConstruireElemChampsPourModification($element, $divChamps);

		   	// On enlève l'élément de la liste des éléments supprimés.
		   	unset($this->listeSuppressions[$element[LISTE_ELEMENT_ID]]);
		}

	   	return $divChamps;
	}

	// Construction des champs d'un élément qui n'existe pas encore dans la liste.
	protected function ConstruireElemChampsPourCreation(&$element, $divChamps)
	{
	   	$element[LISTE_ELEMENT_ACTION] = LISTE_ELEMACTION_CREAT;

	   	// On commence par les champs de modification.
	   	if ($this->chargementModifDiffere === false)
	   	{
	   	   	$this->ElementEtageCharge($element, LISTE_ETAGE_MODIF, true);
	   	   	$this->ConstruireElemEtageChampsPourCreation($element, $divChamps, LISTE_ETAGE_MODIF);
	   	}
	   	else
	   	   	$this->ElementEtageCharge($element, LISTE_ETAGE_MODIF, false);

		// On poursuit par les champs de consulation.
		$this->ElementEtageCharge($element, LISTE_ETAGE_CONSULT, true);
		$this->ConstruireElemEtageChampsPourCreation($element, $divChamps, LISTE_ETAGE_CONSULT);
	}

	// Construction des champs modifiés d'un élément qui existe déjà dans la liste.
	protected function ConstruireElemChampsPourModification(&$element, $divChamps)
	{
	   	$element[LISTE_ELEMENT_ACTION] = LISTE_ELEMACTION_MODIF;
	   	$forcageRechargement = false;

		// On commence par les champs de modification si on charge l'étage de modification.
		if (self::$chargementEtage !== NULL && self::$chargementEtage !== '')
	   	{
		    if (array_key_exists($this->TypeSynchro(), self::$chargementEtage)
		       	&& array_key_exists($this->numero, self::$chargementEtage[$this->TypeSynchro()])
			   	&& array_key_exists(intval(LISTE_ETAGE_MODIF), self::$chargementEtage[$this->TypeSynchro()][$this->numero]))
			{
			 	if (self::$chargementEtage[$this->TypeSynchro()][$this->numero][intval(LISTE_ETAGE_MODIF)] == $element[LISTE_ELEMENT_ID])
				{
				   	$element[LISTE_ELEMENT_MODIFIE] = true;
				   	$forcageRechargement = true;
				   	$this->ElementEtageCharge($element, LISTE_ETAGE_MODIF, true);
					$this->ConstruireElemEtageChampsPourCreation($element, $divChamps, LISTE_ETAGE_MODIF);
				}
			}
		}

		// On poursuit par les champs pour la mise à jour standard.
		$this->ConstruireElemEtageChampsPourModification($element, $divChamps, -1, $forcageRechargement);
	}

	// Construction des champs d'un élément qui n'existe pas encore dans la liste pour un étage donné.
	protected function ConstruireElemEtageChampsPourCreation(&$element, $divChamps, $etage)
	{
	   	switch ($etage)
		{
	   		case LISTE_ETAGE_CONSULT:
	   			foreach ($this->champs as $nomChamp => $champ)
			   	{
			   	   	$valeurConsult = $this->GetElemChampValeurConsultation($element, $nomChamp, true);

					// On met à jour le contexte de la liste pour le champ de l'élément.
					if (!array_key_exists($element[LISTE_ELEMENT_ID], $this->listeContexte))
						$this->listeContexte[$element[LISTE_ELEMENT_ID]] = array();
					if (!array_key_exists(LISTE_CONTEXTE_CHAMPS, $this->listeContexte[$element[LISTE_ELEMENT_ID]]))
					   	$this->listeContexte[$element[LISTE_ELEMENT_ID]][LISTE_CONTEXTE_CHAMPS] = array();

					if ($champ[LISTE_CHAMPLISTE_ENSESSION] === true)
					   	$this->listeContexte[$element[LISTE_ELEMENT_ID]][LISTE_CONTEXTE_CHAMPS][$nomChamp] = $valeurConsult;

					if ($valeurConsult !== NULL)
					{
				   	   	$divChamp = new SBalise(BAL_DIV);
				   	   	$divChamp->AddClass(LISTE_JQ_ELEMENT_CHAMP);
					   	$divChamps->Attach($divChamp);

				  	  	$divChampValeur = new SBalise(BAL_DIV);
				   	   	$divChampValeur->AddClass(LISTE_JQ_ELEMENT_CHAMP_VALEUR);
				   	   	$divChamp->Attach($divChampValeur);
					   	if (is_bool($valeurConsult))
						{
							$checkbox = new SInputCheckbox($this->prefixIdClass, INPUTCHECKBOX_TYPE_LISTE);
			   			   	$checkbox->AjouterCheckbox('', '', $valeurConsult);
			   			   	$divChampValeur->Attach($checkbox);
					   	}
					   	else if ($this->InputModifParDefaut($nomChamp) === LISTE_INPUTTYPE_IMAGE)
						{
						   	$divImg = new SBalise(BAL_DIV);
						   	$img = NULL;
							if ($valeurConsult === '')
						   		$img = new SImage('');
						   	else
						   	   	$img = new SImage($valeurConsult);
						   	$divImg->Attach($img);
					   		$divChampValeur->Attach($divImg);
					   	}
						else if (is_string($valeurConsult) || is_int($valeurConsult))
						    $divChampValeur->SetText(strval($valeurConsult));
						else if (is_array($valeurConsult))
						{
						   	foreach ($valeurConsult as $valeur)
			   			  	{
			   			  	   	$div = $valeur;
			   			  	   	if (is_string($valeur) || is_int($valeur))
			   			  	   	{
									$div = new SBalise(BAL_DIV);
			   			  	   		$div->SetText(strval($valeur));
			   			  	   	}
						   	   	$divChampValeur->Attach($div);
						   	}
						}
			   	   		else
			   	   		   	$divChampValeur->Attach($valeurConsult);

			   	   		$divChampNom = new SBalise(BAL_DIV);
				   	   	$divChampNom->AddClass(LISTE_JQ_ELEMENT_CHAMP_NOM);
				   	   	if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPFORMATE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
				   	   		$divChampNom->SetText($nomChamp.'_f');
				   	   	else
						   	$divChampNom->SetText($nomChamp);
				   	   	$divChamp->Attach($divChampNom);

				   	   	$divChampType = new SBalise(BAL_DIV);
				   	   	$divChampType->AddClass(LISTE_JQ_ELEMENT_CHAMP_TYPE);
				   	   	$divChampType->SetText(LISTE_CHAMPTYPE_CONSULT);
				   	   	$divChamp->Attach($divChampType);
			   	   	}
				}
	   			break;
	   		case LISTE_ETAGE_MODIF:
	   			foreach ($this->champs as $nomChamp => $champ)
			   	{
			   	   	$valeurModif = $this->GetElemChampValeurModification($element, $nomChamp);
			   	   	if ($valeurModif !== NULL)
					{
				   	   	$divChamp = new SBalise(BAL_DIV);
				   	   	$divChamp->AddClass(LISTE_JQ_ELEMENT_CHAMP);
					   	$divChamps->Attach($divChamp);

				  	  	$divChampValeur = new SBalise(BAL_DIV);
				   	   	$divChampValeur->AddClass(LISTE_JQ_ELEMENT_CHAMP_VALEUR);
				   	   	$divChamp->Attach($divChampValeur);
					   	if (is_string($valeurModif) || is_int($valeurModif))
						    $divChampValeur->SetText(strval($valeurModif));
			   	   		else
			   	   		   	$divChampValeur->Attach($valeurModif);

			   	   		$divChampNom = new SBalise(BAL_DIV);
				   	   	$divChampNom->AddClass(LISTE_JQ_ELEMENT_CHAMP_NOM);
				   	   	$divChampNom->SetText($nomChamp);
				   	   	$divChamp->Attach($divChampNom);

				   	   	$divChampType = new SBalise(BAL_DIV);
				   	   	$divChampType->AddClass(LISTE_JQ_ELEMENT_CHAMP_TYPE);
				   	   	$divChampType->SetText(LISTE_CHAMPTYPE_MODIF);
				   	   	$divChamp->Attach($divChampType);
			   	   	}
				};
	   			break;
	   	}
	}

	// Construction des champs modifiés d'un élément qui existe déjà dans la liste pour un étage donné.
	protected function ConstruireElemEtageChampsPourModification(&$element, $divChamps, $etage, $forcageRechargement = false)
	{
	   	switch ($etage)
		{
	   		default:
	   		   	foreach ($this->champs as $nomChamp => $champ)
			   	{
			   	   	if (array_key_exists($nomChamp, $this->listeContexte[$element[LISTE_ELEMENT_ID]][LISTE_CONTEXTE_CHAMPS]))
					{
					   	$valeurConsultContexte = NULL;
					   	if ($champ[LISTE_CHAMPLISTE_ENSESSION] === true)
				   	   	   	$valeurConsultContexte = $this->listeContexte[$element[LISTE_ELEMENT_ID]][LISTE_CONTEXTE_CHAMPS][$nomChamp];
				   	   	$valeurConsult = $this->GetElemChampValeurConsultation($element, $nomChamp);
				   	   	// Si la nouvelle valeur est différente de celle en session ou que la valeur n'existe pas en session.
				   	   	if ($valeurConsult !== NULL && (($valeurConsult != $valeurConsultContexte && $valeurConsultContexte !== NULL) || $valeurConsultContexte === NULL || $forcageRechargement === true))
						{
						   	// L'élément a été modifié.
						   	$element[LISTE_ELEMENT_MODIFIE] = true;

						   	// Mise à jour du contexte de la liste pour le champ de l'élément.
						   	if ($champ[LISTE_CHAMPLISTE_ENSESSION] === true)
						   	   	$this->listeContexte[$element[LISTE_ELEMENT_ID]][LISTE_CONTEXTE_CHAMPS][$nomChamp] = $valeurConsult;

					   	   	$divChamp = new SBalise(BAL_DIV);
					   	   	$divChamp->AddClass(LISTE_JQ_ELEMENT_CHAMP);
					   	   	$divChamps->Attach($divChamp);

					  	  	$divChampValeur = new SBalise(BAL_DIV);
					   	   	$divChampValeur->AddClass(LISTE_JQ_ELEMENT_CHAMP_VALEUR);
					   	   	$divChamp->Attach($divChampValeur);
					   	   	if ($this->InputModifParDefaut($nomChamp) === LISTE_INPUTTYPE_IMAGE)
					   		{
					   		   	if ($valeurConsult === '')
					   		   		$divChampValeur->SetText('');
					   		   	else
							   	   	$divChampValeur->SetText(PATH_SERVER_HTTP.$valeurConsult);
							}
						   	else if (is_string($valeurConsult))
							{
							   	// Cas où le champ est formaté, on doit mettre à jour le champ non formaté et le champ formaté.
							   	if ($champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPFORMATE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
							   	{
							   	   	$dChamp = new SBalise(BAL_DIV);
							   	   	$dChamp->AddClass(LISTE_JQ_ELEMENT_CHAMP);
							   	   	$divChamps->Attach($dChamp);

							  	  	$dChampValeur = new SBalise(BAL_DIV);
							   	   	$dChampValeur->AddClass(LISTE_JQ_ELEMENT_CHAMP_VALEUR);
							   	   	$dChamp->Attach($dChampValeur);
								   	$val = $this->GetElemChampValeurConsultation($element, $nomChamp, true);
									$dChampValeur->SetText($val);

									$dChampNom = new SBalise(BAL_DIV);
							   	   	$dChampNom->AddClass(LISTE_JQ_ELEMENT_CHAMP_NOM);
							   	   	$dChampNom->SetText($nomChamp.'_f');
							   	   	$dChamp->Attach($dChampNom);

							   	   	$dChampType = new SBalise(BAL_DIV);
							   	   	$dChampType->AddClass(LISTE_JQ_ELEMENT_CHAMP_TYPE);
							   	   	$dChampType->SetText(LISTE_CHAMPTYPE_CONSULT);
							   	   	$dChamp->Attach($dChampType);
								}
								$divChampValeur->SetText($valeurConsult);
							}
							else if (is_int($valeurConsult) || is_bool($valeurConsult))
						   	{
						   	   	if ($valeurConsult === true)
				   	   		   		$valeurConsult = '1';
				   	   		   	else if ($valeurConsult === false)
									$valeurConsult = '0';
							    $divChampValeur->SetText(strval($valeurConsult));
							}
							else if (is_array($valeurConsult))
							{
							   	foreach ($valeurConsult as $valeur)
				   			  	{
				   			  	   	$div = $valeur;
				   			  	   	if (is_string($valeur) || is_int($valeur))
				   			  	   	{
										$div = new SBalise(BAL_DIV);
				   			  	   		$div->SetText(strval($valeur));
				   			  	   	}
							   	   	$divChampValeur->Attach($div);
							   	}
							}
				   	   		else
				   	   		   	$divChampValeur->Attach($valeurConsult);

				   	   		$divChampNom = new SBalise(BAL_DIV);
					   	   	$divChampNom->AddClass(LISTE_JQ_ELEMENT_CHAMP_NOM);
					   	   	$divChampNom->SetText($nomChamp);
					   	   	$divChamp->Attach($divChampNom);

					   	   	$divChampType = new SBalise(BAL_DIV);
					   	   	$divChampType->AddClass(LISTE_JQ_ELEMENT_CHAMP_TYPE);
					   	   	$divChampType->SetText(LISTE_CHAMPTYPE_CONSULT);
					   	   	$divChamp->Attach($divChampType);
				   	   	}
				   	}
				}
				break;
	   	}
	}

	// Construction de l'élément en consultation.
	protected function ConstruireElemConsultation()
	{
	   	$elem = new SElement($this->prefixIdClass.LISTECLASS_ELEMCONSULT.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_ELEMCONSULT.$this->Niveau());
		return $elem;
	}

	// Construction de l'élément en modification.
	protected function ConstruireElemModification()
	{
		$elem = new SElement($this->prefixIdClass.LISTECLASS_ELEMMODIF.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_ELEMMODIF.$this->Niveau());
		return $elem;
	}

	// Construction de l'élément en création.
	protected function ConstruireElemCreation()
	{
		$elem = new SElement($this->prefixIdClass.LISTECLASS_ELEMCREAT.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_ELEMCREAT.$this->Niveau());
		return $elem;
	}

	// Construction d'un champ de l'élément.
	protected function ConstruireChamp($nom, $typeChamp = LISTE_CHAMPTYPE_CONSULT)
	{//echo '1';
		$elem = new SElement($this->prefixIdClass.LISTECLASS_ELEMCHAMP.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_ELEMCHAMP.$this->Niveau());
	   	$elem->AddClass(LISTE_JQ_ELEM_CHAMP);

	   	// Si le nom du champ est un tableau, on le transforme en chaîne de caractères.
		$nomChamp = '';
		if (is_array($nom))
		{
			foreach ($nom as $nomCol)
			{
			   	if ($nomChamp !== '')
			   	   	$nomChamp .= ',';
			   	$nomChamp .= $nomCol;
			}
		}
		else
		   	$nomChamp = $nom;

	   	if ($typeChamp === LISTE_CHAMPTYPE_CREAT)
		{
	   		$elemCreat = $this->GetElemChampValeurCreation($nomChamp);
	   		if ($elemCreat !== NULL)
	   			$elem->Attach($elemCreat);
	   	}
	   	else
	   	{
		   	$divChampNom = new SBalise(BAL_DIV);
	   	   	$divChampNom->AddClass(LISTE_JQ_ELEM_CHAMP_NOM);
	   	   	$champ = $this->champs[$nomChamp];
			if ($typeChamp === LISTE_CHAMPTYPE_CONSULT && $champ[LISTE_CHAMPLISTE_AUTRESDONNEES] !== NULL && array_key_exists(LISTE_AUTRESDONNEES_CHAMPFORMATE, $champ[LISTE_CHAMPLISTE_AUTRESDONNEES]))
			   	$divChampNom->SetText($nomChamp.'_f');
	   	   	else
			   	$divChampNom->SetText($nomChamp);
	   	   	$elem->Attach($divChampNom);

	   	   	$divChampType = new SBalise(BAL_DIV);
	   	   	$divChampType->AddClass(LISTE_JQ_ELEM_CHAMP_TYPE);
	   	   	$divChampType->SetText($typeChamp);
	   	   	$elem->Attach($divChampType);
	   	}

		return $elem;
	}

	// Construction du menu de l'élément.
	protected function ConstruireElemMenu()
	{
		$elem = new SElement($this->prefixIdClass.LISTECLASS_ELEMMENU.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_ELEMMENU.$this->Niveau());
	   	$elem->AddClass(LISTE_JQ_ELEM_MENU);

	   	$divMenu = new SBalise(BAL_DIV);
	   	$divMenu->AddClass(LISTE_JQ_ELEM_MENUELEM);
	   	$elem->Attach($divMenu);

		$elemMenu = new SElement($this->prefixIdClass.LISTECLASS_ELEMMENU_ELEM.$this->Niveau(), false);
	   	$elemMenu->AjouterClasse(LISTECLASS_ELEMMENU_ELEM.$this->Niveau());
	   	$elemMenu->AddClass(LISTE_JQ_ELEM_MENUELEM_BOUTON);
		$divMenu->Attach($elemMenu);

		return $elem;
	}

	// Construction du menu de l'élément création.
	protected function ConstruireElemCreationMenu()
	{
		$elemMenus = array();

	   	foreach ($this->GetElemCreationListeMenus() as $menu)
	   	{
	   	   	$elem = new SElement($this->prefixIdClass.LISTECLASS_ELEMMENU.$this->Niveau(), false);
	   		$elem->AjouterClasse(LISTECLASS_ELEMMENU.$this->Niveau());
	   		$elem->AddClass(LISTE_JQ_ELEM_MENU);
	   	   	$elemMenus[] = $elem;

	   	   	foreach ($menu as $menuElem)
	   	   	{
	   	   	   	$divMenuElem = new SBalise(BAL_DIV);
			   	$divMenuElem->AddClass(LISTE_JQ_ELEM_MENUELEM);
			   	$elem->Attach($divMenuElem);

	   	   		if ($menuElem[LISTE_MENU_ELEMENT_AJAX] === true)
	   	   		   	$divMenuElem->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONAJAX);

	   	   	   if ($menuElem[LISTE_MENU_ELEMENT_RESET] === true)
	   	   		   	$divMenuElem->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONRESET);

		   	   	$divMenuElemFonc = new SBalise(BAL_DIV);
		   	   	$divMenuElemFonc->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONFONC);
		   	   	$divMenuElemFonc->SetText($menuElem[LISTE_MENU_ELEMENT_FONC]);
		   	   	$divMenuElem->Attach($divMenuElemFonc);

		   	   	$divMenuElemParam = new SBalise(BAL_DIV);
		   	   	$divMenuElemParam->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONPARAM);
		   	   	$divMenuElemParam->SetText(to_ajax(strval($menuElem[LISTE_MENU_ELEMENT_PARAM])));
		   	   	$divMenuElem->Attach($divMenuElemParam);

		   		$divMenuElemCadre = new SBalise(BAL_DIV);
		   	   	$divMenuElemCadre->AddClass(LISTE_JQ_ELEMENT_MENUELEM_BOUTONCADRE);
		   	   	$divMenuElemCadre->SetText(strval($menuElem[LISTE_MENU_ELEMENT_CADRE]));
		   	   	$divMenuElem->Attach($divMenuElemCadre);

		   	   	$elemMenu = new SElement($this->prefixIdClass.LISTECLASS_ELEMMENU_ELEM.$this->Niveau(), false);
			   	$elemMenu->AjouterClasse(LISTECLASS_ELEMMENU_ELEM.$this->Niveau());
			   	$elemMenu->AddClass(LISTE_JQ_ELEM_MENUELEM_BOUTON);
			   	$elemMenu->SetText($menuElem[LISTE_MENU_ELEMENT_LIB]);
				$divMenuElem->Attach($elemMenu);
		   	}
		}

		return $elemMenus;
	}

	// Construction de la partie triable de la liste si elle l'est.
	protected function ConstruireListeTriable()
	{
	   	// Est ce que la liste est triable (drag and drop des éléments).
		if ($this->triable === true)
		{
			$this->AddClass(LISTE_JQ_SORTABLE);

			// Construction du type de la liste (utilisé pour les échanges d'éléments dans les listes triables).
			$divType = new SBalise(BAL_DIV);
			$divType->AddClass(LISTE_JQ_TYPE);
			$divType->SetText($this->typeLiaison);
			$divType->AddStyle('display: none;');
			$this->Attach($divType);

			// Construction du nombre d'éléments par page (pour le bon calcul de l'ordre lors des déplacements).
			$divNbElemParPage = new SBalise(BAL_DIV);
			$divNbElemParPage->AddClass(LISTE_JQ_NBELEMPARPAGE);
			$divNbElemParPage->SetText(strval($this->nbElementsParPage));
			$divNbElemParPage->AddStyle('display: none;');
			$this->Attach($divNbElemParPage);

			if ($this->foncAjaxTriModification !== '')
			{
				// Construction de la fonction appelée quand un élément est drag and dropé à l'intérieur de la liste.
				$divFoncInIn = new SBalise(BAL_DIV);
				$divFoncInIn->AddClass(LISTE_JQ_SORTABLE_FONCININ);
				$divFoncInIn->AddProp(PROP_STYLE, 'display:none');
				$divFoncInIn->SetText($this->foncAjaxTriModification);
				$this->Attach($divFoncInIn);
			}

			if ($this->foncAjaxTriCreation !== '')
			{
				// Construction de la fonction appelée quand un élément est drag and dropé de l'extérieur vers l'intérieur la liste.
				$divFoncOutIn = new SBalise(BAL_DIV);
				$divFoncOutIn->AddClass(LISTE_JQ_SORTABLE_FONCOUTIN);
				$divFoncOutIn->AddProp(PROP_STYLE, 'display:none');
				$divFoncOutIn->SetText($this->foncAjaxTriCreation);
				$this->Attach($divFoncOutIn);
			}

			if ($this->foncAjaxTriSuppression !== '')
			{
				// Construction de la fonction appelée quand un élément est drag and dropé de l'intérieur vers l'extérieur de la liste.
				$divFoncInOut = new SBalise(BAL_DIV);
				$divFoncInOut->AddClass(LISTE_JQ_SORTABLE_FONCINOUT);
				$divFoncInOut->AddProp(PROP_STYLE, 'display:none');
				$divFoncInOut->SetText($this->foncAjaxTriSuppression);
				$this->Attach($divFoncInOut);
			}
		}
	}

	// Construction de la partie triable de l'élément si la liste l'est.
	protected function ConstruireElemTriable($elem, $element)
	{
	   	// Est ce que la liste est triable (drag and drop des éléments).
		if ($this->triable === true)
		{
		   	$param = $element[LISTE_ELEMENT_RETOUR];
		   	if ($param !== '')
	   			$param = '&'.$param;
	   		$param = 'cf='.GSession::NumCheckFormulaire().$param;

			if ($this->foncAjaxTriModification !== '')
			{
				// Construction des paramètres de la fonction appelée quand un élément est drag and dropé à l'intérieur de la liste.
				$divParamInIn = new SBalise(BAL_DIV);
				$divParamInIn->AddClass(LISTE_JQ_SORTABLE_PARAMININ);
				$divParamInIn->AddProp(PROP_STYLE, 'display:none');
				$divParamInIn->SetText(to_ajax($param.'&'.$this->contexte.'[Ordre]='));
				$elem->Attach($divParamInIn);
			}

			if ($this->foncAjaxTriCreation !== '')
			{
				// Construction des paramètres de la fonction appelée quand un élément est drag and dropé de l'extérieur vers l'intérieur la liste.
				$divParamOutIn = new SBalise(BAL_DIV);
				$divParamOutIn->AddClass(LISTE_JQ_SORTABLE_PARAMOUTIN);
				$divParamOutIn->AddProp(PROP_STYLE, 'display:none');
				$divParamOutIn->SetText(to_ajax($param.'&'.$this->contexte.'[Ordre]='));
				$elem->Attach($divParamOutIn);
			}

			if ($this->foncAjaxTriSuppression !== '')
			{
				// Construction des paramètres de la fonction appelée quand un élément est drag and dropé de l'intérieur vers l'extérieur de la liste.
				$divParamInOut = new SBalise(BAL_DIV);
				$divParamInOut->AddClass(LISTE_JQ_SORTABLE_PARAMINOUT);
				$divParamInOut->AddProp(PROP_STYLE, 'display:none');
				$divParamInOut->SetText(to_ajax($param.'&'.$this->contexte.'[Ordre]='));
				$elem->Attach($divParamInOut);
			}
		}
	}

	// Construction des arguments invisibles de l'élément.
	protected function ConstruireElemRetourInvisible(&$element)
	{
	   	$retourInvisible = '';

	   	if ($this->contexte != '')
	   	   	$retourInvisible = 'contexte='.$this->contexte;

	   	foreach($this->champs as $nomChamp => $champ)
		{
	   		if ($champ[LISTE_CHAMPLISTE_RETOURINVISIBLE] === true)
			{
			   	if ($retourInvisible !== '')
			   		$retourInvisible .= '&';
			   	if ($this->contexte == '')
	   			   	$retourInvisible .= $nomChamp.'='.$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT];
	   			else
	   			   	$retourInvisible .= GContexte::FormaterVariable($this->contexte, $nomChamp).'='.$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT];
	   		}
	   	}

	   	// On enregistre ce retour pour l'élément.
	   	$element[LISTE_ELEMENT_RETOUR] = to_ajax($retourInvisible);

	   	$divRetInv = new SBalise(BAL_DIV);
	   	$divRetInv->AddClass(LISTE_JQ_ELEMENT_PARAM);
	   	$divRetInv->SetText($element[LISTE_ELEMENT_RETOUR]);
	   	return $divRetInv;
	}

	// Construction de l'id de l'élément.
	protected function ConstruireElemId(&$element)
	{
	   	$id = '';
	   	foreach($this->champs as $nomChamp => $champ)
		{
	   		if ($champ[LISTE_CHAMPLISTE_ESTID] === true)
			{
			   	if ($id !== '')
			   		$id .= '_';
	   			$id .= $element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT];
	   		}
	   	}

	   	// On enregistre l'id pour l'élément.
	   	$element[LISTE_ELEMENT_ID] = to_ajax(strval($id));

	   	$divId = new SBalise(BAL_DIV);
	   	$divId->AddClass(LISTE_JQ_ELEMENT_ID);
	   	$divId->SetText($element[LISTE_ELEMENT_ID]);
	   	$divId->AddProp(PROP_STYLE, 'display:none');
	   	return $divId;
	}

	// Construction de l'ordre de l'élément.
	protected function ConstruireElemOrdre(&$element, $ordre)
	{
	   	// On enregistre l'ordre pour l'élément.
	   	$element[LISTE_ELEMENT_ORDRE] = strval($ordre);

	   	if (!array_key_exists($element[LISTE_ELEMENT_ID], $this->listeContexte))
			$this->listeContexte[$element[LISTE_ELEMENT_ID]] = array();
	   	if (array_key_exists(LISTE_CONTEXTE_ORDRE, $this->listeContexte[$element[LISTE_ELEMENT_ID]]) && $ordre !== $this->listeContexte[$element[LISTE_ELEMENT_ID]][LISTE_CONTEXTE_ORDRE])
	   		$element[LISTE_ELEMENT_MODIFIE] = true;

		$this->listeContexte[$element[LISTE_ELEMENT_ID]][LISTE_CONTEXTE_ORDRE] = $ordre;

	   	$divOrdre = new SBalise(BAL_DIV);
	   	$divOrdre->AddClass(LISTE_JQ_ELEMENT_ORDRE);
	   	$divOrdre->SetText($element[LISTE_ELEMENT_ORDRE]);
	   	$divOrdre->AddProp(PROP_STYLE, 'display:none');
	   	return $divOrdre;
	}

	// Construction de la fonction déclenchée au clique de souris sur l'élément.
	protected function ConstruireElemFonctionJSOnClick($elem, $element)
	{
	   	if ($this->foncJsOnClick !== '')
		{
		   	$divFonc = new SBalise(BAL_DIV);
			$divFonc->AddClass(LISTE_JQ_ELEMENT_FONCTION);
			$divFonc->AddProp(PROP_STYLE, 'display:none');
			$divFonc->SetText(to_ajax($this->foncJsOnClick));
			$elem->Attach($divFonc);
	   	}
	}

	// Construction d'un élément avec vérification des droits.
	public function ConstruireElement(&$element, $ordre)
	{
		$elem = new SBalise(BAL_DIV);
		$elem->AddClass(LISTE_JQ_ELEMENT);

		$divId = $this->ConstruireElemId($element);
		$elem->Attach($divId);

		$divOrdre = $this->ConstruireElemOrdre($element, $ordre);
		$elem->Attach($divOrdre);

		// Initialisation des référentiels et listes de l'élément.
		$this->InitialiserReferentielsElement($element);
		$this->InitialiserListesElement($element);

		$divChamps = $this->ConstruireElemChamps($element);
		$elem->Attach($divChamps);

		if ($this->rechargement === false || $element[LISTE_ELEMENT_ACTION] === LISTE_ELEMACTION_CREAT)
		{
		   	// Construction de la fonction déclenchée au clique de souris sur l'élément.
		   	$this->ConstruireElemFonctionJSOnClick($elem, $element);

		   	$divRetInv = $this->ConstruireElemRetourInvisible($element);
			$elem->Attach($divRetInv);

			// Construction de la partie triable de l'élément si la liste l'est.
			$this->ConstruireElemTriable($elem, $element);

			$divMenus = $this->ConstruireElemMenus($element);
			$elem->Attach($divMenus);
		}

		$elem->AddProp(PROP_STYLE, 'display: none;');

		return $elem;
	}

	// Construction d'un élément qui permet de créer un nouvel élément dans la liste.
	public function ConstruireElementCreation()
	{
	   	$elem = NULL;

		// Création.
		$divCreat = new SBalise(BAL_DIV);
		$divCreat->AddClass(LISTE_JQ_ELEM_ETAGE);
		$elemCreat = $this->ConstruireElemCreation();
		if ($elemCreat !== NULL)
		{
		   	$divEtageCreat = new SBalise(BAL_DIV);
			$divEtageCreat->AddClass(LISTE_JQ_ELEM_ETAGE_NUM);
			$divEtageCreat->SetText('1');
			$divCreat->Attach($divEtageCreat);
			$divCreat->Attach($elemCreat);
		}

		// Menu.
		$divMenu = new SBalise(BAL_DIV);
		$divMenu->AddClass(LISTE_JQ_ELEM_MENUS);
		$divMenu->AddProp(PROP_STYLE, 'display: none;');
		foreach ($this->ConstruireElemCreationMenu() as $elemMenu)
		{
			$divMenu->Attach($elemMenu);
		}

		if ($elemCreat !== NULL)
		{
			$elem = new SElemOrg(1, 2, $this->prefixIdClass.LISTECLASS_ELEMENT.$this->Niveau(), true, false, false);
		   	$elem->AjouterClasse(LISTECLASS_ELEMENT.$this->Niveau());
		   	$elem->AddClass(LISTE_JQ_ELEMENTCREATION);
		   	$elem->AddProp(PROP_STYLE, 'display:none');
		   	$elem->SetCelluleDominante(1, 1);
		   	$elem->AttacherCellule(1, 1, $divCreat);
			$elem->AttacherCellule(1, 2, $divMenu);
		}
		else
		   	GLog::LeverException(EXS_0000, 'SListe::ConstruireElementCreation, la liste de type ['.$this->TypeSynchro().'] n\'a pas d\'élément création pour le contexte ['.$this->contexte.'].');

		return $elem;
	}

	// Construction d'un élément modèle à partir duquel vont être fabriqués tous les autres éléments (via le JS).
	public function ConstruireElementModele()
	{
	   	$elem = NULL;

		// Consultation.
		$divConsult = new SBalise(BAL_DIV);
		$divConsult->AddClass(LISTE_JQ_ELEM_ETAGE);
		$elemConsult = $this->ConstruireElemConsultation();
		if ($elemConsult !== NULL)
		{
		   	$divEtageConsult = new SBalise(BAL_DIV);
			$divEtageConsult->AddClass(LISTE_JQ_ELEM_ETAGE_NUM);
			$divEtageConsult->SetText('1');
			$divConsult->Attach($divEtageConsult);
			$divConsult->Attach($elemConsult);
		}

		// Modification.
	   	$divModif = new SBalise(BAL_DIV);
	   	$divModif->AddClass(LISTE_JQ_ELEM_ETAGE);
		$elemModif = $this->ConstruireElemModification();
		if ($elemModif !== NULL)
		{
			$divEtageModif = new SBalise(BAL_DIV);
			$divEtageModif->AddClass(LISTE_JQ_ELEM_ETAGE_NUM);
			$divEtageModif->SetText('2');
			$divModif->Attach($divEtageModif);

			if ($this->chargementModifDiffere === true)
			{
				// Construction de la fonction de chargement du contenu de l'étage.
			   	$divChargePageFonc = new SBalise(BAL_DIV);
			   	$divChargePageFonc->AddClass(LISTE_JQ_ELEM_ETAGE_CHARGEFONC);
			   	$divChargePageFonc->SetText($this->foncAjaxRechargement);
			   	$divModif->Attach($divChargePageFonc);
			   	$divChargePageFonc->AddProp(PROP_STYLE, 'display:none');

			   	// Construction des paramètres pour la fonction de chargement du contenu de l'étage.
			   	$divChargePageParam = new SBalise(BAL_DIV);
			   	$divChargePageParam->AddClass(LISTE_JQ_ELEM_ETAGE_CHARGEPARAM);
			   	$param = 'contexte='.$this->contexte.'&'.$this->contexte.'[etage]['.$this->TypeSynchro().']['.$this->Numero().'][2]';
			   	$divChargePageParam->SetText(to_ajax($param));
			   	$divModif->Attach($divChargePageParam);
			   	$divChargePageParam->AddProp(PROP_STYLE, 'display:none');
			}

			$divModif->Attach($elemModif);
		}

		// Menu.
		$divMenu = new SBalise(BAL_DIV);
		$divMenu->AddClass(LISTE_JQ_ELEM_MENUS);
		$divMenu->AddProp(PROP_STYLE, 'display: none;');
		$elemMenu = $this->ConstruireElemMenu();
		if ($elemMenu !== NULL)
			$divMenu->Attach($elemMenu);

		if ($elemConsult !== NULL && $elemModif !== NULL)
		{
			$elem = new SElemOrg(2, 2, $this->prefixIdClass.LISTECLASS_ELEMENT.$this->Niveau(), true, false, false);
		   	$elem->AjouterClasse(LISTECLASS_ELEMENT.$this->Niveau());
		   	$elem->AddClass(LISTE_JQ_ELEMENTMODELE);
		   	$elem->FusionnerCellule(1, 2, 1, 0);
		   	$elem->SetCelluleDominante(1, 1);
		   	$elem->AjouterPropCellule(1, 2, PROP_STYLE, 'display: none;');
		   	$elem->AttacherCellule(1, 1, $divConsult);
			$elem->AttacherCellule(2, 1, $divModif);
			$elem->AttacherCellule(1, 2, $divMenu);
		}
		else if ($elemConsult !== NULL)
		{
		   	$elem = new SElemOrg(1, 2, $this->prefixIdClass.LISTECLASS_ELEMENT.$this->Niveau(), true, false, false);
		   	$elem->AjouterClasse(LISTECLASS_ELEMENT.$this->Niveau());
		   	$elem->AddClass(LISTE_JQ_ELEMENTMODELE);
		   	$elem->SetCelluleDominante(1, 1);
		   	$elem->AjouterPropCellule(1, 2, PROP_STYLE, 'display: none;');
		   	$elem->AttacherCellule(1, 1, $divConsult);
		   	$elem->AttacherCellule(1, 2, $divMenu);
		}
		else if ($elemModif !== NULL)
		{
			$elem = new SElemOrg(1, 2, $this->prefixIdClass.LISTECLASS_ELEMENT.$this->Niveau(), true, false, false);
		   	$elem->AjouterClasse(LISTECLASS_ELEMENT.$this->Niveau());
		   	$elem->AddClass(LISTE_JQ_ELEMENTMODELE);
		   	$elem->SetCelluleDominante(1, 1);
		   	$elem->AjouterPropCellule(1, 2, PROP_STYLE, 'display: none;');
		   	$elem->AttacherCellule(1, 1, $divModif);
		   	$elem->AttacherCellule(1, 2, $divMenu);
		}
		else
		   	GLog::LeverException(EXS_0000, 'SListe::ConstruireElementModele, la liste de type ['.$this->TypeSynchro().'] n\'a pas d\'élément modèle pour le contexte ['.$this->contexte.'].');

		if ($elem !== NULL)
			$elem->AddProp(PROP_STYLE, 'visibility: hidden; height:0;');

		return $elem;
	}

	// Construction de la liste avec vérification des droits.
	protected function ConstruireListe()
	{
	   	$divElem = NULL;
	   	if ($this->rechargement === false)
		{
		   	$this->AjouterClasse($this->prefixIdClass.LISTECLASS.$this->Niveau(), false);
       		$this->AjouterClasse(LISTECLASS.$this->Niveau());

			// Construction de la partie triable de la liste si elle l'est.
			$this->ConstruireListeTriable();

			// Construction de la fonction appelée en cas de changement de page.
		   	$divChangePageFonc = new SBalise(BAL_DIV);
		   	$divChangePageFonc->AddClass(LISTE_JQ_PAGE_CHANGEFONC);
		   	$divChangePageFonc->SetText($this->foncAjaxRechargement);
		   	$divChangePageFonc->AddProp(PROP_STYLE, 'display: none;');
		   	$this->Attach($divChangePageFonc);

		   	// Construction des paramètres pour la fonction appelée en cas de changement de page.
		   	$divChangePageParam = new SBalise(BAL_DIV);
		   	$divChangePageParam->AddClass(LISTE_JQ_PAGE_CHANGEPARAM);
		   	$param = 'contexte='.$this->contexte.'&'.$this->contexte.'[page]['.$this->TypeSynchro().']['.$this->Numero().']';
		   	$divChangePageParam->SetText(to_ajax($param));
		   	$divChangePageParam->AddProp(PROP_STYLE, 'display: none;');
		   	$this->Attach($divChangePageParam);

		   	// Construction du type de synchronisation de la liste (utilisé pour recharger une liste via ajax).
		   	$divTypeSynchro = new SBalise(BAL_DIV);
		   	$divTypeSynchro->AddClass(LISTE_JQ_TYPESYNCHRO);
		   	$divTypeSynchro->SetText($this->TypeSynchroPage());
		   	$divTypeSynchro->AddProp(PROP_STYLE, 'display: none;');
		   	$this->Attach($divTypeSynchro);

		   	// Construction du numéro de la liste (utilisé pour recharger une liste unique via ajax).
		   	$divNumero = new SBalise(BAL_DIV);
		   	$divNumero->AddClass(LISTE_JQ_NUMERO);
		   	$divNumero->SetText(strval($this->Numero()));
		   	$divNumero->AddProp(PROP_STYLE, 'display: none;');
		   	$this->Attach($divNumero);

		   	// Construction du niveau de la liste (utilisé pour savoir si la liste est contenu dans une autre).
		   	$divNiveau = new SBalise(BAL_DIV);
		   	$divNiveau->AddClass(LISTE_JQ_NIVEAU);
		   	$divNiveau->SetText(strval($this->Niveau()));
		   	$divNiveau->AddProp(PROP_STYLE, 'display: none;');
		   	$this->Attach($divNiveau);

			// Construction de la ligne de titre.
			$ligneTitre = $this->ConstruireLigneTitre();
			if ($ligneTitre !== NULL)
			   	$this->Attach($ligneTitre);

			// Construction d'une ligne de changement de page.
			$changePage = $this->ConstruireChangementPage();
			if ($changePage !== NULL)
			   	$this->Attach($changePage);

			$divElem = new SBalise(BAL_DIV);
			$divElem->AddClass(LISTE_JQ_LISTE);
			if ($this->Triable())
				$divElem->AddClass($this->typeLiaison);
			$elemModele = $this->ConstruireElementModele();
			if ($elemModele !== NULL)
			   	$divElem->Attach($elemModele);
			$this->Attach($divElem);
		}

		// Construction des éléments de la liste.
		$ordre = 0;
		$poidsJavascriptMax = GSession::PoidsJavascriptMax();
		$noSupp = false;
		foreach ($this->elements as &$element)
		{
		   	if (GSession::PoidsJavascript() <= $poidsJavascriptMax)
			{
				$elem = $this->ConstruireElement($element, $ordre);
				if ($element[LISTE_ELEMENT_ACTION] == LISTE_ELEMACTION_CREAT)
				   	GSession::PoidsJavascript(8);
				else if ($element[LISTE_ELEMENT_ACTION] == LISTE_ELEMACTION_MODIF && array_key_exists(LISTE_ELEMENT_MODIFIE, $element) && $element[LISTE_ELEMENT_MODIFIE] === true)
				   	GSession::PoidsJavascript(2);

				if ($this->rechargement === false)
				   	$divElem->Attach($elem);
				else
				   	$element[LISTE_ELEMENT_CONTENU] = $elem;
				$ordre++;
			}
			else
			{
				$noSupp = true;
			   	GReponse::AjouterElementSuite($this->contexte);
			   	break;
			}
		}

		// Suppression des éléments qui ne font plus partie de la liste.
		if ($noSupp === false && $this->listeSuppressions !== NULL)
		{
			foreach ($this->listeSuppressions as $id => $elemSupp)
			{
			   	$elementSupp = array();
				$elementSupp[LISTE_ELEMENT_ID] = $id;
				$elementSupp[LISTE_ELEMENT_ACTION] = LISTE_ELEMACTION_SUPP;
				GSession::PoidsJavascript(1);
				$this->elements[] = $elementSupp;

				// Suppression du contexte.
				if (array_key_exists($id, $this->listeContexte))
				   	unset($this->listeContexte[$id]);
			}
		}

		if ($this->rechargement === false)
		{
		   	// Construction d'une ligne de changement de page.
			$changePage = $this->ConstruireChangementPage();
			if ($changePage !== NULL)
			   	$this->Attach($changePage);

			// Construction de l'élément de création.
			if ($this->HasDroitCreation())
			{
				$elemCreat = $this->ConstruireElementCreation();
				if ($elemCreat)
				{
				   	GSession::PoidsJavascript(8);
					$this->Attach($elemCreat);
				}
			}
		}
		else if ($this->HasDroitCreation())
		{
		   	// Rechargement des listes pour l'élément création.
		   	foreach ($this->champs as $nomChamp => $champ)
			{
			   	$this->GetDifferentielForListeElementCreation($nomChamp);
			}
		}

		// Sauvegarde de la liste dans le contexte.
		// Si on a changé de page, on supprime l'ancienne liste du contexte.
		GContexte::Liste($this->contexte, $this->TypeSynchroPage(), $this->listeContexte);
	}

	public function AppliquerStyleToListe($nomFichier, $presentation)
	{
	   	$this->nomFichierPresMod = $nomFichier;
	   	$this->presentation = $presentation;
	}

	public function AppliquerStyleToBaliseListe($balise)
	{
	   	$enfants = $balise->GetEnfants();
	   	foreach ($enfants as $enfant)
	   	{
	   	   	$style = '';
	   	   	$classes = $enfant->GetClass();
		   	foreach ($classes as $classe)
		   	{
			   	$style .= GCss::GetStyleCss($this->nomFichierPresMod, $this->presentation, $classe);
			}
			if ($style !== '')
			   	$enfant->AddStyle($style);
			$this->AppliquerStyleToBaliseListe($enfant);
			if ($enfant->HasClass(LISTE_JQ) === true)
			   	$enfant->AppliquerStyleToListe($this->nomFichierPresMod, $this->presentation);
		}
	}

	public function GetElementsPourRechargement()
	{
	   	if ($this->chargement === true)
	   	{
	   	   	GSession::PoidsJavascript(1);
			$this->rechargement = true;
		   	$this->ConstruireListe();
		   	return $this->elements;
		}
		return array();
	}

	public function BuildHTML()
	{
	   	if ($this->chargement === true)
	   	{
	   	   	$contexteCourant = GContexte::ContexteCourant();
	   	   	// Rétablissement du contexte de fabrication de la liste (pour le chargement des référentiels notamment).
	   	   	GContexte::ContexteCourant($this->contexte);
	   	   	GSession::PoidsJavascript(15);
		   	$this->listeContexte = array();
		   	$this->listeSuppressions = NULL;
			$this->ConstruireListe();
			if ($this->nomFichierPresMod !== '')
			   	$this->AppliquerStyleToBaliseListe($this);
			if ($this->statique !== true)
			   	GContexte::ListeActive($this->contexte, $this->TypeSynchroPage());
			return parent::BuildHTML();
			GContexte::ContexteCourant($contexteCourant);
		}
		return '';
	}
}

?>