<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeTypesGroupes.php';
require_once PATH_COMPOSANTS.'cListeTypesGroupesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeTypesGroupesAdmin($prefixIdClass, 'TypesGroupesAdmin', $nomContexte);

	$mListe = new MListeTypesGroupes();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterFiltreEgal(COL_JEU, SQL_NULL);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
