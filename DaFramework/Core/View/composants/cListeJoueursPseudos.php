<?php

require_once 'cst.php';
require_once INC_SLISTEREFERENTIEL;
require_once PATH_METIER.'mListeJoueurs.php';


class CListeJoueursPseudos extends SListeReferentiel
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
	   	$autresDonnees = array();
	   	$autresDonnees[LISTE_AUTRESDONNEES_SELECTCOLID] = COL_PSEUDO;
	   	$autresDonnees[LISTE_AUTRESDONNEES_SELECTCOLLIB] = COL_PSEUDO;
	   	$this->AjouterChamp(COL_PSEUDO, '', false, false, LISTE_INPUTTYPE_FIND, LISTE_INPUTTYPE_FIND, NULL, NULL, $autresDonnees);
	}

	protected function InitialiserReferentiels()
	{
		$mListe = new MListeJoueurs();
		$mListe->AjouterColSelection(COL_PSEUDO);
		$mListe->AjouterColOrdre(COL_PSEUDO);
		$this->AjouterReferentiel(COL_PSEUDO, $mListe, array(COL_PSEUDO), true);
	}

	protected function ConstruireLigneTitre()
	{
		return NULL;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$org = new SOrganiseur(1, 1, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_PSEUDO));
	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}

	protected function ConstruireElemCreation()
	{
	   	$elem = parent::ConstruireElemCreation();

	   	$org = new SOrganiseur(1, 1, true);
	   	$org->AttacherCellule(1, 1, $this->ConstruireChamp(COL_PSEUDO, LISTE_CHAMPTYPE_CREAT));
	   	$org->SetLargeurCellule(1, 1, '100%');
	   	$elem->Attach($org);

		return $elem;
	}
}

?>