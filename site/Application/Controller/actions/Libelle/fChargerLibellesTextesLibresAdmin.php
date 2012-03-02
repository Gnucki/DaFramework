<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeLibellesTextesLibres.php';
require_once PATH_COMPOSANTS.'cListeLibellesTextesLibresAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$prefixIdClass = PIC_ADM;
	$cListe = new CListeLibellesTextesLibresAdmin($prefixIdClass, 'LibellesTextesLibresAdmin', $nomContexte);

	$mListe = new MListeLibellesTextesLibres();
	$mListe->AjouterColSelection(COL_ID);
	$mListe->AjouterColSelection(COL_LIBELLE);
	$mListe->AjouterColSelection(COL_TYPELIBELLE);
	$mListe->AjouterColSelection(COL_LANGUE);
	$mListe->AjouterFiltreEgal(COL_LANGUE, GSession::Langue(COL_ID));
	$numJointure = $mListe->AjouterJointure(COL_LANGUEORIGINELLE, COL_ID);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_LANGUE.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$numJointure = $mListe->AjouterJointure(COL_TYPELIBELLE, COL_ID);
	$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
	$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_TYPELIBELLE.COL_LIBELLE);
	$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
	$mListe->AjouterColOrdre(COL_ID);

	$cListe->InjecterListeObjetsMetiers($mListe);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
