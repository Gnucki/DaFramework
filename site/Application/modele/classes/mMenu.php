<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelleOrdre.php';
require_once PATH_METIER.'mListeMenus.php';
require_once PATH_METIER.'mListeMenusContextes.php';
require_once PATH_METIER.'mListeMenusFonctionnalites.php';


class MMenu extends MObjetLibelleOrdre
{
   	private $mListeMenusContextes;
   	private $mListeMenusFonctionnalites;

	public function __construct($id = NULL, $libelle = NULL, $ordre = NULL, $menuId = NULL, $dependFonctionnalite = NULL)
	{
		$this->SetObjet($id, $libelle, $ordre, $menuId, $dependFonctionnalite);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $ordre = NULL, $menuId = NULL, $dependFonctionnalite = NULL)
	{
		parent::SetObjet($id, $libelle, $ordre, NULL, NULL, TYPELIB_MENU);

		$this->Menu($menuId);
		$this->DependFonctionnalite($dependFonctionnalite);
		$this->mListeMenusContextes = NULL;
		$this->mListeMenusFonctionnalites = NULL;
	}

	public function GetNom()
	{
	   	return 'MMenu';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_MENU);
	}

	public function GetNouvelleListe()
	{
	   	return new MListeMenus();
	}

	/*************************************/
	public function Menu($id = -1, $libelle = NULL, $ordre = NULL, $menuId = NULL, $dependFonctionnalite = NULL)
	{
	   	return $this->ValeurObjetVerifiee(COL_MENU, 'MMenu', NULL, false, $id, $libelle, $ordre, $menuId, $dependFonctionnalite);
	}

	public function DependFonctionnalite($dependFonctionnalite = NULL)
	{
	   	return $this->ValeurBoolVerifiee(COL_DEPENDFONCTIONNALITE, $dependFonctionnalite, false, true);
	}

	public function ListeMenusFonctionnalites($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeMenusFonctionnalites !== NULL)
	   	   	$oldId = $this->mListeMenusFonctionnalites->GetFiltreValeur(0, COL_MENU);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeMenusFonctionnalites !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeMenusFonctionnalites);
	   	}
	   	else if ($this->mListeMenusFonctionnalites === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeMenusFonctionnalites === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeMenusFonctionnalites = new MListeMenusFonctionnalites();
		   	   	$numJointureFonc = $this->mListeMenusFonctionnalites->AjouterJointure(COL_FONCTIONNALITE, COL_ID);
		   	   	$this->mListeMenusFonctionnalites->AjouterColSelectionPourJointure($numJointureFonc, COL_ID);
		   	   	$numJointure = $this->mListeMenusFonctionnalites->AjouterJointure(COL_LIBELLE, COL_ID, $numJointureFonc);
		   	   	$this->mListeMenusFonctionnalites->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_LIBELLE.COL_LIBELLE);
		   	   	$this->mListeMenusFonctionnalites->AjouterColOrdrePourJointure($numJointure, COL_LIBELLE);
				$this->mListeMenusFonctionnalites->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
		   	   	$numJointure = $this->mListeMenusFonctionnalites->AjouterJointure(COL_DESCRIPTION, COL_ID, $numJointureFonc);
		   	   	$this->mListeMenusFonctionnalites->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_DESCRIPTION.COL_LIBELLE);
		   	   	$this->mListeMenusFonctionnalites->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
		   	}
			$this->mListeMenusFonctionnalites->AjouterFiltreEgal(COL_MENU, $this->Id());
	   	}

	   	if ($this->mListeMenusFonctionnalites !== NULL && $liste !== NULL)
	   		$this->mListeMenusFonctionnalites->SetListeFromTableau($liste, array(array(COL_ID, COL_FONCTIONNALITE),
			   	   	   	   	   	   	   	   	   	   	   	   	   	   	   	   array(array(COL_LIBELLE, array(COL_FONCTIONNALITE, COL_LIBELLE, COL_LIBELLE)))));

	   	return $this->mListeMenusFonctionnalites;
	}

	public function ListeMenusContextes($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeMenusContextes !== NULL)
	   	   	$oldId = $this->mListeMenusContextes->GetFiltreValeur(0, COL_MENU);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeMenusContextes !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeMenusContextes);
	   	}
	   	else if ($this->mListeMenusContextes === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeMenusContextes === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeMenusContextes = new MListeMenusContextes();
		   	   	$this->mListeMenusContextes->AjouterColSelection(COL_ORDRE);
		   	   	$numJointure = $this->mListeMenusContextes->AjouterJointure(COL_CONTEXTE, COL_ID);
		   	   	$this->mListeMenusContextes->AjouterColSelectionPourJointure($numJointure, COL_ID);
		   	   	$this->mListeMenusContextes->AjouterColSelectionPourJointure($numJointure, COL_NOM);
		   	   	$this->mListeMenusContextes->AjouterColOrdre(COL_ORDRE);
		   	}
			$this->mListeMenusContextes->AjouterFiltreEgal(COL_MENU, $this->Id());
	   	}

	   	if ($this->mListeMenusContextes !== NULL && $liste !== NULL)
	   		$this->mListeMenusContextes->SetListeFromTableau($liste, array(array(COL_ID, COL_CONTEXTE)));	   	   	   	   	   	   	   	   	   	   	   	   	   	   	   	   //array($this->NomChampFromTableauToString(array(COL_CONTEXTE, COL_ID)), COL_CONTEXTE)));

	   	return $this->mListeMenusContextes;
	}

	/*************************************/
	public function Ajouter()
	{
		// On ajoute le menu.
		$retour = parent::Ajouter();

		// On ajoute au menu les contextes qu'il doit charger.
	   	$listeMenusContextes = $this->ListeMenusContextes();
	   	if ($retour !== false && $listeMenusContextes !== NULL)
	   	{
	   	   	$listeMenusContextes->SetListeChampValeur(COL_MENU, $this->Id());
		   	$retour = $listeMenusContextes->Ajouter();
		}

		// On ajoute au menu les fonctionnalités auxquelles il est lié.
		$listeMenusFonctionnalites = $this->ListeMenusFonctionnalites();
		if ($retour !== false && $listeMenusFonctionnalites !== NULL)
		{
		   	$listeMenusFonctionnalites->SetListeChampValeur(COL_MENU, $this->Id());
		   	$retour = $listeMenusFonctionnalites->Ajouter();
		}

		return $retour;
	}

	public function Modifier()
	{
	   	// On modifie le menu.
	   	$retour = parent::Modifier();
	   	$retourCont = true;
	   	$retourFonc = true;

	   	// On modifie la liste de contexte que doit charger le menu.
	   	$listeMenusContextes = $this->ListeMenusContextes();
	   	if ($listeMenusContextes !== NULL)
		{
		   	// Suppression de l'ancienne liste.
		   	$retourCont = $listeMenusContextes->Supprimer();
		   	// Ajout de la nouvelle si tout s'est bien passé.
		   	if ($retourCont !== false)
		   	{
		   	   	$listeMenusContextes->SetListeChampValeur(COL_MENU, $this->Id());
		   		$retourCont = $listeMenusContextes->Ajouter();
		   	}
		}

		// On modifie la liste de fonctionnalités auxquelles le menu est lié.
		$listeMenusFonctionnalites = $this->ListeMenusFonctionnalites();
		if ($listeMenusFonctionnalites !== NULL)
		{
		   	$retourFonc = $listeMenusFonctionnalites->Supprimer();
		   	if ($retourFonc !== false)
		   	{
		   	   	$listeMenusFonctionnalites->SetListeChampValeur(COL_MENU, $this->Id());
		   		$retourFonc = $listeMenusFonctionnalites->Ajouter();
		   	}
		}

		return ($retour && $retourCont && $retourFonc);
	}

	public function Supprimer()
	{
	   	$retour = true;

	   	$listeMenusContextes = $this->ListeMenusContextes();
	   	if ($listeMenusContextes !== NULL)
		   	$retour = $listeMenusContextes->Supprimer();

		$listeMenusFonctionnalites = $this->ListeMenusFonctionnalites();
		if ($retour !== false && $listeMenusFonctionnalites !== NULL)
		   	$retour = $listeMenusFonctionnalites->Supprimer();

		if ($retour !== false)
		   	$retour = parent::Supprimer();

		return $retour;
	}
}

?>