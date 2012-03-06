<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bMessage.php';

$message = GSession::LireVariableContexte('ModifMessage', 'MESSAGE');
$bMessage = new BMessage();
$groupe = $bMessage->RecupererGroupeMessage($message);

if (GSession::HasDroit(FONC_MODIFIER_MESSAGE, $groupe))
{
	$texte = GSession::LireVariableContexte('Texte', 'MESSAGE');

	if ($texte != NULL && $texte != '' && intval($message) != 0)
		$bMessage->ModifierMessage($texte, intval($message));
}

?>
