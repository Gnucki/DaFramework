<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Sql request class.
	/*************************************************************/
	class SqlRequest implements ISqlRequest
	{
		/*************************************/
		// CLASS FIELDS
		//
		private $dataClass;
		private $isValidRequest = true;
		private $baseComponent;


		/*************************************/
		// CLASS PROPERTIES
		//
		// Get/Set the parent component of this component.
		public function DataClass(\DaFramework\Model\Classes $dataClass = null)
		{
			if ($dataClass !== null)
			{
				$this->dataClass = $dataClass;
				return $this;
			}
			return $this->dataClass;
		}

		// Get/Set the request base component.
		public function BaseComponent(ISqlRequestComponent $baseComponent = null)
		{
			if ($baseComponent !== null)
			{
				$this->baseComponent = $baseComponent;
				return $this;
			}
			return $this->baseComponent;
		}

		// Get/Set the fact that the request is valid or not.
		public function IsValidRequest($isValidRequest = null)
		{
			if ($isValidRequest !== null)
			{
				$this->isValidRequest = $isValidRequest;
				return $this;
			}
			return $this->isValidRequest;
		}


		/*************************************/
		// CLASS CONSTRUCTOR
		//
		/*public function __construct(\DaFramework\Model\Classes $dataClass)
		{
			$this->DataClass($dataClass);
		}*/


		/*************************************/
		// CLASS METHODS
		//
		// Handle an exception.
		public function HandleException(\Exception $exception)
		{
			if ($this->IsValidRequest())
			{
				ExceptionHandler()->Log($exception);
				$this->IsValidRequest(false);
			}
		}

		// Request of type Select.
		public function Select($tableAlias_columnNames, $columnNames_ = '')
		{
			try
			{
				switch (func_num_args())
				{
					case 1:
						return $this->BaseComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\Select', $this, $tableAlias_columnNames))->BaseComponent();
					case 2:
						return $this->BaseComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\Select', $this, $tableAlias_columnNames, $columnNames_))->BaseComponent();;
				}
				throw new \Exception('The sql component Select doesn\'t accept ['.func_num_args().'] arguments.');
			}
			catch (\Exception $exception)
			{
				$this->HandleException($exception);
				return $this;
			}
		}

		// Request of type Insert.
		public function Insert()
		{
			return $this->BaseComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\Insert', $this))->BaseComponent();
		}

		// Request of type Update.
		public function Update()
		{
			return $this->BaseComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\Update', $this))->BaseComponent();
		}

		// Request of type Delete.
		public function Delete()
		{
			return $this->BaseComponent(ExtensionsHandler()->ExtendableObject('\DaFramework\Model\Abstraction\Delete', $this))->BaseComponent();
		}

		// Execute the request.
		public function Execute()
		{
			if ($this->IsValidRequest())
				echo $this->BaseComponent()->BuildSql();
			else
				echo 'bad request';
		}
	}
}

?>