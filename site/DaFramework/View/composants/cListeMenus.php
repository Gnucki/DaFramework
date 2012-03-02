<?php

require_once 'cst.php';
require_once INC_SLISTE;


class CListeMenus extends SListe
{
	protected function InitialiserChamps()
	{
	   	$this->AjouterChamp(COL_ID, '-1', true, true);
		$this->AjouterChamp(array(COL_LIBELLE, COL_LIBELLE), '', false, false);
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
	   	$elem = parent::ConstruireElemConsultation();
	   	$elem->Attach($this->ConstruireChamp(array(COL_LIBELLE, COL_LIBELLE)));
		return $elem;
	}

	protected function ConstruireElemRetourInvisible(&$element)
	{
	   	$retourInvisible = 'contexte='.CONT_ORIENTATION.'&cf='.GSession::NumCheckFormulaire();

	   	foreach($this->champs as $nomChamp => $champ)
		{
	   		if ($champ[LISTE_CHAMPLISTE_RETOURINVISIBLE] === true)
			{
			   	if ($retourInvisible !== '')
			   		$retourInvisible .= '&';
	   			$retourInvisible .= GContexte::FormaterVariable(CONT_ORIENTATION, $nomChamp).'='.$element[$nomChamp][LISTE_ELEMENT_VALEURCONSULT];
	   		}
	   	}

	   	// On enregistre ce retour pour l'élément.
	   	$element[LISTE_ELEMENT_RETOUR] = to_html($retourInvisible);

	   	$divRetInv = new SBalise(BAL_DIV);
	   	$divRetInv->AddClass(LISTE_JQ_ELEMENT_PARAM);
	   	$divRetInv->SetText($element[LISTE_ELEMENT_RETOUR]);
	   	return $divRetInv;
	}

	protected function ConstruireElemFonctionJSOnClick($elem, $element)
	{
	   	if ($this->foncJsOnClick === '')
	   	{
	   		$divFonc = new SBalise(BAL_DIV);
			$divFonc->AddClass(LISTE_JQ_ELEMENT_FONCTION);
			$divFonc->AddProp(PROP_STYLE, 'display:none');
			$divFonc->SetText(AJAXFONC_AJOUTERAUCONTEXTE);
			$elem->Attach($divFonc);
	   	}
	   	else
	   	   	parent::ConstruireElemFonctionJSOnClick($elem, $element);
	}
}

?>