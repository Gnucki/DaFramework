<?php

require_once 'cst.php';
require_once INC_SBALISE;

class SInput extends SBalise
{
	public function __construct($id = '', $type = 'text', $valeur = '', $class = '')
    {
		parent::__construct(BAL_INPUT);
		
		if ($id !== '')
			$this->attributs[PROP_ID] = $id;
		
		if ($class !== '')
			$this->attributs[PROP_CLASS] = $class;
		
		if ($valeur !== '')
			$this->attributs[PROP_VALUE] = $valeur;
		
		$this->attributs[PROP_TYPE] = $type;
    }
}

?>
