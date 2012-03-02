<?php

namespace DaFramework\Controller\Tools\Session
{
	/*************************************************************/
	/* Extension class for Session handler class (decorator pattern).
	/*************************************************************/
	abstract class SessionHandlerExtension extends \DaFramework\Controller\Tools\Extension\ExtendableObjectDecorator implements ISessionHandler
	{
		/*************************************/
		// CLASS METHODS
		//
		// Start the session.
		public function Start()
		{
			return $this->Base()->Start();
		}

		// End the session.
		public function End()
		{
			return $this->Base()->End();
		}

		// Initialize global session variables.
		public function Initialize()
		{
			return $this->Base()->Initialize();
		}

		// Initialize specific session variables for the browser page which sent the request.
		public function InitializePage()
		{
			return $this->Base()->InitializePage();
		}

		// Get/set a global session variable.
		public function VariableValue($variableName, $value = UNDEFINED)
		{
			return $this->Base()->VariableValue($variableName, $value);
		}

		// Get/set a specific session variable for the browser page which sent the request.
		public function PageVariableValue($variableName, $value = UNDEFINED)
		{
			return $this->Base()->PageVariableValue($variableName, $value);
		}
	}
}

?>