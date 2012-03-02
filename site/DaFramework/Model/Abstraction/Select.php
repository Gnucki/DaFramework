<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Select component class.
	/*************************************************************/
	class Select extends SqlRequestExecutableComponent implements ISelect
	{
		/*************************************/
		// CLASS FIELDS
		//
		private $tableAlias;
		private $columnNames;


		/*************************************/
		// CLASS PROPERTIES
		//
		// Get an array with ordered accepted sub-component class names.
		public function OrderedAcceptedSubComponentClassNames()
		{
			return array('And', 'From', 'InnerJoin', 'Where', 'OrderBy');
		}

		// Get an array with cardinality of all accepted sub-component (0 means * cardinality).
		public function AcceptedSubComponentCardinality()
		{
			return array('And'=>0, 'From'=>1, 'InnerJoin'=>0, 'Where'=>1, 'OrderBy'=>1);
		}

		// Get the sql before all the sub-components.
		public function BeforeSubComponentsSql()
		{
			$sql = ' select';
			$tableAlias = $this->TableAlias();
			$firstColumn = true;
			foreach ($this->ColumnNames() as $columnName)
			{
				if ($firstColumn)
					$firstColumn = false;
				else
					$sql .= ',';
				$sql .= ' ';
				if ($tableAlias != null)
					$sql .= $tableAlias.'.';
				$sql .= $columnName;
			}
			return $sql;
		}

		// Get the sql before the sub-components of class name $subComponentsClassName.
		public function BeforeClassNameSubComponentsSql($subComponentsClassName)
		{
			switch ($subComponentsClassName)
			{
				case 'From':
					return ' from';
				case 'InnerJoin':
					return ' inner join';
				case 'Where':
					return ' where';
				case 'OrderBy':
					return ' order by';
			}
			return '';
		}

		// Get the sql between each sub-component of class name $subComponentsClassName.
		public function BetweenClassNameSubComponentsSql($subComponentsClassName)
		{
			switch ($subComponentsClassName)
			{
				case 'And':
					return ', ';
			}
			return '';
		}

		// Get/Set the table alias.
		public function TableAlias($tableAlias = null)
		{
			if ($tableAlias !== null)
			{
				$this->tableAlias = $tableAlias;
				return $this;
			}
			return $this->tableAlias;
		}

		// Get/Set the column names.
		public function ColumnNames($columnNames = null)
		{
			if ($columnNames !== null)
			{
				if (!is_array($columnNames))
					$this->columnNames = array($columnNames);
				else
					$this->columnNames = $columnNames;
				return $this;
			}
			return $this->columnNames;
		}


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		public function __construct(ISqlObject $sqlObject, $tableAlias_columnNames, $columnNames_ = '')
		{
			parent::__construct($sqlObject);
			switch (func_num_args())
			{
				case 2:
					$this->ColumnNames(func_get_arg(1));
					break;
				case 3:
					$this->TableAlias(func_get_arg(1));
					$this->ColumnNames(func_get_arg(2));
					break;
			}
		}


		/*************************************/
		// CLASS METHODS
		//
		// Add a new sub-component that allows to add a column (or a set of columns) to the selection.
		public function _And()
		{
			return $this->AddSubComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\SelectAnd'));
		}

		// Add a new sub-component from.
		public function From()
		{
			return $this->AddSubComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\From'));
		}

		// Add a new sub-component inner join.
		public function InnerJoin()
		{
			return $this->AddSubComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\InnerJoin'));
		}

		// Add a new sub-component where.
		public function Where()
		{
			return $this->AddSubComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\Where'));
		}

		// Add a new sub-component order by.
		public function OrderBy()
		{
			return $this->AddSubComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\OrderBy'));
		}

		// Dynamic method which allow you to chain your sql request (doesn't affect the autocompletion).
		public function __call($methodName, $arguments)
		{
			$reflectionClass = new \ReflectionClass($this);
			if ($methodName === 'And')
			{
				$reflectionMethod = $reflectionClass->getMethod('_And');
				return $reflectionMethod->invokeArgs($this, $arguments);
			}
			$reflectionMethod = $reflectionClass->getMethod($methodName);
			return $reflectionMethod->invokeArgs(parent, $arguments);
		}
	}
}

?>