<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';
require_once PATH_METIER.'mListeServeurs.php';
require_once PATH_METIER.'mListeTypesGroupes.php';


class MJeu extends MObjetLibelle
{
   	protected $mListeServeurs;
   	protected $mListeTypesGroupes;

	public function __construct($id = NULL, $libelle = NULL, $icone = NULL, $niveauMax = NULL, $necessiteBoss = NULL, $necessiteClasse = NULL, $necessiteMetier = NULL, $necessiteNiveau = NULL, $necessiteObjet = NULL, $necessiteRole = NULL, $necessiteServeur = NULL, $typeJeuId = NULL)
	{
		$this->SetObjet($id, $libelle, $icone, $niveauMax, $necessiteBoss, $necessiteClasse, $necessiteMetier, $necessiteNiveau, $necessiteObjet, $necessiteRole, $necessiteServeur, $typeJeuId);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $icone = NULL, $niveauMax = NULL, $necessiteBoss = NULL, $necessiteClasse = NULL, $necessiteMetier = NULL, $necessiteNiveau = NULL, $necessiteObjet = NULL, $necessiteRole = NULL, $necessiteServeur = NULL, $typeJeuId = NULL)
	{
		parent::SetObjet($id, $libelle, NULL, NULL, TYPELIB_JEU);

		$this->Icone($icone);
		$this->NiveauMax($niveauMax);
		$this->NecessiteBoss($necessiteBoss);
		$this->NecessiteClasse($necessiteClasse);
		$this->NecessiteMetier($necessiteMetier);
		$this->NecessiteNiveau($necessiteNiveau);
		$this->NecessiteObjet($necessiteObjet);
		$this->NecessiteRole($necessiteRole);
		$this->NecessiteServeur($necessiteServeur);
		$this->TypeJeu($typeJeuId);
		$this->mListeServeurs = NULL;
		$this->mListeTypesGroupes = NULL;
	}

	public function GetNom()
	{
	   	return 'MJeu';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_JEU);
	}

	/*************************************/
	public function Icone($icone = NULL)
	{
		return $this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}

	public function NiveauMax($niveauMax = NULL)
	{
		return $this->ValeurIntVerifiee(COL_NIVEAUMAX, $niveauMax, 0, NULL, 0, true);
	}

	public function NecessiteBoss($necessiteBoss = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_NECESSITEBOSS, $necessiteBoss, false, true);
	}

	public function NecessiteClasse($necessiteClasse = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_NECESSITECLASSE, $necessiteClasse, false, true);
	}

	public function NecessiteMetier($necessiteMetier = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_NECESSITEMETIER, $necessiteMetier, false, true);
	}

	public function NecessiteNiveau($necessiteNiveau = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_NECESSITENIVEAU, $necessiteNiveau, false, true);
	}

	public function NecessiteObjet($necessiteObjet = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_NECESSITEOBJET, $necessiteObjet, false, true);
	}

	public function NecessiteRole($necessiteRole = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_NECESSITEROLE, $necessiteRole, false, true);
	}

	public function NecessiteServeur($necessiteServeur = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_NECESSITESERVEUR, $necessiteServeur, false, true);
	}

	public function TypeJeu($id = -1, $libelle = NULL, $description = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_TYPEJEU, 'MTypeJeu', 1, true, $id, $libelle, $description);
	}

	public function ListeServeurs($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeServeurs !== NULL)
	   	   	$oldId = $this->mListeServeurs->GetFiltreValeur(0, COL_JEU);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeServeurs !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeServeurs);
	   	}
	   	else if ($this->mListeServeurs === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeServeurs === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeServeurs = new MListeServeurs();
		   	   	$this->mListeServeurs->AjouterColSelection(COL_ID);
		   	   	$this->mListeServeurs->AjouterColSelection(COL_LIBELLE);
		   	   	$this->mListeServeurs->AjouterFiltreDifferent(COL_SUPPRIME, true);
		   	   	$this->mListeServeurs->AjouterColOrdre(COL_LIBELLE);
		   	}
			$this->mListeServeurs->AjouterFiltreEgal(COL_JEU, $this->Id());
	   	}

	   	if ($this->mListeServeurs !== NULL && $liste !== NULL)
	   		$this->mListeServeurs->SetListeFromTableau($liste);

	   	return $this->mListeServeurs;
	}

	public function ListeTypesGroupes($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeTypesGroupes !== NULL)
	   	   	$oldId = $this->mListeTypesGroupes->GetFiltreValeur(0, COL_JEU);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeTypesGroupes !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeTypesGroupes);
	   	}
	   	else if ($this->mListeTypesGroupes === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeTypesGroupes === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeTypesGroupes = new MListeTypesGroupes();
		   	   	$this->mListeTypesGroupes->AjouterColSelection(COL_ID);
		   	   	$this->mListeTypesGroupes->AjouterColSelection(COL_LIBELLE);
		   	   	$this->mListeTypesGroupes->AjouterColOrdre(COL_LIBELLE);
		   	}
			$this->mListeTypesGroupes->AjouterFiltreEgal(COL_JEU, $this->Id());
	   	}

	   	if ($this->mListeTypesGroupes !== NULL && $liste !== NULL)
	   		$this->mListeTypesGroupes->SetListeFromTableau($liste);

	   	return $this->mListeTypesGroupes;
	}

	/*************************************/
	public function Ajouter()
	{
		// On ajoute le menu.
		$retour = parent::Ajouter();

		// On ajoute au menu les contextes qu'il doit charger.
	   	$listeServeurs = $this->ListeServeurs();
	   	if ($retour !== false && $listeServeurs !== NULL)
	   	{
	   	   	$listeServeurs->SetListeChampValeur(COL_JEU, $this->Id());
		   	$retour = $listeServeurs->Ajouter();
		}

		// On ajoute au menu les fonctionnalités auxquelles il est lié.
		$listeTypesGroupes = $this->ListeTypesGroupes();
		if ($retour !== false && $listeTypesGroupes !== NULL)
		{
		   	$listeTypesGroupes->SetListeChampValeur(COL_JEU, $this->Id());
		   	$retour = $listeTypesGroupes->Ajouter();
		}

		return $retour;
	}

	public function Modifier()
	{
	   	// On modifie le menu.
	   	$retour = parent::Modifier();
	   	$retourServ = true;
	   	$retourTyGr = true;

	   	// On modifie la liste de contexte que doit charger le menu.
	   	$listeServeurs = $this->ListeServeurs();
	   	if ($listeServeurs !== NULL)
		{
		   	// Suppression de l'ancienne liste.
		   	$retourServ = $listeServeurs->Supprimer();
		   	// Ajout de la nouvelle si tout s'est bien passé.
		   	if ($retourServ !== false)
		   	{
		   	   	$listeServeurs->SetListeChampValeur(COL_JEU, $this->Id());
		   		$retourServ = $listeServeurs->Ajouter();
		   	}
		}

		// On modifie la liste de fonctionnalités auxquelles le menu est lié.
		$listeTypesGroupes = $this->ListeTypesGroupes();
		if ($listeTypesGroupes !== NULL)
		{
		   	$retourTyGr = $listeTypesGroupes->Supprimer();
		   	if ($retourTyGr !== false)
		   	{
		   	   	$listeTypesGroupes->SetListeChampValeur(COL_JEU, $this->Id());
		   		$retourTyGr = $listeTypesGroupes->Ajouter();
		   	}
		}

		return ($retour && $retourServ && $retourTyGr);
	}

	public function Supprimer()
	{
	   	$retour = true;

	   	$listeServeurs = $this->ListeServeurs();
	   	if ($listeServeurs !== NULL)
		   	$retour = $listeServeurs->Supprimer();

		$listeTypesGroupes = $this->ListeTypesGroupes();
		if ($retour !== false && $listeTypesGroupes !== NULL)
		   	$retour = $listeTypesGroupes->Supprimer();

		if ($retour !== false)
		   	$retour = parent::Supprimer();

		return $retour;
	}
}

?>