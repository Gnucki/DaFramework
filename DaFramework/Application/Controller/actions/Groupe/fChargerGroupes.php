<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeGroupes.php';
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';
require_once PATH_METIER.'mListeCommunautes.php';
require_once INC_SCADRE;
require_once PATH_COMPOSANTS.'cListeGroupes.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_GPE;
	$cListe = new CListeGroupes($prefixIdClass, 'Groupes', $nomContexte, 20, -1, false, '', true, AJAXFONC_CLIQUERCONTEXTE);

	$mListe = new MListeGroupes();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_NOM);
	$mListe->AjouterColSelection(COL_ICONE);
	$mListe->AjouterColSelection(COL_DESCRIPTION);
	$mListe->AjouterColSelection(COL_HISTOIRE);
	$mListe->AjouterColSelection(COL_JEU);
	$numJointure = $mListe->AjouterJointure(COL_JEU, COL_ID);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_JEU.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColSelection(COL_SERVEUR);
	$numJointure = $mListe->AjouterJointure(COL_SERVEUR, COL_ID);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_SERVEUR.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColSelection(COL_COMMUNAUTE);
	$numJointure = $mListe->AjouterJointure(COL_COMMUNAUTE, COL_ID);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_COMMUNAUTE.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColSelection(COL_TYPEGROUPE);
	$numJointure = $mListe->AjouterJointure(COL_TYPEGROUPE, COL_ID);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_TYPEGROUPE.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColOrdre(COL_NOM);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	{
		$cadre = new SCadre($prefixIdClass, GSession::Libelle(LIB_GPE_LISTEGROUPESJOUEUR), $cListe, true, false);
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cadre);
	}
	else
	   	GContexte::AjouterListe($cListe);
}

?>
