<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeTypesJeux.php';
require_once PATH_COMPOSANTS.'cListeTypesJeuxAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeTypesJeuxAdmin($prefixIdClass, 'TypesJeuxAdmin', $nomContexte);

	$mListe = new MListeTypesJeux();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_DESCRIPTION);
	$mListe->AjouterColOrdre(COL_LIBELLE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
