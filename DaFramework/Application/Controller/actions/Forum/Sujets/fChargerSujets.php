<?php

require_once 'cst.php';
require_once INC_SLISTESUJETS;
require_once INC_GSESSION;
require_once PATH_CLASSES.'bSujet.php';
require_once PATH_CLASSES.'bConstantes.php';

$groupe = GSession::LireSession('idGroupe');
$cat = GSession::LireVariableContexte('Categorie', 'SUJET');

$bSujet = new BSujet();
$sujets = $bSujet->ChargerListeSujetsFromCategorie($cat);

$liste = new SListeSujets('Liste des sujets', $cat, 'sujet', 'CreerSujet', 'ModifierSujet', 'SupprimerSujet', 'ChargerMessages');

while (list($i, $sujet) = each($sujets))
{
	if ($sujet[COL_CATEGORIE] == $cat)
		$liste->AjouterElement($sujet[COL_ID],
		   	   	   	   	   	   $sujet[COL_NOM],
							   $sujet[COL_COMMENTAIRE],
							   $sujet[COL_LOGIN],
							   $sujet[COL_DATECREATION],
							   $sujet[COL_DERNIERMESSAUTEUR],
							   $sujet[COL_DERNIERMESSDATE],
							   $sujet[COL_VUES],
							   $sujet[COL_NBREPONSES],
							   $sujet[COL_VERSION]);
}

?>