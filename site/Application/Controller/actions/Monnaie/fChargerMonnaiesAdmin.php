<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeMonnaies.php';
require_once PATH_COMPOSANTS.'cListeMonnaiesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeMonnaiesAdmin($prefixIdClass, 'MonnaiesAdmin', $nomContexte);

	$mListe = new MListeMonnaies();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_SYMBOLE);
	$mListe->AjouterColSelection(COL_ACTIVE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
