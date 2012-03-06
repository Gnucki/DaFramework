<?php

require_once 'cst.php';
require_once PATH_METIER.'mCommunaute.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MCommunaute();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Ajouter();
}

?>
