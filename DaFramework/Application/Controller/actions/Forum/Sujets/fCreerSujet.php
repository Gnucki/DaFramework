<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bCategorie.php';
require_once PATH_CLASSES.'bSujet.php';
require_once PATH_CLASSES.'bMessage.php';
require_once INC_GSESSION;

$categorie = GSession::LireVariableContexte('CreatCategorie', 'SUJET');
$bCategorie = new BCategorie();

$groupe = $bCategorie->RecupererGroupeCategorie($categorie);

if (GSession::HasDroit(FONC_CREER_SUJET, $groupe))
{
   	$bSujet = new BSujet();
	$titre = GSession::LireVariableContexte('Titre', 'SUJET');
	$description = GSession::LireVariableContexte('Description', 'SUJET');
	$texte = GSession::LireVariableContexte('Texte', 'SUJET');
	$joueur = GSession::LireSession('idJoueurConnecte');

	if ($titre != NULL && $titre != '' && $texte != NULL && $texte != '' && $description != NULL && $categorie != NULL && intval($categorie) != 0)
	{
		$sujet = $bSujet->AjouterSujet($titre, $description, intval($categorie), $joueur);
		if ($sujet != NULL)
		{
			$bMessage = new BMessage();
			$bMessage->AjouterMessage($texte, intval($sujet), $joueur);
		}
	}
}

?>
