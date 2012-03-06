<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeCommunautes.php';
require_once PATH_COMPOSANTS.'cListeCommunautesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeCommunautesAdmin($prefixIdClass, 'CommunautesAdmin', $nomContexte);

	$mListe = new MListeCommunautes();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_ICONE);
	$mListe->AjouterColOrdre(COL_LIBELLE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
