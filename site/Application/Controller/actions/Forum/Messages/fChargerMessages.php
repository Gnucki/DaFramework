<?php

require_once 'cst.php';
require_once INC_SLISTEMESSAGES;
require_once INC_GSESSION;
require_once PATH_CLASSES.'bMessage.php';

$groupe = GSession::LireSession('idGroupe');
$suj = GSession::LireVariableContexte('Sujet', 'MESSAGE');
$incrementerVues = GSession::LireVariableContexte('IncrementerVues', 'MESSAGE', true);

$bMessage = new BMessage();
$messages = $bMessage->ChargerListeMessagesFromSujet($suj, $incrementerVues);

$liste = new SListeMessages('Liste des messages', $suj, 'message', 'CreerMessage', 'ModifierMessage', 'SupprimerMessage');

while (list($i, $message) = each($messages))
{
	if ($message[COL_SUJET] == $suj)
		$liste->AjouterElement($message[COL_ID],
		   	   	   	   	   	   $message[COL_TEXTE],
							   $message[COL_LOGIN],
							   $message[COL_DATEMESSAGE],
							   $message[COL_VERSION]);
}

?>