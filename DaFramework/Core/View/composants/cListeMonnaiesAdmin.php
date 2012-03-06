<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeMonnaiesAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(COL_LIBELLE, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_SYMBOLE, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_ACTIVE, '', false, false, LISTE_INPUTTYPE_CHECKBOX, LISTE_INPUTTYPE_CHECKBOX);
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

	   	$org = new SOrganiseur(1, 3, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_SYMBOLE));
	   	$org->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_LIBELLE));
	   	$org->AttacherCellule(1, 3, $this->ConstruireTitreElem(COL_ACTIVE));
		$org->SetLargeurCellule(1, 1, '20%');
		$org->SetLargeurCellule(1, 2, '70%');
		$org->SetLargeurCellule(1, 3, '10%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 3, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_SYMBOLE));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_LIBELLE));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(COL_ACTIVE));
	   	$org->SetLargeurCellule(1, 1, '20%');
		$org->SetLargeurCellule(1, 2, '70%');
		$org->SetLargeurCellule(1, 3, '10%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(1, 3, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_SYMBOLE, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_LIBELLE, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(COL_ACTIVE, LISTE_CHAMPTYPE_MODIF));
	   	$org->SetLargeurCellule(1, 1, '20%');
	   	$org->SetLargeurCellule(1, 2, '70%');
	   	$org->SetLargeurCellule(1, 3, '10%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(1, 3, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_SYMBOLE, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_LIBELLE, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(COL_ACTIVE, LISTE_CHAMPTYPE_CREAT));
	   	$org->SetLargeurCellule(1, 1, '20%');
	   	$org->SetLargeurCellule(1, 2, '70%');
	   	$org->SetLargeurCellule(1, 3, '10%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>