<?php

class JsFonction
{
   	private $nom;
   	private $nbParams;
   	private $params;

	public function __construct($nom, $nbParams)
	{
	   	$this->nom = $nom;
	   	$this->nbParams = $nbParams;
	   	$this->params = array();
	}

	private function AddParam($param)
	{
	   	if (count($this->params) < $this->nbParams)
	   		$this->params[] = $param;
	}

	public function AddParamInt($param)
	{
	   	$this->AddParam($param);
	}

	public function AddParamText($param)
	{
	   	$param = '\''.$param.'\'';
		$this->AddParam($param);
	}

	public function AddParamThis()
	{
	   	$param = 'this';
		$this->AddParam($param);
	}

	public function AddParamEvent()
	{
	   	$param = 'event';
		$this->AddParam($param);
	}

	public function AddParamTrue()
	{
	   	$param = 'true';
		$this->AddParam($param);
	}

	public function AddParamFalse()
	{
	   	$param = 'false';
		$this->AddParam($param);
	}

	public function BuildJS()
	{
	   	$JS = 'javascript:'.$this->nom.'(';
	   	while(list($i, $param) = each($this->params))
		{
		    $JS .= $param;
		    if ($i !== ($this->nbParams-1))
		    	$JS .= ',';
		}
		$JS .= ')';
		return $JS;
	}
}

?>