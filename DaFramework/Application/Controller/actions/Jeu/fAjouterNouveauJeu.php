<?php

require_once 'cst.php';
require_once PATH_METIER.'mJeu.php';
require_once PATH_METIER.'mTypeJeu.php';


if (GDroit::EstConnecte(true) === true)
{
   	$varPost = GSession::LirePost($nomContexte);
   	$listeServeurs = NULL;
   	if (array_key_exists(COL_SERVEUR, $varPost))
	{
   		$listeServeurs = $varPost[COL_SERVEUR];
		unset($varPost[COL_SERVEUR]);
   	}
   	$listeTypesGroupes = NULL;
   	if (array_key_exists(COL_TYPEGROUPE, $varPost))
	{
   		$listeTypesGroupes = $varPost[COL_TYPEGROUPE];
		unset($varPost[COL_TYPEGROUPE]);
   	}

	$mObjet = new MJeu();
	$mObjet->SetObjetFromTableau($varPost);
	$mObjet->ListeServeurs($listeServeurs);
	$mObjet->ListeTypesGroupes($listeTypesGroupes);
	$mObjet->Ajouter();
}

?>
