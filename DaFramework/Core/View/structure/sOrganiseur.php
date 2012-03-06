<?php

require_once 'cst.php';
require_once INC_STABLEAU;


define('SORG_CELLPROP','cellprop');
define('SORG_CELLHAUTEUR','cellhauteur');
define('SORG_CELLLARGEUR','celllargeur');
define('SORG_CELLATTACH','cellattach');
define('SORG_CELLTEXTE','celltexte');


class SOrganiseur extends STableau
{
    protected $tableau;
    protected $lignesProp;
    protected $nbLignes;
    protected $nbColonnes;
    protected $isCellDom;
    protected $equiCellules;

    public function __construct($nbLignes, $nbColonnes, $tabMaxLargeur = false, $equiCellules = false)
    {
       	parent::__construct();
		$this->tableau = array();
		$this->lignesProp = array();
		$this->nbLignes = $nbLignes;
		$this->nbColonnes = $nbColonnes;
		$this->isCellDom = false;
		$this->equiCellules = $equiCellules;

		if ($tabMaxLargeur === true)
			$this->AddClass('table_maxlargeur');

		for ($i = 1; $i <= $nbLignes; $i++)
		{
			$this->tableau[$i] = array();
			$this->InitLigne($i);
			for ($j = 1; $j <= $nbColonnes; $j++)
			{
				$this->tableau[$i][$j] = array();
				$this->InitCellule($i, $j);
			}
		}
	}

	public function GetEnfants()
	{
	   	$enfants = array();

	   	for ($i = 1; $i <= $this->nbLignes; $i++)
		{
			for ($j = 1; $j <= $this->nbColonnes; $j++)
			{
			  	 if (array_key_exists($i, $this->tableau) && array_key_exists($j, $this->tableau[$i]))
			  	  	 $enfants = array_merge($enfants, $this->tableau[$i][$j][SORG_CELLATTACH]);
			}
		}

		return $enfants;
	}

	public function InitLigne($ligne)
	{
	   	$this->lignesProp[$ligne] = array();
	}

	public function InitCellule($ligne, $colonne)
	{
	   	$this->tableau[$ligne][$colonne][SORG_CELLPROP]	= array();
	   	$this->tableau[$ligne][$colonne][SORG_CELLHAUTEUR]	= 1;
	   	$this->tableau[$ligne][$colonne][SORG_CELLLARGEUR]	= 1;
	   	$this->tableau[$ligne][$colonne][SORG_CELLATTACH] = array();
	   	$this->tableau[$ligne][$colonne][SORG_CELLTEXTE] = NULL;
	}

	public function SetCelluleDominante($ligne, $colonne)
	{
	   	$this->AjouterClasseCellule($ligne, $colonne, 'cellule_maxlargeur');
	   	$this->isCellDom = true;
	}

	public function AjouterPropCellule($ligne, $colonne, $propName, $propValeur)
	{
		if (array_key_exists($colonne, $this->tableau[$ligne]))
		{
		   	switch ($propName)
			{
		   		case PROP_CLASS:
		   			$this->AjouterClasseCellule($ligne, $colonne, $propValeur);
		   			break;
		   		case PROP_COLSPAN:
		   			$this->FusionnerCellule($ligne, $colonne, 0, $propValeur);
		   			break;
		   		case PROP_ROWSPAN:
		   			$this->FusionnerCellule($ligne, $colonne, $propValeur, 0);
		   			break;
		   		default:
		   			$this->tableau[$ligne][$colonne][SORG_CELLPROP][$propName] = $propValeur;
		   	}
		}
	}

	public function AjouterClasseCellule($ligne, $colonne, $class)
	{
		if (array_key_exists($colonne, $this->tableau[$ligne]))
		{
		   	$cellule = $this->tableau[$ligne][$colonne];
		   	if (array_key_exists(PROP_CLASS, $cellule[SORG_CELLPROP]) && $cellule[SORG_CELLPROP][PROP_CLASS] !== '')
		   		$this->tableau[$ligne][$colonne][SORG_CELLPROP][PROP_CLASS] .= ' '.$class;
		   	else
		   	   	$this->tableau[$ligne][$colonne][SORG_CELLPROP][PROP_CLASS] = $class;
		}
	}

	public function AjouterPropLigne($ligne, $propName, $propValeur)
	{
		switch ($propName)
		{
		   	default:
		   		$this->lignesProp[$ligne][$propName] = $propValeur;
		}
	}

	public function AjouterClasseLigne($ligne, $class)
	{
	   	$this->AjouterPropLigne($ligne, PROP_CLASS, $class);
	}

	public function AttacherCellule($ligne, $colonne, $balise)
	{
		if (array_key_exists($colonne, $this->tableau[$ligne]))
		   	$this->tableau[$ligne][$colonne][SORG_CELLATTACH][] = $balise;
	}

	public function SetTexteCellule($ligne, $colonne, $texte)
	{
		if (array_key_exists($colonne, $this->tableau[$ligne]))
		   	$this->tableau[$ligne][$colonne][SORG_CELLTEXTE] = $texte;
	}

	public function SetLargeurCellule($ligne, $colonne, $largeur)
	{
		if (array_key_exists($colonne, $this->tableau[$ligne]))
		   	$this->AjouterPropCellule($ligne, $colonne, PROP_WIDTH, $largeur);
	}

	public function SetAlignementHorizontalCellule($ligne, $colonne, $alignement)
	{
		if (array_key_exists($colonne, $this->tableau[$ligne]))
		   	$this->AjouterPropCellule($ligne, $colonne, PROP_ALIGN, $alignement);
	}

	public function FusionnerCellule($ligne, $colonne, $nbLignes = 0, $nbColonnes = 0)
	{
	   	if (array_key_exists($colonne, $this->tableau[$ligne]))
		{
		   	$largeur = $this->tableau[$ligne][$colonne][SORG_CELLLARGEUR] + $nbColonnes - 1;
		   	$hauteur = $this->tableau[$ligne][$colonne][SORG_CELLHAUTEUR] + $nbLignes - 1;

		   	if ($nbLignes > 0)
			{
		   		for ($i = 1; $i <= $this->nbLignes; $i++)
				{
				  	if (array_key_exists($colonne, $this->tableau[$i]))
				  	{
					  	if ($i > $ligne && $i <= ($ligne + $nbLignes))
					  	{
					  	   	unset($this->tableau[$i][$colonne]);
					  		for ($j = $colonne + 1; $j <= ($colonne + $largeur); $j++)
							{
					  			if (array_key_exists($j, $this->tableau[$i]))
						  			   	unset($this->tableau[$i][$j]);
					  		}
					  	}
					}
				}
				$this->tableau[$ligne][$colonne][SORG_CELLHAUTEUR]	= $nbLignes + 1;
		   	}

		   	if ($nbColonnes > 0)
			{
		   		for ($j = 1; $j <= $this->nbColonnes; $j++)
				{
				  	if (array_key_exists($j, $this->tableau[$ligne]))
				  	{
					  	if ($j > $colonne && $j <= ($colonne + $nbColonnes))
					  	{
					  		unset($this->tableau[$ligne][$j]);
					  		if ($nbLignes === 0)
							{
						  		for ($i = $ligne + 1; $i <= ($ligne + $hauteur); $i++)
								{
								  	if (array_key_exists($j, $this->tableau[$i]))
						  			   	unset($this->tableau[$i][$j]);
						  		}
						  	}
						}
					}
				}
				$this->tableau[$ligne][$colonne][SORG_CELLLARGEUR]	= $nbColonnes + 1;
		   	}
		}
	}

	protected function GetPlusGrandeLigne()
	{
	   	$nbCellulesMax = -1;
	   	$plusGrandeLigne = array();

	   	$plusGrandeLigne['NUMERO'] = 0;
	   	$plusGrandeLigne['NBCELL'] = 0;

		for ($i = 1; $i <= $this->nbLignes; $i++)
		{
		  	$nbCellules = 0;

		  	if (array_key_exists($i, $this->tableau))
		  	{
			  	for ($j = 1; $j <= $this->nbColonnes; $j++)
				{
			  		if (array_key_exists($j, $this->tableau[$i]))
				  	   	$nbCellules++;
			  	}
			}

			if ($nbCellules > $nbCellulesMax)
			{
			  	$nbCellulesMax = $nbCellules;
			   	$plusGrandeLigne['NUMERO'] = $i;
			   	$plusGrandeLigne['NBCELL'] = $nbCellulesMax;
			}
		}

		return $plusGrandeLigne;
	}

	public function BuildHTML()
	{
	   	if ($this->isCellDom === false && $this->equiCellules === true)
		{
	   		$ligne = $this->GetPlusGrandeLigne();
	   		$numCellule = 0;
	   		for ($j = 1; $j <= $this->nbColonnes; $j++)
			{
		  		if (array_key_exists($j, $this->tableau[$ligne['NUMERO']]))
		  		{
		  		   	$numCellule++;
		  		   	if ($numCellule === $ligne['NBCELL'])
			  	   	   	$this->AjouterPropCellule($ligne['NUMERO'], $j, PROP_STYLE, 'width:'.(100-(($ligne['NBCELL']-1)*intval(100/$ligne['NBCELL']))).'%');
			  	   	else
			  	   	   	$this->AjouterPropCellule($ligne['NUMERO'], $j, PROP_STYLE, 'width:'.intval(100/$ligne['NBCELL']).'%');
			  	}
		  	}
	   	}

	   	for ($i = 1; $i <= $this->nbLignes; $i++)
		{
			$hasCellule = false;
			for ($j = 1; $j <= $this->nbColonnes; $j++)
			{
			  	if (array_key_exists($j, $this->tableau[$i]))
				{
				  	if ($hasCellule === false)
					{
				  	   	$ligne = $this->AddLigne();
				  	   	$hasCellule = true;
				  	   	while(list($propName, $propVal) = each($this->lignesProp[$i]))
						{
						    $ligne->AddProp($propName, $propVal);
						}
				  	}

				  	$cellule = $this->AddCellule();
				  	while(list($propName, $propVal) = each($this->tableau[$i][$j][SORG_CELLPROP]))
					{
					    $cellule->AddProp($propName, $propVal);
					}

					$cellLargeur = $this->tableau[$i][$j][SORG_CELLLARGEUR];
					if ($cellLargeur > 1)
					   	$cellule->AddProp(PROP_COLSPAN, $cellLargeur);
					$cellHauteur = $this->tableau[$i][$j][SORG_CELLHAUTEUR];
					if ($cellHauteur > 1)
					   	$cellule->AddProp(PROP_ROWSPAN, $cellHauteur);

					for ($k = 0; array_key_exists($k, $this->tableau[$i][$j][SORG_CELLATTACH]); $k++)
					{
					   	$balise = $this->tableau[$i][$j][SORG_CELLATTACH][$k];
						if ($balise != NULL)
					   	   	$cellule->Attach($balise);
					}
					$texte = $this->tableau[$i][$j][SORG_CELLTEXTE];
					if ($texte != NULL)
					   	$cellule->SetText($texte);
				}
			}
		}

		return parent::BuildHTML();
	}
}

/*echo '<style>
   	  table
	  {
	  	border: 1px solid black;
	  }

	  td
	  {
	  	border: 1px solid blue;
	  	width: 100px;
	  	height: 40px;
	  }
	  </style>';
echo "\n";

$test = new SOrganiseur(3,4);
$test->AjouterClasseCellule(1, 2, 'tests');
$test->AjouterClasseCellule(1, 2, 'testes');
$test->FusionnerCellule(1, 1, 2, 0);
$test->FusionnerCellule(1, 2, 0, 1);
$test->FusionnerCellule(2, 3, 1, 1);

echo $test->BuildHTML();*/


?>