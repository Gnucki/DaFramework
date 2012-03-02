<?php

require_once 'cst.php';
require_once PATH_METIER.'mLangue.php';
require_once PATH_METIER.'mCommunaute.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MLangue();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Modifier();
}

?>
