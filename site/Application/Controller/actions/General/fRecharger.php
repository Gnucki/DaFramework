<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SLISTE;


GReponse::Debut();


$suite = GSession::LirePost('suite');
// Cas du chargement de la suite d'un ou plusieurs contextes trop gros à charger en une seule fois.
if ($suite !== NULL && $suite !== '')
{
   	$contextes = GSession::LirePost('contextes');
   	if ($contextes !== NULL && $contextes !== '')
   	{
		foreach ($contextes as $contexte)
		{
	   		GContexte::ChargerContexte($contexte, true);
	   	}
	}
}
else
{
   	$auto = GSession::LirePost('auto');
	// Cas du rechargement automatique.
	if ($auto !== NULL && $auto !== '')
	   	GContexte::ChargerContextes(true);
	else
	{
	   	$contexte = GSession::LirePost('contexte');

		// Cas du rechargement de tous les contextes.
	   	if ($contexte === NULL || $contexte === '')
		   	GContexte::ChargerContextes();
		// Cas du rechargement d'un contexte spécifique.
		else
		{
		   	$page = GContexte::LireVariablePost($contexte, 'page');
		   	$etage = GContexte::LireVariablePost($contexte, 'etage');
		   	$contenu = GContexte::LireVariablePost($contexte, 'contenu');
		   	// Cas du changement de page pour une liste.
		   	if ($contexte !== NULL && $page !== NULL && $page !== '')
			   	SListe::SetChangementPage($page);
			// Cas du chargement d'un étage pour un élément d'une liste.
			else if ($contexte !== NULL && $etage !== NULL && $etage !== '')
			   	SListe::SetChargementEtage($etage);
			// Cas du chargement d'un contenu pour un élément d'une liste pliante.
			else if ($contexte !== NULL && $contenu !== NULL && $contenu !== '')
			   	SListe::SetChargementContenu($contenu);
		   	GContexte::ChargerContexte($contexte);
		}
	}
}


GReponse::Fin();

?>