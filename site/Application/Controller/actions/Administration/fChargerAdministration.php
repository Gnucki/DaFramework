<?php

require_once 'cst.php';
require_once INC_SCADRE;
require_once INC_SCLASSEUR;


if (GDroit::ADroitPopErreur(DROIT_ADMIN) === true)
{
   	$classeurAdministration = new SClasseur(PIC_ADM, 'admin', true, true);
   	$cadreAdministration = new SCadre(PIC_ADM, GSession::Libelle(LIB_ADM_ADMINISTRATION), $classeurAdministration, true, false);

	GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $cadreAdministration);

	GContexte::AjouterOnglet('admin', TABLE_VERSION, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_VERSION, false, GContexte::IsContexteExiste(CONT_VERSION, true));
	GContexte::AjouterOnglet('admin', TABLE_MONNAIE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_MONNAIE, false, GContexte::IsContexteExiste(CONT_MONNAIE, true));
	GContexte::AjouterOnglet('admin', TABLE_COMMUNAUTE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_COMMUNAUTE, false, GContexte::IsContexteExiste(CONT_COMMUNAUTE, true));
	GContexte::AjouterOnglet('admin', TABLE_LANGUE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_LANGUE, false, GContexte::IsContexteExiste(CONT_LANGUE, true));
	GContexte::AjouterOnglet('admin', TABLE_TYPELIBELLE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_TYPELIBELLE, false, GContexte::IsContexteExiste(CONT_TYPELIBELLE, true));
	GContexte::AjouterOnglet('admin', TABLE_LIBELLELIBRE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_LIBELLELIBRE, false, GContexte::IsContexteExiste(CONT_LIBELLELIBRE, true));
	GContexte::AjouterOnglet('admin', TABLE_LIBELLETEXTELIBRE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_LIBELLETEXTELIBRE, false, GContexte::IsContexteExiste(CONT_LIBELLETEXTELIBRE, true));
	GContexte::AjouterOnglet('admin', TABLE_TYPEPRESENTATIONMODULE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_TYPEPRESENTATIONMODULE, false, GContexte::IsContexteExiste(CONT_TYPEPRESENTATIONMODULE, true));
	GContexte::AjouterOnglet('admin', TABLE_MENU, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_MENU, false, GContexte::IsContexteExiste(CONT_MENU, true));
	GContexte::AjouterOnglet('admin', TABLE_CONTEXTE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_CONTEXTE, false, GContexte::IsContexteExiste(CONT_CONTEXTE, true));
	GContexte::AjouterOnglet('admin', TABLE_FONCTIONNALITE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_FONCTIONNALITE, false, GContexte::IsContexteExiste(CONT_FONCTIONNALITE, true));
	GContexte::AjouterOnglet('admin', TABLE_SUPERGRADE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_SUPERGRADE, false, GContexte::IsContexteExiste(CONT_SUPERGRADE, true));
	//GContexte::AjouterOnglet('admin', TABLE_GRADECOMMUNAUTEJEU, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_GRADECOMMUNAUTEJEU, false, GContexte::IsContexteExiste(CONT_GRADECOMMUNAUTEJEU, true));
	//GContexte::AjouterOnglet('admin', TABLE_GRADEJEU, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_GRADEJEU, false, GContexte::IsContexteExiste(CONT_GRADEJEU, true));
	//GContexte::AjouterOnglet('admin', TABLE_GRADECOMMUNAUTE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_GRADECOMMUNAUTE, false, GContexte::IsContexteExiste(CONT_GRADECOMMUNAUTE, true));
	GContexte::AjouterOnglet('admin', TABLE_GRADEGLOBAL, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_GRADEGLOBAL, false, GContexte::IsContexteExiste(CONT_GRADEGLOBAL, true));
	GContexte::AjouterOnglet('admin', TABLE_TYPEJEU, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_TYPEJEU, false, GContexte::IsContexteExiste(CONT_TYPEJEU, true));
	GContexte::AjouterOnglet('admin', TABLE_ETATRECRUTEMENT, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_ETATRECRUTEMENT, false, GContexte::IsContexteExiste(CONT_ETATRECRUTEMENT, true));
	GContexte::AjouterOnglet('admin', TABLE_TYPEGROUPE, '', 'AjouterAuContexte', 'contexte='.CONT_ADMINISTRATION.'&'.GContexte::FormaterVariable(CONT_ADMINISTRATION, 'ongletContexte').'='.CONT_TYPEGROUPE, false, GContexte::IsContexteExiste(CONT_TYPEGROUPE, true));
}

?>
