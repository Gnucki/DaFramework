<?php

namespace DaFramework\Model\Classes
{
	abstract class DataField
	{
		/*************************************/
		// CLASS FIELDS
		protected $value;
		private $columnName;
		private $isNullable;
		private $isPrimaryKey;
		private $isAutoInc;
		private $defaultValue;
		private $jointClassName;
		private $jointClassColumnName;


		/*************************************/
		// CLASS PROPERTIES
		//
		public function ColumnName($columnName = NULL)
		{
			if ($columnName !== NULL)
				$this->columnName = $columnName;
			else
				return $this->columnName;
			return $this;
		}

		public function IsNullable($isNullable = NULL)
		{
			if ($isNullable !== NULL)
				$this->isNullable = $isNullable;
			else
				return $this->isNullable;
			return $this;
		}

		public function IsPrimaryKey($isPrimaryKey = NULL)
		{
			if ($isPrimaryKey !== NULL)
				$this->isPrimaryKey = $isPrimaryKey;
			else
				return $this->isPrimaryKey;
			return $this;
		}

		public function IsAutoIncremental($isAutoIncremental = NULL)
		{
			if ($isAutoIncremental !== NULL)
				$this->isAutoIncremental = $isAutoIncremental;
			else
				return $this->isAutoIncremental;
			return $this;
		}

		public function DefaultValue($defaultValue = NULL)
		{
			if ($defaultValue !== NULL)
				$this->defaultValue = $defaultValue;
			else
				return $this->defaultValue;
			return $this;
		}

		// Describe a joint with another table.
		// If $jointColumnName == NULL then we take the primary key by default
		// (of course the primary must be one column in that case).
		public function Joint($jointClassName, $jointClassColumnName = NULL)
		{
			$this->JointClassName($jointClassName);
			if ($jointClassColumnName === NULL)
			{
				// Automatic determination of joint column name.
				$primaryKeyFields = $this->value->PrimaryKeyFields();
				if (count($primaryKeyFields) === 1)
					$this->JointClassColumnName($primaryKeyFields[0]);
	//			else
	//				GLog::LeverException(EXM_, DataField::Value, the joint column name for the joint class name ['.$this->value->GetClassName().'] must be explicited.');
			}
			else
				$this->JointClassColumnName($jointColumnName);
			return $this;
		}

		public function JointClassName()
		{
			return $this->jointClassName;
		}

		public function JointClassColumnName()
		{
			return $this->jointClassColumnName;
		}

		public function Value($value = NULL)
		{
			if ($value !== NULL)
				$this->value = $value;
			else if ($this->IsJoint())
			{
				if ($this->value === NULL)
				{
					// Automatic include if the file has the same name as the class.
					include_once eval($this->JointClassName().'.php');
					$this->value = eval('new '.$this->JointClassName().'()');
				}
				return $this->value;
			}
			else
				return $this->value;
			return $this;
		}

		public function SqlValue($value = NULL)
		{
			if ($value !== NULL)
			{
				if ($this->IsJoint())
					$this->Value()->FieldValue($this->JointClassColumnName(), $value);
				else
					$this->Value($value);
			}
			else
			{
				if ($this->IsJoint())
					return $this->Value()->FieldValue($this->JointClassColumnName());
				else
					return $this->Value();
			}
			return $this;
		}


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		// Constructor.
		public function __construct($columnName, $isNullable = false, $isPrimaryKey = false, $isAutoIncremental = false, $defaultValue = NULL)
		{
			$this->ColumnName($columnName);
			$this->IsNullable($isNullable);
			$this->IsPrimaryKey($isPrimaryKey);
			$this->IsAutoIncremental($isAutoIncremental);
			$this->DefaultValue($defaultValue);
		}


		/*************************************/
		// CLASS METHODS
		//
		public function IsJoint()
		{
			if ($this->jointClassName !== NULL)
				return true;
			return false;
		}
	}
}

?>