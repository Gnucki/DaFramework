<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MPresentation extends MObjetMetier
{
	public function __construct($id = NULL, $nom = NULL, $createurJoueurId = NULL, $createurGroupeId = NULL, $globale = NULL, $publique = NULL, $version = NULL)
	{
		$this->SetObjet($id, $nom, $createurJoueurId, $createurGroupeId, $globale, $publique, $version);
	}

	public function SetObjet($id = NULL, $nom = NULL, $createurJoueurId = NULL, $createurGroupeId = NULL, $globale = NULL, $publique = NULL, $version = NULL)
	{
		parent::SetObjet($id);

		$this->Nom($nom);
		$this->CreateurJoueur($createurJoueurId);
		$this->CreateurGroupe($createurGroupeId);
		$this->Globale($globale);
		$this->Publique($publique);
		$this->Version($version);
	}

	public function GetNom()
	{
	   	return 'MPresentation';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_PRESENTATION);
	}

	/*************************************/
	public function Nom($nom = NULL)
	{
		return $this->ValeurStrVerifiee(COL_NOM, $nom, 1, 200, "/^([a-zA-Z]+)$/", NULL, true);
	}

	public function CreateurJoueur($id = -1, $login = NULL, $motDePasse = NULL, $pseudo = NULL, $description = NULL, $histoire = NULL, $dateCreation = NULL, $dateDerniereConnexion = NULL, $dateSuppression = NULL, $supprime = NULL, $actif = NULL, $codeActivation = NULL, $prenom = NULL, $nom = NULL, $dateNaissance = NULL, $fuseauHoraire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $aide = NULL, $langueId = NULL, $communauteId = NULL, $monnaieId = NULL, $banni = NULL, $bannisseurId = NULL, $dateBannissement = NULL, $dateFinBannissement = NULL, $raisonBannissement = NULL, $superAdmin = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_CREATEURJOUEUR, 'MJoueur', NULL, true, $id, $login, $motDePasse, $pseudo, $description, $histoire, $dateCreation, $dateDerniereConnexion, $dateSuppression, $supprime, $actif, $codeActivation, $prenom, $nom, $dateNaissance, $fuseauHoraire, $participation, $pub, $dateFinNoPub, $aide, $langueId, $communauteId, $monnaieId, $banni, $bannisseurId, $dateBannissement, $dateFinBannissement, $raisonBannissement, $superAdmin);
	}

	public function CreateurGroupe($id = -1, $nom = NULL, $jeuId = NULL, $serveurId = NULL, $description = NULL, $histoire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $typeGroupeId = NULL, $etatRecrutementId = NULL, $messageRecrutement = NULL, $communauteId = NULL, $icone = NULL, $supprime = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_CREATEURGROUPE, 'MGroupe', NULL, true, $id, $nom, $jeuId, $serveurId, $description, $histoire, $participation, $pub, $dateFinNoPub, $typeGroupeId, $etatRecrutementId, $messageRecrutement, $communauteId, $icone, $supprime);
	}

	public function Globale($globale = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_GLOBALE, $globale, false, true);
	}

	public function Publique($publique = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_PUBLIQUE, $publique, false, true);
	}

	public function Version($id = -1, $version = NULL, $commentaire = NULL, $dateProd = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_VERSION, 'MVersion', NULL, true, $id, $version, $commentaire, $dateProd);
	}
}

?>