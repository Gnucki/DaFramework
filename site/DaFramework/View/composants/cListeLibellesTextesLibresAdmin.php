<?php

require_once 'cst.php';
require_once INC_SLISTE;
require_once PATH_COMPOSANTS.'cListeLibellesLibresAdmin.php';


class CListeLibellesTextesLibresAdmin extends CListeLibellesLibresAdmin
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '', true, true, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT);
	   	$this->AjouterChamp(COL_LANGUE, '', true, true);
	   	$autresDonnees = array();
		$autresDonnees[LISTE_AUTRESDONNEES_TEXTTAILLE] = 5;
		$autresDonnees[LISTE_AUTRESDONNEES_CHAMPFORMATE] = FORMATTEXTE_SIMPLE;
		$this->AjouterChamp(COL_LIBELLE, '', false, false, LISTE_INPUTTYPE_TEXT, LISTE_INPUTTYPE_TEXT, NULL, NULL, $autresDonnees);
		$this->AjouterChamp(array(COL_TYPELIBELLE, COL_ID), '', false, false, LISTE_INPUTTYPE_SELECT, LISTE_INPUTTYPE_SELECT);
		$this->AjouterChamp(array(COL_TYPELIBELLE, COL_LIBELLE, COL_LIBELLE), '', false, false);
		$this->AjouterChamp(array(COL_LANGUEORIGINELLE, COL_LIBELLE, COL_LIBELLE), '', false, false);
	}
}

?>