<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_METIER.'mListeTypesLibelles.php';


class CListeFonctionnalitesAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(array(COL_LIBELLE, COL_ID), '', false, true);
		$this->AjouterChamp(array(COL_LIBELLE, COL_LIBELLE), '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(array(COL_DESCRIPTION, COL_ID), '', false, true);
		$this->AjouterChamp(array(COL_DESCRIPTION, COL_LIBELLE), '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_PARAMETRABLE, '', false, false, LISTE_INPUTTYPE_CHECKBOX, LISTE_INPUTTYPE_CHECKBOX);
		$this->AjouterChamp(COL_NIVEAUGRADEMINIMUM, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
	}

	protected function HasDroitConsultation($element)
	{
		return GDroit::ADroit(DROIT_ADMIN);
	}

	protected function HasDroitModification($element)
	{
		return GDroit::ADroit(DROIT_ADMIN);
	}

	protected function HasDroitCreation()
	{
		return GDroit::ADroit(DROIT_ADMIN);
	}

	protected function HasDroitSuppression($element)
	{
		return GDroit::ADroit(DROIT_ADMIN);
	}

	protected function ConstruireLigneTitre()
	{
		$elem = parent::ConstruireLigneTitre();

	   	$org = new SOrganiseur(1, 5, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_ID));
	   	$org->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_LIBELLE));
	   	$org->AttacherCellule(1, 3, $this->ConstruireTitreElem(COL_DESCRIPTION));
	   	$org->AttacherCellule(1, 4, $this->ConstruireTitreElem(COL_NIVEAUGRADEMINIMUM));
	   	$org->AttacherCellule(1, 5, $this->ConstruireTitreElem(COL_PARAMETRABLE));
		$org->SetLargeurCellule(1, 1, '5%');
		$org->SetLargeurCellule(1, 2, '20%');
		$org->SetLargeurCellule(1, 3, '50%');
		$org->SetLargeurCellule(1, 4, '15%');
		$org->SetLargeurCellule(1, 5, '10%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 5, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE)));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_DESCRIPTION, COL_LIBELLE)));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAUGRADEMINIMUM));
	   	$org->AttacherCellule(1, 5, $this->ConstruireChamp(COL_PARAMETRABLE));
	   	$org->SetLargeurCellule(1, 1, '5%');
		$org->SetLargeurCellule(1, 2, '20%');
		$org->SetLargeurCellule(1, 3, '50%');
		$org->SetLargeurCellule(1, 4, '15%');
		$org->SetLargeurCellule(1, 5, '10%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(1, 5, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_DESCRIPTION, COL_LIBELLE), LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAUGRADEMINIMUM, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 5, $this->ConstruireChamp(COL_PARAMETRABLE, LISTE_CHAMPTYPE_MODIF));
		$org->SetLargeurCellule(1, 1, '5%');
		$org->SetLargeurCellule(1, 2, '20%');
		$org->SetLargeurCellule(1, 3, '50%');
		$org->SetLargeurCellule(1, 4, '15%');
		$org->SetLargeurCellule(1, 5, '10%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(1, 5, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_DESCRIPTION, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAUGRADEMINIMUM, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 5, $this->ConstruireChamp(COL_PARAMETRABLE, LISTE_CHAMPTYPE_CREAT));
		$org->SetLargeurCellule(1, 1, '5%');
		$org->SetLargeurCellule(1, 2, '20%');
		$org->SetLargeurCellule(1, 3, '50%');
		$org->SetLargeurCellule(1, 4, '15%');
		$org->SetLargeurCellule(1, 5, '10%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>