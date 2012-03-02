<?php

require_once 'cst.php';
require_once INC_SELEMENT;


define('TYPEPOP_SLIDECLICK','jq_popdiv_slideclick');


class SConteneurRepliable extends SElement
{
	protected $div;

	public function __construct($titre, $idDeclencheur, $class, $id = '', $idTab = '')
    {
       	parent::__construct($class, $id, $idTab);
		
		$popDiv = new SBalise(BAL_DIV);
		$popDiv->AddClass(TYPEPOP_SLIDECLICK);
		parent::Attach($popDiv);
		
		$declencheur = new SBalise(BAL_DIV);
		$declencheur->AddClass('jq_popdiv_declencheur');
		$declencheur->SetText($idDeclencheur);
		$popDiv->Attach($declencheur);

		$bal = new SBalise(BAL_DIV);
		$bal->AddProp(PROP_ID, $idDeclencheur);
		$tab = new STableau(true);
		$tab->AddLigne();
		
		$cellule = $tab->AddCellule();
		$element = new SElement($class.'');
		$element->SetText('+');
		
		$cellule = $tab->AddCellule();
		$element = new SElement($class.'');
		$element->SetText($titre);
		
		$bal->Attach($tab);
		$popDiv->Attach($bal);
		
		$this->div = new SBalise(BAL_DIV);
		$this->div->AddClass('jq_popdiv_div');
		$popDiv->Attach($this->div);
	}

	public function Attach($element)
	{
		$this->div->Attach($element);
	}
}

?>