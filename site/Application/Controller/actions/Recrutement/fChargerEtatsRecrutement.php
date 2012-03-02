<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeEtatsRecrutement.php';
require_once PATH_COMPOSANTS.'cListeEtatsRecrutementAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeEtatsRecrutementAdmin($prefixIdClass, 'EtatsRecrutementAdmin', $nomContexte, 20, -1, true, 'EtatsRecrutementAdmin');

	$mListe = new MListeEtatsRecrutement();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_DESCRIPTION);
	$mListe->AjouterColSelection(COL_ORDRE);
	$mListe->AjouterColOrdre(COL_ORDRE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
