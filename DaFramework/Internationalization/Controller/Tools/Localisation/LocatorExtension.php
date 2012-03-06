<?php

namespace Internationalization\Controller\Tools\Localisation
{
	/*************************************************************/
	/* Extension class for Session handler class (decorator pattern).
	/*************************************************************/
	class LocatorExtension extends \DaFramework\Controller\Tools\Localisation\LocatorExtension
	{
		/*************************************/
		// CLASS METHODS
		//
		// Initialize specific session variables for the browser page which sent the request.
		public function Bip()
		{
			echo 'Bip';
		}
	}
}

?>