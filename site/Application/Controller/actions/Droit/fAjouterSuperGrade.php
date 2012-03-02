<?php

require_once 'cst.php';
require_once PATH_METIER.'mSuperGrade.php';
require_once PATH_METIER.'mFonctionnalite.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
   	$varPost = GSession::LirePost($nomContexte);
   	$listeFonctionnalites = NULL;
   	if (array_key_exists(COL_FONCTIONNALITE, $varPost))
	{
   		$listeFonctionnalites = $varPost[COL_FONCTIONNALITE];
		unset($varPost[COL_FONCTIONNALITE]);
   	}

	$mObjet = new MSuperGrade();
	$mObjet->SetObjetFromTableau($varPost);
	$mObjet->ListeDroitsSuperGrades($listeFonctionnalites);
	$mObjet->Ajouter();
}

?>
