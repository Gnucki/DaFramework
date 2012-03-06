<?php

require_once 'cst.php';
require_once INC_CSTLIBELLES;
require_once PATH_METIER.'mLangue.php';
require_once PATH_METIER.'mTypeLibelle.php';


class MLibelle extends MObjetMetier
{
	public function __construct($id = NULL, $libelle = NULL, $langueId = NULL, $typeLibelleId = NULL, $langueOriginelle = NULL)
	{
		$this->SetObjet($id, $libelle, $langueId, $typeLibelleId, $langueOriginelle);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $langueId = NULL, $typeLibelleId = NULL, $langueOriginelle = NULL)
	{
	   	parent::SetObjet($id);
		$this->AutoInc(false);

		$this->Libelle($libelle);
		$this->Langue($langueId);
		$this->TypeLibelle($typeLibelleId);
		$this->LangueOriginelle($langueOriginelle);
	}

	public function GetNom()
	{
	   	return 'MLibelle';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_LIBELLE);
	}

	/*************************************/
	public function Libelle($libelle = NULL)
	{
		return $this->ValeurStrVerifiee(COL_LIBELLE, $libelle, 0, 255);
	}

	public function Langue($id = -1, $libelle = NULL, $icone = NULL, $communauteId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_LANGUE, 'MLangue', GSession::Langue(COL_ID), true, $id, $libelle, $icone, $communauteId);
	}

	public function TypeLibelle($id = -1, $libelle = NULL, $ordre = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_TYPELIBELLE, 'MTypeLibelle', NULL, false, $id, $libelle, $ordre);
	}

	public function LangueOriginelle($id = -1, $libelle = NULL, $icone = NULL, $communauteId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_LANGUEORIGINELLE, 'MLangue', GSession::Langue(COL_ID), true, $id, $libelle, $icone, $communauteId);
	}
}

?>