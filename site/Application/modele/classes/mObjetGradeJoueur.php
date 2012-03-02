<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MObjetGradeJoueur extends MObjetMetier
{
	public function __construct($joueurId = NULL)
	{
		$this->SetObjet($joueurId);
	}

	public function SetObjet($joueurId = NULL)
	{
		parent::SetObjet();
		$this->ClePrimaire(array(COL_JOUEUR, COL_GRADE));

		$this->Joueur($joueurId);
	}

	public function GetNom()
	{
	   	return 'MObjetGradeJoueur';
	}

	/*************************************/
	public function Joueur($id = -1, $login = NULL, $motDePasse = NULL, $pseudo = NULL, $description = NULL, $histoire = NULL, $dateCreation = NULL, $dateDerniereConnexion = NULL, $dateSuppression = NULL, $supprime = NULL, $actif = NULL, $codeActivation = NULL, $prenom = NULL, $nom = NULL, $dateNaissance = NULL, $fuseauHoraire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $aide = NULL, $langueId = NULL, $communauteId = NULL, $monnaieId = NULL, $banni = NULL, $bannisseurId = NULL, $dateBannissement = NULL, $dateFinBannissement = NULL, $raisonBannissement = NULL, $superAdmin = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_JOUEUR, 'MJoueur', NULL, true, $id, $login, $motDePasse, $pseudo, $description, $histoire, $dateCreation, $dateDerniereConnexion, $dateSuppression, $supprime, $actif, $codeActivation, $prenom, $nom, $dateNaissance, $fuseauHoraire, $participation, $pub, $dateFinNoPub, $aide, $langueId, $communauteId, $monnaieId, $banni, $bannisseurId, $dateBannissement, $dateFinBannissement, $raisonBannissement, $superAdmin);
	}
}

?>