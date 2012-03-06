<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bDroit.php';
require_once INC_GSESSION;

if (GSession::EstConnecte())
{
   	$idJoueurConnecte = GSession::LireSession('idJoueurConnecte');
   	if ($idJoueurConnecte != NULL)
   	{
	   	$bDroit = new BDroit();
	   	$droits = $bDroit->ChargerDroits($idJoueurConnecte);
		GSession::BuildListeDroits($droits);
	}
}

?>
