<?php

require_once 'cst.php';
require_once INC_SLISTE;


// Classe servant de base pour les diff�rentes listes complexes (liste de personnages, de forums, d'amis, de grades, d'�v�nements, ...) du programme.
class SListeReferentiel extends SListe
{
   	public function __construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage = -1, $nbElementsTotal = -1, $triable = false, $typeLiaison = '', $chargementModifDiffere = true, $foncJsOnClick = '', $foncAjaxTriCreation = '', $foncAjaxTriModification = AJAXFONC_MODIFIERDANSCONTEXTE, $foncAjaxTriSuppression = '', $foncAjaxCreation = AJAXFONC_AJOUTERAUREFERENTIEL, $foncAjaxModification = '', $foncAjaxSuppression = AJAXFONC_SUPPRIMERDUREFERENTIEL, $foncAjaxRechargement = AJAXFONC_RECHARGER)
    {
       	parent::__construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage , $nbElementsTotal, $triable, $typeLiaison, $chargementModifDiffere, $foncJsOnClick, $foncAjaxTriCreation, $foncAjaxTriModification, $foncAjaxTriSuppression, $foncAjaxCreation, $foncAjaxModification, $foncAjaxSuppression, $foncAjaxRechargement);
    }

	// R�cup�ration de la liste des menus pour un �l�ment.
	protected function GetElemListeMenus($element)
	{
	   	$menus = array();

	   	if ($this->HasDroitSuppression($element))
	   	   	$this->AjouterMenuToListe($menus, 0, GSession::Libelle(LIB_LIS_SUPPRIMER, true, true), $this->foncAjaxSuppression, $element[LISTE_ELEMENT_RETOUR].'&ref='.$this->TypeSynchroPage(), true);

		return $menus;
	}

	// R�cup�ration de la liste des menus pour l'�l�ment cr�ation.
	protected function GetElemCreationListeMenus()
	{
	   	$menus = array();

	   	if ($this->HasDroitCreation())
	   	   	$this->AjouterMenuToListe($menus, 0, GSession::Libelle(LIB_LIS_AJOUTER, true, true), $this->foncAjaxCreation, 'contexte='.$this->contexte.'&ref='.$this->TypeSynchroPage(), true, LISTE_JQCADRE_ETAGE.'1', true);

		return $menus;
	}

	// Gestion des droits de Consultation. Ce droit peut �tre sp�cifique � un �l�ment.
	protected function HasDroitConsultation($element)
	{
		return true;
	}

	// Gestion des droits de Modification. Ce droit peut �tre sp�cifique � un �l�ment.
	protected function HasDroitModification($element)
	{
		return false;
	}

	// Gestion des droits de Cr�ation. Ce droit n'est pas sp�cifique � un �l�ment.
	protected function HasDroitCreation()
	{
		return true;
	}

	// Gestion des droits de Suppression. Ce droit peut �tre sp�cifique � un �l�ment.
	protected function HasDroitSuppression($element)
	{
		return true;
	}
}

?>