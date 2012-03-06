<?php

require_once 'cst.php';
require_once INC_GSESSION;


GReponse::Debut();


$garderContextes = GSession::LirePost('garderContextes');
$initialisation = GSession::LirePost('initialisation');
$contextes = GSession::LirePost('contextes');

if ($garderContextes == NULL)
  	GContexte::ResetContextes();

if ($initialisation != NULL)
{
   	GSession::InitialiserOnRechargement();
   	GContexte::Initialisation(true);
   	GContexte::ResetEtatChargeContextes();
   	GContexte::SupprimerContextesDesactives();
   	GContexte::ResetReferentielsContextes();
   	GContexte::AjouterContextePermanent(CONT_IDENTIFICATION, true);
   	GContexte::AjouterContextePermanent(CONT_LOCALISATION, false, true, PERIODERECH_LOCALISATION);
   	GContexte::AjouterContextePermanent(CONT_NAVIGATION, false, true, PERIODERECH_NAVIGATION);
   	GContexte::AjouterContextePermanent(CONT_ORIENTATION);
}

if ($contextes != NULL && is_array($contextes))
{
	while (list($i, $contexte) = each($contextes))
	{
	   	GContexte::AjouterContexte($contexte);
	}
}

GContexte::ChargerContextes();

if ($initialisation != NULL)
   	GContexte::Initialisation(false);


GReponse::Fin();

?>