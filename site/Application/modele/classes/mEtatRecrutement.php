<?php

require_once 'cst.php';
require_once PATH_CST.'cstEtatsRecrutement.php';
require_once PATH_METIER.'mObjetLibelleDescriptionOrdre.php';


class MEtatRecrutement extends MObjetLibelleDescriptionOrdre
{
	public function __construct($id = NULL, $libelle = NULL, $description = NULL, $ordre = NULL)
	{
		$this->SetObjet($id, $libelle, $description, $ordre);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $description = NULL, $ordre = NULL)
	{
		parent::SetObjet($id, $libelle, $description, $ordre, NULL, NULL, NULL, TYPELIB_RECRUTEMENT);
	}

	public function GetNom()
	{
	   	return 'MEtatRecrutement';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_ETATRECRUTEMENT);
	}
}

?>