<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SLISTE;


define ('INPUTLISTE', '_inputliste');

define ('INPUTLISTE_JQ', 'jq_input_liste');
define ('INPUTLISTE_JQ_RETOUR', 'jq_input_liste_retour');
define ('INPUTLISTE_JQ_INFO', 'jq_input_liste_info');
define ('INPUTLISTE_JQ_ERREUR', 'jq_input_liste_erreur');
define ('LISTEINPUTLISTE_JQ', 'jq_liste_input_liste');

define ('INPUTLISTE_TYPE_LISTE', 'liste');


// Input de type liste.
class SInputListe extends SElement
{
   	protected $prefixIdClass;

	public function __construct($prefixIdClass, $type = '', $oblig = false, $retour = '', $info = '', $erreur = '', $niveau = '')
	{
	   	parent::__construct($prefixIdClass.INPUTLISTE.$niveau, true, true, false);
	   	$this->AjouterClasse(INPUTLISTE.$niveau);

		if ($oblig == true)
			$this->AddClass('jq_input_form_oblig');

		$this->prefixIdClass = $prefixIdClass;

		switch ($type)
		{
		   	case INPUTLISTE_TYPE_LISTE:
		   		$this->AddClass(LISTEINPUTLISTE_JQ);
		   		break;
			default:
				$this->AddClass(INPUTLISTE_JQ);
		}

		$this->typeLiaison = 'ild_'.strval(mt_rand());

		// Retour.
		if ($retour !== '')
		{
			$divRetour = new SBalise(BAL_DIV);
			$divRetour->SetText(strval($retour));
			$divRetour->AddClass(INPUTLISTE_JQ_RETOUR);
			$this->Attach($divRetour);
		}

		// Info.
		if ($info !== '')
		{
			$divInfo = new SBalise(BAL_DIV);
			$elemInfo = new SElement(CLASSCADRE_INFO, false);
			$elemInfo->SetText($info);
			$divInfo->AddClass(INPUTLISTE_JQ_INFO);
			$divInfo->Attach($elemInfo);
			$divInfo->AddStyle('display: none;');
			$this->Attach($divInfo);
		}

		// Erreur.
		if ($erreur !== '')
		{
			$divErreur = new SBalise(BAL_DIV);
			$elemErreur = new SElement(CLASSCADRE_ERREUR, false);
			$elemErreur->SetText($erreur);
			$divErreur->AddClass(INPUTLISTE_JQ_ERREUR);
			$divErreur->Attach($elemErreur);
			$divErreur->AddStyle('display: none;');
			$this->Attach($divErreur);
		}
	}

	public function AjouterListe(SListe &$sListe)
	{
	   	$this->Attach($sListe);
	}
}