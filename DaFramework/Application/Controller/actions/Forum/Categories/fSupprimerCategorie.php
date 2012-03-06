<?php

require_once 'cst.php';
require_once PATH_CLASSES.'bCategorie.php';

$categorie = GSession::LireVariableContexte('SupprCategorie', 'CATEGORIE');
$bCategorie = new BCategorie();
$groupe = $bCategorie->RecupererGroupeCategorie($categorie);

if (GSession::HasDroit(FONC_SUPPRIMER_FORUM, $groupe))
{
	if (intval($categorie) > 0)
		$bCategorie->SupprimerCategorie(intval($categorie));
}

?>
