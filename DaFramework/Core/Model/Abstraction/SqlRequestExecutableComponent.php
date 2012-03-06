<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Sql request executable component abstract class.
	/*************************************************************/
	abstract class SqlRequestExecutableComponent extends SqlRequestComponent implements ISqlRequestExecutableComponent
	{
		/*************************************/
		// CLASS METHODS
		//
		// Execute the request.
		public function Execute()
		{
			$this->Request()->Execute();
		}
	}
}

?>