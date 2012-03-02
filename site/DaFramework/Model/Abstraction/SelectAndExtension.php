<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Extension class for Select and component class (decorator pattern).
	/*************************************************************/
	class SelectAndExtension extends SqlRequestExecutableComponentExtension implements ISelectAnd
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
	}
}

?>