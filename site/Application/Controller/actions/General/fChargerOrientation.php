<?php

require_once 'cst.php';
require_once PATH_METIER.'mMenu.php';
require_once PATH_METIER.'mContexte.php';
require_once PATH_METIER.'mMenuContexte.php';


// Chargement spécifique lors d'un get.
if (GSession::IsRequeteGet() === true)
{
	// TO DO..
}
// Requête standard.
else
{
	$menuId = GContexte::LireVariablePost($nomContexte, COL_ID, false);
	if ($menuId === NULL)
		$menuId = GContexte::LireVariableSession($nomContexte, COL_ID, false);
	if ($menuId !== NULL)
	{
	   	$mMenu = new MMenu($menuId);
	   	$mListeMenusContextes = $mMenu->ListeMenusContextes();
	   	$mListeMenusContextes->Charger();

	   	$listeMenusContextes = $mListeMenusContextes->GetListe();
		if (count($listeMenusContextes) === 0)
	   		GContexte::SetContexte(CONT_VIDE);
	   	else
	   	{
	   	   	GContexte::ResetContextes();
		   	foreach ($listeMenusContextes as $mMenuContexte)
		   	{
		   	   	$nom = $mMenuContexte->Contexte()->Nom();
		   	   	$rechargement = true;
				switch ($nom)
				{
		   	   		case CONT_ADMINISTRATION:
		   	   			$rechargement = false;
		   	   			break;
		   	   	}
		   	   	GContexte::AjouterContexte($nom, $rechargement);
			}
		}
	}
	//else
	//   	GContexte::SetContexte(CONT_VIDE);
}

?>
