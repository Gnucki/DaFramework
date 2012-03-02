<?php

require_once 'cst.php';
require_once PATH_METIER.'mTypePresentationModule.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MTypePresentationModule();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Modifier();
}

?>
