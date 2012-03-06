<?php

namespace Internationalization\Controller\Tools\Session
{
	/*************************************************************/
	/* Extension class for Session handler class (decorator pattern).
	/*************************************************************/
	class SessionHandlerExtension extends \DaFramework\Controller\Tools\Session\SessionHandlerExtension
	{
		/*************************************/
		// CLASS METHODS
		//
		// Initialize specific session variables for the browser page which sent the request.
		public function InitializePage()
		{
			$this->Base()->InitializePage();

			self::Langue(COL_ID);
			$communauteId = self::Communaute(COL_ID);

			require_once PATH_METIER.'mGroupe.php';

			$mGroupe = new MGroupe();
			$mGroupe->AjouterColSelection(COL_ID);
			$mGroupe->AjouterColSelection(COL_NOM);
			$mGroupe->AjouterColSelection(COL_DESCRIPTION);
			$mGroupe->AjouterColCondition(COL_TYPEGROUPE, TYPEGROUPE_COMMUNAUTE);
			$mGroupe->AjouterColCondition(COL_COMMUNAUTE, $communauteId);
			$mGroupe->Charger();

			GSession::Groupe(COL_ID, $mGroupe->Id(), true);
			GSession::Groupe(COL_NOM, $mGroupe->Nom(), true);
			GSession::Groupe(COL_DESCRIPTION, $mGroupe->Description(), true);
			GSession::Groupe(COL_TYPEGROUPE, TYPEGROUPE_COMMUNAUTE, true);
		}
	}
}

?>