<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MMenuContexte extends MObjetMetier
{
	public function __construct($menuId = NULL, $contexteId = NULL, $ordre = NULL)
	{
		$this->SetObjet($menuId, $contexteId, $ordre);
	}

	public function SetObjet($menuId = NULL, $contexteId = NULL, $ordre = NULL)
	{
		parent::SetObjet();
		$this->ClePrimaire(array(COL_MENU, COL_CONTEXTE));
		
		$this->Menu($menuId);
		$this->Contexte($contexteId);
		$this->Ordre($ordre);
	}

	public function GetNom()
	{
	   	return 'MMenuContexte';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_MENUCONTEXTE);
	}

	/*************************************/
	public function Menu($id = -1, $libelle = NULL, $ordre = NULL, $menuId = NULL, $dependFonctionnalite = NULL)
	{
	   	return $this->ValeurObjetVerifiee(COL_MENU, 'MMenu', NULL, false, $id, $libelle, $ordre, $menuId, $dependFonctionnalite);
	}

	public function Contexte($id = -1, $nom = NULL)
	{
	   	return $this->ValeurObjetVerifiee(COL_CONTEXTE, 'MContexte', NULL, false, $id, $nom);
	}

	public function Ordre($ordre = NULL)
	{
		return $this->ValeurIntVerifiee(COL_ORDRE, $ordre, 0, NULL, NULL, true);
	}
}

?>