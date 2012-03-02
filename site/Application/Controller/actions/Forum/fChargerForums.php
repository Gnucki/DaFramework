<?php

require_once 'cst.php';
require_once PATH_METIER.'mListeForumsCategories.php';
require_once PATH_COMPOSANTS.'cListeCategories.php';


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
   	$prefixIdClass = PIC_FOR;
	$cListe = new CListeCategories($prefixIdClass, 'Categories', $nomContexte);

	$mListeForums = new MListeForums();
	$mListeForums->AjouterColSelection(COL_ID);
	$mListeForums->AjouterColSelection(COL_NOM);
	$mListeForums->AjouterColSelection(COL_DESCRIPTION);
	$mListeForums->AjouterColSelection(COL_CATEGORIE);
	$numJointure = $mListeForums->AjouterJointure(COL_CATEGORIE, COL_ID);
	$mListeForums->AjouterColSelectionPourJointure($numJointure, COL_NOM);
	$mListeForums->AjouterColSelectionPourJointure($numJointure, COL_ICONE);
	$mListeForums->AjouterFiltreEgal(COL_FORUM, SQL_NULL);
	$mListeForums->AjouterFiltreEgal(COL_GROUPE, GSession::Groupe(COL_ID));

	$mListeCategories = $mListeForums->ExtraireListe(COL_CATEGORIE);
	foreach ($mListeCategories->GetListe() as $mCategorie)
	{
		$mListeForumsPourCategorie = new MListeForums();
		foreach ($mListeForums->GetListe() as $mForum)
		{
			if ($mCategorie->Id() === $mForum->Categorie()->Id())
				$mListeForumsPourCategorie->AjouterElement($mForum);
		}
		$mCategorie->ListeForums($mListeForumsPourCategorie);
	}

	$cListe->InjecterListeObjetsMetiers($mListeCategories);

	if ($dejaCharge === false)
	    GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cListe);
	else
	   	GContexte::AjouterListe($cListe);
}

?>
