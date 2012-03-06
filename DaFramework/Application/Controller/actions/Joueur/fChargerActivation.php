<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;
require_once INC_SCADRE;


$activationInfo = new SElement(CLASSTEXTE_INFO);
$activationInfo->SetText(GSession::Libelle(LIB_ACT_INFOACTIVATION));

$activationForm = new SForm('activation', 2, 1, false);
$activationForm->SetCadreInputs(1, 1, 1, 1, false);
$activationForm->AjouterInputText(1, 1, GSession::Libelle(LIB_ACT_CODEACTIVATION), '', true, GContexte::FormaterVariable($nomContexte, 'codeActivation'), '', 1, 40, 40, false, '', GSession::Libelle(LIB_ACT_CODEACTIVATIONINFO));
$activationForm->SetCadreBoutons(2, 1, 1, 1);
$activationForm->AjouterInputButtonModifierDansContexte(1, 1, CONT_ACTIVATION, true);

$activationOrg = new SOrganiseur(2, 1);
$activationOrg->AttacherCellule(1, 1, $activationInfo);
$activationOrg->AttacherCellule(2, 1, $activationForm);

$activationCadre = new SCadre('activation', GSession::Libelle(LIB_ACT_ACTIVATIONCOMPTE), $activationOrg, true, true);

GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $activationCadre);

?>
