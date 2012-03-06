<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelleDescriptionOrdre.php';
require_once PATH_METIER.'mListeFonctionnalites.php';


class MFonctionnalite extends MObjetLibelleDescriptionOrdre
{
	public function __construct($id = NULL, $libelle = NULL, $description = NULL, $ordre = NULL, $parametrable = NULL, $niveauGradeMinimum = NULL)
	{
		$this->SetObjet($id, $libelle, $description, $ordre, $parametrable, $niveauGradeMinimum);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $description = NULL, $ordre = NULL, $parametrable = NULL, $niveauGradeMinimum = NULL)
	{
		parent::SetObjet($id, $libelle, $description, $ordre, NULL, NULL, NULL, TYPELIB_FONCTIONNALITE);

		$this->Parametrable($parametrable);
		$this->NiveauGradeMinimum($niveauGradeMinimum);
	}

	public function GetNom()
	{
	   	return 'MFonctionnalite';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_FONCTIONNALITE);
	}

	public function GetNouvelleListe()
	{
	   	return new MListeFonctionnalites();
	}

	/*************************************/
	public function Parametrable($parametrable = NULL)
	{
	   	return $this->ValeurBoolVerifiee(COL_PARAMETRABLE, $parametrable, false, true);
	}

	public function NiveauGradeMinimum($niveauGradeMinimum = NULL)
	{
	   	return $this->ValeurIntVerifiee(COL_NIVEAUGRADEMINIMUM, $niveauGradeMinimum, 0, NULL, 0, true);
	}
}

?>