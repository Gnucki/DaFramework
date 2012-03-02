<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGrade.php';


class MGradeCommunaute extends MObjetGrade
{
	public function __construct($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $communauteId = NULL)
	{
		$this->SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId, $communauteId);
	}

	public function SetObjet($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $communauteId = NULL)
	{
		parent::SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId);

		$this->Communaute($communauteId);
	}

	public function GetNom()
	{
	   	return 'MGradeCommunaute';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADECOMMUNAUTE);
	}

	/*************************************/
	public function Communaute($id = -1, $libelle = NULL, $icone = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_COMMUNAUTE, 'MCommunaute', NULL, true, $id, $libelle, $icone);
	}
}

?>