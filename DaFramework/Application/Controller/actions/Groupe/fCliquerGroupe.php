<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeGroupes.php';
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mCommunaute.php';
require_once PATH_METIER.'mTypeGroupe.php';
require_once PATH_METIER.'mTypeJeu.php';
require_once PATH_METIER.'mServeur.php';
require_once PATH_METIER.'mEtatRecrutement.php';


if (GDroit::EstConnecte(true) === true)
{
	$groupe = GContexte::LirePost(COL_ID);
	// Groupe vide.
	if ($groupe == NULL)
	{
	   	GSession::Groupe(COL_ID, NULL, true);
	   	GSession::Groupe(COL_NOM, NULL, true);
	}
	else
	{
		// On stocke en session les informations du groupe.
		$mGroupe = new MGroupe($groupe);
		$mGroupe->AjouterColSelection(COL_NOM);
		$mGroupe->AjouterColSelection(COL_DESCRIPTION);
		$mGroupe->AjouterColSelection(COL_JEU);
		$mGroupe->AjouterColSelection(COL_TYPEGROUPE);
		$mJeu = $mGroupe->AjouterJointure(COL_JEU, COL_ID);
		$mJeu->AjouterColSelection(COL_LIBELLE);
		$mGroupe->Charger();
		GSession::Groupe(COL_ID, $groupe, true);
		GSession::Groupe(COL_NOM, $mGroupe->Nom(), true);
		GSession::Groupe(COL_DESCRIPTION, $mGroupe->Description(), true);
		GSession::Groupe(COL_TYPEGROUPE, $mGroupe->TypeGroupe()->Id(), true);
		GSession::Groupe(COL_JEU, $mGroupe->Jeu()->Id(), true);
		GSession::Jeu(COL_ID, $mGroupe->Jeu()->Id(), true);
		GSession::Jeu(COL_LIBELLE, $mGroupe->Jeu()->Libelle(), true);

		GSession::Groupe('change', 1);
	}
}

?>
