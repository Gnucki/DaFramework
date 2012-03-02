<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGrade.php';


class MGradeCommunauteJeu extends MObjetGrade
{
	public function __construct($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $communauteId = NULL, $jeuId = NULL)
	{
		$this->SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId, $communauteId, $jeuId);
	}

	public function SetObjet($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL, $communauteId = NULL, $jeuId = NULL)
	{
		parent::SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId);

		$this->Communaute($communauteId);
		$this->Jeu($jeuId);
	}

	public function GetNom()
	{
	   	return 'MGradeCommunauteJeu';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADECOMMUNAUTEJEU);
	}

	/*************************************/
	public function Communaute($id = -1, $libelle = NULL, $icone = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_COMMUNAUTE, 'MCommunaute', NULL, true, $id, $libelle, $icone);
	}

	public function Jeu($id = -1)
	{
		return $this->ValeurObjetVerifiee(COL_JEU, 'MJeu', NULL, true, $id);
	}
}

?>