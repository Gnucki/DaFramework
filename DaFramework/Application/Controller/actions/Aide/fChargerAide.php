<?php

require_once 'cst.php';
require_once INC_SCADRE;
require_once INC_SSEPARATEUR;


if ($dejaCharge === false)
{
   	$prefixIdClass = PIC_AID;
   	$orgCadre = new SOrganiseur(3, 1, true);

   	$elemGlossaire = new SElement($prefixIdClass.CLASSTEXTE_INFO);
	$elemGlossaire->AjouterClasse(CLASSTEXTE_INFO);
	$elemGlossaire->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_AID_GLOSSAIRE, false, true)));
	$cadreGlossaire = new SCadre($prefixIdClass, GSession::Libelle(LIB_AID_GLOSSAIRE), $elemGlossaire, true, false);

	$org = new SOrganiseur(2, 1, true);
	$elemRejoindreGroupe = new SElement($prefixIdClass.CLASSTEXTE_INFO);
	$elemRejoindreGroupe->AjouterClasse(CLASSTEXTE_INFO);
	$elemRejoindreGroupe->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_AID_REJGPE1, false, true)));
	$org->AttacherCellule(1, 1, $elemRejoindreGroupe);
	$elemRejoindreGroupe = new SElement($prefixIdClass.CLASSTEXTE_INFO);
	$elemRejoindreGroupe->AjouterClasse(CLASSTEXTE_INFO);
	$elemRejoindreGroupe->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_AID_REJGPE2, false, true)));
	$org->AttacherCellule(2, 1, $elemRejoindreGroupe);
	$cadreRejoindreGroupe = new SCadre($prefixIdClass, GSession::Libelle(LIB_AID_REJGPE), $org, true, false);

	$elemCreerGroupe = new SElement($prefixIdClass.CLASSTEXTE_INFO);
	$elemCreerGroupe->AjouterClasse(CLASSTEXTE_INFO);
	$elemCreerGroupe->SetText(GTexte::FormaterTexteSimple(GSession::Libelle(LIBTEXT_AID_CREERGPE, false, true)));
	$cadreCreerGroupe = new SCadre($prefixIdClass, GSession::Libelle(LIB_AID_CREGPE), $elemCreerGroupe, true, false);

	$orgCadre->AttacherCellule(1, 1, $cadreGlossaire);
	$orgCadre->AttacherCellule(2, 1, $cadreRejoindreGroupe);
	$orgCadre->AttacherCellule(3, 1, $cadreCreerGroupe);

	GContexte::AjouterContenu(CADRE_CONTENU_CONTENU, $orgCadre);
}

?>
