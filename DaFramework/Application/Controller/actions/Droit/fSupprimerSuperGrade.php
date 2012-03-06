<?php

require_once 'cst.php';
require_once PATH_METIER.'mSuperGrade.php';
require_once PATH_METIER.'mFonctionnalite.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MSuperGrade();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Supprimer();
}

?>
