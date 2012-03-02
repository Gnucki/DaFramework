<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MServeur extends MObjetLibelle
{
	public function __construct($id = NULL, $libelle = NULL, $supprime = NULL, $jeuId = NULL)
	{
		$this->SetObjet($id, $libelle, $supprime, $jeuId);
	}

	public function SetObjet($id = NULL, $libelle = NULL, $supprime = NULL, $jeuId = NULL)
	{
		parent::SetObjet($id, $libelle, NULL, NULL, TYPELIB_SERVEUR);

		$this->Supprime($supprime);
		$this->Jeu($jeuId);
	}

	public function GetNom()
	{
	   	return 'MServeur';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_SERVEUR);
	}

	/*************************************/
	public function Jeu($id = -1, $libelle = NULL, $icone = NULL, $niveauMax = NULL, $necessiteBoss = NULL, $necessiteClasse = NULL, $necessiteMetier = NULL, $necessiteNiveau = NULL, $necessiteObjet = NULL, $necessiteRole = NULL, $necessiteServeur = NULL, $typeJeuId = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_JEU, 'MJeu', NULL, true, $id, $libelle, $icone, $niveauMax, $necessiteBoss, $necessiteClasse, $necessiteMetier, $necessiteNiveau, $necessiteObjet, $necessiteRole, $necessiteServeur, $typeJeuId);
	}

	public function Supprime($supprime = NULL)
	{
		return $this->ValeurBoolVerifiee(COL_SUPPRIME, $supprime, false, true);
	}
}

?>