<?php

namespace DaFramework\Controller\Tools\Localisation
{
	/*************************************************************/
	/* Extension class for Locator class (decorator pattern).
	/*************************************************************/
	abstract class LocatorExtension extends \DaFramework\Controller\Tools\Extension\ExtendableObjectDecorator implements ILocator
	{
		/*************************************/
		// CLASS METHODS
		//
		// Get an array mapping languages and time zones.
		function LanguageTimeZones()
		{
			return $this->Base()->LanguageTimeZones();
		}
	}
}

?>