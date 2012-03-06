<?php

require_once 'cst.php';
require_once INC_SLISTEREFERENTIEL;
require_once PATH_METIER.'mListeServeurs.php';


class CListeJeuServeurs extends SListeReferentiel
{
	protected function InitialiserChamps()
	{
	   	//$this->AjouterChamp(COL_ID, '-1', true, true);
	   	//$this->AjouterChamp(array(COL_LIBELLE, COL_ID), '', true, true);
		$this->AjouterChamp(array(COL_LIBELLE, COL_LIBELLE), '', true, true, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
	}

	protected function ConstruireLigneTitre()
	{
		return NULL;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 1, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE)));
	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
	   	$elem = parent::ConstruireElemCreation();

	   	$org = new SOrganiseur(1, 1, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>