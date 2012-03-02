<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeForums extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
		$this->AjouterChamp(COL_NOM, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_DESCRIPTION, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
	}

	protected function InitialiserReferentiels()
	{
	   	//$this->AjouterReferentielFichiers(COL_ICONE, PATH_IMAGES.'Communaute/', REF_FICHIERSEXTENSIONS_IMAGES);
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

	   	$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_NOM));
	   	$org->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_DESCRIPTION));
		$org->SetLargeurCellule(1, 1, '30%');
		$org->SetLargeurCellule(1, 2, '70%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_NOM));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_DESCRIPTION));
		$org->SetLargeurCellule(1, 1, '30%');
		$org->SetLargeurCellule(1, 2, '70%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_DESCRIPTION, LISTE_CHAMPTYPE_MODIF));
		$org->SetLargeurCellule(1, 1, '30%');
		$org->SetLargeurCellule(1, 2, '70%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_DESCRIPTION, LISTE_CHAMPTYPE_CREAT));
		$org->SetLargeurCellule(1, 1, '30%');
		$org->SetLargeurCellule(1, 2, '70%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>