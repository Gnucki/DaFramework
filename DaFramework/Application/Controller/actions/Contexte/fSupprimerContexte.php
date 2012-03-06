<?php

require_once 'cst.php';
require_once PATH_METIER.'mContexte.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MContexte();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Supprimer();
}

?>
