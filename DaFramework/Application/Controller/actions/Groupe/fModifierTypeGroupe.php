<?php

require_once 'cst.php';
require_once PATH_METIER.'mTypeGroupe.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MTypeGroupe();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Modifier();
}

?>
