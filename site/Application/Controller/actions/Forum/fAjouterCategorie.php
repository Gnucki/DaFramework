<?php

require_once 'cst.php';
require_once PATH_METIER.'mCategorie.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MCategorie();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Ajouter();
}

?>
