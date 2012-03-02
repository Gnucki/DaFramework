<?php

require_once 'cst.php';
require_once PATH_METIER.'mEtatRecrutement.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MEtatRecrutement();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Modifier();
}

?>
