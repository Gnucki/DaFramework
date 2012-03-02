<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Extension class for Sql request component class (decorator pattern).
	/*************************************************************/
	class SqlRequestComponentExtension extends \DaFramework\Controller\Tools\Extension\ExtendableObjectDecorator implements ISqlRequestComponent
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		// Get/Set the parent component of this component.
		public function ParentComponent(ISqlRequestComponent $parentComponent = null)
		{
			return $this->Base()->ParentComponent($parentComponent);
		}

		// Get/Set the request of this component.
		public function Request(ISqlRequest $request = null)
		{
			return $this->Base()->Request($request);
		}

		// Get the sub-components array.
		public function SubComponents()
		{
			return $this->Base()->SubComponents();
		}

		// Get an array with the instances number for each sub-component type.
		public function SubComponentInstancesNumber()
		{
			return $this->Base()->SubComponentInstancesNumber();
		}

		// Get an array with ordered accepted sub-component class names.
		public function OrderedAcceptedSubComponentClassNames(array $orderedAcceptedSubComponentClassNames = null)
		{
			return $this->Base()->OrderedAcceptedSubComponentClassNames($orderedAcceptedSubComponentClassNames);
		}

		// Get an array with cardinality of all accepted sub-component (0 means * cardinality).
		public function AcceptedSubComponentCardinality(array $acceptedSubComponentCardinality = null)
		{
			return $this->Base()->AcceptedSubComponentCardinality($acceptedSubComponentCardinality);
		}

		// Get the sql before all the sub-components.
		public function BeforeSubComponentsSql()
		{
			return $this->Base()->BeforeSubComponentsSql();
		}

		// Get the sql before the sub-components of class name $subComponentsClassName.
		public function BeforeClassNameSubComponentsSql($subComponentsClassName)
		{
			return $this->Base()->BeforeClassNameSubComponentsSql($subComponentsClassName);
		}

		// Get the sql between each sub-component of class name $subComponentsClassName.
		public function BetweenClassNameSubComponentsSql($subComponentsClassName)
		{
			return $this->Base()->BetweenClassNameSubComponentsSql($subComponentsClassName);
		}

		// Get the sql after the sub-components of class name $subComponentsClassName.
		public function AfterClassNameSubComponentsSql($subComponentsClassName)
		{
			return $this->Base()->AfterClassNameSubComponentsSql($subComponentsClassName);
		}

		// Get the sql after all the sub-components.
		public function AfterSubComponentsSql()
		{
			return $this->Base()->AfterSubComponentsSql();
		}


		/*************************************/
		// CLASS METHODS
		//
		// Get/Set the fact that the request is valid or not.
		public function IsValidRequest($isValidRequest = null)
		{
			return $this->Base()->IsValidRequest($isValidRequest);
		}

		// Add a sub-component to this component.
		public function AddSubComponent(SqlRequestComponent &$subComponent)
		{
			return $this->Base()->AddSubComponent($subComponent);
		}

		// Build the sql request text.
		public function BuildSql()
		{
			return $this->Base()->BuildSql();
		}

		// Build the sub-components sql request text.
		public function BuildSubComponentsSql()
		{
			return $this->Base()->BuildSubComponentsSql();
		}

		// Get sub-components whom class name is $className.
		public function GetSubComponentsByClassName($className)
		{
			return $this->Base()->GetSubComponentsByClassName($className);
		}
	}
}

?>