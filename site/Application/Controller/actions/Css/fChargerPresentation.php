<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_CSSPARSEUR;
require_once INC_CSS;


//if (GSession::HasDroit(FONC_CREER_CSS))
//{
	$nomElement = GSession::LirePost('NomElement');
	$nomPresentation = GSession::LirePost('NomPresentation');

	if ($nomElement != NULL && $nomElement != '')// && $nomPresentation != NULL && $nomPresentation != '')
	{
		$nomFichier = Css::GetNomFichierDestination($nomElement, $nomPresentation);
		if ($nomFichier !== '')
		{
			$cssParseur = new CssParseur();
			$css = $cssParseur->ParseCSS($nomFichier);
			if ($css != NULL)
			{
				switch($nomElement)
				{
					case 'AMI':
						include INC_FCHARGERPRESENTATIONAMI;
						break;
					case 'FORUM':
						include INC_FCHARGERPRESENTATIONFORUM;
						break;
				}
			}
		}
	}
//}

?>