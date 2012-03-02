<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Sql request component interface.
	/*************************************************************/
	interface ISqlRequestComponent extends ISqlObject, \DaFramework\Controller\Tools\Extension\IExtendableObject
	{
		/*************************************/
		// INTERFACE PROPERTIES
		//
		// Get/Set the parent component of this component.
		function ParentComponent(ISqlRequestComponent $parentComponent = null);

		// Get/Set the request of this component.
		function Request(ISqlRequest $request = null);

		// Get the sub-components array.
		function SubComponents();

		// Get an array with the instances number for each sub-component type.
		function SubComponentInstancesNumber();

		// Get the sql before all the sub-components.
		function BeforeSubComponentsSql();

		// Get the sql before the sub-components of class name $subComponentsClassName.
		function BeforeClassNameSubComponentsSql($subComponentsClassName);

		// Get the sql between each sub-component of class name $subComponentsClassName.
		function BetweenClassNameSubComponentsSql($subComponentsClassName);

		// Get the sql after the sub-components of class name $subComponentsClassName.
		function AfterClassNameSubComponentsSql($subComponentsClassName);

		// Get the sql after all the sub-components.
		function AfterSubComponentsSql();


		/*************************************/
		// INTERFACE METHODS
		//
		// Get/Set the fact that the request is valid or not.
		function IsValidRequest($isValidRequest = null);

		// Add a sub-component to this component.
		function AddSubComponent(SqlRequestComponent &$subComponent);

		// Build the sql request text.
		function BuildSql();

		// Build the sub-components sql request text.
		function BuildSubComponentsSql();

		// Get sub-components whom class name is $className.
		function GetSubComponentsByClassName($className);
	}
}

?>