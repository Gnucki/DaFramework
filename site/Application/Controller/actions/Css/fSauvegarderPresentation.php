<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SRECHARGECSS;
require_once INC_CSSCONSTRUCTEUR;
require_once INC_CSS;


//if (GSession::HasDroit(FONC_CREER_CSS))
//{
	$nomElement = GSession::LirePost('NomElement');
	$nomPresentation = GSession::LirePost('NomPresentation');
	$cssId = GSession::LirePost('cssId');
	$cssClass = GSession::LirePost('cssClass');
	
	if ($nomElement != NULL && $nomElement != '' && $nomPresentation != NULL && $nomPresentation != '')
	{
		// On fabrique le fichier Css sur le disque.
		$cssConstructeur = new CssConstructeur($nomElement, $nomPresentation, $cssId, $cssClass);
		$cssConstructeur->ConstruireCss();
		
		$lien = Css::GetNomFichierLien($nomElement, $nomPresentation);
		$id = Css::GetIdLienHTML($nomElement);
	
		if ($id !== '' && $lien !== '')
		{
			// On retourne un ordre de rechargement du Css.
			$sRechargeCss = new SRechargeCss();
			$sRechargeCss->AjouterElement($id, $lien);
			echo $sRechargeCss->BuildHTML();
		}
	}
//}

?>