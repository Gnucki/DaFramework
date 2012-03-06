<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelleDescription.php';


class MSuperGrade extends MObjetLibelleDescription
{
   	protected $mListeDroitsSuperGrades;

	public function __construct($id = NULL, $libelle = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $poidsVoteRecrutement = NULL)
	{
		$this->SetObjet($id, $libelle, $description, $icone, $niveau, $poidsVoteRecrutement);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $description = NULL, $icone = NULL, $niveau = NULL, $poidsVoteRecrutement = NULL)
	{
		parent::SetObjet($id, $libelle, $description, NULL, NULL, NULL, TYPELIB_DROIT);

		$this->Icone($icone);
		$this->Niveau($niveau);
		$this->PoidsVoteRecrutement($poidsVoteRecrutement);
		$this->mListeDroitsSuperGrades = NULL;
	}

	public function GetNom()
	{
	   	return 'MSuperGrade';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_SUPERGRADE);
	}

	/*************************************/
	public function Icone($icone = NULL)
	{
		$this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}

	public function Niveau($niveau = NULL)
	{
	   	return $this->ValeurIntVerifiee(COL_NIVEAU, $niveau, 0, NULL, 0, true);
	}

	public function PoidsVoteRecrutement($poidsVoteRecrutement = NULL)
	{
	   	return $this->ValeurIntVerifiee(COL_POIDSVOTERECRUTEMENT, $poidsVoteRecrutement, 0, NULL, 1, true);
	}

	public function ListeDroitsSuperGrades($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeDroitsSuperGrades !== NULL)
	   	   	$oldId = $this->mListeDroitsSuperGrades->GetFiltreValeur(0, COL_SUPERGRADE);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeDroitsSuperGrades !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeDroitsSuperGrades);
	   	}
	   	else if ($this->mListeDroitsSuperGrades === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeDroitsSuperGrades === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeDroitsSuperGrades = new MListeDroitsSuperGrades();
		   	   	$numJointureFonc = $this->mListeDroitsSuperGrades->AjouterJointure(COL_FONCTIONNALITE, COL_ID);
		   	   	$this->mListeDroitsSuperGrades->AjouterColSelectionPourJointure($numJointureFonc, COL_ID);
		   	   	$numJointure = $this->mListeDroitsSuperGrades->AjouterJointure(COL_LIBELLE, COL_ID, $numJointureFonc);
		   	   	$this->mListeDroitsSuperGrades->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_LIBELLE.COL_LIBELLE);
		   	   	$this->mListeDroitsSuperGrades->AjouterColOrdrePourJointure($numJointure, COL_LIBELLE);
				$this->mListeDroitsSuperGrades->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
		   	   	$numJointure = $this->mListeDroitsSuperGrades->AjouterJointure(COL_DESCRIPTION, COL_ID, $numJointureFonc);
		   	   	$this->mListeDroitsSuperGrades->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_DESCRIPTION.COL_LIBELLE);
		   	   	$this->mListeDroitsSuperGrades->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
		   	}
			$this->mListeDroitsSuperGrades->AjouterFiltreEgal(COL_SUPERGRADE, $this->Id());
	   	}

	   	if ($this->mListeDroitsSuperGrades !== NULL && $liste !== NULL)
	   		$this->mListeDroitsSuperGrades->SetListeFromTableau($liste, array(array(COL_ID, COL_FONCTIONNALITE),
			   	   	   	   	   	   	   	   	   	   	   	   	   	   	   	   array(array(COL_LIBELLE, array(COL_FONCTIONNALITE, COL_LIBELLE, COL_LIBELLE)))));

	   	return $this->mListeDroitsSuperGrades;
	}

	/*************************************/
	public function Ajouter()
	{
		// On ajoute le menu.
		$retour = parent::Ajouter();

		// On ajoute au supergrade les fonctionnalités auxquelles il a accès.
		$listeDroitsSuperGrades = $this->ListeDroitsSuperGrades();
		if ($retour !== false && $listeDroitsSuperGrades !== NULL)
		{
		   	$listeDroitsSuperGrades->SetListeChampValeur(COL_SUPERGRADE, $this->Id());
		   	$retour = $listeDroitsSuperGrades->Ajouter();
		}

		return $retour;
	}

	public function Modifier()
	{
	   	// On modifie le menu.
	   	$retour = parent::Modifier();
	   	$retourDroit = true;

		// On modifie la liste des fonctionnalités auxquelles le supergrade a accès.
		$listeDroitsSuperGrades = $this->ListeDroitsSuperGrades();
		if ($listeDroitsSuperGrades !== NULL)
		{
		   	$retourFonc = $listeDroitsSuperGrades->Supprimer();
		   	if ($retourFonc !== false)
		   	{
		   	   	$listeDroitsSuperGrades->SetListeChampValeur(COL_SUPERGRADE, $this->Id());
		   		$retourDroit = $listeDroitsSuperGrades->Ajouter();
		   	}
		}

		return ($retour && $retourDroit);
	}

	public function Supprimer()
	{
	   	$retour = true;

		$listeDroitsSuperGrades = $this->ListeDroitsSuperGrades();
		if ($retour !== false && $listeDroitsSuperGrades !== NULL)
		   	$retour = $listeDroitsSuperGrades->Supprimer();

		if ($retour !== false)
		   	$retour = parent::Supprimer();

		return $retour;
	}
}

?>