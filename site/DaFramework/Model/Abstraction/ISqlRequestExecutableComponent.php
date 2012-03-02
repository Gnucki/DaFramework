<?php

namespace DaFramework\Model\Abstraction
{
	/*************************************************************/
	/* Sql request executable component interface.
	/*************************************************************/
	interface ISqlRequestExecutableComponent extends ISqlRequestComponent
	{
		/*************************************/
		// INTERFACE METHODS
		//
		// Execute the request.
		function Execute();
	}
}

?>