<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeVersionsAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(COL_VERSION, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_COMMENTAIRE, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
	}

	public function AjouterElement($id, $version, $textVersion, $commentaire, $textCommentaire)
	{
		$elem = array();
		$this->SetElemValeurChamp($elem, COL_ID, $id);
		$this->SetElemValeurChamp($elem, COL_VERSION, $version, $textVersion);
		$this->SetElemValeurChamp($elem, COL_COMMENTAIRE, $commentaire, $textCommentaire);

		$this->elements[] = $elem;
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
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_VERSION));
	   	$org->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_COMMENTAIRE));
		$org->SetLargeurCellule(1, 1, '20%');
		$org->SetLargeurCellule(1, 2, '80%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 2, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_VERSION));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_COMMENTAIRE));
	   	$org->SetLargeurCellule(1, 1, '20%');
	   	$org->SetLargeurCellule(1, 2, '80%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(1, 2, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_VERSION, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_COMMENTAIRE, LISTE_CHAMPTYPE_MODIF));
	   	$org->SetLargeurCellule(1, 1, '20%');
	   	$org->SetLargeurCellule(1, 2, '80%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(1, 2, true);
		$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_VERSION, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_COMMENTAIRE, LISTE_CHAMPTYPE_CREAT));
	   	$org->SetLargeurCellule(1, 1, '20%');
	   	$org->SetLargeurCellule(1, 2, '80%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>