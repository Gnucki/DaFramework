<?php

require_once 'cst.php';
require_once PATH_METIER.'mLangue.php';
require_once PATH_METIER.'mCommunaute.php';
require_once PATH_METIER.'mMonnaie.php';


class MJoueur extends MObjetMetier
{
	public function __construct($id = NULL, $login = NULL, $motDePasse = NULL, $pseudo = NULL, $description = NULL, $histoire = NULL, $dateCreation = NULL, $dateDerniereConnexion = NULL, $dateSuppression = NULL, $supprime = NULL, $actif = NULL, $codeActivation = NULL, $prenom = NULL, $nom = NULL, $dateNaissance = NULL, $fuseauHoraire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $aide = NULL, $langueId = NULL, $communauteId = NULL, $monnaieId = NULL, $banni = NULL, $bannisseurId = NULL, $dateBannissement = NULL, $dateFinBannissement = NULL, $raisonBannissement = NULL, $superAdmin = NULL)
	{
		$this->SetObjet($id, $login, $motDePasse, $pseudo, $description, $histoire, $dateCreation, $dateDerniereConnexion, $dateSuppression, $supprime, $actif, $codeActivation, $prenom, $nom, $dateNaissance, $fuseauHoraire, $participation, $pub, $dateFinNoPub, $aide, $langueId, $communauteId, $monnaieId, $banni, $bannisseurId, $dateBannissement, $dateFinBannissement, $raisonBannissement, $superAdmin);
	}

	public function SetObjet($id = NULL, $login = NULL, $motDePasse = NULL, $pseudo = NULL, $description = NULL, $histoire = NULL, $dateCreation = NULL, $dateDerniereConnexion = NULL, $dateSuppression = NULL, $supprime = NULL, $actif = NULL, $codeActivation = NULL, $prenom = NULL, $nom = NULL, $dateNaissance = NULL, $fuseauHoraire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $aide = NULL, $langueId = NULL, $communauteId = NULL, $monnaieId = NULL, $banni = NULL, $bannisseurId = NULL, $dateBannissement = NULL, $dateFinBannissement = NULL, $raisonBannissement = NULL, $superAdmin = NULL)
	{
		parent::SetObjet($id);

		$this->Login($login);
		$this->MotDePasse($motDePasse);
		$this->Pseudo($pseudo);
		$this->Description($description);
		$this->Histoire($histoire);
		$this->DateCreation($dateCreation);
		$this->DateDerniereConnexion($dateDerniereConnexion);
		$this->DateSuppression($dateSuppression);
		$this->Supprime($supprime);
		$this->Actif($actif);
		$this->CodeActivation($codeActivation);
		$this->Prenom($prenom);
		$this->Nom($nom);
		$this->DateNaissance($dateNaissance);
		$this->FuseauHoraire($fuseauHoraire);
		$this->Participation($participation);
		$this->Pub($pub);
		$this->DateFinNoPub($dateFinNoPub);
		$this->Aide($aide);
		$this->Langue($langueId);
		$this->Communaute($communauteId);
		$this->Monnaie($monnaieId);
		$this->Banni($banni);
		$this->Bannisseur($bannisseurId);
		$this->DateBannissement($dateBannissement);
		$this->DateFinBannissement($dateFinBannissement);
		$this->RaisonBannissement($raisonBannissement);
		$this->SuperAdmin($superAdmin);
	}

	public function GetNom()
	{
	   	return 'MJoueur';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_JOUEUR);
	}

	/*************************************/
	public function Login($login = NULL)
	{
		return $this->ValeurStrVerifiee(COL_LOGIN, $login, 1, 70, "/^([a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,3})$/", NULL, true);
	}

	public function MotDePasse($motDePasse = NULL)
	{
		return $this->ValeurStrVerifiee(COL_MOTDEPASSE, $motDePasse, 5, 20, NULL, NULL, true);
	}

	public function Pseudo($pseudo = NULL)
	{
		return $this->ValeurStrVerifiee(COL_PSEUDO, $pseudo, 1, 30, NULL, NULL, true);
	}

	public function Description($description = NULL)
	{
		return $this->ValeurStrVerifiee(COL_DESCRIPTION, $description, 0, 250);
	}

	public function Histoire($histoire = NULL)
	{
		return $this->ValeurStrVerifiee(COL_HISTOIRE, $histoire, 0, NULL);
	}

	public function DateCreation($dateCreation = NULL)
	{
		return $this->ValeurDateTimeVerifiee(COL_DATECREATION, $dateCreation, DATE_NOW, true);
	}

	public function DateDerniereConnexion($dateDerniereConnexion = NULL)
	{
		return $this->ValeurDateTimeVerifiee(COL_DATEDERNIERECONNEXION, $dateDerniereConnexion);
	}

	public function DateSuppression($dateSuppression = NULL)
	{
		return $this->ValeurDateTimeVerifiee(COL_DATESUPPRESSION, $dateSuppression);
	}

	public function Supprime($supprime = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_SUPPRIME, $supprime, false, true);
	}

	public function Actif($actif = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_ACTIF, $actif, false, true);
	}

	public function CodeActivation($codeActivation = NULL)
	{
		return $this->ValeurStrVerifiee(COL_CODEACTIVATION, $codeActivation, 0, 40);
	}

	public function Prenom($prenom = NULL)
	{
		return $this->ValeurStrVerifiee(COL_PRENOM, $prenom, 0, 100);
	}

	public function Nom($nom = NULL)
	{
		return $this->ValeurStrVerifiee(COL_NOM, $nom, 0, 100);
	}

	public function DateNaissance($dateNaissance = NULL)
	{
		return $this->ValeurDateVerifiee(COL_DATENAISSANCE, $dateNaissance);
	}

	public function FuseauHoraire($fuseauHoraire = NULL)
	{
		return $this->ValeurStrVerifiee(COL_FUSEAUHORAIRE, $fuseauHoraire, 1, 40, NULL, 'UTC', true);
	}

	public function Participation($participation = NULL)
	{
		return $this->ValeurIntVerifiee(COL_PARTICIPATION, $participation, 0, NULL, 0, true);
	}

	public function Pub($pub = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_PUB, $pub, true, true);
	}

	public function DateFinNoPub($dateFinNoPub = NULL)
	{
		return $this->ValeurDateTimeVerifiee(COL_DATEFINNOPUB, $dateFinNoPub);
	}

	public function Aide($aide = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_AIDE, $aide, true, true);
	}

	public function Banni($banni = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_BANNI, $banni, false, true);
	}

	public function DateBannissement($dateBannissement = NULL)
	{
		return $this->ValeurDateTimeVerifiee(COL_DATEBANNISSEMENT, $dateBannissement);
	}

	public function DateFinBannissement($dateFinBannissement = NULL)
	{
		return $this->ValeurDateTimeVerifiee(COL_DATEFINBANNISSEMENT, $dateFinBannissement);
	}

	public function RaisonBannissement($raisonBannissement = NULL)
	{
		return $this->ValeurStrVerifiee(COL_RAISONBANNISSEMENT, $raisonBannissement, 0, 250);
	}

	public function SuperAdmin($superAdmin = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_SUPERADMIN, $superAdmin, false, true);
	}

	public function Langue($id = -1, $libelle = NULL, $icone = NULL, $communauteId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_LANGUE, 'MLangue', 1, true, $id, $libelle, $icone, $communauteId);
	}

	public function Communaute($id = -1, $libelle = NULL, $icone = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_COMMUNAUTE, 'MCommunaute', 1, true, $id, $libelle, $icone);
	}

	public function Monnaie($id = -1, $libelle = NULL, $symbole = NULL, $active = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_MONNAIE, 'MMonnaie', 1, true, $id, $libelle, $symbole, $active);
	}

	public function Bannisseur($id = -1, $login = NULL, $motDePasse = NULL, $pseudo = NULL, $description = NULL, $histoire = NULL, $dateCreation = NULL, $dateDerniereConnexion = NULL, $dateSuppression = NULL, $supprime = NULL, $actif = NULL, $codeActivation = NULL, $prenom = NULL, $nom = NULL, $dateNaissance = NULL, $fuseauHoraire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $aide = NULL, $langueId = NULL, $communauteId = NULL, $monnaieId = NULL, $banni = NULL, $bannisseurId = NULL, $dateBannissement = NULL, $dateFinBannissement = NULL, $raisonBannissement = NULL, $superAdmin = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_BANNISSEUR, 'MJoueur', NULL, false, $id, $login, $motDePasse, $pseudo, $description, $histoire, $dateCreation, $dateDerniereConnexion, $dateSuppression, $supprime, $actif, $codeActivation, $prenom, $nom, $dateNaissance, $fuseauHoraire, $participation, $pub, $dateFinNoPub, $aide, $langueId, $communauteId, $monnaieId, $banni, $bannisseurId, $dateBannissement, $dateFinBannissement, $raisonBannissement, $superAdmin);
	}

	/*************************************/
	public function Supprimer()
	{
		$id = $this->Id();

		if ($id !== NULL)
		{
			$this->Supprime(true);
			$this->DateSuppression(SQL_NOW);
			$this->Modifier();
		}
		else
			GLog::LeverException(EXM_0060, 'MJoueur::Supprimer, pas d\'id.');
	}

	public function ChargerFromLoginEtMotDePasse()
	{
		if ($this->Login() !== NULL && $this->MotDePasse() !== NULL)
		{
		   	$this->AjouterColSelection(COL_ID);
		   	$this->AjouterColSelection(COL_PSEUDO);
		  	$this->AjouterColSelection(COL_BANNI);
		  	$this->AjouterColSelection(COL_SUPPRIME);
		  	$this->AjouterColSelection(COL_ACTIF);
		  	$this->AjouterColSelection(COL_SUPERADMIN);
		   	$this->Charger(false);
		}
		else
		{
			if ($this->Login() == NULL)
				GLog::LeverException(EXM_0061, 'MJoueur::ChargerFromLoginEtMotDePasse, pas de login.');
			if ($this->MotDePasse() == NULL)
				GLog::LeverException(EXM_0062, 'MJoueur::ChargerFromLoginEtMotDePasse, pas de mot de passe.');
		}
	}

	public function ChargerFromLogin()
	{
		if ($this->Login() !== NULL)
		{
		   	$this->AjouterColSelection(COL_ID);
		   	$this->AjouterColSelection(COL_SUPPRIME);
		   	$this->Charger(false);
		}
		else
		{
			if ($this->Login() == NULL)
				GLog::LeverException(EXM_0063, 'MJoueur::ChargerFromLogin, pas de login.');
		}
	}

	public function ChargerFromPseudo()
	{
		if ($this->Pseudo() !== NULL)
		{
		   	$this->AjouterColSelection(COL_ID);
		   	$this->Charger(false);
		}
		else
		{
			if ($this->Pseudo() == NULL)
				GLog::LeverException(EXM_0064, 'MJoueur::ChargerFromPseudo, pas de pseudo.');
		}
	}
}

?>