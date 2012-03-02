<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_COMPOSANTS.'cListeModificationPresentation2.php';
require_once PATH_COMPOSANTS.'cListeModificationPresentation3.php';


class CListeModificationPresentation extends SListePliante
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
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_PRS_LISTEDER);
		$this->AjouterChamp('champ_5', '', false, false, LISTE_INPUTTYPE_LISTE, LISTE_INPUTTYPE_LISTE, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_PRS_LISTEDER);
		$this->AjouterChamp('champ_6', '', false, false, LISTE_INPUTTYPE_LISTEDB, LISTE_INPUTTYPE_LISTEDB, NULL, NULL, $autresDonnees);
	}

	public function AjouterElement($champ1, $champ2, $champ3, $champ4, $champ5, $champ6)
	{
		$element = array();
		$this->SetElemValeurChamp($element, 'champ_1', $champ1);
		$this->SetElemValeurChamp($element, 'champ_2', $champ2);
		$this->SetElemValeurChamp($element, 'champ_3', $champ3);
		$this->SetElemValeurChamp($element, 'champ_4', $champ4);
		$this->SetElemValeurChamp($element, 'champ_5', $champ5);
		$this->SetElemValeurChamp($element, 'champ_6', $champ6);
		$this->elements[] = $element;
	}

	protected function InitialiserListes()
	{
	   	$mListe = new MListeObjetsMetiers();
	   	$this->AjouterListe('champ_5', $mListe);

	   	$mListe = new MListeObjetsMetiers();
	   	$this->AjouterListe('champ_6', $mListe);
	}

	public function RemplirListe($element, $nomChamp, $liste)
	{
	   	switch ($nomChamp)
	   	{
	   	   	case 'champ_5':
	   	   	   	$libelle = GSession::Libelle(LIB_PRS_CHAMP, true, true);
	   	   	   	$cListe = new CListeModificationPresentation2($this->prefixIdClass, 'ModifPres2', $this->contexte, -1, -1, false, '', true, '', '', '', '', '', '', '', AJAXFONC_RECHARGER);
	   	   	   	$cListe->AjouterElement($libelle.'1', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'2', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'3', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'4', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'5', $libelle, '', $libelle);
				$cListe->SetListeParente($this);
				$liste->AjouterListe($cListe);
			   	break;
		}
	}

	public function RemplirListeDouble($element, $nomChamp, $liste)
	{
	   	switch ($nomChamp)
	   	{
	   	   	case 'champ_6':
	   	   	   	$libelle = GSession::Libelle(LIB_PRS_ELEMENT, true, true);
	   	   	   	$cListe = new CListeModificationPresentation3($this->prefixIdClass, 'ModifPres3', $this->contexte, -1, -1, false, '', false);
				$cListe->SetListeParente($this);
				$cListe->AjouterElement($libelle);
	   	   	   	$cListe->AjouterElement($libelle);
	   	   	   	$cListe->AjouterElement($libelle);
	   	   	   	$cListe->AjouterElement($libelle);
	   	   	   	$cListe->AjouterElement($libelle);
				$liste->AjouterListeSel($cListe);

			   	$cListe = new CListeModificationPresentation3($this->prefixIdClass, 'ModifPres3', $this->contexte, -1, -1, false, '', false);
				$cListe->SetListeParente($this);
				$cListe->AjouterElement($libelle);
	   	   	   	$cListe->AjouterElement($libelle);
	   	   	   	$cListe->AjouterElement($libelle);
			   	$liste->AjouterListeDispo($cListe);
			   	break;
		}
	}

	protected function GetDifferentielForListe($nomChamp)
	{
	   	switch ($nomChamp)
		{
	   	   	case 'champ_5':
			   	$libelle = GSession::Libelle(LIB_PRS_CHAMP, true, true);
				$cListe = new CListeModificationPresentation2($this->prefixIdClass, 'ModifPres2', $this->contexte, -1, -1, false, '', true, '', '', '', '', '', '', '', AJAXFONC_RECHARGER);
	   	   	   	$cListe->AjouterElement($libelle.'1', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'2', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'3', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'4', $libelle, '', $libelle);
	   	   	   	$cListe->AjouterElement($libelle.'5', $libelle, '', $libelle);
				$cListe->SetListeParente($this);
			   	GContexte::AjouterListe($cListe);
				break;
		}
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

	   	$org = new SOrganiseur(1, 2, true, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireTitreElem(GSession::Libelle(LIB_PRS_LISTETITRECOLONNE, true, true)));
	   	$org->AttacherCellule(1, 2, $this->ConstruireTitreElem(GSession::Libelle(LIB_PRS_LISTETITRECOLONNE, true, true)));
		$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	//$elem = parent::ConstruireElemConsultation();

		$org = new SOrganiseur(2, 2, true, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp('champ_2'));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp('champ_4'));
	   	$org->AttacherCellule(2, 1, $this->ConstruireChamp('champ_5'));
	   	$org->AttacherCellule(2, 2, $this->ConstruireChamp('champ_6'));
	   	$elem = parent::ConstruireElemConsultation(GSession::Libelle(LIB_PRS_TITRE, true, true), $org);
	   	//$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		//$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(3, 2, true, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp('champ_1', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp('champ_2', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(2, 1, $this->ConstruireChamp('champ_3', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(2, 2, $this->ConstruireChamp('champ_4', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(3, 1, $this->ConstruireChamp('champ_5', LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(3, 2, $this->ConstruireChamp('champ_6', LISTE_CHAMPTYPE_MODIF));
	   	$elem = parent::ConstruireElemConsultation(GSession::Libelle(LIB_PRS_TITRE, true, true), $org);
	   	//$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		//$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(3, 2, true, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp('champ_1', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp('champ_2', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(2, 1, $this->ConstruireChamp('champ_3', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(2, 2, $this->ConstruireChamp('champ_4', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(3, 1, $this->ConstruireChamp('champ_5', LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(3, 2, $this->ConstruireChamp('champ_6', LISTE_CHAMPTYPE_CREAT));
	   	$elem = parent::ConstruireElemConsultation(GSession::Libelle(LIB_PRS_TITRE, true, true), $org);
	   	//$elem->Attach($org);

		return $elem;
	}
}

?>