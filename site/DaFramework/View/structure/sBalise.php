<?php

require_once 'cst.php';
require_once INC_CSTHTML;

class SBalise
{
    protected $nom;
	protected $attributs;
	protected $texte;
	protected $enfants;
	protected $noIdent;
	static protected $indent;

	static public function InitIndent()
	{
	   	self::$indent = 0;
	}

    public function __construct($idBalise, $noIdent = false)
    {
        $this->nom = $idBalise;
		$this->attributs = array();
		$this->texte = '';
		$this->enfants = array();
		$this->noIdent = $noIdent;
    }

    public function AddProp($attName, $attVal)
    {
	   	$this->attributs[$attName] = $attVal;
	}

	public function AddClass($attVal)
    {
		if (!array_key_exists(PROP_CLASS, $this->attributs))
			$this->attributs[PROP_CLASS] = $attVal;
		else
			$this->attributs[PROP_CLASS] .= ' '.$attVal;
	}

	public function HasClass($classSearch)
    {
       	$hasClass = false;
       	if (array_key_exists(PROP_CLASS, $this->attributs))
       	{
       	   	$classTab = explode(' ', $this->attributs[PROP_CLASS]);
	       	foreach ($classTab as $class)
	       	{
			   if ($classSearch === $class)
			   	   $hasClass = true;
			}
		}
 		return $hasClass;
	}

	public function AddStyle($attVal)
    {
		if (!array_key_exists(PROP_STYLE, $this->attributs))
			$this->attributs[PROP_STYLE] = $attVal;
		else
			$this->attributs[PROP_STYLE] .= ' '.$attVal;
	}

	public function DelProp($attName)
    {
		if (array_key_exists($attName, $this->attributs))
			unset($this->attributs[$attName]);
	}

	public function SetText($texte)
	{
	   	$this->texte = $texte;
	}

	public function GetEnfants()
	{
	   	return $this->enfants;
	}

	public function GetText()
	{
	   	return $this->texte;
	}

	public function GetProp($attName)
	{
	   	$propVal = NULL;
	   	if (array_key_exists($attName, $this->attributs))
	   	   	$propVal = $this->attributs[$attName];
	   	return $propVal;
	}

	public function GetClass()
	{
	   	$classTab = array();
		if (array_key_exists(PROP_CLASS, $this->attributs))
			$classTab = explode(' ', $this->attributs[PROP_CLASS]);
		return $classTab;
	}

	private function WriteText()
	{
		if (is_int($this->texte))
			return GSession::Libelle($this->texte);

		return $this->texte;
	}

	public function BuildHTML()
	{
	   	$HTML = '';
	   	self::$indent++;
		for ($i=0; $i<self::$indent; $i++)
	   	{
		   	$HTML .= "\t";
		}

		$HTML .= '<'.$this->nom;
	   	while(list($attName, $attVal) = each($this->attributs))
		{
		    $HTML .= ' '.$attName.'="'.$attVal.'"';
		}

		switch ($this->nom)
		{
			case BAL_BR:
			case BAL_INPUT:
			case BAL_LINK:
			case BAL_IMAGE:
			case BAL_META:
				$HTML .= '/>'."\n";
				break;
			default:
				$HTML .= '>'.$this->WriteText();
				if ($this->noIdent !== true)
					$HTML .= "\n";
				while(list($i, $enfant) = each($this->enfants))
				{
					$HTML .= $enfant->BuildHTML();
				}
				if ($this->noIdent !== true)
				{
					for ($i=0; $i<self::$indent; $i++)
					{
						$HTML .= "\t";
					}
				}
				$HTML .= '</'.$this->nom.'>'."\n";
				break;
		}
		self::$indent--;

		return $HTML;
	}

	public function Attach(SBalise $nouvEnfant)
	{
	   	$this->enfants[] = $nouvEnfant;
	}

	public function InsertFirst(SBalise $nouvEnfant)
	{
	   	$enfants = array();
	   	$enfants[0] = $nouvEnfant;

	   	$nbEnfants = count($this->enfants);
	   	for ($i = 0; $i < $nbEnfants; $i++)
		{
	   		$enfants[$i+1] = $this->enfants[$i];
	   	}

	   	unset($this->enfants);
	   	$this->enfants = $enfants;
	}
}

SBalise::InitIndent();

?>