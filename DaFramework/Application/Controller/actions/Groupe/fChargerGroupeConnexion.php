<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeGroupes.php';


$mGroupe = NULL;
$mJeu = NULL;
$mListeJeux = new MListeJeux();
$jeuId = GSession::Jeu(COL_ID);
if ($jeuId != NULL)
{
   	$mJeu = new MJeu();
   	$mJeu->Id($jeuId);
   	$mJeu->Libelle(GSession::Jeu(COL_LIBELLE));
   	$mListeJeux->AjouterElement($mJeu);
}

$mListeGroupes = new MListeGroupes();
$groupeId = GSession::Groupe(COL_ID);
if ($groupeId != NULL)
{
   	$mGroupe = new MGroupe();
   	$mGroupe->Id($groupeId);
   	$mGroupe->Nom(GSession::Groupe(COL_NOM));
   	$mGroupe->Description(GSession::Groupe(COL_DESCRIPTION));
   	if ($mJeu !== NULL)
   	{
   		$mGroupe->Jeu()->Id($mJeu->Id());
   		$mGroupe->Jeu()->Libelle($mJeu->Libelle());
   	}
   	$mListeGroupes->AjouterElement($mGroupe);
}

if ($dejaCharge === false)
{
	$rechargeFonc = AJAXFONC_CHARGERREFERENTIELCONTEXTE;
	$rechargeParam = 'contexte='.$nomContexte;
	$changeFonc = AJAXFONC_MODIFIERDANSCONTEXTE;
	$changeParam = 'cf='.GSession::NumCheckFormulaire().'&contexte='.$nomContexte;

	GReferentiel::AjouterReferentiel(COL_JEU, $mListeJeux, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
	GReferentiel::AjouterReferentiel(COL_GROUPE, $mListeGroupes, array(COL_ID, COL_NOM, COL_DESCRIPTION, COL_JEU), true);

	$selectGroupe = new SForm(PIC_LOC, 1, 2, false, false);
	$selectGroupe->SetCadreInputs(1, 1, 1, 2);
	$select = $selectGroupe->AjouterInputSelect(1, 1, GSession::Libelle(LIB_CON_JEU), INPUTSELECT_TYPE_FIND, true, GContexte::FormaterVariable($nomContexte, COL_JEU), '', '', $nomContexte.COL_JEU, ''/*$nomContexte.COL_GROUPE*/, '', $rechargeFonc, $rechargeParam, $changeFonc, $changeParam);
	$select->AjouterElementsFromListe(COL_JEU, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '', $jeuId);
	$select = $selectGroupe->AjouterInputSelect(1, 2, GSession::Libelle(LIB_CON_GROUPE), INPUTSELECT_TYPE_FIND, true, GContexte::FormaterVariable($nomContexte, COL_GROUPE), '', '', $nomContexte.COL_GROUPE, '', ''/*$nomContexte.COL_JEU*/, $rechargeFonc, $rechargeParam, $changeFonc, $changeParam);
	$select->AjouterReference(COL_GROUPE);
	$select->AjouterCategorie(0, 'Groupes généraux');
	$mTypeGroupe = new MTypeGroupe(TYPEGROUPE_COMMUNAUTE);
	$mTypeGroupe->AjouterColSelection(COL_LIBELLE);
	$mTypeGroupe->Charger();
	$select->AjouterElement(-1, $mTypeGroupe->Libelle(), '', (GSession::Groupe(COL_TYPEGROUPE) === TYPEGROUPE_COMMUNAUTE), false);
	if (GSession::Jeu(COL_ID) != NULL)
	{
		$mTypeGroupe = new MTypeGroupe(TYPEGROUPE_JEU);
		$mTypeGroupe->AjouterColSelection(COL_LIBELLE);
		$mTypeGroupe->Charger();
		$select->AjouterElement(-2, $mTypeGroupe->Libelle(), '', (GSession::Groupe(COL_TYPEGROUPE) === TYPEGROUPE_JEU), false);
	}
	if ($mJeu != NULL && $mGroupe != NULL)
	{
		$select->AjouterCategorie($mJeu->Id(), $mJeu->Libelle());
		$select->AjouterElement($mGroupe->Id(), $mGroupe->Nom(), $mGroupe->Description(), true, false);
	}
	$selectGroupe->SetCadreBoutonsCache(1, 2);

	GContexte::AjouterContenu(CADRE_INFO_GROUPE, $selectGroupe);
}
else if (GSession::Groupe('change') == 1)
{
	GReferentiel::AjouterReferentiel(COL_JEU, $mListeJeux, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
	GReferentiel::GetDifferentielReferentielForSelect(COL_JEU, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '', $jeuId);

	$typeGroupe = GSession::Groupe(COL_TYPEGROUPE);
	if ($typeGroupe == TYPEGROUPE_COMMUNAUTE)
	{
		GReponse::AjouterElementSelect(COL_GROUPE);
		GReponse::AjouterElementSelectSelection(-1);
	}
	else if ($typeGroupe == TYPEGROUPE_JEU)
	{
		GReponse::AjouterElementSelect(COL_GROUPE);
		GReponse::AjouterElementSelectSelection(-2);
	}
	else
	{
		GReferentiel::AjouterReferentiel(COL_GROUPE, $mListeGroupes, array(COL_ID, COL_NOM, COL_DESCRIPTION, COL_JEU), true);
		GReferentiel::GetDifferentielReferentielForSelect(COL_GROUPE, COL_ID, COL_NOM, COL_DESCRIPTION, $groupeId, COL_JEU, array(COL_JEU, COL_LIBELLE, COL_LIBELLE));
	}

	GSession::Groupe('change', NULL, true);
}

?>
