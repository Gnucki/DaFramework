<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bCategorie.php';

$categorie = GSession::LireVariableContexte('ModifCategorie', 'CATEGORIE');
$typeCategorie = GSession::LireVariableContexte('TypeCategorie', 'CATEGORIE');
$bCategorie = new BCategorie();
$groupe = $bCategorie->RecupererGroupeCategorie($categorie);

if (GSession::HasDroit(FONC_MODIFIER_FORUM, $groupe))
{
	$titre = GSession::LireVariableContexte('Titre', 'CATEGORIE');
	$description = GSession::LireVariableContexte('Description', 'CATEGORIE');

	if ($typeCategorie === NULL || $typeCategorie === '' || intval($typeCategorie) === 0)
		$typeCategorie = 1;

	if ($titre != NULL && $titre != '' && $description != NULL && $categorie != NULL && intval($categorie) != 0)
		$bCategorie->ModifierCategorie($titre, $description, intval($categorie), intval($typeCategorie));
}

?>
