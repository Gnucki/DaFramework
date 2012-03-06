<?php

require_once 'cst.php';
require_once INC_SLISTE;


define ('LISTECLASS_ELEMTITRE','_liste_elemtitre');
define ('LISTECLASS_ELEMTITRECHAMP','_liste_elemtitrechamp');
define ('LISTECLASS_ELEMINDIC','_liste_elemindic');
define ('LISTECLASS_ELEMCONTENU','_liste_elemcontenu');


class SListeTitreContenu extends SListe
{
   	// Construction de l'élément en consultation.
	protected function ConstruireElemConsultation($titre = '', $contenu = '')
	{
	   	$elem = parent::ConstruireElemConsultation();

	   	$divTitre = new SBalise(BAL_DIV);
	   	$divTitre->AddClass(LISTE_JQ_ELEM_TITRE);
	   	$elemTitre = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRE.$this->Niveau());
	   	$elemTitre->AjouterClasse(LISTECLASS_ELEMTITRE.$this->Niveau());
	   	if ($titre === '' || is_string($titre))
	   	{
	   	   	$elemTitreChamp = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->AjouterClasse(LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
	   		$elemTitreChamp->SetText($titre);
	   		$elemTitre->Attach($elemTitreChamp);
	   	}
	   	else
	   	   	$elemTitre->Attach($titre);

		$divTitre->Attach($elemTitre);
		$elem->Attach($divTitre);

	   	$divContenu = new SBalise(BAL_DIV);
	   	$divContenu->AddClass(LISTE_JQ_ELEM_CONTENU);
		$elemContenu = new SElement($this->prefixIdClass.LISTECLASS_ELEMCONTENU.$this->Niveau());
	   	$elemContenu->AjouterClasse(LISTECLASS_ELEMCONTENU.$this->Niveau());
	   	$elemContenu->Attach($contenu);
		$divContenu->Attach($elemContenu);
		$elem->Attach($divContenu);

		return $elem;
	}

	// Construction de l'élément en modification.
	protected function ConstruireElemModification($titre = '', $contenu = '')
	{
	   	$elem = parent::ConstruireElemModification();

	   	if ($contenu != '')
		{
		   	$divTitre = new SBalise(BAL_DIV);
		   	$divTitre->AddClass(LISTE_JQ_ELEM_TITRE);
		   	$elemTitre = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRE.$this->Niveau());
		   	$elemTitre->AjouterClasse(LISTECLASS_ELEMTITRE.$this->Niveau());
		   	if ($titre === '' || is_string($titre))
		   	{
		   	   	$elemTitreChamp = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
		   		$elemTitreChamp->AjouterClasse(LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
		   		$elemTitreChamp->SetText($titre);
		   		$elemTitre->Attach($elemTitreChamp);
		   	}
		   	else
		   	   	$elemTitre->Attach($titre);

			$divTitre->Attach($elemTitre);
			$elem->Attach($divTitre);

		   	$divContenu = new SBalise(BAL_DIV);
		   	$divContenu->AddClass(LISTE_JQ_ELEM_CONTENU);
			$elemContenu = new SElement($this->prefixIdClass.LISTECLASS_ELEMCONTENU.$this->Niveau());
		   	$elemContenu->AjouterClasse(LISTECLASS_ELEMCONTENU.$this->Niveau());
		   	$elemContenu->Attach($contenu);
			$divContenu->Attach($elemContenu);
			$elem->Attach($divContenu);
		}

		return $elem;
	}

	// Construction de l'élément en création.
	protected function ConstruireElemCreation($titre = '', $contenu = '')
	{
	   	$elem = parent::ConstruireElemCreation();

	   	if ($contenu != '')
		{
		   	$divTitre = new SBalise(BAL_DIV);
		   	$divTitre->AddClass(LISTE_JQ_ELEM_TITRE);
		   	$elemTitre = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRE.$this->Niveau());
		   	$elemTitre->AjouterClasse(LISTECLASS_ELEMTITRE.$this->Niveau());
		   	if ($titre === '' || is_string($titre))
		   	{
		   	   	$elemTitreChamp = new SElement($this->prefixIdClass.LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
		   		$elemTitreChamp->AjouterClasse(LISTECLASS_ELEMTITRECHAMP.$this->Niveau());
		   		$elemTitreChamp->SetText($titre);
		   		$elemTitre->Attach($elemTitreChamp);
		   	}
		   	else
		   	   	$elemTitre->Attach($titre);

			$divTitre->Attach($elemTitre);
			$elem->Attach($divTitre);

		   	$divContenu = new SBalise(BAL_DIV);
		   	$divContenu->AddClass(LISTE_JQ_ELEM_CONTENU);
			$elemContenu = new SElement($this->prefixIdClass.LISTECLASS_ELEMCONTENU.$this->Niveau());
		   	$elemContenu->AjouterClasse(LISTECLASS_ELEMCONTENU.$this->Niveau());
		   	$elemContenu->Attach($contenu);
			$divContenu->Attach($elemContenu);
			$elem->Attach($divContenu);
		}

		return $elem;
	}
}

?>