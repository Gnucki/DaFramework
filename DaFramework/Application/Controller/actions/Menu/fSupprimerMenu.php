<?php

require_once 'cst.php';
require_once PATH_METIER.'mMenu.php';
require_once PATH_METIER.'mContexte.php';
require_once PATH_METIER.'mFonctionnalite.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MMenu();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Supprimer();
}

?>
