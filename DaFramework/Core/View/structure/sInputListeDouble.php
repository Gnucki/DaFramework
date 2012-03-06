<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SLISTE;


define ('INPUTLISTEDB', '_inputlistedb');
define ('INPUTLISTEDB_DISPO', '_inputlistedb_dispo');
define ('INPUTLISTEDB_SEL', '_inputlistedb_sel');

define ('INPUTLISTEDB_JQ', 'jq_input_listedb');
define ('INPUTLISTEDB_JQ_DISPO', 'jq_input_listedb_dispo');
define ('INPUTLISTEDB_JQ_SEL', 'jq_input_listedb_sel');
define ('INPUTLISTEDB_JQ_RETOUR', 'jq_input_listedb_retour');
define ('INPUTLISTEDB_JQ_INFO', 'jq_input_listedb_info');
define ('INPUTLISTEDB_JQ_ERREUR', 'jq_input_listedb_erreur');
define ('LISTEINPUTLISTEDB_JQ', 'jq_liste_input_listedb');

define ('INPUTLISTEDB_TYPE_LISTE', 'liste');

// Input de type liste double.
class SInputListeDouble extends SElemOrg
{
   	protected $prefixIdClass;
   	protected $typeLiaison;
   	protected $niveau;

	public function __construct($prefixIdClass, $type = '', $oblig = false, $retour = '', $info = '', $erreur = '', $niveau = '')
	{
	   	$this->prefixIdClass = $prefixIdClass;
	   	$this->niveau = $niveau;

	   	parent::__construct(1, 2, $this->prefixIdClass.INPUTLISTEDB.$this->niveau, true, true, false);
	   	$this->AjouterClasse(INPUTLISTEDB.$this->niveau);

		if ($oblig == true)
			$this->AddClass('jq_input_form_oblig');

		switch ($type)
		{
		   	case INPUTLISTEDB_TYPE_LISTE:
		   		$this->AddClass(LISTEINPUTLISTEDB_JQ);
		   		break;
			default:
				$this->AddClass(INPUTLISTEDB_JQ);
		}

		$this->typeLiaison = 'ild_'.strval(mt_rand());

		// Retour.
		if ($retour !== '')
		{
			$divRetour = new SBalise(BAL_DIV);
			$divRetour->SetText(strval($retour));
			$divRetour->AddClass(INPUTLISTEDB_JQ_RETOUR);
			$this->Attach($divRetour);
		}

		// Info.
		if ($info !== '')
		{
			$divInfo = new SBalise(BAL_DIV);
			$elemInfo = new SElement(CLASSCADRE_INFO, false);
			$elemInfo->SetText($info);
			$divInfo->AddClass(INPUTLISTEDB_JQ_INFO);
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
			$divErreur->AddClass(INPUTLISTEDB_JQ_ERREUR);
			$divErreur->Attach($elemErreur);
			$divErreur->AddStyle('display: none;');
			$this->Attach($divErreur);
		}
	}

	public function AjouterListeDispo(SListe &$sListe, $label = '')
	{

	   	$sListe->Triable($this->typeLiaison, '', '', '');
	   	$elem = new SElement($this->prefixIdClass.INPUTLISTEDB_DISPO.$this->niveau);
	   	$elem->AjouterClasse(INPUTLISTEDB_DISPO.$this->niveau);
	   	$elem->AddClass(INPUTLISTEDB_JQ_DISPO);
	   	if ($label === '')
	   		$label = GSession::Libelle(LIB_FOR_DISPO, true, true);
	   	$input = new SInputLabel($this->prefixIdClass, $label, $sListe, INPUTLABELPLACE_HAUT, false, true, $this->niveau, true, false);
		$elem->Attach($input);
	   	$this->AttacherCellule(1, 1, $elem);
	}

	public function AjouterListeSel(SListe &$sListe, $label = '')
	{
	   	$sListe->Triable($this->typeLiaison, '', '', '');
	   	$elem = new SElement($this->prefixIdClass.INPUTLISTEDB_SEL.$this->niveau);
	   	$elem->AjouterClasse(INPUTLISTEDB_SEL.$this->niveau);
	   	$elem->AddClass(INPUTLISTEDB_JQ_SEL);
	   	if ($label === '')
	   		$label = GSession::Libelle(LIB_FOR_SEL, true, true);
	   	$input = new SInputLabel($this->prefixIdClass, $label, $sListe, INPUTLABELPLACE_HAUT, false, true, $this->niveau, true, false);
		$elem->Attach($input);
	   	$this->AttacherCellule(1, 2, $elem);
	}
}