(function ($)
{
	var visualiseur = function()
	{
		var
		defaults =
		{
			selectorVue: '.jq_visualiseur_vue',
			selectorForm: '.jq_visualiseur_form',
			selectorClignotement: '.jq_visualiseur_clignotement',
			selectorClignotementInfo: '.jq_visualiseur_clignotement_info',
			selectorClignotementInfoPP: '.jq_visualiseur_clignotement_infopp',
			selectorClignotementInfoAP: '.jq_visualiseur_clignotement_infoap'
		},

		init = function(jqElem, options)
		{
			if (jqElem.hasClass('jq_visualiseur') == false)
				jqElem.addClass('jq_visualiseur');

			var jqCligno = jqElem.find(options.selectorClignotement + ':first').closest('.jq_liste_elem');
			jqCligno.hide();

			var jqClignoInfoPP = jqCligno.find(options.selectorClignotementInfoPP);
			jqCligno.data('visualiseurClignoPP', $.trim(jqClignoInfoPP.text()));
			jqClignoInfoPP.remove();

			var jqClignoInfoAP = jqCligno.find(options.selectorClignotementInfoAP);
			jqCligno.data('visualiseurClignoAP', $.trim(jqClignoInfoAP.text()));
			jqClignoInfoAP.remove();

			var jqClignoInfo20 = jqCligno.find(options.selectorClignotementInfo + '20');
			jqCligno.data('visualiseurCligno20', $.trim(jqClignoInfo20.text()));
			jqClignoInfo20.remove();

			var jqClignoInfo30 = jqCligno.find(options.selectorClignotementInfo + '30');
			jqCligno.data('visualiseurCligno30', $.trim(jqClignoInfo30.text()));
			jqClignoInfo30.remove();

			var jqClignoInfo40 = jqCligno.find(options.selectorClignotementInfo + '40');
			jqCligno.data('visualiseurCligno40', $.trim(jqClignoInfo40.text()));
			jqClignoInfo40.remove();

			var jqClignoInfo45 = jqCligno.find(options.selectorClignotementInfo + '45');
			jqCligno.data('visualiseurCligno45', $.trim(jqClignoInfo45.text()));
			jqClignoInfo45.remove();

			var jqVue = jqElem.find(options.selectorVue + ':first');
			var jqForm = jqElem.find(options.selectorForm + ':first');
			var backgroundImage = '';
			var jqBody = $('body');
			var repeat = jqBody.css('background-repeat');
			if (repeat == undefined || repeat == '' || repeat == 'none' || repeat == 'no-repeat')
			   	backgroundImage = 'url("' + $('#cadre_background_image').attr('src') + '")';
			else
			   	backgroundImage = jqBody.css('background-image');
			jqVue.css('background-image', backgroundImage);
			jqElem.data('visualiseurPret', 1);

			jqVue.mousedown(function(e)
			{
			   	$(this).find('.jq_visualiseur_temp').remove();
			   	$(document).unbind('keyup', visualiseurKeyUp);
				$(document).unbind('keydown', visualiseurKeyDown);

				e.stopPropagation();
			});

			jqVue.mouseup(function(e)
			{
			   	var jqCible = $(e.target);
			   	var elemOk = false;
			   	var className = '';
			   	var nodeName = '';

				while (elemOk === false)
			   	{
			   	   	if (jqCible.hasClass('jq_visualiseur_vue') === true)
			   	   	{
			   	   		elemOk = true;
			   	   		jqElem.data('visualiseurClasse', '');
			   	   	}
			   	   	else
			   	   	{
			   	   	   	var nodeName = jqCible.get(0).nodeName;
			   	   	   	if (nodeName == 'div' || nodeName == 'DIV' || nodeName == 'input' || nodeName == 'INPUT')
						{
						   	var className = jqCible.attr('class');
							var tabClassName = className.split(' ');
							var tab;
							className = '';
							for (var i = 0; i < tabClassName.length; i++)
							{
								if (tabClassName[i].substring(0, 2) != 'jq')
									className = tabClassName[i];
							}

							if (className != '')
			   	   	   		   	elemOk = true;
			   	   	   	}
			   	   	   	if (elemOk === false)
			   	   	   		jqCible = jqCible.parent();
			   	   	}
			   	}

			 	$(this).find('.jq_visualiseur_temp').remove();
			   	if (className != '')
				{
				   	jqElem.data('visualiseurClasse', className);
					$(this).find('.' + className).each(function()
					{
					   	var width = $(this).outerWidth(true);
				   		var height = $(this).outerHeight(true);
					   	var left = 0;
					   	var top = 0;
					   	if ($(this).css('position') != 'relative' && $(this).css('position') != 'absolute')
						{
							var offset = $(this).position();
						   	left = offset.left;
						   	top = offset.top;
					   	}
					   	if (nodeName == 'input' || nodeName == 'INPUT')
					   		$(this).before('<div class="jq_visualiseur_temp jq_visualiseur_templast" style="position: absolute; border: 2px dotted red; z-index: 90;"></div>');
					   	else
					   	   	$(this).prepend('<div class="jq_visualiseur_temp jq_visualiseur_templast" style="position: absolute; border: 2px dotted red; z-index: 90;"></div>');
						var jqVisLast = $(this).parent().find('.jq_visualiseur_templast:first');
						jqVisLast.removeClass('jq_visualiseur_templast').css('top', (top - 2) + 'px').css('left', (left - 2) + 'px').height(height).width(width);
						if ($(this).css('display') == 'none')
							jqVisLast.hide();
					});
					chargerClignotement(jqCible, jqElem, jqCligno);
					remplirForm(jqForm, jqCible, jqElem);

					var data = {elem: jqElem, options: options};
					$(document).bind('keyup', data, visualiseurKeyUp);
					$(document).bind('keydown', '', visualiseurKeyDown);
				}
				else
				{
					$(document).unbind('keyup', visualiseurKeyUp);
					$(document).unbind('keydown', visualiseurKeyDown);
				}

				e.stopPropagation();
			});

			jqElem.bind('changeEtatInput', function(e)
			{
			   	if (jqElem.data('visualiseurPret') == 1)
				{
				   	var jqInitiateur = $(e.target);
				   	var retour = '';
				   	var retaille = false;

				   	if (jqInitiateur.hasClass('jq_input_form') === false)
				   		jqInitiateur = jqInitiateur.closest('.jq_input_form');

				   	if (jqInitiateur.hasClass('jq_input_select'))
				   		retour = jqInitiateur.inputSelectRecupererRetour();
				   	else if (jqInitiateur.hasClass('jq_input_text'))
				   		retour = jqInitiateur.inputTextRecupererRetour();
				   	else if (jqInitiateur.hasClass('jq_input_file'))
				   		retour = jqInitiateur.inputFileRecupererRetour();

				 	if (retour != '')
					{
					   	var posCroch1 = retour.indexOf('[');
					   	var posCroch2 = retour.indexOf(']', posCroch1);
					   	var posCroch3 = retour.indexOf('[', posCroch2);
					   	var posCroch4 = retour.indexOf(']', posCroch3);
						var posEgal = retour.indexOf('=');
						var classe = retour.substring(posCroch1 + 1, posCroch2);
						var premierPlan = false;
						if (classe.lastIndexOf('_tab') >= 0)
							premierPlan = true;
						var cssAtt = retour.substring(posCroch3 + 1, posCroch4);
						var valeur = retour.substring(posEgal + 1);
						switch (cssAtt)
						{
						   	case 'padding-top':
							case 'padding-left':
							case 'padding-bottom':
							case 'padding-right':
							case 'margin-top':
							case 'margin-left':
							case 'margin-bottom':
							case 'margin-right':
							case 'border-top-width':
							case 'border-left-width':
							case 'border-bottom-width':
							case 'border-right-width':
							case 'font-size':
							case 'text-indent':
							   	if (valeur === '')
							   		valeur = 'inherit';
							   	else
							   	   	valeur += 'px';
							   	retaille = true;
							   	break;
							case 'border-top-style':
							case 'border-left-style':
							case 'border-bottom-style':
							case 'border-right-style':
							  	retaille = true;
							   	break;
							case 'opacity':
							   	valeur = 100 - (valeur * 100);
							   	break;
							case 'background-image':
						   	   	valeur = 'url(' + valeur + ')';
						   	   	break;
						}
						classe = jqElem.data('visualiseurClasse');
						jqVue.find('.' + classe).each(function()
						{
						   	var nodeName = $(this).get(0).nodeName;
						   	if (nodeName != 'div' && nodeName != 'DIV')
							   	premierPlan = false;

						   	if (premierPlan == true)
						   		$(this).find('td:first').css(cssAtt, valeur);
						   	else
						   	   	$(this).css(cssAtt, valeur);

						   	if (retaille == true)
							{
						   		jqVue.find('.jq_visualiseur_temp').each(function()
							   	{
							   	   	var jqParent = $(this).parent();
							   	   	var width = jqParent.outerWidth(true);
							   		var height = jqParent.outerHeight(true);
								   	var offset = jqParent.position();
							   	   	$(this).css('top', (offset.top - 2) + 'px').css('left', (offset.left - 2) + 'px').height(height).width(width);
							   	});
							}
						});
					}
				}

				e.stopPropagation();
			});

			jqElem.bind('colorChange', function(e)
			{
			   	if (jqElem.data('visualiseurPret') == 1)
				{
				   	var jqInitiateur = $(e.target);
				   	var retour = jqInitiateur.colorRecupererRetour();
				   	var jqCligno = jqInitiateur.closest('.jq_visualiseur_cligno');
				   	var posCroch1 = retour.indexOf('[');
				   	var posCroch2 = retour.indexOf(']', posCroch1);
				   	var posCroch3 = retour.indexOf('[', posCroch2);
				   	var posCroch4 = retour.indexOf(']', posCroch3);
					var posEgal = retour.indexOf('=');
					var classe = retour.substring(posCroch1 + 1, posCroch2);
					var premierPlan = false;
					if (classe.lastIndexOf('_tab') >= 0)
						premierPlan = true;
					var niveauCligno = 0;
					if (jqCligno.length == 1)
					{
					   	niveauCligno = jqCligno.data('visualiseurNiveau');
					   	var plan = jqCligno.data('visualiseurPlan');
						if (plan == 'PP')
							premierPlan = true;
						else
						   	premierPlan = false;
					}
					var cssAtt = retour.substring(posCroch3 + 1, posCroch4);
					var valeur = retour.substring(posEgal + 1);

					classe = jqElem.data('visualiseurClasse');
					var clignoReinit = true;
					switch (cssAtt)
					{
					   	case 'cligno-pic-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = parserCouleur(valeur);
						   	var rgbFin = tabObjCliVis[classe].GetRGBCouleurEcritureFinTab();
							tabObjCliVis[classe].SetCliEcriture(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-pic-background-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = parserCouleur(valeur);
						   	var rgbFin = tabObjCliVis[classe].GetRGBCouleurBackgroundFinTab();
							tabObjCliVis[classe].SetCliBackground(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-pic-border-top-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = parserCouleur(valeur);
						   	var rgbFin = tabObjCliVis[classe].GetRGBCouleurBordHautFinTab();
							tabObjCliVis[classe].SetCliBordHaut(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-pic-border-left-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = parserCouleur(valeur);
						   	var rgbFin = tabObjCliVis[classe].GetRGBCouleurBordGaucheFinTab();
							tabObjCliVis[classe].SetCliBordGauche(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-pic-border-bottom-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = parserCouleur(valeur);
						   	var rgbFin = tabObjCliVis[classe].GetRGBCouleurBordBasFinTab();
							tabObjCliVis[classe].SetCliBordBas(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-pic-border-right-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = parserCouleur(valeur);
						   	var rgbFin = tabObjCliVis[classe].GetRGBCouleurBordDroitFinTab();
							tabObjCliVis[classe].SetCliBordDroit(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-fin-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = tabObjCliVis[classe].GetRGBCouleurEcriturePicTab();
						   	var rgbFin = parserCouleur(valeur);
							tabObjCliVis[classe].SetCliEcriture(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-fin-background-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = tabObjCliVis[classe].GetRGBCouleurBackgroundPicTab();
						   	var rgbFin = parserCouleur(valeur);
							tabObjCliVis[classe].SetCliBackground(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-fin-border-top-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = tabObjCliVis[classe].GetRGBCouleurBordHautPicTab();
						   	var rgbFin = parserCouleur(valeur);
							tabObjCliVis[classe].SetCliBordHaut(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-fin-border-left-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = tabObjCliVis[classe].GetRGBCouleurBordGauchePicTab();
						   	var rgbFin = parserCouleur(valeur);
							tabObjCliVis[classe].SetCliBordGauche(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-fin-border-bottom-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = tabObjCliVis[classe].GetRGBCouleurBordBasPicTab();
						   	var rgbFin = parserCouleur(valeur);
							tabObjCliVis[classe].SetCliBordBas(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						case 'cligno-fin-border-right-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] == undefined)
						   	 	tabObjCliVis[classe] = new ObjetClignotant();
						   	var rgbPic = tabObjCliVis[classe].GetRGBCouleurBordDroitPicTab();
						   	var rgbFin = parserCouleur(valeur);
							tabObjCliVis[classe].SetCliBordDroit(rgbPic.r, rgbPic.g, rgbPic.b, rgbFin.r, rgbFin.g, rgbFin.b, niveauCligno);
							break;
						default:
						   	clignoReinit = false;
						   	jqVue.find('.' + classe).each(function()
							{
							   	var nodeName = $(this).get(0).nodeName;
							   	if (nodeName != 'div' && nodeName != 'DIV')
								   	premierPlan = false;

								var jqPlan = $(this);
							   	if (premierPlan == true)
							   		jqPlan = $(this).find('td:first')

							   	if (jqPlan.hasClass('jq_clignotant') === true)
							   		jqPlan.ClignoterChangerCouleurInitiale(cssAtt, valeur);
								else
							   	   	jqPlan.css(cssAtt, valeur);
							});
							break;
					}

					if (clignoReinit === true)
						jqVue.find('.' + classe).ClignoterReinitialiser(true);
				}

				e.stopPropagation();
			});

			//jqElem.find('.jq_input_form').trigger('changeEtatInput');
			//jqElem.find('.jq_color').trigger('colorChange');
			jqVue.find('.jq_input_button').inputButtonCliqueFactice();
		},

		remplirForm = function(jqForm, jqCible, jqElem)
		{
		   	jqElem.data('visualiseurPret', 0);
		  	var classeBase = jqElem.data('visualiseurClasse');

		   	jqForm.find('.jq_input_form').each(function()
		   	{
		   	   	var retour = '';
		   	   	if ($(this).hasClass('jq_input_text') == true)
					retour = $(this).data('inputTextRetour');
				else if ($(this).hasClass('jq_input_select') == true)
					retour = $(this).data('inputSelectRetour');
				else if ($(this).hasClass('jq_input_file') == true)
					retour = $(this).find('.jq_input_select:first').data('inputSelectRetour');

			 	if (retour != '')
				{
			 	  	var posCroch1 = retour.indexOf('[');
				   	var posCroch2 = retour.indexOf(']', posCroch1);
				   	var posCroch3 = retour.indexOf('[', posCroch2);
				   	var posCroch4 = retour.indexOf(']', posCroch3);
					var classeTab = retour.substring(posCroch1 + 1, posCroch2);
					var cssAtt = retour.substring(posCroch3 + 1, posCroch4);
					var valeur = '';
					var premierPlan = false;
					if (classeTab.lastIndexOf('_tab') >= 0)
						premierPlan = true;
					var nodeName = $(this).get(0).nodeName;
					if (nodeName != 'div' && nodeName != 'DIV')
						premierPlan = false;
					if (premierPlan === true)
						valeur = jqCible.find('td:first').css(cssAtt);
					else
					   	valeur = jqCible.css(cssAtt);

					switch (cssAtt)
					{
					   	case 'padding-top':
						case 'padding-left':
						case 'padding-bottom':
						case 'padding-right':
						case 'margin-top':
						case 'margin-left':
						case 'margin-bottom':
						case 'margin-right':
						case 'border-top-width':
						case 'border-left-width':
						case 'border-bottom-width':
						case 'border-right-width':
						case 'font-size':
						case 'text-indent':
						   	valeur = parseInt(valeur);
						   	if (isNaN(valeur) === true)
						   		valeur = 0;
						   	break;
						case 'opacity':
						   	if (premierPlan === true)
							{
							   	if (jqCible.get(0).nodeName == 'input' || jqCible.get(0).nodeName == 'INPUT')
							   		valeur = jqCible.ClignoterRecupererCouleurInitiale(cssAtt);
							   	else
								   	valeur = jqCible.find('td:first').ClignoterRecupererCouleurInitiale(cssAtt);
							}
							else if (jqCible.get(0).nodeName != 'input' && jqCible.get(0).nodeName != 'INPUT')
							   	valeur = jqCible.ClignoterRecupererCouleurInitiale(cssAtt);
						   	valeur = 100 - (parseInt(valeur) * 100);
						   	if (isNaN(valeur) === true)
						   		valeur = 0;
						   	break;
						case 'background-image':
						   	var posCheminRel = -1;
						   	if (valeur != undefined)
							    posCheminRel = valeur.indexOf('/', 11);
						   	if (posCheminRel == -1)
						   		valeur = '';
						   	else
						   	   	valeur = valeur.substring(posCheminRel + 1, valeur.length - 1);
						   	break;
					}

					if ($(this).hasClass('jq_input_text') == true)
						$(this).inputTextFixerValeur(valeur);
					else if ($(this).hasClass('jq_input_select') == true)
					   	$(this).inputSelectFixerValeur(valeur);
					else if ($(this).hasClass('jq_input_file') == true)
					{
					   	if (valeur != '')
					   	   	$(this).inputFileFixerValeur(valeur);
					   	else
					   	   	$(this).inputFileReset(valeur);
					}
			 	}
			});

			jqForm.find('.jq_color').each(function()
		   	{
		   	   	var retour = $(this).data('colorRetour');

		   	   	if (retour != '')
				{
			 	  	var posCroch1 = retour.indexOf('[');
				   	var posCroch2 = retour.indexOf(']', posCroch1);
				   	var posCroch3 = retour.indexOf('[', posCroch2);
				   	var posCroch4 = retour.indexOf(']', posCroch3);
					var classeTab = retour.substring(posCroch1 + 1, posCroch2);
					var jqCligno = $(this).closest('.jq_visualiseur_cligno');
					var premierPlan = false;
					if (classeTab.lastIndexOf('_tab') >= 0)
						premierPlan = true;
					var niveauCligno = 0;
					if (jqCligno.length == 1)
					{
					   	niveauCligno = jqCligno.data('visualiseurNiveau');
					   	var plan = jqCligno.data('visualiseurPlan');
						if (plan == 'PP')
							premierPlan = true;
						else
						   	premierPlan = false;
					}
					var cssAtt = retour.substring(posCroch3 + 1, posCroch4);
					var valeur = '';
					var classe = classeBase;
					switch (cssAtt)
					{
					   	case 'cligno-pic-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	   	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurEcriturePic(niveauCligno));
							break;
						case 'cligno-pic-background-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBackgroundPic(niveauCligno));
							break;
						case 'cligno-pic-border-top-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordHautPic(niveauCligno));
							break;
						case 'cligno-pic-border-left-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordGauchePic(niveauCligno));
							break;
						case 'cligno-pic-border-bottom-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordBasPic(niveauCligno));
							break;
						case 'cligno-pic-border-right-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordDroitPic(niveauCligno));
							break;
						case 'cligno-fin-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurEcritureFin(niveauCligno));
							break;
						case 'cligno-fin-background-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBackgroundFin(niveauCligno));
							break;
						case 'cligno-fin-border-top-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordHautFin(niveauCligno));
							break;
						case 'cligno-fin-border-left-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordGaucheFin(niveauCligno));
							break;
						case 'cligno-fin-border-bottom-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordBasFin(niveauCligno));
							break;
						case 'cligno-fin-border-right-color':
						   	if (premierPlan === true)
						   		classe += '_tab';
						   	if (tabObjCliVis[classe] != undefined)
						   	 	$(this).colorSet(tabObjCliVis[classe].GetRGBCouleurBordDroitFin(niveauCligno));
							break;
						default:
							if (premierPlan === true)
							{
							   	if (jqCible.get(0).nodeName == 'input' || jqCible.get(0).nodeName == 'INPUT')
							   		valeur = jqCible.ClignoterRecupererCouleurInitiale(cssAtt);
							   	else
								   	valeur = jqCible.find('td:first').ClignoterRecupererCouleurInitiale(cssAtt);
							}
							else if (jqCible.get(0).nodeName != 'input' && jqCible.get(0).nodeName != 'INPUT')
							   	valeur = jqCible.ClignoterRecupererCouleurInitiale(cssAtt);
							$(this).colorSet(valeur);
							break;
					}
			 	}
		   	});

		   	jqElem.data('visualiseurPret', 1);
		},

		chargerClignotement = function(jqCible, jqElem, jqCligno)
		{
		   	var className = jqCible.attr('class');
			var tabClassName = className.split(' ');
			var tab;
			var jqLastCligno = jqCligno;
			className = '';
			jqElem.find('.jq_visualiseur_cligno').remove();
			for (var i = 0; i < tabClassName.length; i++)
			{
				if (tabClassName[i].substring(0, 14) == 'jq_clignotant_')
				{
				   	var niveauCligno = tabClassName[i].substring(14, tabClassName[i].length);
				   	var label = '';
					if (niveauCligno >= 45)
				   		label = jqCligno.data('visualiseurCligno45');
				   	else if (niveauCligno >= 40)
				   		label = jqCligno.data('visualiseurCligno40');
				   	else if (niveauCligno >= 30)
				   		label = jqCligno.data('visualiseurCligno30');
				   	else if (niveauCligno >= 20)
					   	label = jqCligno.data('visualiseurCligno20') + ' (' + (niveauCligno - 20) + ')';

					if (label !== '')
					{
					   	var jqClignoClone = jqCligno.clone(true);
					   	jqLastCligno.after(jqClignoClone);
					   	jqClignoClone.show();
					   	jqClignoClone.find('.jq_visualiseur_clignotement:first').removeClass('jq_visualiseur_clignotement');
					   	jqClignoClone.addClass('jq_visualiseur_cligno');
					   	var jqClignoCloneTitre = jqClignoClone.find('.jq_liste_elem_titre:first');
					   	jqClignoCloneTitre.data('listeElemPliantPlie', 1);
						jqClignoCloneTitre.find('td:first').find('td:first').text(label + ' - ' + jqCligno.data('visualiseurClignoPP'));
						jqClignoCloneTitre.find('.jq_liste_elem_indic:first').find('td:first').text('+');
						jqClignoCloneTitre.siblings('.jq_liste_elem_contenu:first').hide();
					   	jqClignoClone.data('visualiseurNiveau', niveauCligno);
					   	jqClignoClone.data('visualiseurPlan', 'PP');
						jqLastCligno = jqClignoClone;
						jqClignoClone.find('.jq_color').each(function()
						{
						   	$(this).draggable('destroy').draggable({helper: 'clone', zIndex: 200, containment: 'document'});
							$(this).droppable('destroy').droppable({tolerance: 'pointer',
								drop: function(event, ui)
								{
									$(this).css('background-color', ui.helper.css('background-color'));
									$(this).trigger('colorChange', $(this).css('background-color'));
									$(this).mousedown();
								}
							});
						});

					   	var jqClignoClone = jqCligno.clone(true);
					   	jqLastCligno.after(jqClignoClone);
					   	jqClignoClone.show();
					   	jqClignoClone.find('.jq_visualiseur_clignotement:first').removeClass('jq_visualiseur_clignotement');
					   	jqClignoClone.addClass('jq_visualiseur_cligno');
					   	var jqClignoCloneTitre = jqClignoClone.find('.jq_liste_elem_titre:first');
						jqClignoCloneTitre.data('listeElemPliantPlie', 1);
						jqClignoCloneTitre.find('td:first').find('td:first').text(label + ' - ' + jqCligno.data('visualiseurClignoAP'));
						jqClignoCloneTitre.find('.jq_liste_elem_indic:first').find('td:first').text('+');
						jqClignoCloneTitre.siblings('.jq_liste_elem_contenu:first').hide();
						jqClignoClone.data('visualiseurNiveau', niveauCligno);
					   	jqClignoClone.data('visualiseurPlan', 'AP');
						jqLastCligno = jqClignoClone;
						jqClignoClone.find('.jq_color').each(function()
						{
						   	$(this).draggable('destroy').draggable({helper: 'clone', zIndex: 200, containment: 'document'});
							$(this).droppable('destroy').droppable({tolerance: 'pointer',
								drop: function(event, ui)
								{
									$(this).css('background-color', ui.helper.css('background-color'));
									$(this).trigger('colorChange', $(this).css('background-color'));
									$(this).mousedown();
								}
							});
						});
					}
				}
			}
		},

		parserCouleur = function(couleur)
		{
		   	var rgb;
		   	if (couleur == 'transparent' || couleur == 'rgba(0, 0, 0, 0)')
			{
		   		rgb =
		   		{
			   		r: -1,
				  	g: -1,
				  	b: -1
		   		};
		   	}
		   	else
		   	{
			   	var pos1 = couleur.indexOf('(');
				var pos2 = couleur.indexOf(',', pos1 + 1);
				var pos3 = couleur.indexOf(',', pos2 + 1);
				var pos4 = couleur.indexOf(')', pos3 + 1);
				rgb =
				{
				  	r: couleur.substring(pos1 + 1, pos2),
				  	g: couleur.substring(pos2 + 1, pos3),
				  	b: couleur.substring(pos3 + 1, pos4)
				};
			}
			return rgb;
		};

		visualiseurKeyUp = function(e)
		{
		   	var numTouche;
		   	var jqCligno;

			if (window.event) // IE.
				numTouche = e.keyCode;
			else if (e.which) // Firefox/Opera.
				numTouche = e.which;

			if (numTouche == 38) // Flèche haut.
			{
			   	var jqElem = e.data.elem;
			   	var options = e.data.options;
			   	var jqVue = jqElem.find(options.selectorVue + ':first');
			   	var jqCible = jqVue.find('.jq_visualiseur_temp:first').parent().parent();
			   	var elemOk = false;
			   	var className = '';

			 	if (jqCible.length >= 1)
				{
					while (elemOk === false)
				   	{
				   	   	if (jqCible.hasClass('jq_visualiseur_vue') === true)
				   	   	{
				   	   		elemOk = true;
				   	   		jqElem.data('visualiseurClasse', '');
				   	   	}
				   	   	else
				   	   	{
				   	   	   	var nodeName = jqCible.get(0).nodeName;
				   	   	   	if (nodeName == 'div' || nodeName == 'DIV')
							{
							   	var className = jqCible.attr('class');
								var tabClassName = className.split(' ');
								var tab;
								className = '';
								for (var i = 0; i < tabClassName.length; i++)
								{
									if (tabClassName[i].substring(0, 2) != 'jq')
										className = tabClassName[i];
								}

								if (className != '')
				   	   	   		   	elemOk = true;
				   	   	   	}
				   	   	   	if (elemOk === false)
				   	   	   		jqCible = jqCible.parent();
				   	   	}
				   	}
				}

				var jqForm = jqElem.find(options.selectorForm + ':first');
			   	jqVue.find('.jq_visualiseur_temp').remove();
			   	if (className != '')
				{
				   	jqElem.data('visualiseurClasse', className);
				   	jqCligno = jqElem.find(options.selectorClignotement + ':first').closest('.jq_liste_elem');
				   	chargerClignotement(jqCible.eq(0), jqElem, jqCligno);
				   	remplirForm(jqForm, jqCible, jqElem);
				   	jqVue.find('.' + className).each(function()
					{
					   	var width = $(this).outerWidth(true);
				   		var height = $(this).outerHeight(true);
					   	var left = 0;
					   	var top = 0;
					   	if ($(this).css('position') != 'relative' && $(this).css('position') != 'absolute')
						{
							var offset = $(this).position();
						   	left = offset.left;
						   	top = offset.top;
					   	}
					   	$(this).prepend('<div class="jq_visualiseur_temp jq_visualiseur_templast" style="position: absolute; border: 2px dotted red; z-index: 90;"></div>');
						$(this).find('.jq_visualiseur_templast:first').removeClass('jq_visualiseur_templast').css('top', (top - 2) + 'px').css('left', (left - 2) + 'px').height(height).width(width);
					});
				}
				else
				{
					$(document).unbind('keyup', visualiseurKeyUp);
					$(document).unbind('keydown', visualiseurKeyDown);
				}

				e.stopPropagation();
				e.preventDefault();
			}
			else if (numTouche == 40) // Flèche bas.
			{
			   	var jqElem = e.data.elem;
			   	var options = e.data.options;
			   	var jqCible = jqElem.find('.jq_visualiseur_temp:first').parent().children();
			   	var elemOk = false;
			   	var className = '';
			   	var nodeName = '';
			   	var jqNouvelleCible;

				while (elemOk === false)
			   	{
			   	   	if (jqCible.length == 0)
			   	   	   	elemOk = true;
			   	   	else
			   	   	{
				   	   	jqCible.each(function()
				   	   	{
				   	   	   	if (elemOk === false)
							{
								nodeName = jqCible.get(0).nodeName;
					   	   	   	if (nodeName == 'div' || nodeName == 'DIV' || nodeName == 'input' || nodeName == 'INPUT')
								{
								   	className = jqCible.attr('class');
									var tabClassName = className.split(' ');
									var tab;
									className = '';
									for (var i = 0; i < tabClassName.length; i++)
									{
										if (tabClassName[i].substring(0, 2) != 'jq')
											className = tabClassName[i];
									}

									if (className != '')
									{
					   	   	   		   	elemOk = true;
					   	   	   		   	jqNouvelleCible = $(this);
					   	   	   		}
					   	   	   	}
					   	   	}
				   	   	});
				   	}

			   	   	if (elemOk === false)
			   	   	   	jqCible = jqCible.children();
			   	}

			   	var jqVue = jqElem.find(options.selectorVue + ':first');
				var jqForm = jqElem.find(options.selectorForm + ':first');
			   	jqVue.find('.jq_visualiseur_temp').remove();
			   	if (className != '')
				{
				   	jqElem.data('visualiseurClasse', className);
				   	jqCligno = jqElem.find(options.selectorClignotement + ':first').closest('.jq_liste_elem');
					chargerClignotement(jqCible.eq(0), jqElem, jqCligno);
				   	remplirForm(jqForm, jqNouvelleCible, jqElem);
				   	jqVue.find('.' + className).each(function()
					{
					   	var width = $(this).outerWidth(true);
				   		var height = $(this).outerHeight(true);
					   	var left = 0;
					   	var top = 0;
					   	if ($(this).css('position') != 'relative' && $(this).css('position') != 'absolute')
						{
							var offset = $(this).position();
						   	left = offset.left;
						   	top = offset.top;
					   	}
					   	if (nodeName == 'input' || nodeName == 'INPUT')
					   		$(this).before('<div class="jq_visualiseur_temp jq_visualiseur_templast" style="position: absolute; border: 2px dotted red; z-index: 90;"></div>');
					   	else
					   	   	$(this).prepend('<div class="jq_visualiseur_temp jq_visualiseur_templast" style="position: absolute; border: 2px dotted red; z-index: 90;"></div>');
						$(this).parent().find('.jq_visualiseur_templast:first').removeClass('jq_visualiseur_templast').css('top', (top - 2) + 'px').css('left', (left - 2) + 'px').height(height).width(width);
					});
				}
				else
				{
					$(document).unbind('keyup', visualiseurKeyUp);
					$(document).unbind('keydown', visualiseurKeyDown);
				}

				e.stopPropagation();
				e.preventDefault();
			}
		};

		visualiseurKeyDown = function(e)
		{
			var numTouche;

			if (window.event) // IE.
				numTouche = e.keyCode;
			else if (e.which) // Firefox/Opera.
				numTouche = e.which;

			if (numTouche == 38 || numTouche == 40)
			{
		   	   	e.stopPropagation();
		   		e.preventDefault();
		   	}
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function()
				{
					if ($(this).data('visualiseur') != 1)
					{
						var visualiseur = $(this);
						visualiseur.data('visualiseur', 1);

						init(visualiseur, options);
					}
				});
			},

			recupererRetour: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				var retour = '';

				if ($(this).data('visualiseur') == 1)
				{
				   	var cssAttPP = new Array();
				   	var cssAttSP = new Array();
				   	var contexte = '';
				   	var j = 0;
				   	var k = 0;
				   	var jqForm = $(this).find(options.selectorForm + ':first');

				   	jqForm.find('.jq_input_form').each(function()
				   	{
				   	   	var retourForm = '';
				   	   	if ($(this).hasClass('jq_input_text') == true)
							retourForm = $(this).data('inputTextRetour');
						else if ($(this).hasClass('jq_input_select') == true)
							retourForm = $(this).data('inputSelectRetour');
						else if ($(this).hasClass('jq_input_file') == true)
							retourForm = $(this).find('.jq_input_select:first').data('inputSelectRetour');

					 	var posCroch1 = retourForm.indexOf('[');
					 	if (contexte == '')
					 	   	contexte = retourForm.substring(0, posCroch1);
						var posCroch2 = retourForm.indexOf(']', posCroch1);
						var posCroch3 = retourForm.indexOf('[', posCroch2);
						var posCroch4 = retourForm.indexOf(']', posCroch3);
						var classe = retourForm.substring(posCroch1 + 1, posCroch2);
						var premierPlan = false;
						if (classe.lastIndexOf('_tab') >= 0)
							premierPlan = true;
						var cssAtt = retourForm.substring(posCroch3 + 1, posCroch4);
						if (premierPlan === true)
						{
							cssAttPP[j] = cssAtt;
							j++;
						}
						else if (cssAtt != '')
						{
							cssAttSP[k] = cssAtt;
							k++;
						}
					});

   	   	 			jqForm.find('.jq_color').each(function()
				   	{
				   	   	var retourCouleur = $(this).data('colorRetour');

				   	   	if (retourCouleur != '')
						{
					 	  	var posCroch1 = retourCouleur.indexOf('[');
						   	var posCroch2 = retourCouleur.indexOf(']', posCroch1);
						   	var posCroch3 = retourCouleur.indexOf('[', posCroch2);
						   	var posCroch4 = retourCouleur.indexOf(']', posCroch3);
							var classe = retourCouleur.substring(posCroch1 + 1, posCroch2);
							var premierPlan = false;
							if (classe.lastIndexOf('_tab') >= 0)
								premierPlan = true;
							var cssAtt = retourCouleur.substring(posCroch3 + 1, posCroch4);
							if (premierPlan === true)
							{
								cssAttPP[j] = cssAtt;
								j++;
							}
							else
							{
								cssAttSP[k] = cssAtt;
								k++;
							}
					 	}
				   	});

				   	var jqVue = $(this).find(options.selectorVue + ':first');
				   	jqVue.find('td:first').find('td,div,input').each(function()
				   	{
				   	   	var nodeName = $(this).get(0).nodeName;
				   	   	var className = $(this).attr('class');
						var tabClassName = className.split(' ');
						var tab;
						var valeur = '';
						className = '';
						for (var i = 0; i < tabClassName.length; i++)
						{
							if (tabClassName[i].substring(0, 2) != 'jq')
								className = tabClassName[i];
						}

						if (className != '')
						{
						   	var cssAttTab;
						   	if (nodeName != 'div' && nodeName != 'DIV')
							   	cssAttTab = cssAttPP;
							else
							   	cssAttTab = cssAttSP;
						   	for (var i = 0; i < cssAttTab.length; i++)
							{
							  	valeur = $(this).css(cssAttTab[i]);
							  	switch (cssAttTab[i])
								{
								  	case 'padding-top':
									case 'padding-left':
									case 'padding-bottom':
									case 'padding-right':
									case 'margin-top':
									case 'margin-left':
									case 'margin-bottom':
									case 'margin-right':
									   	if (parseInt(valeur) === 0)
									   	 	valeur = null;
										break;
									case 'border-top-color':
									case 'border-top-style':
									case 'border-top-width':
									   	if (parseInt($(this).css('border-top-width')) === 0 || $(this).css('border-top-style') === 'none')
									   	 	valeur = null;
									   	break;
									case 'border-left-color':
									case 'border-left-style':
									case 'border-left-width':
									   	if (parseInt($(this).css('border-left-width')) === 0 || $(this).css('border-left-style') === 'none')
									   	 	valeur = null;
									   	break;
									case 'border-bottom-color':
									case 'border-bottom-style':
									case 'border-bottom-width':
									   	if (parseInt($(this).css('border-bottom-width')) === 0 || $(this).css('border-bottom-style') === 'none')
									   	 	valeur = null;
									   	break;
									case 'border-right-color':
									case 'border-right-style':
									case 'border-right-width':
									   	if (parseInt($(this).css('border-right-width')) === 0 || $(this).css('border-right-style') === 'none')
									   	 	valeur = null;
									   	break;
									case 'background-image':
									   	if (valeur === 'none')
									   	 	valeur = null;
									   	break;
									case 'background-repeat':
									   	if ($(this).css('background-image') === 'none')
									   	 	valeur = null;
									   	break;
									case 'background-color':
									   	if (valeur === 'transparent' || valeur === 'rgba(0, 0, 0, 0)' || valeur === 'rgba(0,0,0,0)')
									   	 	valeur = null;
									   	break;
									case 'cligno-pic-color':
									case 'cligno-pic-background-color':
									case 'cligno-pic-border-top-color':
									case 'cligno-pic-border-left-color':
									case 'cligno-pic-border-bottom-color':
									case 'cligno-pic-border-right-color':
									case 'cligno-fin-color':
									case 'cligno-fin-background-color':
									case 'cligno-fin-border-top-color':
									case 'cligno-fin-border-left-color':
									case 'cligno-fin-border-bottom-color':
									case 'cligno-fin-border-right-color':
									   	 break;
									default:
									   	if ($(this).parent().css(cssAttTab[i]) == valeur)
									   		valeur = null;
								}

							   	if (valeur != null)
								{
									if (retour != '')
								   		retour += '&';
				   	   	   		   	retour += contexte + '[' + className + '][' + cssAttTab[i] + ']=' + valeur;
				   	   	   		}
		   	   	   		   	}

						   	/*if (nodeName != 'div' && nodeName != 'DIV')
							{
							   	for (var i = 0; i < cssAttPP.length; i++)
								{
								   	valeur = $(this).css(cssAttPP[i]);
								   	if (valeur != null)
									{
										if (retour != '')
									   		retour += '&';
					   	   	   		   	retour += contexte + '[' + className + '][' + cssAttPP[i] + ']=' + valeur;
					   	   	   		}
			   	   	   		   	}
			   	   	   		}
			 	 	 		else
			 	 	 		{
			   	   	   		   	for (var i = 0; i < cssAttSP.length; i++)
								{
								   	valeur = $(this).css(cssAttSP[i]);
								   	if (valeur != null)
									{
									   	if (retour != '')
									   		retour += '&';
					   	   	   		   	retour += contexte + '[' + className + '][' + cssAttSP[i] + ']=' + valeur;
					   	   	   		}
			   	   	   		   	}
			   	   	   		}*/

			   	   	   		if (tabObjCliVis[className] != undefined)
							{
							   	valeur = tabObjCliVis[className].RecupererRetour();
								if (valeur != '')
								{
				   	   	   			if (retour != '')
								   		retour += '&';
				   	   	   		   	retour += contexte + '[' + className + '][cligno]=' + valeur;
				   	   	   		}
			   	   	   		}
		   	   	   		}
		   	   	   	});
				}

				return retour;
			}
		};
	}();
	$.fn.extend(
	{
		visualiseur: visualiseur.construct,
		visualiseurRecupererRetour: visualiseur.recupererRetour
	});
})(jQuery)