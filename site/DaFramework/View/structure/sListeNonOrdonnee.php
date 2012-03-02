<?php

require_once 'cst.php';
require_once INC_SBALISE;


class SListeNonOrdonnee extends SBalise
{
    public function __construct($id = '', $class = '')
    {
       	parent::__construct(BAL_UL);

       	if ($id !== '')
	   	   	$this->AddProp(PROP_ID, $id);

	   	if ($class !== '')
	   	   	$this->AddProp(PROP_CLASS, $class);
	}

	public function AjouterElement($texte, $id = '', $class = '', $valeur = '')
	{
	   	$element = new Balise(BAL_LI);

	   	if ($id !== '')
	   	   	$element->AddProp(PROP_ID, $id);

	   	if ($class !== '')
	   	   	$element->AddProp(PROP_CLASS, $class);

	   	if ($valeur !== '')
	   	   	$element->AddProp(PROP_VALUE, $valeur);

	   	$element->SetText($texte);

	   	$this->Attach($element);
	}
}

?>