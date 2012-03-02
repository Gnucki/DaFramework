<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MContexte extends MObjetMetier
{
	public function __construct($id = NULL, $nom = NULL)
	{
		$this->SetObjet($id, $nom);
	}

	public function SetObjet($id = NULL, $nom = NULL)
	{
		parent::SetObjet($id);

		$this->Nom($nom);
	}

	public function GetNom()
	{
	   	return 'MContexte';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_CONTEXTE);
	}

	/*************************************/
	public function Nom($nom = NULL)
	{
		return $this->ValeurStrVerifiee(COL_NOM, $nom, 1, 40, "/^([a-zA-Z]+)$/", NULL, true);
	}
}

?>