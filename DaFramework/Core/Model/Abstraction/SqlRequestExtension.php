<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Extension class for Sql request class (decorator pattern).
	/*************************************************************/
	class SqlRequestExtension extends \DaFramework\Controller\Tools\Extension\ExtendableObjectDecorator implements ISqlRequest
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		// Get/Set the parent component of this component.
		public function DataClass(\DaFramework\Model\Classes $dataClass = null)
		{
			return $this->Base()->DataClass($dataClass);
		}

		// Get/Set the request base component.
		public function BaseComponent(SqlRequestComponent $baseComponent)
		{
			return $this->Base()->BaseComponent($baseComponent);
		}

		// Get/Set the fact that the request is valid or not.
		public function IsValidRequest($isValidRequest = null)
		{
			return $this->Base()->IsValidRequest($isValidRequest);
		}


		/*************************************/
		// CLASS METHODS
		//
		// Handle an exception.
		public function HandleException(\Exception $exception)
		{
			return $this->Base()->HandleException($exception);
		}

		// Request of type Select.
		public function Select($tableAlias_columnNames, $columnNames_ = '')
		{
			return $this->Base()->Select($tableAlias_columnNames, $columnNames_);
		}

		// Request of type Insert.
		public function Insert()
		{
			return $this->Base()->Insert();
		}

		// Request of type Update.
		public function Update()
		{
			return $this->Base()->Update();
		}

		// Request of type Delete.
		public function Delete()
		{
			return $this->Base()->Delete();
		}

		// Execute the request.
		public function Execute()
		{
			return $this->Base()->Execute();
		}
	}
}

?>