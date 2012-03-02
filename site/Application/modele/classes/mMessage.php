<?php

require_once 'cst.php';
require_once PATH_BASE.'bSujet.php';


class MSujet extends MObjetMetier
{
	protected $iId;
	protected $sCommentaire;
	protected $dDateCreation;
	
	protected $oCategorie; 		// MCategorie.
	protected $oCreateur; 		// MJoueur.

	public function __construct($id, $commentaire = NULL, $dateCreation = NULL, $categorieId = NULL, $createurId = NULL)
	{
		parent::__construct();
		$this->SetObjet($id, $commentaire, $dateCreation, $categorieId, $createurId);
	}
	
	public function __destruct() 
	{
		parent::__destruct();
        $this->UnsetObjet();
    }
	
	public function SetObjet($id, $commentaire = NULL, $dateCreation = NULL, $categorieId = NULL, $createurId = NULL)
	{
		$this->Id($id);
		$this->Commentaire($commentaire);
		$this->DateCreation($dateCreation);
		
		$this->Categorie($categorieId);
		$this->Createur($createurId);
	}
	
	public function UnsetObjet()
	{
		unset($iId);
		unset($sCommentaire);
		unset($dDateCreation);
		
		unset($oCategorie);
		unset($oCreateur);
	}
	
	public function Id($id = NULL)
	{
		if ($id != NULL)
			$this->iId = ValeurIntVerifiee($id, 1);
		return $this->iId;
	}
	
	public function Commentaire($commentaire = NULL)
	{
		if ($commentaire != NULL)
			$this->sCommentaire = ValeurStrVerifiee($commentaire);
		return $this->sCommentaire;
	}
	
	public function DateCreation($dateCreation = NULL)
	{
		if ($dateCreation != NULL)
			$this->dDateCreation = ValeurDateVerifiee($dateCreation);
		return $this->dDateCreation;
	}
	
	public function Categorie($id = NULL, $nom = NULL, $commentaire = NULL, $categorieId = NULL, $groupeId = NULL, $typeCategorieId = NULL)
	{
		if ($id != NULL)
		{
			if ($this->oCategorie == NULL)
				$this->oCategorie = new MCategorie($id, $nom, $commentaire, $categorieId, $groupeId, $typeCategorieId);
			else
				$this->oCategorie->SetObjet($id, $nom, $commentaire, $categorieId, $groupeId, $typeCategorieId);
		}
		return $this->oCategorie;
	}
	
	public function Createur($id = NULL, ...)
	{
		if ($id != NULL)
			$this->oCreateur = new MJoueur($id, ...);
		return $this->oCreateur;
	}

	/*public function Charger()
	{
		$bSujet = new BSujet();
		$categorie = $this->Categorie();
		if ($categorie != NULL && $categorie->Id() != NULL)
			$bSujet->ChargerListeSujetsFromCategorie($oCategorie->iId);
		else if ($categorie != NULL)
		{
			$id = $this->Id();
			if ($id == NULL)
				$id = '-1';
			GSession::LeverException(EXM_0000, 'MSujet::ChargerFromCategorie, pas de categorie pour le sujet ['.$id.']');
		}
	}*/
}

?>