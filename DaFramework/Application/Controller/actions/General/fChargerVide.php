<?php

require_once 'cst.php';


$bal = new SBalise(BAL_DIV);
$bal->SetText('contenu<br/><br/><br/><br/>');
GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $bal);

?>
