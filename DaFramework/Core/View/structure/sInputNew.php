<?php

require_once 'cst.php';
require_once INC_SINPUTSELECT;
require_once INC_SINPUTTEXT;


define ('INPUTNEW', '_new');
define ('INPUTNEW_DECLENCHEUR', '_new_dec');
define ('INPUTNEW_FORMULAIRE', '_new_form');

define ('INPUTNEW_JQ', 'jq_input_new');
define ('INPUTNEW_JQ_SELECT', 'jq_input_new_select');
define ('INPUTNEW_JQ_TEXT', 'jq_input_new_text');
define ('INPUTNEW_JQ_ELEMENT', 'jq_input_new_element');
define ('INPUTNEW_JQ_FORM', 'jq_input_new_form');
define ('INPUTNEW_JQ_DECLENCHEUR', 'jq_input_new_declencheur');
define ('INPUTNEW_JQ_TYPE', 'jq_input_file_type');

define ('INPUTNEW_TYPE_SELECT', 'newselect');
define ('INPUTNEW_TYPE_TEXT', 'newtext');


// Input de type input avec un ou plusieurs formulaires popup.
class SInputNew extends SBalise
{
   	protected $prefixIdClass;
   	protected $select;
	protected $text;
	protected $newTab;
   	protected $niveau;

	public function __construct($prefixIdClass, $typeInput = '', $oblig = false, $niveau = '')
	{
		parent::__construct(BAL_DIV);
		GSession::PoidsJavascript(1);

		switch ($typeInput)
		{
			default:
				if ($typeInput === '')
					$typeInput = INPUTNEW_TYPE_SELECT;
				break;
		}

		$this->prefixIdClass = $prefixIdClass;
		$this->niveau = $niveau;
		$this->AddClass(INPUTNEW_JQ);
		$this->AddClass('jq_fill');
		if ($oblig == true)
			$this->AddClass('jq_input_form_oblig');

		$elem = new SElement($this->prefixIdClass.INPUTNEW.$this->niveau);
		$elem->AjouterClasse(INPUTNEW.$this->niveau);
		$this->Attach($elem);

		$org = new SOrganiseur(1, 2);
		$elem->Attach($org);

		// Input.
		if ($typeInput == INPUTNEW_TYPE_SELECT && $this->select != NULL)
			$org->AttacherCellule(1, 1, $this->select);
		else if ($typeInput == INPUTNEW_TYPE_TEXT && $this->text != NULL)
			$org->AttacherCellule(1, 1, $this->text);

		$this->newTab = new STableau(true);
		$this->newTab->AddClass('jq_fill');
		$org->AttacherCellule(1, 2, $this->newTab);
	}

	public function AjouterFormulaire($libelle, $form)
	{
		$this->newTab->AddLigne();
		$cellule = $this->newTab->AddCellule();
		$cellule->AddClass(INPUTNEW_JQ_ELEMENT);

		$declencheur = new SElement($this->prefixIdClass.INPUTNEW_DECLENCHEUR.$this->niveau);
		$declencheur->AjouterClasse(INPUTNEW_DECLENCHEUR.$this->niveau);
		$declencheur->AddClass(INPUTNEW_JQ_DECLENCHEUR);
		$declencheur->SetText($libelle);
		$cellule->Attach($declencheur);

		$formulaire = new SBalise(BAL_DIV);
		$formulaire->AddClass(INPUTNEW_JQ_FORM);
		$formulaire->Attach($form);
		//$form->AjouterClasse(INPUTNEW_FORMULAIRE);
		$cellule->Attach($formulaire);
	}
}