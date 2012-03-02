<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Extension class for Select component class (decorator pattern).
	/*************************************************************/
	class SelectExtension extends SqlRequestExecutableComponentExtension implements ISelect
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		// Get/Set the table alias.
		public function TableAlias($tableAlias = null)
		{
			return $this->Base()->TableAlias($tableAlias);
		}
		
		// Get/Set the column names.
		public function ColumnNames($columnNames = null)
		{
			return $this->Base()->ColumnNames($columnNames);
		}
		
		
		/*************************************/
		// CLASS METHODS
		//
		// Add a new sub-component that allows to add a column (or a set of columns) to the selection.
		public function _And()
		{
			return $this->Base()->_And();
		}

		// Add a new sub-component from.
		public function From()
		{
			return $this->Base()->From();
		}

		// Add a new sub-component inner join.
		public function InnerJoin()
		{
			return $this->Base()->InnerJoin();
		}

		// Add a new sub-component where.
		public function Where()
		{
			return $this->Base()->Where();
		}

		// Add a new sub-component order by.
		public function OrderBy()
		{
			return $this->Base()->OrderBy();
		}
	}
}

?>