<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
	switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
	{
		case 'Groupes'.COL_JEU.','.COL_ID:
		   	$valeur = GSession::LirePost('valeur');
		   	$mListe = new MListeJeux();
			$mListe->AjouterColSelection(COL_ID);
			$mListe->AjouterColSelection(COL_LIBELLE);
			$mListe->AjouterColOrdre(COL_LIBELLE);
			$mListe->AjouterFiltreLike(COL_LIBELLE, '%'.$valeur.'%');
			if ($valeur != NULL)
			   	$mListe->Charger(20);
			GReferentiel::AjouterReferentiel($nomReferentiel, $mListe, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
			GReferentiel::GetDifferentielReferentielForSelect($nomReferentiel, COL_ID, array(COL_LIBELLE, COL_LIBELLE));
			break;
		case 'Groupes'.COL_SERVEUR.','.COL_ID:
		   	$jeu = GContexte::LireVariablePost($nomContexte, COL_JEU.','.COL_ID);
		   	$mListe = new MListeServeurs();
		   	if ($jeu !== NULL)
			{
		   		$mListe->AjouterColSelection(COL_ID);
		   		$mListe->AjouterColSelection(COL_LIBELLE);
				$mListe->AjouterColOrdre(COL_LIBELLE);
				$mListe->AjouterFiltreEgal(COL_JEU, $jeu);
			   	$mListe->Charger();
		   	}
			GReferentiel::AjouterReferentiel($nomReferentiel, $mListe, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
			GReferentiel::GetDifferentielReferentielForSelect($nomReferentiel, COL_ID, array(COL_LIBELLE, COL_LIBELLE));
			break;
		case 'Groupes'.COL_TYPEGROUPE.','.COL_ID:
		   	$jeu = GContexte::LireVariablePost($nomContexte, COL_JEU.','.COL_ID);
		   	$mListe = new MListeTypesGroupes();
		   	if ($jeu !== NULL)
			{
		   		$mListe->AjouterColSelection(COL_ID);
		   		$mListe->AjouterColSelection(COL_LIBELLE);
				$mListe->AjouterColOrdre(COL_LIBELLE);
				$mListe->AjouterFiltreEgal(COL_JEU, $jeu);
			   	$mListe->Charger();
		   	}
			GReferentiel::AjouterReferentiel($nomReferentiel, $mListe, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
			GReferentiel::GetDifferentielReferentielForSelect($nomReferentiel, COL_ID, array(COL_LIBELLE, COL_LIBELLE));
			break;
	}
}

?>
