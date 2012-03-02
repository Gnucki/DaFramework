<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_METIER.'mListeMenus.php';
require_once PATH_METIER.'mListeContextes.php';
require_once PATH_COMPOSANTS.'cListeContextes.php';
//require_once PATH_COMPOSANTS.'cListeMenusContextes.php';
require_once PATH_METIER.'mListeFonctionnalites.php';
require_once PATH_COMPOSANTS.'cListeFonctionnalites.php';
//require_once PATH_COMPOSANTS.'cListeMenusFonctionnalites.php';


class CListeMenusAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(array(COL_LIBELLE, COL_ID), '', false, true);
		$this->AjouterChamp(array(COL_LIBELLE, COL_LIBELLE), '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(array(COL_MENU, COL_ID), '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT);
		$this->AjouterChamp(array(COL_MENU, COL_LIBELLE, COL_LIBELLE), '', false, false);
		$this->AjouterChamp(COL_DEPENDFONCTIONNALITE, '', false, false, LISTE_INPUTTYPE_CHECKBOX, LISTE_INPUTTYPE_CHECKBOX);
		$this->AjouterChamp(COL_CONTEXTE, '', false, false, LISTE_INPUTTYPE_LISTEDB, LISTE_INPUTTYPE_LISTEDB);
		$this->AjouterChamp(COL_FONCTIONNALITE, '', false, false, LISTE_INPUTTYPE_LISTEDB, LISTE_INPUTTYPE_LISTEDB);
	}

	protected function InitialiserReferentiels()
	{
	   	$mListeMenus = new MListeMenus();
	   	$mListeMenus->AjouterColSelection(COL_ID);
		$mListeMenus->AjouterColSelection(COL_LIBELLE);
		$mListeMenus->AjouterColOrdre(COL_LIBELLE);
		$this->AjouterReferentiel(array(COL_MENU, COL_ID), $mListeMenus, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));
	}

	protected function InitialiserListes()
	{
	   	$mListeContextes = new MListeContextes();
	   	$mListeContextes->AjouterColSelection(COL_ID);
		$mListeContextes->AjouterColSelection(COL_NOM);
		$mListeContextes->AjouterColOrdre(COL_NOM);
	   	$this->AjouterListe(COL_CONTEXTE, $mListeContextes);

	   	$mListeFonctionnalites = new MListeFonctionnalites();
	   	$mListeFonctionnalites->AjouterColSelection(COL_ID);
	   	$mListeFonctionnalites->AjouterColSelection(COL_LIBELLE);
	   	$mListeFonctionnalites->AjouterColOrdre(COL_LIBELLE);
	   	$this->AjouterListe(COL_FONCTIONNALITE, $mListeFonctionnalites);
	}

	protected function InitialiserListesElement($element)
	{
	   	$mListeContextes = $element[LISTE_ELEMENT_OBJET]->ListeMenusContextes();
	   	$this->AjouterListeElement($element, COL_CONTEXTE, $mListeContextes);

	   	$mListeFonctionnalites = $element[LISTE_ELEMENT_OBJET]->ListeMenusFonctionnalites();
	   	$this->AjouterListeElement($element, COL_FONCTIONNALITE, $mListeFonctionnalites);
	}

	protected function GetDifferentielForListeElement($element, $nomChamp)
	{
	   	$id = $element[LISTE_ELEMENT_ID];

	   	switch ($nomChamp)
		{
	   	   	case COL_CONTEXTE:
			   	$cListe = new CListeContextes($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte, -1);
			   	$cListe->SetListeParente($this, $id);
				$mListe = $this->GetSousListeElement($element, $nomChamp);
				$mSousListe = new MListeContextes();
				$mSousListe = $mListe->ExtraireListe(COL_CONTEXTE);
			   	$cListe->InjecterListeObjetsMetiers($mSousListe, true);
			   	GContexte::AjouterListe($cListe);

			 	if ($this->ElementEtageCharge($element, LISTE_ETAGE_MODIF) === true)
				{
				   	$cListe = new CListeContextes($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_'.$id, $this->contexte, -1);
				   	$cListe->SetListeParente($this, $id);
					$mListe = $this->GetSousListe($nomChamp);
				   	$mListe->SoustraireListe($mSousListe);
				   	$cListe->InjecterListeObjetsMetiers($mListe, true);
				   	GContexte::AjouterListe($cListe);
				}
				break;
			case COL_FONCTIONNALITE:
			   	$cListe = new CListeFonctionnalites($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte, -1);
			   	$cListe->SetListeParente($this, $id);
				$mListe = $this->GetSousListeElement($element, $nomChamp);
				$mSousListe = new MListeFonctionnalites();
				$mSousListe = $mListe->ExtraireListe(COL_FONCTIONNALITE);
			   	$cListe->InjecterListeObjetsMetiers($mSousListe, true);
			   	GContexte::AjouterListe($cListe);

			 	if ($this->ElementEtageCharge($element, LISTE_ETAGE_MODIF) === true)
				{
				   	$cListe = new CListeFonctionnalites($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_'.$id, $this->contexte, -1);
				   	$cListe->SetListeParente($this, $id);
					$mListe = $this->GetSousListe($nomChamp);
				   	$mListe->SoustraireListe($mSousListe);
				   	$cListe->InjecterListeObjetsMetiers($mListe, true);
				   	GContexte::AjouterListe($cListe);
				}
				break;
		}
	}

	protected function GetDifferentielForListeElementCreation($nomChamp)
	{
	   	switch ($nomChamp)
		{
	   	   	case COL_CONTEXTE:
			   	$cListe = new CListeContextes($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_', $this->contexte, -1);
			   	$cListe->SetListeParente($this, '');
				$mListe = $this->GetSousListe($nomChamp);
			   	$cListe->InjecterListeObjetsMetiers($mListe, true);
			   	GContexte::AjouterListe($cListe);
				break;
			case COL_FONCTIONNALITE:
			   	$cListe = new CListeFonctionnalites($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_', $this->contexte, -1);
			   	$cListe->SetListeParente($this, '');
				$mListe = $this->GetSousListe($nomChamp);
			   	$cListe->InjecterListeObjetsMetiers($mListe, true);
			   	GContexte::AjouterListe($cListe);
				break;
		}
	}

	public function RemplirListeDouble($element, $nomChamp, $liste)
	{
	   	switch ($nomChamp)
	   	{
	   	   	case COL_CONTEXTE:
	   	   	   	$id = '';
				if ($element !== NULL)
	   	   	   	   	$id = $element[LISTE_ELEMENT_ID];

	   	   	   	$cListe = new CListeContextes($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte, -1);
				$cListe->SetListeParente($this, $id);
				$mSousListe = new MListeContextes();
				if ($id !== '')
			 	{
				   	$mListe = $this->GetSousListeElement($element, $nomChamp);
					$mSousListe = $mListe->ExtraireListe(COL_CONTEXTE);
				}
				$cListe->InjecterListeObjetsMetiers($mSousListe, true);
				$liste->AjouterListeSel($cListe);

			   	$cListe = new CListeContextes($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_'.$id, $this->contexte, -1);
			   	$cListe->SetListeParente($this, $id);
				$mListe = $this->GetSousListe($nomChamp);
		   		if ($mSousListe !== NULL)
		   			$mListe->SoustraireListe($mSousListe);
			   	$cListe->InjecterListeObjetsMetiers($mListe, true);
			   	$liste->AjouterListeDispo($cListe);
			   	break;
			case COL_FONCTIONNALITE:
	   	   	   	$id = '';
				if ($element !== NULL)
	   	   	   	   	$id = $element[LISTE_ELEMENT_ID];

	   	   	   	$cListe = new CListeFonctionnalites($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte, -1);
				$cListe->SetListeParente($this, $id);
				$mSousListe = new MListeFonctionnalites();
				if ($id !== '')
			 	{
				   	$mListe = $this->GetSousListeElement($element, $nomChamp);
					$mSousListe = $mListe->ExtraireListe(COL_FONCTIONNALITE);
				}
				$cListe->InjecterListeObjetsMetiers($mSousListe, true);
				$liste->AjouterListeSel($cListe);

			   	$cListe = new CListeFonctionnalites($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_'.$id, $this->contexte, -1);
			   	$cListe->SetListeParente($this, $id);
				$mListe = $this->GetSousListe($nomChamp);
		   		if ($mSousListe !== NULL)
		   			$mListe->SoustraireListe($mSousListe);
			   	$cListe->InjecterListeObjetsMetiers($mListe, true);
			   	$liste->AjouterListeDispo($cListe);
			   	break;
		}
	}

	protected function SetElemValeurChampSpec(&$element, $nomChamp)
	{
	   	switch ($nomChamp)
	   	{
		   	case COL_CONTEXTE:
		   	   	$mListe = $element[LISTE_ELEMENT_OBJET]->ListeMenusContextes();
		   	   	if ($mListe->ListeChargee() === false)
				   	$mListe->Charger();
		   	   	$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $mListe->ExtraireChamp(array(COL_CONTEXTE, COL_NOM));
		   	   	break;
		   	case COL_FONCTIONNALITE:
		   	   	$mListe = $element[LISTE_ELEMENT_OBJET]->ListeMenusFonctionnalites();
		   	   	if ($mListe->ListeChargee() === false)
				   	$mListe->Charger();
		   	   	$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $mListe->ExtraireChamp(array(COL_FONCTIONNALITE, COL_LIBELLE, COL_LIBELLE));
		   	   	break;
		   	default:
		   	   	$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = NULL;
		}
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

	   	$org = new SOrganiseur(2, 1, true);
	   	$sousOrg1 = new SOrganiseur(1, 4, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_ID));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_LIBELLE));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireTitreElem(COL_MENU));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireTitreElem(COL_DEPENDFONCTIONNALITE));
	   	$sousOrg1->SetLargeurCellule(1, 1, '5%');
		$sousOrg1->SetLargeurCellule(1, 2, '45%');
		$sousOrg1->SetLargeurCellule(1, 3, '30%');
		$sousOrg1->SetLargeurCellule(1, 4, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 2, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_CONTEXTE));
	   	$sousOrg2->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_FONCTIONNALITE));
		$sousOrg2->SetLargeurCellule(1, 1, '50%');
		$sousOrg2->SetLargeurCellule(1, 2, '50%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
		$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

		$org = new SOrganiseur(2, 1, true);
	   	$sousOrg1 = new SOrganiseur(1, 4, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE)));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_MENU, COL_LIBELLE, COL_LIBELLE)));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_DEPENDFONCTIONNALITE));
	   	$sousOrg1->SetLargeurCellule(1, 1, '5%');
		$sousOrg1->SetLargeurCellule(1, 2, '45%');
		$sousOrg1->SetLargeurCellule(1, 3, '30%');
		$sousOrg1->SetLargeurCellule(1, 4, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 2, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_CONTEXTE));
	   	$sousOrg2->AttacherCellule(1, 2, $this->ConstruireChamp(COL_FONCTIONNALITE));
		$sousOrg2->SetLargeurCellule(1, 1, '50%');
		$sousOrg2->SetLargeurCellule(1, 2, '50%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(2, 1, true);
	   	$sousOrg1 = new SOrganiseur(1, 4, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_MENU, COL_ID), LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_DEPENDFONCTIONNALITE, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->SetLargeurCellule(1, 1, '5%');
		$sousOrg1->SetLargeurCellule(1, 2, '45%');
		$sousOrg1->SetLargeurCellule(1, 3, '30%');
		$sousOrg1->SetLargeurCellule(1, 4, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 2, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_CONTEXTE, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg2->AttacherCellule(1, 2, $this->ConstruireChamp(COL_FONCTIONNALITE, LISTE_CHAMPTYPE_MODIF));
		$sousOrg2->SetLargeurCellule(1, 1, '50%');
		$sousOrg2->SetLargeurCellule(1, 2, '50%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

		$org = new SOrganiseur(2, 1, true);
	   	$sousOrg1 = new SOrganiseur(1, 4, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ID, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_MENU, COL_ID), LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_DEPENDFONCTIONNALITE, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->SetLargeurCellule(1, 1, '5%');
		$sousOrg1->SetLargeurCellule(1, 2, '45%');
		$sousOrg1->SetLargeurCellule(1, 3, '30%');
		$sousOrg1->SetLargeurCellule(1, 4, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 2, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_CONTEXTE, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg2->AttacherCellule(1, 2, $this->ConstruireChamp(COL_FONCTIONNALITE, LISTE_CHAMPTYPE_CREAT));
		$sousOrg2->SetLargeurCellule(1, 1, '50%');
		$sousOrg2->SetLargeurCellule(1, 2, '50%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
	   	$elem->Attach($org);

		return $elem;
	}
}

?>