<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;
require_once INC_SCADRE;
require_once PATH_METIER.'mJeu.php';
require_once PATH_METIER.'mListeTypesJeux.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';
require_once PATH_COMPOSANTS.'cListeJeuServeurs.php';
require_once PATH_COMPOSANTS.'cListeJeuTypesGroupes.php';


$jeu = GSession::Jeu(COL_ID);
if ($jeu != NULL && GDroit::ADroitPopErreur(FONC_ADM_JEU) === true)
{
   	// Initialisation des référentiels.
   	GReferentiel::AjouterReferentielFichiers(COL_ICONE, PATH_IMAGES.'Langue/', REF_FICHIERSEXTENSIONS_IMAGES);

	$mListeTypesJeux = new MListeTypesJeux();
	$mListeTypesJeux->AjouterColSelection(COL_ID);
	$mListeTypesJeux->AjouterColSelection(COL_LIBELLE);
	$mListeTypesJeux->AjouterColSelection(COL_DESCRIPTION);
	$mListeTypesJeux->AjouterColOrdre(COL_LIBELLE);
	GReferentiel::AjouterReferentiel(COL_TYPEJEU, $mListeTypesJeux, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE), array(COL_DESCRIPTION, COL_LIBELLE)));

	if ($dejaCharge === false)
	{
	   	$mJeu = new MJeu($jeu);
	   	$mJeu->Charger();

	   	// Construction des 2 listes du formulaire.
	   	$mListeServeurs = new MListeServeurs();
	   	$mListeServeurs->AjouterColSelection(COL_ID);
   		$mListeServeurs->AjouterColSelection(COL_LIBELLE);
		$mListeServeurs->AjouterColOrdre(COL_LIBELLE);
		$mListeServeurs->AjouterFiltreEgal(COL_JEU, $jeu);
	   	$mListeServeurs->Charger();
	   	GReferentiel::AjouterReferentiel(COL_SERVEUR, $mListeServeurs, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
		$cListeJeuServeurs = new CListeJeuServeurs(PIC_JEU, COL_SERVEUR, $nomContexte);
		$cListeJeuServeurs->InjecterListeObjetsMetiers($mListeServeurs, true);
		$mListeTypesGroupes = new MListeTypesGroupes();
		$mListeTypesGroupes->AjouterColSelection(COL_ID);
   		$mListeTypesGroupes->AjouterColSelection(COL_LIBELLE);
		$mListeTypesGroupes->AjouterColOrdre(COL_LIBELLE);
		$mListeTypesGroupes->AjouterFiltreEgal(COL_JEU, $jeu);
	   	$mListeTypesGroupes->Charger();
		GReferentiel::AjouterReferentiel(COL_TYPEGROUPE, $mListeTypesGroupes, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
		$cListeJeuTypesGroupes = new CListeJeuTypesGroupes(PIC_JEU, COL_TYPEGROUPE, $nomContexte);
		$cListeJeuTypesGroupes->InjecterListeObjetsMetiers($mListeTypesGroupes, true);

		// Construction du formulaire.
		$form = new SForm(PIC_JEU, 3, 1);

		$form->SetCadreInputs(1, 1, 9, 2);
		$form->FusionnerCelluleCadre(2, 1, 0, 1);
		$form->FusionnerCelluleCadre(3, 1, 0, 1);
		$form->FusionnerCelluleCadre(4, 1, 0, 1);
		$form->FusionnerCelluleCadre(5, 1, 0, 1);
		$form->FusionnerCelluleCadre(7, 1, 0, 1);
		$form->FusionnerCelluleCadre(8, 1, 0, 1);
		$form->FusionnerCelluleCadre(9, 1, 0, 1);
		$img = $form->AjouterInputImage(1, 1, GSession::Libelle(LIB_JEU_ICONE), '', false, GContexte::FormaterVariable($nomContexte, COL_ICONE), PATH_IMAGES.'Jeu/', '', GSession::Libelle(LIB_JEU_ICONEINFO), '', TYPEFICHIER_IMAGEGLOBALE_JEU, $nomContexte);
		$img->AjouterElementsFromListe(COL_ICONE, $mJeu->Icone());
		$form->AjouterInputText(1, 2, GSession::Libelle(LIB_JEU_NOM), '', true, GContexte::FormaterVariable($nomContexte, array(COL_LIBELLE, COL_LIBELLE)), $mJeu->Libelle(), 1, 100, 50, false, '', GSession::Libelle(LIB_JEU_NOMINFO), GSession::Libelle(LIB_JEU_NOMERREUR), INPUTTEXT_REGEXP_TOUT_FV);
		$select = $form->AjouterInputSelect(2, 1, GSession::Libelle(LIB_JEU_TYPEJEU), '', true, GContexte::FormaterVariable($nomContexte, COL_TYPEJEU), GSession::Libelle(LIB_JEU_TYPEJEUINFO), GSession::Libelle(LIB_JEU_TYPEJEUERREUR), $nomContexte.COL_TYPEJEU);
		$select->AjouterElementsFromListe(COL_TYPEJEU, COL_ID, array(COL_LIBELLE, COL_LIBELLE), array(COL_DESCRIPTION, COL_LIBELLE), $mJeu->TypeJeu()->Id());
		$checkbox = $form->AjouterInputCheckbox(3, 1, GSession::Libelle(LIB_JEU_NECBOSS), '', false, GContexte::FormaterVariable($nomContexte, COL_NECESSITEBOSS));
		$checkbox->AjouterCheckbox('', GSession::Libelle(LIB_JEU_NECBOSSINFO), $mJeu->NecessiteBoss());
		$checkbox = $form->AjouterInputCheckbox(4, 1, GSession::Libelle(LIB_JEU_NECCLASSE), '', false, GContexte::FormaterVariable($nomContexte, COL_NECESSITECLASSE), GSession::Libelle(LIB_JEU_NECCLASSEINFO));
		$checkbox->AjouterCheckbox('', GSession::Libelle(LIB_JEU_NECCLASSEINFO), $mJeu->NecessiteClasse());
		$checkbox = $form->AjouterInputCheckbox(5, 1, GSession::Libelle(LIB_JEU_NECMETIER), '', false, GContexte::FormaterVariable($nomContexte, COL_NECESSITEMETIER), GSession::Libelle(LIB_JEU_NECMETIERINFO));
		$checkbox->AjouterCheckbox('', GSession::Libelle(LIB_JEU_NECMETIERINFO), $mJeu->NecessiteMetier());
		$checkbox = $form->AjouterInputCheckbox(6, 1, GSession::Libelle(LIB_JEU_NECNIVEAU), '', false, GContexte::FormaterVariable($nomContexte, COL_NECESSITENIVEAU), GSession::Libelle(LIB_JEU_NECNIVEAUINFO));
		$checkbox->AjouterCheckbox('', GSession::Libelle(LIB_JEU_NECNIVEAUINFO), $mJeu->NecessiteNiveau());
		$form->AjouterInputText(6, 2, GSession::Libelle(LIB_JEU_NIVEAUMAX), '', false, GContexte::FormaterVariable($nomContexte, COL_NIVEAUMAX), $mJeu->NiveauMax(), 1, 5, 5, false, '', GSession::Libelle(LIB_JEU_NIVEAUMAXINFO), '', INPUTTEXT_REGEXP_DECIMAL_FV);
		$checkbox = $form->AjouterInputCheckbox(7, 1, GSession::Libelle(LIB_JEU_NECOBJET), '', false, GContexte::FormaterVariable($nomContexte, COL_NECESSITEOBJET), GSession::Libelle(LIB_JEU_NECOBJETINFO));
		$checkbox->AjouterCheckbox('', GSession::Libelle(LIB_JEU_NECOBJETINFO), $mJeu->NecessiteObjet());
		$checkbox = $form->AjouterInputCheckbox(8, 1, GSession::Libelle(LIB_JEU_NECROLE), '', false, GContexte::FormaterVariable($nomContexte, COL_NECESSITEROLE), GSession::Libelle(LIB_JEU_NECROLEINFO));
		$checkbox->AjouterCheckbox('', GSession::Libelle(LIB_JEU_NECROLEINFO), $mJeu->NecessiteRole());
		$checkbox = $form->AjouterInputCheckbox(9, 1, GSession::Libelle(LIB_JEU_NECSERVEUR), '', false, GContexte::FormaterVariable($nomContexte, COL_NECESSITESERVEUR), GSession::Libelle(LIB_JEU_NECSERVEURINFO));
		$checkbox->AjouterCheckbox('', GSession::Libelle(LIB_JEU_NECSERVEURINFO), $mJeu->NecessiteServeur());

		$form->SetCadreInputs(2, 1, 1, 2, true, false);
		$form->SetLargeurCelluleCadre(1, 1, '50%');
		$form->SetLargeurCelluleCadre(1, 2, '50%');
		$form->AjouterPropCelluleCadre(1, 1, PROP_STYLE, 'vertical-align: top');
		$form->AjouterPropCelluleCadre(1, 2, PROP_STYLE, 'vertical-align: top');
		$liste = $form->AjouterInputListe(1, 1, GSession::Libelle(LIB_JEU_SERVEURS), '', false, GContexte::FormaterVariable($nomContexte, COL_SERVEUR), GSession::Libelle(LIB_JEU_SERVEURSINFO));
		$liste->AjouterListe($cListeJeuServeurs);
		$liste = $form->AjouterInputListe(1, 2, GSession::Libelle(LIB_JEU_TYPESGROUPES), '', false, GContexte::FormaterVariable($nomContexte, COL_TYPEGROUPE), GSession::Libelle(LIB_JEU_TYPESGROUPESINFO));
		$liste->AjouterListe($cListeJeuTypesGroupes);

		$form->SetCadreBoutons(3, 1, 1, 1);
		$bouton = $form->AjouterInputButtonModifierDansContexte(1, 1, $nomContexte, true, GSession::Libelle(LIB_JEU_MODIFIERJEU));
		$bouton->AjouterParamRetour(GContexte::FormaterVariable($nomContexte, COL_ID), $mJeu->Id());

		// Cadre contenant le formulaire et son explication.
		$cadre = new SCadre(PIC_JEU, GSession::Libelle(LIB_JEU_ADMINISTRATIONJEU), $form, true, true);

		GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cadre);
	}
	else
	{
	   	// Rechargement des référentiels.
	   	GReferentiel::GetDifferentielReferentielFichiersForSelect(COL_ICONE);
	   	GReferentiel::GetDifferentielReferentielForSelect(COL_TYPEJEU, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE), array(COL_DESCRIPTION, COL_LIBELLE)));
	}
}

?>
