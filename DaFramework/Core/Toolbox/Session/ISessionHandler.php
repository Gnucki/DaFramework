<?php

namespace DaFramework\Controller\Tools\Session
{
	/*************************************************************/
	/* Session handler interface.
	/*************************************************************/
	interface ISessionHandler extends \DaFramework\Controller\Tools\Extension\IExtendableObject
	{
		/*************************************/
		// INTERFACE METHODS
		//
		// Start the session.
		function Start();
		// End the session.
		function End();
		// Initialize global session variables.
		function Initialize();
		// Initialize specific session variables for the browser page which sent the request.
		function InitializePage();
		// Get/set a global session variable.
		function VariableValue($variableName, $value = UNDEFINED);
		// Get/set a specific session variable for the browser page which sent the request.
		function PageVariableValue($variableName, $value = UNDEFINED);
	}
}

?>