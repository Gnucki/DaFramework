<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MTypeGroupe extends MObjetLibelle
{
	public function __construct($id = NULL, $libelle = NULL, $jeuId = NULL)
	{
		$this->SetObjet($id, $libelle, $jeuId);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $jeuId = NULL)
	{
		parent::SetObjet($id, $libelle, NULL, NULL, TYPELIB_GROUPE);

		$this->Jeu($jeuId);
	}

	public function GetNom()
	{
	   	return 'MTypeGroupe';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_TYPEGROUPE);
	}

	/*************************************/
	public function Jeu($id = -1, $libelle = NULL, $icone = NULL, $niveauMax = NULL, $necessiteBoss = NULL, $necessiteClasse = NULL, $necessiteMetier = NULL, $necessiteNiveau = NULL, $necessiteObjet = NULL, $necessiteRole = NULL, $necessiteServeur = NULL, $typeJeuId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_JEU, 'MJeu', NULL, false, $id, $libelle, $icone, $niveauMax, $necessiteBoss, $necessiteClasse, $necessiteMetier, $necessiteNiveau, $necessiteObjet, $necessiteRole, $necessiteServeur, $typeJeuId);
	}
}

?>