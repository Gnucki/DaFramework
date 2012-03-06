<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SINPUT;


define ('INPUTCHECKBOX', '_checkbox');
define ('INPUTCHECKBOX_ELEM', '_checkbox_elem');

define ('INPUTCHECKBOX_JQ', 'jq_input_checkbox');
define ('INPUTCHECKBOX_JQ_EDIT', 'jq_input_checkbox_edit');
define ('INPUTCHECKBOX_JQ_ELEMENT', 'jq_input_checkbox_element');
define ('INPUTCHECKBOX_JQ_DESCRIPTION', 'jq_input_checkbox_description');
define ('INPUTCHECKBOX_JQ_ID', 'jq_input_checkbox_id');
define ('INPUTCHECKBOX_JQ_RETOUR', 'jq_input_checkbox_retour');
define ('INPUTCHECKBOX_JQ_ERREUR', 'jq_input_checkbox_erreur');
define ('INPUTCHECKBOX_JQ_INFO', 'jq_input_checkbox_info');

define ('LISTEINPUTCHECKBOX_JQ', 'jq_liste_input_checkbox');

define ('INPUTCHECKBOX_TYPE_CHECKBOX', 'check');
define ('INPUTCHECKBOX_TYPE_RADIOBOX', 'radio');
define ('INPUTCHECKBOX_TYPE_LISTE', 'liste');


// Input de type checkbox.
class SInputCheckbox extends SBalise
{
   	protected $prefixIdClass;
   	protected $checkboxTab;
   	protected $checkboxCadre;
   	protected $nbCheckboxElem;
   	protected $info;
   	protected $niveau;

	public function __construct($prefixIdClass, $type = '', $oblig = false, $retour = '', $info = '', $erreur = '', $niveau = '')
	{
	   	parent::__construct(BAL_DIV);

		$this->AddClass('jq_fill');
		if ($oblig == true)
			$this->AddClass('jq_input_form_oblig');

		$this->prefixIdClass = $prefixIdClass;
		$this->niveau = $niveau;
		$this->nbCheckboxElem = 0;
		$this->info = $info;

		switch ($type)
		{
		   	case INPUTCHECKBOX_TYPE_LISTE:
		   		$this->AddClass(LISTEINPUTCHECKBOX_JQ);
		   		break;
			default:
				$this->AddClass(INPUTCHECKBOX_JQ);
		}

		$this->checkboxTab = NULL;
		$this->checkboxCadre = new SElement($this->prefixIdClass.INPUTCHECKBOX.$this->niveau);
		$this->checkboxCadre->AjouterClasse(INPUTCHECKBOX.$this->niveau);
		$this->Attach($this->checkboxCadre);

		// Retour.
		if ($retour !== '')
		{
			$divRetour = new SBalise(BAL_DIV);
			$divRetour->SetText(strval($retour));
			$divRetour->AddClass(INPUTCHECKBOX_JQ_RETOUR);
			$divRetour->AddStyle('display:none;');
			$this->Attach($divRetour);
		}

		// Info.
		if ($info !== '')
		{
			$divInfo = new SBalise(BAL_DIV);
			$elemInfo = new SElement(CLASSCADRE_INFO, false);
			$elemInfo->SetText($info);
			$divInfo->AddClass(INPUTCHECKBOX_JQ_INFO);
			$divInfo->AddStyle('display:none;');
			$divInfo->Attach($elemInfo);
			$this->Attach($divInfo);
		}

		// Erreur.
		if ($erreur !== '')
		{
			$divErreur = new SBalise(BAL_DIV);
			$elemErreur = new SElement(CLASSCADRE_ERREUR, false);
			$elemErreur->SetText($erreur);
			$divErreur->AddClass(INPUTCHECKBOX_JQ_ERREUR);
			$divErreur->AddStyle('display:none;');
			$divErreur->Attach($elemErreur);
			$this->Attach($divErreur);
		}
	}

	public function AjouterCheckbox($id = '', $description = '', $valeurParDefaut = false)
	{
	   	$this->nbCheckboxElem++;

	   	if ($this->checkboxTab === NULL)
	   	{
	   	   	$this->checkboxTab = new STableau();
	   	   	$this->checkboxCadre->Attach($this->checkboxTab);
	   	}

	   	$this->checkboxTab->AddLigne();
	   	$cellule = $this->checkboxTab->AddCellule();
	   	$cellule->AddClass(INPUTCHECKBOX_JQ_ELEMENT);

	   	// Checkbox.
	   	$elemCheck = new SElement($this->prefixIdClass.INPUTCHECKBOX_ELEM.$this->niveau);
		$elemCheck->AjouterClasse(INPUTCHECKBOX_ELEM.$this->niveau);
		$elemCheck->AddClass(INPUTCHECKBOX_JQ_EDIT);
		if ($valeurParDefaut === true)
		   	$elemCheck->SetText('x');
		$cellule->Attach($elemCheck);

	   	// Id.
	   	if ($id !== '')
		{
			$divId = new SBalise(BAL_DIV);
			$divId->SetText(strval($id));
			$divId->AddClass(INPUTCHECKBOX_JQ_ID);
			$divId->AddStyle('display:none;');
			$cellule->Attach($divId);
		}

		// Description.
		if ($description !== '')
		{
			$divDesc = new SBalise(BAL_DIV);
			$divDesc->SetText($description);
			$divDesc->AddClass(INPUTCHECKBOX_JQ_DESCRIPTION);
			$divDesc->AddStyle('display:none;');
			$cellule->Attach($divDesc);
		}
	}

	public function BuildHTML()
	{
	   	if ($this->nbCheckboxElem === 0)
	   		$this->AjouterCheckbox('', $this->info);
	   	return parent::BuildHTML();
	}
}