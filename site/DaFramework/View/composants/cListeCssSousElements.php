<?php

require_once 'cst.php';
require_once INC_SLISTEPLIANTESTATIQUE;


class CListeCssSousElements extends SListePlianteStatique
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_LIBELLE, '', false, false);
		$this->AjouterChamp('cligno', '', false, false);
		$this->AjouterChamp(COL_CONTENU, '', false, false, NULL, NULL, NULL, NULL, NULL, false);
	}

	public function AjouterElement($libelle, $contenu, $clignotement = false)
	{
		$element = array();
		$this->SetElemValeurChamp($element, COL_LIBELLE, $libelle);
		$this->SetElemValeurChamp($element, COL_CONTENU, $contenu);
		$this->SetElemValeurChamp($element, 'cligno', $clignotement);
		$this->elements[] = $element;
	}

	protected function HasDroitConsultation($element)
	{
		return true;
	}

	protected function ConstruireLigneTitre()
	{
		return NULL;
	}

	protected function ConstruireElemConsultation(&$element)
	{
	   	$elem = parent::ConstruireElemConsultation($element, $this->GetElemChampValeurConsultation($element, COL_LIBELLE), $this->GetElemChampValeurConsultation($element, COL_CONTENU));
		if ($this->GetElemChampValeurConsultation($element, 'cligno') === true)
		{
		   	$elem->AddClass(VISUALISEUR_JQ_CLIGNOTEMENT);
		   	$div = new SBalise(BAL_DIV);
			$div->AddClass(VISUALISEUR_JQ_CLIGNOTEMENT_INFOPP);
		   	$div->AddStyle('display:none;');
		   	$div->SetText(GSession::Libelle(LIB_PRS_SEPREMIERPLAN, true, true));
		   	$elem->Attach($div);

		   	$div = new SBalise(BAL_DIV);
			$div->AddClass(BAL_DIV);
			$div->AddClass(VISUALISEUR_JQ_CLIGNOTEMENT_INFOAP);
		   	$div->AddStyle('display:none;');
		   	$div->SetText(GSession::Libelle(LIB_PRS_SESECONDPLAN, true, true));
		   	$elem->Attach($div);

		   	$div = new SBalise(BAL_DIV);
			$div->AddClass(VISUALISEUR_JQ_CLIGNOTEMENT_INFO.'20');
		   	$div->AddStyle('display:none;');
		   	$div->SetText(GSession::Libelle(LIB_PRS_CLIGNO20, true, true));
		   	$elem->Attach($div);

		   	$div = new SBalise(BAL_DIV);
			$div->AddClass(VISUALISEUR_JQ_CLIGNOTEMENT_INFO.'30');
		   	$div->AddStyle('display:none;');
		   	$div->SetText(GSession::Libelle(LIB_PRS_CLIGNO30, true, true));
		   	$elem->Attach($div);

		   	$div = new SBalise(BAL_DIV);
			$div->AddClass(VISUALISEUR_JQ_CLIGNOTEMENT_INFO.'40');
		   	$div->AddStyle('display:none;');
		   	$div->SetText(GSession::Libelle(LIB_PRS_CLIGNO40, true, true));
		   	$elem->Attach($div);

		   	$div = new SBalise(BAL_DIV);
			$div->AddClass(VISUALISEUR_JQ_CLIGNOTEMENT_INFO.'45');
		   	$div->AddStyle('display:none;');
		   	$div->SetText(GSession::Libelle(LIB_PRS_CLIGNO45, true, true));
		   	$elem->Attach($div);
		}
		return $elem;
	}
}

?>