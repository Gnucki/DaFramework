<?php

require_once 'cst.php';
require_once INC_SLISTEPLIANTE;
require_once PATH_COMPOSANTS.'cListeMenus.php';


class CListeMenusPliants extends SListePliante
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
		$this->AjouterChamp(COL_LIBELLE, '', false, false);
		$this->AjouterChamp(COL_MENU, '', false, false, NULL, NULL, NULL, NULL, NULL, false);
	}

	public function AjouterElement($id, $libelle, $menus)
	{
		$element = array();
		$this->SetElemValeurChamp($element, COL_ID, $id);
		$this->SetElemValeurChamp($element, COL_LIBELLE, $libelle);
		$this->SetElemValeurChamp($element, COL_MENU, $menus);
		$this->elements[] = $element;
	}

	public function Niveau($niveau = -1)
	{
	   	if ($this->niveau === -1 || $niveau !== -1)
	   	{
			$niveau++;
			$listeParente = $this->GetListeParente();
			if ($listeParente !== NULL)
				$niveau = $listeParente->Niveau($niveau);
			$this->niveau = $niveau;
		}

		if ($this->niveau < 5)
		   	$this->niveau += 5;
		return $this->niveau;
	}

	protected function HasDroitConsultation($element)
	{
		return true;
	}

	protected function ConstruireLigneTitre()
	{
		return NULL;
	}

	protected function ConstruireElemConsultation()
	{
	   	$elem = parent::ConstruireElemConsultation($this->ConstruireChamp(COL_LIBELLE), $this->ConstruireChamp(COL_MENU));
		return $elem;
	}
}

?>