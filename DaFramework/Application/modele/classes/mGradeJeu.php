<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGrade.php';


class MGradeJeu extends MObjetGrade
{
	public function __construct($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $jeuId = NULL)
	{
		$this->SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId, $jeuId);
	}

	public function SetObjet($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $jeuId = NULL)
	{
		parent::SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId);

		$this->Jeu($jeuId);
	}

	public function GetNom()
	{
	   	return 'MGradeJeu';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADEJEU);
	}

	/*************************************/
	public function Jeu($id = -1)
	{
		return $this->ValeurObjetVerifiee(COL_JEU, 'MJeu', NULL, true, $id);
	}
}

?>