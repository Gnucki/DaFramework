<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bSujet.php';

$sujet = GSession::LireVariableContexte('SupprSujet', 'SUJET');
$bSujet = new BSujet();
$groupe = $bSujet->RecupererGroupeSujet($sujet);

if (GSession::HasDroit(FONC_SUPPRIMER_SUJET, $groupe))
{
	if (intval($sujet) > 0)
		$bSujet->SupprimerSujet(intval($sujet));
}

?>
