<?php

require_once 'cst.php';
require_once INC_STABLEAU;

class SElement extends SBalise
{
    protected $tableau;
    protected $cellule;

    public function __construct($class = '', $remplirParent = true, $id = '', $idTab = '', $tabMaxLargeur = true)
    {
       	parent::__construct(BAL_DIV);

		$this->tableau = new STableau($tabMaxLargeur);
		$this->tableau->AddLigne();
		$this->cellule = $this->tableau->AddCellule();

		if ($id !== '')
			$this->AddProp(PROP_ID, $id);
		if ($idTab !== '')
			$this->cellule->AddProp(PROP_ID, $idTab);
		if ($class !== '')
		{
			$this->AddClass($class);
			$this->cellule->AddClass($class.'_tab');
		}

		if ($remplirParent === true)
		{
		   	$this->AddClass('jq_fill');
			$this->tableau->AddClass('jq_fill');
		}

		parent::Attach($this->tableau);
	}

	public function GetTableau()
	{
		return $this->tableau;
	}

	public function GetCellule()
	{
	   	return $this->cellule;
	}

	public function Attach($element)
	{
		$this->cellule->Attach($element);
	}

	public function SetText($texte)
	{
		$this->cellule->SetText($texte);
	}

	public function AjouterClasse($class)
	{
		if ($class !== '')
		{
			$this->AddClass($class);
			$this->cellule->AddClass($class.'_tab');
		}
	}
}

?>