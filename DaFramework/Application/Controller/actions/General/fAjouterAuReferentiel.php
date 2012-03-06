<?php

require_once 'cst.php';
require_once INC_GSESSION;


GReponse::Debut();


$contexte = GSession::LirePost('contexte');
$referentiel = GSession::LirePost('ref');

if ($contexte != NULL && $referentiel != NULL)
   	GContexte::AjouterAuReferentiel($contexte, $referentiel);


GReponse::Fin();

?>