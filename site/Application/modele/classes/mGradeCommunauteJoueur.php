<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGradeJoueur.php';


class MGradeCommunauteJoueur extends MObjetGradeJoueur
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
	   	return 'MGradeCommunauteJoueur';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADECOMMUNAUTEJOUEUR);
	}

	/*************************************/
	public function Grade($id = -1, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $communauteId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GRADE, 'MGradeCommunaute', NULL, true, $id, $nom, $description, $icone, $niveau, $superGradeId, $communauteId);
	}
}

?>