<?php

require_once 'cst.php';
require_once PATH_METIER.'mGradeGlobal.php';
require_once PATH_METIER.'mSuperGrade.php';
require_once PATH_METIER.'mListeJoueurs.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$varPost = GSession::LirePost($nomContexte);
   	$listeJoueurs = NULL;
   	if (array_key_exists(COL_JOUEUR, $varPost))
	{
   		$listeJoueurs = $varPost[COL_JOUEUR];
		unset($varPost[COL_JOUEUR]);
   	}

	$mObjet = new MGradeGlobal();
	$mObjet->SetObjetFromTableau($varPost);
	$mObjet->ListeGradesJoueurs($listeJoueurs);
	$mObjet->Modifier();
}

?>
