<?php

require_once 'cst.php';
require_once INC_SINPUTFILE;
require_once INC_SIMAGE;
require_once INC_SELEMORG;


define ('INPUTIMAGE', '_image');
define ('INPUTIMAGE_IMAGE', '_image_image');
define ('INPUTIMAGE_FILE', '_image_file');

define ('INPUTIMAGE_JQ', 'jq_input_image');
define ('INPUTIMAGE_JQ_IMAGE', 'jq_input_image_image');
define ('INPUTIMAGE_JQ_FILE', 'jq_input_image_file');

define ('LISTEINPUTIMAGE_JQ', 'jq_liste_input_image');


// Input de type combobox pour les images avec visualiseur de l'image sélectionnée.
class SInputImage extends SElemOrg
{
   	protected $inputFile;

   	public function __construct($prefixIdClass, $typeInput = INPUTFILE_TYPE_IMAGE, $oblig = false, $retour = '', $chemin = '', $id = '', $info = '', $erreur = '', $type = '', $contexte = '', $niveau = '')
	{
	   	parent::__construct(2, 1, '', true);
	   	GSession::PoidsJavascript(1);

	   	if ($typeInput === '')
	   	   	$typeInput = INPUTFILE_TYPE_IMAGE;

	   	switch ($typeInput)
		{
	   		case INPUTFILE_TYPE_LISTEIMAGE:
	   			$this->AddClass(LISTEINPUTIMAGE_JQ);
	   			break;
	   		default:
	   			$this->AddClass(INPUTIMAGE_JQ);
	   	}

	   	$elemImage = new SElement($prefixIdClass.INPUTIMAGE_IMAGE.$niveau);
	   	$elemImage->AjouterClasse(INPUTIMAGE_IMAGE.$niveau);
	   	$image = new SImage('');
	   	$image->AddClass(INPUTIMAGE_JQ_IMAGE);
	   	$elemImage->Attach($image);
	   	$this->AttacherCellule(1, 1, $elemImage);

	   	$elemFile = new SElement($prefixIdClass.INPUTIMAGE_FILE.$niveau);//, true, '', '', false);
	   	$elemFile->AjouterClasse(INPUTIMAGE_FILE.$niveau);
	   	$this->inputFile = new SInputFile($prefixIdClass, $typeInput, $oblig, $retour, $chemin, REF_FICHIERSEXTENSIONS_IMAGES, $id, $info, $erreur, $type, $contexte, $niveau);
	   	$this->inputFile->AddClass(INPUTIMAGE_JQ_FILE);
		$elemFile->Attach($this->inputFile);
		$this->AttacherCellule(2, 1, $elemFile);
	}

	public function AjouterElement($id, $libelle, $description = '', $valParDefaut = false)
	{
		$this->inputFile->AjouterElement($id, $libelle, $description, $valParDefaut);
	}

	public function AjouterElementsFromListe($nomRef, $listeVide = false, $fichierParDefaut = NULL)
	{
	   	$this->inputFile->AjouterElementsFromListe($nomRef, $listeVide, $fichierParDefaut);
	}
}