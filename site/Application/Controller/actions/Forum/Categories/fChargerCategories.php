<?php

require_once 'cst.php';
require_once INC_SLISTEFORUMS;
require_once INC_GSESSION;
require_once PATH_CLASSES.'bCategorie.php';
require_once PATH_CLASSES.'bTypeCategorie.php';

if (GSession::HasDroit(FONC_VOIR_FORUM))
{
	$groupe = GSession::LireSession('idGroupe');
	$cat = GSession::LireVariableContexte('Categorie', 'CATEGORIE');
	if (intval($cat) <= 0)
		$cat = NULL;

	$bCategorie = new BCategorie();
	$categories = $bCategorie->ChargerListeCategorieFromCategorie($groupe, $cat);

	$bTypeCategorie = new BTypeCategorie();
	$typesCategorie = $bTypeCategorie->RecupererTypesCategorie();

	$liste = new SListeForums('Liste des forums', $cat, 'categorie', 'CreerCategorie', 'ModifierCategorie', 'SupprimerCategorie', 'ChargerCategoriesEtSujets', $typesCategorie);

	while (list($i, $categorie) = each($categories))
	{
		if ($categorie[COL_CATEGORIE] == $cat)
			$liste->AjouterElement($categorie[COL_ID], $categorie[COL_NOM], $categorie[COL_COMMENTAIRE], LISTE_CHAMPLISTE_VALEURPARDEFAUT, $categorie[COL_MESSAGES], $categorie[COL_SUJETS], $categorie[COL_VERSION]);
	}
}

?>