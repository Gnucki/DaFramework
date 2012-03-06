<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeMenus.php';
require_once PATH_COMPOSANTS.'cListeMenusAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeMenusAdmin($prefixIdClass, 'MenusAdmin', $nomContexte, 20, -1, true, 'MenusAdmin');

	$mListe = new MListeMenus();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_ORDRE);
	$mListe->AjouterColSelection(COL_MENU);
	$mListe->AjouterColSelection(COL_DEPENDFONCTIONNALITE);
	$numJointure = $mListe->AjouterJointure(COL_MENU, COL_ID, 0, SQL_LEFT_JOIN);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure, SQL_LEFT_JOIN);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_MENU.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColOrdre(COL_ORDRE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
