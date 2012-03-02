<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeTypesLibelles.php';
require_once PATH_COMPOSANTS.'cListeTypesLibellesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeTypesLibellesAdmin($prefixIdClass, 'TypesLibellesAdmin', $nomContexte, 20, -1, true, 'TypesLibellesAdmin');

	$mListe = new MListeTypesLibelles();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_ORDRE);
	$mListe->AjouterColOrdre(COL_ORDRE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
