<?php

require_once 'cst.php';
require_once INC_SLISTETITRECONTENU;
require_once PATH_METIER.'mListeForums.php';
require_once PATH_COMPOSANTS.'cListeForums.php';


class CListeCategories extends SListeTitreContenu
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
		$this->AjouterChamp(COL_NOM, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_FORUM, '', false, false, LISTE_INPUTTYPE_LISTE, LISTE_INPUTTYPE_LISTE);
	}

	protected function InitialiserReferentiels()
	{
	   	/*$mListeMenus = new MListeMenus();
	   	$mListeMenus->AjouterColSelection(COL_ID);
		$mListeMenus->AjouterColSelection(COL_LIBELLE);
		$mListeMenus->AjouterColOrdre(COL_LIBELLE);
		$this->AjouterReferentiel(array(COL_MENU, COL_ID), $mListeMenus, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));*/
	}

	protected function InitialiserListes()
	{
	   	/*$mListeContextes = new MListeContextes();
	   	$mListeContextes->AjouterColSelection(COL_ID);
		$mListeContextes->AjouterColSelection(COL_NOM);
		$mListeContextes->AjouterColOrdre(COL_NOM);
	   	$this->AjouterListe(COL_CONTEXTE, $mListeContextes);

	   	$mListeFonctionnalites = new MListeFonctionnalites();
	   	$mListeFonctionnalites->AjouterColSelection(COL_ID);
	   	$mListeFonctionnalites->AjouterColSelection(COL_LIBELLE);
	   	$mListeFonctionnalites->AjouterColOrdre(COL_LIBELLE);
	   	$this->AjouterListe(COL_FONCTIONNALITE, $mListeFonctionnalites);*/
	}

	protected function InitialiserListesElement($element)
	{
	   	$mListeForums = $element[LISTE_ELEMENT_OBJET]->ListeForums();
	   	$this->AjouterListeElement($element, COL_FORUM, $mListeForums);
	}

	protected function GetDifferentielForListeElement($element, $nomChamp)
	{
	   	$id = $element[LISTE_ELEMENT_ID];

	   	switch ($nomChamp)
		{
	   	   	case COL_FORUM:
			   	$cListe = new CListeForums($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte, -1);
			   	$cListe->SetListeParente($this, $id);
				$mListe = $this->GetSousListeElement($element, $nomChamp);
				//$mSousListe = new MListeForums();
				$mSousListe = $mListe->ExtraireListe(COL_FORUM);
			   	$cListe->InjecterListeObjetsMetiers($mSousListe, true);
			   	GContexte::AjouterListe($cListe);

				break;
		}
	}

	protected function GetDifferentielForListeElementCreation($nomChamp)
	{
	   	/*switch ($nomChamp)
		{
	   	   	case COL_FORUM:
			   	$cListe = new CListeForums($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_', $this->contexte, -1);
			   	$cListe->SetListeParente($this, '');
				$mListe = $this->GetSousListe($nomChamp);
			   	$cListe->InjecterListeObjetsMetiers($mListe, true);
			   	GContexte::AjouterListe($cListe);
				break;
		}*/
	}

	public function RemplirListe($element, $nomChamp, $liste)
	{
	   	switch ($nomChamp)
	   	{
	   	   	case COL_FORUM:
	   	   	   	$id = '';
				if ($element !== NULL)
	   	   	   	   	$id = $element[LISTE_ELEMENT_ID];

	   	   	   	$cListe = new CListeForums($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte, -1);
				$cListe->SetListeParente($this, $id);
				$mSousListe = new MListeForums();
				if ($id !== '')
				{
				   	$mListe = $this->GetSousListeElement($element, $nomChamp);
				   	$mSousListe = $mListe->ExtraireListe(COL_FORUM);
				}
				$cListe->InjecterListeObjetsMetiers($mSousListe, true);
				$liste->AjouterListe($cListe);
			   	break;
		}
	}

	protected function SetElemValeurChampSpec(&$element, $nomChamp)
	{
	   	switch ($nomChamp)
	   	{
		   	case COL_FORUM:
		   	   	$mListe = $element[LISTE_ELEMENT_OBJET]->ListeForums();
		   	   	if ($mListe->ListeChargee() === false)
				   	$mListe->Charger();
		   	   	$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $mListe->ExtraireChamp(array(COL_FORUM, COL_NOM));
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
		return NULL;
	}

	protected function ConstruireElemConsultation()
	{
		return parent::ConstruireElemConsultation($this->ConstruireChamp(COL_NOM), $this->ConstruireChamp(COL_FORUM));
	}

	protected function ConstruireElemModification()
	{
		return parent::ConstruireElemModification($this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_MODIF), $this->ConstruireChamp(COL_FORUM, LISTE_CHAMPTYPE_MODIF));
	}

	protected function ConstruireElemCreation()
	{
		return parent::ConstruireElemCreation($this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_CREAT), new SElement());//$this->ConstruireChamp(COL_FORUM, LISTE_CHAMPTYPE_CREAT));
	}
}

?>