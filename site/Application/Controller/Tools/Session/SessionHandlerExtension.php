<?php

namespace Application\Controller\Tools\Session
{
	/*************************************************************/
	/* Extension class for Session handler class (decorator pattern).
   	/*************************************************************/
	class SessionHandlerExtension extends \DaFramework\Controller\Tools\Session\SessionHandlerExtension
	{
		/*************************************/
		// CLASS METHODS
		//
		public function Langue()
		{
			echo '3';
		}
	}
}

?>