<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeContextes.php';
require_once PATH_COMPOSANTS.'cListeContextesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeContextesAdmin($prefixIdClass, 'ContextesAdmin', $nomContexte);

	$mListe = new MListeContextes();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_NOM);
	$mListe->AjouterColOrdre(COL_NOM);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
