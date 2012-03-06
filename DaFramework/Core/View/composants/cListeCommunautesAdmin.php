<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeCommunautesAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(array(COL_LIBELLE, COL_ID), '', true, true);
		$this->AjouterChamp(array(COL_LIBELLE, COL_LIBELLE), '',false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGEVISUALISEUR] = true;
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGETYPE] = TYPEFICHIER_IMAGEGLOBALE_COMMUNAUTE;
		$this->AjouterChamp(COL_ICONE, '', false, false, LISTE_INPUTTYPE_IMAGE, LISTE_INPUTTYPE_IMAGE, NULL, NULL, $autresDonnees);
	}

	protected function InitialiserReferentiels()
	{
	   	$this->AjouterReferentielFichiers(COL_ICONE, PATH_IMAGES.'Communaute/', REF_FICHIERSEXTENSIONS_IMAGES);
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
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_ICONE));
	   	$org->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_LIBELLE));
		$org->SetLargeurCellule(1, 1, '15%');
		$org->SetLargeurCellule(1, 2, '85%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE)));
		$org->SetLargeurCellule(1, 1, '15%');
		$org->SetLargeurCellule(1, 2, '85%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_MODIF));
		$org->SetLargeurCellule(1, 1, '15%');
		$org->SetLargeurCellule(1, 2, '85%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
		$org->SetLargeurCellule(1, 1, '15%');
		$org->SetLargeurCellule(1, 2, '85%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>