<?php

echo '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                    "http://www.w3.org/TR/html4/loose.dtd">
<html>

	<head>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/jquery.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/jqCore.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/jqSlider.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/jqDraggable.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/jqDroppable.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/jqSortable.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/jqColor.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/fill.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/clignotement.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/infoBulle.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputTrigger.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputText.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputSelect.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputCheckbox.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputNew.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputFile.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputColor.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/popDiv.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/inputButton.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/css.js"></script>
		<script type="text/javascript" src="file:///C:/Divers/Entreprise/DossierProjet/dev/www/js/onreadyBis.js"></script>


<style type="text/css">
   	   	   	/******************* GENERAL *******************/
			body
			{
				background: rgb(200,200,255);
				font-family: Verdana, sans-serif;
				font-size: 11px;
				color: rgb(200,200,255);
			}

			td
			{
			  	padding: 0;
			}

			.table_maxlargeur
			{
				width: 100%;
			}

			.cellule_maxlargeur
			{
				width: 100%;
			}
			/***********************************************/

			/******************* INFO/ERREUR *******************/
			 .classecadre_info_tab
			{
				color: white;
				background: rgb(150,150,230);
				border-top: 1px solid rgb(170,170,250);
				border-left: 1px solid rgb(170,170,250);
				border-bottom: 1px solid rgb(130,130,210);
				border-right: 1px solid rgb(130,130,210);
				text-align: center;
				width: 100%;
			}

			.classecadre_erreur_tab
			{
				color: white;
				background: rgb(230,150,150);
				border-top: 1px solid rgb(250,170,170);
				border-left: 1px solid rgb(250,170,170);
				border-bottom: 1px solid rgb(210,130,130);
				border-right: 1px solid rgb(210,130,130);
				text-align: center;
				width: 100%;
			}
			/***************************************************/

			/******************* LABEL *******************/
			/*._input_tab
			{
				background: rgb(0,0,140);
				border-top: 1px solid rgb(50,50,190);
				border-left: 1px solid rgb(50,50,190);
				border-right: 1px solid rgb(0,0,20);
				padding: 1px;
				font-size: 12px;
			}*/

			._input_cadre_tab
			{
				background: rgb(0,0,140);
				border-top: 1px solid rgb(50,50,190);
				border-left: 1px solid rgb(50,50,190);
				border-right: 1px solid rgb(0,0,20);
				padding: 1px;
				font-size: 12px;
			}

			._input_cadre_oblig_tab
			{
				background: rgb(220,30,160);
				border-top: 1px solid rgb(250,60,190);
				border-left: 1px solid rgb(250,60,190);
				border-right: 1px solid rgb(190,0,130);
				padding: 1px;
				font-size: 12px;
			}

			._input_label_tab
			{
			   	background: rgb(0,0,140);
				border-top: 1px solid rgb(50,50,190);
				border-left: 1px solid rgb(50,50,190);
				border-bottom: 1px solid rgb(0,0,20);
				padding: 1px;
				font-size: 12px;
			}
			/*********************************************/

			/******************* SELECT *******************/
			/*._select_tab
			{
				padding: 1px;
				margin: 0;
				background: rgb(0,0,140);
				border: 1px solid rgb(0, 0, 140);
				color: rgb(200,200,255);
			}*/

			._select_cadre_tab
			{
				padding: 1px;
				margin: 0;
				background: rgb(0,0,140);
				border: 1px solid rgb(0, 0, 140);
				color: rgb(200,200,255);
			}

			._select_derouleur_tab
			{
				padding-left: 5px;
				padding-right: 5px;
				cursor: pointer;
				background: rgb(0,0,140);
				border-top: 1px solid rgb(50,50,190);
				border-left: 1px solid rgb(50,50,190);
				border-bottom: 1px solid rgb(0,0,20);
				border-right: 1px solid rgb(0,0,20);
				font-family: Verdana, sans-serif;
				font-size: 11px;
			}

			._select_valeur_tab
			{
				padding: 1px;
				margin: 0;
				border: 1px solid rgb(40, 40, 180);
				background: rgb(40,40,180);
				color: rgb(200,200,255);
			}

			._select_valeuredit
			{
				padding: 1px;
				margin: 0;
				border: 1px solid rgb(40, 40, 180);
				background: rgb(40,40,180);
				color: rgb(200,200,255);
				font-size: 12px;
			}

			._select_liste_tab
			{
				background: rgb(0,0,140);
				border-top: 1px solid rgb(60,60,200);
				border-left: 1px solid rgb(0,0,20);
				border-bottom: 1px solid rgb(0,0,20);
				border-right: 1px solid rgb(0,0,20);
			}

			._select_element_tab
			{
				padding-left: 5px;
				padding-right: 5px;
				padding-top: 1px;
				padding-bottom: 1px;
				background: rgb(40,40,180);
				color: rgb(180,180,240);
			}
			/**********************************************/

			/******************* TEXT *******************/
			/*._text_tab
			{
			   	padding: 1px;
				margin: 0;
				background: rgb(0,0,140);
				border: 1px solid rgb(0, 0, 140);
				color: rgb(200,200,255);
			}*/

			._text_cadre_tab
			{
			   	padding: 1px;
				margin: 0;
				background: rgb(0,0,140);
				border: 1px solid rgb(0, 0, 140);
				color: rgb(200,200,255);
			}

			._text_valeuredit
			{
			   	padding: 1px;
				margin: 0;
				border: 1px solid rgb(40, 40, 180);
				background: rgb(40,40,180);
				color: rgb(200,200,255);
				font-size: 12px;
			}
			/********************************************/

			/******************* FILE *******************/
			/*._file_tab
			{
				padding: 1px;
				margin: 0;
				background: rgb(0,0,140);
				border: 1px solid rgb(0, 0, 140);
				color: rgb(200,200,255);
			}*/

			._file_cadre_tab
			{
				padding: 1px;
				margin: 0;
				background: rgb(0,0,140);
				border: 1px solid rgb(0, 0, 140);
				color: rgb(200,200,255);
			}

			._file_select_derouleur_tab
			{
				padding-left: 5px;
				padding-right: 5px;
				cursor: pointer;
				background: rgb(0,0,140);
				border-top: 1px solid rgb(50,50,190);
				border-left: 1px solid rgb(50,50,190);
				border-bottom: 1px solid rgb(0,0,20);
				border-right: 1px solid rgb(0,0,20);
				font-family: Verdana, sans-serif;
				font-size: 11px;
			}

			._file_select_valeur_tab
			{
				padding: 1px;
				margin: 0;
				border: 1px solid rgb(40, 40, 180);
				background: rgb(40,40,180);
				color: rgb(200,200,255);
			}

			._file_select_valeuredit
			{
				padding: 1px;
				margin: 0;
				border: 1px solid rgb(40, 40, 180);
				background: rgb(40,40,180);
				color: rgb(200,200,255);
				font-size: 12px;
			}

			._file_select_liste_tab
			{
				background: rgb(0,0,140);
				border-top: 1px solid rgb(60,60,200);
				border-left: 1px solid rgb(0,0,20);
				border-bottom: 1px solid rgb(0,0,20);
				border-right: 1px solid rgb(0,0,20);
			}

			._file_select_element_tab
			{
				padding-left: 5px;
				padding-right: 5px;
				padding-top: 1px;
				padding-bottom: 1px;
				background: rgb(40,40,180);
				color: rgb(180,180,240);
			}

			._file_newdec_tab
			{
				padding-left: 5px;
				padding-right: 5px;
				cursor: pointer;
				background: rgb(0,0,140);
				border-top: 1px solid rgb(50,50,190);
				border-left: 1px solid rgb(50,50,190);
				border-bottom: 1px solid rgb(0,0,20);
				border-right: 1px solid rgb(0,0,20);
				font-family: Verdana, sans-serif;
				font-size: 11px;
			}
			/**********************************************/

			/******************* BUTTON *******************/
			._button_tab
			{
				padding: 3px;
				background: rgb(0,0,140);
				border-top: 1px solid rgb(50,50,190);
				border-left: 1px solid rgb(50,50,190);
				border-bottom: 1px solid rgb(0,0,20);
				border-right: 1px solid rgb(0,0,20);
				text-align: center;
			}
			/**********************************************/

			/******************* FORM *******************/
			._form_cadre_tab
			{
				padding: 10px;
				background: rgb(150,150,230);
				border-top: 1px solid rgb(170,170,250);
				border-left: 1px solid rgb(170,170,250);
				border-bottom: 1px solid rgb(130,130,210);
				border-right: 1px solid rgb(130,130,210);
			}
			/**********************************************/


			.checkbox
			{
				margin: 0;
				/*border: 1px solid black;*/
				background: rgb(40,40,180);
				border-top: 1px solid rgb(90,90,230);
				border-left: 1px solid rgb(90,90,230);
				border-bottom: 1px solid rgb(0,0,60);
				border-right: 1px solid rgb(0,0,60);
			}

			.contenu
			{
				background: rgb(0,0,140);
				/*border-top: 1px solid rgb(50,50,190);*/
				border-bottom: 1px solid rgb(0,0,20);
				border-right: 1px solid rgb(0,0,20);
				padding: 3px;
			}



			.bouton_tab
			{
				background: rgb(30,30,170);
			}

			#id1
			{
				padding: 10px;
				background: rgb(150,150,230);
				border-top: 1px solid rgb(170,170,250);
				border-left: 1px solid rgb(170,170,250);
				border-bottom: 1px solid rgb(130,130,210);
				border-right: 1px solid rgb(130,130,210);
			}



			.jq_input_liste_element
			{
				color: rgb(140, 100, 0);
				background: rgb(220, 200, 30);
				border-top: 1px solid rgb(240, 240, 100);
				border-left: 1px solid rgb(240, 240, 100);
				border-bottom: 1px solid rgb(240, 240, 100);
				border-right: 1px solid rgb(240, 240, 100);
				width: 200px;
			}

			.test
			{
				vertical-align: top;
			}
		</style>


	</head>

	<body>

	<script type="text/javascript">
	function test()
	{
		if ($(this).hasClass("jq_input_button") == true)
		{
			alert($(this).data("donnees"));
			$(this).inputButtonReset();
			//$(this).inputButtonPret();
			$(this).inputButtonNotifNewSelect("11", "Warcraft 3", "Orcs ou Elfes?", "2");
		}
	}


	tabObjCli["_select_element_tab"] = new ObjetClignotant();
	tabObjCli["_select_element_tab"].SetCliEcriture(220, 220, 220,
														140, 100, 0,
														30);
	tabObjCli["_select_element_tab"].SetCliBackground(220, 220, 220,
															220, 200, 30,
															30);

	tabObjCli["_select_valeuredit"] = new ObjetClignotant();
	tabObjCli["_select_valeuredit"].SetCliEcriture(220, 220, 220,
														140, 100, 0,
														30);
	tabObjCli["_select_valeuredit"].SetCliBackground(220, 220, 220,
															220, 200, 30,
															30);
	tabObjCli["_select_valeuredit"].SetCliBordHaut(240, 240, 240,
													   240, 240, 100,
													   30);
	tabObjCli["_select_valeuredit"].SetCliBordGauche(240, 240, 240,
													   240, 240, 100,
													   30);
	tabObjCli["_select_valeuredit"].SetCliBordDroit(240, 240, 240,
													   240, 240, 100,
													   30);
	tabObjCli["_select_valeuredit"].SetCliBordBas(240, 240, 240,
													   240, 240, 100,
													   30);

	tabObjCli["_select_derouleur_tab"] = new ObjetClignotant();
	tabObjCli["_select_derouleur_tab"].SetCliBackground(20, 20, 160,
										 -1 , -1, -1,
										 30);
	tabObjCli["_select_derouleur_tab"].SetCliBordHaut(0, 0, 140,
									   -1 , -1, -1,
									   30);
	tabObjCli["_select_derouleur_tab"].SetCliBordGauche(0, 0, 140,
										 -1 , -1, -1,
										 30);
	tabObjCli["_select_derouleur_tab"].SetCliBordDroit(40, 40, 180,
									    -1 , -1, -1,
									    30);
	tabObjCli["_select_derouleur_tab"].SetCliBordBas(40, 40, 180,
									  -1 , -1, -1,
									  30);

	tabObjCli["_text_valeuredit"] = new ObjetClignotant();
	tabObjCli["_text_valeuredit"].SetCliEcriture(220, 220, 220,
														140, 100, 0,
														30);
	tabObjCli["_text_valeuredit"].SetCliBackground(220, 220, 220,
															220, 200, 30,
															30);
	tabObjCli["_text_valeuredit"].SetCliBordHaut(240, 240, 240,
													   240, 240, 100,
													   30);
	tabObjCli["_text_valeuredit"].SetCliBordGauche(240, 240, 240,
													   240, 240, 100,
													   30);
	tabObjCli["_text_valeuredit"].SetCliBordDroit(240, 240, 240,
													   240, 240, 100,
													   30);
	tabObjCli["_text_valeuredit"].SetCliBordBas(240, 240, 240,
													   240, 240, 100,
													   30);


	tabObjCli["_button_tab"] = new ObjetClignotant();
	tabObjCli["_button_tab"].SetCliEcriture(
														140, 100, 0,
														-1, -1, -1,
														30);
	tabObjCli["_button_tab"].SetCliBackground(
															220, 200, 30,
													   -1, -1, -1,
															30);
	tabObjCli["_button_tab"].SetCliBordHaut(
													   240, 240, 100,
													   -1, -1, -1,
													   30);
	tabObjCli["_button_tab"].SetCliBordGauche(
													   240, 240, 100,
													   -1, -1, -1,
													   30);
	tabObjCli["_button_tab"].SetCliBordDroit(
													   240, 240, 100,
													   -1, -1, -1,
													   30);
	tabObjCli["_button_tab"].SetCliBordBas(
													   240, 240, 100,
													   -1, -1, -1,
													   30);

	tabObjCli["_button_tab"].SetCliEcriture(
										80, 80, 200,
										-1, -1, -1,
										40);
	tabObjCli["_button_tab"].SetCliBackground(40, 40, 160,
										 -1 , -1, -1,
										 40);
	tabObjCli["_button_tab"].SetCliBordHaut(40, 40, 160,
									   -1 , -1, -1,
									   40);
	tabObjCli["_button_tab"].SetCliBordGauche(40, 40, 160,
										 -1 , -1, -1,
										 40);
	tabObjCli["_button_tab"].SetCliBordDroit(40, 40, 160,
									    -1 , -1, -1,
									    40);
	tabObjCli["_button_tab"].SetCliBordBas(40, 40, 160,
									  -1 , -1, -1,
									  40);
	</script>';

require_once 'cst.php';
require_once INC_SFORM;

echo "\n\n";


echo "<div id='id1'>\n\n";

$org = new SOrganiseur(5, 6, true, true);
$org->FusionnerCellule(1, 1, 0, 2);
$org->FusionnerCellule(1, 4, 0, 2);
$org->FusionnerCellule(2, 1, 0, 1);
$org->FusionnerCellule(2, 3, 0, 1);
$org->FusionnerCellule(2, 5, 0, 1);
$org->FusionnerCellule(3, 1, 0, 5);
$org->FusionnerCellule(4, 1, 0, 5);
$org->FusionnerCellule(5, 1, 0, 5);

$select = new SInputSelect('sel');
$select->AjouterElement(1, 'Guild War', 'Jeu gratuit.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$label = new SInputLabel('lab', 'Jeu:', $select);
$org->AttacherCellule(1, 1, $label);

$select = new SInputSelect('sel', '', true, 'Le jeu auquel tu joues.', 'Il faut choisir un jeu.', 'JEU', '', '');
$select->AjouterCategorie(1, 'RPG');
$select->AjouterElement(1, 'Guild War', 'Jeu avec des PPBL.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select->AjouterCategorie(2, 'RTS');
$select->AjouterElement(4, 'Age of Empires', 'Jeu avec des paysans.');
$select->AjouterElement(5, 'Warcraft 3', 'Jeu avec des elfes.');
$label = new SInputLabel('lab', 'Jeu:', $select);
$org->AttacherCellule(1, 4, $label);

$text = new SInputText('tex');
$label = new SInputLabel('lab', 'Jeu:', $text);
$org->AttacherCellule(2, 1, $label);

$text = new SInputText('tex', '', true, 'Doe', 6, 6, 'px', 'Ton nom.', 'Il faut remplir le nom.');
$label = new SInputLabel('lab', 'Nom:', $text);
$org->AttacherCellule(2, 3, $label);

$text = new SInputText('tex', '', true, 'John', -1, -1, 'px', 'Ton prénom.', 'Il faut remplir le prénom.');
$label = new SInputLabel('lab', 'Prénom:', $text);
$org->AttacherCellule(2, 5, $label);

$text = new SInputFile('fic', '', false, 1, 'Fichier image.', '', INPUTFILE_TYPE_IMAGEPERSO);
$label = new SInputLabel('lab', 'Image:', $text);
$org->AttacherCellule(3, 1, $label);

$bouton = new SInputButton('bou', '', 'Valider', 'Validation en cours', 'id1', 'test', true, true);
$org->AttacherCellule(4, 1, $bouton);

$bouton = new SInputButton('bou', '', 'Annuler', '', '', 'alert', false, true);
$bouton->AjouterParamRetour('Annuler!');
$org->AttacherCellule(5, 1, $bouton);

echo $org->BuildHTML();

echo "\n\n</div>";


echo "\n\n";


$sousForm = new SForm('form', 2, 1);

$sousForm->SetCadreInputs(1, 1, 3, 6);
$sousForm->FusionnerCelluleCadre(1, 1, 0, 2);
$sousForm->FusionnerCelluleCadre(1, 4, 0, 2);
$sousForm->FusionnerCelluleCadre(2, 1, 0, 1);
$sousForm->FusionnerCelluleCadre(2, 3, 0, 1);
$sousForm->FusionnerCelluleCadre(2, 5, 0, 1);
$sousForm->FusionnerCelluleCadre(3, 1, 0, 5);
$select = $sousForm->AjouterInputSelect(1, 1, 'Jeu:');
$select->AjouterElement(1, 'Guild War', 'Jeu gratuit.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select = $sousForm->AjouterInputSelect(1, 4, 'Jeu:', '', true, 'Le jeu auquel tu joues.', 'Il faut choisir un jeu.', 'JEU', '', '');
$select->AjouterCategorie(1, 'RPG');
$select->AjouterElement(1, 'Guild War', 'Jeu avec des PPBL.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select->AjouterCategorie(2, 'RTS');
$select->AjouterElement(4, 'Age of Empires', 'Jeu avec des paysans.');
$select->AjouterElement(5, 'Warcraft 3', 'Jeu avec des elfes.');
$sousForm->AjouterInputText(2, 1, 'Jeu:');
$sousForm->AjouterInputText(2, 3, 'Nom:', '', true, 'Doe', 6, 6, 'px', 'Ton nom.', 'Il faut remplir le nom.');
$sousForm->AjouterInputText(2, 5, 'Prénom:', '', true, 'John', -1, -1, 'px', 'Ton prénom.', 'Il faut remplir le prénom.');
$sousForm->AjouterInputFile(3, 1, 'Image:', '', false, 1, 'Fichier image.', '', INPUTFILE_TYPE_IMAGEPERSO);

$sousForm->SetCadreBoutons(2, 1, 2, 1);
$sousForm->AjouterInputButton(1, 1, '', 'Valider', 'Validation en cours', true, 'test', true, true);
$sousForm->AjouterInputButton(2, 1, '', 'Annuler', '', '', 'alert', false, true);

$form = new SForm('form', 2, 1);

$form->SetCadreInputs(1, 1, 3, 6);
$form->FusionnerCelluleCadre(1, 1, 0, 2);
$form->FusionnerCelluleCadre(1, 4, 0, 2);
$form->FusionnerCelluleCadre(2, 1, 0, 1);
$form->FusionnerCelluleCadre(2, 3, 0, 1);
$form->FusionnerCelluleCadre(2, 5, 0, 1);
$form->FusionnerCelluleCadre(3, 1, 0, 2);
$form->FusionnerCelluleCadre(3, 4, 0, 2);
$select = $form->AjouterInputSelect(1, 1, 'Jeu:');
$select->AjouterElement(1, 'Guild War', 'Jeu gratuit.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select = $form->AjouterInputSelect(1, 4, 'Jeu:', '', true, 'Le jeu auquel tu joues.', 'Il faut choisir un jeu.', 'JEU', '', '');
$select->AjouterCategorie(1, 'RPG');
$select->AjouterElement(1, 'Guild War', 'Jeu avec des PPBL.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select->AjouterCategorie(2, 'RTS');
$select->AjouterElement(4, 'Age of Empires', 'Jeu avec des paysans.');
$select->AjouterElement(5, 'Warcraft 3', 'Jeu avec des elfes.');
$form->AjouterInputText(2, 1, 'Jeu:');
$form->AjouterInputText(2, 3, 'Nom:', '', true, 'Doe', 6, 6, 'px', 'Ton nom.', 'Il faut remplir le nom.');
$form->AjouterInputText(2, 5, 'Prénom:', '', true, 'John', -1, -1, 'px', 'Ton prénom.', 'Il faut remplir le prénom.');
$form->AjouterInputFile(3, 1, 'Image:', '', false, 1, 'Fichier image.', '', INPUTFILE_TYPE_IMAGEPERSO);
$select = $form->AjouterInputNewSelect(3, 4, 'Jeu:', false, 'Le jeu auquel tu joues.', '', 'JEU', '', '');
$select->AjouterCategorie(1, 'RPG');
$select->AjouterElement(1, 'Guild War', 'Jeu avec des PPBL.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select->AjouterCategorie(2, 'RTS');
$select->AjouterElement(4, 'Age of Empires', 'Jeu avec des paysans.');
$select->AjouterElement(5, 'Warcraft 3', 'Jeu avec des elfes.');
$select->AjouterFormulaire('Créer Jeu', $sousForm);
$form->SetCadreBoutons(2, 1, 2, 1);
$form->AjouterInputButton(1, 1, '', 'Valider', 'Validation en cours', true, 'test', true, true);
$form->AjouterInputButton(2, 1, '', 'Annuler', '', '', 'alert', false, true);

echo $form->BuildHTML();


echo "\n\n";


$form = new SForm('form', 2, 1);

$form->SetCadreInputs(1, 1, 3, 6);
$form->FusionnerCelluleCadre(1, 1, 0, 2);
$form->FusionnerCelluleCadre(1, 4, 0, 2);
$form->FusionnerCelluleCadre(2, 1, 0, 1);
$form->FusionnerCelluleCadre(2, 3, 0, 1);
$form->FusionnerCelluleCadre(2, 5, 0, 1);
$form->FusionnerCelluleCadre(3, 1, 0, 5);
$select = $form->AjouterInputSelect(1, 1, 'Jeu:');
$select->AjouterElement(1, 'Guild War', 'Jeu gratuit.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select = $form->AjouterInputSelect(1, 4, 'Jeu:', '', true, 'Le jeu auquel tu joues.', 'Il faut choisir un jeu.', 'JEU', '', '');
$select->AjouterCategorie(1, 'RPG');
$select->AjouterElement(1, 'Guild War', 'Jeu avec des PPBL.');
$select->AjouterElement(2, 'Warhammer', 'Jeu avec des nains.', true);
$select->AjouterElement(3, 'World of Warcraft', 'Jeu avec des gnomes.');
$select->AjouterCategorie(2, 'RTS');
$select->AjouterElement(4, 'Age of Empires', 'Jeu avec des paysans.');
$select->AjouterElement(5, 'Warcraft 3', 'Jeu avec des elfes.');
$form->AjouterInputText(2, 1, 'Jeu:');
$form->AjouterInputText(2, 3, 'Nom:', '', true, 'Doe', 6, 6, 'px', 'Ton nom.', 'Il faut remplir le nom.');
$form->AjouterInputText(2, 5, 'Prénom:', '', true, 'John', -1, -1, 'px', 'Ton prénom.', 'Il faut remplir le prénom.');
$form->AjouterInputFile(3, 1, 'Image:', '', false, 1, 'Fichier image.', '', INPUTFILE_TYPE_IMAGEPERSO);

$form->SetCadreBoutons(2, 1, 2, 1);
$form->AjouterInputButton(1, 1, '', 'Valider', 'Validation en cours', true, 'test', true, true);
$form->AjouterInputButton(2, 1, '', 'Annuler', '', '', 'alert', false, true);

echo $form->BuildHTML();


echo "\n\n";

echo '</body>

</html>';

?>
