<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGradeJoueur.php';


class MGradeCommunauteJeuJoueur extends MObjetGradeJoueur
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
	   	return 'MGradeCommunauteJeuJoueur';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADECOMMUNAUTEJEUJOUEUR);
	}

	/*************************************/
	public function Grade($id = -1, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $communauteId = NULL, $jeuId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GRADE, 'MGradeCommunauteJeu', NULL, true, $id, $nom, $description, $icone, $niveau, $superGradeId, $communauteId, $jeuId);
	}
}

?>