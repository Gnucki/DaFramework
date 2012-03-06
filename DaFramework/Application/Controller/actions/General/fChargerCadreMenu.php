<?php
require_once 'cst.php';
require_once INC_SBALISE;
require_once INC_SLISTEMENUSDEROULANTS;
require_once INC_SMENUPOPUP;
require_once INC_JSFONCTION;
require_once PATH_CLASSES.'bMenu.php';
require_once PATH_CLASSES.'bGroupe.php';

$bMenu = new BMenu();
$resultats = $bMenu->GetListeMenus();

$sListeMenu = new SListeMenusDeroulants();

$numMenu = 0;
$listeMenus = $resultats;
while (list($i, $menu) = each($listeMenus))
{
   	if ($menu[COL_MENU] == null)
	{
   		$sListeMenu->AddMenu($menu[COL_LIBELLE], 'menu_'.$menu[COL_ID], 'div_menu_visible', '');
   		$listeSousMenus = $resultats;
   		while (list($i, $sousMenu) = each($listeSousMenus))
		{
		   	if ($sousMenu[COL_MENU] === $menu[COL_ID])
		   	{
				$numMenu++;
		   	   	$jsFonc = new JSFonction($sousMenu[COL_AJAXFONC], 0);
   			   	$currentSousMenu = $sListeMenu->AddSousMenu($sousMenu[COL_LIBELLE], 'menu_'.$sousMenu[COL_ID], 'div_sousmenu_visible', $jsFonc->BuildJS()/*, 'sousmenupop'.$numMenu.$sousMenu[COL_ID]*/);
				$menuPopup = new SMenuPopup($resultats, COL_ID, COL_MENU, COL_LIBELLE, $sousMenu[COL_ID], NAVIGATIONFORUM_LISTECONTENEUR, NAVIGATIONFORUM_LISTE, NAVIGATIONFORUM_FORUM, MENUPRINCIPAL_MENUDEROULANT, 'sousmenupop'.$numMenu);
				if ($menuPopup->HasMenuPopup())
				   	$currentSousMenu->AddSousMenu($menuPopup);
   			}
		}
   	}
}

if (isset($_SESSION['idJoueurConnecte']))
{
	$bGroupe = new BGroupe();
	$groupes = $bGroupe->GetListeGroupesPourJoueur($_SESSION['idJoueurConnecte']);

	if (count($groupes) !== 0)
	{
		$sListeMenu->AddMenu(to_html('Aller dans'), 'menu_groupeallerdans', 'div_menu_visible', '');
		$listeGroupes = $groupes;
		while (list($i, $groupe) = each($listeGroupes))
		{
		   	$jsFonc = new JSFonction(AJAX_CHARGERGROUPE_NAME, AJAX_CHARGERGROUPE_NBPARAMS);
		   	$jsFonc->AddParamInt($groupe[COL_ID]);
		   	$sListeMenu->AddSousMenu($groupe[COL_LIBELLE].' - '.$groupe[COL_NOM], 'menu_groupe'.$groupe[COL_ID], 'div_sousmenu_visible', $jsFonc->BuildJS());
		}
	}
}

echo $sListeMenu->BuildHTML();

?>
