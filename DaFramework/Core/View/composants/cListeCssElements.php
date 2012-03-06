<?php

require_once 'cst.php';
require_once INC_SLISTEPLIANTESTATIQUE;
require_once INC_SORGANISEUR;
require_once INC_SINPUTCOLOR;
require_once INC_SINPUTSELECT;
require_once INC_CSTCSS;
require_once INC_GCSS;
require_once PATH_COMPOSANTS.'cListeCssSousElements.php';


class CListeCssElements extends SListePlianteStatique
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
		$this->AjouterChamp(COL_CLASSE, '', false, false);
		$this->AjouterChamp('premierPlan', '', false, false);
		$this->AjouterChamp('secondPlan', '', false, false);
		$this->AjouterChamp('cadre', '', false, false);
		$this->AjouterChamp('texte', '', false, false);
	}

	public function AjouterElement($libelle, $classe, $premierPlan = true, $secondPlan = true, $cadre = true, $texte = true)
	{
		$element = array();
		$this->SetElemValeurChamp($element, COL_LIBELLE, $libelle);
		$this->SetElemValeurChamp($element, COL_CLASSE, $classe);
		$this->SetElemValeurChamp($element, 'premierPlan', $premierPlan);
		$this->SetElemValeurChamp($element, 'secondPlan', $secondPlan);
		$this->SetElemValeurChamp($element, 'cadre', $cadre);
		$this->SetElemValeurChamp($element, 'texte', $texte);
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
	   	return parent::ConstruireElemConsultation($element, '', '', false);
	}

	protected function ConstruireElemConsultationTitre(&$element)
	{
	   	return $this->GetElemChampValeurConsultation($element, COL_LIBELLE);
	}

	protected function ConstruireElemConsultationContenu(&$element)
	{
	   	$cListeCssSousElements = new CListeCssSousElements($this->prefixIdClass, 'CssSousElements', $this->contexte, -1);
	   	$cListeCssSousElements->SetListeParente($this);
		$niveau = $cListeCssSousElements->Niveau();
		$premierPlan = $this->GetElemChampValeurConsultation($element, 'premierPlan');
		$secondPlan = $this->GetElemChampValeurConsultation($element, 'secondPlan');
		$cadre = $this->GetElemChampValeurConsultation($element, 'cadre');
		$texte = $this->GetElemChampValeurConsultation($element, 'texte');

		$classe = $this->GetElemChampValeurConsultation($element, COL_CLASSE);
		$classeTab = $classe.'_tab';
		if ($secondPlan !== true)
			$classeTab = $classe;

		// Premier Plan.
		if ($premierPlan === true)
		{
		   	$org1 = new SOrganiseur(2, 1, true, true);
		   	$org2 = new SOrganiseur(1, 4, true, true);
		   	// Couleur du fond.
		   	$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BACKGROUNDCOLOR);
		   	$color = new SInputColor($this->prefixIdClass, COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BACKGROUNDCOLOR), $valeur);
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPCOULEURFOND, true, true), $color, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		   	$org2->AttacherCellule(1, 1, $inputLabel);
		   	// Image de fond.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BACKGROUNDIMAGE);
			$valeur = substr($valeur, 4, strlen($valeur) - 1);
			$img = new SInputImage($this->prefixIdClass, INPUTFILE_TYPE_LISTEIMAGE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BACKGROUNDIMAGE), '', GSession::Groupe(COL_ID), '', '', TYPEFICHIER_IMAGEGROUPE, $this->contexte, $niveau);
			GReferentiel::AjouterReferentielFichiers('images', GCss::GetCheminFichiersImages(), REF_FICHIERSEXTENSIONS_IMAGES);
			$img->AjouterElementsFromListe('images', false, $valeur);
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPIMAGE, true, true), $img, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 2, $inputLabel);
			// Répétition de l'image de fond.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BACKGROUNDREPEAT);
		   	$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BACKGROUNDREPEAT), '', '', '', '', '', '', '', '', '', $niveau);
			$select->AjouterElement('repeat', 'repeat', '', ($valeur === 'repeat'));
		   	$select->AjouterElement('repeat-x', 'repeat-x', '', ($valeur === 'repeat-x'));
		   	$select->AjouterElement('repeat-y', 'repeat-y', '', ($valeur === 'repeat-y'));
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPREPETITION, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 3, $inputLabel);
			// Transparence.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_OPACITY);
		   	if ($valeur === '')
				$valeur = '100';
			$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_OPACITY), $valeur, 0, 0, 3, false, '%', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 100, $niveau);
		   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPTRANSPARENCE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 4, $inputLabel);
		   	$org1->AttacherCellule(1, 1, $org2);
			$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SEPREMIERPLAN, true, true), $org1);
		}

		/*****************************************************/
		// Second Plan.
		if ($secondPlan === true)
		{
			$org1 = new SOrganiseur(2, 1, true, true);
		   	$org2 = new SOrganiseur(1, 4, true, true);
		   	// Couleur du fond.
		   	$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classe, CSSATT_BACKGROUNDCOLOR);
		   	$color = new SInputColor($this->prefixIdClass, COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_BACKGROUNDCOLOR), $valeur);
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPCOULEURFOND, true, true), $color, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		   	$org2->AttacherCellule(1, 1, $inputLabel);
		   	// Image de fond.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classe, CSSATT_BACKGROUNDIMAGE);
			$valeur = substr($valeur, 4, strlen($valeur) - 1);
			$img = new SInputImage($this->prefixIdClass, INPUTFILE_TYPE_LISTEIMAGE, false, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_BACKGROUNDIMAGE), '', GSession::Groupe(COL_ID), '', '', TYPEFICHIER_IMAGEGROUPE, $this->contexte, $niveau);
			GReferentiel::AjouterReferentielFichiers('images', GCss::GetCheminFichiersImages(), REF_FICHIERSEXTENSIONS_IMAGES);
			$img->AjouterElementsFromListe('images', false, $valeur);
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPIMAGE, true, true), $img, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 2, $inputLabel);
			// Répétition de l'image de fond.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classe, CSSATT_BACKGROUNDREPEAT);
		   	$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_BACKGROUNDREPEAT), '', '', '', '', '', '', '', '', '', $niveau);
		   	$select->AjouterElement('repeat', 'repeat', '', ($valeur === 'repeat'));
		   	$select->AjouterElement('repeat-x', 'repeat-x', '', ($valeur === 'repeat-x'));
		   	$select->AjouterElement('repeat-y', 'repeat-y', '', ($valeur === 'repeat-y'));
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPREPETITION, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 3, $inputLabel);
			// Transparence.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classe, CSSATT_OPACITY);
			if ($valeur === '')
				$valeur = '100';
		   	$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classe.']['.CSSATT_OPACITY), $valeur, 0, 0, 3, false, '%', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 100, $niveau);
		   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_PPTRANSPARENCE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 4, $inputLabel);
		   	$org1->AttacherCellule(1, 1, $org2);
			$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SESECONDPLAN, true, true), $org1);
		}

	   	/*****************************************************/
	   	// Cadre.
	   	if ($cadre === true)
		{
		   	$org1 = new SOrganiseur(2, 1, true, true);
		   	$org2 = new SOrganiseur(2, 1, true, true);
		   	$org1->AttacherCellule(1, 1, $org2);
		   	$org3 = new SOrganiseur(4, 1, true, true);
		   	$org1->AttacherCellule(2, 1, $org3);
		   	// Marge intérieure.
		   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CMARGEINT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
		   	$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_PADDINGTOP);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CHAUT), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGTOP), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_PADDINGLEFT);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CGAUCHE), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGLEFT), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_PADDINGBOTTOM);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CBAS), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGBOTTOM), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_PADDINGRIGHT);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CDROIT), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_PADDINGRIGHT), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$org2->AttacherCellule(1, 1, $inputLabel);
			//Marge extérieure.
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CMARGEEXT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_MARGINTOP);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CHAUT), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINTOP), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_MARGINLEFT);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CGAUCHE), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINLEFT), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_MARGINBOTTOM);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CBAS), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINBOTTOM), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_MARGINRIGHT);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CDROIT), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_MARGINRIGHT), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$org2->AttacherCellule(2, 1, $inputLabel);
			//Bord haut.
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDHAUT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERTOPCOLOR);
			$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERTOPCOLOR), $valeur);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERTOPWIDTH);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERTOPWIDTH), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERTOPSTYLE);
			$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERTOPSTYLE));
			$select->AjouterElement('none', 'none', '', ($valeur === 'none'));
		   	$select->AjouterElement('dotted', 'dotted', '', ($valeur === 'dotted'));
		   	$select->AjouterElement('dashed', 'dashed', '', ($valeur === 'dashed'));
		   	$select->AjouterElement('solid', 'solid', '', ($valeur === 'solid'));
		   	$select->AjouterElement('double', 'double', '', ($valeur === 'double'));
		   	$select->AjouterElement('groove', 'groove', '', ($valeur === 'groove'));
		   	$select->AjouterElement('ridge', 'ridge', '', ($valeur === 'ridge'));
		   	$select->AjouterElement('inset', 'inset', '', ($valeur === 'inset'));
		   	$select->AjouterElement('outset', 'outset', '', ($valeur === 'outset'));
			$org3->AttacherCellule(1, 1, $inputLabel);
			//Bord gauche.
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDGAUCHE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERLEFTCOLOR);
			$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERLEFTCOLOR), $valeur);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERLEFTWIDTH);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERLEFTWIDTH), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERLEFTSTYLE);
			$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERLEFTSTYLE));
			$select->AjouterElement('none', 'none', '', ($valeur === 'none'));
		   	$select->AjouterElement('dotted', 'dotted', '', ($valeur === 'dotted'));
		   	$select->AjouterElement('dashed', 'dashed', '', ($valeur === 'dashed'));
		   	$select->AjouterElement('solid', 'solid', '', ($valeur === 'solid'));
		   	$select->AjouterElement('double', 'double', '', ($valeur === 'double'));
		   	$select->AjouterElement('groove', 'groove', '', ($valeur === 'groove'));
		   	$select->AjouterElement('ridge', 'ridge', '', ($valeur === 'ridge'));
		   	$select->AjouterElement('inset', 'inset', '', ($valeur === 'inset'));
		   	$select->AjouterElement('outset', 'outset', '', ($valeur === 'outset'));
			$org3->AttacherCellule(2, 1, $inputLabel);
			//Bord bas.
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDBAS, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERBOTTOMCOLOR);
			$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERBOTTOMCOLOR), $valeur);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERBOTTOMWIDTH);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERBOTTOMWIDTH), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERBOTTOMSTYLE);
			$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERBOTTOMSTYLE));
			$select->AjouterElement('none', 'none', '', ($valeur === 'none'));
		   	$select->AjouterElement('dotted', 'dotted', '', ($valeur === 'dotted'));
		   	$select->AjouterElement('dashed', 'dashed', '', ($valeur === 'dashed'));
		   	$select->AjouterElement('solid', 'solid', '', ($valeur === 'solid'));
		   	$select->AjouterElement('double', 'double', '', ($valeur === 'double'));
		   	$select->AjouterElement('groove', 'groove', '', ($valeur === 'groove'));
		   	$select->AjouterElement('ridge', 'ridge', '', ($valeur === 'ridge'));
		   	$select->AjouterElement('inset', 'inset', '', ($valeur === 'inset'));
		   	$select->AjouterElement('outset', 'outset', '', ($valeur === 'outset'));
			$org3->AttacherCellule(3, 1, $inputLabel);
			//Bord droit.
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_CBORDDROIT, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true, true);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERRIGHTCOLOR);
			$inputLabel->AjouterInputColor(GSession::Libelle(LIB_PRS_TCOULEUR), COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERRIGHTCOLOR), $valeur);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERRIGHTWIDTH);
			$inputLabel->AjouterInputText(GSession::Libelle(LIB_PRS_CEPAISSEUR), INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERRIGHTWIDTH), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 30);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_BORDERRIGHTSTYLE);
			$select = $inputLabel->AjouterInputSelect(GSession::Libelle(LIB_PRS_TSTYLE), INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_BORDERRIGHTSTYLE));
			$select->AjouterElement('none', 'none', '', ($valeur === 'none'));
		   	$select->AjouterElement('dotted', 'dotted', '', ($valeur === 'dotted'));
		   	$select->AjouterElement('dashed', 'dashed', '', ($valeur === 'dashed'));
		   	$select->AjouterElement('solid', 'solid', '', ($valeur === 'solid'));
		   	$select->AjouterElement('double', 'double', '', ($valeur === 'double'));
		   	$select->AjouterElement('groove', 'groove', '', ($valeur === 'groove'));
		   	$select->AjouterElement('ridge', 'ridge', '', ($valeur === 'ridge'));
		   	$select->AjouterElement('inset', 'inset', '', ($valeur === 'inset'));
		   	$select->AjouterElement('outset', 'outset', '', ($valeur === 'outset'));
			$org3->AttacherCellule(4, 1, $inputLabel);
			$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SECADRE, true, true), $org1);
		}

		/*****************************************************/
	   	// Alignement.
		//$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SEALIGNEMENT, true, true), 'gnu testa');

	   	/*****************************************************/
	   	// Texte.
	   	if ($texte === true)
		{
			$org1 = new SOrganiseur(2, 1, true, true);
		   	$org2 = new SOrganiseur(1, 4, true, true);
		   	// Couleur.
		   	$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_COLOR);
			$color = new SInputColor($this->prefixIdClass, COLOR_TYPE_LISTE, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_COLOR), $valeur);
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TCOULEUR, true, true), $color, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
		   	$org2->AttacherCellule(1, 1, $inputLabel);
		   	// Police.
		   	$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_FONTFAMILY);
			$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTFAMILY), '', '', '', '', '', '', '', '', '', $niveau);
		   	$select->AjouterElement('Arial sans serif', 'Arial', '', ($valeur === 'Arial sans serif'));
		   	$select->AjouterElement('Helvetica sans serif', 'Helvetica', '', ($valeur === 'Helvetica sans serif'));
		   	$select->AjouterElement('MS sans serif', 'MS', '', ($valeur === 'MS sans serif'));
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TPOLICE, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 2, $inputLabel);
			// Taille.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_FONTSIZE);
			$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTSIZE), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 40, $niveau);
		   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TTAILLE, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 3, $inputLabel);
			// Indentation.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_TEXTINDENT);
			$text = new SInputText($this->prefixIdClass, INPUTTEXT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_TEXTINDENT), str_replace('px', '', $valeur), 0, 2, 2, false, 'px', '', '', INPUTTEXT_REGEXP_DECIMAL_FV, 0, 40, $niveau);
		   	$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TINDENTATION, true, true), $text, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org2->AttacherCellule(1, 4, $inputLabel);
			$org1->AttacherCellule(1, 1, $org2);
			// Style.
			$org3 = new SOrganiseur(1, 4, true, true);
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_FONTSTYLE);
			$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTSTYLE), '', '', '', '', '', '', '', '', '', $niveau);
		   	$select->AjouterElement('normal', 'normal', '', ($valeur === 'normal'));
		   	$select->AjouterElement('italic', 'italique', '', ($valeur === 'italic'));
		   	$select->AjouterElement('oblique', 'oblique', '', ($valeur === 'oblique'));
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TSTYLE, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org3->AttacherCellule(1, 1, $inputLabel);
			// Poids.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_FONTWEIGHT);
			$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTWEIGHT), '', '', '', '', '', '', '', '', '', $niveau);
		   	$select->AjouterElement('lighter', 'léger', '', ($valeur === 'lighter'));
		   	$select->AjouterElement('normal', 'normal', '', ($valeur === 'normal'));
		   	$select->AjouterElement('bold', 'gras', '', ($valeur === 'bold'));
			$select->AjouterElement('bolder', 'très gras', '', ($valeur === 'bolder'));
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TPOIDS, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org3->AttacherCellule(1, 2, $inputLabel);
			// Décoration.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_TEXTDECORATION);
			$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_TEXTDECORATION), '', '', '', '', '', '', '', '', '', $niveau);
		   	$select->AjouterElement('underline', 'souligné', '', ($valeur === 'underline'));
		   	$select->AjouterElement('overline', 'surligné', '', ($valeur === 'overline'));
		   	$select->AjouterElement('line-through', 'barré', '', ($valeur === 'line-through'));
		   	$select->AjouterElement('none', 'aucune', '', ($valeur === 'none'));
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TDECORATION, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org3->AttacherCellule(1, 3, $inputLabel);
			// Casse.
			$valeur = GCss::GetValeurAttributCss($this->nomFichier, $this->presentation, $classeTab, CSSATT_FONTVARIANT);
			$select = new SInputSelect($this->prefixIdClass, INPUTSELECT_TYPE_LISTE, false, GContexte::FormaterVariable($this->contexte, $classeTab.']['.CSSATT_FONTVARIANT), '', '', '', '', '', '', '', '', '', $niveau);
		   	$select->AjouterElement('normal', 'normal', '', ($valeur === 'normal'));
		   	$select->AjouterElement('small-caps', 'petites capitales', '', ($valeur === 'small-caps'));
			$inputLabel = new SInputLabel($this->prefixIdClass, GSession::Libelle(LIB_PRS_TCASSE, true, true), $select, INPUTLABELPLACE_GAUCHE, false, false, $niveau, true, true);
			$org3->AttacherCellule(1, 4, $inputLabel);
			$org1->AttacherCellule(2, 1, $org3);
			$cListeCssSousElements->AjouterElement(GSession::Libelle(LIB_PRS_SETEXTE, true, true), $org1);
		}

		return $cListeCssSousElements;
	}
}

?>