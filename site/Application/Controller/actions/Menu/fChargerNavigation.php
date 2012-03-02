<?php

require_once 'cst.php';
require_once INC_CSTMENUS;
require_once PATH_METIER.'mListeMenus.php';
require_once PATH_COMPOSANTS.'cListeMenusPliants.php';
require_once PATH_METIER.'mMenuFonctionnalite.php';
require_once PATH_METIER.'mFonctionnalite.php';


$prefixIdClass = PIC_NAV;
$cListe = new CListeMenusPliants($prefixIdClass, 'Menus', $nomContexte, -1);

// Chargement de la liste de tous les menus.
$mListe = new MListeMenus();
$mListe->AjouterColSelection(COL_ID);
$mListe->AjouterColSelection(COL_LIBELLE);
$mListe->AjouterColSelection(COL_ORDRE);
$mListe->AjouterColSelection(COL_MENU);
$mListe->AjouterColSelection(COL_DEPENDFONCTIONNALITE);
$numJointure = $mListe->AjouterJointure(COL_MENU, COL_ID, 0, SQL_LEFT_JOIN);
$numJointure = $mListe->AjouterJointure(COL_LIBELLE, COL_ID, $numJointure, SQL_LEFT_JOIN);
$mListe->AjouterColSelectionPourJointure($numJointure, COL_LIBELLE, COL_MENU.COL_LIBELLE);
$mListe->AjouterFiltreEgalPourJointure($numJointure, COL_LANGUE, GSession::Langue(COL_ID));
$mListe->AjouterColOrdre(COL_ORDRE);
$mListe->Charger();

// Liste des menus principaux.
$mListeMenusPrincipaux = new MListeMenus();
$menus = $mListe->GetListe();
foreach ($menus as $menu)
{
  	if ($menu->Menu()->Id() === NULL)
  		$mListeMenusPrincipaux->AjouterElement($menu);
}

$menusPrincipaux = $mListeMenusPrincipaux->GetListe();
foreach ($menusPrincipaux as $menuPrincipal)
{
   	$nbSousMenus = 0;
   	$cListeSousMenus = new CListeMenus($prefixIdClass, 'Menus_'.$menuPrincipal->Id(), $nomContexte, -1);
   	$cListeSousMenus->SetListeParente($cListe, $menuPrincipal->Id());
   	$mListeSousMenus = new MListeMenus();
   	// On regarde les sous-menus qui sont rattachés aux menus principaux.
	foreach ($menus as $menu)
	{
	   	if ($menuPrincipal->Id() === $menu->Menu()->Id())
	   	{
	   	   	// On vérifie que le joueur à les droits d'accès aux fonctionnalités liées au menu.
	   	   	$mListeMenusFonctionnalites = $menu->ListeMenusFonctionnalites();
	   	   	if ($mListeMenusFonctionnalites->ListeChargee() !== true)
	   	   		$mListeMenusFonctionnalites->Charger();
	   	   	$listeMenusFonctionnalites = $mListeMenusFonctionnalites->GetListe();
	   	   	$insertionMenuOk = true;
	   	   	foreach ($listeMenusFonctionnalites as $mMenuFonctionnalite)
	   	   	{
	   	   	   	if (GDroit::ADroit($mMenuFonctionnalite->Fonctionnalite()->Id()) === false)
	   	   	   		$insertionMenuOk = false;
	   	   	}
	   	   	if ($insertionMenuOk === true)
			{
			   	// Cas particuliers d'affichage pour les menus.
			   	switch ($menu->Id())
				{
			   		case MENU_JEU_ADM:
			   		   	// Pour le menu d'administration d'un jeu, on doit être connecté à un jeu.
			   		   	if (GSession::Jeu(COL_ID) == NULL)
			   			   	$insertionMenuOk = false;
			   			break;
			   		case MENU_GPE_PRES:
			   		   	// Pour le menu d'administration d'un jeu, on doit être connecté à un jeu.
			   		   	if (GSession::Groupe(COL_ID) == NULL)
			   			   	$insertionMenuOk = false;
			   			break;
			   	} // switch
	   	   		if ($insertionMenuOk === true)
				{
		   	   		$nbSousMenus++;
		   	   		$mListeSousMenus->AjouterElement($menu);
		   	   	}
	   	   	}
	   	}
	}

	if ($dejaCharge !== false)
	{
	   	$cListeSousMenus->InjecterListeObjetsMetiers($mListeSousMenus, true);
	   	$menuCharge = GSession::MenuCharge($menuPrincipal->Id());
	   	// Si aucun sous-menu on n'affiche pas le menu principal.
		if ($nbSousMenus >= 1)
	   	{
	   	   	if ($menuCharge === false)
	   	   	{
	   	   	   	$cListe->AjouterElement($menuPrincipal->Id(), $menuPrincipal->Libelle(), $cListeSousMenus);
	   	   	   	GSession::AjouterMenu($menuPrincipal->Id());
	   	   	}
	   	   	else
	   	   	{
	   	   	   	$cListe->AjouterElement($menuPrincipal->Id(), $menuPrincipal->Libelle(), NULL);
	   	   	   	GContexte::AjouterListe($cListeSousMenus);
	   	   	}
	   	}
	   	else if ($menuCharge === true)
		{
	   	   	GSession::SupprimerMenu($menuPrincipal->Id());
	   	   	GContexte::AjouterListe($cListeSousMenus);
	   	}
	}
	// Si aucun sous-menu on n'affiche pas le menu principal.
	else if ($nbSousMenus >= 1)
	{
	   	$cListeSousMenus->InjecterListeObjetsMetiers($mListeSousMenus, true);
		$cListe->AjouterElement($menuPrincipal->Id(), $menuPrincipal->Libelle(), $cListeSousMenus);
		GSession::AjouterMenu($menuPrincipal->Id());
	}
	else
	   	GSession::SupprimerMenu($menuPrincipal->Id());
}

if ($dejaCharge === false)
    GContexte::AjouterContenu(CADRE_MENU_MENU, $cListe);
else
   	GContexte::AjouterListe($cListe);

?>
