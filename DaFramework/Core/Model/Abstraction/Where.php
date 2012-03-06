<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* From component class.
	/*************************************************************/
	class From extends SqlRequestExecutableComponent implements IFrom
	{
		/*************************************/
		// CLASS PROPERTIES
		//
		// Get an array with ordered accepted sub-component class names.
		public function OrderedAcceptedSubComponentClassNames()
		{
			return array();
		}

		// Get an array with cardinality of all accepted sub-component (0 means * cardinality).
		public function AcceptedSubComponentCardinality()
		{
			return array();
		}

		// Get the sql before all the sub-components.
		public function BeforeSubComponentsSql()
		{
			return ' from';
		}
	}
}

?>