<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bMessage.php';
require_once PATH_CLASSES.'bSujet.php';
require_once INC_GSESSION;

$sujet = GSession::LireVariableContexte('CreatSujet', 'MESSAGE');
$bSujet = new BSujet();
$groupe = $bSujet->RecupererGroupeSujet($sujet);

if (GSession::HasDroit(FONC_CREER_MESSAGE, $groupe))
{
   	$bMessage = new BMessage();
	$texte = GSession::LireVariableContexte('Texte', 'MESSAGE');
	$joueur = GSession::LireSession('idJoueurConnecte');

	if ($texte != NULL && $texte != '' && $sujet != NULL && intval($sujet) != 0)
		$bMessage->AjouterMessage($texte, intval($sujet), $joueur);
}

?>
