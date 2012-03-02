<?php

require_once 'cst.php';
require_once INC_SBALISE;
require_once INC_SFORUMGRAPH1;
require_once INC_SLISTEFORUMSGRAPH;
require_once INC_SINPUT;
require_once PATH_CLASSES.'bConstantes.php';
require_once PATH_CLASSES.'bCategorie.php';
require_once INC_SLISTEMENUSDEROULANTSHORIZONTAUX;
require_once INC_SMENUPOPUP;
require_once INC_SCADRETITRECONTENU;

$numSousMenu = 0;
$sListeNavigationCategories = new SListeMenusDeroulantsHorizontaux();
$categs = $categories;
$currentCat = $cat;
$numMenu = 0;

$currentCategories = array();
while (list($i, $categ) = each($categs))
{
   	if ($currentCat == $categ[COL_ID])
	{
	   	$currentCategories[] = $categ;
		$currentCat = $categ[COL_CATEGORIE];
		$categs = $categories;
	}
	if ($currentCat == NULL)
	   	break;
}

$numMenu++;
$sListeNavigationCategories->AddMenu(utf8_encode(htmlspecialchars('...', ENT_QUOTES)),$categ[COL_CATEGORIE],'menu_deroulant',NAVIGATIONFORUM.$numMenu);
$menu = new SMenuPopup($categories, COL_ID, COL_CATEGORIE, COL_NOM, NULL, NAVIGATIONFORUM_LISTECONTENEUR, NAVIGATIONFORUM_LISTE, NAVIGATIONFORUM_FORUM, NAVIGATIONFORUM_MENUDEROULANT, NAVIGATIONFORUM.$numMenu);
$sListeNavigationCategories->AddSousMenu($menu);

while ($categ = array_pop($currentCategories))
{
   	$numMenu++;
   	$sListeNavigationCategories->AddMenu(utf8_encode(htmlspecialchars($categ[COL_NOM], ENT_QUOTES)),'','menu_deroulant',NAVIGATIONFORUM.$numMenu.$categ[COL_ID]);
	$menu = new SMenuPopup($categories, COL_ID, COL_CATEGORIE, COL_NOM, $categ[COL_ID], NAVIGATIONFORUM_LISTECONTENEUR, NAVIGATIONFORUM_LISTE, NAVIGATIONFORUM_FORUM, NAVIGATIONFORUM_MENUDEROULANT, NAVIGATIONFORUM.$numMenu);
	$sListeNavigationCategories->AddSousMenu($menu);
}

$cadre = new SCadreTitreContenu('Navigation dans les Forums', '', CADREFORUM, CADREFORUM_TITRE_NAVIGATION, CADREFORUM_TITRE, CADREFORUM_CONTENU_NAVIGATION, CADREFORUM_CONTENU);
$cadre->Attach($sListeNavigationCategories);
echo $cadre->BuildHTML();

?>
