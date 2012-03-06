<?php

require_once INC_SBALISE;

class STableau extends SBalise
{
    protected $currentLigne;
    protected $currentCellule;

    public function __construct($largeurMax = false)
    {
       	parent::__construct(BAL_TABLE);
		$this->currentLigne = -1;
		$this->currentCellule = -1;
		$this->AddProp(PROP_CELLPADDING, 0);
		$this->AddProp(PROP_CELLSPACING, 0);

		if ($largeurMax)
		   	$this->AddProp(PROP_CLASS, TABLE_MAXLARGEUR);
	}

	public function AddLigne()
	{
		$balise = new SBalise(BAL_TR);
		$this->Attach($balise);
		$this->currentLigne = $balise;
		return $this->currentLigne;
	}

	public function AddCellule()
	{
	   	if ($this->currentLigne !== -1)
		{
			$balise = new SBalise(BAL_TD);
			$this->currentLigne->Attach($balise);
			$this->currentCellule = $balise;
			return $this->currentCellule;
		}
	}

	public function AttachCellule($attElt)
	{
		if ($this->currentCellule !== -1)
			$this->currentCellule->Attach($attElt);
	}
}

?>