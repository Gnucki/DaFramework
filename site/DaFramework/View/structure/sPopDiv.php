<?php

require_once 'cst.php';
require_once INC_SELEMENT;


define('TYPEPOP_MENUFADE','jq_popdiv_menufade');
define('TYPEPOP_DIVFADE','jq_popdiv_divfade');
define('TYPEPOP_MENUTOGGLE','jq_popdiv_menutoggle');


class SPopDiv extends SBalise
{
	protected $div;

	public function __construct($typePop, $idDeclencheur, $class)
    {
       	parent::__construct(BAL_DIV);
		$this->AddClass($typePop);
		
		$elem = new SElement($class);

		$declencheur = new SBalise(BAL_DIV);
		$declencheur->AddClass('jq_popdiv_declencheur');
		$declencheur->SetText($idDeclencheur);
		parent::Attach($declencheur);

		$this->div = new SBalise(BAL_DIV);
		$this->div->AddClass('jq_popdiv_div');
		parent::Attach($this->div);
	}

	public function Attach($element)
	{
		$this->div->Attach($element);
	}
}

?>