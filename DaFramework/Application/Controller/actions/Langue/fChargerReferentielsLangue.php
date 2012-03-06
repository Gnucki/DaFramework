<?php

require_once 'cst.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
	{
		case 'LanguesAdmin'.COL_ICONE:
		   	GReferentiel::AjouterReferentielFichiers($nomReferentiel, PATH_IMAGES.'Langue/', REF_FICHIERSEXTENSIONS_IMAGES);
			GReferentiel::GetDifferentielReferentielFichiersForSelect($nomReferentiel);
			break;
	}
}

?>
