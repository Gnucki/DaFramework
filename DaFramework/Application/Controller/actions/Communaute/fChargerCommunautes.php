<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;
require_once PATH_METIER.'mListeCommunautes.php';


$mListeCommunautes = new MListeCommunautes(false);
$mListeCommunautes->AjouterColSelection(COL_ID);
$mListeCommunautes->AjouterColSelection(COL_LIBELLE);
$mListeCommunautes->AjouterColOrdre(COL_LIBELLE);
GReferentiel::AjouterReferentiel(COL_COMMUNAUTE, $mListeCommunautes, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));

if ($dejaCharge === false)
{
	$selectCommunaute = new SForm('selcom', 1, 1);
	$selectCommunaute->SetCadreInputs(1, 1, 1, 1);
	$select = $selectCommunaute->AjouterInputSelect(1, 1, GSession::Libelle(LIB_CON_COMMUNAUTE), '', true, GContexte::FormaterVariable($nomContexte, 'communaute'));
	$select->AjouterElementsFromListe(COL_COMMUNAUTE, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '', GSession::Communaute(COL_ID));
	GContexte::AjouterContenu(CADRE_INFO_COMMUNAUTE, $selectCommunaute);
}
else
   	GReferentiel::GetDifferentielReferentielForSelect(COL_COMMUNAUTE, COL_ID, array(COL_LIBELLE, COL_LIBELLE));

?>
