<?php

require_once 'cst.php';
require_once INC_SBALISE;

class SText extends SBalise
{
	public function __construct($class = '', $valeur = '', $nbLignes = -1, $nbColonnes = -1)
    {
		parent::__construct(BAL_TEXTAREA, true);

		if ($class !== '')
			$this->AddClass($class);

		if ($valeur !== '')
			$this->SetText($valeur);

		if ($nbLignes != -1)
		   	$this->AddProp(PROP_ROWS, $nbLignes);

		if ($nbColonnes != -1)
		   	$this->AddProp(PROP_COLS, $nbColonnes);
    }
}

?>
