<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeModificationPresentation3 extends SListe
{
	protected function InitialiserChamps()
	{
		$this->AjouterChamp('champ_1', '2', false, false);
	}

	public function AjouterElement($champ1)
	{
		$element = array();
		$this->SetElemValeurChamp($element, 'champ_1', $champ1);
		$this->elements[] = $element;
	}

	protected function HasDroitConsultation($element)
	{
		return true;
	}

	protected function HasDroitModification($element)
	{
		return false;
	}

	protected function HasDroitCreation()
	{
		return false;
	}

	protected function HasDroitSuppression($element)
	{
		return false;
	}

	protected function ConstruireLigneTitre()
	{
	   	return NULL;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$elem->Attach($this->ConstruireChamp('champ_1'));

		return $elem;
	}
}

?>