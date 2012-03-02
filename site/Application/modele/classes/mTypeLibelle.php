<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelleOrdre.php';
require_once PATH_METIER.'mListeTypesLibelles.php';


class MTypeLibelle extends MObjetLibelleOrdre
{
	public function __construct($id = NULL, $libelle = NULL, $ordre = NULL)
	{
		$this->SetObjet($id, $libelle, $ordre);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $ordre = NULL)
	{
		parent::SetObjet($id, $libelle, $ordre, NULL, NULL, TYPELIB_TYPELIBELLE);
	}

	public function GetNom()
	{
	   	return 'MTypeLibelle';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_TYPELIBELLE);
	}

	public function GetNouvelleListe()
	{
	   	return new MListeTypesLibelles();
	}
}

?>