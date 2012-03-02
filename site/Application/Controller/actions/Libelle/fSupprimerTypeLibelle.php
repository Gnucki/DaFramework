<?php

require_once 'cst.php';
require_once PATH_METIER.'mTypeLibelle.php';
require_once PATH_METIER.'mLangue.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MTypeLibelle();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Supprimer();
}

?>
