<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MForumCategorie extends MObjetMetier
{
	public function __construct($id = NULL, $nom = NULL, $icone = NULL)
	{
		$this->SetObjet($id, $nom, $icone);
	}

	public function SetObjet($id = NULL, $nom = NULL, $icone = NULL)
	{
		parent::SetObjet($id);

		$this->Nom($nom);
		$this->Icone($icone);
	}

	public function GetNom()
	{
	   	return 'MForumCategorie';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_FORUMCATEGORIE);
	}

	public function GetNouvelleListe()
	{
		return new MListeForumsCategories();
	}

	/*************************************/
	public function Nom($nom = NULL)
	{
		return $this->ValeurStrVerifiee(COL_NOM, $nom, 1, 100, NULL, NULL, true);
	}

	public function Icone($icone = NULL)
	{
		return $this->ValeurStrVerifiee(COL_ICONE, $icone, 0, 150);
	}

	public function ListeForums($liste = NULL)
	{
	   	$oldId = NULL;
	   	if ($this->mListeForums !== NULL)
	   	   	$oldId = $this->mListeForums->GetFiltreValeur(0, COL_JEU);

	   	if ($this->Id() === NULL && $liste === NULL)
	   	{
	   	   	if ($this->mListeForums !== NULL && $this->Id() !== $oldId)
	   		   	unset($this->mListeForums);
	   	}
	   	else if ($this->mListeForums === NULL || $this->Id() !== $oldId)
	   	{
	   	   	if ($this->mListeForums === NULL || $oldId !== NULL)
			{
		   	   	$this->mListeForums = new MListeForums();
		   	   	$this->mListeForums->AjouterColSelection(COL_NOM);
		   	   	$this->mListeForums->AjouterColSelection(COL_DESCRIPTION);
		   	   	$this->mListeForums->AjouterColOrdre(COL_ORDRE);
		   	}
			$this->mListeForums->AjouterFiltreEgal(COL_FORUM, $this->Id());
	   	}

	   	if ($this->mListeForums !== NULL && $liste !== NULL)
	   		$this->mListeForums->SetListeFromTableau($liste);

	   	return $this->mListeForums;
	}
}

?>