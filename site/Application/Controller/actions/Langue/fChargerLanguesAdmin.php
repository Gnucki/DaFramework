<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeLangues.php';
require_once PATH_COMPOSANTS.'cListeLanguesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeLanguesAdmin($prefixIdClass, 'LanguesAdmin', $nomContexte);

	$mListe = new MListeLangues();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_ICONE);
	$numJointure = $mListe->AjouterJointure(COL_COMMUNAUTE, COL_ID);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_ID, COL_COMMUNAUTE.COL_ID);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_COMMUNAUTE.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColOrdre(COL_LIBELLE);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
