<?php

require_once 'cst.php';
require_once INC_SBALISE;

class SOption extends SBalise
{
	public function __construct($value, $label)
    {
    	parent :: __construct(BAL_OPTION);
		$this->attributs['value'] = $value;
		$this->attributs['label'] = $label;
		$this->texte = $label;
    }
}

?>
