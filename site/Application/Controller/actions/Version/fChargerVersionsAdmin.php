<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeVersions.php';
require_once PATH_COMPOSANTS.'cListeVersionsAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeVersionsAdmin($prefixIdClass, 'VersionsAdmin', $nomContexte);

	$mListe = new MListeVersions();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_VERSION);
	$mListe->AjouterColSelection(COL_COMMENTAIRE);
	$mListe->AjouterColOrdre(COL_DATEPROD);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
