<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bSujet.php';

$sujet = GSession::LireVariableContexte('ModifSujet', 'SUJET');
$bSujet = new BSujet();
$groupe = $bSujet->RecupererGroupeSujet($sujet);

if (GSession::HasDroit(FONC_MODIFIER_SUJET, $groupe))
{
	$titre = GSession::LireVariableContexte('Titre', 'SUJET');
	$description = GSession::LireVariableContexte('Description', 'SUJET');

	if ($titre != NULL && $titre != '' && $description != NULL && intval($sujet) != 0)
		$bSujet->ModifierSujet($titre, $description, intval($sujet));
}

?>
