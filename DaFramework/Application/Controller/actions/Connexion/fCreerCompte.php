<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once PATH_METIER.'mJoueur.php';
require_once INC_GLOCALISATION;


$utc = intval(GSession::LirePost('utc'));
$fuseauHoraire = GLocalisation::FuseauHoraire($utc);
$langueId = GSession::Langue(COL_ID);
$communauteId = GSession::Communaute(COL_ID);
$login = GContexte::LireVariablePost($nomContexte, 'login');
$motDePasse = GContexte::LireVariablePost($nomContexte, 'motDePasse');
$pseudo = GContexte::LireVariablePost($nomContexte, 'pseudo');
//$nom = GContexte::LireVariablePost($nomContexte, 'prenom');
//$prenom = GContexte::LireVariablePost($nomContexte, 'nom');
$annee = GContexte::LireVariablePost($nomContexte, 'annee');
$mois = GContexte::LireVariablePost($nomContexte, 'mois');
$jour = GContexte::LireVariablePost($nomContexte, 'jour');
if (strlen($mois) == 1)
	$mois = '0'.$mois;
if (strlen($jour) == 1)
	$jour = '0'.$jour;
if (strlen($annee) == 2)
{
  	if (intval($annee) <= 20)
  		$annee = '20'.$annee;
  	else
  	   	$annee = '19'.$annee;
}
$dateNaissance = NULL;
if (strlen($annee) === 4 && strlen($mois) === 2 && strlen($jour) === 2)
   	$dateNaissance = $annee.'-'.$mois.'-'.$jour;
$codeActivation = strval(mt_rand()).'-'.strval(mt_rand());

$mJoueur = new MJoueur(NULL, $login, $motDePasse, $pseudo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $codeActivation, NULL, NULL, $dateNaissance, $fuseauHoraire, NULL, NULL, NULL, NULL, $langueId, $communauteId);

$formulaireValide = true;

// On vérifie qu'aucun compte n'existe déjà pour cette adresse email.
$mJoueurExistant = new MJoueur(NULL, $login);
$mJoueurExistant->ChargerFromLogin();
if ($mJoueurExistant->Id() != NULL)
{
   	// Si le joueur avait été supprimé, on le dé-supprime.
   	if ($mJoueurExistant->Supprime() === false)
   	{
	   	GLog::LeverException(EXF_0000, GSession::Libelle(LIB_CON_COMPTEDEJAEXISTANT), true, false);
		$formulaireValide = false;
	}
	else
	{
	   	$mJoueurExistant->MotDePasse($motDePasse);
	   	$mJoueurExistant->Pseudo($pseudo);
	   	$mJoueurExistant->CodeActivation($codeActivation);
	   	$mJoueurExistant->Actif(false);
	   	$mJoueurExistant->DateNaissance($dateNaissance);
	   	$mJoueurExistant->FuseauHoraire($fuseauHoraire);
	   	$mJoueurExistant->Supprime(false);
	   	$mJoueurExistant->DateSuppression(SQL_NULL);
	}
}
if ($mJoueur->Login() === NULL)
{
	GLog::LeverException(EXF_0001, GSession::Libelle(LIB_CON_EMAILERREUR), true);
	$formulaireValide = false;
}
if ($mJoueur->MotDePasse() == NULL)
{
   	GLog::LeverException(EXF_0002, GSession::Libelle(LIB_CON_MOTDEPASSEERREUR), true);
   	$formulaireValide = false;
}
if ($mJoueur->Pseudo() == NULL)
{
   	GLog::LeverException(EXF_0003, GSession::Libelle(LIB_CON_PSEUDOERREUR), true);
   	$formulaireValide = false;
}

if ($formulaireValide === true)
{
   	// Si un joueur existait et était supprimé on le met à jour, sinon on crée un nouveau joueur.
   	if ($mJoueurExistant->Id() != NULL)
   	{
   	   $mJoueurExistant->Modifier();
   	   unset($mJoueur);
   	   $mJoueur = $mJoueurExistant;
   	}
   	else
	   $mJoueur->Ajouter();
}

// Si le joueur a bien été créé, on lui envoie un mail avec son pseudo, son mot de passe et son code d'activation.
if ($mJoueur->Id() !== NULL)
{
   	$headers ='From: "Admin"<mou@mou.fr>'."\n";
    $headers .='Content-Type: text/plain; charset="utf8"'."\n";
    $headers .='Content-Transfer-Encoding: 8bit';
    ini_set('SMTP', SMTP);

	$message = GSession::Libelle(LIBTEXT_CON_MAILMESSAGE, false, true)."\r\n\r\n".
	   	   		GSession::Libelle(LIB_CON_PSEUDO, false, true).' '.$mJoueur->Pseudo()."\r\n".
			 	GSession::Libelle(LIB_CON_MOTDEPASSE, false, true).' '.$mJoueur->MotDePasse()."\r\n".
			 	GSession::Libelle(LIB_CON_CODEACTIVATION, false, true).' '.$mJoueur->CodeActivation();

	mail($mJoueur->Login(), GSession::Libelle(LIB_CON_MAILTITRE, false, true), $message, $headers);

	GSession::Joueur(COL_ID, $mJoueur->Id());
   	GSession::Joueur(COL_PSEUDO, $mJoueur->Pseudo());
	GContexte::SetContexte(CONT_ACTIVATION);
}
else
   	GLog::LeverException(EXF_0004, GSession::Libelle(LIB_CON_CREATCOMPTEERREUR), true, $formulaireValide);

$pasDeRechargement = true;

?>
