<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeContextesAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(COL_NOM, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
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

	   	$org = new SOrganiseur(1, 1, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_NOM));
		$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 1, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_NOM));
	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(1, 1, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_MODIF));
	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(1, 1, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_CREAT));
	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>