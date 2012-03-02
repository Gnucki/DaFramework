<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


class MPresentationModule extends MObjetMetier
{
	public function __construct($presentationId = NULL, $typePresentationModuleId = NULL, $ressourceCSS = NULL, $ressourceJS = NULL)
	{
		$this->SetObjet($presentationId, $typePresentationModuleId, $ressourceCSS, $ressourceJS);
	}

	public function SetObjet($presentationId = NULL, $typePresentationModuleId = NULL, $ressourceCSS = NULL, $ressourceJS = NULL)
	{
		parent::SetObjet();
		$this->ClePrimaire(array(COL_PRESENTATION, COL_TYPEPRESENTATIONMODULE));

		$this->Presentation($presentationId);
		$this->TypePresentationModule($typePresentationModuleId);
		$this->RessourceCSS($ressourceCSS);
		$this->RessourceJS($ressourceJS);
	}

	public function GetNom()
	{
	   	return 'MPresentationModule';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_PRESENTATIONMODULE);
	}

	/*************************************/
	public function Presentation($id = -1, $nom = NULL, $createurJoueurId = NULL, $createurGroupeId = NULL, $globale = NULL, $publique = NULL, $version = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_PRESENTATION, 'MPresentation', NULL, true, $id, $nom, $createurJoueurId, $createurGroupeId, $globale, $publique, $version);
	}

	public function TypePresentationModule($id = -1, $libelle = NULL, $description = NULL, $ordre = NULL, $nomFichier = NULL, $actif = NULL)
	{
		return $this->ValeurObjetVerifiee(COL_TYPEPRESENTATIONMODULE, 'MTypePresentationModule', NULL, true, $id, $libelle, $description, $ordre, $nomFichier, $actif);
	}

	public function RessourceCSS($ressourceCSS = NULL)
	{
		return $this->ValeurStrVerifiee(COL_RESSOURCECSS, $ressourceCSS, 0, 250, NULL, NULL, true);
	}

	public function RessourceJS($ressourceJS = NULL)
	{
		return $this->ValeurStrVerifiee(COL_RESSOURCEJS, $ressourceJS, 0, 250, NULL, NULL, true);
	}
}

?>