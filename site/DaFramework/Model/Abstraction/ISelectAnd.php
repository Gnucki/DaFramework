<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Select and component interface.
	/*************************************************************/
	interface ISelectAnd
	{
		/*************************************/
		// INTERFACE PROPERTIES
		//
		// Get/Set the table alias.
		function TableAlias($tableAlias = null);
		
		// Get/Set the column names.
		function ColumnNames($columnNames = null);
	}
}

?>