<?php

namespace DaFramework\Model\Classes
{
	class DataIntField extends DataField
	{
		public function Value($value = NULL)
		{
			if ($value !== NULL)
			{
				$this->value = $value;
			}
			else
				return $this->value;
			return $this;
		}
	}
}

?>