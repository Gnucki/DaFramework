<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetDroit.php';


class MDroitGlobal extends MObjetDroit
{
	public function __construct($fonctionnaliteId = NULL, $gradeId = NULL, $autorise = NULL)
	{
		$this->SetObjet($fonctionnaliteId, $gradeId, $autorise);
	}

	public function SetObjet($fonctionnaliteId = NULL, $gradeId = NULL, $autorise = NULL)
	{
		parent::SetObjet($fonctionnaliteId, $autorise);

		$this->Grade($gradeId);
	}

	public function GetNom()
	{
	   	return 'MDroitGlobal';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_DROITGLOBAL);
	}

	/*************************************/
	public function Grade($id = -1, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GRADE, 'MGradeGlobalJoueur', NULL, true, $id, $nom, $description, $icone, $niveau, $superGradeId);
	}
}

?>