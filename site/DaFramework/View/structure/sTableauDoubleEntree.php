<?php

require_once 'cst.php';
require_once INC_STABLEAU;

class STableauDoubleEntree extends STableau
{
	protected $lignes;
	protected $colonnes;
	protected $cases;
	protected $tableau;
	protected $nbLignes;
	protected $nbColonnes;

    public function __construct()
    {
       	parent::__construct();
		$this->lignes = array();
		$this->colonnes = array();
		$this->cases = array();
		$this->tableau = array();
		$this->nbLignes = 0;
		$this->nbColonnes = 0;
	}

	/*
	lignes[cle_ligne]=valeur;
	colonnes[cle_colonne]=valeur;
	cases[cle_ligne][cle_colonne]=valeur;
	*/

	public function SetEntreeLigne(array $lignes)
	{
		$this->lignes = $lignes;

		// Création de la colonne de titre (titres des lignes).
		$numLigne = 0;
		$numColonne = 0;
		while (list($cle, $titre) = each($lignes))
		{
			$numLigne++;
			if (!isset($this->tableau[$numLigne]) || !is_array($this->tableau[$numLigne]))
				$this->tableau[$numLigne] = array();
		    $this->tableau[$numLigne][$numColonne] = $titre;
		}

		$this->nbLignes = $numLigne;
	}

	public function SetEntreeColonne(array $colonnes)
	{
		$this->colonnes = $colonnes;

		// Création de la ligne de titre (titres des colonnes).
		$numLigne = 0;
		$numColonne = 0;
		$this->nbColonnes = 0;
		while (list($cle, $titre) = each($colonnes))
		{
			$numColonne++;
			if (!isset($this->tableau[$numLigne]) || !is_array($this->tableau[$numLigne]))
				$this->tableau[$numLigne] = array();
		    $this->tableau[$numLigne][$numColonne] = $titre;
		}

		$this->nbColonnes = $numColonne;
	}

	public function SetContenuCases(array $cases)
	{
		$this->cases = $cases;

		// Création des cases.
		$numLigne = 0;
		$numColonne = 0;
		$colonnes = $this->colonnes;
		while (list($cleColonne, $titreColonne) = each($colonnes))
		{
			$numColonne++;
			$lignes = $this->lignes;
			while (list($cleLigne, $titreLigne) = each($lignes))
			{
				$numLigne++;
				$cases = $this->cases;
				if ($cases[$cleLigne] != NULL && $cases[$cleLigne][$cleColonne] != NULL)
					$this->tableau[$numLigne][$numColonne] = $cases[$cleLigne][$cleColonne];
			}
		}
	}

	public function ConstruireTableau()
	{
		$numLigne = 0;
		$numColonne = 0;
		for ($numLigne = 0; $numLigne <= $this->nbLignes; $numLigne++)
		{
			$this->AddLigne();
			for ($numColonne = 0; $numColonne <= $this->nbColonnes; $numColonne++)
			{
				$cellule = $this->AddCellule();
				if (is_array($this->tableau[$numLigne]) && $this->tableau[$numLigne][$numColonne] != NULL)
					$cellule->SetText($this->tableau[$numLigne][$numColonne]);
			}
		}
	}

	public function BuildHTML()
	{
		$this->ConstruireTableau();
		return parent::BuildHTML();
	}
}

?>