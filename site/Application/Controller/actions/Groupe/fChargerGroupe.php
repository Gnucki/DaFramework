<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once PATH_CLASSES.'bGroupe.php';

GSession::StartSession();

$groupe = GSession::LirePost('groupe');
if ($groupe != NULL)
{
   	GSession::EcrireSession('idGroupe', $groupe);
   	$bGroupe = new BGroupe();
   	$bGroupe->ChargerGroupe($groupe);
   	GSession::EcrireSession('nomGroupe', $bGroupe->GetNom());
   	GSession::EcrireSession('jeuGroupe', $bGroupe->GetJeu());
   	GSession::EcrireSession('serveurGroupe', $bGroupe->GetServeur());
}

?>
