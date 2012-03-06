<?php

require_once 'cst.php';
require_once INC_SBALISE;

define ('XML_LISTE','liste');
define ('XML_AJOUT','ajout');
define ('XML_AUTRE','autre');
define ('XML_ELEMENT','element');
define ('XML_ID','id');
define ('XML_ORDRE','ordre');
define ('XML_TYPE','type');
define ('XML_VALEUR','valeur');

define ('XML_TYPE_CREATION','creat');
define ('XML_TYPE_MODIFICATION','modif');
define ('XML_TYPE_SUPPRESSION','suppr');

class SRechargeListe extends SBalise
{
	public function __construct()
	{
		parent::__construct(XML_LISTE);
	}

	protected function AjouterElement($id, $valeur, $type, $ordre = -1)
	{
		$element = new SBalise(XML_ELEMENT);
		$this->AjouterProp($element, $id, $valeur, $type, $ordre);

		$this->Attach($element);
	}

	protected function AjouterProp($element, $id, $valeur, $type = '', $ordre = -1)
	{
		$balId = new SBalise(XML_ID);
		$balId->SetText($id);

		$balValeur = new SBalise(XML_VALEUR);
		if ($valeur == NULL)
			$balValeur->SetText('');
		else
		   	$balValeur->Attach($valeur);

		$balType = new SBalise(XML_TYPE);
		$balType->SetText($type);

		$balOrdre = new SBalise(XML_ORDRE);
		$balOrdre->SetText($ordre);

		$element->Attach($balId);
		$element->Attach($balValeur);
		if ($type !== '')
		   	$element->Attach($balType);
		if ($ordre !== -1)
		   	$element->Attach($balOrdre);
	}

	public function AjouterElementCreation($id, $valeur, $ordre)
	{
		$this->AjouterElement($id, $valeur, XML_TYPE_CREATION, $ordre);
	}

	public function AjouterElementModification($id, $valeur)
	{
		$this->AjouterElement($id, $valeur, XML_TYPE_MODIFICATION);
	}

	public function AjouterElementSuppression($id)
	{
		$this->AjouterElement($id, NULL, XML_TYPE_SUPPRESSION);
	}

	public function AjouterAjout($id, $valeur)
	{
		$element = new SBalise(XML_AJOUT);
		$this->AjouterProp($element, $id, $valeur);

		$this->Attach($element);
	}

	public function AjouterAutre($id, $valeur)
	{
		$element = new SBalise(XML_AUTRE);
		$this->AjouterProp($element, $id, $valeur);

		$this->Attach($element);
	}
}

?>