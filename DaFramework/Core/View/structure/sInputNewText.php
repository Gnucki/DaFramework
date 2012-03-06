<?php

require_once 'cst.php';
require_once INC_SINPUTNEW;


// Input de type text avec un ou plusieurs formulaires popup.
class SInputNewText extends SInputNew
{
	public function __construct($prefixIdClass, $oblig = false, $retour = '', $valeurParDefaut = '', $longueurMin = -1, $longueurMax = -1, $taille = -1, $tailleAuto = false, $unite = '', $info = '', $erreur = '', $formatValide = '', $min = NULL, $max = NULL, $niveau = '')
	{
	   	$this->text = new SInputText($prefixIdClass.INPUTNEW, INPUTTEXT_TYPE_NEW, $oblig, $retour, $valeurParDefaut, $longueurMin, $longueurMax, $taille, $tailleAuto, $unite, $info, $erreur, $formatValide, $min, $max, $niveau);

		parent::__construct($prefixIdClass, INPUTNEW_TYPE_TEXT, $oblig, $niveau);
	}
}