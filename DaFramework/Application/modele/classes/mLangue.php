<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetLibelle.php';
require_once PATH_METIER.'mListeLibelles.php';
require_once PATH_METIER.'mListeLibellesLibres.php';
require_once PATH_METIER.'mListeLibellesTextes.php';
require_once PATH_METIER.'mListeLibellesTextesLibres.php';


class MLangue extends MObjetLibelle
{
	public function __construct($id = NULL, $libelle = NULL, $icone = NULL, $communauteId = NULL)
	{
		$this->SetObjet($id, $libelle, $icone, $communauteId);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $icone = NULL, $communauteId = NULL)
	{
		parent::SetObjet($id, $libelle, NULL, NULL, TYPELIB_LANGUE);

		$this->Icone($icone);
		$this->Communaute($communauteId);
	}

	public function GetNom()
	{
	   	return 'MLangue';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_LANGUE);
	}

	/*************************************/
	public function Icone($icone = NULL)
	{
		return $this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}

	public function Communaute($id = -1, $libelle = NULL, $icone = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_COMMUNAUTE, 'MCommunaute', 1, true, $id, $libelle, $icone);
	}

	/*************************************/
	public function Ajouter()
	{
	   	// Ouverture de la transaction si on ne l'ai pas déjà.
	   	$retour = parent::Ajouter();

		if ($retour !== false)
		{
		 	// On copie les libellés pour la nouvelle langue.
		 	$mListeLibelles = new MListeLibelles();
		 	$mListeLibelles->AjouterJointure(COL_LANGUE, COL_ID, 0, SQL_CROSS_JOIN);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_ID, COL_ID);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LIBELLE, COL_LIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_TYPELIBELLE, COL_TYPELIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LANGUEORIGINELLE, COL_LANGUEORIGINELLE);
		 	$mListeLibelles->AjouterColInsertionExt(1, COL_LANGUE, COL_ID);
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, GSession::Langue(COL_ID));
		 	$mListeLibelles->AjouterFiltreEgalPourJointure(1, COL_ID, $this->Id());
		 	$mListeLibelles->Ajouter();

		 	$mListeLibelles = new MListeLibellesLibres();
		 	$mListeLibelles->AjouterJointure(COL_LANGUE, COL_ID, 0, SQL_CROSS_JOIN);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_ID, COL_ID);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LIBELLE, COL_LIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_TYPELIBELLE, COL_TYPELIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LANGUEORIGINELLE, COL_LANGUEORIGINELLE);
		 	$mListeLibelles->AjouterColInsertionExt(1, COL_LANGUE, COL_ID);
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, GSession::Langue(COL_ID));
		 	$mListeLibelles->AjouterFiltreEgalPourJointure(1, COL_ID, $this->Id());
		 	$mListeLibelles->Ajouter();

		 	$mListeLibelles = new MListeLibellesTextes();
		 	$mListeLibelles->AjouterJointure(COL_LANGUE, COL_ID, 0, SQL_CROSS_JOIN);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_ID, COL_ID);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LIBELLE, COL_LIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_TYPELIBELLE, COL_TYPELIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LANGUEORIGINELLE, COL_LANGUEORIGINELLE);
		 	$mListeLibelles->AjouterColInsertionExt(1, COL_LANGUE, COL_ID);
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, GSession::Langue(COL_ID));
		 	$mListeLibelles->AjouterFiltreEgalPourJointure(1, COL_ID, $this->Id());
		 	$mListeLibelles->Ajouter();

		 	$mListeLibelles = new MListeLibellesTextesLibres();
		 	$mListeLibelles->AjouterJointure(COL_LANGUE, COL_ID, 0, SQL_CROSS_JOIN);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_ID, COL_ID);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LIBELLE, COL_LIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_TYPELIBELLE, COL_TYPELIBELLE);
		 	$mListeLibelles->AjouterColInsertionExt(0, COL_LANGUEORIGINELLE, COL_LANGUEORIGINELLE);
		 	$mListeLibelles->AjouterColInsertionExt(1, COL_LANGUE, COL_ID);
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, GSession::Langue(COL_ID));
		 	$mListeLibelles->AjouterFiltreEgalPourJointure(1, COL_ID, $this->Id());
		 	$mListeLibelles->Ajouter();
		}

		return $retour;
	}

	public function Supprimer()
	{
	   	if ($this->Id() !== NULL)
		{
	   	   	// On supprime tous les libellés de cette langue.
		 	$mListeLibelles = new MListeLibelles();
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, $this->Id());
		 	$mListeLibelles->Supprimer();

		 	$mListeLibelles = new MListeLibellesLibres();
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, $this->Id());
		 	$mListeLibelles->Supprimer();

		 	$mListeLibelles = new MListeLibellesTextes();
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, $this->Id());
		 	$mListeLibelles->Supprimer();

		 	$mListeLibelles = new MListeLibellesTextesLibres();
		 	$mListeLibelles->AjouterFiltreEgal(COL_LANGUE, $this->Id());
		 	$mListeLibelles->Supprimer();
		}

	   	return parent::Supprimer();
	}
}

?>