<?php

require_once 'cst.php';
require_once PATH_METIER.'mTypeJeu.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MTypeJeu();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Ajouter();
}

?>
