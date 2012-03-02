<?php

require_once 'cst.php';
require_once INC_SORGANISEUR;


define ('CENTER_JQ', 'jq_center');


class SCentreur extends SOrganiseur
{
    public function __construct($contenu)
    {
       	parent::__construct(1, 3, true);
       	$this->AddClass(CENTER_JQ);
	   	$this->AjouterPropCellule(1, 1, PROP_WIDTH, '50%');
	   	$this->AttacherCellule(1, 2, $contenu);
	   	$this->AjouterPropCellule(1, 3, PROP_WIDTH, '50%');
	}
}

?>