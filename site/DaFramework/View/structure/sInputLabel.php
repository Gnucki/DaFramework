<?php

require_once 'cst.php';
require_once INC_SELEMENT;
require_once INC_SORGANISEUR;


define ('INPUTLABELPLACE_HAUT',0);
define ('INPUTLABELPLACE_GAUCHE',1);

define ('JQINPUTLABEL', 'jq_label');

define ('INPUT', '_input');
define ('INPUT_LABEL', '_input_label');
define ('SOUSINPUT', '_sousinput');
define ('SOUSINPUT_LABEL', '_sousinput_label');


// Factory permettant de créer des inputs avec des labels positionnés ou non.
class SInputLabel extends SElement
{
   	protected $prefixIdClass;
   	protected $organiseur;
   	protected $sousLabels;
   	protected $niveau;
   	protected $tabMaxLargeur;
   	protected $equiCellules;

	public function __construct($prefixIdClass, $label, $input = NULL, $placeLabel = INPUTLABELPLACE_GAUCHE, $oblig = false, $sousLabel = false, $niveau = '', $tabMaxLargeur = false, $remplirParent = true, $equiCellules = false)
	{
		$classeInput = INPUT;
		$classeLabel = INPUT_LABEL;
		if ($sousLabel === true)
		{
			$classeInput = SOUSINPUT;
			$classeLabel = SOUSINPUT_LABEL;
		}

		$this->prefixIdClass = $prefixIdClass;
		$this->niveau = $niveau;
		$this->tabMaxLargeur = $tabMaxLargeur;
		$this->equiCellules = $equiCellules;


		if ($oblig === true)
		{
		   	parent::__construct($prefixIdClass.$classeInput.'_oblig'.$this->niveau, $remplirParent);
			$this->AjouterClasse($classeInput.'_oblig'.$this->niveau);
		}
		else
		{
		   	parent::__construct($prefixIdClass.$classeInput.$this->niveau, $remplirParent);
		   	$this->AjouterClasse($classeInput.$this->niveau);
		}

		$this->organiseur = NULL;
		$org = NULL;

		if ($placeLabel == INPUTLABELPLACE_HAUT)
		{
		   	$org = new SOrganiseur(2, 1, $tabMaxLargeur);
			$org->AddClass('jq_fill');

			$elem = NULL;
			if ($oblig === true)
			{
			   	$elem = new SElement($prefixIdClass.$classeLabel.'_oblig'.$this->niveau, false);
				$elem->AjouterClasse($classeLabel.'_oblig'.$this->niveau);
			}
			else
			{
			   	$elem = new SElement($prefixIdClass.$classeLabel.$this->niveau, false);
			   	$elem->AjouterClasse($classeLabel.$this->niveau);
			}
			$elem->GetCellule()->AddClass(JQINPUTLABEL);
		   	$elem->SetText($label);
		   	$org->AttacherCellule(1, 1, $elem);

		   	$org->SetCelluleDominante(2, 1);
		   	if ($input != NULL)
		   	   	$org->AttacherCellule(2, 1, $input);
		}
		else if ($placeLabel == INPUTLABELPLACE_GAUCHE)
		{
			$org = new SOrganiseur(1, 2, $tabMaxLargeur);
			$org->AddClass('jq_fill');

		   	$elem = NULL;
			if ($oblig === true)
			{
			   	$elem = new SElement($prefixIdClass.$classeLabel.'_oblig'.$this->niveau);
				$elem->AjouterClasse($classeLabel.'_oblig'.$this->niveau);
			}
			else
			{
			   	$elem = new SElement($prefixIdClass.$classeLabel.$this->niveau);
			   	$elem->AjouterClasse($classeLabel.$this->niveau);
			}
			$elem->GetCellule()->AddClass(JQINPUTLABEL);
		   	$elem->SetText($label);
		   	$org->AttacherCellule(1, 1, $elem);

		   	$org->SetCelluleDominante(1, 2);
		   	if ($input != NULL)
		   	   	$org->AttacherCellule(1, 2, $input);
		}

		if ($org != NULL)
		{
		   	$this->organiseur = $org;
			$this->Attach($this->organiseur);
		}

		$this->sousLabels = array();
	}

	public function AttacherInput($input)
	{
		if ($this->organiseur != NULL)
		{
		   	if ($placeLabel == INPUTLABELPLACE_HAUT)
			   	$this->organiseur->AttacherCellule(2, 1, $input);
			else if ($placeLabel == INPUTLABELPLACE_GAUCHE)
			   	$this->organiseur->AttacherCellule(1, 2, $input);
		}
	}

	// Inputs.
	public function AjouterInputSelect($label = '', $typeInput = '', $oblig = false, $retour = '', $info = '', $erreur = '', $type = '', $impact = '', $dependance = '', $rechargeFonc = '', $rechargeParam = '', $changeFonc = '', $changeParam = '')
	{
		$select = new SInputSelect($this->prefixIdClass, $typeInput, $oblig, $retour, $info, $erreur, $type, $impact, $dependance, $rechargeFonc, $rechargeParam, $changeFonc, $changeParam, $this->niveau);
		$this->AjouterInput($label, $select, $oblig);
		return $select;
	}

	public function AjouterInputText($label = '', $typeInput = '', $oblig = false, $retour = '', $valeurParDefaut = '', $longueurMin = -1, $longueurMax = -1, $taille = -1, $tailleAuto = false, $unite = '', $info = '', $erreur = '', $formatValide = '', $min = NULL, $max = NULL)
	{
		$text = new SInputText($this->prefixIdClass, $typeInput, $oblig, $retour, $valeurParDefaut, $longueurMin, $longueurMax, $taille, $tailleAuto, $unite, $info, $erreur, $formatValide, $min, $max, $this->niveau);
		$this->AjouterInput($label, $text, $oblig);
		return $text;
	}

	public function AjouterInputColor($label = '', $typeInput = '', $retour = '', $valeur = '')
	{
		$color = new SInputColor($this->prefixIdClass, $typeInput, $retour, $valeur);
		$this->AjouterInput($label, $color, false);
		return $color;
	}

	public function AjouterInputCheckbox()
	{
		/*if ($this->currentCadreInputs != NULL)
		{
			$this->currentCadreInputs->AjouterCellule();
		}*/
	}

	public function AjouterInputNewSelect($label = '', $oblig = false, $retour = '', $info = '', $erreur = '', $type = '', $impact = '', $dependance = '', $rechargeFonc = '', $rechargeParam = '', $changeFonc = '', $changeParam = '')
	{
		$new = new SInputNewSelect($this->prefixIdClass, $oblig, $retour, $info, $erreur, $type, $impact, $dependance, $rechargeFonc, $rechargeParam, $changeFonc, $changeParam, $this->niveau);
		$this->AjouterInput($label, $new, $oblig);
		return $new;
	}

	public function AjouterInputNewText($label = '', $oblig = false, $retour = '', $valeurParDefaut = '', $longueurMax = -1, $taille = -1, $tailleAuto = false, $unite = '', $info = '', $erreur = '', $formatValide = '', $min = NULL, $max = NULL)
	{
		$new = new SInputNewText($this->prefixIdClass, $oblig, $retour, $valeurParDefaut, $longueurMax, $taille, $tailleAuto, $unite, $info, $erreur, $formatValide, $min, $max, $this->niveau);
		$this->AjouterInput($label, $new, $oblig);
		return $new;
	}

	public function AjouterInputFile($label = '', $typeInput = '', $oblig = false, $retour = '', $id = '', $info = '', $erreur = '', $type = '', $contexte = '')
	{
		$file = new SInputFile($this->prefixIdClass, $typeInput, $oblig, $retour, $id, $info, $erreur, $type, $contexte, $this->niveau);
		$this->AjouterInput($label, $file, $oblig);
		return $file;
	}

	protected function AjouterInput($label, $input, $oblig)
	{
		$elem = NULL;

		if ($label !== '')
			$elem = new SInputLabel($this->prefixIdClass, $label, $input, INPUTLABELPLACE_GAUCHE, $oblig, true, $this->niveau, $this->tabMaxLargeur);
		else
			$elem = $input;

		$this->sousLabels[] = $elem;
	}

	protected function ConstruireSousLabels()
	{
	   	$nbSousLabels = count($this->sousLabels);
	   	if ($nbSousLabels >= 1)
		{
		   	$org = new SOrganiseur(1, $nbSousLabels, $this->tabMaxLargeur, $this->equiCellules);
		   	for ($i = 0; $i <= ($nbSousLabels - 1); $i++)
			{
			   	$org->AttacherCellule(1, $i + 1, $this->sousLabels[$i]);
			}
			$this->organiseur->AttacherCellule(1, 2, $org);
		}
	}

	public function BuildHTML()
	{
	   	$this->ConstruireSousLabels();

	   	return parent::BuildHTML();
	}
}

?>