<?php

require_once 'cst.php';
require_once INC_SLISTESTATIQUE;
require_once INC_SLISTEPLIANTE;


class SListePlianteStatique extends SListeStatique
{
   	protected $chargementContenuDiffere;

   	public function __construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage = 20, $nbElementsTotal = -1, $chargementContenuDiffere = false)
    {
       	parent::__construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage, $nbElementsTotal, false, '', true, '', '', '', '', '', '', '', AJAXFONC_RECHARGER);

		$this->chargementContenuDiffere = $chargementContenuDiffere;
	}

   	// Construction de l'élément en consultation.
	protected function ConstruireElemConsultation(&$element, $titre = '', $contenu = '', $deplie = true)
	{
	   	$elem = parent::ConstruireElemConsultation($element);
	   	$elem->AddClass(LISTE_JQ_ELEM_PLIANT);

	   	$divTitre = new SBalise(BAL_DIV);
	   	$divTitre->AddClass(LISTE_JQ_ELEM_TITRE);
	   	$elemTitre = new SElemOrg(1, 2, $this->prefixIdClass.LISTECLASS_ELEMTITRE.$this->Niveau(), true);
	   	$elemTitre->AjouterClasse(LISTECLASS_ELEMTITRE.$this->Niveau());
		if ($titre === '')
	   		$titre = $this->ConstruireElemConsultationTitre($element);
		if (is_string($titre))
	   	{
	   	   	$elemTitreChamp = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->AjouterClasse(LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->SetText($titre);
	   		$elemTitre->AttacherCellule(1, 1, $elemTitreChamp);
	   	}
	   	else
	   	   	$elemTitre->AttacherCellule(1, 1, $titre);
	   	//$elemTitre->SetCelluleDominante(1, 1);
	   	$elemTitre->SetLargeurCellule(1, 1, '100%');
	   	$elemTitre->AjouterPropCellule(1, 2, PROP_STYLE, 'min-width: 20px');
	   	$elemTitre->AjouterClasseCellule(1, 2, LISTE_JQ_ELEM_INDIC);
	   	$elemIndic = new SElement($this->prefixIdClass.LISTECLASS_ELEMINDIC.$this->Niveau());
	   	$elemIndic->AjouterClasse(LISTECLASS_ELEMINDIC.$this->Niveau());
	   	//$elemIndic->AddClass(LISTE_JQ_ELEM_INDIC);
	   	if ($deplie === true)
	   	   	$elemIndic->SetText('-');
	   	else
	   	   	$elemIndic->SetText('+');
	   	$elemTitre->AttacherCellule(1, 2, $elemIndic);
		$divTitre->Attach($elemTitre);
		$elem->Attach($divTitre);

	   	$divContenu = new SBalise(BAL_DIV);
	   	$divContenu->AddClass(LISTE_JQ_ELEM_CONTENU);
		$elemContenu = new SElement($this->prefixIdClass.LISTECLASS_ELEMCONTENU.$this->Niveau(), false);
	   	$elemContenu->AjouterClasse(LISTECLASS_ELEMCONTENU.$this->Niveau());
	   	if ($this->chargementContenuDiffere === false)
		{
			if ($contenu === '')
		   		$contenu = $this->ConstruireElemConsultationContenu($element);
			if (is_string($contenu) || is_int($contenu))
		   		$elemContenu->SetText($contenu);
		   	else
		   	   	$elemContenu->Attach($contenu);
		}
		$divContenu->Attach($elemContenu);
		$elem->Attach($divContenu);

		if ($this->chargementContenuDiffere === true)
		{
		   	// Construction de la fonction appelée en cas de changement de page.
		   	$divChargeContenuFonc = new SBalise(BAL_DIV);
		   	$divChargeContenuFonc->AddClass(LISTE_JQ_ELEM_CONTENU_CHARGEFONC);
		   	$divChargeContenuFonc->SetText($this->foncAjaxRechargement);
		   	$divChargeContenuFonc->AddProp(PROP_STYLE, 'display:none');
		   	$elem->Attach($divChargeContenuFonc);

		   	// Construction des paramètres pour la fonction appelée en cas de changement de page.
		   	$divChargeContenuParam = new SBalise(BAL_DIV);
		   	$divChargeContenuParam->AddClass(LISTE_JQ_ELEM_CONTENU_CHARGEPARAM);
		   	$param = 'contexte='.$this->contexte.'&'.$this->contexte.'[contenu]['.$this->TypeSynchro().']['.$this->Numero().']';
		   	$divChargeContenuParam->SetText(to_html($param));
		   	$divChargeContenuParam->AddProp(PROP_STYLE, 'display:none');
		   	$elem->Attach($divChargeContenuParam);
		}

		return $elem;
	}

	// Construction du titre de l'élément pliant en consultation.
	protected function ConstruireElemConsultationTitre(&$element)
	{
	   	return '';
	}

	// Construction du contenu de l'élément pliant en consultation.
	protected function ConstruireElemConsultationContenu(&$element)
	{
	   	return '';
	}

	public function GetElementsPourRechargement()
	{
	   	if ($this->chargement === true && $this->chargementContenuDiffere === true)
	   	{
	   	   	if (self::$chargementContenu !== NULL && self::$chargementContenu !== '')
		   	{
			    if (array_key_exists($this->TypeSynchro(), self::$chargementContenu)
			       	&& array_key_exists($this->numero, self::$chargementContenu[$this->TypeSynchro()]))
				{
			   	   	$elements = array();
			   	   	$idElemCharge = self::$chargementContenu[$this->TypeSynchro()][$this->numero];
			   	   	$id = 0;
					foreach ($this->elements as &$element)
					{
					   	if ($idElemCharge == $id)
					   	{
						   	$element[LISTE_ELEMENT_ID] = $id;
						   	$element[LISTE_ELEMENT_ACTION] = LISTE_ELEMACTION_AJOUTCONTENU;
							$element[LISTE_ELEMENT_CONTENU] = $this->ConstruireElemConsultationContenu($element);
							$elements[] = $element;
						}
						$id++;
					}
					return $elements;
				}
			}
		}
		return array();
	}
}

?>