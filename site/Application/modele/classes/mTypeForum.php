<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelleDescription.php';


class MTypeForum extends MObjetLibelleDescription
{
	public function __construct($id = NULL, $libelle = NULL, $description = NULL)
	{
		$this->SetObjet($id, $libelle, $description);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $description = NULL)
	{
		parent::SetObjet($id, $libelle, $description, NULL, NULL, NULL, TYPELIB_FORUM);
	}

	public function GetNom()
	{
	   	return 'MTypeForum';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_TYPEFORUM);
	}
}

?>