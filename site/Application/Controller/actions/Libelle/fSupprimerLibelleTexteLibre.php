<?php

require_once 'cst.php';
require_once PATH_METIER.'mLibelleTexteLibre.php';
require_once PATH_METIER.'mLangue.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MLibelleTexteLibre();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Supprimer();
}

?>
