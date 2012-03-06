<?php

require_once 'cst.php';
require_once INC_SLISTETITRECONTENU;


class SListePliante extends SListeTitreContenu
{
   	// Construction de l'élément en consultation.
	protected function ConstruireElemConsultation($titre = '', $contenu = '', $deplie = true)
	{
	   	$org = new SOrganiseur(1, 2, true);
	   	if ($titre === '' || is_string($titre))
	   	{
	   	   	$elemTitreChamp = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->AjouterClasse(LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->SetText($titre);
	   		$org->AttacherCellule(1, 1, $elemTitreChamp);
	   	}
	   	else
	   	   	$org->AttacherCellule(1, 1, $titre);

	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$org->AjouterPropCellule(1, 2, PROP_STYLE, 'min-width: 20px');
	   	$org->AjouterClasseCellule(1, 2, LISTE_JQ_ELEM_INDIC);
	   	$elemIndic = new SElement($this->prefixIdClass.LISTECLASS_ELEMINDIC.$this->Niveau());
	   	$elemIndic->AjouterClasse(LISTECLASS_ELEMINDIC.$this->Niveau());

	   	if ($deplie === true)
	   	   	$elemIndic->SetText('-');
	   	else
	   	   	$elemIndic->SetText('+');
	   	$org->AttacherCellule(1, 2, $elemIndic);

	   	$elem = parent::ConstruireElemConsultation($org, $contenu);
	   	$elem->AddClass(LISTE_JQ_ELEM_PLIANT);
		return $elem;
	}

	// Construction de l'élément en modification.
	protected function ConstruireElemModification($titre = '', $contenu = '', $deplie = true)
	{
	   	$org = new SOrganiseur(1, 2, true);
	   	if ($titre === '' || is_string($titre))
	   	{
	   	   	$elemTitreChamp = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->AjouterClasse(LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->SetText($titre);
	   		$org->AttacherCellule(1, 1, $elemTitreChamp);
	   	}
	   	else
	   	   	$org->AttacherCellule(1, 1, $titre);

	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$org->AjouterPropCellule(1, 2, PROP_STYLE, 'min-width: 20px');
	   	$org->AjouterClasseCellule(1, 2, LISTE_JQ_ELEM_INDIC);
	   	$elemIndic = new SElement($this->prefixIdClass.LISTECLASS_ELEMINDIC.$this->Niveau());
	   	$elemIndic->AjouterClasse(LISTECLASS_ELEMINDIC.$this->Niveau());

	   	if ($deplie === true)
	   	   	$elemIndic->SetText('-');
	   	else
	   	   	$elemIndic->SetText('+');
	   	$org->AttacherCellule(1, 2, $elemIndic);

		$elem = parent::ConstruireElemModification($org, $contenu);
	   	$elem->AddClass(LISTE_JQ_ELEM_PLIANT);
		return $elem;
	}

	// Construction de l'élément en création.
	protected function ConstruireElemCreation($titre = '', $contenu = '', $deplie = true)
	{
	   	$org = new SOrganiseur(1, 2, true);
	   	if ($titre === '' || is_string($titre))
	   	{
	   	   	$elemTitreChamp = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->AjouterClasse(LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->SetText($titre);
	   		$org->AttacherCellule(1, 1, $elemTitreChamp);
	   	}
	   	else
	   	   	$org->AttacherCellule(1, 1, $titre);

	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$org->AjouterPropCellule(1, 2, PROP_STYLE, 'min-width: 20px');
	   	$org->AjouterClasseCellule(1, 2, LISTE_JQ_ELEM_INDIC);
	   	$elemIndic = new SElement($this->prefixIdClass.LISTECLASS_ELEMINDIC.$this->Niveau());
	   	$elemIndic->AjouterClasse(LISTECLASS_ELEMINDIC.$this->Niveau());

	   	if ($deplie === true)
	   	   	$elemIndic->SetText('-');
	   	else
	   	   	$elemIndic->SetText('+');
	   	$org->AttacherCellule(1, 2, $elemIndic);

		$elem = parent::ConstruireElemCreation($org, $contenu);
	   	$elem->AddClass(LISTE_JQ_ELEM_PLIANT);
		return $elem;
	}
}

?>