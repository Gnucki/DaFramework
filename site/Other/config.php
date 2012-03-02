<?php

// Connexion à la base de données.
define('USERBDD', 'utilstand');
define('PASSWORDBDD', 'xxxTPx92$');
define('CONNEXION', 'mysql:host=localhost;dbname=superbase3');
//define('CONNEXION', 'mysql:host=88.164.190.125;dbname=superbase');
//define('CONNEXION', 'mysql:host=192.168.0.10;dbname=superbase');


// SMTP (installer un serveur mail si pas disponible).
define ('SMTP','smtp.wanadoo.fr');


// TimeZone par défaut.
define ('UTC_SQL','UTC'); 				// Fuseau horaire (UTC) du serveur SQL.
define ('UTC_SERVEUR','UTC'); 			// Fuseau horaire (UTC) du serveur PHP.
date_default_timezone_set('UTC');


// Constantes générales.
define ('MODE_EXECUTION','DEBUG'); 	// DEBUG, RELEASE.


// Constantes pour les périodes de rechargement des contextes en secondes.
define ('PERIODERECH_NORMALE', 20000);
define ('PERIODERECH_LOCALISATION', 60000);
define ('PERIODERECH_NAVIGATION', 60000);


// Paths.
define ('PATH_ROOT_LOCAL','C:/Divers/Entreprise/DossierProjet/dev/www/');
define ('PATH_ROOT_HTTP','http://localhost/');


// Constantes représentant les includes.
define ('PATH_BASE','base/');
define ('PATH_CSS','css/');
define ('PATH_COMPOSANTS','interface/composants/');
define ('PATH_CST','constantes/');
define ('PATH_FONCTIONS','fonctions/');
define ('PATH_GLOBAL','global/');
define ('PATH_IMAGES','images/');
define ('PATH_INTERFACE','interface/');
define ('PATH_JS','js/');
define ('PATH_METIER','metier/');
define ('PATH_STOCKAGE','stockage/');
define ('PATH_STRUCTURE','interface/structure/');

define ('INC_CSTBASE',PATH_CST.'cstBase.php');
define ('INC_CSTCSS',PATH_CST.'cstCSS.php');
define ('INC_CSTEXCEPTIONS',PATH_CST.'cstExceptions.php');
define ('INC_CSTFONCTIONS',PATH_CST.'cstFonctions.php');
define ('INC_CSTFONCTIONNALITES',PATH_CST.'cstFonctionnalites.php');
define ('INC_CSTHTML',PATH_CST.'cstHTML.php');
define ('INC_CSTJS',PATH_CST.'cstJS.php');
define ('INC_CSTLIBELLES',PATH_CST.'cstLibelles.php');
define ('INC_CSTMENUS',PATH_CST.'cstMenus.php');
define ('INC_CSTPIC',PATH_CST.'cstPrefixIdClass.php');
define ('INC_CSTSQL',PATH_CST.'cstSQL.php');
define ('INC_CSTWARNINGS',PATH_CST.'cstWarnings.php');

define ('INC_SBALISE',PATH_STRUCTURE.'sBalise.php');
define ('INC_SCADRE',PATH_STRUCTURE.'sCadre.php');
define ('INC_SCENTREUR',PATH_STRUCTURE.'sCentreur.php');
define ('INC_SCLASSEUR',PATH_STRUCTURE.'sClasseur.php');
define ('INC_SELEMENT',PATH_STRUCTURE.'sElement.php');
define ('INC_SELEMORG',PATH_STRUCTURE.'sElemOrg.php');
define ('INC_SFORM',PATH_STRUCTURE.'sForm.php');
define ('INC_SIMAGE',PATH_STRUCTURE.'sImage.php');
define ('INC_SINPUT',PATH_STRUCTURE.'sInput.php');
define ('INC_SINPUTBUTTON',PATH_STRUCTURE.'sInputButton.php');
define ('INC_SINPUTCHECKBOX',PATH_STRUCTURE.'sInputCheckbox.php');
define ('INC_SINPUTCOLOR',PATH_STRUCTURE.'sInputColor.php');
define ('INC_SINPUTFACTORY',PATH_STRUCTURE.'sInputFactory.php');
define ('INC_SINPUTFILE',PATH_STRUCTURE.'sInputFile.php');
define ('INC_SINPUTIMAGE',PATH_STRUCTURE.'sInputImage.php');
define ('INC_SINPUTLISTE',PATH_STRUCTURE.'sInputListe.php');
define ('INC_SINPUTLISTEDOUBLE',PATH_STRUCTURE.'sInputListeDouble.php');
define ('INC_SINPUTNEW',PATH_STRUCTURE.'sInputNew.php');
define ('INC_SINPUTNEWSELECT',PATH_STRUCTURE.'sInputNewSelect.php');
define ('INC_SINPUTNEWTEXT',PATH_STRUCTURE.'sInputNewText.php');
define ('INC_SINPUTLABEL',PATH_STRUCTURE.'sInputLabel.php');
define ('INC_SINPUTSELECT',PATH_STRUCTURE.'sInputSelect.php');
define ('INC_SINPUTTEXT',PATH_STRUCTURE.'sInputText.php');
define ('INC_SLISTE',PATH_STRUCTURE.'sListe.php');
define ('INC_SLISTEPLIANTE',PATH_STRUCTURE.'sListePliante.php');
define ('INC_SLISTEPLIANTESTATIQUE',PATH_STRUCTURE.'sListePlianteStatique.php');
define ('INC_SLISTEREFERENTIEL',PATH_STRUCTURE.'sListeReferentiel.php');
define ('INC_SLISTESTATIQUE',PATH_STRUCTURE.'sListeStatique.php');
define ('INC_SLISTETITRECONTENU',PATH_STRUCTURE.'sListeTitreContenu.php');
define ('INC_SORGANISEUR',PATH_STRUCTURE.'sOrganiseur.php');
define ('INC_SPALETTE',PATH_STRUCTURE.'sPalette.php');
define ('INC_SSEPARATEUR',PATH_STRUCTURE.'sSeparateur.php');
define ('INC_STABLEAU',PATH_STRUCTURE.'sTableau.php');
define ('INC_STEXT',PATH_STRUCTURE.'sText.php');
define ('INC_SVISUALISEUR',PATH_STRUCTURE.'sVisualiseur.php');

define ('INC_CSS',PATH_CSS.'css.php');
define ('INC_CSSATTRIBUT',PATH_CSS.'cssAttribut.php');
define ('INC_CSSATTRIBUTCONTENEUR',PATH_CSS.'cssAttributConteneur.php');
define ('INC_CSSATTRIBUTCONTENEURCONTENU',PATH_CSS.'cssAttributConteneurContenu.php');
define ('INC_CSSATTRIBUTCOULEUR',PATH_CSS.'cssAttributCouleur.php');
define ('INC_CSSATTRIBUTPIXEL',PATH_CSS.'cssAttributPixel.php');
define ('INC_CSSCONSTRUCTEUR',PATH_CSS.'cssConstructeur.php');
define ('INC_CSSELEMENT',PATH_CSS.'cssElement.php');
define ('INC_CSSELEMENTAMI',PATH_CSS.'cssElementAmi.php');
define ('INC_CSSLISTE',PATH_CSS.'cssListe.php');
define ('INC_CSSLISTESTYLES',PATH_CSS.'cssListeStyles.php');
define ('INC_CSSPARSEUR',PATH_CSS.'cssParseur.php');

define ('INC_JSLISTESCRIPTS',PATH_JS.'jsListeScripts.php');
define ('INC_JSFONCTION',PATH_JS.'jsFonction.php');

define ('INC_GBASE',PATH_GLOBAL.'gBase.php');
define ('INC_GCSS',PATH_GLOBAL.'gCss.php');
define ('INC_GCONTEXTE',PATH_GLOBAL.'gContexte.php');
define ('INC_GDATE',PATH_GLOBAL.'gDate.php');
define ('INC_GDROIT',PATH_GLOBAL.'gDroit.php');
define ('INC_GJS',PATH_GLOBAL.'gJs.php');
define ('INC_GLOCALISATION',PATH_GLOBAL.'gLocalisation.php');
define ('INC_GLOG',PATH_GLOBAL.'gLog.php');
define ('INC_GREFERENTIEL',PATH_GLOBAL.'gReferentiel.php');
define ('INC_GREPONSE',PATH_GLOBAL.'gReponse.php');
define ('INC_GSESSION',PATH_GLOBAL.'gSession.php');
define ('INC_GTEXTE',PATH_GLOBAL.'gTexte.php');


// Constantes d'id pour la présentation.
define ('CADRE_PRINCIPAL','cadre_principal');
define ('CADRE_BACKGROUND','cadre_background');
define ('CADRE_BANNIERE','cadre_banniere');
define ('CADRE_BANNIERE_BANNIERE','cadre_banniere_banniere');
define ('CADRE_BANNIERE_PUB','cadre_banniere_pub');
define ('CADRE_CHAT','cadre_chat');
define ('CADRE_CHAT_CHAT','cadre_chat_chat');
define ('CADRE_CHAT_PUB','cadre_chat_pub');
define ('CADRE_MENU','cadre_menu');
define ('CADRE_MENU_MENU','cadre_menu_menu');
define ('CADRE_MENU_PUB','cadre_menu_pub');
define ('CADRE_CONTENU','cadre_contenu');
define ('CADRE_CONTENU_CONTENU','cadre_contenu_contenu');
define ('CADRE_CONTENU_PUB','cadre_contenu_pub');
define ('CADRE_BARREINFO','cadre_barreinfo');
define ('CADRE_INFO','cadre_info');
define ('CADRE_INFO_JOUEUR','cadre_info_joueur');
define ('CADRE_INFO_GROUPE','cadre_info_groupe');
define ('CADRE_INFO_AJAX','cadre_info_ajax');
define ('CADRE_INFO_LANGUE','cadre_info_langue');
define ('CADRE_INFO_COMMUNAUTE','cadre_info_communaute');
define ('CADRE_INFO_ERREUR','cadre_info_erreur');
define ('CADRE_H','_h'); // Haut.
define ('CADRE_HG','_hg'); // Haut Gauche.
define ('CADRE_G','_g'); // Gauche.
define ('CADRE_BG','_bg'); // Bas Gauche.
define ('CADRE_B','_b'); // Bas.
define ('CADRE_BD','_bd'); // Bas Droite.
define ('CADRE_D','_d'); // Droite.
define ('CADRE_HD','_hd'); // Haut Droite.


// Constantes de class.
define ('TABLE_MAXLARGEUR', 'table_maxlargeur');

define ('INFO_CONNEXION','info_connexion');
define ('INFO_DECONNEXION','info_deconnexion');
define ('INFO_GROUPE','info_groupe');
define ('INFO_JOUEUR','info_joueur');
define ('INFO_LOGIN','info_login');
define ('INFO_MOTDEPASSE','info_motdepasse');
define ('INFO_PERSO','info_perso');

define ('CLASSCADRE_AIDE','classecadre_aide');
define ('CLASSCADRE_INFO','classecadre_info');
define ('CLASSCADRE_ERREUR','classecadre_erreur');

define ('CLASSTEXTE_INFO','classetexte_info');

define ('CLASSSEPARATEUR','classesep');


// Constantes représentant les langues.
define ('LANGUE_FRANCAISE',1);
define ('LANGUE_ANGLAISE',2);


// Constantes représentant les types de groupes généraux.
define ('TYPEGROUPE_COMMUNAUTE',3);
define ('TYPEGROUPE_JEU',4);


// Constantes représentant les noms des fonctions ajax disponibles.
define ('AJAXFONC_AJOUTERAUCONTEXTE', 'AjouterAuContexte');
define ('AJAXFONC_MODIFIERDANSCONTEXTE', 'ModifierDansContexte');
define ('AJAXFONC_SUPPRIMERDUCONTEXTE', 'SupprimerDuContexte');
define ('AJAXFONC_CHARGERCONTEXTES', 'ChargerContextes');
define ('AJAXFONC_CHARGERREFERENTIELCONTEXTE', 'ChargerReferentielContexte');
define ('AJAXFONC_AJOUTERAUREFERENTIEL', 'AjouterAuReferentiel');
define ('AJAXFONC_SUPPRIMERDUREFERENTIEL', 'SupprimerDuReferentiel');
define ('AJAXFONC_RECHARGER', 'Recharger');
define ('AJAXFONC_CLIQUERCONTEXTE', 'CliquerContexte');


require_once INC_CSTPIC;

?>