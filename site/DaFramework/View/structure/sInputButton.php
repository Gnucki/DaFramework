<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SINPUT;


define ('INPUTBUTTON', '_button');

define ('INPUTBUTTON_JQ', 'jq_input_button');
define ('INPUTBUTTON_JQ_BOUTON', 'jq_input_button_bouton');
define ('INPUTBUTTON_JQ_CADRE', 'jq_input_button_cadre');
define ('INPUTBUTTON_JQ_CLASSE', 'jq_input_button_classe');
define ('INPUTBUTTON_JQ_FONCTION', 'jq_input_button_fonction');
define ('INPUTBUTTON_JQ_PARAM', 'jq_input_button_param');
define ('INPUTBUTTON_JQ_AJAX', 'jq_input_button_ajax');
define ('INPUTBUTTON_JQ_RESET', 'jq_input_button_reset');
define ('INPUTBUTTON_JQ_VALONCLICK', 'jq_input_button_valeuronclick');

define ('INPUTBUTTONTYPE_GAUCHE', 1);
define ('INPUTBUTTONTYPE_MILIEU', 2);
define ('INPUTBUTTONTYPE_DROIT', 3);
define ('INPUTBUTTONTYPE_REMPLI', 4);


// Input de type bouton.
class SInputButton extends STableau
{
   	protected $prefixIdClass;
	protected $bouton;
	protected $retour;
	protected $ajax;

	public function __construct($prefixIdClass, $typeInput, $libelle, $libelleOnClick = '', $cadre = '', $fonction = '', $ajax = false, $reset = false, $niveau = '')
	{
		parent::__construct(true);
		GSession::PoidsJavascript(4);

		$this->AddLigne();

		switch($typeInput)
		{
			case INPUTBUTTONTYPE_GAUCHE:
				$cellule = $this->AddCellule();
				$cell = $this->AddCellule();
				$cell->AddProp(PROP_STYLE, 'width: 100%');
				break;
			case INPUTBUTTONTYPE_DROIT:
				$cell = $this->AddCellule();
				$cell->AddProp(PROP_STYLE, 'width: 100%');
				$cellule = $this->AddCellule();
				break;
			case INPUTBUTTONTYPE_REMPLI:
				$cellule = $this->AddCellule();
				$cellule->AddProp(PROP_STYLE, 'width: 100%');
				break;
			case INPUTBUTTONTYPE_MILIEU:
			default:
				$cell = $this->AddCellule();
				$cell->AddProp(PROP_STYLE, 'width: 50%');
				$cellule = $this->AddCellule();
				$cell = $this->AddCellule();
				$cell->AddProp(PROP_STYLE, 'width: 50%');
				break;
		}

		$this->bouton = new SBalise(BAL_DIV);
		$cellule->Attach($this->bouton);

		$this->prefixIdClass = $prefixIdClass;
		$this->bouton->AddClass(INPUTBUTTON_JQ);
		$this->ajax = $ajax;
		if ($ajax == true)
			$this->bouton->AddClass(INPUTBUTTON_JQ_AJAX);
		if ($reset == true)
			$this->bouton->AddClass(INPUTBUTTON_JQ_RESET);

		$this->retour = new SBalise(BAL_DIV);
		$this->retour->AddClass(INPUTBUTTON_JQ_PARAM);
		$this->retour->SetText('');
		$this->bouton->Attach($this->retour);

		if ($libelleOnClick !== '')
		{
			$div = new SBalise(BAL_DIV);
			$div->AddClass(INPUTBUTTON_JQ_VALONCLICK);
			$div->SetText($libelleOnClick);
			$this->bouton->Attach($div);
		}

		if ($cadre !== '')
		{
			$div = new SBalise(BAL_DIV);
			$div->AddClass(INPUTBUTTON_JQ_CADRE);
			$div->SetText($cadre);
			$this->bouton->Attach($div);
		}

		if ($fonction !== '')
		{
			$div = new SBalise(BAL_DIV);
			$div->AddClass(INPUTBUTTON_JQ_FONCTION);
			$div->SetText($fonction);
			$this->bouton->Attach($div);
		}

		$element = new SElement($this->prefixIdClass.INPUTBUTTON.$niveau, false);
		$element->AjouterClasse(INPUTBUTTON.$niveau);
		$element->AddClass(INPUTBUTTON_JQ_BOUTON);
		$element->SetText($libelle);
		$this->bouton->Attach($element);
	}

	public function AjouterParamRetour($nom, $valeur = '')
	{
		if ($this->ajax === true)
			$this->AjouterParamRetourAjax($nom, $valeur);
		else
			$this->AjouterParamRetourNonAjax($nom);
	}

	private function AjouterParamRetourAjax($nom, $valeur)
	{
		$retourTxt = $this->retour->GetText();

		if ($retourTxt !== '')
			$retourTxt .= to_ajax('&');
		$retourTxt .= to_html($nom.'='.$valeur);

		$this->retour->SetText($retourTxt);
	}

	private function AjouterParamRetourNonAjax($valeur)
	{
		$retourTxt = $this->retour->GetText();

		if ($retourTxt !== '')
			$retourTxt .= ', ';
		$retourTxt .= to_html('\''.$valeur.'\'');

		$this->retour->SetText($retourTxt);
	}
}