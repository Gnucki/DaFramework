<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelleDescriptionOrdre.php';
require_once PATH_METIER.'mListeTypesPresentationsModules.php';


class MTypePresentationModule extends MObjetLibelleDescriptionOrdre
{
	public function __construct($id = NULL, $libelle = NULL, $description = NULL, $ordre = NULL, $nomFichier = NULL, $actif = NULL)
	{
		$this->SetObjet($id, $libelle, $description, $ordre, $nomFichier, $actif);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $description = NULL, $ordre = NULL, $nomFichier = NULL, $actif = NULL)
	{
		parent::SetObjet($id, $libelle, $description, $ordre, NULL, NULL, NULL, TYPELIB_TYPEPRESENTATIONMODULE);

		$this->NomFichier($nomFichier);
		$this->Actif($actif);
	}

	public function GetNom()
	{
	   	return 'MTypePresentationModule';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_TYPEPRESENTATIONMODULE);
	}

	public function GetNouvelleListe()
	{
	   	return new MListeTypesPresentationsModules();
	}

	/*************************************/
	public function NomFichier($nomFichier = NULL)
	{
		return $this->ValeurStrVerifiee(COL_NOMFICHIER, $nomFichier, 5, 50, "/^([a-zA-Z0-9_-]+\.[a-zA-Z]{2,4})$/", NULL, true);
	}

	public function Actif($actif = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_ACTIF, $actif, false, true);
	}
}

?>