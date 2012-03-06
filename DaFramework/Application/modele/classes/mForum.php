<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetOrdre.php';
require_once INC_GLOG;


class MForum extends MObjetOrdre
{
	public function __construct($id = NULL, $ordre = NULL, $nom = NULL, $description = NULL, $presentation = NULL, $icone = NULL, $nbSujets = NULL, $nbMessages = NULL, $officier = NULL, $accepteForum = NULL, $accepteSujet = NULL, $forumId = NULL, $categorieId = NULL, $groupeId = NULL, $typeForumId = NULL, $typeAccesId = NULL)
	{
		$this->SetObjet($id, $nom, $description, $presentation, $icone, $nbSujets, $nbMessages, $officier, $accepteForum, $accepteSujet, $forumId, $categorieId, $groupeId, $typeForumId, $typeAccesId);
	}

	public function SetObjet($id = NULL, $ordre = NULL, $nom = NULL, $description = NULL, $presentation = NULL, $icone = NULL, $nbSujets = NULL, $nbMessages = NULL, $officier = NULL, $accepteForum = NULL, $accepteSujet = NULL, $forumId = NULL, $categorieId = NULL, $groupeId = NULL, $typeForumId = NULL, $typeAccesId = NULL)
	{
		parent::SetObjet($id, $ordre, array(COL_GROUPE, COL_FORUM));

		$this->Nom($nom);
		$this->Description($description);
		$this->Presentation($presentation);
		$this->Icone($icone);
		$this->NbSujets($nbSujets);
		$this->NbMessages($nbMessages);
		$this->Officier($officier);
		$this->AccepteForum($accepteForum);
		$this->AccepteSujet($accepteSujet);
		$this->Forum($forumId);
		$this->Categorie($categorieId);
		$this->Groupe($groupeId);
		$this->TypeForum($typeForumId);
		$this->TypeAcces($typeAccesId);
	}

	public function GetNom()
	{
	   	return 'MForum';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_FORUM);
	}

	public function GetNouvelleListe()
	{
		return new MListeForums();
	}

	/*************************************/
	public function Nom($nom = NULL)
	{
		return $this->ValeurStrVerifiee(COL_NOM, $nom, 1, 100, NULL, NULL, true);
	}

	public function Description($description = NULL)
	{
		return $this->ValeurStrVerifiee(COL_DESCRIPTION, $description, 1, 250);
	}

	public function Presentation($presentation = NULL)
	{
		return $this->ValeurStrVerifiee(COL_PRESENTATION, $presentation, 0, NULL);
	}

	public function Icone($icone = NULL)
	{
		return $this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}

	public function NbSujets($nbSujets = NULL)
	{
		return $this->ValeurIntVerifiee(COL_NBSUJETS, $nbSujets, 1, NULL, NULL, true);
	}

	public function NbMessages($nbMessages = NULL)
	{
		return $this->ValeurIntVerifiee(COL_NBMESSAGES, $nbMessages, 1, NULL, NULL, true);
	}

	public function Officier($officier = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_OFFICIER, $officier, false, true);
	}

	public function AccepteForum($accepteForum = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_ACCEPTEFORUM, $accepteForum, true, true);
	}

	public function AccepteSujet($accepteSujet = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_ACCEPTESUJET, $accepteSujet, true, true);
	}

	public function Forum($id = NULL, $ordre = NULL, $nom = NULL, $description = NULL, $presentation = NULL, $icone = NULL, $nbSujets = NULL, $nbMessages = NULL, $officier = NULL, $accepteForum = NULL, $accepteSujet = NULL, $forumId = NULL, $categorieId = NULL, $groupeId = NULL, $typeForumId = NULL, $typeAccesId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_FORUM, 'MForum', null, true, $id, $nom, $description, $presentation, $icone, $nbSujets, $nbMessages, $officier, $accepteForum, $accepteSujet, $forumId, $categorieId, $groupeId, $typeForumId, $typeAccesId);
	}

	public function Categorie($id = NULL, $nom = NULL, $icone = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_CATEGORIE, 'MForumCategorie', null, true, $id, $nom, $icone);
	}

	public function Groupe($id = NULL, $nom = NULL, $jeuId = NULL, $serveurId = NULL, $description = NULL, $histoire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $typeGroupeId = NULL, $etatRecrutementId = NULL, $messageRecrutement = NULL, $communauteId = NULL, $icone = NULL, $supprime = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GROUPE, 'MGroupe', null, true, $id, $nom, $jeuId, $serveurId, $description, $histoire, $participation, $pub, $dateFinNoPub, $typeGroupeId, $etatRecrutementId, $messageRecrutement, $communauteId, $icone, $supprime);
	}

	public function TypeForum($id = NULL, $libelle = NULL, $description = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_TYPEFORUM, 'MTypeForum', null, true, $id, $libelle, $description);
	}

	public function TypeAcces($id = NULL, $libelle = NULL, $description = NULL, $ordre = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_TYPEACCES, 'MTypeAcces', null, true, $id, $libelle, $description, $ordre);
	}

	public function ListeForums($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeForums !== NULL)
	   	   	$oldId = $this->mListeForums->GetFiltreValeur(0, COL_JEU);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeForums !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeForums);
	   	}
	   	else if ($this->mListeForums === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeForums === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeForums = new MListeForums();
		   	   	$this->mListeForums->AjouterColSelection(COL_NOM);
		   	   	$this->mListeForums->AjouterColSelection(COL_DESCRIPTION);
		   	   	$this->mListeForums->AjouterColOrdre(COL_ORDRE);
		   	}
			$this->mListeForums->AjouterFiltreEgal(COL_FORUM, $this->Id());
	   	}

	   	if ($this->mListeForums !== NULL && $liste !== NULL)
	   		$this->mListeForums->SetListeFromTableau($liste);

	   	return $this->mListeForums;
	}
}

?>