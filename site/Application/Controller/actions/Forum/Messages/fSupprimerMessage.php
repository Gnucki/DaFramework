<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bMessage.php';

$message = GSession::LireVariableContexte('SupprMessage', 'MESSAGE');
$bMessage = new BMessage();
$groupe = $bMessage->RecupererGroupeMessage($message);

if (GSession::HasDroit(FONC_SUPPRIMER_MESSAGE, $groupe))
{
	if (intval($message) > 0)
		$bMessage->SupprimerMessage(intval($message));
}

?>
