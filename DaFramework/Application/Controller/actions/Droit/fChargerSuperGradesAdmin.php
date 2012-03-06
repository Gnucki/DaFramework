<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeSuperGrades.php';
require_once PATH_METIER.'mListeDroitsSuperGrades.php';
require_once PATH_COMPOSANTS.'cListeSuperGradesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeSuperGradesAdmin($prefixIdClass, 'SuperGradesAdmin', $nomContexte);

	$mListe = new MListeSuperGrades();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_DESCRIPTION);
	$mListe->AjouterColSelection(COL_ICONE);
	$mListe->AjouterColSelection(COL_NIVEAU);
	$mListe->AjouterColSelection(COL_POIDSVOTERECRUTEMENT);
	$mListe->AjouterColOrdre(COL_NIVEAU, NULL, true);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
