<?php

require_once 'cst.php';
require_once INC_SBALISE;
require_once INC_SSELECT;
require_once INC_SLABEL;


class SChoix extends SBalise
{
	public function __construct($id, $valeurDefaut, $libelle)
    {
    	parent ::__construct(BAL_DIV);
		$this->enfants[] = new SLabel($libelle);
		$this->enfants[] = new SSelect($id, $valeurDefaut);
    }

    public function AddProp($attName, $attVal)
    {
	   	$this->enfants[1]->AddProp($attName, $attVal);
	}

	public function Attach(IObjetHTML $nouvEnfant)
	{
	   	$this->enfants[1]->Attach($nouvEnfant);
	}
	
	public function AttachGlobal(IObjetHTML $nouvEnfant)
	{
	   	$this->enfants[] = $nouvEnfant;
	}
	
	public function SelectOption($optionChoisie)
	{
		$this->enfants[1]->SelectOption($optionChoisie);
	}
	
	public function SupprimerOption($optionASupprimer)
	{
		$this->enfants[1]->SupprimerOption($optionASupprimer);
	}
}

?>
