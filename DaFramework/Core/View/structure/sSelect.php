<?php

require_once INC_SBALISE;
require_once INC_SOPTION;

class SSelect extends SBalise
{
	public function __construct($id, $valeurDefaut = '')
    {
    	parent :: __construct(BAL_SELECT);
		$this->attributs['id'] = $id;
		if ($valeurDefaut != '')
			$this->Attach(new SOption('', $valeurDefaut));
    }
    
    public function SelectOption($optionChoisie)
    {
    	$enfants = $this->enfants;
    	foreach($enfants as $enfant) {
    		$enfant->DelProp('selected');
    		if ($enfant->attributs['value'] == $optionChoisie)
    			$enfant->AddProp('selected', 'true');
    	}
    }
    
    public function SupprimerOption($optionASupprimer)
    {
    	$enfants = $this->enfants;
    	foreach($enfants as $enfant)
    		if ($enfant->attributs['value'] == $optionASupprimer)
    			unset($this->enfants[array_search($enfant, $this->enfants)]);
    }
}

?>
