<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeGroupes.php';
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mCommunaute.php';
require_once PATH_METIER.'mTypeGroupe.php';
require_once PATH_METIER.'mServeur.php';
require_once PATH_METIER.'mEtatRecrutement.php';


if (GDroit::EstConnecte(true) === true)
{
	$mGroupe = new MGroupe();
	$mGroupe->SetObjetFromTableau(GSession::LirePost($nomContexte));
	$retour = $mGroupe->Ajouter();

	if ($retour !== false)
	{
	   	// Mise à jour du jeu et du groupe de connexion avec celui qui vient d'être créé.
		GSession::Groupe(COL_ID, $mGroupe->Id(), true);
		GSession::Groupe(COL_NOM, $mGroupe->Nom(), true);
		GSession::Groupe(COL_DESCRIPTION, $mGroupe->Description(), true);
		GSession::Groupe(COL_TYPEGROUPE, $mGroupe->TypeGroupe()->Id(), true);

		$mJeu = $mGroupe->Jeu();
		$mJeu->AjouterColSelection(COL_LIBELLE);
		$mJeu->Charger();

		GSession::Jeu(COL_ID, $mJeu->Id(), true);
		GSession::Jeu(COL_LIBELLE, $mJeu->Libelle(), true);

		GSession::Groupe('change', 1);
	}
}

?>
