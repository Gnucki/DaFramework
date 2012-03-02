<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_METIER.'mListeSuperGrades.php';
require_once PATH_METIER.'mListeFonctionnalites.php';
require_once PATH_COMPOSANTS.'cListeFonctionnalites.php';
//require_once PATH_COMPOSANTS.'cListeDroitsSuperGrades.php';


class CListeSuperGradesAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$this->AjouterChamp(array(COL_LIBELLE, COL_ID), '', false, true);
		$this->AjouterChamp(array(COL_LIBELLE, COL_LIBELLE), '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(array(COL_DESCRIPTION, COL_ID), '', false, true);
		$this->AjouterChamp(array(COL_DESCRIPTION, COL_LIBELLE), '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_NIVEAU, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_POIDSVOTERECRUTEMENT, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_FONCTIONNALITE, '', false, false, LISTE_INPUTTYPE_LISTEDB, LISTE_INPUTTYPE_LISTEDB);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGEVISUALISEUR] = true;
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGETYPE] = TYPEFICHIER_IMAGEGLOBALE_GRADE;
		$this->AjouterChamp(COL_ICONE, '', false, false, LISTE_INPUTTYPE_IMAGE, LISTE_INPUTTYPE_IMAGE, NULL, NULL, $autresDonnees);
	}

	protected function InitialiserReferentiels()
	{
	   	$this->AjouterReferentielFichiers(COL_ICONE, PATH_IMAGES.'Grade/', REF_FICHIERSEXTENSIONS_IMAGES);
	}

	protected function InitialiserListes()
	{
	   	$mListeFonctionnalites = new MListeFonctionnalites();
	   	$mListeFonctionnalites->AjouterColSelection(COL_ID);
	   	$mListeFonctionnalites->AjouterColSelection(COL_LIBELLE);
	   	$mListeFonctionnalites->AjouterColOrdre(COL_LIBELLE);
	   	$this->AjouterListe(COL_FONCTIONNALITE, $mListeFonctionnalites);
	}

	protected function InitialiserListesElement($element)
	{
	   	$mListeFonctionnalites = $element[LISTE_ELEMENT_OBJET]->ListeDroitsSuperGrades();
	   	$this->AjouterListeElement($element, COL_FONCTIONNALITE, $mListeFonctionnalites);
	}

	protected function GetDifferentielForListeElement($element, $nomChamp)
	{
	   	$id = $element[LISTE_ELEMENT_ID];

	   	switch ($nomChamp)
		{
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
			case COL_FONCTIONNALITE:
			   	$cListe = new CListeFonctionnalites($this->prefixIdClass, $this->NomListeFormate($nomChamp).'_', $this->contexte, -1);
			   	$cListe->SetListeParente($this, $id);
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
		   	case COL_FONCTIONNALITE:
		   	   	$mListe = $element[LISTE_ELEMENT_OBJET]->ListeDroitsSuperGrades();
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
	   	$sousOrg1 = new SOrganiseur(1, 5, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_ICONE));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_LIBELLE));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireTitreElem(COL_DESCRIPTION));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireTitreElem(COL_NIVEAU));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireTitreElem(COL_POIDSVOTERECRUTEMENT));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '30%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '10%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_FONCTIONNALITE));
		$sousOrg2->SetLargeurCellule(1, 1, '100%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
		$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(2, 1, true);
	   	$sousOrg1 = new SOrganiseur(1, 5, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE)));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_DESCRIPTION, COL_LIBELLE)));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAU));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireChamp(COL_POIDSVOTERECRUTEMENT));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '30%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '10%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_FONCTIONNALITE));
		$sousOrg2->SetLargeurCellule(1, 1, '100%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
		$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

	   	$org = new SOrganiseur(2, 1, true);
	   	$sousOrg1 = new SOrganiseur(1, 5, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_DESCRIPTION, COL_LIBELLE), LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAU, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireChamp(COL_POIDSVOTERECRUTEMENT, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '30%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '10%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_FONCTIONNALITE, LISTE_CHAMPTYPE_MODIF));
		$sousOrg2->SetLargeurCellule(1, 1, '100%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
		$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

	   	$org = new SOrganiseur(2, 1, true);
	   	$sousOrg1 = new SOrganiseur(1, 5, true);
	   	$sousOrg1->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_DESCRIPTION, COL_LIBELLE), LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAU, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireChamp(COL_POIDSVOTERECRUTEMENT, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '30%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '10%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_FONCTIONNALITE, LISTE_CHAMPTYPE_CREAT));
		$sousOrg2->SetLargeurCellule(1, 1, '100%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
		$elem->Attach($org);

		return $elem;
	}
}

?>