<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGrade.php';


class MGradeGroupe extends MObjetGrade
{
	public function __construct($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $poidsVoteRecrutement = NULL, $groupeId = NULL)
	{
		$this->SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId, $poidsVoteRecrutement, $groupeId);
	}

	public function SetObjet($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $poidsVoteRecrutement = NULL, $groupeId = NULL)
	{
		parent::SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId);

		$this->PoidsVoteRecrutement($poidsVoteRecrutement);
		$this->Groupe($groupeId);
	}

	public function GetNom()
	{
	   	return 'MGradeGroupe';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADEGROUPE);
	}

	/*************************************/
	public function PoidsVoteRecrutement($poidsVoteRecrutement = NULL)
	{
	   	return $this->ValeurIntVerifiee(COL_POIDSVOTERECRUTEMENT, $poidsVoteRecrutement, 0, NULL, 1, true);
	}

	public function Groupe($id = -1, $nom = NULL, $jeuId = NULL, $serveurId = NULL, $description = NULL, $histoire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $typeGroupeId = NULL, $etatRecrutementId = NULL, $messageRecrutement = NULL, $communauteId = NULL, $icone = NULL, $supprime = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GROUPE, 'MGroupe', NULL, true, $id, $nom, $jeuId, $serveurId, $description, $histoire, $participation, $pub, $dateFinNoPub, $typeGroupeId, $etatRecrutementId, $messageRecrutement, $communauteId, $icone, $supprime);
	}
}

?>