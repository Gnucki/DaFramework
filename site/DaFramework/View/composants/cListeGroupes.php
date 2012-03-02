<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';
require_once PATH_METIER.'mListeCommunautes.php';


class CListeGroupes extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_NOM);
		$this->AjouterChamp(COL_NOM, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_DESCRIPTION);
		$this->AjouterChamp(COL_DESCRIPTION, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_HISTOIRE);
		$this->AjouterChamp(COL_HISTOIRE, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGEVISUALISEUR] = true;
		$autresDonnees[LISTE_AUTRESDONNEES_IMAGETYPE] = TYPEFICHIER_IMAGEGLOBALE_COMMUNAUTE;
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_ICONE);
		$this->AjouterChamp(COL_ICONE, '', false, false, LISTE_INPUTTYPE_IMAGE, LISTE_INPUTTYPE_IMAGE, NULL, NULL, $autresDonnees);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_COMMUNAUTE);
		$this->AjouterChamp(array(COL_COMMUNAUTE, COL_ID), '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT, NULL, NULL, $autresDonnees);
		$this->AjouterChamp(array(COL_COMMUNAUTE, COL_LIBELLE, COL_LIBELLE), '', false, false);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_SELECTIMPACT] = array(array(COL_SERVEUR, COL_ID), array(COL_TYPEGROUPE, COL_ID));
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_JEU);
		$this->AjouterChamp(array(COL_JEU, COL_ID), '', false, false, LISTE_INPUTTYPE_FIND, LISTE_INPUTTYPE_FIND, NULL, NULL, $autresDonnees);
		$this->AjouterChamp(array(COL_JEU, COL_LIBELLE, COL_LIBELLE), '', false, false);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_SELECTDEPENDANCE] = array(array(COL_JEU, COL_ID));
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_SERVEUR);
		$this->AjouterChamp(array(COL_SERVEUR, COL_ID), '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT, NULL, NULL, $autresDonnees);
		$this->AjouterChamp(array(COL_SERVEUR, COL_LIBELLE, COL_LIBELLE), '', false, false);
		$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_SELECTDEPENDANCE] = array(array(COL_JEU, COL_ID));
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPLABEL] = GSession::Libelle(LIB_GPE_TYPEGROUPE);
		$this->AjouterChamp(array(COL_TYPEGROUPE, COL_ID), '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT, NULL, NULL, $autresDonnees);
		$this->AjouterChamp(array(COL_TYPEGROUPE, COL_LIBELLE, COL_LIBELLE), '', false, false);
	}

	protected function InitialiserReferentiels()
	{
	   	$this->AjouterReferentielFichiers(COL_ICONE, PATH_IMAGES.'Communaute/', REF_FICHIERSEXTENSIONS_IMAGES);
	   	$mListeJeux = new MListeJeux();
	   	$this->AjouterReferentiel(array(COL_JEU, COL_ID), $mListeJeux, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
	   	$mListeCommunautes = new MListeCommunautes();
	   	$mListeCommunautes->AjouterColSelection(COL_ID);
	   	$mListeCommunautes->AjouterColSelection(COL_LIBELLE);
	   	$mListeCommunautes->AjouterColOrdre(COL_LIBELLE);
	   	$mListeCommunautes->Charger();
	   	$this->AjouterReferentiel(array(COL_COMMUNAUTE, COL_ID), $mListeCommunautes, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
	   	$mListeServeurs = new MListeServeurs();
	   	$this->AjouterReferentiel(array(COL_SERVEUR, COL_ID), $mListeServeurs, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
	   	$mListeTypesGroupes = new MListeTypesGroupes();
	   	$this->AjouterReferentiel(array(COL_TYPEGROUPE, COL_ID), $mListeTypesGroupes, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
	}

	protected function InitialiserReferentielsElement($element)
	{
	   	$mObjet = $element[LISTE_ELEMENT_OBJET];

	   	$mListeJeux = new MListeJeux();
	   	$mJeu = new MJeu();
	   	$mJeu->Id($mObjet->Jeu()->Id());
	   	$mJeu->Libelle($mObjet->Jeu()->Libelle());
	   	$mListeJeux->AjouterElement($mJeu);
	   	$this->AjouterReferentielElement($element, array(COL_JEU, COL_ID), $mListeJeux, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
	   	$mListeServeurs = new MListeServeurs();
	   	$mListeServeurs->AjouterColSelection(COL_ID);
	   	$mListeServeurs->AjouterColSelection(COL_LIBELLE);
	   	$mListeServeurs->AjouterFiltreEgal(COL_JEU, $mObjet->Jeu()->Id());
	   	$this->AjouterReferentielElement($element, array(COL_SERVEUR, COL_ID), $mListeServeurs, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));
	   	$mListeTypesGroupes = new MListeTypesGroupes();
	   	$mListeTypesGroupes->AjouterColSelection(COL_ID);
	   	$mListeTypesGroupes->AjouterColSelection(COL_LIBELLE);
	   	$mListeTypesGroupes->AjouterFiltreEgal(COL_JEU, $mObjet->Jeu()->Id());
	   	$this->AjouterReferentielElement($element, array(COL_TYPEGROUPE, COL_ID), $mListeTypesGroupes, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));

	}

	protected function HasDroitConsultation($element)
	{
		return true;
	}

	protected function HasDroitModification($element)
	{
		return false;
	}

	protected function HasDroitCreation()
	{
		return false;
	}

	protected function HasDroitSuppression($element)
	{
		return false;
	}

	protected function ConstruireLigneTitre()
	{
		return NULL;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(4, 4, true);
	   	$org->FusionnerCellule(1, 1, 1, 0);
	   	$org->FusionnerCellule(1, 2, 0, 1);
	   	$org->FusionnerCellule(2, 2, 0, 2);
	   	$org->FusionnerCellule(3, 1, 0, 3);
	   	$org->FusionnerCellule(4, 1, 0, 3);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_NOM));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(array(COL_JEU, COL_LIBELLE, COL_LIBELLE)));
	   	$org1 = new SOrganiseur(1, 3, true);
	   	$org1->AttacherCellule(1, 1, $this->ConstruireChamp(array(COL_SERVEUR, COL_LIBELLE, COL_LIBELLE)));
	   	$org1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_COMMUNAUTE, COL_LIBELLE, COL_LIBELLE)));
	   	$org1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_TYPEGROUPE, COL_LIBELLE, COL_LIBELLE)));
	   	$org1->SetLargeurCellule(1, 1, '33%');
		$org1->SetLargeurCellule(1, 2, '33%');
		$org1->SetLargeurCellule(1, 3, '34%');
	   	$org->AttacherCellule(2, 2, $org1);
	   	$org->AttacherCellule(3, 1, $this->ConstruireChamp(COL_DESCRIPTION));
	   	$org->AttacherCellule(4, 1, $this->ConstruireChamp(COL_HISTOIRE));
		$org->SetLargeurCellule(1, 1, '16%');
		$org->SetLargeurCellule(1, 2, '56%');
		$org->SetLargeurCellule(1, 4, '28%');
		$org->SetLargeurCellule(3, 1, '100%');
		$org->SetLargeurCellule(4, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemModification()
	{
		$elem = parent::ConstruireElemModification();

		$org = new SOrganiseur(4, 4, true);
	   	$org->FusionnerCellule(1, 1, 1, 0);
	   	$org->FusionnerCellule(1, 2, 0, 1);
	   	$org->FusionnerCellule(2, 2, 0, 2);
	   	$org->FusionnerCellule(3, 1, 0, 3);
	   	$org->FusionnerCellule(4, 1, 0, 3);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(array(COL_JEU, COL_ID), LISTE_CHAMPTYPE_MODIF));
	   	$org1 = new SOrganiseur(1, 3, true);
	   	$org1->AttacherCellule(1, 1, $this->ConstruireChamp(array(COL_SERVEUR, COL_ID), LISTE_CHAMPTYPE_MODIF));
	   	$org1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_COMMUNAUTE, COL_ID), LISTE_CHAMPTYPE_MODIF));
	   	$org1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_TYPEGROUPE, COL_ID), LISTE_CHAMPTYPE_MODIF));
	   	$org1->SetLargeurCellule(1, 1, '33%');
		$org1->SetLargeurCellule(1, 2, '33%');
		$org1->SetLargeurCellule(1, 3, '34%');
	   	$org->AttacherCellule(2, 2, $org1);
	   	$org->AttacherCellule(3, 1, $this->ConstruireChamp(COL_DESCRIPTION, LISTE_CHAMPTYPE_MODIF));
	   	$org->AttacherCellule(4, 1, $this->ConstruireChamp(COL_HISTOIRE, LISTE_CHAMPTYPE_MODIF));
		$org->SetLargeurCellule(1, 1, '16%');
		$org->SetLargeurCellule(1, 2, '56%');
		$org->SetLargeurCellule(1, 4, '28%');
		$org->SetLargeurCellule(3, 1, '100%');
		$org->SetLargeurCellule(4, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
		$elem = parent::ConstruireElemCreation();

	   	$org = new SOrganiseur(4, 4, true);
	   	$org->FusionnerCellule(1, 1, 1, 0);
	   	$org->FusionnerCellule(1, 2, 0, 1);
	   	$org->FusionnerCellule(2, 2, 0, 2);
	   	$org->FusionnerCellule(3, 1, 0, 3);
	   	$org->FusionnerCellule(4, 1, 0, 3);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_ICONE, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 2, $this->ConstruireChamp(COL_NOM, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(1, 4, $this->ConstruireChamp(array(COL_JEU, COL_ID), LISTE_CHAMPTYPE_CREAT));
	   	$org1 = new SOrganiseur(1, 3, true);
	   	$org1->AttacherCellule(1, 1, $this->ConstruireChamp(array(COL_SERVEUR, COL_ID), LISTE_CHAMPTYPE_CREAT));
	   	$org1->AttacherCellule(1, 2, $this->ConstruireChamp(array(COL_COMMUNAUTE, COL_ID), LISTE_CHAMPTYPE_CREAT));
	   	$org1->AttacherCellule(1, 3, $this->ConstruireChamp(array(COL_TYPEGROUPE, COL_ID), LISTE_CHAMPTYPE_CREAT));
	   	$org1->SetLargeurCellule(1, 1, '33%');
		$org1->SetLargeurCellule(1, 2, '33%');
		$org1->SetLargeurCellule(1, 3, '34%');
	   	$org->AttacherCellule(2, 2, $org1);
	   	$org->AttacherCellule(3, 1, $this->ConstruireChamp(COL_DESCRIPTION, LISTE_CHAMPTYPE_CREAT));
	   	$org->AttacherCellule(4, 1, $this->ConstruireChamp(COL_HISTOIRE, LISTE_CHAMPTYPE_CREAT));
		$org->SetLargeurCellule(1, 1, '16%');
		$org->SetLargeurCellule(1, 2, '56%');
		$org->SetLargeurCellule(1, 4, '28%');
		$org->SetLargeurCellule(3, 1, '100%');
		$org->SetLargeurCellule(4, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>