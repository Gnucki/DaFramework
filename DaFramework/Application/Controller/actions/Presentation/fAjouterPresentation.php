<?php

require_once 'cst.php';
require_once INC_GSESSION;


$groupe = GSession::Groupe(COL_ID);
if ($groupe !== NULL && GDroit::ADroitPopErreur(FONC_PRS_CREERMODIFIER) === true)
{
   	$nouvPres = GSession::LirePost('nouvPres');
   	// Cas de la création d'une présentation.
   	if ($nouvPres != NULL && $nouvPres !== '')
	{
   		require_once PATH_METIER.'mListePresentations.php';
   		require_once PATH_METIER.'mVersion.php';
   		require_once PATH_METIER.'mJoueur.php';
   		require_once PATH_METIER.'mGroupe.php';

   		$formulaire = true;

   		$mPresentation = new MPresentation();
   		$mPresentation->Nom(GContexte::LirePost(COL_NOM));
   		$mPresentation->CreateurJoueur(GSession::Joueur(COL_ID));
   		$mPresentation->CreateurGroupe($groupe);
   		if ($mPresentation->Nom() === NULL)
		{
		   	 GLog::LeverException(EXF_0040, GSession::Libelle(LIB_PRS_NOMINVALIDE), true, false);
		   	 $formulaire = false;
		}

		$retour = true;
		if ($formulaire === true)
		{
		   	$mPresentation->AjouterJointure(COL_VERSION, COL_ID, 0, NULL, SQL_RIGHT_JOIN);
		   	$mPresentation->AjouterColInsertionMaxExt(1, COL_VERSION, COL_ID);
			$retour = $mPresentation->Ajouter();
		}

		if ($formulaire === false || $retour === false)
			GLog::LeverException(EXF_0041, GSession::Libelle(LIB_PRS_PRESNONCREEE), true, false);
		else
		   	GSession::PresentationModif($mPresentation->Id());
   	}
   	// Cas d'un chargement d'onglet.
   	else
   	{
	   	$ongletContexte = GContexte::LireVariablePost($nomContexte, 'ongletContexte');
	   	$ancienOngletContexte = GContexte::LireVariableSession($nomContexte, 'ongletContexte');

		// Si on a changé d'onglet ou que l'on recharge toute la page.
		if ($ancienOngletContexte !== $ongletContexte)
		{
			GContexte::DesactiverContexte($ancienOngletContexte);
		   	GContexte::EcrireVariableSession($nomContexte, 'ongletContexte', $ongletContexte);
		   	GContexte::AjouterContexte($ongletContexte, true, false);
		}
		// Si on a recliqué sur l'onglet où on était pour le recharger.
		else
		   	GContexte::ChargerContexte($ancienOngletContexte);
	}
}

?>
