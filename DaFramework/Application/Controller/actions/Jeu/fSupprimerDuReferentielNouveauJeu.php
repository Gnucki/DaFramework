<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';
require_once PATH_COMPOSANTS.'cListeJeuServeurs.php';
require_once PATH_COMPOSANTS.'cListeJeuTypesGroupes.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
   	$prefixIdClass = PIC_NJEU;
	switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
	{
		case COL_SERVEUR:
		   	$mObjet = new MServeur();
		   	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
		   	$mListe = new MListeServeurs();
			$mListe->AjouterElement($mObjet);
			$cListe = new CListeJeuServeurs($prefixIdClass, $nomReferentiel, $nomContexte);
			$cListe->SupprimerListeObjetsMetiersFromExistante($mListe, array(COL_LIBELLE, COL_LIBELLE));
			GContexte::AjouterListe($cListe);
			break;
		case COL_TYPEGROUPE:
		   	$mObjet = new MTypeGroupe();
		   	$mObjet->SetObjetFromTableau(GSession::LirePost($nomContexte));
		   	$mListe = new MListeTypesGroupes();
			$mListe->AjouterElement($mObjet);
			$cListe = new CListeJeuTypesGroupes($prefixIdClass, $nomReferentiel, $nomContexte);
			$cListe->SupprimerListeObjetsMetiersFromExistante($mListe, array(COL_LIBELLE, COL_LIBELLE));
			GContexte::AjouterListe($cListe);
			break;
	}
}

?>
