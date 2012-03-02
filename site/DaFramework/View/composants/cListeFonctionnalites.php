<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_METIER.'mListeFonctionnalites.php';


class CListeFonctionnalites extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(array(COL_LIBELLE, COL_LIBELLE), '', false, true);
	}

	protected function HasDroitConsultation($element)
	{
		return true;
	}

	protected function HasDroitModification($element)
	{
		return false;
	}

	protected function HasDroitCreation()
	{
		return false;
	}

	protected function HasDroitSuppression($element)
	{
		return false;
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
}

?>