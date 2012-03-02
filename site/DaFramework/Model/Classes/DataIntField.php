<?php

namespace DaFramework\Model\Classes
{
	class DataIntField extends DataField
	{
		/*************************************/
		// CLASS FIELDS
		private $minValue;
		private $maxValue;


		/*************************************/
		// CLASS PROPERTIES
		//
		public function MinValue($minValue = NULL)
		{
			if ($minValue !== NULL)
				$this->minValue = $minValue;
			else
				return $this->minValue;
			return $this;
		}

		public function MaxValue($maxValue = NULL)
		{
			if ($maxValue !== NULL)
				$this->maxValue = $maxValue;
			else
				return $this->maxValue;
			return $this;
		}


		/*************************************/
		// CLASS METHODS
		//
		public function Value($value = NULL)
		{
			if ($value !== NULL)
			{
				$value = intval($value);
				if ($value < $this->MinValue() || $value > $this->MaxValue())
	//				GLog::
				else
					parent::Value($value);
			}
				$this->value = $value;
			else
				return parent::Value();
			return $this;
		}
	}
}

?>