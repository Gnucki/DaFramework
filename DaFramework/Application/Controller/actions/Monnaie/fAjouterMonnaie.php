<?php

require_once 'cst.php';
require_once PATH_METIER.'mMonnaie.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MMonnaie();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Ajouter();
}

?>
