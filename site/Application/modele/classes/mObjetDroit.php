<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MObjetDroit extends MObjetMetier
{
	public function __construct($fonctionnaliteId = NULL, $autorise = NULL)
	{
		$this->SetObjet($fonctionnaliteId, $autorise);
	}

	public function SetObjet($fonctionnaliteId = NULL, $autorise = NULL)
	{
		parent::SetObjet();
		$this->ClePrimaire(array(COL_FONCTIONNALITE, COL_GRADE));
		
		$this->Fonctionnalite($fonctionnaliteId);
		$this->Autorise($autorise);
	}

	public function GetNom()
	{
	   	return 'MObjetDroit';
	}

	/*************************************/
	public function Autorise($autorise = NULL)
	{
	   	return $this->ValeurBoolVerifiee(COL_AUTORISE, $autorise, false, true);
	}

	public function Fonctionnalite($id = -1, $libelle = NULL, $description = NULL, $ordre = NULL, $parametrable = NULL, $niveauGradeMinimum = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_FONCTIONNALITE, 'MFonctionnalite', NULL, true, $id, $libelle, $description, $ordre, $parametrable, $niveauGradeMinimum);
	}
}

?>