<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SCADRE;
require_once INC_SCLASSEUR;


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
   	$ongletContexte = GContexte::LireVariablePost($nomContexte, 'ongletContexte');
   	$ancienOngletContexte = GContexte::LireVariableSession($nomContexte, 'ongletContexte');

	// Si on a changé d'onglet ou que l'on recharge toute la page.
	if ($ancienOngletContexte !== $ongletContexte)
	{
		GContexte::DesactiverContexte($ancienOngletContexte);
	   	GContexte::EcrireVariableSession($nomContexte, 'ongletContexte', $ongletContexte);
	   	GContexte::AjouterContexte($ongletContexte, true, false);
	}
	// Si on a recliqué sur l'onglet où on était pour le recharger.
	else
	   	GContexte::ChargerContexte($ancienOngletContexte);
}

?>
