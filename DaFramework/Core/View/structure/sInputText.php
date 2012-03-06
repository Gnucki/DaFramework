<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SINPUT;
require_once INC_STEXT;


define ('INPUTTEXT', '_text');
define ('INPUTTEXT_EDIT', '_text_edit');
define ('INPUTTEXT_VALEUREDIT', '_text_valeuredit');

define ('INPUTTEXT_JQ', 'jq_input_text');
define ('INPUTTEXT_JQ_AUTOWIDTH', 'jq_input_text_autowidth');
define ('INPUTTEXT_JQ_EDIT', 'jq_input_text_edit');
define ('INPUTTEXT_JQ_EDITVAL', 'jq_input_text_editval');
define ('INPUTTEXT_JQ_FV', 'jq_input_text_fv'); // Format valide.
define ('INPUTTEXT_JQ_CV', 'jq_input_text_cv'); // Caractères valides.
define ('INPUTTEXT_JQ_RETOUR', 'jq_input_text_retour');
define ('INPUTTEXT_JQ_ERREUR', 'jq_input_text_erreur');
define ('INPUTTEXT_JQ_INFO', 'jq_input_text_info');
define ('INPUTTEXT_JQ_DECIMAL', 'jq_input_text_dec');
define ('INPUTTEXT_JQ_MIN', 'jq_input_text_min');
define ('INPUTTEXT_JQ_MAX', 'jq_input_text_max');

define ('INPUTNEWTEXT_JQ', 'jq_input_new_text');
define ('LISTEINPUTTEXT_JQ', 'jq_liste_input_text');

define ('INPUTTEXT_TYPE_NEW', 'new');
define ('INPUTTEXT_TYPE_PASSWORD', 'password');
define ('INPUTTEXT_TYPE_LISTE', 'liste');

// Expressions régulières au format JS.
define ('INPUTTEXT_REGEXP_EMAIL_FV', "^([a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,3})$");
define ('INPUTTEXT_REGEXP_EMAIL_CV', "^[a-zA-Z0-9_@.-]*$");
define ('INPUTTEXT_REGEXP_DECIMAL_FV', "^[0-9]+$");
define ('INPUTTEXT_REGEXP_DECIMAL_CV', "^[0-9]+$");
define ('INPUTTEXT_REGEXP_TOUT_FV', "^.{min,max}$");
define ('INPUTTEXT_REGEXP_TOUT_CV', "^.*$");
// Equivalents PHP.
/*define ('INPUTTEXT_REGEXP_EMAIL_FV', "/^([a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,3})$/");
define ('INPUTTEXT_REGEXP_EMAIL_CV', "/^[a-zA-Z0-9_.@-]*$/");
define ('INPUTTEXT_REGEXP_DECIMAL_FV', "/^[0-9]*$/");
define ('INPUTTEXT_REGEXP_DECIMAL_CV', "/^[0-9]*$/");*/


// Input de type editbox.
class SInputText extends SBalise
{
   	protected $prefixIdClass;

	public function __construct($prefixIdClass, $type = '', $oblig = false, $retour = '', $valeurParDefaut = '', $longueurMin = -1, $longueurMax = -1, $taille = -1, $tailleAuto = false, $unite = '', $info = '', $erreur = '', $formatValide = '', $min = NULL, $max = NULL, $niveau = '')
	{
	   	parent::__construct(BAL_DIV);
	   	GSession::PoidsJavascript(2);

		$this->AddClass('jq_fill');
		if ($oblig == true)
			$this->AddClass('jq_input_form_oblig');

		if ($tailleAuto === true)
			$this->AddClass(INPUTTEXT_JQ_AUTOWIDTH);

		$this->prefixIdClass = $prefixIdClass;

		switch ($type)
		{
		   	case INPUTTEXT_TYPE_NEW:
				$this->AddClass(INPUTNEWTEXT_JQ);
				break;
			case INPUTTEXT_TYPE_LISTE:
				$this->AddClass(LISTEINPUTTEXT_JQ);
				break;
			default:
				$this->AddClass(INPUTTEXT_JQ);
		}

		$elem = new SElement($this->prefixIdClass.INPUTTEXT.$niveau);
		$elem->AjouterClasse(INPUTTEXT.$niveau);
		$elem->AddClass(INPUTTEXT_JQ_EDIT);

		if ($type === INPUTTEXT_TYPE_PASSWORD)
		   	$edit = new SInput('', 'password', '', $this->prefixIdClass.INPUTTEXT_VALEUREDIT);
		else if ($longueurMax === NULL && $formatValide !== INPUTTEXT_REGEXP_DECIMAL_FV)
		   	$edit = new SText($this->prefixIdClass.INPUTTEXT_VALEUREDIT.$niveau, $valeurParDefaut);
		else
		   	$edit = new SInput('', 'text', '', $this->prefixIdClass.INPUTTEXT_VALEUREDIT.$niveau);

		$edit->AddClass(INPUTTEXT_VALEUREDIT.$niveau);
		$edit->AddClass(INPUTTEXT_JQ_EDITVAL);

		if ($valeurParDefaut !== '')
			$edit->AddProp(PROP_VALUE, $valeurParDefaut);
		else
		   	$edit->AddProp(PROP_VALUE, '- null -');
		if ($longueurMax !== NULL && $longueurMax > 0)
			$edit->AddProp(PROP_MAXLENGTH, $longueurMax);
		if ($taille !== NULL && $taille > 0)
		{
		   	if ($longueurMax === NULL && $formatValide !== INPUTTEXT_REGEXP_DECIMAL_FV)
		   		$edit->AddProp(PROP_ROWS, $taille);
			else
			   	$edit->AddProp(PROP_SIZE, $taille);
		}
		else if ($tailleAuto === true && $taille <= 0)
			$edit->AddProp(PROP_SIZE, '1');

		$org = NULL;
		if ($unite !== '')
		{
			$org = new SOrganiseur(1, 2);
			$org->AttacherCellule(1, 1, $edit);
			if ($taille === -1)
			   	$org->SetCelluleDominante(1, 1);
			$org->SetTexteCellule(1, 2, strval($unite));
		}
		else
		   	$org = $edit;

		$elem->Attach($org);
		$this->Attach($elem);

		// Format valide et caractères valides (min et max quand nécessaires).
		switch ($formatValide)
		{
			case INPUTTEXT_REGEXP_EMAIL_FV:
				$caracteresValides = INPUTTEXT_REGEXP_EMAIL_CV;
				break;
			case INPUTTEXT_REGEXP_DECIMAL_FV:
				$caracteresValides = INPUTTEXT_REGEXP_DECIMAL_CV;
				$this->AddClass(INPUTTEXT_JQ_DECIMAL);

				if ($min !== NULL)
				{
					$divMin = new SBalise(BAL_DIV);
					$divMin->SetText(strval($min));
					$divMin->AddClass(INPUTTEXT_JQ_MIN);
					$divMin->AddStyle('display:none;');
					$this->Attach($divMin);
				}

				if ($max !== NULL)
				{
					$divMax = new SBalise(BAL_DIV);
					$divMax->SetText(strval($max));
					$divMax->AddClass(INPUTTEXT_JQ_MAX);
					$divMax->AddStyle('display:none;');
					$this->Attach($divMax);
				}
				break;
			case INPUTTEXT_REGEXP_TOUT_FV:
			default:
			   	$formatValide = INPUTTEXT_REGEXP_TOUT_FV;
			   	$caracteresValides = INPUTTEXT_REGEXP_TOUT_CV;
			   	if ($longueurMin === NULL)
				   	$longueurMin = '';
				else if ($longueurMin <= 0)
				   	$longueurMin = 1;
				if ($longueurMax === NULL)
				   	$longueurMax = '';
				else if ($longueurMax <= 0)
					$longueurMax = 1;
				$formatValide = str_replace('min', strval($longueurMin), $formatValide);
				$formatValide = str_replace('max', strval($longueurMax), $formatValide);
				break;
		}

		$divFV = new SBalise(BAL_DIV);
		$divFV->SetText(strval($formatValide));
		$divFV->AddClass(INPUTTEXT_JQ_FV);
		$divFV->AddStyle('display:none;');
		$this->Attach($divFV);

		if ($caracteresValides !== '')
		{
			$divCA = new SBalise(BAL_DIV);
			$divCA->SetText(strval($caracteresValides));
			$divCA->AddClass(INPUTTEXT_JQ_CV);
			$divCA->AddStyle('display:none;');
			$this->Attach($divCA);
		}

		// Retour.
		if ($retour !== '')
		{
			$divRetour = new SBalise(BAL_DIV);
			$divRetour->SetText(strval($retour));
			$divRetour->AddClass(INPUTTEXT_JQ_RETOUR);
			$divRetour->AddStyle('display:none;');
			$this->Attach($divRetour);
		}

		// Info.
		if ($info !== '')
		{
			$divInfo = new SBalise(BAL_DIV);
			$elemInfo = new SElement(CLASSCADRE_INFO, false);
			$elemInfo->SetText($info);
			$divInfo->AddClass(INPUTTEXT_JQ_INFO);
			$divInfo->Attach($elemInfo);
			$divInfo->AddStyle('display:none;');
			$this->Attach($divInfo);
		}

		// Erreur.
		if ($erreur !== '')
		{
			$divErreur = new SBalise(BAL_DIV);
			$elemErreur = new SElement(CLASSCADRE_ERREUR, false);
			$elemErreur->SetText($erreur);
			$divErreur->AddClass(INPUTTEXT_JQ_ERREUR);
			$divErreur->Attach($elemErreur);
			$divErreur->AddStyle('display:none;');
			$this->Attach($divErreur);
		}
	}
}