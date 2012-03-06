<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelle.php';


class MObjetLibelleOrdre extends MObjetLibelle
{
	public function __construct($id = NULL, $libelle = NULL, $ordre = NULL, $libelleId = NULL, $langueId = NULL, $typeLibelleId = NULL)
	{
		$this->SetObjet($id, $libelle, $ordre, $libelleId, $langueId, $typeLibelleId);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $ordre = NULL, $libelleId = NULL, $langueId = NULL, $typeLibelleId = NULL)
	{
		parent::SetObjet($id, $libelle, $libelleId, $langueId, $typeLibelleId);

		$this->Ordre($ordre);
	}

	public function GetNom()
	{
	   	return 'MObjetLibelleOrdre';
	}

	/*************************************/
	public function Ordre($ordre = NULL)
	{
		return $this->ValeurIntVerifiee(COL_ORDRE, $ordre, 0, NULL, NULL, true);
	}

	/*************************************/
	public function Ajouter()
	{
	   	// On ajoute l'objet avec comme ordre l'ordre max + 1.
	   	$this->AjouterColInsertionMax(COL_ORDRE, 1);
	   	return parent::Ajouter();
	}

	public function Modifier()
	{
	   	// Ouverture de la transaction si on ne l'ai pas déjà.
	   	$dejaEnTransaction = GBase::EstEnTransaction();
	   	if ($dejaEnTransaction === false)
	   	   	GBase::DemarrerTransaction();

	   	$retour = true;
	    $ancienOrdre = NULL;
	   	$nouvelOrdre = $this->Ordre();

	   	if ($nouvelOrdre !== NULL)
		{
		   	// On récupère l'ordre de l'élément.
		   	$this->AjouterColSelection(COL_ORDRE);
		   	$retour = $this->Charger();

		   	$ancienOrdre = $this->Ordre();
		   	$this->Ordre($nouvelOrdre);
		}

	   	if ($ancienOrdre === NULL && $nouvelOrdre !== NULL)
		{
	   		GLog::LeverException(EXM_0214, $this->GetNom().'::Modifier, impossible de récupérer l\'ordre de l\'élément d\'id ['.$this->Id().'].');
	   	   	$retour = false;
	   	}

	   	$log = true;
	   	// On modifie l'élément.
	   	if ($retour !== false)
	   	{
	   	   	$retour = parent::Modifier();

		   	// Si l'ordre de l'élément à changé, on modifie les éléments qui en sont impactés.
		   	if ($retour !== false && $nouvelOrdre !== NULL && $nouvelOrdre !== $ancienOrdre)
		   	{
		   	   	// On récupère la liste relative au type d'élément afin de modifier l'ordre si besoin.
			   	$mListe = $this->GetNouvelleListe();
			   	if ($mListe === NULL)
				{
					GLog::LeverException(EXM_0213, $this->GetNom().'::Modifier, impossible de récupérer un objet liste.');
			   	   	$retour = false;
			   	}
			   	else
			   	{
			   	   	// Si l'ancien ordre est supérieur au nouveau.
			   	   	if ($nouvelOrdre < $ancienOrdre)
					{
					   	$mListe->AjouterColModificationExt(0, COL_ORDRE, COL_ORDRE, 1);
						$mListe->AjouterFiltreEntre(COL_ORDRE, $nouvelOrdre, $ancienOrdre - 1);
						$mListe->AjouterFiltreDifferent(COL_ID, $this->Id());
						$retour = $mListe->Modifier();
			   	   	}
			   	   	// Si l'ancien ordre est inférieur au nouveau.
			   	   	else
			   	   	{
						$mListe->AjouterColModificationExt(0, COL_ORDRE, COL_ORDRE, -1);
						$mListe->AjouterFiltreEntre(COL_ORDRE, $ancienOrdre + 1, $nouvelOrdre);
						$mListe->AjouterFiltreDifferent(COL_ID, $this->Id());
						$retour = $mListe->Modifier();
					}
				}
			}
			else
			   	$log = false;
		}

		// Si on a créé nous même la transaction dans cette fonction, on commit ou rollback suivant le résultat.
	   	if ($dejaEnTransaction === false)
	   	{
	   	   	if ($retour === false)
		   	   	GBase::AnnulerTransaction();
		   	else
		   	   	GBase::ValiderTransaction();
		}

		if ($retour === false && $log === true)
			GLog::LeverException(EXM_0215, $this->GetNom().'::Modification, échec de la modification en base.');

		return $retour;
	}

	public function Supprimer()
	{
	   	// Ouverture de la transaction si on ne l'ai pas déjà.
	   	$dejaEnTransaction = GBase::EstEnTransaction();
	   	if ($dejaEnTransaction === false)
	   	   	GBase::DemarrerTransaction();

	   	// On récupère l'ordre de l'élément.
	   	$this->AjouterColSelection(COL_ORDRE);
	   	$retour = $this->Charger();

	   	// On récupère la liste relative au type d'élément afin de décrémenter l'ordre des éléments
	   	// possédant un ordre supérieur à celui qui va être supprimé.
	   	$mListe = $this->GetNouvelleListe();
	   	if ($mListe === NULL)
		{
			GLog::LeverException(EXM_0210, $this->GetNom().'::Supprimer, impossible de récupérer un objet liste.');
	   	   	$retour = false;
	   	}
	   	else if ($this->Ordre() === NULL)
		{
	   		GLog::LeverException(EXM_0211, $this->GetNom().'::Supprimer, impossible de récupérer l\'ordre de l\'élément d\'id ['.$this->Id().'].');
	   	   	$retour = false;
	   	}

	   	$log = true;
	   	// On supprime l'élément.
	   	if ($retour !== false)
	   	{
	   	   	$retour = parent::Supprimer();

		   	// On décrémente l'ordre des éléments possédant un ordre supérieur à celui qui a été supprimé.
		   	if ($retour !== false)
		   	{
				$mListe->AjouterColModificationExt(0, COL_ORDRE, COL_ORDRE, -1);
				$mListe->AjouterFiltreSuperieur(COL_ORDRE, $this->Ordre());
				$retour = $mListe->Modifier();
			}
			else
			   	$log = false;
		}

		// Si on a créé nous même la transaction dans cette fonction, on commit ou rollback suivant le résultat.
	   	if ($dejaEnTransaction === false)
	   	{
	   	   	if ($retour === false)
		   	   	GBase::AnnulerTransaction();
		   	else
		   	   	GBase::ValiderTransaction();
		}

		if ($retour === false && $log === true)
			GLog::LeverException(EXM_0212, $this->GetNom().'::Supprimer, échec de la suppression en base.');

		return $retour;
	}
}

?>