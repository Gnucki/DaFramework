<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SINPUT;
require_once INC_STEXT;


define ('COLOR_JQ', 'jq_color');
define ('COLOR_JQ_RETOUR', 'jq_color_retour');
define ('LISTECOLOR_JQ', 'jq_liste_color');

define ('COLOR', '_color');

define ('COLOR_TYPE_LISTE', 'liste');


// Input de type color.
class SInputColor extends SElement
{
	public function __construct($prefixIdClass, $typeInput = '', $retour = '', $valeur = '')
	{
	   	parent::__construct($prefixIdClass.COLOR, true, '', '', true);
	   	$this->AjouterClasse(COLOR);
	   	$div = new SBalise(BAL_DIV);

		switch ($typeInput)
		{
		   	case COLOR_TYPE_LISTE:
				$div->AddClass(LISTECOLOR_JQ);
				break;
			default:
				$div->AddClass(COLOR_JQ);
		}

		$this->Attach($div);

		if ($valeur !== '')
			$div->AddProp(PROP_STYLE, 'background-color: '.$valeur);

		// Retour.
		if ($retour !== '')
		{
			$divRetour = new SBalise(BAL_DIV);
			$divRetour->SetText(strval($retour));
			$divRetour->AddClass(COLOR_JQ_RETOUR);
			$div->Attach($divRetour);
		}
	}
}