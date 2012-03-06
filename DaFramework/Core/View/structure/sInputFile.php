<?php

require_once 'cst.php';
//require_once INC_GFICHIER;
require_once INC_SINPUTSELECT;
require_once INC_SINPUTNEW;


define ('INPUTFILE', '_file');
define ('INPUTFILE_NEWDECLENCHEUR', '_file_newdec');

define ('INPUTFILE_JQ', 'jq_input_file');
define ('LISTEINPUTFILE_JQ', 'jq_liste_input_file');
define ('INPUTFILE_JQ_NEWINPUT', 'jq_input_file_newinput');
define ('INPUTFILE_JQ_NEWDECLENCHEUR', 'jq_input_file_newdeclencheur');
define ('INPUTFILE_JQ_TYPE', 'jq_input_file_type');
//define ('INPUTFILE_JQ_IFRAMEINPUT', 'jq_input_file_iframeinput');

define ('INPUTFILE_TYPE_FICHIER', 'fichier');
define ('INPUTFILE_TYPE_IMAGE', 'image');
define ('INPUTFILE_TYPE_LISTEFICHIER', 'listefichier');
define ('INPUTFILE_TYPE_LISTEIMAGE', 'listeimage');

define ('TYPEFICHIER_IMAGEPERSO', 'tfip');
define ('TYPEFICHIER_IMAGEGROUPE', 'tfig');
define ('TYPEFICHIER_IMAGEGLOBALE_COMMUNAUTE', 'tfigc');
define ('TYPEFICHIER_IMAGEGLOBALE_GRADE', 'tfigg');
define ('TYPEFICHIER_IMAGEGLOBALE_LANGUE', 'tfigl');
define ('TYPEFICHIER_IMAGEGLOBALE_JEU', 'tfigj');


// Input de type combobox.
class SInputFile extends SBalise
{
   	protected $prefixIdClass;
   	protected $niveau;
   	protected $select;

	public function __construct($prefixIdClass, $typeInput = '', $oblig = false, $retour = '', $chemin = '', $extensions = '', $id = '', $info = '', $erreur = '', $type = '', $contexte = '', $niveau = '')
	{
		parent::__construct(BAL_DIV);
		GSession::PoidsJavascript(1);

		$this->select == NULL;

		$this->prefixIdClass = $prefixIdClass;
		$this->niveau = $niveau;
		if ($typeInput === INPUTFILE_TYPE_LISTEFICHIER)
		   	$this->AddClass(LISTEINPUTFILE_JQ);
		else if ($typeInput === '' || $typeInput === INPUTFILE_TYPE_FICHIER)
		   	$this->AddClass(INPUTFILE_JQ);

		$this->AddClass('jq_fill');
		if ($oblig == true)
			$this->AddClass('jq_input_form_oblig');

		$elem = new SElement($this->prefixIdClass.INPUTFILE.$this->niveau, true, '', '', false);
		$elem->AjouterClasse(INPUTFILE.$this->niveau);
		$this->Attach($elem);

		$org = new SOrganiseur(1, 2, true);
		$org->SetCelluleDominante(1, 1);
		$elem->Attach($org);

		// Select.
		$rechargeFonc = '';
		$rechargeParam = '';
		if ($contexte !== '')
		{
		   	$rechargeFonc = AJAXFONC_CHARGERREFERENTIELCONTEXTE;
			$rechargeParam = to_html('contexte='.$contexte);
		}
		$this->select = new SInputSelect($this->prefixIdClass/*.INPUTFILE*/, INPUTSELECT_TYPE_FICHIER, $oblig, $retour, $info, $erreur, $type, '', '', $rechargeFonc, $rechargeParam, '', '', $niveau);
		$org->AttacherCellule(1, 1, $this->select);

		// InputFile.
		$action = '';
		switch ($type)
		{
			default:
			   	if ($type === '')
				   	$type = INPUTFILE_TYPE_FICHIER;
				$action = PATH_SERVER_HTTP.'fonctions/General/fUploadFichier.php';
		}

		// - Input.
		$div = new SBalise(BAL_DIV);
		$div->AddClass(INPUTFILE_JQ_NEWINPUT);
		$div->AddProp(PROP_STYLE, 'overflow:hidden;');
		$form = new SBalise(BAL_FORM);
		$form->AddProp(PROP_ACTION, $action);
		$form->AddProp(PROP_METHOD, 'post');
		$form->AddProp(PROP_ENCTYPE, 'multipart/form-data');
		//$form->AddStyle('display:none;');
		$div->Attach($form);
		$rand = mt_rand();
		$file = new SInput('', 'file', '', '');
		$file->AddProp(PROP_NAME, 'fichierUp'.$rand);
		$file->AddStyle('display:none;');
		$form->Attach($file);
		$fileType = new SInput('', 'hidden', '', '');
		$fileType->AddProp(PROP_NAME, 'type'.$rand);
		$fileType->AddProp(PROP_VALUE, $type);
		$form->Attach($fileType);
		$fileId = new SInput('', 'hidden', '', '');
		$fileId->AddProp(PROP_NAME, 'id'.$rand);
		$fileId->AddProp(PROP_VALUE, $id);
		$form->Attach($fileId);
		/*$fileFrame = new SInput('', 'hidden', '', '');
		$fileFrame->AddClass(INPUTFILE_JQ_IFRAMEINPUT);
		$fileFrame->AddProp(PROP_NAME, 'iframe'.$rand);
		$form->Attach($fileFrame);*/
		$org->AttacherCellule(1, 2, $div);

		// - Declencheur.
		//$element = new SElement($this->prefixIdClass.INPUTFILE_NEWDECLENCHEUR.$this->niveau, false);
		//$element->AjouterClasse(INPUTFILE_NEWDECLENCHEUR.$this->niveau);
		$element = new SElement($this->prefixIdClass.INPUTNEW_DECLENCHEUR.$this->niveau, false);
		$element->AjouterClasse(INPUTNEW_DECLENCHEUR.$this->niveau);
		$element->AddClass(INPUTFILE_JQ_NEWDECLENCHEUR);
		$org->AttacherCellule(1, 2, $element);

		//if ($chemin !== '')
		//   	$this->GetNomsFichiers($chemin);
	}

	/*public function GetNomsFichiers($chemin, $categorieLib = NULL)
	{
		if ($categorieLib != NULL)
			$this->AjouterCategorie('', $categorieLib);

		$gFichier = new GFichier($chemin, $extensions);
		foreach ($gFichier->ChargerNomsFichiers() as $nomfichier)
		{
		   	$this->AjouterElement($fichier, $fichier);
		}
	}*/

	public function AjouterCategorie($id, $libelle)
	{
		if ($this->select != NULL)
			$this->select->AjouterCategorie($id, $libelle);
	}

	public function AjouterElement($id, $libelle, $description = '', $valParDefaut = false)
	{
		if ($this->select != NULL)
			$this->select->AjouterElement($id, $libelle, $description, $valParDefaut);
	}

	public function AjouterElementsFromListe($nomRef, $listeVide = false, $fichierParDefaut = NULL)
	{
	   	if ($listeVide !== true)
		{
		   	$chemin = GReferentiel::GetCheminReferentielFichiers($nomRef);
		   	foreach (GReferentiel::GetReferentielFichiers($nomRef) as $fichier)
			{
			   	$valParDefaut = false;
			   	if ($fichierParDefaut !== NULL && $chemin.$fichier === $fichierParDefaut)
		   		   	$valParDefaut = true;
			   	$this->AjouterElement($chemin.$fichier, $fichier, PATH_SERVER_HTTP.$chemin.$fichier, $valParDefaut);
			}
		}

		// Référentiel.
		$divRef = new SBalise(BAL_DIV);
		$divRef->SetText($nomRef);
		$divRef->AddClass(INPUTSELECT_JQ_REF);
		$divRef->AddStyle('display:none;');
		$this->select->Attach($divRef);
	}
}