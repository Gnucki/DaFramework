<?php

require_once 'cst.php';
require_once INC_SELEMORG;
require_once INC_SINPUT;
require_once INC_SINPUTCOLOR;


define ('PALETTE', '_palette');
define ('PALETTE_TITRE', '_palette_titre');
define ('PALETTE_CADRETITRE', '_palette_cadretitre');
define ('PALETTE_CADRECOULEUR', '_palette_cadrecouleur');
define ('PALETTE_INDIC', '_palette_indic');
define ('PALETTE_VISUALISEUR', '_palette_visualiseur');
define ('PALETTE_EDITEUR', '_palette_editeur');
define ('PALETTE_SLIDER', '_palette_slider');
define ('PALETTE_INCDEC', '_palette_incdec');
define ('PALETTE_INC', '_palette_inc');
define ('PALETTE_DEC', '_palette_dec');
define ('PALETTE_TEXTE', '_palette_texte');
define ('PALETTE_MEMOIRE', '_palette_memoire');
define ('PALETTE_COULEUR', '_palette_couleur');

define ('BUFFERCOULEUR_JQ', 'jq_buffercouleur');
define ('BUFFERCOULEUR_JQ_CADRE', 'jq_buffercouleur_cadre');
define ('BUFFERCOULEUR_JQ_CADRECOULEUR', 'jq_buffercouleur_cadrecouleur');
define ('BUFFERCOULEUR_JQ_CADRETITRE', 'jq_buffercouleur_cadretitre');
define ('BUFFERCOULEUR_JQ_INDIC', 'jq_buffercouleur_indic');

define ('INPUTCOLOR_JQ', 'jq_inputcolor');
define ('INPUTCOLOR_JQ_CAL', 'jq_inputcolor_cal');
define ('INPUTCOLOR_JQ_VISUALISEUR', 'jq_inputcolor_visualiseur');
define ('INPUTCOLOR_JQ_EDITEUR', 'jq_inputcolor_editeur');
define ('INPUTCOLOR_JQ_COLOR', 'jq_inputcolor_color');
define ('INPUTCOLOR_JQ_HUE', 'jq_inputcolor_hue');
define ('INPUTCOLOR_JQ_NEW_COLOR', 'jq_inputcolor_new_color');
define ('INPUTCOLOR_JQ_FIELD', 'jq_inputcolor_field');
define ('INPUTCOLOR_JQ_HEX', 'jq_inputcolor_hex');
define ('INPUTCOLOR_JQ_RGB_R', 'jq_inputcolor_rgb_r');
define ('INPUTCOLOR_JQ_RGB_G', 'jq_inputcolor_rgb_g');
define ('INPUTCOLOR_JQ_RGB_B', 'jq_inputcolor_rgb_b');
define ('INPUTCOLOR_JQ_HSB_H', 'jq_inputcolor_hsb_h');
define ('INPUTCOLOR_JQ_HSB_S', 'jq_inputcolor_hsb_s');
define ('INPUTCOLOR_JQ_HSB_B', 'jq_inputcolor_hsb_b');
define ('INPUTCOLOR_JQ_COMPOSANTE', 'jq_inputcolor_composante');
define ('INPUTCOLOR_JQ_COMPOSANTE_ROUGE', 'jq_inputcolor_composante_rouge');
define ('INPUTCOLOR_JQ_COMPOSANTE_VERTE', 'jq_inputcolor_composante_verte');
define ('INPUTCOLOR_JQ_COMPOSANTE_BLEUE', 'jq_inputcolor_composante_bleue');
define ('INPUTCOLOR_JQ_COMPOSANTE_SLIDER', 'jq_inputcolor_composante_slider');
define ('INPUTCOLOR_JQ_COMPOSANTE_TEXT', 'jq_inputcolor_composante_text');
define ('INPUTCOLOR_JQ_SUIV', 'jq_inputcolor_suiv');
define ('INPUTCOLOR_JQ_PREC', 'jq_inputcolor_prec');


class SPalette extends SBalise
{
    public function __construct($prefixIdClass, $titre)
    {
       	parent::__construct(BAL_DIV);
       	$this->AddClass(BUFFERCOULEUR_JQ);

		$cadre = new SElemOrg(2, 1, $prefixIdClass.PALETTE, false, false, false);
		$cadre->AjouterClasse(PALETTE);
		$cadre->AddClass(BUFFERCOULEUR_JQ_CADRE);
		$this->Attach($cadre);


		// Titre.
		$divTitre = new SBalise(BAL_DIV);
		$divTitre->AddClass(BUFFERCOULEUR_JQ_CADRETITRE);
		$elemTitre = new SElemOrg(1, 2, $prefixIdClass.PALETTE_CADRETITRE, true);
		$elemTitre->AjouterClasse(PALETTE_CADRETITRE);
		$elem = new SElement($prefixIdClass.PALETTE_TITRE);
		$elem->AjouterClasse(PALETTE_TITRE);
		$elem->SetText($titre);
		$elemTitre->AttacherCellule(1, 1, $elem);
		$elemTitre->SetCelluleDominante(1, 1);
		$elemIndic = new SElement($prefixIdClass.PALETTE_INDIC);
		$elemIndic->AjouterClasse(PALETTE_INDIC);
		$elemIndic->AddClass(BUFFERCOULEUR_JQ_INDIC);
		$elemIndic->SetText('-');
		$elemTitre->AttacherCellule(1, 2, $elemIndic);
		$divTitre->Attach($elemTitre);
		$cadre->AttacherCellule(1, 1, $divTitre);


		// Couleur.
		$divCouleur = new SBalise(BAL_DIV);
		$divCouleur->AddClass(BUFFERCOULEUR_JQ_CADRECOULEUR);
		$elemCouleur = new SElement($prefixIdClass.PALETTE_CADRECOULEUR);
		$elemCouleur->AjouterClasse(PALETTE_CADRECOULEUR);
		$divCouleur->Attach($elemCouleur);

		$divInputColor = new SBalise(BAL_DIV);
		$divInputColor->AddClass(INPUTCOLOR_JQ);
		$orgInputColor = new SOrganiseur(1, 2, true);
		$orgInputColor->SetCelluleDominante(1, 1);
		$divInputColor->Attach($orgInputColor);
		$elemCouleur->Attach($divInputColor);
		//
		// Partie visualisation.
		$elemOrgVisualiseur = new SElemOrg(1, 10, $prefixIdClass.PALETTE_VISUALISEUR, false, false, false);
		$elemOrgVisualiseur->AjouterClasse(PALETTE_VISUALISEUR);
		$elemOrgVisualiseur->AjouterClasseTableau(INPUTCOLOR_JQ_CAL);
		$div1 = new SBalise(BAL_DIV);
		$div2 = new SBalise(BAL_DIV);
		$img = new SImage(PATH_IMAGES.'Css/jq_inputcolor_overlay.png');
		$div1->Attach($img);
		$div1->Attach($div2);
		$elemOrgVisualiseur->AjouterClasseCellule(1, 1, INPUTCOLOR_JQ_COLOR);
		$elemOrgVisualiseur->AttacherCellule(1, 1, $div1);
		//
		$div = new SBalise(BAL_DIV);
		$img = new SImage(PATH_IMAGES.'Css/jq_inputcolor_slider.jpg');
		//$img->AddProp(PROP_STYLE, 'display: none');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 2, INPUTCOLOR_JQ_HUE);
		$elemOrgVisualiseur->AttacherCellule(1, 2, $img);
		$elemOrgVisualiseur->AttacherCellule(1, 2, $div);
		//
		$elemOrgVisualiseur->AjouterClasseCellule(1, 3, INPUTCOLOR_JQ_NEW_COLOR);
		//
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '6');
		$input->AddProp(PROP_SIZE, '6');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 4, INPUTCOLOR_JQ_HEX);
		$elemOrgVisualiseur->AttacherCellule(1, 4, $input);
		//
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 5, INPUTCOLOR_JQ_FIELD);
		$elemOrgVisualiseur->AjouterClasseCellule(1, 5, INPUTCOLOR_JQ_RGB_R);
		$elemOrgVisualiseur->AttacherCellule(1, 5, $input);
		//
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 6, INPUTCOLOR_JQ_FIELD);
		$elemOrgVisualiseur->AjouterClasseCellule(1, 6, INPUTCOLOR_JQ_RGB_G);
		$elemOrgVisualiseur->AttacherCellule(1, 6, $input);
		//
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 7, INPUTCOLOR_JQ_FIELD);
		$elemOrgVisualiseur->AjouterClasseCellule(1, 7, INPUTCOLOR_JQ_RGB_B);
		$elemOrgVisualiseur->AttacherCellule(1, 7, $input);
		//
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 8, INPUTCOLOR_JQ_FIELD);
		$elemOrgVisualiseur->AjouterClasseCellule(1, 8, INPUTCOLOR_JQ_HSB_H);
		$elemOrgVisualiseur->AttacherCellule(1, 8, $input);
		//
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 9, INPUTCOLOR_JQ_FIELD);
		$elemOrgVisualiseur->AjouterClasseCellule(1, 9, INPUTCOLOR_JQ_HSB_S);
		$elemOrgVisualiseur->AttacherCellule(1, 9, $input);
		//
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$elemOrgVisualiseur->AjouterClasseCellule(1, 10, INPUTCOLOR_JQ_FIELD);
		$elemOrgVisualiseur->AjouterClasseCellule(1, 10, INPUTCOLOR_JQ_HSB_B);
		$elemOrgVisualiseur->AttacherCellule(1, 10, $input);
		$orgInputColor->AjouterClasseCellule(1, 1, INPUTCOLOR_JQ_VISUALISEUR);
		$orgInputColor->AttacherCellule(1, 1, $elemOrgVisualiseur);
		//
		// Partie édition.
		$elemOrgEditeur = new SElemOrg(3, 3, $prefixIdClass.PALETTE_EDITEUR);
		$elemOrgEditeur->AjouterClasse(PALETTE_EDITEUR);
		$elemOrgEditeur->AjouterClasseLigne(1, INPUTCOLOR_JQ_COMPOSANTE);
		$elem = new SElement($prefixIdClass.PALETTE_SLIDER);
		$elem->AjouterClasse(PALETTE_SLIDER);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(INPUTCOLOR_JQ_COMPOSANTE_SLIDER);
		$div->AddClass('jq_fill');
		$elem->Attach($div);
		$elemOrgEditeur->AjouterClasseCellule(1, 1, INPUTCOLOR_JQ_COMPOSANTE_ROUGE);
		$elemOrgEditeur->AttacherCellule(1, 1, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_SLIDER);
		$elem->AjouterClasse(PALETTE_SLIDER);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(INPUTCOLOR_JQ_COMPOSANTE_SLIDER);
		$div->AddClass('jq_fill');
		$elem->Attach($div);
		$elemOrgEditeur->AjouterClasseCellule(1, 2, INPUTCOLOR_JQ_COMPOSANTE_VERTE);
		$elemOrgEditeur->AttacherCellule(1, 2, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_SLIDER);
		$elem->AjouterClasse(PALETTE_SLIDER);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(INPUTCOLOR_JQ_COMPOSANTE_SLIDER);
		$div->AddClass('jq_fill');
		$elem->Attach($div);
		$elemOrgEditeur->AjouterClasseCellule(1, 3, INPUTCOLOR_JQ_COMPOSANTE_BLEUE);
		$elemOrgEditeur->AttacherCellule(1, 3, $elem);
		//
		$elemOrg = new SElemOrg(1, 2, $prefixIdClass.PALETTE_INCDEC, true);
		$elemOrg->AjouterClasse(PALETTE_INCDEC);
		$elemInc = new SElement($prefixIdClass.PALETTE_INC);
		$elemInc->AjouterClasse(PALETTE_INC);
		$elemInc->SetText('+');
		$elemOrg->AjouterClasseCellule(1, 1, INPUTCOLOR_JQ_SUIV);
		$elemOrg->AttacherCellule(1, 1, $elemInc);
		$elemDec = new SElement($prefixIdClass.PALETTE_DEC);
		$elemDec->AjouterClasse(PALETTE_DEC);
		$elemDec->SetText('-');
		$elemOrg->AjouterClasseCellule(1, 2, INPUTCOLOR_JQ_PREC);
		$elemOrg->AttacherCellule(1, 2, $elemDec);
		$elemOrgEditeur->AttacherCellule(2, 1, $elemOrg);
		//
		$elemOrg = new SElemOrg(1, 2, $prefixIdClass.PALETTE_INCDEC, true);
		$elemOrg->AjouterClasse(PALETTE_INCDEC);
		$elemInc = new SElement($prefixIdClass.PALETTE_INC);
		$elemInc->AjouterClasse(PALETTE_INC);
		$elemInc->SetText('+');
		$elemOrg->AjouterClasseCellule(1, 1, INPUTCOLOR_JQ_SUIV);
		$elemOrg->AttacherCellule(1, 1, $elemInc);
		$elemDec = new SElement($prefixIdClass.PALETTE_DEC);
		$elemDec->AjouterClasse(PALETTE_DEC);
		$elemDec->SetText('-');
		$elemOrg->AjouterClasseCellule(1, 2, INPUTCOLOR_JQ_PREC);
		$elemOrg->AttacherCellule(1, 2, $elemDec);
		$elemOrgEditeur->AttacherCellule(2, 2, $elemOrg);
		//
		$elemOrg = new SElemOrg(1, 2, $prefixIdClass.PALETTE_INCDEC, true);
		$elemOrg->AjouterClasse(PALETTE_INCDEC);
		$elemInc = new SElement($prefixIdClass.PALETTE_INC);
		$elemInc->AjouterClasse(PALETTE_INC);
		$elemInc->SetText('+');
		$elemOrg->AjouterClasseCellule(1, 1, INPUTCOLOR_JQ_SUIV);
		$elemOrg->AttacherCellule(1, 1, $elemInc);
		$elemDec = new SElement($prefixIdClass.PALETTE_DEC);
		$elemDec->AjouterClasse(PALETTE_DEC);
		$elemDec->SetText('-');
		$elemOrg->AjouterClasseCellule(1, 2, INPUTCOLOR_JQ_PREC);
		$elemOrg->AttacherCellule(1, 2, $elemDec);
		$elemOrgEditeur->AttacherCellule(2, 3, $elemOrg);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$input->AddProp(PROP_VALUE, '127');
		$elem->Attach($input);
		$elemOrgEditeur->AjouterClasseCellule(3, 1, INPUTCOLOR_JQ_COMPOSANTE_TEXT);
		$elemOrgEditeur->AttacherCellule(3, 1, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$input->AddProp(PROP_VALUE, '127');
		$elem->Attach($input);
		$elemOrgEditeur->AjouterClasseCellule(3, 2, INPUTCOLOR_JQ_COMPOSANTE_TEXT);
		$elemOrgEditeur->AttacherCellule(3, 2, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$input = new SInput();
		$input->AddProp(PROP_MAXLENGTH, '3');
		$input->AddProp(PROP_SIZE, '3');
		$input->AddProp(PROP_VALUE, '127');
		$elem->Attach($input);
		$elemOrgEditeur->AjouterClasseCellule(3, 3, INPUTCOLOR_JQ_COMPOSANTE_TEXT);
		$elemOrgEditeur->AttacherCellule(3, 3, $elem);
		//
		$orgInputColor->AjouterClasseCellule(1, 2, INPUTCOLOR_JQ_EDITEUR);
		$orgInputColor->AttacherCellule(1, 2, $elemOrgEditeur);
		$cadre->AttacherCellule(2, 1, $divCouleur);

		// Mémoire.
		$elemOrgMemoire = new SElemOrg(1, 10, $prefixIdClass.PALETTE_MEMOIRE, true, true, false);
		$elemOrgMemoire->AjouterClasse(PALETTE_MEMOIRE);
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 1, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 2, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 3, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 4, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 5, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 6, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 7, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 8, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 9, $elem);
		//
		$elem = new SElement($prefixIdClass.PALETTE_TEXTE);
		$elem->AjouterClasse(PALETTE_TEXTE);
		$div = new SBalise(BAL_DIV);
		$div->AddClass(COLOR_JQ);
		$elem->Attach($div);
		$elemOrgMemoire->AttacherCellule(1, 10, $elem);
		$elemCouleur->Attach($elemOrgMemoire);
	}

}

?>