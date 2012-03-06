<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once PATH_METIER.'mJoueur.php';


$login = GContexte::LireVariablePost($nomContexte, 'login');
$motDePasse = GContexte::LireVariablePost($nomContexte, 'motDePasse');

$mJoueur = new MJoueur(NULL, $login, $motDePasse);

$formulaireValide = true;

// On vérifie qu'un compte existe pour cette adresse email.
$mJoueur->ChargerFromLoginEtMotDePasse();

if ($mJoueur->Id() === NULL || $mJoueur->Supprime() === true)
{
	GLog::LeverException(EXF_0020, GSession::Libelle(LIB_CON_COMPTENONEXISTANT), true, false);
	$formulaireValide = false;
}
else if ($mJoueur->Banni() === true)
{
	GLog::LeverException(EXF_0021, GSession::Libelle(LIB_CON_COMPTEBANNI), true, false);
	$formulaireValide = false;
}

if ($formulaireValide === true)
{
   	GSession::Joueur(COL_ID, $mJoueur->Id());
   	GSession::Joueur(COL_PSEUDO, $mJoueur->Pseudo());
   	GSession::Joueur(COL_SUPERADMIN, $mJoueur->SuperAdmin());
   	// On vérifie si le compte a été activé ou non.
   	if ($mJoueur->Actif() === false)
	   	GContexte::SetContexte(CONT_ACTIVATION);
   	else
   	   	GContexte::SetContexte(CONT_ADMINISTRATION, false);
}
else
   	GContexte::SupprimerContexte(CONT_CONNEXION);

$pasDeRechargement = true;

?>
