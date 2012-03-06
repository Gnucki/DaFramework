<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeFonctionnalites.php';
require_once PATH_COMPOSANTS.'cListeFonctionnalitesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeFonctionnalitesAdmin($prefixIdClass, 'FoncAdmin', $nomContexte, 20, -1, true, 'FoncAdmin');

	$mListe = new MListeFonctionnalites();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_DESCRIPTION);
	$mListe->AjouterColSelection(COL_ORDRE);
	$mListe->AjouterColSelection(COL_PARAMETRABLE);
	$mListe->AjouterColSelection(COL_NIVEAUGRADEMINIMUM);
	$mListe->AjouterColOrdre(COL_ORDRE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
