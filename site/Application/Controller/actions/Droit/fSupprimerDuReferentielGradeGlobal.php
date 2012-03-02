<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeJoueurs.php';
require_once PATH_COMPOSANTS.'cListeJoueursPseudos.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
   	$prefixIdClass = PIC_ADM;
	switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
	{
		case 'GradesGlobauxAdmin'.COL_JOUEUR:
		   	$mObjet = new MJoueur();
		   	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
		   	$mObjet->ChargerFromPseudo();
		   	$mListe = new MListeJoueurs();
			$mListe->AjouterElement($mObjet);
			$cListe = new CListeJoueursPseudos($prefixIdClass, $nomReferentiel, $nomContexte);
			$cListe->SupprimerListeObjetsMetiersFromExistante($mListe);
			GContexte::AjouterListe($cListe);
			break;
	}
}

?>
