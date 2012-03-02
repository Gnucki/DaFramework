<?php

require_once 'cst.php';
require_once PATH_BASE.'bSujet.php';
require_once PATH_BASE.'bMessage.php';
require_once PATH_METIER.'mObjetMetier.php';
require_once PATH_METIER.'mForum.php';
require_once PATH_METIER.'mJoueur.php';
require_once PATH_METIER.'mTypeSujet.php';
require_once INC_GLOG;


class MSujet extends MObjetMetier
{
	protected $sNom;
	protected $sCommentaire;
	protected $dDateCreation;
	protected $dDateDernierMess;
	protected $iNbVues;
	protected $iVersion;
	protected $bModeWiki;
	
	protected $oForum; 			// MForum.
	protected $oCreateur; 		// MJoueur.
	protected $oDernierPosteur;	// MJoueur.
	protected $oTypeSujet;		// MTypeSujet.

	public function __construct($id = NULL, $nom = NULL, $commentaire = NULL, $dateCreation = NULL, $dateDernierMess = NULL, $nbVues = NULL, $version = NULL, $modeWiki = NULL, $forumId = NULL, $createurId = NULL, $dernierPosteurId = NULL, $typeSujetId = NULL)
	{
		parent::__construct();
		$this->SetObjet($id, $nom, $commentaire, $dateCreation, $nbVues, $version, $modeWiki, $forumId, $createurId, $dernierPosteurId, $typeSujet);
	}
	
	public function SetObjet($id = NULL, $nom = NULL, $commentaire = NULL, $dateCreation = NULL, $dateDernierMess = NULL, $nbVues = NULL, $version = NULL, $modeWiki = NULL, $forumId = NULL, $createurId = NULL, $dernierPosteurId = NULL, $typeSujetId = NULL)
	{
		$this->Id($id);
		$this->Nom($nom);
		$this->Commentaire($commentaire);
		$this->DateCreation($dateCreation);
		$this->DateDernierMess($dateDernierMess);
		$this->NbVues($nbVues);
		$this->Version($version);
		$this->ModeWiki($modeWiki);
		
		$this->Forum($forumId);
		$this->Createur($createurId);
		$this->DernierPosteur($dernierPosteurId);
		$this->TypeSujet($typeSujetId);
	}
	
	public function SetObjetFromSQL($bufferSQL, $colId = NULL, $colNom = NULL, $colCommentaire = NULL, $colDateCreation = NULL, $colDateDernierMess = NULL, $colNbVues = NULL, $colVersion = NULL, $colModeWiki = NULL, $colForumId = NULL, $colCreateurId = NULL, $colDernierPosteurId = NULL, $colTypeSujetId = NULL)
	{
		if ($colId !== false)
			$this->Id($bufferSQL[$colId]);
		if ($colNom !== false)
			$this->Nom($bufferSQL[$colNom]);
		if ($colDescription !== false)
			$this->Commentaire($bufferSQL[$colCommentaire]);
		if ($colDateCreation !== false)
			$this->DateCreation($bufferSQL[$colDateCreation]);
		if ($colDateDernierMess !== false)
			$this->DateDernierMess($bufferSQL[$colDateDernierMess]);
		if ($colNbVues !== false)
			$this->NbVues($bufferSQL[$colNbVues]);
		if ($colVersion !== false)
			$this->Version($bufferSQL[$colVersion]);
		if ($colModeWiki !== false)
			$this->ModeWiki($bufferSQL[$colModeWiki]);
		if ($colForumId !== false)
			$this->Forum($bufferSQL[$colForumId]);
		if ($colCreateurId !== false)
			$this->Createur($bufferSQL[$colCreateurId]);
		if ($colDernierPosteurId !== false)
			$this->DernierPosteur($bufferSQL[$colDernierPosteurId]);
		if ($colTypeSujetId !== false)
			$this->TypeSujet($bufferSQL[$colTypeSujetId]);
	}
	
	public function UnsetObjet()
	{	
		parent::UnsetObjet();

		unset($this->sNom);
		unset($this->sCommentaire);
		unset($this->dDateCreation);
		unset($this->dDateDernierMess);
		unset($this->nbVues);
		unset($this->version);
		unset($this->modeWiki);
		
		unset($this->oForum);
		unset($this->oCreateur);
		unset($this->oDernierPosteur);
		unset($this->oTypeSujet);
	}
	
	/*************************************/	
	public function Nom($nom = NULL)
	{
		if ($nom != NULL)
			$this->sNom = ValeurStrVerifiee($nom, 150);
		return $this->sNom;
	}
	
	public function Commentaire($commentaire = NULL)
	{
		if ($commentaire != NULL)
			$this->sCommentaire = ValeurStrVerifiee($commentaire, 250);
		return $this->sCommentaire;
	}
	
	public function DateCreation($dateCreation = NULL)
	{
		if ($dateCreation != NULL)
			$this->dDateCreation = ValeurDateVerifiee($dateCreation);
		return $this->dDateCreation;
	}
	
	public function DateDernierMess($dateDernierMess = NULL)
	{
		if ($dateDernierMess != NULL)
			$this->dDateDernierMess = ValeurDateVerifiee($dateDernierMess);
		return $this->dDateDernierMess;
	}
	
	public function NbVues($nbVues = NULL)
	{
		if ($nbVues != NULL)
			$this->iNbVues = ValeurIntVerifiee($nbVues, 0);
		return $this->iNbVues;
	}
	
	public function Version($version = NULL)
	{
		if ($version != NULL)
			$this->iVersion = ValeurIntVerifiee($version, 0);
		return $this->iVersion;
	}
	
	public function ModeWiki($modeWiki = NULL)
	{
		if ($modeWiki != NULL)
			$this->bModeWiki = ValeurBoolVerifiee($modeWiki);
		return $this->bModeWiki;
	}
	
	public function Forum($id = NULL, $nom = NULL, $commentaire = NULL, $icone = NULL, $nbSujets = NULL, $nbMessages = NULL, $version = NULL, $forumId = NULL, $categorieId = NULL, $groupeId = NULL, $typeForumId = NULL)
	{
		if ($id != NULL)
		{
			if ($this->oForum == NULL)
				$this->oForum = new MForum($id, $nom, $commentaire, $icone, $nbSujets, $nbMessages, $version, $forumId, $categorieId, $groupeId, $typeForumId);
			else
				$this->oForum->SetObjet($id, $nom, $commentaire, $icone, $nbSujets, $nbMessages, $version, $forumId, $categorieId, $groupeId, $typeForumId);
		}
		return $this->oForum;
	}
	
	public function Createur($id = NULL)
	{
		if ($id != NULL)
		{
			if ($this->oCreateur == NULL)
				$this->oCreateur = new MJoueur($id);
			else
				$this->oCreateur->SetObjet($id);
		}
		return $this->oCreateur;
	}
	
	public function DernierPosteur($id = NULL)
	{
		if ($id != NULL)
		{
			if ($this->oDernierPosteur == NULL)
				$this->oDernierPosteur = new MJoueur($id);
			else
				$this->oDernierPosteur->SetObjet($id);
		}
		return $this->oDernierPosteur;
	}
	
	public function TypeSujet($id = NULL, $libelle = NULL, $description = NULL)
	{
		if ($id != NULL)
		{
			if ($this->oTypeSujet == NULL)
				$this->oTypeSujet = new MTypeSujet($id, $libelle, $description);
			else
				$this->oTypeSujet->SetObjet($id, $libelle, $description);
		}
		return $this->oTypeSujet;
	}

	/*************************************/
	public function Ajouter()
	{
		$forumId = NULL;
		if ($this->Forum() != NULL)
			$forumId = $this->Forum()->Id();
		$createurId = NULL;
		if ($this->Createur() != NULL)
			$createurId = $this->Createur()->Id();
		$typeSujetId = NULL;
		if ($this->TypeSujet() != NULL)
			$typeSujetId = $this->TypeSujet()->Id();
		$dernierPosteurId = NULL;
		if ($this->DernierPosteur() != NULL)
			$dernierPosteurId = $this->DernierPosteur()->Id();
			
		if ($typeSujetId != NULL && $createurId != NULL && $dernierPosteurId != NULL && $this->Nom() != NULL)
		{
			if ($this->NbVues() == NULL)
				$this->NbVues(0);
			if ($this->Version() == NULL)
				$this->Version(1);
			if ($this->DateCreation == NULL)
				$this->DateCreation(SQL_NOW);
			
			$bSujet = new BSujet();
			$this->Id($bSujet->Ajouter($this->Nom(), $this->Commentaire(), $this->DateCreation(), $this->DateDernierMess(), $this->NbVues(), $this->Version(), $this->ModeWiki(), $forumId, $createurId, $dernierPosteurId, $typeSujetId));
		}
		else
		{
			if ($typeSujetId == NULL)
				GLog::LeverException(EXM_0040, 'MSujet::Ajouter, pas d\'id type sujet.');
			if ($createurId == NULL)
				GLog::LeverException(EXM_0041, 'MSujet::Ajouter, pas d\'id créateur.');
			if ($this->Nom() == NULL)
				GLog::LeverException(EXM_0042, 'MSujet::Ajouter, pas de nom.');
		}
		
	}
	
	public function Modifier()
	{
		$id = $this->Id();
		if ($id != NULL)
		{
			$forumId = NULL;
			if ($this->Forum() != NULL)
				$forumId = $this->Forum()->Id();
			$createurId = NULL;
			if ($this->Createur() != NULL)
				$createurId = $this->Createur()->Id();
			$typeSujetId = NULL;
			if ($this->TypeSujet() != NULL)
				$typeSujetId = $this->TypeSujet()->Id();
			$dernierPosteurId = NULL;
			if ($this->DernierPosteur() != NULL)
				$dernierPosteurId = $this->DernierPosteur()->Id();
			
			$bSujet = new BForum();
			$bForum->Modifier($id, $this->Nom(), $this->Commentaire(), $this->DateCreation(), $this->DateDernierMess(), $this->NbVues(), $this->Version(), $this->ModeWiki(), $forumId, $createurId, $dernierPosteurId, $typeSujetId);
		}
		else
			GLog::LeverException(EXM_0043, 'MSujet::Modifier, pas d\'id.');
	}
	
	public function Supprimer()
	{
		$id = $this->Id();
		if ($id != NULL)
		{
			// On supprime les message du sujet.
			$bMessage = new BMessage();
			$bMessage->SupprimerFromForum($id);

			// On supprime le sujet.
			$bSujet = new BSujet();
			$bSujet->Supprimer($id);
		}
		else
			GLog::LeverException(EXM_0044, 'MSujet::Supprimer, pas d\'id.');
	}
	
	public function Charger($colNom = NULL, $colCommentaire = NULL, $colDateCreation = NULL, $colDateDernierMess = NULL, $colNbVues = NULL, $colVersion = NULL, $colModeWiki = NULL, $colForumId = NULL, $colCreateurId = NULL, $colDernierPosteurId = NULL, $colTypeSujetId = NULL)
	{
		$id = $this->Id();
		if ($id != NULL)
		{
			$bSujet = new BSujet();
			$listeSujets = $bSujet->Charger($id, $colNom, $colCommentaire, $colDateCreation, $colDateDernierMess, $colNbVues, $colVersion, $colModeWiki, $colForumId, $colCreateurId, $colDernierPosteurId, $colTypeSujetId);
		
			$sujet = $this->UniqueResultatVerifie($listeSujets, WAM_0040, 'MSujet::Charger, aucun résultat pour l\'id ['.$id.'].');
			if ($sujet != NULL)
			{
				$bSujet->GetNomsColonnes($colId, $colNom, $colCommentaire, $colDateCreation, $colDateDernierMess, $colNbVues, $colVersion, $colModeWiki, $colForumId, $colCreateurId, $colDernierPosteurId, $colTypeSujetId);
				$this->SetObjetFromSQL($sujet, false, $colNom, $colCommentaire, $colDateCreation, $colDateDernierMess, $colNbVues, $colVersion, $colModeWiki, $colForumId, $colCreateurId, $colDernierPosteurId, $colTypeSujetId);
			}
		}
		else
			GLog::LeverException(EXM_0045, 'MSujet::Charger, pas d\'id.');
	}
}

?>