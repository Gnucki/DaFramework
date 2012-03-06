<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SFORM;


if (GDroit::EstConnecte(false) === false && (GSession::Connecte() === true || $dejaCharge === false))
{
   	GSession::Connecte(false);
	$creerJoueurForm = new SForm('creercompte', 2, 1);

	$creerJoueurForm->SetCadreInputs(1, 1, 6, 1);
	$creerJoueurForm->AjouterInputText(1, 1, GSession::Libelle(LIB_CON_EMAIL), '', true, GContexte::FormaterVariable(CONT_CONNEXION, 'login'), '', 1, 70, 70, false, '', GSession::Libelle(LIB_CON_EMAILINFO), GSession::Libelle(LIB_CON_EMAILERREUR), INPUTTEXT_REGEXP_EMAIL_FV);
	$creerJoueurForm->AjouterInputText(2, 1, GSession::Libelle(LIB_CON_MOTDEPASSE), INPUTTEXT_TYPE_PASSWORD, true, GContexte::FormaterVariable(CONT_CONNEXION, 'motDePasse'), '', 5, 20, 20, false, '', GSession::Libelle(LIB_CON_MOTDEPASSEINFO), GSession::Libelle(LIB_CON_MOTDEPASSEERREUR));
	$creerJoueurForm->AjouterInputText(3, 1, GSession::Libelle(LIB_CON_PSEUDO), '', true, GContexte::FormaterVariable(CONT_CONNEXION, 'pseudo'), '', 1, 30, 30, false, '', GSession::Libelle(LIB_CON_PSEUDOINFO), GSession::Libelle(LIB_CON_PSEUDOERREUR));
	$label = $creerJoueurForm->AjouterInputLabel(6, 1, GSession::Libelle(LIB_CON_DATENAISSANCE));
	$label->AjouterInputText(GSession::Libelle(LIB_CON_ANNEE), '', false, GContexte::FormaterVariable(CONT_CONNEXION, 'annee'), '', 1, 4, 4, false, '', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 1900, intval(date('Y')));
	$label->AjouterInputText(GSession::Libelle(LIB_CON_MOIS), '', false, GContexte::FormaterVariable(CONT_CONNEXION, 'mois'), '', 1, 2, 2, false, '', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 1, 12);
	$label->AjouterInputText(GSession::Libelle(LIB_CON_JOUR), '', false, GContexte::FormaterVariable(CONT_CONNEXION, 'jour'), '', 1, 2, 2, false, '', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 1 , 31);
	$creerJoueurForm->SetCadreBoutons(2, 1, 1, 2);
	$creerJoueurForm->AjouterInputButtonValiderAjaxContexte(1, 1, CONT_CONNEXION, 'CreerJoueur');
	$creerJoueurForm->AjouterInputButtonAnnuler(1, 2);


	$connexionForm = new SForm('connexion', 1, 2);

	$connexionForm->SetCadreInputs(1, 1, 1, 2);
	$select = $connexionForm->AjouterInputNewText(1, 1, GSession::Libelle(LIB_CON_EMAIL), true, GContexte::FormaterVariable(CONT_CONNEXION, 'login'), '', 1, 70, 20, false, '', '', '', INPUTTEXT_REGEXP_EMAIL_FV);
	$select->AjouterFormulaire(GSession::Libelle(LIB_CON_CREERCOMPTE), $creerJoueurForm);
	$connexionForm->AjouterInputText(1, 2, GSession::Libelle(LIB_CON_MOTDEPASSE), INPUTTEXT_TYPE_PASSWORD, true, GContexte::FormaterVariable(CONT_CONNEXION, 'motDePasse'), '', 5, 20, 10, false, '', '', '');

	$connexionForm->SetCadreBoutons(1, 2, 1, 1);
	$bouton = $connexionForm->AjouterInputButton(1, 1, '', GSession::Libelle(LIB_CON_CONNEXION), GSession::Libelle(LIB_CON_CONNEXION), true, AJAXFONC_CHARGERCONTEXTES, true, true);
	$bouton->AjouterParamRetour('contextes[0]', CONT_CONNEXION);

	GContexte::AjouterContenu(CADRE_INFO_JOUEUR, $connexionForm);
}
else if (GDroit::EstConnecte(false) === true && (GSession::Connecte() === false || $dejaCharge === false))//GSession::Connecte() !== true || $dejaCharge === false)
{
   	GSession::Connecte(true);
   	$connecteForm = new SForm('connecte', 1, 2);

	$connecteForm->SetCadreInputs(1, 1, 1, 1);
	$connecteForm->AjouterInputInfo(1, 1, GSession::Libelle(LIB_CON_PSEUDO), GSession::Joueur(COL_PSEUDO), true);

	$connecteForm->SetCadreBoutons(1, 2, 1, 1);
	$bouton = $connecteForm->AjouterInputButton(1, 1, '', GSession::Libelle(LIB_CON_DECONNEXION), GSession::Libelle(LIB_CON_DECONNEXION), true, AJAXFONC_CHARGERCONTEXTES, true, true);
	$bouton->AjouterParamRetour('contextes[0]', CONT_DECONNEXION);

	GContexte::AjouterContenu(CADRE_INFO_JOUEUR, $connecteForm);
}

?>
