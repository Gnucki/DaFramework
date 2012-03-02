<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_METIER.'mListeTypesLibelles.php';


class CListeLibellesLibresAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '', true, true, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
	   	$this->AjouterChamp(COL_LANGUE, '', true, true);
		$this->AjouterChamp(COL_LIBELLE, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(array(COL_TYPELIBELLE, COL_ID), '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT);
		$this->AjouterChamp(array(COL_TYPELIBELLE, COL_LIBELLE, COL_LIBELLE), '', false, false);
		$this->AjouterChamp(array(COL_LANGUEORIGINELLE, COL_LIBELLE, COL_LIBELLE), '', false, false);
	}

	protected function InitialiserReferentiels()
	{
	   	$mListeTypesLibelles = new MListeTypesLibelles();
	   	$mListeTypesLibelles->AjouterColSelection(COL_ID);
		$mListeTypesLibelles->AjouterColSelection(COL_LIBELLE);
		$mListeTypesLibelles->AjouterColOrdre(COL_LIBELLE);
		$this->AjouterReferentiel(array(COL_TYPELIBELLE, COL_ID), $mListeTypesLibelles, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));
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

	   	$org = new SOrganiseur(1, 4, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_ID));
	   	$org->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_LIBELLE));
	   	$org->AttacherCellule(1, 3, $this->ConstruireTitreElem(COL_TYPELIBELLE));
	   	$org->AttacherCellule(1, 4, $this->ConstruireTitreElem(COL_LANGUEORIGINELLE));
		$org->SetLargeurCellule(1, 1, '10%');
		$org->SetLargeurCellule(1, 2, '60%');
		$org->SetLargeurCellule(1, 3, '15%');
		$org->SetLargeurCellule(1, 4, '15%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 4, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_LIBELLE));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_TYPELIBELLE, COL_LIBELLE, COL_LIBELLE)));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(array(COL_LANGUEORIGINELLE, COL_LIBELLE, COL_LIBELLE)));
		$org->SetLargeurCellule(1, 1, '10%');
		$org->SetLargeurCellule(1, 2, '60%');
		$org->SetLargeurCellule(1, 3, '15%');
		$org->SetLargeurCellule(1, 4, '15%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(1, 4, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_LIBELLE, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_TYPELIBELLE, COL_ID), LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(array(COL_LANGUEORIGINELLE, COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_MODIF));
		$org->SetLargeurCellule(1, 1, '10%');
		$org->SetLargeurCellule(1, 2, '60%');
		$org->SetLargeurCellule(1, 3, '15%');
		$org->SetLargeurCellule(1, 4, '15%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(1, 4, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_LIBELLE, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_TYPELIBELLE, COL_ID), LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(array(COL_LANGUEORIGINELLE, COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
		$org->SetLargeurCellule(1, 1, '10%');
		$org->SetLargeurCellule(1, 2, '60%');
		$org->SetLargeurCellule(1, 3, '15%');
		$org->SetLargeurCellule(1, 4, '15%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>