<?php

require_once 'cst.php';
require_once PATH_METIER.'mLibelleLibre.php';
require_once PATH_METIER.'mLangue.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	$mObjet = new MLibelleLibre();
	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$mObjet->Supprimer();
}

?>
