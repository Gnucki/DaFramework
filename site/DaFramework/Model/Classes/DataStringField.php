<?php

require_once 'cst.php';
require_once INC_GDATE;
require_once PATH_BASE.'bObjetBase.php';


class DataStringField extends DataField
{
	/*************************************/
	// CLASS FIELDS
	private $minLength;
	private $maxLength;

	/*************************************/
	// CLASS PROPERTIES
	//
	public function MinLength($minLength = NULL)
	{
		if ($minLength !== NULL)
			$this->minLength = $minLength;
		else
			return $this->minLength;
		return $this;
	}

	public function MaxLength($maxLength = NULL)
	{
		if ($maxLength !== NULL)
			$this->maxLength = $maxLength;
		else
			return $this->maxLength;
		return $this;
	}

	public function RegularExpression($regularExpression = NULL)
	{
		if ($regularExpression !== NULL)
			$this->regularExpression = $regularExpression;
		else
			return $this->regularExpression;
		return $this;
	}
}

?>