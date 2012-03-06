<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_JSFONCTION;
require_once INC_SELEMORG;
require_once INC_SIMAGE;
require_once INC_SFORM;


// Cadre d'information, bannière en haut de la page.
$infoCadre = new STableau();
$infoCadre->AddProp(PROP_ID, CADRE_BARREINFO);
$infoCadre->AddLigne();
$cellule = $infoCadre->AddCellule();
$cellule->AddProp(PROP_ID, CADRE_INFO);
$cadreInfo = new SElemOrg(2, 6, CADRE_INFO, true);
$cadreInfo->FusionnerCellule(2, 1, 0, 5);
//$cadreInfo->SetCelluleDominante(1, 3);
$cadreInfo->AjouterPropCellule(1, 1, PROP_ID, CADRE_INFO_JOUEUR);
$cadreInfo->AjouterPropCellule(1, 2, PROP_WIDTH, '50%');
$cadreInfo->AjouterPropCellule(1, 3, PROP_ID, CADRE_INFO_GROUPE);
//$cadreInfo->AjouterPropCellule(1, 3, PROP_ID, CADRE_INFO_AJAX);
$cadreInfo->AjouterPropCellule(1, 4, PROP_WIDTH, '50%');
$cadreInfo->AjouterPropCellule(1, 5, PROP_ID, CADRE_INFO_LANGUE);
$cadreInfo->AjouterPropCellule(1, 6, PROP_ID, CADRE_INFO_COMMUNAUTE);
$cadreInfo->AjouterPropCellule(2, 1, PROP_ID, CADRE_INFO_ERREUR);
$elem = new SElement(FORM_ERREURS);
$cadreInfo->AttacherCellule(2, 1, $elem);
$cellule->Attach($cadreInfo);


// Cadre qui permet de redimensionner l'image (passée comme background-image au body) en fonction de la résolution d'affichage du client.
$backgroundCadre = new SBalise(BAL_DIV);
$backgroundCadre->AddProp(PROP_ID, CADRE_BACKGROUND);
$image = new SImage('', '', '');
$image->AddProp(PROP_ID, CADRE_BACKGROUND.'_image');
$backgroundCadre->Attach($image);


// Cadre qui contient tout le reste (menu, contenu, pub, ...).
$mainCadre = new STableau();
$mainCadre->AddProp(PROP_ID, CADRE_PRINCIPAL);

$org = new SOrganiseur(2, 3, true, false);
$org->AddProp(PROP_ID, 'tab_contenu');
$org->AjouterPropCellule(1, 2, PROP_ID, CADRE_BANNIERE);
$org->AjouterPropCellule(2, 1, PROP_ID, CADRE_MENU);
$org->AjouterPropCellule(2, 2, PROP_ID, CADRE_CONTENU);
$org->AjouterPropCellule(2, 3, PROP_ID, CADRE_CHAT);

$cadreBanniere = new SElemOrg(4, 3, CADRE_BANNIERE, true, false, true);
$cadreBanniere->FusionnerCellule(2, 1, 1, 0);
$cadreBanniere->FusionnerCellule(2, 3, 1, 0);
$cadreBanniere->AjouterClasseCellule(1, 2, CADRE_BANNIERE.CADRE_H);
$cadreBanniere->AjouterClasseCellule(1, 1, CADRE_BANNIERE.CADRE_HG);
$cadreBanniere->AjouterClasseCellule(2, 1, CADRE_BANNIERE.CADRE_G);
$cadreBanniere->AjouterClasseCellule(4, 1, CADRE_BANNIERE.CADRE_BG);
$cadreBanniere->AjouterClasseCellule(4, 2, CADRE_BANNIERE.CADRE_B);
$cadreBanniere->AjouterClasseCellule(4, 3, CADRE_BANNIERE.CADRE_BD);
$cadreBanniere->AjouterClasseCellule(2, 3, CADRE_BANNIERE.CADRE_D);
$cadreBanniere->AjouterClasseCellule(1, 3, CADRE_BANNIERE.CADRE_HD);
$cadreBanniere->AjouterPropCellule(2, 2, PROP_ID, CADRE_BANNIERE_BANNIERE);
$cadreBanniere->SetTexteCellule(2, 2, 'banniere<br/><br/><br/><br/><br/>');
$cadreBanniere->AjouterPropCellule(2, 3, PROP_ID, CADRE_BANNIERE_PUB);
$org->AttacherCellule(1, 2, $cadreBanniere);

$cadreMenu = new SElemOrg(4, 3, CADRE_MENU, true, false, false);
$cadreMenu->FusionnerCellule(2, 1, 1, 0);
$cadreMenu->FusionnerCellule(2, 3, 1, 0);
$cadreMenu->AjouterClasseCellule(1, 2, CADRE_MENU.CADRE_H);
$cadreMenu->AjouterClasseCellule(1, 1, CADRE_MENU.CADRE_HG);
$cadreMenu->AjouterClasseCellule(2, 1, CADRE_MENU.CADRE_G);
$cadreMenu->AjouterClasseCellule(4, 1, CADRE_MENU.CADRE_BG);
$cadreMenu->AjouterClasseCellule(4, 2, CADRE_MENU.CADRE_B);
$cadreMenu->AjouterClasseCellule(4, 3, CADRE_MENU.CADRE_BD);
$cadreMenu->AjouterClasseCellule(2, 3, CADRE_MENU.CADRE_D);
$cadreMenu->AjouterClasseCellule(1, 3, CADRE_MENU.CADRE_HD);
$cadreMenu->AjouterPropCellule(2, 2, PROP_ID, CADRE_MENU_MENU);
$cadreMenu->SetTexteCellule(2, 2, 'menu<br/><br/><br/><br/><br/><br/>');
$cadreMenu->AjouterPropCellule(2, 3, PROP_ID, CADRE_MENU_PUB);
$org->AttacherCellule(2, 1, $cadreMenu);

$cadreContenu = new SElemOrg(4, 3, CADRE_CONTENU, true, false, false);
$cadreContenu->FusionnerCellule(2, 1, 1, 0);
$cadreContenu->FusionnerCellule(2, 3, 1, 0);
$cadreContenu->AjouterClasseCellule(1, 2, CADRE_CONTENU.CADRE_H);
$cadreContenu->AjouterClasseCellule(1, 1, CADRE_CONTENU.CADRE_HG);
$cadreContenu->AjouterClasseCellule(2, 1, CADRE_CONTENU.CADRE_G);
$cadreContenu->AjouterClasseCellule(4, 1, CADRE_CONTENU.CADRE_BG);
$cadreContenu->AjouterClasseCellule(4, 2, CADRE_CONTENU.CADRE_B);
$cadreContenu->AjouterClasseCellule(4, 3, CADRE_CONTENU.CADRE_BD);
$cadreContenu->AjouterClasseCellule(2, 3, CADRE_CONTENU.CADRE_D);
$cadreContenu->AjouterClasseCellule(1, 3, CADRE_CONTENU.CADRE_HD);
$cadreContenu->AjouterPropCellule(2, 2, PROP_ID, CADRE_CONTENU_CONTENU);
//$cadreContenu->SetTexteCellule(2, 2, 'contenu<br/><br/><br/><br/>');
$cadreContenu->AjouterPropCellule(2, 3, PROP_ID, CADRE_CONTENU_PUB);
$org->AttacherCellule(2, 2, $cadreContenu);

$cadreChat = new SElemOrg(4, 3, CADRE_CHAT, true, false, false);
$cadreChat->FusionnerCellule(2, 1, 1, 0);
$cadreChat->FusionnerCellule(2, 3, 1, 0);
$cadreChat->AjouterClasseCellule(1, 2, CADRE_CHAT.CADRE_H);
$cadreChat->AjouterClasseCellule(1, 1, CADRE_CHAT.CADRE_HG);
$cadreChat->AjouterClasseCellule(2, 1, CADRE_CHAT.CADRE_G);
$cadreChat->AjouterClasseCellule(4, 1, CADRE_CHAT.CADRE_BG);
$cadreChat->AjouterClasseCellule(4, 2, CADRE_CHAT.CADRE_B);
$cadreChat->AjouterClasseCellule(4, 3, CADRE_CHAT.CADRE_BD);
$cadreChat->AjouterClasseCellule(2, 3, CADRE_CHAT.CADRE_D);
$cadreChat->AjouterClasseCellule(1, 3, CADRE_CHAT.CADRE_HD);
$cadreChat->AjouterPropCellule(2, 2, PROP_ID, CADRE_CHAT_CHAT);
$cadreChat->SetTexteCellule(2, 2, 'chat<br/><br/>');
$cadreChat->AjouterPropCellule(2, 3, PROP_ID, CADRE_CHAT_PUB);
$org->AttacherCellule(2, 3, $cadreChat);

$mainCadre->Attach($org);


// Retour affichage.
echo $infoCadre->BuildHTML();
echo $backgroundCadre->BuildHTML();
echo $mainCadre->BuildHTML();

?>