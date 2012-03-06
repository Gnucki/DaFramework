<?php

require_once 'cst.php';
require_once PATH_BASE.'bTypeSujet.php';
require_once PATH_METIER.'mObjetMetier.php';


class MTypeSujet extends MLibelle
{
	protected $sDescription
	
	public function __construct($id = NULL, $libelle = NULL, $description = NULL)
	{
		parent::__construct();
		$this->SetObjet($id, $libelle, $description);
	}
	
	public function SetObjet($id = NULL, $libelle = NULL, $description = NULL)
	{
		$this->Id($id);
		$this->Libelle($libelle);
		$this->Description($description);
	}
	
	public function UnsetObjet()
	{
		parent::UnsetObjet();
		
		unset($this->sDescription);
	}
	
	/*************************************/
	public function Charger($libelle = true, $description = true)
	{
		$id = $this->Id();
		if ($id != NULL)
		{	
			$bTypeSujet = new BTypeSujet();
			$typeSujet = $bTypeSujet->Charger($id, $libelle, $description);
			$this->SetObjet($id, $typeSujet[COL_LIBELLE], $typeSujet[COL_DESCRIPTION]);
		}
		else
			GSession::LeverException(EXM_0031, 'MTypeSujet::Charger, pas d\'id TypeSujet.');
	}
}

?>