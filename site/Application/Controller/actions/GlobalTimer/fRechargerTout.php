<?php

require_once 'cst.php';
require_once INC_GSESSION;

// Recharge les droits de l'utilisateur.
require INC_FRECHARGERDROITS;

// Recharge en fonction du contexte de la session.
GSession::ChargerContextes();

?>
