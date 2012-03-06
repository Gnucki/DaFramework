<?php

require_once 'cst.php';
require_once INC_SELEMENT;
require_once INC_SORGANISEUR;


class SElemOrg extends SElement
{
    protected $org;

    public function __construct($nbLignes, $nbColonnes, $class = '', $tabMaxLargeur = false, $equiCellules = false, $remplirParent = true)
    {
       	parent::__construct($class, $remplirParent, '', '', $tabMaxLargeur);

		$this->org = new SOrganiseur($nbLignes, $nbColonnes, $tabMaxLargeur, $equiCellules);
		$this->Attach($this->org);
		if ($remplirParent === true)
			$this->org->AddClass('jq_fill');
	}

	public function InitCellule($ligne, $colonne)
	{
	   	$this->org->InitCellule($ligne, $colonne);
	}

	public function SetCelluleDominante($ligne, $colonne)
	{
	   	$this->org->SetCelluleDominante($ligne, $colonne);
	}

	public function AjouterPropCellule($ligne, $colonne, $propName, $propValeur)
	{
		$this->org->AjouterPropCellule($ligne, $colonne, $propName, $propValeur);
	}

	public function AjouterClasseCellule($ligne, $colonne, $class)
	{
		$this->org->AjouterClasseCellule($ligne, $colonne, $class);
	}

	public function AjouterPropLigne($ligne, $propName, $propValeur)
	{
		$this->org->AjouterPropLigne($ligne, $propName, $propValeur);
	}

	public function AjouterClasseLigne($ligne, $class)
	{
		$this->org->AjouterClasseLigne($ligne, $class);
	}

	public function AjouterClasseTableau($class)
	{
		$this->org->AddClass($class);
	}

	public function AttacherCellule($ligne, $colonne, $balise)
	{
		$this->org->AttacherCellule($ligne, $colonne, $balise);
	}

	public function SetTexteCellule($ligne, $colonne, $texte)
	{
		$this->org->SetTexteCellule($ligne, $colonne, $texte);
	}

	public function FusionnerCellule($ligne, $colonne, $nbLignes = 0, $nbColonnes = 0)
	{
	   	$this->org->FusionnerCellule($ligne, $colonne, $nbLignes, $nbColonnes);
	}

	public function SetAlignementHorizontalCellule($ligne, $colonne, $alignement)
	{
	   	$this->org->SetAlignementHorizontalCellule($ligne, $colonne, $alignement);
	}

	public function SetLargeurCellule($ligne, $colonne, $largeur)
	{
		$this->org->SetLargeurCellule($ligne, $colonne, $largeur);
	}
}

?>