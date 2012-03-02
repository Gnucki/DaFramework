<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelle.php';


class MMonnaie extends MObjetMetier
{
	protected $sLibelle;
	protected $sSymbole;
	protected $bActive;

	public function __construct($id = NULL, $libelle = NULL, $symbole = NULL, $active = NULL)
	{
		$this->SetObjet($id, $libelle, $symbole, $active);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $symbole = NULL, $active = NULL)
	{
		parent::SetObjet($id);

		$this->Libelle($libelle);
		$this->Symbole($symbole);
		$this->Active($active);
	}

	public function GetNom()
	{
	   	return 'MMonnaie';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_MONNAIE);
	}

	/*************************************/
	public function Libelle($libelle = NULL)
	{
		return $this->ValeurStrVerifiee(COL_LIBELLE, $libelle, 0, 30);
	}

	public function Symbole($symbole = NULL)
	{
		return $this->ValeurStrVerifiee(COL_SYMBOLE, $symbole, 0, 5);
	}

	public function Active($active = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_ACTIVE, $active, false, true);
	}
}

?>