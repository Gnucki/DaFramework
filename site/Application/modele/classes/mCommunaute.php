<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelle.php';


class MCommunaute extends MObjetLibelle
{
	public function __construct($id = NULL, $libelle = NULL, $icone = NULL)
	{
		$this->SetObjet($id, $libelle, $icone);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $icone = NULL)
	{
		parent::SetObjet($id, $libelle, NULL, NULL, TYPELIB_COMMUNAUTE);

		$this->Icone($icone);
	}

	public function GetNom()
	{
	   	return 'MCommunaute';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_COMMUNAUTE);
	}

	/*************************************/
	public function Icone($icone = NULL)
	{
		$this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}
}

?>