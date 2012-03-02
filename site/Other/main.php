<?php

header('Content-Type: text/html; charset=utf-8');


require_once 'cst.php';
require_once INC_SBALISE;
require_once INC_JSLISTESCRIPTS;
require_once INC_JSFONCTION;
require_once INC_CSSLISTESTYLES;
require_once INC_CSTCSS;
require_once INC_CSTJS;


// Entête.
echo '<?xml version="1.0" encoding="utf-8"?>';
//echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
//"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"> ';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n\n";


// Création des Balises HTML principales.
$html = new SBalise(BAL_HTML);
$html->AddProp(PROP_XMLNS, 'http://www.w3.org/1999/xhtml');
$head = new SBalise(BAL_HEAD);
$body = new SBalise(BAL_BODY);

// Head et Body appartiennent à la balise générale HTML.
$html->Attach($head);
$html->Attach($body);


// Chargement de la balise head.
// Title
$titre = new SBalise(BAL_TITLE);
$titre->SetText('Vive le Texas!!');

// Meta.
$metaUTF8 = new SBalise(BAL_META);
$metaUTF8->AddProp(PROP_HTTPEQUIV, 'Content-Type');
$metaUTF8->AddProp(PROP_CONTENT, 'text/html; charset=utf-8');

$metaCss = new SBalise(BAL_META);
$metaCss->AddProp(PROP_HTTPEQUIV, 'Content-Style-Type');
$metaCss->AddProp(PROP_CONTENT, 'text/css');

$metaIE8 = new SBalise(BAL_META);
$metaIE8->AddProp(PROP_HTTPEQUIV, 'X-UA-Compatible');
$metaIE8->AddProp(PROP_CONTENT, 'IE=8');

$metaNoCache1 = new SBalise(BAL_META);
$metaNoCache1->AddProp(PROP_HTTPEQUIV, 'Pragma');
$metaNoCache1->AddProp(PROP_CONTENT, 'no-cache');

$metaNoCache2 = new SBalise(BAL_META);
$metaNoCache2->AddProp(PROP_HTTPEQUIV, 'Cache-Control');
$metaNoCache2->AddProp(PROP_CONTENT, 'no-cache');

// Ajout des différents fichiers CSS (ordre important!!!).
$css = CssListeStyles::GetInstance();
$css->AddStyle(CSS_GLOBAL_FILE);
/*$css->AddStyle(CSS_GENERAL_FILE);
//$css->AddStyle(CSS_AMI_FILE);
$css->AddStyle(CSS_BARREINFO_FILE);
$css->AddStyle(CSS_CONNEXION_FILE);
//$css->AddStyle(CSS_EVENEMENT_FILE);
//$css->AddStyle(CSS_EDITIONPRESENTATION_FILE);
//$css->AddStyle(CSS_FORUM_FILE);
//$css->AddStyle(CSS_MENU_FILE);*/
$css->AddStyle(CSS_ORGANISATION_FILE);
//$css->AddStyle(CSS_TEST_FILE);

// Ajout des différents fichiers Javascript (ordre important!!!).
$js = JsListeScripts::GetInstance();
$js->AddScript(JS_JQUERY_FILE);
$js->AddScript(JS_JQCORE_FILE);
$js->AddScript(JS_JQWIDGET_FILE);
$js->AddScript(JS_JQPOSITION_FILE);
$js->AddScript(JS_JQMOUSE_FILE);
$js->AddScript(JS_JQCOREEXTEND_FILE);
$js->AddScript(JS_JQSLIDER_FILE);
$js->AddScript(JS_JQDRAG_FILE);
$js->AddScript(JS_JQDROP_FILE);
$js->AddScript(JS_JQSORT_FILE);
$js->AddScript(JS_JQEFFECTCORE_FILE);
$js->AddScript(JS_JQEFFECTHIGHLIGHT_FILE);
$js->AddScript(JS_FILL_FILE);
$js->AddScript(JS_CLIGNO_FILE);
$js->AddScript(JS_VARIABLES_FILE);
$js->AddScript(JS_INFOBULLE_FILE);
$js->AddScript(JS_INPUTTRIGGER_FILE);
$js->AddScript(JS_INPUTTEXT_FILE);
$js->AddScript(JS_INPUTSELECT_FILE);
$js->AddScript(JS_INPUTCHECKBOX_FILE);
$js->AddScript(JS_INPUTNEW_FILE);
$js->AddScript(JS_INPUTFILE_FILE);
$js->AddScript(JS_INPUTIMAGE_FILE);
$js->AddScript(JS_INPUTCOLOR_FILE);
$js->AddScript(JS_VISUALISEUR_FILE);
$js->AddScript(JS_POPDIV_FILE);
$js->AddScript(JS_INPUTBUTTON_FILE);
$js->AddScript(JS_CLASSEUR);
$js->AddScript(JS_INPUTLISTE_FILE);
$js->AddScript(JS_INPUTLISTEDOUBLE_FILE);
$js->AddScript(JS_LISTE);
$js->AddScript(JS_CSS_FILE);
$js->AddScript(JS_GLOBALTIMER_FILE);
$js->AddScript(AJAX);

$head->Attach($titre);
$head->Attach($metaUTF8);
$head->Attach($metaCss);
$head->Attach($metaIE8);
//$head->Attach($metaNoCache1);
//$head->Attach($metaNoCache2);
$head->Attach($css);
$head->Attach($js);


// Appel de la fonction Ajax de chargement de la balise body.
$jsFonc = new JsFonction('ChargerOrganisation', 0);
$jsBal = new SBalise(BAL_SCRIPT);
$jsBal->AddProp(PROP_TYPE, 'text/javascript');
$jsBal->SetText($jsFonc->BuildJS().';');
$div = new SBalise(BAL_DIV);
$div->AddProp(PROP_ID, 'main');
$body->Attach($div);
$body->Attach($jsBal);


// Traduction des objets en balises HTML.
echo $html->BuildHTML();

?>