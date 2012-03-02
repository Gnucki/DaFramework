<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeModificationPresentation2 extends SListePliante
{
	protected function InitialiserChamps()
	{
	   	$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_PRS_TEXTEAEDITER);
		$this->AjouterChamp('champ_1', '', true, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_PRS_LISTEDER);
		$this->AjouterChamp('champ_2', '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_PRS_LISTEDERFICHIER);
		$this->AjouterChamp('champ_3', '', false, false, LISTE_INPUTTYPE_IMAGE, LISTE_INPUTTYPE_IMAGE, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_PRS_CASEACOCHER);
		$this->AjouterChamp('champ_4', '', false, false, LISTE_INPUTTYPE_CHECKBOX, LISTE_INPUTTYPE_CHECKBOX, NULL, NULL, $autresDonnees);
	}

	public function AjouterElement($champ1, $champ2, $champ3, $champ4)
	{
		$element = array();
		$this->SetElemValeurChamp($element, 'champ_1', $champ1);
		$this->SetElemValeurChamp($element, 'champ_2', $champ2);
		$this->SetElemValeurChamp($element, 'champ_3', $champ3);
		$this->SetElemValeurChamp($element, 'champ_4', $champ4);
		$this->elements[] = $element;
	}

	protected function HasDroitConsultation($element)
	{
		return true;
	}

	protected function HasDroitModification($element)
	{
		return true;
	}

	protected function HasDroitCreation()
	{
		return true;
	}

	protected function HasDroitSuppression($element)
	{
		return true;
	}

	protected function ConstruireLigneTitre()
	{
		$elem = parent::ConstruireLigneTitre();

	   	$elem->Attach($this->ConstruireTitreElem(GSession::Libelle(LIB_PRS_LISTETITRECOLONNE, true, true)));

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	//$elem = parent::ConstruireElemConsultation();

		$org = new SOrganiseur(1, 2, true, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp('champ_2'));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp('champ_3'));
	   	$elem = parent::ConstruireElemConsultation(GSession::Libelle(LIB_PRS_TITRE, true, true), $org);
	   	//$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		//$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(4, 1, true, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp('champ_1', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(2, 1, $this->ConstruireChamp('champ_2', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(3, 1, $this->ConstruireChamp('champ_3', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(4, 1, $this->ConstruireChamp('champ_4', LISTE_CHAMPTYPE_MODIF));
	   	$elem = parent::ConstruireElemModification(GSession::Libelle(LIB_PRS_TITRE, true, true), $org);
	   	//$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		//$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(4, 1, true, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp('champ_1', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(2, 1, $this->ConstruireChamp('champ_2', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(3, 1, $this->ConstruireChamp('champ_3', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(4, 1, $this->ConstruireChamp('champ_4', LISTE_CHAMPTYPE_CREAT));
	   	$elem = parent::ConstruireElemCreation(GSession::Libelle(LIB_PRS_TITRE, true, true), $org);
	   	//$elem->Attach($org);

		return $elem;
	}
}

?>