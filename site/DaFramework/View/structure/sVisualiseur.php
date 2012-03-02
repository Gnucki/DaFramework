<?php

require_once 'cst.php';
require_once INC_SELEMORG;


define ('VISUALISEUR', '_visualiseur');
define ('VISUALISEUR_VUE', '_visualiseur_vue');
define ('VISUALISEUR_FORM', '_visualiseur_form');

define ('VISUALISEUR_JQ', 'jq_visualiseur');
define ('VISUALISEUR_JQ_VUE', 'jq_visualiseur_vue');
define ('VISUALISEUR_JQ_FORM', 'jq_visualiseur_form');
define ('VISUALISEUR_JQ_CLIGNOTEMENT', 'jq_visualiseur_clignotement');
define ('VISUALISEUR_JQ_CLIGNOTEMENT_INFO', 'jq_visualiseur_clignotement_info');
define ('VISUALISEUR_JQ_CLIGNOTEMENT_INFOPP', 'jq_visualiseur_clignotement_infopp');
define ('VISUALISEUR_JQ_CLIGNOTEMENT_INFOAP', 'jq_visualiseur_clignotement_infoap');


class SVisualiseur extends SElemOrg
{
   	protected $cadreVue;
   	protected $cadreForm;
   	protected $nomFichier;
   	protected $presentation;

    public function __construct($prefixIdClass = '', $vue = NULL, $form = NULL, $nomFichier = '', $presentation = '', $remplirParent = true)
    {
       	parent::__construct(2, 1, $prefixIdClass.VISUALISEUR, true, false, $remplirParent);
       	$this->AjouterClasse(VISUALISEUR);
       	$this->AddClass(VISUALISEUR_JQ);

       	$this->cadreVue = new SElement($prefixIdClass.VISUALISEUR_VUE);
       	$this->cadreVue->AjouterClasse(VISUALISEUR_VUE);
       	$this->cadreVue->AddClass(VISUALISEUR_JQ_VUE);
       	$this->AttacherCellule(1, 1, $this->cadreVue);

       	$this->cadreForm = new SElement($prefixIdClass.VISUALISEUR_FORM);
       	$this->cadreForm->AjouterClasse(VISUALISEUR_FORM);
       	$this->cadreForm->AddClass(VISUALISEUR_JQ_FORM);
       	$this->AttacherCellule(2, 1, $this->cadreForm);

		$this->nomFichier = $nomFichier;
		$this->presentation = $presentation;

       	if ($vue !== NULL)
       		$this->AjouterVue($vue);

       	if ($form !== NULL)
       		$this->AjouterForm($form);
	}

	public function AjouterVue($vue)
	{
	   	$this->cadreVue->Attach($vue);
	}

	public function AppliquerStyleToBalise($balise)
	{
	   	$enfants = $balise->GetEnfants();
	   	foreach ($enfants as $enfant)
	   	{
	   	   	$style = '';
	   	   	$classes = $enfant->GetClass();
		   	foreach ($classes as $classe)
		   	{
			   	$style .= GCss::GetStyleCss($this->nomFichier, $this->presentation, $classe);
			}
			if ($style !== '')
			   	$enfant->AddStyle($style);
			$this->AppliquerStyleToBalise($enfant);
			if ($enfant->HasClass(LISTE_JQ) === true)
			   	$enfant->AppliquerStyleToListe($this->nomFichier, $this->presentation);
		}
	}

	public function AjouterForm($form)
	{
	   	$this->cadreForm->Attach($form);
	}

	public function BuildHTML()
	{
	   	$this->AppliquerStyleToBalise($this->cadreVue);
	   	return parent::BuildHTML();
	}
}

?>