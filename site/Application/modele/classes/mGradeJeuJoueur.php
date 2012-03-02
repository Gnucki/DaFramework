<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGradeJoueur.php';


class MGradeJeuJoueur extends MObjetGradeJoueur
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
	   	return 'MGradeJeuJoueur';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADEJEUJOUEUR);
	}

	/*************************************/
	public function Grade($id = -1, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $jeuId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GRADE, 'MGradeJeu', NULL, true, $id, $nom, $description, $icone, $niveau, $superGradeId, $jeuId);
	}
}

?>