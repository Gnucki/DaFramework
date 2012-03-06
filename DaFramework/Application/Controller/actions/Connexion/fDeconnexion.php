<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SBALISE;


GSession::Joueur(NULL, NULL, true);
GContexte::ResetContextes();

$bal = new SBalise(BAL_DIV);
$bal->SetText('contenu<br/><br/><br/><br/>');
GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $bal);

?>
