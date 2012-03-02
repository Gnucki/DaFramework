<?php

require_once 'cst.php';
require_once INC_SELEMORG;
require_once INC_SORGANISEUR;
require_once INC_SINPUTLABEL;
require_once INC_SINPUTSELECT;
require_once INC_SINPUTTEXT;
require_once INC_SINPUTCHECKBOX;
require_once INC_SINPUTBUTTON;
require_once INC_SINPUTNEWSELECT;
require_once INC_SINPUTNEWTEXT;
require_once INC_SINPUTFILE;
require_once INC_SINPUTIMAGE;
require_once INC_SINPUTLISTE;
require_once INC_SINPUTLISTEDOUBLE;


define ('FORM', '_form');
define ('FORM_INPUTS', '_form_inputs');
define ('FORM_BOUTONS', '_form_boutons');
define ('FORM_ERREURS', '_form_erreurs');

define ('FORM_JQ_ERREUR', 'jq_form_erreur');

define ('INPUTINFO', '_inputinfo');


// Formulaire.
class SForm extends SElemOrg
{
   	protected $prefixIdClass;
	protected $id;
	protected $currentCadre;
	protected $currentCadreInputs;
	protected $currentCadreBoutons;
	protected $nbLignes;
	protected $nbColonnes;
	protected $aCadreErreur;
	//protected $cadre;

	public function __construct($prefixIdClass, $nbLignes = 2, $nbColonnes = 1, $tabMaxLargeur = true, $equiCellules = true)
	{
		$this->prefixIdClass = $prefixIdClass;

		parent::__construct($nbLignes + 1, $nbColonnes, $this->prefixIdClass.FORM, $tabMaxLargeur, $equiCellules);
		$this->AjouterClasse(FORM);

		$this->currentCadre = NULL;
		$this->currentCadreInputs = NULL;
		$this->currentCadreBoutons = NULL;

		$this->id = FORM.mt_rand();
		$this->AddProp(PROP_ID, $this->id);

		$this->nbLignes = $nbLignes;
		$this->nbColonnes = $nbColonnes;
		$this->aCadreErreur = false;
	}

	public function SetCadreInputs($ligne, $colonne, $nbLignes = 1, $nbColonnes = 1, $tabMaxLargeur = true, $equiCellules = true)
	{
		$this->currentCadreInputs = $this->SetCadre($ligne, $colonne, $nbLignes, $nbColonnes, FORM_INPUTS, $tabMaxLargeur, $equiCellules);
		$this->currentCadre = $this->currentCadreInputs;
	}

	public function SetCadreBoutons($ligne, $colonne, $nbLignes = 1, $nbColonnes = 1, $tabMaxLargeur = true, $equiCellules = true)
	{
		$this->currentCadreBoutons = $this->SetCadre($ligne, $colonne, $nbLignes, $nbColonnes, FORM_BOUTONS, $tabMaxLargeur, $equiCellules);
		$this->currentCadre = $this->currentCadreBoutons;
		return $this->currentCadre;
	}

	public function SetCadreBoutonsCache($ligne, $colonne, $tabMaxLargeur = true, $equiCellules = true)
	{
		$this->currentCadreBoutons = $this->SetCadreBoutons($ligne, $colonne, 1, 1, FORM_BOUTONS, $tabMaxLargeur, $equiCellules);
		$this->currentCadre = $this->currentCadreBoutons;

		$this->currentCadre->AddProp(PROP_STYLE, 'display: none;');
		$this->AjouterInputButtonValiderAjaxContexte(1, 1, '', '', false, '');

		return $this->currentCadre;
	}

	protected function SetCadre($ligne, $colonne, $nbLignes, $nbColonnes, $class, $tabMaxLargeur, $equiCellules)
	{
		$elem = NULL;

		$elem = new SElemOrg($nbLignes, $nbColonnes, $this->prefixIdClass.$class, $tabMaxLargeur, $equiCellules);
		$elem->AjouterClasse($class);

		$this->AttacherCellule($ligne, $colonne, $elem);

		return $elem;
	}

	public function FusionnerCelluleCadre($ligne, $colonne, $nbLignes = 0, $nbColonnes = 0)
	{
		if ($this->currentCadre != NULL)
			$this->currentCadre->FusionnerCellule($ligne, $colonne, $nbLignes, $nbColonnes);
	}

	public function SetLargeurCelluleCadre($ligne, $colonne, $largeur)
	{
		if ($this->currentCadre != NULL)
			$this->currentCadre->SetLargeurCellule($ligne, $colonne, $largeur);
	}

	public function AjouterPropCelluleCadre($ligne, $colonne, $propName, $propValeur)
	{
		if ($this->currentCadre != NULL)
			$this->currentCadre->AjouterPropCellule($ligne, $colonne, $propName, $propValeur);
	}

	// Boutons.
	public function AjouterInputButton($ligne, $colonne, $typeInput, $libelle, $libelleOnClick = '', $cadre = '', $fonction = '', $ajax = false, $reset = false)
	{
		$button = NULL;
		if ($this->currentCadreBoutons != NULL)
		{
			if ($cadre === true)
				$cadre = $this->id;
			else
				$cadre = '';

			$button = new SInputButton($this->prefixIdClass, $typeInput, $libelle, $libelleOnClick, $cadre, $fonction, $ajax, $reset);
			$this->currentCadreBoutons->AttacherCellule($ligne, $colonne, $button);

			if ($ajax === true && $this->aCadreErreur !== true)
			{
				// Cadre qui récupère les erreurs (après retour ajax) du formulaire lors de sa validation.
				$elem = new SElement($this->prefixIdClass.FORM_ERREURS);
				$elem->AjouterClasse(FORM_ERREURS);
				$elem->AddClass(FORM_JQ_ERREUR.$this->id);
				$this->FusionnerCellule($this->nbLignes + 1, 1, 0, $this->nbColonnes - 1);
				$this->AttacherCellule($this->nbLignes + 1, 1, $elem);
				$this->aCadreErreur = true;
			}
		}
		return $button;
	}

	public function AjouterInputButtonAjouterAuContexte($ligne, $colonne, $contexte, $reset = true, $libelle = '')
	{
	   	return $this->AjouterInputButtonValiderAjaxContexte($ligne, $colonne, $contexte, AJAXFONC_AJOUTERAUCONTEXTE, $reset, $libelle);
	}

	public function AjouterInputButtonModifierDansContexte($ligne, $colonne, $contexte, $reset = true, $libelle = '')
	{
	   	return $this->AjouterInputButtonValiderAjaxContexte($ligne, $colonne, $contexte, AJAXFONC_MODIFIERDANSCONTEXTE, $reset, $libelle);
	}

	public function AjouterInputButtonSupprimerDuContexte($ligne, $colonne, $contexte, $reset = true, $libelle = '')
	{
	   	return $this->AjouterInputButtonValiderAjaxContexte($ligne, $colonne, $contexte, AJAXFONC_SUPPRIMERDUCONTEXTE, $reset, $libelle);
	}

	public function AjouterInputButtonChargerContextes($ligne, $colonne, $contexte, $reset = true, $libelle = '')
	{
	   	return $this->AjouterInputButtonValiderAjaxContexte($ligne, $colonne, $contexte, AJAXFONC_CHARGERCONTEXTES, $reset, $libelle);
	}

	public function AjouterInputButtonValiderAjaxContexte($ligne, $colonne, $contexte, $fonction, $reset = true, $libelle = '')
	{
		$bouton = $this->AjouterInputButtonValiderAjax($ligne, $colonne, $fonction, $reset, $libelle);
		$bouton->AjouterParamRetour('contexte', $contexte);
		return $bouton;
	}

	public function AjouterInputButtonValiderAjax($ligne, $colonne, $fonction = '', $reset = true, $libelle = '')
	{
	   	if ($libelle === '')
	   		$libelle = GSession::Libelle(LIB_FOR_VALIDER);
		$bouton = $this->AjouterInputButton($ligne, $colonne, '', $libelle, GSession::Libelle(LIB_FOR_VALIDER), true, $fonction, true, $reset);
		$bouton->AjouterParamRetour('cf', GSession::NumCheckFormulaire());
		return $bouton;
	}

	public function AjouterInputButtonAnnuler($ligne, $colonne, $libelle = '')
	{
	   	if ($libelle === '')
	   		$libelle = GSession::Libelle(LIB_FOR_ANNULER);
		$bouton = $this->AjouterInputButton($ligne, $colonne, '', $libelle, '', '', '$(this).trigger', false, true);
		$bouton->AjouterParamRetour('inputNewFormFermer');
		return $bouton;
	}

	// Inputs.
	public function AjouterInputSelect($ligne, $colonne, $label = '', $typeInput = '', $oblig = false, $retour = '', $info = '', $erreur = '', $type = '', $impact = '', $dependance = '', $rechargeFonc = '', $rechargeParam = '', $changeFonc = '', $changeParam = '')
	{
		$select = NULL;
		if ($this->currentCadreInputs != NULL)
		{
			$select = new SInputSelect($this->prefixIdClass, $typeInput, $oblig, $retour, $info, $erreur, $type, $impact, $dependance, $rechargeFonc, $rechargeParam, $changeFonc, $changeParam);
			$this->AjouterInput($ligne, $colonne, $label, $select, $oblig, INPUTLABELPLACE_GAUCHE, true);
		}
		return $select;
	}

	public function AjouterInputText($ligne, $colonne, $label = '', $typeInput = '', $oblig = false, $retour = '', $valeurParDefaut = '', $longueurMin = -1, $longueurMax = -1, $taille = -1, $tailleAuto = false, $unite = '', $info = '', $erreur = '', $formatValide = '', $min = NULL, $max = NULL)
	{
		$text = NULL;
		if ($this->currentCadreInputs != NULL)
		{
		   	$tabMaxLargeur = false;
		   	if ($tailleAuto === true)
		   		$tabMaxLargeur = true;
			$text = new SInputText($this->prefixIdClass, $typeInput, $oblig, $retour, $valeurParDefaut, $longueurMin, $longueurMax, $taille, $tailleAuto, $unite, $info, $erreur, $formatValide, $min, $max);
			$this->AjouterInput($ligne, $colonne, $label, $text, $oblig, INPUTLABELPLACE_GAUCHE, $tabMaxLargeur);
		}
		return $text;
	}

	public function AjouterInputCheckbox($ligne, $colonne, $label = '', $typeInput = '', $oblig = false, $retour = '', $info = '', $erreur = '')
	{
		$check = NULL;
		if ($this->currentCadreInputs != NULL)
		{
			$check = new SInputCheckbox($this->prefixIdClass, $typeInput, $oblig, $retour, $info, $erreur);
			$this->AjouterInput($ligne, $colonne, $label, $check, $oblig);
		}
		return $check;
	}

	public function AjouterInputNewSelect($ligne, $colonne, $label = '', $oblig = false, $retour = '', $info = '', $erreur = '', $type = '', $impact = '', $dependance = '', $rechargeFonc = '', $rechargeParam = '', $changeFonc = '', $changeParam = '')
	{
		$new = NULL;
		if ($this->currentCadreInputs != NULL)
		{
			$new = new SInputNewSelect($this->prefixIdClass, $oblig, $retour, $info, $erreur, $type, $impact, $dependance, $rechargeFonc, $rechargeParam, $changeFonc, $changeParam);
			$this->AjouterInput($ligne, $colonne, $label, $new, $oblig);
		}
		return $new;
	}

	public function AjouterInputNewText($ligne, $colonne, $label = '', $oblig = false, $retour = '', $valeurParDefaut = '', $longueurMax = -1, $taille = -1, $tailleAuto = false, $unite = '', $info = '', $erreur = '', $formatValide = '', $min = NULL, $max = NULL)
	{
		$new = NULL;
		if ($this->currentCadreInputs != NULL)
		{
			$new = new SInputNewText($this->prefixIdClass, $oblig, $retour, $valeurParDefaut, $longueurMax, $taille, $tailleAuto, $unite, $info, $erreur, $formatValide, $min, $max);
			$this->AjouterInput($ligne, $colonne, $label, $new, $oblig);
		}
		return $new;
	}

	public function AjouterInputFile($ligne, $colonne, $label = '', $typeInput = '', $oblig = false, $retour = '', $chemin = '', $extensions = '', $id = '', $info = '', $erreur = '', $type = '', $contexte = '')
	{
		$file = NULL;
		if ($this->currentCadreInputs != NULL)
		{
			$file = new SInputFile($this->prefixIdClass, $typeInput, $oblig, $retour, $chemin, $extensions, $id, $info, $erreur, $type, $contexte);
			$this->AjouterInput($ligne, $colonne, $label, $file, $oblig);
		}
		return $file;
	}

	public function AjouterInputImage($ligne, $colonne, $label = '', $typeInput = '', $oblig = false, $retour = '', $chemin = '', $id = '', $info = '', $erreur = '', $type = '', $contexte = '')
	{
		$img = NULL;
		if ($this->currentCadreInputs != NULL)
		{
			$img = new SInputImage($this->prefixIdClass, $typeInput, $oblig, $retour, $chemin, $id, $info, $erreur, $type, $contexte);
			$this->AjouterInput($ligne, $colonne, $label, $img, $oblig);
		}
		return $img;
	}

	public function AjouterInputListe($ligne, $colonne, $label = '', $type = '', $oblig = false, $retour = '', $info = '', $erreur = '')
	{
		$liste = NULL;
		if ($this->currentCadreInputs != NULL)
		{
			$liste = new SInputListe($this->prefixIdClass, $type, $oblig, $retour, $info, $erreur);
			$this->AjouterInput($ligne, $colonne, $label, $liste, $oblig, INPUTLABELPLACE_HAUT);
		}
		return $liste;
	}

	public function AjouterInputInfo($ligne, $colonne, $label, $info, $oblig = false)
	{
	   	$elem = new SElement($this->prefixIdClass.INPUTINFO);
		$elem->AjouterClasse(INPUTINFO);
	   	$elem->SetText($info);
		$this->AjouterInput($ligne, $colonne, $label, $elem, $oblig);
	}

	public function AjouterInputLabel($ligne, $colonne, $label, $oblig = false, $placeLabel = INPUTLABELPLACE_GAUCHE, $input = NULL)
	{
	   	$tabMaxLargeur = false;
	   	$remplirParent = true;
		if ($placeLabel === INPUTLABELPLACE_HAUT)
	   	{
	   		$tabMaxLargeur = true;
	   		$remplirParent = false;
	   	}
		$label = new SInputLabel($this->prefixIdClass, $label, $input, $placeLabel, $oblig, false, $tabMaxLargeur, $remplirParent);
		$this->currentCadreInputs->AttacherCellule($ligne, $colonne, $label);
		return $label;
	}

	public function AjouterInput($ligne, $colonne, $label, $input, $oblig, $placeLabel = INPUTLABELPLACE_GAUCHE, $tabMaxLargeur = false)
	{
		$elem = NULL;

	   	$remplirParent = true;
		if ($placeLabel === INPUTLABELPLACE_HAUT)
	   	{
	   		$tabMaxLargeur = true;
	   		$remplirParent = false;
	   	}
		if ($label !== '')
			$elem = new SInputLabel($this->prefixIdClass, $label, $input, $placeLabel, $oblig, false, '', $tabMaxLargeur, $remplirParent);
		else
			$elem = $input;

		$this->currentCadreInputs->AttacherCellule($ligne, $colonne, $elem);
	}
}