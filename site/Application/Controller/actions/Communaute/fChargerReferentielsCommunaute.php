<?php

require_once 'cst.php';
//require_once PATH_METIER.'mListeCommunautes.php';
//require_once PATH_COMPOSANTS.'cListeCommunautesAdmin.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
	{
		case 'CommunautesAdmin'.COL_ICONE:
		   	GReferentiel::AjouterReferentielFichiers($nomReferentiel, PATH_IMAGES.'Communaute/', REF_FICHIERSEXTENSIONS_IMAGES);
			GReferentiel::GetDifferentielReferentielFichiersForSelect($nomReferentiel);
			break;
	}
}

?>
