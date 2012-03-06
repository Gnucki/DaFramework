<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MObjetGrade extends MObjetMetier
{
   	protected $mListeGradesJoueurs;

	public function __construct($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL)
	{
		$this->SetObjet($id, $nom, $description, $icone, $niveau, $superGradeId);
	}

	public function SetObjet($id = NULL, $nom = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $superGradeId = NULL)
	{
		parent::SetObjet($id);

		$this->Nom($nom);
		$this->Description($description);
		$this->Icone($icone);
		$this->Niveau($niveau);
		$this->SuperGrade($superGradeId);
		$this->mListeGradesJoueurs = NULL;
	}

	public function GetNom()
	{
	   	return 'MObjetGrade';
	}

	protected function GetNouvelleListeGradesJoueurs()
	{
	   	return NULL;
	}

	/*************************************/
	public function Nom($nom = NULL)
	{
		$this->ValeurStrVerifiee(COL_NOM, $nom, 1, 150, NULL, NULL, true);
	}

	public function Description($description = NULL)
	{
		$this->ValeurStrVerifiee(COL_DESCRIPTION, $description, 0, 150, NULL, '', true);
	}

	public function Icone($icone = NULL)
	{
		$this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}

	public function Niveau($niveau = NULL)
	{
	   	return $this->ValeurIntVerifiee(COL_NIVEAU, $niveau, 0, NULL, 0, true);
	}

	public function SuperGrade($id = -1, $libelle = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $poidsVoteRecrutement = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_SUPERGRADE, 'MSuperGrade', NULL, true, $id, $libelle, $description, $icone, $niveau, $poidsVoteRecrutement);
	}

	public function ListeGradesJoueurs($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeGradesJoueurs !== NULL)
	   	   	$oldId = $this->mListeGradesJoueurs->GetFiltreValeur(0, COL_JOUEUR);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeGradesJoueurs !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeGradesJoueurs);
	   	}
	   	else if ($this->mListeGradesJoueurs === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeGradesJoueurs === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeGradesJoueurs = $this->GetNouvelleListeGradesJoueurs();
		   	   	if ($this->mListeGradesJoueurs !== NULL)
				{
			   	   	$numJointure = $this->mListeGradesJoueurs->AjouterJointure(COL_JOUEUR, COL_ID);
			   	   	$this->mListeGradesJoueurs->AjouterColSelectionPourJointure($numJointure, COL_ID);
			   	   	$this->mListeGradesJoueurs->AjouterColSelectionPourJointure($numJointure, COL_PSEUDO);
			   	   	$this->mListeGradesJoueurs->AjouterColOrdrePourJointure($numJointure, COL_PSEUDO);
			   	}
		   	}
		   	if ($this->mListeGradesJoueurs !== NULL)
			   	$this->mListeGradesJoueurs->AjouterFiltreEgal(COL_GRADE, $this->Id());
	   	}

	   	if ($this->mListeGradesJoueurs !== NULL && $liste !== NULL)
	   		$this->mListeGradesJoueurs->SetListeFromTableau($liste, array(array(COL_ID, COL_JOUEUR)));

	   	return $this->mListeGradesJoueurs;
	}

	/*************************************/
	public function Ajouter()
	{
		// On ajoute le grade.
		$retour = parent::Ajouter();

		// On ajoute au grade les joueurs qui y appartiennent.
	   	$listeGradesJoueurs = $this->ListeGradesJoueurs();
	   	if ($retour !== false && $listeGradesJoueurs !== NULL)
	   	{
	   	   	$listeGradesJoueurs->SetListeChampValeur(COL_GRADE, $this->Id());
		   	$retour = $listeGradesJoueurs->Ajouter();
		}

		return $retour;
	}

	public function Modifier()
	{
	   	// On modifie le grade.
	   	$retour = parent::Modifier();
	   	$retourJoueur = true;

	   	// On modifie la liste de joueurs appartenant au grade.
	   	$listeGradesJoueurs = $this->ListeGradesJoueurs();
	   	if ($listeGradesJoueurs !== NULL)
		{
		   	// Suppression de l'ancienne liste.
		   	$retourJoueur = $listeGradesJoueurs->Supprimer();
		   	// Ajout de la nouvelle si tout s'est bien passé.
		   	if ($retourJoueur !== false)
		   	{
		   	   	$listeGradesJoueurs->SetListeChampValeur(COL_GRADE, $this->Id());
		   		$retourJoueur = $listeGradesJoueurs->Ajouter();
		   	}
		}

		return ($retour && $retourJoueur);
	}

	public function Supprimer()
	{
	   	$retour = true;

	   	$listeGradesJoueurs = $this->ListeGradesJoueurs();
	   	if ($listeGradesJoueurs !== NULL)
		   	$retour = $listeGradesJoueurs->Supprimer();

		if ($retour !== false)
		   	$retour = parent::Supprimer();

		return $retour;
	}
}

?>