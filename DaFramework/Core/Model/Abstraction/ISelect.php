<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Select component interface.
	/*************************************************************/
	interface ISelect
	{
		/*************************************/
		// INTERFACE PROPERTIES
		//
		// Get/Set the table alias.
		function TableAlias($tableAlias = null);
		
		// Get/Set the column names.
		function ColumnNames($columnNames = null);
		
		
		/*************************************/
		// INTERFACE METHODS
		//
		// Add a new sub-component that allows to add a column (or a set of columns) to the selection.
		function _And();

		// Add a new sub-component from.
		function From();

		// Add a new sub-component inner join.
		function InnerJoin();

		// Add a new sub-component where.
		function Where();

		// Add a new sub-component order by.
		function OrderBy();
	}
}

?>