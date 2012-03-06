<?php

require_once 'cst.php';
require_once PATH_METIER.'mTypeJeu.php';
require_once PATH_METIER.'mTypeGroupe.php';
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeGroupes.php';


$jeu = GContexte::LirePost(COL_JEU);
// Si on a changé le jeu.
if ($jeu !== NULL)
{
   	$ancienJeu = GSession::Jeu(COL_ID);

   	// Si le jeu a changé, on reset le groupe de connexion.
	if ($ancienJeu != $jeu)
	{
	   	$mGroupe = new MGroupe();
	   	$groupeChange = false;

	   	// Jeu vide.
	   	if ($jeu === '')
	   	{
	   	   	GSession::Jeu(COL_ID, NULL, true);
	   	   	GSession::Jeu(COL_LIBELLE, NULL, true);

			// On supprime du select le groupe du jeu.
	   	   	GReponse::AjouterElementSelect(COL_GROUPE);
			GReponse::AjouterElementSelectSuppression(-2);
			GReponse::AjouterElementSelectSelection(-1);

			// Le nouveau groupe auquel on est connecté est le groupe de la communauté.
			$mGroupe->AjouterColSelection(COL_ID);
			$mGroupe->AjouterColSelection(COL_NOM);
			$mGroupe->AjouterColSelection(COL_DESCRIPTION);
			$mGroupe->AjouterColCondition(COL_TYPEGROUPE, TYPEGROUPE_COMMUNAUTE);
			$mGroupe->AjouterColCondition(COL_COMMUNAUTE, GSession::Communaute(COL_ID));
			$mGroupe->Charger();
			$mGroupe->TypeGroupe()->Id(TYPEGROUPE_COMMUNAUTE);

			$groupeChange = true;
	   	}
		else
		{
		   	// On stocke en session les informations du jeu.
		   	$mJeu = new MJeu($jeu);
		   	$mJeu->AjouterColSelection(COL_LIBELLE);
		   	$mJeu->Charger();
			GSession::Jeu(COL_ID, $jeu, true);
			GSession::Jeu(COL_LIBELLE, $mJeu->Libelle(), true);

			// On ajoute le groupe du jeu dans la liste du select.
			$mTypeGroupe = new MTypeGroupe(TYPEGROUPE_JEU);
			$mTypeGroupe->AjouterColSelection(COL_LIBELLE);
			$mTypeGroupe->Charger();
			GReponse::AjouterElementSelect(COL_GROUPE);
			GReponse::AjouterElementSelectCreation(-2, $mTypeGroupe->Libelle(), '', true, 0);

			$groupeJeu = GSession::Groupe(COL_JEU);
			if ($groupeJeu !== $jeu)
			{
				// Le nouveau groupe auquel on est connecté est le groupe du jeu.
			   	$mGroupe->AjouterColSelection(COL_ID);
	   			$mGroupe->AjouterColSelection(COL_NOM);
	   			$mGroupe->AjouterColSelection(COL_DESCRIPTION);
			   	$mGroupe->AjouterColCondition(COL_TYPEGROUPE, TYPEGROUPE_JEU);
			   	$mGroupe->AjouterColCondition(COL_COMMUNAUTE, GSession::Communaute(COL_ID));
			   	$mGroupe->AjouterColCondition(COL_JEU, $jeu);
			   	$mGroupe->Charger();
			   	$mGroupe->TypeGroupe()->Id(TYPEGROUPE_JEU);

			   	$groupeChange = true;
			}
		}

		if ($groupeChange === true)
		{
			// On reset la liste des groupes en fonction du jeu.
			$mListeGroupes = new MListeGroupes();
			GReferentiel::AjouterReferentiel(COL_GROUPE, $mListeGroupes, array(COL_ID, COL_NOM, COL_DESCRIPTION, COL_JEU), true);
			GReferentiel::GetDifferentielReferentielForSelect(COL_GROUPE, COL_ID, COL_NOM, COL_DESCRIPTION, NULL, COL_JEU, array(COL_JEU, COL_LIBELLE, COL_LIBELLE));
			GSession::Groupe(COL_ID, $mGroupe->Id(), true);
			GSession::Groupe(COL_NOM, $mGroupe->Nom(), true);
			GSession::Groupe(COL_DESCRIPTION, $mGroupe->Description(), true);
			GSession::Groupe(COL_TYPEGROUPE, $mGroupe->TypeGroupe()->Id(), true);
			GSession::Groupe(COL_JEU, $mGroupe->Jeu()->Id(), true);
		}
	}
}
else
{
   	$groupe = GContexte::LirePost(COL_GROUPE);

	// Si on a changé le groupe.
	if ($groupe !== NULL)
	{
		$ancienGroupe = GSession::Groupe(COL_ID);
		$typeGroupe = GSession::Groupe(COL_TYPEGROUPE);

		if ($groupe != $ancienGroupe && !($groupe == -1 && $typeGroupe === TYPEGROUPE_COMMUNAUTE) && !($groupe == -2 && $typeGroupe === TYPEGROUPE_JEU))
	 	{
		   	// Groupe vide.
		   	if ($groupe === '')
		   	   	$groupe = -1;

		   	$mGroupe = NULL;
		   	$mJeu = NULL;
		   	$mListeGroupes = new MListeGroupes();

		   	if ($groupe <= 0)
			{
			   	$jeu = GSession::Jeu(COL_ID);

			   	// Groupe de la communauté.
		   		if ($groupe == -1 || $jeu == NULL)
				{
		   			$mGroupe = new MGroupe();
		   			$mGroupe->AjouterColSelection(COL_ID);
				   	$mGroupe->AjouterColSelection(COL_NOM);
				   	$mGroupe->AjouterColSelection(COL_DESCRIPTION);
				   	$mGroupe->AjouterColCondition(COL_TYPEGROUPE, TYPEGROUPE_COMMUNAUTE);
				   	$mGroupe->AjouterColCondition(COL_COMMUNAUTE, GSession::Communaute(COL_ID));
				   	$mGroupe->Charger();
				   	$mGroupe->TypeGroupe()->Id(TYPEGROUPE_COMMUNAUTE);

				   	GSession::Jeu(COL_ID, NULL, true);
			   	   	GSession::Jeu(COL_LIBELLE, NULL, true);

			   	   	GReponse::AjouterElementSelect(COL_GROUPE);
					GReponse::AjouterElementSelectSuppression(-2);
					GReponse::AjouterElementSelectSelection(-1);

					$mListe = new MListeJeux();
					GReferentiel::AjouterReferentiel(COL_JEU, $mListe, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
					GReferentiel::GetDifferentielReferentielForSelect(COL_JEU, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '');
		   		}
		   		// Groupe du jeu.
		   		else if ($groupe == -2)
				{
				   	$mGroupe = new MGroupe();
				   	$mGroupe->AjouterColSelection(COL_ID);
		   			$mGroupe->AjouterColSelection(COL_NOM);
		   			$mGroupe->AjouterColSelection(COL_DESCRIPTION);
				   	$mGroupe->AjouterColCondition(COL_TYPEGROUPE, TYPEGROUPE_JEU);
				   	$mGroupe->AjouterColCondition(COL_COMMUNAUTE, GSession::Communaute(COL_ID));
				   	$mGroupe->AjouterColCondition(COL_JEU, $jeu);
				   	$mGroupe->Charger();
				   	$mGroupe->TypeGroupe()->Id(TYPEGROUPE_JEU);
		   		}
		   	}
		   	else
		   	{
			   	$mGroupe = new MGroupe($groupe);
			   	$mGroupe->AjouterColSelection(COL_NOM);
			   	$mGroupe->AjouterColSelection(COL_DESCRIPTION);
			   	$mGroupe->AjouterColSelection(COL_JEU);
			   	$mJeu = $mGroupe->AjouterJointure(COL_JEU, COL_ID);
			   	$mJeu->AjouterColSelection(COL_LIBELLE);
			   	$mGroupe->Charger();
			   	$mListeGroupes->AjouterElement($mGroupe);
			}
			// On stocke en session les informations du groupe.
			GSession::Groupe(COL_ID, $mGroupe->Id(), true);
			GSession::Groupe(COL_NOM, $mGroupe->Nom(), true);
			GSession::Groupe(COL_DESCRIPTION, $mGroupe->Description(), true);
			GSession::Groupe(COL_TYPEGROUPE, $mGroupe->TypeGroupe()->Id(), true);
			GSession::Groupe(COL_JEU, $mGroupe->Jeu()->Id(), true);

			// On reset la liste des groupes en fonction du jeu.
			GReferentiel::AjouterReferentiel(COL_GROUPE, $mListeGroupes, array(COL_ID, COL_NOM, COL_DESCRIPTION, COL_JEU), true);
			GReferentiel::GetDifferentielReferentielForSelect(COL_GROUPE, COL_ID, COL_NOM, COL_DESCRIPTION, NULL, COL_JEU, array(COL_JEU, COL_LIBELLE, COL_LIBELLE));

			if ($mJeu !== NULL)
			{
				$ancienJeu = GSession::Jeu(COL_ID);
				// Si le jeu à changé.
				if ($ancienJeu != $mJeu->Id())
				{
				   	$mListe = new MListeJeux();
					$mListe->AjouterElement($mJeu);
					GReferentiel::AjouterReferentiel(COL_JEU, $mListe, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
					GReferentiel::GetDifferentielReferentielForSelect(COL_JEU, COL_ID, array(COL_LIBELLE, COL_LIBELLE), '', $mJeu->Id());
					GSession::Jeu(COL_ID, $mJeu->Id(), true);
					GSession::Jeu(COL_LIBELLE, $mJeu->Libelle(), true);
				}
			}
		}
	}
}

GContexte::SetContexte(CONT_ACCUEIL, true);

?>
