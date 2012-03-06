<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetDroit.php';


class MDroitSuperGrade extends MObjetDroit
{
	public function __construct($fonctionnaliteId = NULL, $superGradeId = NULL, $autorise = NULL)
	{
		$this->SetObjet($fonctionnaliteId, $superGradeId, $autorise);
	}

	public function SetObjet($fonctionnaliteId = NULL, $superGradeId = NULL, $autorise = NULL)
	{
		parent::SetObjet($fonctionnaliteId, $autorise);
		$this->ClePrimaire(array(COL_FONCTIONNALITE, COL_SUPERGRADE));

		$this->SuperGrade($superGradeId);
	}

	public function GetNom()
	{
	   	return 'MDroitSuperGrade';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_DROITSUPERGRADE);
	}

	/*************************************/
	public function Autorise($autorise = NULL)
	{
	   	return $this->ValeurBoolVerifiee(COL_AUTORISE, $autorise, true, true);
	}

	public function SuperGrade($id = -1, $libelle = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $poidsVoteRecrutement = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_SUPERGRADE, 'MSuperGrade', NULL, true, $id, $libelle, $description, $icone, $niveau, $poidsVoteRecrutement);
	}
}

?>