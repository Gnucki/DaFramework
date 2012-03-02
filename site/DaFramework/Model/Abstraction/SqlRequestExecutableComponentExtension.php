<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Extension class for Sql request executable component class (decorator pattern).
	/*************************************************************/
	class SqlRequestExecutableComponentExtension extends SqlRequestComponentExtension implements ISqlRequestExecutableComponentExtension
	{
		/*************************************/
		// CLASS METHODS
		//
		// Execute the request.
		public function Execute()
		{
			return $this->Base()->Execute();
		}
	}
}

?>