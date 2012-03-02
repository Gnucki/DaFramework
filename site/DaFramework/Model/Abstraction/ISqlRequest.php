<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Sql request interface.
	/*************************************************************/
	interface ISqlRequest extends ISqlObject, \DaFramework\Controller\Tools\Extension\IExtendableObject
	{
		/*************************************/
		// INTERFACE PROPERTIES
		//
		// Get/Set the parent component of this component.
		function DataClass(\DaFramework\Model\Classes $dataClass = null);

		// Get/Set the request base component.
		function BaseComponent(ISqlRequestComponent $baseComponent);

		// Get/Set the fact that the request is valid or not.
		function IsValidRequest($isValidRequest = null);


		/*************************************/
		// INTERFACE METHODS
		//
		// Handle an exception.
		function HandleException(\Exception $exception);

		// Request of type Select.
		function Select($tableAlias_columnNames, $columnNames_ = '');

		// Request of type Insert.
		function Insert();

		// Request of type Update.
		function Update();

		// Request of type Delete.
		function Delete();

		// Execute the request.
		function Execute();
	}
}

?>