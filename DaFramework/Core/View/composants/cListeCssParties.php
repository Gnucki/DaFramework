<?php

require_once 'cst.php';
require_once INC_SLISTEPLIANTESTATIQUE;


class CListeCssParties extends SListePlianteStatique
{
   	protected $nomFichier;
   	protected $presentation;

   	public function __construct($nomFichier, $presentation, $prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage = 20, $nbElementsTotal = -1, $chargementContenuDiffere = false)
    {
       	parent::__construct($prefixIdClass, $typeSynchro, $contexte, $nbElementsParPage, $nbElementsTotal, $chargementContenuDiffere);

       	$this->nomFichier = $nomFichier;
    	$this->presentation = $presentation;
    }

	protected function InitialiserChamps()
	{
		$this->AjouterChamp(COL_LIBELLE, '', false, false);
		$this->AjouterChamp('vue', '', false, false, NULL, NULL, NULL, NULL, NULL, false);
	}

	public function AjouterElement($libelle, $vue)
	{
		$element = array();
		$this->SetElemValeurChamp($element, COL_LIBELLE, $libelle);
		$this->SetElemValeurChamp($element, 'vue', $vue);
		$this->elements[] = $element;
	}

	protected function HasDroitConsultation($element)
	{
		return true;
	}

	protected function ConstruireLigneTitre()
	{
		return NULL;
	}

	protected function ConstruireElemConsultation(&$element)
	{
	   	$vue = $this->GetElemChampValeurConsultation($element, 'vue');

	   	/*-------------------------------------------------------------*/
	   	$cListeCssSousElements = new CListeCssSousElements($this->prefixIdClass, 'CssSousElements', $this->contexte, -1);
	   	$cListeCssSousElements->SetListeParente($this);
		$niveau = $cListeCssSousElements->Niveau();

		$classe = 'classe';
		$classeTab = $classe.'_tab';

		// Premier Plan.
	   	$org1 = new SOrganiseur(2, 1, true, true);
	   	$org2 = new SOrganiseur(1, 4, true, true);
	   	// Couleur du fond.
	   	$color = new SInputColor($this->prefixIdClass, COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BACKGROUNDCOLOR));
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPCOULEURFOND, true, true), $color, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
	   	$org2->AttacherCellule(1, 1, $inputLabel);
	   	// Image de fond.
		$img = new SInputImage($this->prefixIdClass, INPUTFILE_TYPE_LISTEIMAGE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BACKGROUNDIMAGE), '', GSession::Groupe(COL_ID), '', '', TYPEFICHIER_IMAGEGROUPE, $this->contexte, $niveau);
		GReferentiel::AjouterReferentielFichiers('images', GCss::GetCheminFichiersImages(), REF_FICHIERSEXTENSIONS_IMAGES);
		$img->AjouterElementsFromListe('images', false);
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPIMAGE, true, true), $img, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 2, $inputLabel);
		// Répétition de l'image de fond.
		$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BACKGROUNDREPEAT), '', '', '', '', '', '', '', '', '', $niveau);
		$select->AjouterElement('no-repeat', 'no-repeat', '');
		$select->AjouterElement('repeat', 'repeat', '');
	   	$select->AjouterElement('repeat-x', 'repeat-x', '');
	   	$select->AjouterElement('repeat-y', 'repeat-y', '');
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPREPETITION, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 3, $inputLabel);
		// Transparence.
		$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_OPACITY), '', 0, 0, 3, false, '%', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 100, $niveau);
	   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPTRANSPARENCE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 4, $inputLabel);
	   	$org1->AttacherCellule(1, 1, $org2);
		$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SEPREMIERPLAN, true, true), $org1);

		/*****************************************************/
		// Second Plan.
		$org1 = new SOrganiseur(2, 1, true, true);
	   	$org2 = new SOrganiseur(1, 4, true, true);
	   	// Couleur du fond.
	   	$color = new SInputColor($this->prefixIdClass, COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_BACKGROUNDCOLOR));
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPCOULEURFOND, true, true), $color, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
	   	$org2->AttacherCellule(1, 1, $inputLabel);
	   	// Image de fond.
		$img = new SInputImage($this->prefixIdClass, INPUTFILE_TYPE_LISTEIMAGE, false, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_BACKGROUNDIMAGE), '', GSession::Groupe(COL_ID), '', '', TYPEFICHIER_IMAGEGROUPE, $this->contexte, $niveau);
		GReferentiel::AjouterReferentielFichiers('images', GCss::GetCheminFichiersImages(), REF_FICHIERSEXTENSIONS_IMAGES);
		$img->AjouterElementsFromListe('images', false);
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPIMAGE, true, true), $img, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 2, $inputLabel);
		// Répétition de l'image de fond.
		$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_BACKGROUNDREPEAT), '', '', '', '', '', '', '', '', '', $niveau);
	   	$select->AjouterElement('no-repeat', 'no-repeat', '');
		$select->AjouterElement('repeat', 'repeat', '');
	   	$select->AjouterElement('repeat-x', 'repeat-x', '');
	   	$select->AjouterElement('repeat-y', 'repeat-y', '');
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPREPETITION, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 3, $inputLabel);
		// Transparence.
		$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_OPACITY), '', 0, 0, 3, false, '%', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 100, $niveau);
	   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPTRANSPARENCE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 4, $inputLabel);
	   	$org1->AttacherCellule(1, 1, $org2);
		$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SESECONDPLAN, true, true), $org1);

	   	/*****************************************************/
	   	// Cadre.
	   	$org1 = new SOrganiseur(2, 1, true, true);
	   	//$org2 = new SOrganiseur(2, 1, true, true);
	   	//$org1->AttacherCellule(1, 1, $org2);
	   	$org3 = new SOrganiseur(4, 1, true, true);
	   	$org1->AttacherCellule(2, 1, $org3);
	   	// Marge intérieure.
	   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CMARGEINT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
	   	$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CHAUT, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGTOP), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CGAUCHE, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGLEFT), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CBAS, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGBOTTOM), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CDROIT, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGRIGHT), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$org1->AttacherCellule(1, 1, $inputLabel);
		//Marge extérieure.
		/*$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CMARGEEXT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CHAUT), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINTOP), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CGAUCHE), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINLEFT), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CBAS), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINBOTTOM), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CDROIT), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINRIGHT), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$org2->AttacherCellule(2, 1, $inputLabel);*/
		//Bord haut.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDHAUT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR, true, true), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERTOPCOLOR));
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERTOPWIDTH), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE, true, true), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERTOPSTYLE));
		$select->AjouterElement('none', 'none', '');
	   	$select->AjouterElement('dotted', 'dotted', '');
	   	$select->AjouterElement('dashed', 'dashed', '');
	   	$select->AjouterElement('solid', 'solid', '');
	   	$select->AjouterElement('double', 'double', '');
	   	$select->AjouterElement('groove', 'groove', '');
	   	$select->AjouterElement('ridge', 'ridge', '');
	   	$select->AjouterElement('inset', 'inset', '');
	   	$select->AjouterElement('outset', 'outset', '');
		$org3->AttacherCellule(1, 1, $inputLabel);
		//Bord gauche.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDGAUCHE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERLEFTCOLOR));
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERLEFTWIDTH), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERLEFTSTYLE));
		$select->AjouterElement('none', 'none', '');
	   	$select->AjouterElement('dotted', 'dotted', '');
	   	$select->AjouterElement('dashed', 'dashed', '');
	   	$select->AjouterElement('solid', 'solid', '');
	   	$select->AjouterElement('double', 'double', '');
	   	$select->AjouterElement('groove', 'groove', '');
	   	$select->AjouterElement('ridge', 'ridge', '');
	   	$select->AjouterElement('inset', 'inset', '');
	   	$select->AjouterElement('outset', 'outset', '');
		$org3->AttacherCellule(2, 1, $inputLabel);
		//Bord bas.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDBAS, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERBOTTOMCOLOR));
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERBOTTOMWIDTH), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERBOTTOMSTYLE));
		$select->AjouterElement('none', 'none', '');
	   	$select->AjouterElement('dotted', 'dotted', '');
	   	$select->AjouterElement('dashed', 'dashed', '');
	   	$select->AjouterElement('solid', 'solid', '');
	   	$select->AjouterElement('double', 'double', '');
	   	$select->AjouterElement('groove', 'groove', '');
	   	$select->AjouterElement('ridge', 'ridge', '');
	   	$select->AjouterElement('inset', 'inset', '');
	   	$select->AjouterElement('outset', 'outset', '');
		$org3->AttacherCellule(3, 1, $inputLabel);
		//Bord droit.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDDROIT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERRIGHTCOLOR));
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERRIGHTWIDTH), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
		$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERRIGHTSTYLE));
		$select->AjouterElement('none', 'none', '');
	   	$select->AjouterElement('dotted', 'dotted', '');
	   	$select->AjouterElement('dashed', 'dashed', '');
	   	$select->AjouterElement('solid', 'solid', '');
	   	$select->AjouterElement('double', 'double', '');
	   	$select->AjouterElement('groove', 'groove', '');
	   	$select->AjouterElement('ridge', 'ridge', '');
	   	$select->AjouterElement('inset', 'inset', '');
	   	$select->AjouterElement('outset', 'outset', '');
		$org3->AttacherCellule(4, 1, $inputLabel);
		$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SECADRE, true, true), $org1);

		/*****************************************************/
	   	// Alignement.
		//$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SEALIGNEMENT, true, true), 'gnu testa');

	   	/*****************************************************/
	   	// Texte.
		$org1 = new SOrganiseur(2, 1, true, true);
	   	$org2 = new SOrganiseur(1, 4, true, true);
	   	// Couleur.
	   	$color = new SInputColor($this->prefixIdClass, COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_COLOR));
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TCOULEUR, true, true), $color, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
	   	$org2->AttacherCellule(1, 1, $inputLabel);
	   	// Police.
	   	$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTFAMILY), '', '', '', '', '', '', '', '', '', $niveau);
	   	$select->AjouterElement('Arial sans serif', 'Arial', '');
	   	$select->AjouterElement('Helvetica sans serif', 'Helvetica', '');
	   	$select->AjouterElement('MS sans serif', 'MS', '');
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TPOLICE, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 2, $inputLabel);
		// Taille.
		$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTSIZE), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 40, $niveau);
	   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TTAILLE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 3, $inputLabel);
		// Indentation.
		$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_TEXTINDENT), '', 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 40, $niveau);
	   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TINDENTATION, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org2->AttacherCellule(1, 4, $inputLabel);
		$org1->AttacherCellule(1, 1, $org2);
		// Style.
		$org3 = new SOrganiseur(1, 4, true, true);
		$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTSTYLE), '', '', '', '', '', '', '', '', '', $niveau);
	   	$select->AjouterElement('normal', 'normal', '');
	   	$select->AjouterElement('italic', 'italique', '');
	   	$select->AjouterElement('oblique', 'oblique', '');
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TSTYLE, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org3->AttacherCellule(1, 1, $inputLabel);
		// Poids.
		$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTWEIGHT), '', '', '', '', '', '', '', '', '', $niveau);
	   	$select->AjouterElement('lighter', 'léger', '');
	   	$select->AjouterElement('normal', 'normal', '');
	   	$select->AjouterElement('bold', 'gras', '');
		$select->AjouterElement('bolder', 'très gras', '');
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TPOIDS, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org3->AttacherCellule(1, 2, $inputLabel);
		// Décoration.
		$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_TEXTDECORATION), '', '', '', '', '', '', '', '', '', $niveau);
	   	$select->AjouterElement('underline', 'souligné', '');
	   	$select->AjouterElement('overline', 'surligné', '');
	   	$select->AjouterElement('line-through', 'barré', '');
	   	$select->AjouterElement('none', 'aucune', '');
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TDECORATION, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org3->AttacherCellule(1, 3, $inputLabel);
		// Casse.
		$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTVARIANT), '', '', '', '', '', '', '', '', '', $niveau);
	   	$select->AjouterElement('normal', 'normal', '');
	   	$select->AjouterElement('small-caps', 'petites capitales', '');
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TCASSE, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		$org3->AttacherCellule(1, 4, $inputLabel);
		$org1->AttacherCellule(2, 1, $org3);
		$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SETEXTE, true, true), $org1);

		/*****************************************************/
		// Clignotement.
		$org1 = new SOrganiseur(8, 1, true, true);
	   	// Couleur écriture.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_SETEXTE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPPICCOULEUR, true, true), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICCOLOR));
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPFINCOULEUR, true, true), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINCOLOR));
		$org1->AttacherCellule(1, 1, $inputLabel);
		// Couleur fond.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPFOND, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPPICCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICBACKGROUNDCOLOR));
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPFINCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINBACKGROUNDCOLOR));
		$org1->AttacherCellule(2, 1, $inputLabel);
		// Couleur bord haut.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDHAUT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPPICCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICBORDERTOPCOLOR));
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPFINCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINBORDERTOPCOLOR));
		$org1->AttacherCellule(3, 1, $inputLabel);
		// Couleur bord gauche.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDGAUCHE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPPICCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICBORDERLEFTCOLOR));
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPFINCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINBORDERLEFTCOLOR));
		$org1->AttacherCellule(4, 1, $inputLabel);
		// Couleur bord bas.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDBAS, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPPICCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICBORDERBOTTOMCOLOR));
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPFINCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINBORDERBOTTOMCOLOR));
		$org1->AttacherCellule(5, 1, $inputLabel);
		// Couleur bord droit.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDDROIT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPPICCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICBORDERRIGHTCOLOR));
		$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_PPFINCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINBORDERRIGHTCOLOR));
		$org1->AttacherCellule(6, 1, $inputLabel);
		// Transparence.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPTRANSP, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_PPPICTRANSPARENCE, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICOPACITY), '', 0, 0, 3, false, '%', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 100, $niveau);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_PPFINTRANSPARENCE, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINOPACITY), '', 0, 0, 3, false, '%', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 100, $niveau);
		$org1->AttacherCellule(7, 1, $inputLabel);
		// Durée.
		$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPDUREE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_PPPICDUREE, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOPICDUREE), '', 0, 0, 4, false, 'ms', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 2000, $niveau);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_PPFINDUREE, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNOFINDUREE), '', 0, 0, 4, false, 'ms', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 2000, $niveau);
		$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_PPRETDUREE, true, true), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_CLIGNORETDUREE), '', 0, 0, 4, false, 'ms', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 2000, $niveau);
		$org1->AttacherCellule(8, 1, $inputLabel);
		$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_PPCLIGNOTEMENT, true, true), $org1, true);
		/*****************************************************/
	   	$visualiseur = new SVisualiseur($this->prefixIdClass, $vue, $cListeCssSousElements, $this->nomFichier, $this->presentation);
	   	$elem = parent::ConstruireElemConsultation($element, $this->GetElemChampValeurConsultation($element, COL_LIBELLE), $visualiseur);
		return $elem;
	}
}

?>