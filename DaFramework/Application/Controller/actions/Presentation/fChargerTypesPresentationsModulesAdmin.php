<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeTypesPresentationsModules.php';
require_once PATH_COMPOSANTS.'cListeTypesPresentationsModulesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeTypesPresentationsModulesAdmin($prefixIdClass, 'TypesPresModAdmin', $nomContexte, 20, -1, true, 'TypesPresModAdmin');

	$mListe = new MListeTypesPresentationsModules();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_DESCRIPTION);
	$mListe->AjouterColSelection(COL_ORDRE);
	$mListe->AjouterColSelection(COL_NOMFICHIER);
	$mListe->AjouterColSelection(COL_ACTIF);
	$mListe->AjouterColOrdre(COL_ORDRE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
