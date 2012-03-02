<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGradeJoueur.php';


class MGradeGroupeJoueur extends MObjetGradeJoueur
{
	public function __construct($joueurId = NULL, $gradeId = NULL)
	{
		$this->SetObjet($joueurId, $gradeId);
	}

	public function SetObjet($joueurId = NULL, $gradeId = NULL)
	{
		parent::SetObjet($joueurId);

		$this->Grade($gradeId);
	}

	public function GetNom()
	{
	   	return 'MGradeGroupeJoueur';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADEGROUPEJOUEUR);
	}

	/*************************************/
	public function Grade($id = -1, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $poidsVoteRecrutement = NULL, $groupeId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GRADE, 'MGradeGroupe', NULL, true, $id, $nom, $description, $icone, $niveau, $superGradeId, $poidsVoteRecrutement, $groupeId);
	}
}

?>