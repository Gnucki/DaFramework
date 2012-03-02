<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MMenuFonctionnalite extends MObjetMetier
{
	public function __construct($menuId = NULL, $fonctionnaliteId = NULL, $ordre = NULL)
	{
		$this->SetObjet($menuId, $fonctionnaliteId, $ordre);
	}

	public function SetObjet($menuId = NULL, $fonctionnaliteId = NULL, $ordre = NULL)
	{
	   	$this->noId = true;

		parent::SetObjet();

		$this->idAutoInc = false;
		$this->Menu($menuId);
		$this->Fonctionnalite($fonctionnaliteId);
	}

	public function GetNom()
	{
	   	return 'MMenuFonctionnalite';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_MENUFONCTIONNALITE);
	}

	/*************************************/
	public function Menu($id = -1, $libelle = NULL, $ordre = NULL, $menuId = NULL, $dependFonctionnalite = NULL)
	{
	   	return $this->ValeurObjetVerifiee(COL_MENU, 'MMenu', NULL, false, $id, $libelle, $ordre, $menuId, $dependFonctionnalite);
	}

	public function Fonctionnalite($id = -1, $libelle = NULL, $description = NULL, $ordre = NULL, $parametrable = NULL, $niveauGradeMinimum = NULL)
	{
	   	return $this->ValeurObjetVerifiee(COL_FONCTIONNALITE, 'MFonctionnalite', NULL, false, $id, $libelle, $description, $ordre, $parametrable, $niveauGradeMinimum);
	}
}

?>