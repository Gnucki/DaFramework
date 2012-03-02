<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Sql request component abstract class.
	/*************************************************************/
	abstract class SqlRequestComponent implements ISqlRequestComponent
	{
		/*************************************/
		// CLASS FIELDS
		//
		private $parentComponent;
		private $request;
		private $subComponents = array();
		private $subComponentInstancesNumber = array();
		private $orderedAcceptedSubComponentClassNames = array();
		private $acceptedSubComponentCardinality = array();


		/*************************************/
		// CLASS PROPERTIES
		//
		// Get/Set the parent component of this component.
		public function ParentComponent(ISqlRequestComponent $parentComponent = null)
		{
			if ($parentComponent !== null)
			{
				$this->parentComponent = $parentComponent;
				return $this;
			}
			return $this->parentComponent;
		}

		// Get/Set the request of this component.
		public function Request(ISqlRequest $request = null)
		{
			if ($request !== null)
			{
				$this->request = $request;
				return $this;
			}
			if ($this->request !== null)
				return $this->request;
			return $this->ParentComponent()->Request();
		}

		// Get the sub-components array.
		public function SubComponents()
		{
			return $this->subComponents;
		}

		// Get an array with the instances number for each sub-component type.
		public function SubComponentInstancesNumber()
		{
			return $this->subComponentInstancesNumber;
		}

		// Get an array with ordered accepted sub-component class names.
		public abstract function OrderedAcceptedSubComponentClassNames();
		//{
			//return array('And', 'From', ...);
		//}

		// Get an array with cardinality of all accepted sub-component (0 means * cardinality).
		public abstract function AcceptedSubComponentCardinality();
		//{
			//return array('And'=>0, 'From'=>1, ...);
		//}

		// Get the sql before all the sub-components.
		public function BeforeSubComponentsSql()
		{
			return '';
		}

		// Get the sql before the sub-components of class name $subComponentsClassName.
		public function BeforeClassNameSubComponentsSql($subComponentsClassName)
		{
			return '';
		}

		// Get the sql between each sub-component of class name $subComponentsClassName.
		public function BetweenClassNameSubComponentsSql($subComponentsClassName)
		{
			return '';
		}

		// Get the sql after the sub-components of class name $subComponentsClassName.
		public function AfterClassNameSubComponentsSql($subComponentsClassName)
		{
			return '';
		}

		// Get the sql after all the sub-components.
		public function AfterSubComponentsSql()
		{
			return '';
		}


		/*************************************/
		// CLASS METHODS
		//
		public function __construct(ISqlObject $sqlObject)
		{
			if ($sqlObject instanceof ISqlRequest)
				$this->Request($sqlObject);
			else
				$this->ParentComponent($sqlObject);
		}


		/*************************************/
		// CLASS METHODS
		//
		// Get/Set the fact that the request is valid or not.
		public function IsValidRequest($isValidRequest = null)
		{
			return $this->Request()->IsValidRequest($isValidRequest);
		}

		// Add a sub-component to this component.
		public function AddSubComponent(SqlRequestComponent &$subComponent)
		{
			$subComponentClassName = get_class($subComponent);
			// If this subcomponent is not in the accepted list, you call the parent (chained request).
			if (array_key_exists($subComponentClassName, $orderedAcceptedSubComponentClassNames))
			{
				try
				{
					if ($this->Parent() === null)
						throw new \Exception('Your SQL request has a bad syntax.');
				}
				catch (\Exception $exception)
				{
					$this->Request()->HandleException($exception);
					return $this;
				}
				return $this->ParentComponent()->AddSubComponent($subComponent);
			}
			else
			{
				$subComponentInstancesNumber = $this->SubComponentInstancesNumber();
				if (!array_key_exists($subComponentClassName, $subComponentInstancesNumber))
					$subComponentInstancesNumber[$subComponentClassName] = 0;

				try
				{
					// Verify that the number of these sub-components type doesn't exceed the accepted maximum.
					$acceptedSubComponentCardinality = $this->AcceptedSubComponentCardinality();
					if (array_key_exists($subComponentClassName, $acceptedSubComponentCardinality) &&
						$acceptedSubComponentCardinality[$subComponentClassName] >= 1 &&
						$acceptedSubComponentCardinality[$subComponentClassName] === $subComponentInstancesNumber[$subComponentClassName])
						throw new \Exception('Component ['.get_class($this).'] doesn\'t accept more than ['.$acceptedSubComponentCardinality[$subComponentClassName].'] ['.$subComponentClassName.']  sub-component.');
				}
				catch (\Exception $exception)
				{
					$this->Request()->HandleException($exception);
					return $this;
				}

				$subComponentInstancesNumber[$subComponentClassName]++;
				$this->subComponents[] = &$subComponent;
				return $subComponent;
			}
		}

		// Build the sql request text.
		public function BuildSql()
		{
			$sql = '';
			if ($this->IsValidRequest())
				$sql .= $this->BeforeSubComponentsSql().$this->BuildSubComponentsSql().$this->AfterSubComponentsSql();
			if (!$this->IsValidRequest())
				return '';
			return $sql;
		}

		// Build the sub-components sql request text.
		public function BuildSubComponentsSql()
		{
			$sql = '';
			foreach ($this->OrderedAcceptedSubComponentClassNames() as $subComponentClassName)
			{
				$subComponents = $this->GetSubComponentsByClassName($subComponentClassName);
				foreach ($subComponents as $num => $subComponent)
				{
					if ($num === 0)
						$sql .= $this->BeforeClassNameSubComponentsSql($subComponentClassName);
					else
						$sql .= $this->BetweenClassNameSubComponentsSql($subComponentClassName);
					$sql .= $subComponent->BuildSql();
					if (!$this->IsValidRequest())
						return '';
				}
				if (!empty($subComponents))
					$sql .= $this->AfterClassNameSubComponentsSql($subComponentClassName);
			}
			return $sql;
		}

		// Get sub-components whom class name is $className.
		public function GetSubComponentsByClassName($className)
		{
			$subComponents = array();
			foreach ($this->SubComponents() as $subComponent)
			{
				if (get_class($subComponent) === $className)
					$subComponents[] = $subComponent;
			}
			return $subComponents;
		}

		// Dynamic method which allow you to chain your sql request (doesn't affect the autocompletion).
		public function __call($methodName, $arguments)
		{
			try
			{
				if ($this->Parent() === null)
					throw new \Exception('Your SQL request has a bad syntax.');
				else
				{
					$reflectionClass = new \ReflectionClass($this->ParentComponent());
					$reflectionMethod = $reflectionClass->getMethod($methodName);
					return $reflectionMethod->invokeArgs($this->ParentComponent(), $arguments);
				}
			}
			catch (\Exception $exception)
			{
				$this->Request()->HandleException($exception);
				return $this;
			}
		}
	}
}

?>