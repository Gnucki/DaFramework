<?php

require_once 'cst.php';
require_once INC_GSESSION;


GReponse::Debut();


$contexte = GSession::LirePost('contexte');

if ($contexte != NULL)
   	GContexte::ModifierDansContexte($contexte);


GReponse::Fin();

?>