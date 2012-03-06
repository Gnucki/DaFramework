<?php

require_once 'cst.php';
require_once INC_GCSS;


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
	{
		case 'images':
		   	GReferentiel::AjouterReferentielFichiers($nomReferentiel, GCss::GetCheminFichiersImages(), REF_FICHIERSEXTENSIONS_IMAGES);
			GReferentiel::GetDifferentielReferentielFichiersForSelect($nomReferentiel);
			break;
	}
}

?>
