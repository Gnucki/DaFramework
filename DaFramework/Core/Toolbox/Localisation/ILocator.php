<?php

namespace DaFramework\Controller\Tools\Localisation
{
	/*************************************************************/
	/* Locator interface.
	/*************************************************************/
	interface ILocator extends \DaFramework\Controller\Tools\Extension\IExtendableObject
	{
		// Get an array mapping languages and time zones.
		function LanguageTimeZones();
	}
}

?>