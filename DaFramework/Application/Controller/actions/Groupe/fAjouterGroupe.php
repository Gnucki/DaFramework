<?php

require_once 'cst.php';
require_once PATH_METIER.'mGroupe.php';
require_once PATH_METIER.'mJeu.php';
require_once PATH_METIER.'mCommunaute.php';
require_once PATH_METIER.'mTypeGroupe.php';
require_once PATH_METIER.'mServeur.php';
require_once PATH_METIER.'mEtatRecrutement.php';


if (GDroit::EstConnecte(true) === true)
{
	$mObjet = new MGroupe();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Ajouter();
}

?>
