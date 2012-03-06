<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeJoueurs.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
	{
		case 'GradesGlobauxAdmin'.COL_ICONE:
		   	GReferentiel::AjouterReferentielFichiers($nomReferentiel, PATH_IMAGES.'Grade/', REF_FICHIERSEXTENSIONS_IMAGES);
			GReferentiel::GetDifferentielReferentielFichiersForSelect($nomReferentiel);
			break;
		case 'GradesGlobauxAdmin'.COL_JOUEUR.COL_PSEUDO:
		   	$valeur = GSession::LirePost('valeur');
		   	$mListe = new MListeJoueurs();
			$mListe->AjouterColSelection(COL_PSEUDO);
			$mListe->AjouterColOrdre(COL_PSEUDO);
			$mListe->AjouterFiltreLike(COL_PSEUDO, '%'.$valeur.'%');
			if ($valeur != NULL)
			   	$mListe->Charger(20);
			GReferentiel::AjouterReferentiel($nomReferentiel, $mListe, array(COL_PSEUDO), true);
			GReferentiel::GetDifferentielReferentielForSelect($nomReferentiel, COL_PSEUDO, COL_PSEUDO);
			break;
	}
}

?>
