<?php

require_once 'cst.php';
require_once INC_GSESSION;


$groupe = GSession::Groupe(COL_ID);
if ($groupe !== NULL && GDroit::ADroitPopErreur(FONC_PRS_CREERMODIFIER) === true)
{
   	$presActive = GContexte::LirePost(COL_PRESENTATION.'active');

   	if ($presActive === NULL)
   	{
	   	$presModif = GContexte::LirePost(COL_PRESENTATION.'modif');

	   	// Cas où l'on modifie la présentation modifiée.
	   	if ($presModif !== '')
	   	{
		   	GSession::PresentationModif($presModif);
		   	GReponse::AjouterElementClasseurRechargement('pres');
			// A faire:
			// - Rechargement des onglets ou pas?
		}
	}
	// Cas où l'on modifie la présentation active.
	else if ($presActive !== '')
	{
	   	require_once PATH_METIER.'mPresentationGroupe.php';
	   	require_once PATH_METIER.'mPresentation.php';
	   	require_once PATH_METIER.'mGroupe.php';

	   	$anciennePresActive = GSession::PresentationActive();

	   	// Suppression de l'ancienne présentation pour le groupe.
	   	$mPresentationGroupe = new MPresentationGroupe($anciennePresActive, $groupe);
	   	$retour = $mPresentationGroupe->Supprimer();

	   	if ($retour !== false)
		{
		   	// Ajout de la nouvelle présentation pour le groupe.
		   	$mPresentationGroupe->Presentation($presActive);
		   	$retour = $mPresentationGroupe->Ajouter();

		   	if ($retour !== false)
		   	   	GSession::PresentationActive($presActive, true);
		}

		if ($retour === false)
		{
		  	GLog::LeverException(EXF_0050, GSession::Libelle(LIB_PRS_PRESACTNONMODIF), true, false);
			GLog::LeverException(EXF_0050, 'Erreur lors de la tentative de modification de la présentation active.');
		}

	   	 // A faire:
	   	 // - Rechargement du css.
	}
}

?>
