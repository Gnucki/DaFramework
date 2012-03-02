<?php

require_once 'cst.php';
require_once PATH_BASE.'bCategorie.php';


class MCategorie extends MObjetMetier
{
	protected $sNom;
	protected $sIcone;
	
	public function __construct($id = NULL, $nom = NULL, $icone = NULL)
	{
		parent::__construct();
		$this->SetObjet($id, $nom, $icone);
	}
	
	public function SetObjet($id = NULL, $nom = NULL, $icone = NULL)
	{
		$this->Id($id);
		$this->Nom($nom);
		$this->Icone($icone);
	}
	
	public function UnsetObjet()
	{	
		parent::UnsetObjet();

		unset($this->sNom);
		unset($this->sIcone);
	}
	
	/*************************************/
	public function Nom($nom = NULL)
	{
		if ($nom != NULL)
			$this->sNom = ValeurStrVerifiee($nom, 100);
		return $this->sNom;
	}
	
	public function Icone($icone = NULL)
	{
		if ($icone != NULL)
			$this->sIcone = ValeurStrVerifiee($icone, 100);
		return $this->sIcone;
	}

	/*************************************/
	public function Ajouter()
	{
		if ($this->Nom() != NULL)
		{
			$bCategorie = new BCategorie();
			$this->Id($bCategorie->Ajouter($this->Nom(), $this->Icone()));
		}
		else
			GSession::LeverException(EXM_0010, 'MCategorie::Ajouter, pas de nom.');
	}
	
	public function Modifier()
	{
		$id = $this->Id();
		if ($id != NULL)
		{
			$bCategorie = new BCategorie();
			$bCategorie->Modifier($id, $this->Nom(), $this->Icone());
		}
		else
			GSession::LeverException(EXM_0011, 'MCategorie::Modifier, pas d\'id categorie.');
	}
	
	public function Supprimer()
	{
		$id = $this->Id();
		if ($id != NULL)
		{
			$bCategorie = new BCategorie();
			$bCategorie->Supprimer($id);
		}
		else
			GSession::LeverException(EXM_0012, 'MCategorie::Supprimer, pas d\'id categorie.');
	}
}

?>