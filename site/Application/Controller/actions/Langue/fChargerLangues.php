<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;
require_once PATH_METIER.'mListeLangues.php';


$mListeLangues = new MListeLangues(false);
$mListeLangues->AjouterColSelection(COL_ID);
$mListeLangues->AjouterColSelection(COL_LIBELLE);
$mListeLangues->AjouterColOrdre(COL_LIBELLE);
GReferentiel::AjouterReferentiel(COL_LANGUE, $mListeLangues, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)));

if ($dejaCharge === false)
{
	$selectLangue = new SForm('sellan', 1, 1);
	$selectLangue->SetCadreInputs(1, 1, 1, 1);
	$select = $selectLangue->AjouterInputSelect(1, 1, GSession::Libelle(LIB_CON_LANGUE), '', true, GContexte::FormaterVariable($nomContexte, 'langue'));
	$select->AjouterElementsFromListe(COL_LANGUE, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '', GSession::Langue(COL_ID));
	GContexte::AjouterContenu(CADRE_INFO_LANGUE, $selectLangue);
}
else
   	GReferentiel::GetDifferentielReferentielForSelect(COL_LANGUE, COL_ID, array(COL_LIBELLE, COL_LIBELLE));

?>
