<?php

require_once 'cst.php';
require_once INC_SINPUTNEW;


// Input de type select avec un ou plusieurs formulaires popup.
class SInputNewSelect extends SInputNew
{
	public function __construct($prefixIdClass, $oblig = false, $retour = '', $info = '', $erreur = '', $type = '', $impact = '', $dependance = '', $rechargeFonc = '', $rechargeParam = '', $changeFonc = '', $changeParam = '', $niveau = '')
	{
	   	$this->select = new SInputSelect($prefixIdClass/*.INPUTNEW*/, INPUTSELECT_TYPE_NEW, $oblig, $retour, $info, $erreur, $type, $impact, $dependance, $rechargeFonc, $rechargeParam, $changeFonc, $changeParam, $niveau);
		parent::__construct($prefixIdClass, INPUTNEW_TYPE_SELECT, $oblig, $niveau);
	}

	public function AjouterCategorie($id, $libelle)
	{
		$this->select->AjouterCategorie($id, $libelle);
	}

	public function AjouterElement($id, $libelle, $description = '', $valParDefaut = false)
	{
		$this->select->AjouterElement($id, $libelle, $description, $valParDefaut);
	}

	public function AjouterElementsFromListe($nomRef, $colId = COL_ID, $colLibelle = array(COL_LIBELLE, COL_LIBELLE), $colDescription = '', $idParDefaut = NULL)
	{
	   	$this->select->AjouterElementsFromListe($nomRef, $colId, $colLibelle, $colDescription, $idParDefaut);
	}
}