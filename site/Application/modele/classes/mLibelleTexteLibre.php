<?php

require_once 'cst.php';
require_once PATH_METIER.'mLibelleTexte.php';


class MLibelleTexteLibre extends MLibelleTexte
{
   	public function GetNom()
	{
	   	return 'MLibelleTexteLibre';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_LIBELLETEXTELIBRE);
	}

	/*************************************/
	public function Ajouter()
	{
	   	// On inscrit le nouveau libellé dans la base.
		$retour = parent::Ajouter();

		if ($retour !== false)
		{
			// On copie le libellé pour toutes les autres langues.
	 		$mListeLibelles = new MListeLibellesTextesLibres();
			$mListeLibelles->AjouterJointure(COL_LANGUE, COL_ID, 0, SQL_CROSS_JOIN);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_ID, COL_ID);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LIBELLE, COL_LIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_TYPELIBELLE, COL_TYPELIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LANGUEORIGINELLE, COL_LANGUEORIGINELLE);
		 	$mListeLibelles->AjouterColInsertionExt(1, COL_LANGUE, COL_ID);
		 	$mListeLibelles->AjouterFiltreEgal(COL_ID, $this->Id());
		 	$mListeLibelles->AjouterFiltreDifferentPourJointure(1, COL_ID, GSession::Langue(COL_ID));
		 	$retour = $mListeLibelles->Ajouter();
		}

		return $retour;
	}

	public function Modifier()
	{
	   	$retour = false;

	   	$colCond = $this->bufferColCond;
	   	if ($this->Id() !== NULL || $colCond !== NULL)
		{
		   	if ($colCond === NULL)
			{
			   	$this->AjouterColCondition(COL_ID);
			   	$this->AjouterColCondition(COL_LANGUE);
			}
			if ($this->Langue()->Id() === NULL)
				$this->Langue()->Id(GSession::Langue(COL_ID));
			$this->LangueOriginelle()->Id($this->Langue()->Id());

			// On ne modifie le libellé que pour notre langue.
			$retour = parent::Modifier();

			if ($retour !== false)
			{
				// On modifie le libellé pour toutes les autres langues qui ont comme langue d'origine notre langue.
		 		$mListeLibelles = new MListeLibellesTextesLibres();
			 	$mListeLibelles->AjouterColModification(COL_LIBELLE, $this->Libelle());
			 	$mListeLibelles->AjouterColModification(COL_TYPELIBELLE, $this->TypeLibelle()->Id());
			 	$mListeLibelles->AjouterFiltreEgal(COL_ID, $this->Id());
				$mListeLibelles->AjouterFiltreEgal(COL_LANGUEORIGINELLE, $this->Langue()->Id());
			 	$retour = $mListeLibelles->Modifier();
			}

		}

		return $retour;
	}
}

?>