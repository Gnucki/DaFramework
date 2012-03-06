<?php

require_once 'cst.php';
require_once PATH_METIER.'mSuperGrade.php';
require_once PATH_METIER.'mListeGradesGlobaux.php';
require_once PATH_METIER.'mListeGradesGlobauxJoueurs.php';
require_once PATH_COMPOSANTS.'cListeGradesGlobauxAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeGradesGlobauxAdmin($prefixIdClass, 'GradesGlobauxAdmin', $nomContexte);

	$mListe = new MListeGradesGlobaux();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_NOM);
	$mListe->AjouterColSelection(COL_DESCRIPTION);
	$mListe->AjouterColSelection(COL_ICONE);
	$mListe->AjouterColSelection(COL_NIVEAU);
	$mListe->AjouterColSelection(COL_SUPERGRADE);
	$numJointure = $mListe->AjouterJointure(COL_SUPERGRADE, COL_ID, 0, SQL_LEFT_JOIN);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_SUPERGRADE.COL_LIBELLE);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_SUPERGRADE.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColOrdre(COL_NIVEAU, NULL, true);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
