<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeGroupes.php';
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';
require_once PATH_METIER.'mListeCommunautes.php';
require_once PATH_METIER.'mListePresentations.php';
require_once PATH_METIER.'mListeTypesPresentationsModules.php';
require_once INC_SCADRE;
require_once INC_SCENTREUR;
require_once INC_SCLASSEUR;
require_once INC_SSEPARATEUR;
require_once INC_SPALETTE;
require_once PATH_COMPOSANTS.'cListeGroupes.php';


$groupe = GSession::Groupe(COL_ID);
if ($groupe !== NULL && GDroit::ADroitPopErreur(FONC_PRS_CREERMODIFIER) === true)
{
	$prefixIdClass = PIC_PRES;

	$mListePresentationsActives = new MListePresentations();
	$mListePresentationsActives->AjouterColSelection(COL_ID);
	$mListePresentationsActives->AjouterColSelection(COL_NOM);
	$mListePresentationsActives->AjouterFiltreEgal(COL_CREATEURGROUPE, GSession::Groupe(COL_ID));
	GReferentiel::AjouterReferentiel(COL_PRESENTATION.'active', $mListePresentationsActives, array(COL_ID, COL_NOM));

	$mListePresentationsModif = new MListePresentations();
	$mListePresentationsModif->AjouterColSelection(COL_ID);
	$mListePresentationsModif->AjouterColSelection(COL_NOM);
	$mListePresentationsModif->AjouterFiltreEgal(COL_CREATEURGROUPE, GSession::Groupe(COL_ID));
	GReferentiel::AjouterReferentiel(COL_PRESENTATION.'modif', $mListePresentationsModif, array(COL_ID, COL_NOM));

	if ($dejaCharge === false)
	{
		$org = new SOrganiseur(8, 1, true);

		$elemInfo = new SElement($prefixIdClass.CLASSTEXTE_INFO);
		$elemInfo->AjouterClasse(CLASSTEXTE_INFO);
		$elemInfo->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_PRS_DESCRIPTION, false, true)));

		$elemInfoPresActive = new SElement($prefixIdClass.CLASSTEXTE_INFO);
		$elemInfoPresActive->AjouterClasse(CLASSTEXTE_INFO);
		$elemInfoPresActive->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_PRS_PRESACTIVE, false, true)));

		$elemInfoPresModif = new SElement($prefixIdClass.CLASSTEXTE_INFO);
		$elemInfoPresModif->AjouterClasse(CLASSTEXTE_INFO);
		$elemInfoPresModif->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_PRS_PRESMODIF, false, true)));

		//$rechargeFonc = AJAXFONC_CHARGERREFERENTIELCONTEXTE;
		//$rechargeParam = 'contexte='.$nomContexte;
		$changeFonc = AJAXFONC_MODIFIERDANSCONTEXTE;
		$changeParam = 'cf='.GSession::NumCheckFormulaire().'&contexte='.$nomContexte;

		$selectPresActive = new SForm($prefixIdClass, 1, 2, true, false);
		$selectPresActive->SetCadreInputs(1, 1, 1, 1);
		$select = $selectPresActive->AjouterInputSelect(1, 1, GSession::Libelle(LIB_PRS_PRESACTIVE), '', true, GContexte::FormaterVariable($nomContexte, COL_PRESENTATION.'active'), '', '', '', '', '', '', '', $changeFonc, $changeParam);
		$select->AjouterElementsFromListe(COL_PRESENTATION.'active', COL_ID, COL_NOM, '', GSession::PresentationActive());
		$selectPresActive->SetCadreBoutonsCache(1, 2);
		$elemPresActive = new SCentreur($selectPresActive);

		$selectPresModif = new SForm($prefixIdClass, 1, 2, false, false);
		$selectPresModif->SetCadreInputs(1, 1, 1, 1);
		$select = $selectPresModif->AjouterInputNewSelect(1, 1, GSession::Libelle(LIB_PRS_PRESMODIF), true, GContexte::FormaterVariable($nomContexte, COL_PRESENTATION.'modif'), '', '', '', '', '', '', '', $changeFonc, $changeParam);
		$formCreerPres = new SForm($prefixIdClass, 2, 1);
		$formCreerPres->SetCadreInputs(1, 1, 1, 1);
		$formCreerPres->AjouterInputText(1, 1, GSession::Libelle(LIB_PRS_NOM), '', true, GContexte::FormaterVariable($nomContexte, COL_NOM), '', 1, 200, 40);
		$formCreerPres->SetCadreBoutons(2, 1, 1, 2);
		$bouton = $formCreerPres->AjouterInputButtonAjouterAuContexte(1, 1, $nomContexte);
		$bouton->AjouterParamRetour('nouvPres', '1');
		$formCreerPres->AjouterInputButtonAnnuler(1, 2);
		$select->AjouterFormulaire(GSession::Libelle(LIB_PRS_CREERPRES), $formCreerPres);
		$select->AjouterElementsFromListe(COL_PRESENTATION.'modif', COL_ID, COL_NOM, '', GSession::PresentationModif());
		$selectPresModif->SetCadreBoutonsCache(1, 2);
		$elemPresModif = new SCentreur($selectPresModif);

		$classeurPres = new SClasseur($prefixIdClass, 'pres', true, true);
		$mListe = new MListeTypesPresentationsModules();
		$mListe->AjouterColSelection(COL_ID);
		$mListe->AjouterColSelection(COL_LIBELLE);
		$mListe->AjouterFiltreEgal(COL_ACTIF, true);
		$mListe->Charger();
		$liste = $mListe->GetListe();
		foreach ($liste as $mObjet)
		{
			GContexte::AjouterOnglet('pres', $mObjet->Libelle(), '', AJAXFONC_AJOUTERAUCONTEXTE, 'contexte='.CONT_PRESENTATION.'&'.GContexte::FormaterVariable(CONT_PRESENTATION, 'ongletContexte').'='.CONT_PRESENTATIONMODULE.'_'.$mObjet->Id(), false, GContexte::IsContexteExiste(CONT_PRESENTATIONMODULE.'_'.$mObjet->Id(), true));
		}

		$org->AttacherCellule(1, 1, $elemInfo);
		$org->AttacherCellule(2, 1, new SSeparateur($prefixIdClass));
		$org->AttacherCellule(3, 1, $elemInfoPresActive);
		$org->AttacherCellule(4, 1, $elemPresActive);
		$org->AttacherCellule(5, 1, new SSeparateur($prefixIdClass));
		$org->AttacherCellule(6, 1, $elemInfoPresModif);
		$org->AttacherCellule(7, 1, $elemPresModif);
		$org->AttacherCellule(8, 1, $classeurPres);

		$cadre = new SCadre($prefixIdClass, GSession::Libelle(LIB_PRS_PRESENTATION), $org, true, false);

		$palette = new SPalette($prefixIdClass, GSession::Libelle(LIB_PRS_PALETTE));
		GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $palette);

		$div = new SBalise(BAL_DIV);
		$div->Attach($palette);
		$div->Attach($cadre);

	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $div);
	}
	else
	{
	   	GReferentiel::GetDifferentielReferentielForSelect(COL_PRESENTATION.'active', COL_ID, COL_NOM, '');//, GSession::PresentationActive());
	   	GReferentiel::GetDifferentielReferentielForSelect(COL_PRESENTATION.'modif', COL_ID, COL_NOM, '');//, GSession::PresentationModif());
	}
}

?>
