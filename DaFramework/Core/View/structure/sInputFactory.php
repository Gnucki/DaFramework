<?php

require_once 'cst.php';
require_once INC_SELEMENT;
require_once INC_SINPUTSELECT;
require_once INC_SINPUTTEXT;
require_once INC_SINPUTBUTTON;


define ('INPUTTYPE_SELECT','select');
define ('INPUTTYPE_TEXT','text');
define ('INPUTTYPE_BUTTON','button');

define ('INPUTLABELPLACE_HAUT',0);
define ('INPUTLABELPLACE_GAUCHE',1);

define ('INPUT_LABEL', '_input_label');
//define ('INPUT_CONTENU', '_input_contenu');


// Factory permettant de créer des inputs avec des labels positionnés ou non.
class SInputFactory
{
	public function __construct()
	{
	}

	public function FabriquerNouvelInput($type, $valeur, $prefixIdClass, $label = '', $placeLabel = INPUTLABELPLACE_GAUCHE)
	{
		$element = null;
		$input = null;

		switch ($type)
		{
			case INPUTTYPE_SELECT:
				$input = new SInputSelect($prefixIdClass);
				if (is_array($valeur))
				{
					while (list($i, $val) = each($valeur))
					{
						$input->AjouterElement($val[COL_ID], $val[COL_LIBELLE], $val[COL_DESCRIPTION]);
					}
				}
				break;
			case INPUTTYPE_TEXT:
				$input = new SInputText($prefixIdClass, $valeur);
				break;
			case INPUTTYPE_BUTTON:
				$input = new SInputButton($prefixIdClass, $valeur);
				break;
		}

		if ($label !== '' && $input != null)
		{
			$element = new STableau();
			$element->AddLigne();

			if ($placeLabel == INPUTLABELPLACE_HAUT)
			{
				$cellule = $element->AddCellule();
				$elem = new SElement($prefixIdClass.INPUT_LABEL);
				$elem->SetText($label);
				$cellule->Attach($elem);
				$element->AddLigne();
			}
			else if ($placeLabel == INPUTLABELPLACE_GAUCHE)
			{
				$cellule = $element->AddCellule();
				$elem = new SElement($prefixIdClass.INPUT_LABEL);
				$elem->SetText($label);
				$cellule->Attach($elem);
			}

			$cellule = $element->AddCellule();
			$cellule->Attach($input);
		}
		else
			$element = $input;

		return $element;
	}
}