<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bCategorie.php';
require_once 'GuildPortail/Outils/include.php';
require_once INC_GSESSION;

$categorie = GSession::LireVariableContexte('CreatCategorie', 'CATEGORIE');
$typeCategorie = GSession::LireVariableContexte('TypeCategorie', 'CATEGORIE');
$bCategorie = new BCategorie();
$groupe = NULL;

if ($categorie == -1 || $categorie == NULL)
	$groupe = GSession::LireSession('idGroupe');
else
   	$groupe = $bCategorie->RecupererGroupeCategorie($categorie);

if (GSession::HasDroit(FONC_CREER_FORUM, $groupe))
{
	$titre = GSession::LireVariableContexte('Titre', 'CATEGORIE');
	$description = GSession::LireVariableContexte('Description', 'CATEGORIE');

	if ($typeCategorie === NULL || $typeCategorie === '' || intval($typeCategorie) === 0)
		$typeCategorie = 1;

	if ($groupe != NULL && $titre != NULL && $titre != '' && $description != NULL && $categorie != NULL && intval($categorie) != 0)
		$bCategorie->AjouterCategorie($titre, $description, intval($categorie), $groupe, intval($typeCategorie));
}

?>
