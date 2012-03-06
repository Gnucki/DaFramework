<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeJeux.php';
require_once PATH_METIER.'mListeGroupes.php';


switch (GReferentiel::NomReferentielGeneral($nomReferentiel))
{
	case COL_JEU:
	   	$valeur = GSession::LirePost('valeur');
	   	$mListe = new MListeJeux();
		$mListe->AjouterColSelection(COL_ID);
		$mListe->AjouterColSelection(COL_LIBELLE);
		$mListe->AjouterFiltreLike(COL_LIBELLE, '%'.$valeur.'%');
		$mListe->AjouterColOrdre(COL_LIBELLE);
		if ($valeur != NULL)
		   	$mListe->Charger(20);
		GReferentiel::AjouterReferentiel($nomReferentiel, $mListe, array(COL_ID, array(COL_LIBELLE, COL_LIBELLE)), true);
		GReferentiel::GetDifferentielReferentielForSelect($nomReferentiel, COL_ID, array(COL_LIBELLE, COL_LIBELLE));
		break;
	case COL_GROUPE:
	   	$valeur = GSession::LirePost('valeur');
	   	if ($valeur !== GSession::Groupe(COL_NOM))
		{
		   	$jeuId = GSession::Jeu(COL_ID);
		   	$mListe = new MListeGroupes();
			$mListe->AjouterColSelection(COL_ID);
			$mListe->AjouterColSelection(COL_NOM);
			$mListe->AjouterColSelection(COL_DESCRIPTION);
			$mListe->AjouterColSelection(COL_JEU);
			$mListe->AjouterFiltreLike(COL_NOM, '%'.$valeur.'%');
			if ($jeuId != NULL)
				$mListe->AjouterFiltreEgal(COL_JEU, $jeuId);
			$numJointure = $mListe->AjouterJointure(COL_JEU, COL_ID);
			$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure);
			$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE);

			$mListe->AjouterColOrdre(COL_NOM);
			if ($valeur != NULL)
			   	$mListe->Charger(20);
			GReferentiel::AjouterReferentiel($nomReferentiel, $mListe, array(COL_ID, COL_NOM, COL_DESCRIPTION, COL_JEU), true);
			GReferentiel::GetDifferentielReferentielForSelect($nomReferentiel, COL_ID, COL_NOM, COL_DESCRIPTION, NULL, COL_JEU, array(COL_JEU, COL_LIBELLE, COL_LIBELLE));
		}
		break;
}

?>
