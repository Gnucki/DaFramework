<?php

require_once 'cst.php';
require_once INC_SCADRE;
require_once INC_SFORM;
require_once INC_SVISUALISEUR;
require_once INC_SCLASSEUR;
require_once INC_GJS;
require_once PATH_COMPOSANTS.'cListeCssParties.php';
require_once PATH_COMPOSANTS.'cListeCssElements.php';
require_once PATH_COMPOSANTS.'cListeModificationPresentation.php';
require_once PATH_METIER.'mPresentation.php';
require_once PATH_METIER.'mPresentationModule.php';
require_once PATH_METIER.'mTypePresentationModule.php';
require_once PATH_METIER.'mListePresentationsModules.php';
require_once PATH_METIER.'mListeTypesPresentationsModules.php';


$groupe = GSession::Groupe(COL_ID);
if ($groupe !== NULL && GDroit::ADroitPopErreur(FONC_PRS_CREERMODIFIER) === true)
{
   	if (SListe::IsChargementEtage() === true)
	{
   		$cListeModificationPresentation = new cListeModificationPresentation('', 'ModifPres', $nomContexte, -1, -1, false, '', true, '', '', '', '', '', '', '', AJAXFONC_RECHARGER);
		$libelle = GSession::Libelle(LIB_PRS_CHAMP, true, true);
		$cListeModificationPresentation->AjouterElement($libelle.'10', $libelle, '', $libelle, $libelle, $libelle);
		$cListeModificationPresentation->AjouterElement($libelle.'11', $libelle, '', $libelle, $libelle, $libelle);
		$cListeModificationPresentation->AjouterElement($libelle.'12', $libelle, '', $libelle, $libelle, $libelle);

	   	GContexte::AjouterListe($cListeModificationPresentation);
   	}
   	else
   	{
	   	$presentationModif = GSession::PresentationModif();
	   	$presentationModule = GSession::PresentationModule($module);
	   	if ($presentationModif !== $presentationModule || $dejaCharge === false)
		{
		   	GSession::PresentationModule($module, $presentationModif, true);

		   	$prefixIdClass = PIC_PRES;
		   	// Récupération du nom de fichier.
		   	$mPresentationModule = new MPresentationModule();
		   	$mPresentationModule->TypePresentationModule($module);
		   	$mTypePresentationModule = $mPresentationModule->TypePresentationModule();
		   	$mTypePresentationModule->AjouterColSelection(COL_NOMFICHIER);
		   	$mTypePresentationModule->Charger();
		   	$nomFichier = $mTypePresentationModule->NomFichier();

		   	/*********************************************/
			$cListeCssParties = new CListeCssParties($nomFichier, $presentationModif, $prefixIdClass, 'CssParties', $nomContexte, -1);

			$vue = new SOrganiseur(4, 1, true);
		   	$org = new SOrganiseur(5, 1, true);
			$elem = new SElement(CLASSTEXTE_INFO);
		   	$elem->SetText(GSession::Libelle(LIB_PRS_TEXTEINFO));
		   	$org->AttacherCellule(1, 1, $elem);
		   	$elem = new SElement(CLASSSEPARATEUR);
		   	$org->AttacherCellule(2, 1, $elem);
		   	$elem = new SElement(CLASSCADRE_INFO);
		   	$elem->SetText(GSession::Libelle(LIB_PRS_CADREINFO));
		   	$org->AttacherCellule(3, 1, $elem);
		   	$elem = new SElement(CLASSSEPARATEUR);
		   	$org->AttacherCellule(4, 1, $elem);
		   	$elem = new SElement(CLASSCADRE_ERREUR);
		   	$elem->SetText(GSession::Libelle(LIB_PRS_CADREERREUR));
		   	$org->AttacherCellule(5, 1, $elem);
		   	$cadre = new SCadre('', GSession::Libelle(LIB_PRS_CADRESTEXTE), $org, true, false);
		   	$vue->AttacherCellule(1, 1, $cadre);

			$form = new SForm('', 2, 1);
		   	$form->SetCadreInputs(1, 1, 2, 3);
		   	$select = $form->AjouterInputSelect(1, 1, GSession::Libelle(LIB_PRS_LISTEDER), '', true);
		   	for ($i = 0; $i < 15; $i++)
			{
			  	$select->AjouterElement($i, GSession::Libelle(LIB_PRS_ELEMENT));
			}
		   	$select = $form->AjouterInputFile(1, 2, GSession::Libelle(LIB_PRS_LISTEDERFICHIER), '', true);
		   	for ($i = 0; $i < 15; $i++)
			{
			  	$select->AjouterElement($i, GSession::Libelle(LIB_PRS_ELEMENT));
			}
		   	$select = $form->AjouterInputNewSelect(1, 3, GSession::Libelle(LIB_PRS_LISTEDERBOUTON), true);
		   	$formIn = new SForm('', 0, 0);
			$select->AjouterFormulaire(GSession::Libelle(LIB_PRS_NOUVEAU), $formIn);
			for ($i = 0; $i < 15; $i++)
			{
			  	$select->AjouterElement($i, GSession::Libelle(LIB_PRS_ELEMENT));
			}
			$form->AjouterInputText(2, 1, GSession::Libelle(LIB_PRS_TEXTEAEDITER), '', false);
		   	$form->AjouterInputCheckbox(2, 2, GSession::Libelle(LIB_PRS_CASEACOCHER), '', false);
		   	$form->AjouterInputInfo(2, 3, GSession::Libelle(LIB_PRS_INFOFORM), false);
			$form->SetCadreBoutons(2, 1, 1, 1);
			$form->AjouterInputButton(1, 1, '', GSession::Libelle(LIB_PRS_BOUTON));
			$cadre = new SCadre('', GSession::Libelle(LIB_PRS_FORM), $form, true, false);
		   	$vue->AttacherCellule(2, 1, $cadre);

		   	$liste = new SElement(CLASSSEPARATEUR);
		   	$cListeModificationPresentation = new cListeModificationPresentation('', 'ModifPres', $nomContexte, -1, -1, false, '', true, '', '', '', '', '', '', '', AJAXFONC_RECHARGER);
		   	$libelle = GSession::Libelle(LIB_PRS_CHAMP, true, true);
			$cListeModificationPresentation->AjouterElement($libelle.'10', $libelle, '', $libelle, $libelle, $libelle);
		   	$cListeModificationPresentation->AjouterElement($libelle.'11', $libelle, '', $libelle, $libelle, $libelle);
		   	$cListeModificationPresentation->AjouterElement($libelle.'12', $libelle, '', $libelle, $libelle, $libelle);
			$cadre = new SCadre('', GSession::Libelle(LIB_PRS_LISTES), $cListeModificationPresentation, true, false);
		   	$vue->AttacherCellule(3, 1, $cadre);

		   	$classeur = new SClasseur('', 'presex', true, true);
		   	GContexte::AjouterOnglet('presex', GSession::Libelle(LIB_PRS_ONGLET), '', '', '', true, false);
			GContexte::AjouterOnglet('presex', GSession::Libelle(LIB_PRS_ONGLET), '', '', '', true, false);
		   	GContexte::AjouterOnglet('presex', GSession::Libelle(LIB_PRS_ONGLET), '', '', '', true, false);
		   	$cadre = new SCadre('', GSession::Libelle(LIB_PRS_TABONGLETS), $classeur, true, false);
		   	$vue->AttacherCellule(4, 1, $cadre);

			$cListeCssParties->AjouterElement(GSession::Libelle(LIB_PRS_PRESGEN, false, true), $vue);
			/*********************************************/

		   	$form = new SForm($prefixIdClass, 2, 1, true, false);
			$form->SetCadreInputs(1, 1, 1, 1);
			$form->AjouterInput(1, 1, '', $cListeCssParties, false);
			$form->SetCadreBoutons(2, 1, 1, 1);
			$form->AjouterInputButtonModifierDansContexte(1, 1, $nomContexte, false, GSession::Libelle(LIB_PRS_SAUVEGARDER));

	       	GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $form);

	       	$mListePresentationsModules = new mListePresentationsModules();
			$mListePresentationsModules->AjouterColSelection(COL_RESSOURCEJS);
			$mListePresentationsModules->AjouterFiltreEgal(COL_PRESENTATION, $presentationModif);
			$numJointure = $mListePresentationsModules->AjouterJointure(COL_TYPEPRESENTATIONMODULE, COL_ID, 0, SQL_RIGHT_JOIN);
			$mListePresentationsModules->AjouterColSelectionPourJointure($numJointure, COL_ID);
			$mListePresentationsModules->AjouterFiltreEgalPourJointure($numJointure, COL_ACTIF, true);
			$mListePresentationsModules->Charger();

			foreach($mListePresentationsModules->GetListe() as $mPresentationModule)
			{
				if ($mPresentationModule->RessourceJS() != NULL)
				   	GReponse::AjouterElementJS($mPresentationModule->TypePresentationModule()->Id(), PATH_SERVER_HTTP.$mPresentationModule->RessourceJS(), true);
				else
				   	GReponse::AjouterElementJS($mPresentationModule->TypePresentationModule()->Id(), '', true);
			}
	    }
	}
}

?>
