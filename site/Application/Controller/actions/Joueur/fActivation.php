<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;
require_once PATH_METIER.'mJoueur.php';


$codeActivation = GContexte::LireVariablePost($nomContexte, 'codeActivation');

$mJoueur = new MJoueur(GSession::Joueur(COL_ID));
$mJoueur->AjouterColSelection(COL_CODEACTIVATION);

$compteActive = false;

if ($mJoueur->Charger() !== false)
{
	if ($mJoueur->CodeActivation() !== $codeActivation)
		GLog::LeverException(EXF_0030, GSession::Libelle(LIB_ACT_CODEACTIVATIONFAUX), true, false);
	else
	{
	   	$mJoueur->Actif(true);
	   	$compteActive = $mJoueur->Modifier();
	}
}

if ($compteActive === false)
	GLog::LeverException(EXF_0031, GSession::Libelle(LIB_ACT_ACTIVCOMPTEERREUR), true, false);
else
   	GContexte::SetContexte(CONT_AIDE, true);

$pasDeRechargement = true;

?>
