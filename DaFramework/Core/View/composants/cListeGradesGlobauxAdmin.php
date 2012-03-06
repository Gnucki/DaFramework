<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_METIER.'mListeGradesGlobaux.php';
require_once PATH_METIER.'mListeSuperGrades.php';
require_once PATH_COMPOSANTS.'cListeJoueursPseudos.php';


class CListeGradesGlobauxAdmin extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
		$this->AjouterChamp(COL_NOM, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_DESCRIPTION, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_NIVEAU, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
		$this->AjouterChamp(COL_JOUEUR, '', false, false, LISTE_INPUTTYPE_LISTE, LISTE_INPUTTYPE_LISTE);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGEVISUALISEUR] = true;
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGETYPE] = TYPEFICHIER_IMAGEGLOBALE_GRADE;
		$this->AjouterChamp(COL_ICONE, '', false, false, LISTE_INPUTTYPE_IMAGE, LISTE_INPUTTYPE_IMAGE, NULL, NULL, $autresDonnees);
		$this->AjouterChamp(array(COL_SUPERGRADE, COL_ID), '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT);
		$this->AjouterChamp(array(COL_SUPERGRADE, COL_LIBELLE, COL_LIBELLE), '', false, false);
	}

	protected function InitialiserReferentiels()
	{
	   	$this->AjouterReferentielFichiers(COL_ICONE, PATH_IMAGES.'Grade/', REF_FICHIERSEXTENSIONS_IMAGES);
	   	$mListeSuperGrades = new MListeSuperGrades();
	   	$mListeSuperGrades->AjouterColSelection(COL_ID);
		$mListeSuperGrades->AjouterColSelection(COL_LIBELLE);
		$mListeSuperGrades->AjouterColOrdre(COL_NIVEAU, NULL, true);
		$this->AjouterReferentiel(array(COL_SUPERGRADE, COL_ID), $mListeSuperGrades, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));

	}

	protected function InitialiserListesElement($element)
	{
	   	$mListeGradesJoueurs = $element[LISTE_ELEMENT_OBJET]->ListeGradesJoueurs();
	   	$this->AjouterListeElement($element, COL_JOUEUR, $mListeGradesJoueurs);
	}

	protected function GetDifferentielForListeElement($element, $nomChamp)
	{
	   	$id = $element[LISTE_ELEMENT_ID];

	   	switch ($nomChamp)
		{
			case COL_JOUEUR:
			   	$cListe = new CListeJoueursPseudos($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte);
			   	$cListe->SetListeParente($this, $id);
				$mListe = $this->GetSousListeElement($element, $nomChamp);
				$mSousListe = new MListeJoueurs();
				$mSousListe = $mListe->ExtraireListe(COL_JOUEUR);
			   	$cListe->InjecterListeObjetsMetiers($mSousListe, true);
			   	GContexte::AjouterListe($cListe);
		}
	}

	public function RemplirListe($element, $nomChamp, $liste)
	{
	   	switch ($nomChamp)
	   	{
			case COL_JOUEUR:
	   	   	   	$id = '';
				if ($element !== NULL)
	   	   	   	   	$id = $element[LISTE_ELEMENT_ID];

	   	   	   	$cListe = new CListeJoueursPseudos($this->prefixIdClass, $this->NomListeFormate($nomChamp).'__'.$id, $this->contexte);
				$cListe->SetListeParente($this, $id);
				$mSousListe = new MListeJoueurs();
				if ($id !== '')
			 	{
				   	$mListe = $this->GetSousListeElement($element, $nomChamp);
					$mSousListe = new MListeJoueurs();
					$mSousListe = $mListe->ExtraireListe(COL_JOUEUR);
				}
				$cListe->InjecterListeObjetsMetiers($mSousListe, true);
				$liste->AjouterListe($cListe);
		}
	}

	protected function SetElemValeurChampSpec(&$element, $nomChamp)
	{
	   	switch ($nomChamp)
	   	{
		   	case COL_JOUEUR:
		   	   	$mListe = $element[LISTE_ELEMENT_OBJET]->ListeGradesJoueurs();
		   	   	if ($mListe->ListeChargee() === false)
				   	$mListe->Charger();
		   	   	$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT] = $mListe->ExtraireChamp(array(COL_JOUEUR, COL_PSEUDO));
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
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireTitreElem(COL_NOM));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireTitreElem(COL_DESCRIPTION));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireTitreElem(COL_NIVEAU));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireTitreElem(COL_SUPERGRADE));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '20%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireTitreElem(COL_JOUEUR));
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
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(COL_NOM));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(COL_DESCRIPTION));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAU));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireChamp(array(COL_SUPERGRADE, COL_LIBELLE, COL_LIBELLE)));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '20%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_JOUEUR));
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
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(COL_DESCRIPTION, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAU, LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireChamp(array(COL_SUPERGRADE, COL_ID), LISTE_CHAMPTYPE_MODIF));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '20%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_JOUEUR, LISTE_CHAMPTYPE_MODIF));
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
	   	$sousOrg1->AttacherCellule(1, 2, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 3, $this->ConstruireChamp(COL_DESCRIPTION, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 4, $this->ConstruireChamp(COL_NIVEAU, LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->AttacherCellule(1, 5, $this->ConstruireChamp(array(COL_SUPERGRADE, COL_ID), LISTE_CHAMPTYPE_CREAT));
	   	$sousOrg1->SetLargeurCellule(1, 1, '10%');
		$sousOrg1->SetLargeurCellule(1, 2, '20%');
		$sousOrg1->SetLargeurCellule(1, 3, '40%');
		$sousOrg1->SetLargeurCellule(1, 4, '10%');
		$sousOrg1->SetLargeurCellule(1, 5, '20%');
	   	$sousOrg2 = new SOrganiseur(1, 1, true);
	   	$sousOrg2->AttacherCellule(1, 1, $this->ConstruireChamp(COL_JOUEUR, LISTE_CHAMPTYPE_CREAT));
		$sousOrg2->SetLargeurCellule(1, 1, '100%');
	   	$org->AttacherCellule(1, 1, $sousOrg1);
	   	$org->AttacherCellule(2, 1, $sousOrg2);
		$elem->Attach($org);

		return $elem;
	}
}

?>