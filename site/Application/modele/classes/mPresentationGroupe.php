<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MPresentationGroupe extends MObjetMetier
{
	public function __construct($presentationId = NULL, $groupeId = NULL)
	{
		$this->SetObjet($presentationId, $groupeId);
	}

	public function SetObjet($presentationId = NULL, $groupeId = NULL)
	{
		parent::SetObjet();
		$this->ClePrimaire(array(COL_PRESENTATION, COL_GROUPE));

		$this->Presentation($presentationId);
		$this->Groupe($groupeId);
	}

	public function GetNom()
	{
	   	return 'MPresentationGroupe';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_PRESENTATIONGROUPE);
	}

	/*************************************/
	public function Presentation($id = -1, $nom = NULL, $createurJoueurId = NULL, $createurGroupeId = NULL, $globale = NULL, $publique = NULL, $version = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_PRESENTATION, 'MPresentation', NULL, true, $id, $nom, $createurJoueurId, $createurGroupeId, $globale, $publique, $version);
	}

	public function Groupe($id = -1, $nom = NULL, $jeuId = NULL, $serveurId = NULL, $description = NULL, $histoire = NULL, $participation = NULL, $pub = NULL, $dateFinNoPub = NULL, $typeGroupeId = NULL, $etatRecrutementId = NULL, $messageRecrutement = NULL, $communauteId = NULL, $icone = NULL, $supprime = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_GROUPE, 'MGroupe', NULL, true, $id, $nom, $jeuId, $serveurId, $description, $histoire, $participation, $pub, $dateFinNoPub, $typeGroupeId, $etatRecrutementId, $messageRecrutement, $communauteId, $icone, $supprime);
	}
}

?>