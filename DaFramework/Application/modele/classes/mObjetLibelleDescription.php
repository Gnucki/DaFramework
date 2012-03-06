<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelle.php';


class MObjetLibelleDescription extends MObjetLibelle
{
	public function __construct($id = NULL, $libelle = NULL, $description = NULL, $libelleId = NULL, $descriptionId = NULL, $langueId = NULL, $typeLibelleId = NULL)
	{
		$this->SetObjet($id, $libelle, $description, $libelleId, $descriptionId, $langueId, $typeLibelleId);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $description = NULL, $libelleId = NULL, $descriptionId = NULL, $langueId = NULL, $typeLibelleId = NULL)
	{
		parent::SetObjet($id, $libelle, $libelleId, $langueId, $typeLibelleId);

		$this->Description($description, $descriptionId, $langueId, $typeLibelleId);
	}

	public function GetNom()
	{
	   	return 'MObjetLibelleDescription';
	}

	/*************************************/
	public function Description($libelle = NULL, $id = -1, $langueId = NULL, $typeLibelleId = NULL)
	{
		$mLibelle = $this->ValeurObjetVerifiee(COL_DESCRIPTION, 'MLibelle', NULL, false, $id, $libelle, $langueId, $typeLibelleId);

		if ($mLibelle !== NULL && !is_int($mLibelle))
		   	return $mLibelle->Libelle();
		else
		   	return NULL;
	}

	public function DescriptionId()
	{
		$mLibelle = $this->ValeurObjetVerifiee(COL_DESCRIPTION, 'MLibelle', NULL, false, -1);

		if ($mLibelle !== NULL && !is_int($mLibelle))
		   	return $mLibelle->Id();
		else
		   	return NULL;
	}

	public function DescriptionObj()
	{
		$mLibelle = $this->ValeurObjetVerifiee(COL_DESCRIPTION, 'MLibelle', NULL, false, -1);

		if ($mLibelle !== NULL && !is_int($mLibelle))
		   	return $mLibelle;
		else
		   	return NULL;
	}

	/*************************************/
	public function Ajouter()
	{
	   	// Ouverture de la transaction si on ne l'ai pas déjà.
	   	$dejaEnTransaction = GBase::EstEnTransaction();
	   	if ($dejaEnTransaction === false)
	   	   	GBase::DemarrerTransaction();

	   	// On inscrit le nouveau libellé dans la base avec l'id max + 1 comme id.
	   	$mLibelle = $this->DescriptionObj();
	   	$mLibelle->AjouterColInsertionMax(COL_ID, 1);
		$retour = $mLibelle->Ajouter();

	   	if ($retour !== false)
		{
		   	// On récupère l'id max qui est l'id de notre libellé.
		   	$mLibelle->AjouterColSelectionMax(COL_ID);
		   	$retour = $mLibelle->Charger();

			if ($retour !== false)
			{
			   	// Fermeture de la transaction si on ne l'était pas déjà.
			   	if ($dejaEnTransaction === false)
			   	   	GBase::ValiderTransaction();

			 	// On copie le libellé pour toutes les autres langues.
			 	$mListeLibelles = new MListeLibelles();
			 	$mListeLibelles->AjouterJointure(COL_LANGUE, COL_ID, 0, SQL_CROSS_JOIN);
			 	$mListeLibelles->AjouterColInsertionExt(0, COL_ID, COL_ID);
			 	$mListeLibelles->AjouterColInsertionExt(0, COL_LIBELLE, COL_LIBELLE);
			 	$mListeLibelles->AjouterColInsertionExt(0, COL_TYPELIBELLE, COL_TYPELIBELLE);
			 	$mListeLibelles->AjouterColInsertionExt(0, COL_LANGUEORIGINELLE, COL_LANGUEORIGINELLE);
			 	$mListeLibelles->AjouterColInsertionExt(1, COL_LANGUE, COL_ID);
			 	$mListeLibelles->AjouterFiltreEgal(COL_ID, $mLibelle->Id());
			 	$mListeLibelles->AjouterFiltreDifferentPourJointure(1, COL_ID, GSession::Langue(COL_ID));
			 	$mListeLibelles->Ajouter();

			   	$this->Libelle(NULL, $mLibelle->Id());
			   	// On ajoute ensuite l'objet normalement.
			   	return parent::Ajouter();
			}
		}

		if ($dejaEnTransaction === false)
		   	GBase::AnnulerTransaction();

		return $retour;
	}

	public function Modifier()
	{
	   	$langueId = GSession::Langue(COL_ID);
	   	$mLibelle = NULL;

	   	// On ne modifie le libellé que pour notre langue.
	   	if ($this->Libelle() !== NULL && $langueId !== NULL)
		{
		   	$mLibelle = $this->AjouterJointure(COL_DESCRIPTION, COL_ID);
		   	if ($mLibelle->Langue()->Id() !== NULL)
		   		$langueId = $mLibelle->Langue()->Id();
		   	$mLibelle->LangueOriginelle()->Id($langueId);
		   	$mLibelle->AjouterColModification(COL_LIBELLE);
		   	$mLibelle->AjouterColModification(COL_LANGUEORIGINELLE);
			$mLibelle->AjouterColCondition(COL_LANGUE, $langueId);
			$mLibelle->ModifierSurJointure(true);
		}

		$retour = parent::Modifier();

		if ($retour !== false && $mLibelle !== NULL && $langueId !== NULL)
		{
			// On modifie le libellé pour toutes les autres langues qui ont comme langue d'origine notre langue.
		 	$mListeLibelles = new MListeLibelles();
			$mListeLibelles->AjouterColModification(COL_LIBELLE, $mLibelle->Libelle());
			$mListeLibelles->AjouterFiltreEgal(COL_ID, $mLibelle->Id());
			$mListeLibelles->AjouterFiltreEgal(COL_LANGUEORIGINELLE, $langueId);
			$mListeLibelles->AjouterFiltreDifferent(COL_LANGUE, $langueId);
			$retour = $mListeLibelles->Modifier();
		}

		return $retour;
	}

	public function Supprimer()
	{
	   	// On supprime le libellé dans toutes les langues.
	   	$mLibelle = $this->AjouterJointure(COL_DESCRIPTION, COL_ID);
	   	$mLibelle->SupprimerSurJointure(true);

	   	return parent::Supprimer();
	}

	public function AjouterColSelection($col, $as = NULL, &$bufferColSelExt = NULL)
	{
	   	if ($col === COL_DESCRIPTION)
		{
		   	if ($this->bufferColSel === NULL)
		   	   	$this->bufferColSel = array();
		   	$mLibelle = $this->AjouterJointure(COL_DESCRIPTION, COL_ID);
	   		$mLibelle->AjouterColSelection(COL_ID, COL_DESCRIPTION.COL_ID);
	   		$mLibelle->AjouterColSelection(COL_LIBELLE, COL_DESCRIPTION.COL_LIBELLE);
	   		$mLibelle->AjouterColCondition(COL_LANGUE, GSession::Langue(COL_ID));
	   	}
	   	else
	   	   	parent::AjouterColSelection($col, $as, $bufferColSelExt);
	}

	public function AjouterColOrdre($col, $ordre)
	{
	   	if ($col === COL_DESCRIPTION)
		{
		   	$mLibelle = $this->ValeurObjetVerifiee(COL_DESCRIPTION, 'MLibelle');
		   	$mLibelle->AjouterColOrdre($col, $ordre);
		}
		else
		   	parent::AjouterColOrdre($nom, $ordre);
	}

	public function AjouterBaseColSelection($bObjetBase, $col, $as)
	{
	   	if ($col === COL_DESCRIPTION)
		{
	   		$bObjetBase->AjouterJointure(COL_DESCRIPTION, $this->LibelleObj()->GetObjetBase(), COL_ID);
	   		$bObjetBase->AjouterColSelect(COL_ID, COL_DESCRIPTION.COL_ID);
	   		$bObjetBase->AjouterColSelect(COL_LIBELLE, COL_DESCRIPTION.COL_LIBELLE);
	   		$bObjetBase->AjouterColWhere(COL_LANGUE, GSession::Langue(COL_ID));
	   	}
	   	else
	   	   	parent::AjouterBaseColSelection($bObjetBase, $col, $as);
	}

	public function AjouterBaseColModification($bObjetBase, $col, $valeur)
	{
	   	if ($col !== COL_DESCRIPTION)
	   	   	parent::AjouterBaseColModification($bObjetBase, $col, $valeur);
	}
}

?>