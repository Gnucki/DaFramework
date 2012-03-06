<?php

require_once 'cst.php';
require_once PATH_METIER.'mMenu.php';
require_once PATH_METIER.'mContexte.php';
require_once PATH_METIER.'mFonctionnalite.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
   	$varPost = GSession::LirePost($nomContexte);
   	$listeContextes = NULL;
   	if (array_key_exists(COL_CONTEXTE, $varPost))
	{
   		$listeContextes = $varPost[COL_CONTEXTE];
		unset($varPost[COL_CONTEXTE]);
   	}
   	$listeFonctionnalites = NULL;
   	if (array_key_exists(COL_FONCTIONNALITE, $varPost))
	{
   		$listeFonctionnalites = $varPost[COL_FONCTIONNALITE];
		unset($varPost[COL_FONCTIONNALITE]);
   	}

	$mObjet = new MMenu();
	$mObjet->SetObjetFromTableau($varPost);
	$mObjet->ListeMenusContextes($listeContextes);
	$mObjet->ListeMenusFonctionnalites($listeFonctionnalites);
	$mObjet->Ajouter();
}

?>
