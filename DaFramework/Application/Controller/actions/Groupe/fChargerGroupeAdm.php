<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;
require_once INC_SCADRE;
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeCommunautes.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';


if (GDroit::EstConnecte(true) === true)
{
   	$prefixIdClass = PIC_NGPE;
   	// Initialisation des référentiels.
   	GReferentiel::AjouterReferentielFichiers(COL_ICONE, PATH_IMAGES.'Langue/', REF_FICHIERSEXTENSIONS_IMAGES);

	$mListeCommunautes = new MListeCommunautes();
	$mListeCommunautes->AjouterColSelection(COL_ID);
	$mListeCommunautes->AjouterColSelection(COL_LIBELLE);
	$mListeCommunautes->AjouterColOrdre(COL_LIBELLE);
	GReferentiel::AjouterReferentiel(COL_COMMUNAUTE, $mListeCommunautes, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));

	if ($dejaCharge === false)
	{
	   	$jeuId = GSession::Jeu(COL_ID);
	   	$dejaCharge = false;
	   	if ($jeuId == NULL)
	   		$dejaCharge = true;

	   	$mListeJeux = new MListeCommunautes();
		$mListeJeux->AjouterColSelection(COL_ID);
		$mListeJeux->AjouterColSelection(COL_LIBELLE);
		$mListeJeux->AjouterColOrdre(COL_LIBELLE);
		if ($jeuId != NULL)
		{
		   	$mJeu = new MJeu();
		   	$mJeu->Id($jeuId);
		   	$mJeu->Libelle(GSession::Jeu(COL_LIBELLE));
		   	$mListeJeux->AjouterElement($mJeu);
		}
		GReferentiel::AjouterReferentiel(COL_JEU, $mListeJeux, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);

	   	$mListeServeurs = new MListeServeurs();
	   	$mListeServeurs->AjouterColSelection(COL_ID);
		$mListeServeurs->AjouterColSelection(COL_LIBELLE);
		$mListeServeurs->AjouterColOrdre(COL_LIBELLE);
		$mListeServeurs->AjouterFiltreEgal(COL_JEU, $jeuId);
		$mListeServeurs->AjouterFiltreDifferent(COL_SUPPRIME, true);
	   	GReferentiel::AjouterReferentiel(COL_SERVEUR, $mListeServeurs, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), $dejaCharge);

		$mListeTypesGroupes = new MListeTypesGroupes();
		$mListeTypesGroupes->AjouterColSelection(COL_ID);
		$mListeTypesGroupes->AjouterColSelection(COL_LIBELLE);
		$mListeTypesGroupes->AjouterColOrdre(COL_LIBELLE);
		$mListeTypesGroupes->AjouterFiltreEgal(COL_JEU, $jeuId);
		GReferentiel::AjouterReferentiel(COL_TYPEGROUPE, $mListeTypesGroupes, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), $dejaCharge);

		$org = new SOrganiseur(2, 1, true);

		$elem = new SElement($prefixIdClass.CLASSTEXTE_INFO);
		$elem->AjouterClasse(CLASSTEXTE_INFO);
		$elem->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_GPE_NOUVGPEDESC, false, true)));
		$org->AttacherCellule(1, 1, $elem);

		// Construction du formulaire.
		$form = new SForm($prefixIdClass, 2, 1);

		$form->SetCadreInputs(1, 1, 5, 6);
		$form->FusionnerCelluleCadre(1, 1, 1, 1);
		$form->FusionnerCelluleCadre(1, 3, 0, 3);
		$form->FusionnerCelluleCadre(2, 3, 0, 3);
		$form->FusionnerCelluleCadre(3, 1, 0, 1);
		$form->FusionnerCelluleCadre(3, 3, 0, 1);
		$form->FusionnerCelluleCadre(3, 5, 0, 1);
		$form->FusionnerCelluleCadre(4, 1, 0, 5);
		$form->FusionnerCelluleCadre(5, 1, 0, 5);
		$img = $form->AjouterInputImage(1, 1, GSession::Libelle(LIB_GPE_ICONE), '', false, GContexte::FormaterVariable($nomContexte, COL_ICONE), PATH_IMAGES.'Jeu/', '', GSession::Libelle(LIB_GPE_ICONEINFO), '', TYPEFICHIER_IMAGEGLOBALE_JEU, $nomContexte);
		$img->AjouterElementsFromListe(COL_ICONE);
		$form->AjouterInputText(1, 3, GSession::Libelle(LIB_GPE_NOM), '', true, GContexte::FormaterVariable($nomContexte, COL_NOM), '', 1, 100, 50, false, '', GSession::Libelle(LIB_GPE_NOMINFO), GSession::Libelle(LIB_GPE_NOMERREUR), INPUTTEXT_REGEXP_TOUT_FV);
		$select = $form->AjouterInputSelect(2, 3, GSession::Libelle(LIB_GPE_JEU), INPUTSELECT_TYPE_FIND, true, GContexte::FormaterVariable($nomContexte, COL_JEU), GSession::Libelle(LIB_GPE_JEUINFO), GSession::Libelle(LIB_GPE_JEUERREUR), $nomContexte.COL_JEU, $nomContexte.COL_SERVEUR.';'.$nomContexte.COL_TYPEGROUPE);
		$select->AjouterElementsFromListe(COL_JEU, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '', $jeuId);
		$select = $form->AjouterInputSelect(3, 1, GSession::Libelle(LIB_GPE_SERVEUR), '', false, GContexte::FormaterVariable($nomContexte, COL_SERVEUR), '', '', $nomContexte.COL_SERVEUR, '', $nomContexte.COL_JEU, AJAXFONC_CHARGERREFERENTIELCONTEXTE, 'contexte='.$nomContexte);
		$select->AjouterElementsFromListe(COL_SERVEUR, COL_ID, array(COL_LIBELLE, COL_LIBELLE));
		$select = $form->AjouterInputSelect(3, 3, GSession::Libelle(LIB_GPE_COMMUNAUTE), '', true, GContexte::FormaterVariable($nomContexte, COL_COMMUNAUTE), '', GSession::Libelle(LIB_GPE_COMMUNAUTEERREUR));
		$select->AjouterElementsFromListe(COL_COMMUNAUTE, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '', GSession::Communaute(COL_ID));
		$select = $form->AjouterInputSelect(3, 5, GSession::Libelle(LIB_GPE_TYPEGROUPE), '', true, GContexte::FormaterVariable($nomContexte, COL_TYPEGROUPE), GSession::Libelle(LIB_GPE_TYPEGPEINFO), GSession::Libelle(LIB_GPE_TYPEGPEERREUR), $nomContexte.COL_TYPEGROUPE, '', $nomContexte.COL_JEU, AJAXFONC_CHARGERREFERENTIELCONTEXTE, 'contexte='.$nomContexte);
		$select->AjouterElementsFromListe(COL_TYPEGROUPE, COL_ID, array(COL_LIBELLE, COL_LIBELLE));
		$form->AjouterInputText(4, 1, GSession::Libelle(LIB_GPE_DESCRIPTION), '', false, GContexte::FormaterVariable($nomContexte, COL_DESCRIPTION), '', 1, 250, -1, true, '', GSession::Libelle(LIB_GPE_DESCRIPTIONINFO));
		$form->AjouterInputText(5, 1, GSession::Libelle(LIB_GPE_HISTOIRE), '', false, GContexte::FormaterVariable($nomContexte, COL_HISTOIRE), '', 1, NULL, 5, true, '', GSession::Libelle(LIB_GPE_HISTOIREINFO));

		$form->SetCadreBoutons(2, 1, 1, 1);
		$form->AjouterInputButtonAjouterAuContexte(1, 1, $nomContexte, true, GSession::Libelle(LIB_GPE_CREERGROUPE));
		$org->AttacherCellule(2, 1, $form);

		// Cadre contenant le formulaire et son explication.
		$cadre = new SCadre($prefixIdClass, GSession::Libelle(LIB_GPE_CREATIONGPE), $org, true, true);

		GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cadre);
	}
	else
	{
	   	// Rechargement des référentiels.
	   	GReferentiel::GetDifferentielReferentielFichiersForSelect(COL_ICONE);
	   	GReferentiel::GetDifferentielReferentielForSelect(COL_COMMUNAUTE, COL_ID, array(COL_LIBELLE, COL_LIBELLE));
	}
}

?>
