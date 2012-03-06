<?php

require_once 'cst.php';
require_once PATH_CST.'cstEtatsRecrutement.php';
require_once PATH_METIER.'mObjetMetier.php';


class MGroupe extends MObjetMetier
{
	public function __construct($id = NULL, $nom = NULL, $jeuId = NULL, $serveurId = NULL, $description = NULL, $histoire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $typeGroupeId = NULL, $etatRecrutementId = NULL, $messageRecrutement = NULL, $communauteId = NULL, $icone = NULL, $supprime = NULL)
	{
		$this->SetObjet($id, $nom, $jeuId, $serveurId, $description, $histoire, $participation, $pub, $dateFinNoPub, $typeGroupeId, $etatRecrutementId, $messageRecrutement, $communauteId, $icone, $supprime);
	}

	public function SetObjet($id = NULL, $nom = NULL, $jeuId = NULL, $serveurId = NULL, $description = NULL, $histoire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $typeGroupeId = NULL, $etatRecrutementId = NULL, $messageRecrutement = NULL, $communauteId = NULL, $icone = NULL, $supprime = NULL)
	{
		parent::SetObjet($id);

		$this->Nom($nom);
		$this->Jeu($jeuId);
		$this->Serveur($serveurId);
		$this->Description($description);
		$this->Histoire($histoire);
		$this->Participation($participation);
		$this->Pub($pub);
		$this->DateFinNoPub($dateFinNoPub);
		$this->TypeGroupe($typeGroupeId);
		$this->EtatRecrutement($etatRecrutementId);
		$this->MessageRecrutement($messageRecrutement);
		$this->Communaute($communauteId);
		$this->Icone($icone);
		$this->Supprime($supprime);
	}

	public function GetNom()
	{
	   	return 'MGroupe';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GROUPE);
	}

	/*************************************/
	public function Nom($nom = NULL)
	{
		return $this->ValeurStrVerifiee(COL_NOM, $nom, 0, 70);
	}

	public function Description($description = NULL)
	{
		return $this->ValeurStrVerifiee(COL_DESCRIPTION, $description, 0, 250);
	}

	public function Histoire($histoire = NULL)
	{
		return $this->ValeurStrVerifiee(COL_HISTOIRE, $histoire, 0, NULL);
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
		return $this->ValeurDateVerifiee(COL_DATEFINNOPUB, $dateFinNoPub);
	}

	public function MessageRecrutement($messageRecrutement = NULL)
	{
		return $this->ValeurStrVerifiee(COL_MESSAGERECRUTEMENT, $messageRecrutement, 0, 250);
	}

	public function Icone($icone = NULL)
	{
		return $this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}

	public function Supprime($supprime = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_SUPPRIME, $supprime, false, true);
	}

	public function Jeu($id = -1, $libelle = NULL, $icone = NULL, $niveauMax = NULL, $necessiteBoss = NULL, $necessiteClasse = NULL, $necessiteMetier = NULL, $necessiteNiveau = NULL, $necessiteObjet = NULL, $necessiteRole = NULL, $necessiteServeur = NULL, $typeJeuId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_JEU, 'MJeu', NULL, false, $id, $libelle, $icone, $niveauMax, $necessiteBoss, $necessiteClasse, $necessiteMetier, $necessiteNiveau, $necessiteObjet, $necessiteRole, $necessiteServeur, $typeJeuId);
	}

	public function Serveur($id = -1, $libelle = NULL, $supprime = NULL, $jeuId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_SERVEUR, 'MServeur', NULL, false, $id, $libelle, $supprime, $jeuId);
	}

	public function TypeGroupe($id = -1, $libelle = NULL, $jeuId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_TYPEGROUPE, 'MTypeGroupe', NULL, true, $id, $libelle, $jeuId);
	}

	public function EtatRecrutement($id = -1, $libelle = NULL, $description = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_ETATRECRUTEMENT, 'MEtatRecrutement', ETREC_OUVERT, true, $id, $libelle, $description);
	}

	public function Communaute($id = -1, $libelle = NULL, $icone = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_COMMUNAUTE, 'MCommunaute', 1, true, $id, $libelle, $icone);
	}
}

?>