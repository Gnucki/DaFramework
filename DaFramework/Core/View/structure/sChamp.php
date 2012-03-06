<?php

require_once 'cst.php';
require_once INC_SLABEL;
require_once INC_SINPUT;
require_once INC_SBALISE;

class SChamp extends SBalise
{
	public function __construct($id, $type, $libelle)
    {
        $this->nom = "div";
		$this->attributs = array();
		$this->texte = '';
		$this->enfants = array();
		$this->Attach(new SLabel($libelle));
		$this->Attach(new SInput($id, $type, ""));
    }

    public function AddProp($attName, $attVal)
    {
	   	$this->enfants[1]->AddProp($attName, $attVal);
	}
}

?>
