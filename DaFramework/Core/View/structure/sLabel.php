<?php

require_once 'cst.php';
require_once INC_SBALISE;

class SLabel extends SBalise
{
	public function __construct($libelle, $id = 'label')
    {
        $this->nom = 'label';
		$this->attributs = array();
		$this->attributs['id'] = $id;
		$this->texte = $libelle;
		$this->enfants = array();
    }
}

?>
