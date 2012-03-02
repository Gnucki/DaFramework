<?php

require_once 'cst.php';
require_once INC_GCSS;
require_once INC_GJS;
require_once PATH_METIER.'mPresentation.php';
require_once PATH_METIER.'mPresentationModule.php';
require_once PATH_METIER.'mTypePresentationModule.php';


$groupe = GSession::Groupe(COL_ID);
if ($groupe !== NULL && GDroit::ADroitPopErreur(FONC_PRS_CREERMODIFIER) === true)
{
   	$presentationModif = GSession::PresentationModif();
   	if ($presentationModif != NULL)
	{
	   	// Récupération du nom de fichier que l'on va utiliser pour la sauvegarde.
	   	$mPresentationModule = new MPresentationModule();
	   	$mPresentationModule->TypePresentationModule($module);
	   	$mTypePresentationModule = $mPresentationModule->TypePresentationModule();
	   	$mTypePresentationModule->AjouterColSelection(COL_NOMFICHIER);
	   	$mTypePresentationModule->Charger();
	   	$nomFichier = $mTypePresentationModule->NomFichier();
	   	$cheminCss = GCss::GetCheminFichier($presentationModif);
	   	$cheminJs = GJs::GetCheminFichier($presentationModif);

	   	if ($cheminCss !== '' && $cheminJs !== '' && $nomFichier !== '')
		{
		   	$varPost = GContexte::LirePost(NULL);

			// Sauvegarde du Css.
			GCss::SauvegarderFichierCss($nomFichier, $presentationModif, $varPost);

			// Sauvegarde du JS.
			GJs::SauvegarderFichierJs($nomFichier, $presentationModif, $varPost);

			// Sauvegarde en base.
			$mPresentationModule->Presentation($presentationModif);
			$mPresentationModule->RessourceCSS($cheminCss.$nomFichier.'.css');
			$mPresentationModule->RessourceJS($cheminJs.$nomFichier.'.js');
			$mPresentationModule->ModifierSiExistantAjouterSinon();
		}
	}
	else
	{
	   	GLog::LeverException(EXF_0060, GSession::Libelle(LIB_PRS_PRESMODIFVIDE), true, false);
	   	GLog::LeverException(EXF_0061, GSession::Libelle(LIB_PRS_PRESNONSAUV), true, false);
	}
}


?>
