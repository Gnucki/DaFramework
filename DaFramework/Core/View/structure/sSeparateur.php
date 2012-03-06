<?php

require_once 'cst.php';
require_once INC_SORGANISEUR;


class SSeparateur extends SElement
{
    public function __construct($prefixIdClass)
    {
       	parent::__construct($prefixIdClass.CLASSSEPARATEUR);
       	$this->AjouterClasse(CLASSSEPARATEUR);
	}
}

?>