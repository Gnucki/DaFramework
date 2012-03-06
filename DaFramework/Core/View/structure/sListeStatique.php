<?php

require_once 'cst.php';
require_once INC_SLISTE;


class SListeStatique extends SListe
{
    public function __construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage = 20, $nbElementsTotal = -1, $triable = false, $typeLiaison = '', $chargementModifDiffere = true, $foncJsOnClick = '', $foncAjaxTriCreation = '', $foncAjaxTriModification = AJAXFONC_MODIFIERDANSCONTEXTE, $foncAjaxTriSuppression = '', $foncAjaxCreation = AJAXFONC_AJOUTERAUCONTEXTE, $foncAjaxModification = AJAXFONC_MODIFIERDANSCONTEXTE, $foncAjaxSuppression = AJAXFONC_SUPPRIMERDUCONTEXTE, $foncAjaxRechargement = AJAXFONC_RECHARGER)
    {
       	$this->statique = true;
       	parent::__construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage, $nbElementsTotal, $triable, $typeLiaison, $chargementModifDiffere, $foncJsOnClick, $foncAjaxTriCreation, $foncAjaxTriModification, $foncAjaxTriSuppression, $foncAjaxCreation, $foncAjaxModification, $foncAjaxSuppression, $foncAjaxRechargement);
		$this->AddClass(LISTE_JQ_STATIQUE);
	}

	// Construction de l'élément en consultation.
	protected function ConstruireElemConsultation(&$element)
	{
	   	$elem = new SElement($this->prefixIdClass.LISTECLASS_ELEMCONSULT.$this->Niveau(), false);
	   	$elem->AjouterClasse(LISTECLASS_ELEMCONSULT.$this->Niveau());
		return $elem;
	}

	// Construction de l'id de l'élément.
	protected function ConstruireElemId(&$element)
	{
	   	$divId = new SBalise(BAL_DIV);
	   	$divId->AddClass(LISTE_JQ_ELEMENT_ID);
	   	$divId->SetText($element[LISTE_ELEMENT_ID]);
	   	$divId->AddProp(PROP_STYLE, 'display:none');
	   	return $divId;
	}

	// Construction d'un élément modèle à partir duquel vont être fabriqués tous les autres éléments (via le JS).
	public function ConstruireElement(&$element)
	{
	   	$elem = NULL;

		// Consultation.
		$divConsult = new SBalise(BAL_DIV);
		$divConsult->AddClass(LISTE_JQ_ELEM_ETAGE);
		$elemConsult = $this->ConstruireElemConsultation($element);
		if ($elemConsult !== NULL)
		   	$divConsult->Attach($elemConsult);

		// Menu.
		/*$divMenu = new SBalise(BAL_DIV);
		$divMenu->AddClass(LISTE_JQ_ELEM_MENUS);
		$divMenu->AddProp(PROP_STYLE, 'display: none;');
		$elemMenu = $this->ConstruireElemMenu();
		if ($elemMenu !== NULL)
			$divMenu->Attach($elemMenu);*/

		$elem = new SElemOrg(1, 1, $this->prefixIdClass.LISTECLASS_ELEMENT.$this->Niveau(), true, false, false);
		$elem->AjouterClasse(LISTECLASS_ELEMENT.$this->Niveau());
		$elem->AddClass(LISTE_JQ_ELEM);
		//$elem->SetCelluleDominante(1, 1);
		$elem->AttacherCellule(1, 1, $divConsult);
		//$elem->AttacherCellule(1, 2, $divMenu);

		$divId = $this->ConstruireElemId($element);
		$elem->Attach($divId);

		//if ($elem !== NULL)
		//	$elem->AddProp(PROP_STYLE, 'visibility: hidden; height:0;');

		return $elem;
	}

	// Construction de la liste avec vérification des droits.
	protected function ConstruireListe()
	{
	   	$this->AjouterClasse($this->prefixIdClass.LISTECLASS.$this->Niveau(), false);
   		$this->AjouterClasse(LISTECLASS.$this->Niveau());
   		$this->AddClass(LISTE_JQ);

		/*// Construction de la fonction appelée en cas de changement de page.
	   	$divChangePageFonc = new SBalise(BAL_DIV);
	   	$divChangePageFonc->AddClass(LISTE_JQ_PAGE_CHANGEFONC);
	   	$divChangePageFonc->SetText($this->foncAjaxRechargement);
	   	$divChangePageFonc->AddProp(PROP_STYLE, 'display:none');
	   	$this->Attach($divChangePageFonc);

	   	// Construction des paramètres pour la fonction appelée en cas de changement de page.
	   	$divChangePageParam = new SBalise(BAL_DIV);
	   	$divChangePageParam->AddClass(LISTE_JQ_PAGE_CHANGEPARAM);
	   	$param = 'contexte='.$this->contexte.'&'.$this->contexte.'[page]['.$this->TypeSynchro().']['.$this->Numero().']';
	   	$divChangePageParam->SetText(to_html($param));
	   	$divChangePageParam->AddProp(PROP_STYLE, 'display:none');
	   	$this->Attach($divChangePageParam);*/

	   	// Construction du type de synchronisation de la liste (utilisé pour recharger une liste via ajax).
	   	$divTypeSynchro = new SBalise(BAL_DIV);
	   	$divTypeSynchro->AddClass(LISTE_JQ_TYPESYNCHRO);
	   	$divTypeSynchro->SetText($this->TypeSynchroPage());
	   	$divTypeSynchro->AddProp(PROP_STYLE, 'display:none');
	   	$this->Attach($divTypeSynchro);

	   	// Construction du numéro de la liste (utilisé pour recharger une liste unique via ajax).
	   	$divNumero = new SBalise(BAL_DIV);
	   	$divNumero->AddClass(LISTE_JQ_NUMERO);
	   	$divNumero->SetText(strval($this->Numero()));
	   	$divNumero->AddProp(PROP_STYLE, 'display:none');
	   	$this->Attach($divNumero);

	   	// Construction du niveau de la liste (utilisé pour savoir si la liste est contenu dans une autre).
	   	$divNiveau = new SBalise(BAL_DIV);
	   	$divNiveau->AddClass(LISTE_JQ_NIVEAU);
	   	$divNiveau->SetText(strval($this->Niveau()));
	   	$divNiveau->AddProp(PROP_STYLE, 'display:none');
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
		$this->Attach($divElem);

		// Construction des éléments de la liste.
		$poidsJavascriptMax = GSession::PoidsJavascriptMax();
		$noSupp = false;
		$id = 0;
		foreach ($this->elements as &$element)
		{
		   	$element[LISTE_ELEMENT_ID] = strval($id);
		   	$elem = $this->ConstruireElement($element);
			GSession::PoidsJavascript(1);
			$divElem->Attach($elem);
			$id++;
		}
	}

	public function GetElementsPourRechargement()
	{
		return array();
	}

	/*public function BuildHTML()
	{
	   	$contexteCourant = GContexte::ContexteCourant();
	   	// Rétablissement du contexte de fabrication de la liste (pour le chargement des référentiels notamment).
	   	GContexte::ContexteCourant($this->contexte);
	   	GSession::PoidsJavascript(10);
		$this->ConstruireListe();
		GContexte::ListeActive($this->contexte, $this->TypeSynchroPage());
		return SListe::BuildHTML();
		GContexte::ContexteCourant($contexteCourant);
	}*/
}

?>