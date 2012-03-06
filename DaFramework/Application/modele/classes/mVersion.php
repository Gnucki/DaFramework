<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MVersion extends MObjetMetier
{
	public function __construct($id = NULL, $version = NULL, $commentaire = NULL, $dateProd = NULL)
	{
		$this->SetObjet($id, $version, $commentaire, $dateProd);
	}

	public function SetObjet($id = NULL, $version = NULL, $commentaire = NULL, $dateProd = NULL)
	{
		parent::SetObjet($id);

		$this->Version($version);
		$this->Commentaire($commentaire);
		$this->DateProd($dateProd);
	}

	public function GetNom()
	{
	   	return 'MVersion';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_VERSION);
	}

	/*************************************/
	public function Version($version = NULL)
	{
		return $this->ValeurStrVerifiee(COL_VERSION, $version, 0, 15);
	}

	public function Commentaire($commentaire = NULL)
	{
		return $this->ValeurStrVerifiee(COL_COMMENTAIRE, $commentaire, 0, 250);
	}

	public function DateProd($dateProd = NULL)
	{
		return $this->ValeurDateTimeVerifiee(COL_DATEPROD, $dateProd, DATE_NOW, true);
	}
}

?>