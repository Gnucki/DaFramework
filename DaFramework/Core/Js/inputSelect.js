(function ($)
{
	var inputSelect = function()
	{
		var
		defaults =
		{
			selectorElement: '.jq_input_select_element',
			selectorDerouleur: '.jq_input_select_derouleur',
			selectorEdit: '.jq_input_select_edit',
			selectorInfo: '.jq_input_select_info',
			selectorErreur: '.jq_input_select_erreur',
			selectorRetour: '.jq_input_select_retour',
			selectorType: '.jq_input_select_type',
			selectorImpact: '.jq_input_select_impact',
			selectorDependance: '.jq_input_select_dependance',
			selectorRechargeFonc: '.jq_input_select_rechargefonc',
			selectorRechargeParam: '.jq_input_select_rechargeparam',
			selectorRef: '.jq_input_select_ref',
			selectorChangeFonc: '.jq_input_select_changefonc',
			selectorChangeParam: '.jq_input_select_changeparam',
			selectorListe: '.jq_input_select_liste',
			selectorBarreDefilement: '.jq_input_select_bardef',
			selectorBarreDefilementBas: '.jq_input_select_bardef_bas',
			selectorBarreDefilementHaut: '.jq_input_select_bardef_haut',
			selectorBarreDefilementBarre: '.jq_input_select_bardef_barre',
			selectorElements: '.jq_input_select_elements',
			selectorElementCategorie: '.jq_input_select_element_categorie',
			selectorElementId: '.jq_input_select_element_id',
			selectorElementLibelle: '.jq_input_select_element_libelle',
			selectorElementDescription: '.jq_input_select_element_description',
			selectorCategorie: '.jq_input_select_categorie',
			selectorCategorieId: '.jq_input_select_categorie_id',
			selectorCategorieLibelle: '.jq_input_select_categorie_libelle',
			classeElementParDefaut: 'jq_input_select_element_defaut',
			classeElementNonFiltre: 'jq_input_select_element_nonfiltre',
			classeSelectFind: 'jq_input_select_find',
			obligatoire: false,
			isEnfantInput: false,
			isSelectImage: false,
			nbElementsAffiches: 12,
			vitesseDefilement: 2
		},

		init = function(jqElem, jqListe, jqEdit, jqDerouleur, options)
		{
			if (options.isEnfantInput != true)
				jqElem.addClass('jq_input_form');

			if (options.isSelectImage == true)
				jqElem.addClass('jq_input_select_image');

			if (options.obligatoire == true && jqElem.hasClass('jq_input_form_oblig') == false)
				jqElem.addClass('jq_input_form_oblig');
			if (jqElem.hasClass('jq_input_select') == false)
				jqElem.addClass('jq_input_select');
			if (jqListe.hasClass('jq_input_select_liste') == false)
				jqListe.addClass('jq_input_select_liste');

			jqElem.data('inputSelectErreur', 0);
			jqElem.data('inputSelectRechargePret', 0);
			jqListe.data('inputSelectRechargePret', 0);
			jqListe.data('isFocus', -2);
			resetBuffer(jqListe, jqEdit, options);

			var jqType = jqElem.find(options.selectorType + ':first');
			var type = $.trim(jqType.text());
			jqElem.data('inputSelectType', type);
			jqListe.data('inputSelectType', type);
			jqType.remove();

			var jqRecFonc = jqElem.find(options.selectorRechargeFonc + ':first');
			jqElem.data('inputSelectRechargFonc', $.trim(jqRecFonc.text()));
			jqRecFonc.remove();

			var jqRecParam = jqElem.find(options.selectorRechargeParam + ':first');
			jqElem.data('inputSelectRechargParam', $.trim(jqRecParam.text()));
			jqRecParam.remove();

			var jqRef = jqElem.find(options.selectorRef);
			jqElem.data('inputSelectRef', $.trim(jqRef.text()));
			jqRef.remove();

			var jqImpact = jqElem.find(options.selectorImpact + ':first');
			var impact = new Array();
			var impactTxt = $.trim(jqImpact.text());
			var i = -1;
			var j = -1;
			while (j >= 0 || i == -1)
			{
				i = j + 1;
				j = impactTxt.indexOf(';', i);
				if (j >= 0)
					impact[impactTxt.substring(i, j)] = 1;
				else
					impact[impactTxt.substring(i, impactTxt.length)] = 1;
			}
			jqElem.data('inputSelectImpact', impact);
			jqListe.data('inputSelectImpact', impact);
			jqImpact.remove();

			var jqDependance = jqElem.find(options.selectorDependance + ':first');
			var depend = new Array();
			var dependTxt = $.trim(jqDependance.text());
			var i = -1;
			var j = -1;
			while (j >= 0 || i == -1)
			{
				i = j + 1;
				j = dependTxt.indexOf(';', i);
				if (j >= 0)
					depend[dependTxt.substring(i, j)] = 1;
				else
					depend[dependTxt.substring(i, dependTxt.length)] = 1;
			}
			jqElem.data('inputSelectDependance', depend);
			jqListe.data('inputSelectDependance', depend);
			jqDependance.remove();

			var jqChangeFonc = jqElem.find(options.selectorChangeFonc + ':first');
			jqListe.data('inputSelectChangeFonc', $.trim(jqChangeFonc.text()));
			jqChangeFonc.remove();

			var jqChangeParam = jqElem.find(options.selectorChangeParam + ':first');
			jqListe.data('inputSelectChangeParam', $.trim(jqChangeParam.text()));
			jqChangeParam.remove();
		},

		initListe = function(jqListe, jqElem, jqEdit, options)
		{
		   	jqListe.data('inputSelectListeCurseurOnBD', 0);
		   	jqListe.data('inputSelectListeNbElements', 0);
		   	jqListe.data('inputSelectListeRedim', 0);

		   	var jqBarreDefilement = jqListe.find(options.selectorBarreDefilement);
		   	jqBarreDefilement.width('20px');
			jqBarreDefilement.css('position', 'relative').css('cursor', 'default').disableSelection();
			var tailleListeReelle = jqListe.data('inputSelectListeHauteurElem')*jqListe.data('inputSelectListeNbElements');
			var tailleBarreDefilement = (jqBarreDefilement.find(options.selectorBarreDefilementBarre).parent() - tailleListeReelle) / 3;
			jqBarreDefilement.find(options.selectorBarreDefilementBarre).css('cursor', 'default').width(20).draggable({
			containment: 'parent',
			axis: 'y',
			drag: function(event, ui)
			{
			   	var tailleBarre = $(this).parent().height();
			   	var posBarre = parseInt($(this).css('top'));
			   	var jqElements = jqListe.find(options.selectorElements);
			   	var tailleListeReelle = jqListe.data('inputSelectListeHauteurElem')*jqListe.data('inputSelectListeNbElementsVisibles');
			   	var scrollVal = (tailleListeReelle - jqElements.height()) * (posBarre / (tailleBarre - $(this).outerHeight(true)));
				jqElements.scrollTop(scrollVal);
			}
			});
			var jqBarreDefilementHaut = jqBarreDefilement.find(options.selectorBarreDefilementHaut);
			var jqBarreDefilementBas = jqBarreDefilement.find(options.selectorBarreDefilementBas);
			jqBarreDefilementHaut.css('position', 'absolute').css('top', '0px').height(20).width(20).find('td').css('text-align', 'center').text('▲');
			jqBarreDefilementBas.css('position', 'absolute').css('bottom', '0px').height(20).width(20).find('td').css('text-align', 'center').text('▼');
			jqBarreDefilement.find(options.selectorBarreDefilementBarre).parent().css('position', 'absolute').css('top', jqBarreDefilementHaut.outerHeight(true)+'px').css('bottom', jqBarreDefilementBas.outerHeight(true)+'px');
			jqBarreDefilement.hide();

			jqBarreDefilement.click(function(e)
			{
			   	e.stopPropagation();
			});

			jqBarreDefilement.mousedown(function(e)
			{
			   	e.stopPropagation();
			});

			jqBarreDefilement.mouseenter(function()
			{
			   	if (jqListe.data('isFocus') < 0)
			   	  	jqListe.data('inputSelectListeCurseurOnBD', 1);
			   	else
			   	   	jqListe.data('inputSelectListeCurseurOnBD', 2);
			});

			jqBarreDefilement.mouseleave(function()
			{
			   	if (jqListe.data('inputSelectListeCurseurOnBD') === 2)
			   	{
			   	   	jqListe.data('inputSelectListeCurseurOnBD', 0);
					jqEdit.focus();
				}
				else
				   	jqListe.data('inputSelectListeCurseurOnBD', 0);
			});

			var jqElements = jqListe.find(options.selectorElements + ':first');
			jqElements.css('overflow', 'hidden');
			jqListe.find('td:first').css('vertical-align', 'top');
		},

		initElement = function(jqElem, jqListe, jqEdit, jqInfo, options, id, libelle, description, categorie)
		{
			jqElem.css('cursor','pointer');
			jqElem.disableSelection();

			if (jqElem.hasClass('jq_input_select_element') == false)
				jqElem.addClass('jq_input_select_element');

			var ajout = false;
			if (id != undefined)
				ajout = true;

			if (id == undefined)
			{
			    var jqId = jqElem.find(options.selectorElementId + ':first');
				id = $.trim(jqId.text());
				jqId.remove();
			}
			if (libelle == undefined)
				libelle = $.trim(jqElem.find(options.selectorElementLibelle).text());
			if (description == undefined)
			{
			   	var jqDesc = jqElem.find(options.selectorElementDescription + ':first');
				description = $.trim(jqDesc.html());
				jqDesc.remove();
			}
			if (categorie == undefined)
			{
			   	var jqCat = jqElem.find(options.selectorElementCategorie + ':first');
				categorie = $.trim(jqCat.text());
				jqCat.remove();
			}
			jqElem.data('inputSelectId', id);
			jqElem.data('inputSelectLib', libelle);
			jqElem.data('inputSelectDesc', description);
			jqElem.data('inputSelectCat', categorie);

			var nbElements = 0;
			if (id != '' && libelle != '')
			{
			   	nbElements = jqListe.data('inputSelectListeNbElements');
				if (nbElements == undefined)
					jqListe.data('inputSelectListeNbElements', 1);
				else
				   	jqListe.data('inputSelectListeNbElements', nbElements + 1);

				if (jqElem.hasClass(options.classeElementParDefaut) == true)
				{
					//if (ajout == false && jqElem.hasClass('jq_input_select_element_defaut') == false)
					//	jqElem.addClass('jq_input_select_element_defaut');
					/*else*/ if (/*ajout == true &&*/ jqElem.hasClass('jq_input_select_element_defaut') == true)
						jqElem.removeClass('jq_input_select_element_defaut');
						jqElem.removeClass(options.classeElementParDefaut);
					setBuffer(jqElem, jqListe, jqEdit, options);
				}

				jqElem.mouseenter(function()
				{
				   	var desc = $(this).data('inputSelectDesc');
					$(this).Clignoter({}, 30, true);
					if (desc != null && desc != undefined && desc != '')
					{
					   	if (jqListe.closest('.jq_input_select').hasClass('jq_input_select_image') === true)
					   	   	desc = '<img src="'+desc+'"/>';
						jqInfo.find('td').html(desc);
						$(this).InfoBullePop({type: 'info'}, jqInfo);
						$(this).InfoBullePop({type: 'erreur'}, jqErreur);
					}
				});

				jqElem.mouseleave(function()
				{
					if ($(this).data('inputSelectSel') != 1)
						$(this).Clignoter({}, 30, false);
				});

				jqElem.mousedown(function()
				{
					setBuffer($(this), jqListe, jqEdit, options);
					jqEdit.blur();
				});
			}
			else
			{
			   	var premier = true;
			   	jqListe.find(options.selectorElement).each(function ()
				{
					if ($(this).data('inputSelectCat') == categorie && $(this).data('inputSelectVide') == 1)
						premier = false;
				});

				if (premier == false)
				{
			   		jqElem.remove();
			   		nbElements = 0;
			   	}
			   	else
			   	{
					jqElem.data('inputSelectVide', 1);
					jqElem.hide();
				}
			}

			if (jqListe.data('inputSelectListeHauteurElem') == undefined && nbElements == 1)
			{
			   	var display = jqListe.css('display');
			   	if (display == 'none')
			   	   	jqListe.css('visibility', 'hidden').show();
			   	jqListe.data('inputSelectListeHauteurElem', jqElem.outerHeight(true));
			   	if (display == 'none')
			   	   	jqListe.hide().css('visibility', 'visible');
			   	var jqElements = jqListe.find(options.selectorElements + ':first');
				jqElements.css('max-height', options.nbElementsAffiches*jqListe.data('inputSelectListeHauteurElem'));
				jqListe.find(options.selectorBarreDefilement + ':first').height(jqListe.height());
			}
		},

		initCategorie = function(jqElem, options, id)
		{
			jqElem.css('cursor','normal');
			jqElem.disableSelection();

			if (jqElem.hasClass('jq_input_select_categorie') == false)
				jqElem.addClass('jq_input_select_categorie');

			if (id == undefined)
			{
			    var jqId = jqElem.find(options.selectorCategorieId + ':first');
				id = $.trim(jqId.text());
				jqId.remove();
			}
			jqElem.data('inputSelectId', id);
		},

		initDerouleur = function(jqDerouleur, jqElem, jqListe, jqEdit, options)
		{
			if (jqDerouleur.hasClass('jq_input_select_derouleur') == false)
				jqDerouleur.addClass('jq_input_select_derouleur');

			jqDerouleur.disableSelection();
			if (jqElem.hasClass(options.classeSelectFind) === true)
				jqDerouleur.width(0).hide();
			else
			{
			   	jqDerouleur.find('td').text('▼');

				jqDerouleur.mouseup(function()
				{
					if (jqListe.data('isFocus') < -1 && jqEdit.data('inputSelectVerouiller') != 1)
					{
						resetBuffer(jqListe, jqEdit, options);
						filtrerListe(jqEdit, jqListe, options);
						jqEdit.focus();
					}
					else
						jqEdit.trigger('blur', [1]);
				});

				jqDerouleur.fill();
				jqDerouleur.find('table:first').fill();
			}
		},

		initEdit = function(jqEdit, jqElem, jqListe, jqDerouleur, jqInfo, options)
		{
			var info = $.trim(jqInfo.find('td').html());
			jqEdit.mouseenter(function ()
			{
				if (info != '')
				{
					jqInfo.find('td').html(info);
					$(this).InfoBullePop({type: 'info'}, jqInfo);
					$(this).InfoBullePop({type: 'erreur'}, jqErreur);
				}
			});

			jqEdit.keyup(function(e)
			{
				var numTouche;

				if (window.event) // IE.
					numTouche = e.keyCode;
				else if (e.which) // Firefox/Opera.
					numTouche = e.which;

				if (numTouche == 13) // Entrée.
					validerSelection(jqListe, $(this), options);
				else if (numTouche == 38) // Flèche haut.
					prendreElementPrecedent(jqListe, $(this), options);
				else if (numTouche == 40) // Flèche bas.
					prendreElementSuivant(jqListe, $(this), options);
				else
				{
				   	if (jqElem.hasClass(options.classeSelectFind) === true && jqElem.data('inputSelectRechargePret') == 1)
				   	{
				   	   	var donnees = 'find=1&valeur=' + jqEdit.val();
						var param = jqElem.data('inputSelectRechargParam');
						if (param != undefined && param != '')
						   	donnees += '&' + param;
						donnees += '&ref=' + jqElem.data('inputSelectRef');
						jqElem.data('donnees', donnees);
						var fonc = jqElem.data('inputSelectRechargFonc');
						if (fonc != '')
						   	eval(fonc + '.call(jqElem.get(0))');
				   	}

					var nbElemVisibles = filtrerListe($(this), jqListe, options);
					if (nbElemVisibles >= options.nbElementsAffiches + 1)
					{
						jqListe.data('inputSelectListeNbElementsVisibles', nbElemVisibles);
						afficherBarreDefilement(jqListe, options);
						calculerDimensionsBarreDefilement(jqListe, nbElemVisibles, options);
					}
					else
						cacherBarreDefilement(jqListe, options);
				}
			});

			jqEdit.focus(function()
			{
				if ($(this).data('inputSelectVerouiller') == 1)
					$(this).blur();
				else if (jqListe.data('isFocus') < 0)
				{
					jqListe.data('isFocus',1);
					var nbElemVisibles = filtrerListe($(this), jqListe, options);
					if (jqElem.data('inputSelectWidth') != jqElem.width())
					{
					   	jqListe.hide().css('visibility', 'visible');
						if (jqListe.data('inputSelectListeNbElements') == 0)
						   	jqListe.width(jqElem.width());
						else
						   	jqListe.width(jqListe.outerWidth() + jqDerouleur.outerWidth());
					  	calculerDimensions(jqElem, jqListe, jqEdit, jqDerouleur, options);
					}
					jqListe.slideDown(500, function()
					{
					   	/*if (jqListe.data('inputSelectListeRedim') == 1)
					   	{
							jqListe.width('');
							jqListe.width(jqListe.width() + jqDerouleur.outerWidth());
							jqListe.data('inputSelectListeRedim', 0);
							//calculerDimensions(jqListe.closest('.jq_input_select'), jqListe, jqEdit, jqDerouleur, options);
						}*/
					   	jqListe.data('isFocus',2);
					   	if (nbElemVisibles >= options.nbElementsAffiches + 1)
						{
						   	jqListe.data('inputSelectListeNbElementsVisibles', nbElemVisibles);
							afficherBarreDefilement(jqListe, options);
							calculerDimensionsBarreDefilement(jqListe, nbElemVisibles, options);
						}
						else
						   	cacherBarreDefilement(jqListe, options);
					});
					jqDerouleur.Clignoter({}, 30, true);
				}
			});

			jqEdit.blur(function(e, fromDerouleur)
			{
			   	if (jqEdit.closest('.jq_visualiseur_vue').length == 0 || fromDerouleur == 1)
			   	{
					if (jqListe.data('isFocus') > 0 && $(this).data('inputSelectVerouiller') != 1 && jqListe.data('inputSelectListeCurseurOnBD') === 0)
					{
						jqListe.data('isFocus',-1);
						jqListe.slideUp(500, function(){jqListe.data('isFocus',-2);});
						jqDerouleur.Clignoter({}, 30, false);

						var filtreValeur = $(this).attr('value');
						var selOk = false;
						if (filtreValeur != '')
						{
							jqListe.find(options.selectorElementLibelle).each(function()
							{
								if ($.trim($(this).text()) == filtreValeur)
									selOk = true;
							});
						}

						if (selOk == false)
							resetBuffer(jqListe, $(this), options);

						cacherBarreDefilement(jqListe, options);
					}
				}
			});

			jqEdit.click(function (e)
			{
				e.stopPropagation();
			});
		},

		initInfo = function(jqInfo, options)
		{
			if (jqInfo.hasClass('jq_input_select_info') == false)
				jqInfo.addClass('jq_input_select_info');

			jqInfo.css('position','absolute').css('z-index',200).hide();
		},

		initErreur = function(jqErreur, options)
		{
			if (jqErreur.hasClass('jq_input_select_erreur') == false)
				jqErreur.addClass('jq_input_select_erreur');

			jqErreur.hide();
		},

		initRetour = function(jqRetour, jqElem)
		{
			var retour = $.trim(jqRetour.text());

			if (retour == undefined)
				retour = '';

			jqElem.data('inputSelectRetour', retour);
			jqRetour.remove();
		},

		filtrerListe = function(jqEdit, jqListe, options)
		{
			var filtreValeur = jqEdit.attr('value');
			var regExp = new RegExp(filtreValeur, 'i');
			var nbElemVisibles = 0;

			jqListe.find(options.selectorElementLibelle).each(function()
			{
			   	if ($(this).hasClass(options.classeElementNonFiltre) === false)
				{
					if (filtreValeur == '' || regExp.test($(this).find('td').text()) == true)
					{
					   	if ($.trim($(this).text()) != '')
						{
					   		$(this).parent().show();
							nbElemVisibles++;
					   	}
					}
					else
					{
					   	if ($.trim($(this).text()) != '')
						{
							//$(this).parent().data('inputSelectSel', 0);
							$(this).parent().hide();
						}
					}
				}
			});

			return nbElemVisibles;
		},

		setBuffer = function(jqElem, jqListe, jqEdit, options)
		{
			if (jqElem.data('inputSelectVide') != 1)
			{
				if (jqListe.data('inputSelectBufId') != jqElem.data('inputSelectId'))
				{
					//jqListe.find(options.selectorElement).data('inputSelectSel', 0);
					jqListe.data('inputSelectBufId', jqElem.data('inputSelectId'));
					jqListe.data('inputSelectBufLib', jqElem.data('inputSelectLib'));
					jqEdit.val(getBufferLibelle(jqListe));
					var animation = true;
					if (jqListe.data('inputSelect') != 1)
						animation = false;
					jqEdit.Clignoter({animation: animation}, 30, true);
					jqListe.find(options.selectorElement).each(function()
					{
						if ($(this).data('inputSelectSel') == 1)
						{
					   	   	$(this).Clignoter({}, 30, false);
					   	   	$(this).data('inputSelectSel', 0);
					   	}
					});
					jqElem.data('inputSelectSel', 1);
					jqElem.Clignoter({animation: animation}, 30, true);
					if (jqListe.closest('.jq_input_select').hasClass('jq_input_select_image') === true)
					   	jqEdit.trigger('changeEtatInput', jqElem.data('inputSelectDesc'));
					else
					   	jqEdit.trigger('changeEtatInput', jqElem.data('inputSelectLib'));

					if (jqListe.data('inputSelect') == 1 && jqListe.data('inputSelectRechargePret') == 1)
					{
						var params =
						{
							action: 'rechargement',
							valeur: jqElem.data('inputSelectId'),
							declencheur: jqListe.data('inputSelectType'),
							cibles: jqListe.data('inputSelectImpact'),
							dependances: jqListe.data('inputSelectDependance')
						};
						jqEdit.trigger('eventForm', params);

						var fonc = jqListe.data('inputSelectChangeFonc');
					   	if (fonc != '')
					   	{
					   	   	var jqSelect = jqListe.closest('.jq_input_select');
					   	   	var donnees = jqSelect.inputSelectRecupererRetour();
							var param = jqListe.data('inputSelectChangeParam');
							if (param != undefined && param != '')
							   	donnees += '&' + param;
							//donnees += '&ref=' + jqElem.data('inputSelectRef');
							jqSelect.data('donnees', donnees);
							eval(fonc + '.call(jqSelect.get(0))');
					   	}
					}
				}
				return true;
			}
			return false;
		},

		resetBuffer = function(jqListe, jqEdit, options)
		{
			//if (jqListe.data('inputSelectBufId') != '')
			//{
				jqListe.data('inputSelectBufId', '');
				jqListe.data('inputSelectBufLib', '');
				jqEdit.val('');
				//jqListe.find(options.selectorElement).Clignoter({animation: animation}, 30, false);
				if (jqListe.data('inputSelect') == 1)
				{
					jqListe.find(options.selectorElement).each(function()
					{
						if ($(this).data('inputSelectSel') == 1)
						{
					   	   	$(this).Clignoter({}, 30, false);
					   	   	$(this).data('inputSelectSel', 0);
					   	}
					});
					jqEdit.Clignoter({}, 30, false);

					if (jqListe.data('inputSelect') == 1 && jqListe.data('inputSelectRechargePret') == 1)
					{
						var jqElem = jqListe.closest('.jq_input_select');
						if (jqElem.hasClass(options.classeSelectFind) === true && jqElem.data('inputSelectRechargePret') == 1)
					   	{
					   	   	var donnees = 'valeur=' + jqEdit.val();
							var param = jqElem.data('inputSelectRechargParam');
							if (param != undefined && param != '')
							   	donnees += '&' + param;
							donnees += '&ref=' + jqElem.data('inputSelectRef');
							jqElem.data('donnees', donnees);
							var fonc = jqElem.data('inputSelectRechargFonc');
							if (fonc != '')
							   	eval(fonc + '.call(jqElem.get(0))');
					   	}

					   	var params =
						{
							action: 'rechargement',
							valeur: '',
							declencheur: jqListe.data('inputSelectType'),
							cibles: jqListe.data('inputSelectImpact'),
							dependances: jqListe.data('inputSelectDependance')
						};
						jqEdit.trigger('eventForm', params);

						var fonc = jqListe.data('inputSelectChangeFonc');
					   	if (fonc != '')
					   	{
					   	   	var jqElem = jqListe.closest('.jq_input_select');
					   	   	var donnees = jqElem.inputSelectRecupererRetour();
							var param = jqListe.data('inputSelectChangeParam');
							if (param != undefined && param != '')
							   	donnees += '&' + param;
							//donnees += '&ref=' + jqElem.data('inputSelectRef');
							jqElem.data('donnees', donnees);
							eval(fonc + '.call(jqElem.get(0))');
					   	}
					}
				}

				jqEdit.trigger('changeEtatInput', '');
			//}
		},

		getBufferId = function(jqListe)
		{
			return jqListe.data('inputSelectBufId');
		},

		getBufferLibelle = function(jqListe)
		{
			return jqListe.data('inputSelectBufLib');
		},

		prendreElementPrecedent = function(jqListe, jqEdit, options, nobuff)
		{
			var jqBuffer;

			if (nobuff != true)
			{
				jqListe.find(options.selectorElement).each(function()
				{
					if ($(this).data('inputSelectSel') == 1)
						jqBuffer = $(this);
				});
			}

			if (jqBuffer != undefined)
			{
				var jqElemPrev = jqBuffer.parent().prev();
				while (jqElemPrev.html() != null)
				{
					var jqElem = jqElemPrev.find(options.selectorElement + ':visible');
					if (jqElem.find(options.selectorElementLibelle + ':visible').html() != null)
					{
						if (setBuffer(jqElem, jqListe, jqEdit, options) == true)
							return;
					}
					jqElemPrev = jqElemPrev.prev();
				}
				prendreElementPrecedent(jqListe, jqEdit, options, true);
			}
			else
			{
				var jqElemPrev = jqListe.find(options.selectorElement + ':last').parent();
				while (jqElemPrev.html() != null)
				{
					var jqElem = jqElemPrev.find(options.selectorElement);
					if (jqElem.find(options.selectorElementLibelle + ':visible').html() != null)
					{
						if (setBuffer(jqElem, jqListe, jqEdit, options) == true)
							return;
					}
					jqElemPrev = jqElemPrev.prev();
				}
			}
		},

		prendreElementSuivant = function(jqListe, jqEdit, options, nobuff)
		{
			var jqBuffer;

			if (nobuff != true)
			{
				jqListe.find(options.selectorElement).each(function()
				{
					if ($(this).data('inputSelectSel') == 1)
						jqBuffer = $(this);
				});
			}

			if (jqBuffer != undefined)
			{
				var jqElemNext = jqBuffer.parent().next();
				while (jqElemNext.html() != null)
				{
					var jqElem = jqElemNext.find(options.selectorElement);
					if (jqElem.find(options.selectorElementLibelle + ':visible').html() != null)
					{
						if (setBuffer(jqElem, jqListe, jqEdit, options) == true)
							return;
					}
					jqElemNext = jqElemNext.next();
				}
				prendreElementSuivant(jqListe, jqEdit, options, true);
			}
			else
			{
				var jqElemNext = jqListe.find(options.selectorElement + ':first').parent();
				while (jqElemNext.html() != null)
				{
					var jqElem = jqElemNext.find(options.selectorElement);
					if (jqElem.find(options.selectorElementLibelle + ':visible').html() != null)
					{
						if (setBuffer(jqElem, jqListe, jqEdit, options) == true)
							return;
					}
					jqElemNext = jqElemNext.next();
				}
			}
		},

		validerSelection = function(jqListe, jqEdit, options)
		{
			var filtreValeur = jqEdit.attr('value');
			jqListe.find(options.selectorElementLibelle).each(function()
			{
				if ($.trim($(this).text()) == filtreValeur)
				{
					setBuffer($(this).parent(), jqListe, jqEdit, options);
					jqEdit.blur();
				}
			});
		},

		vider = function(jqElem, options)
		{
			var premier = true;
			var currentCat = '';

			var jqClone;
			var jqListe = jqElem.find('.jq_input_select_liste');
			var jqInfo = jqElem.find('.jq_input_select_info');
			var jqEdit = jqElem.find('.jq_input_select_edit');

			resetBuffer(jqListe, jqEdit, options);
			jqElem.find('.jq_input_select_element').each(function ()
			{
				if ($(this).data('inputSelectCat') != currentCat)
				{
					premier = true;
					currentCat = $(this).data('inputSelectCat');
				}
				if (premier == true)
				{
					$(this).find('.jq_input_select_element_libelle').find('td:first').text('');
					$(this).data('inputSelectId', '');
					$(this).data('inputSelectLib', '');
					$(this).data('inputSelectDesc', '');
					$(this).data('inputSelectCat', '');
					$(this).data('inputSelectVide', 1);
					$(this).hide();
					premier = false;
					//jqClone = $(this).parent().clone();
					//jqClone.insertBefore($(this).parent());
					//initElement(jqClone.children(), jqListe, jqEdit, jqInfo, false, '', '', '', currentCat);
				}
				else
					$(this).remove();
			});
		},

		afficherBarreDefilement = function(jqListe, options)
		{
		   	jqListe.find(options.selectorBarreDefilement).show();
		},

		cacherBarreDefilement = function(jqListe, options)
		{
		   	jqListe.find(options.selectorBarreDefilement).hide();
		},

		calculerDimensionsBarreDefilement = function(jqListe, nbElements, options)
		{
		   	var jqBarreDefilement = jqListe.find(options.selectorBarreDefilement + ':first');
		   	var jqBarreDefilementBas = jqBarreDefilement.find(options.selectorBarreDefilementBas + ':first');
		   	var jqBarreDefilementHaut = jqBarreDefilement.find(options.selectorBarreDefilementHaut + ':first');
		   	var jqBarreDefilementBarre = jqBarreDefilement.find(options.selectorBarreDefilementBarre + ':first');
		   	var tailleListeReelle = jqListe.data('inputSelectListeHauteurElem')*nbElements;
		   	var tailleBarreDefilementParent = jqBarreDefilementBarre.parent().height() - jqBarreDefilementBas.outerHeight(true) - jqBarreDefilementHaut.outerHeight(true);
		   	jqBarreDefilementBarre.parent().css('top', jqBarreDefilementHaut.outerHeight(true)).css('bottom', jqBarreDefilementBas.outerHeight(true) + (jqBarreDefilementBarre.outerHeight(true) - jqBarreDefilementBarre.innerHeight()));
			var tailleBarreDefilement = tailleBarreDefilementParent - ((tailleListeReelle - tailleBarreDefilementParent) / options.vitesseDefilement);
			if (isNaN(tailleBarreDefilement) || tailleBarreDefilement <= 10)
			   	tailleBarreDefilement = 10;
			jqBarreDefilement.width(20);
			jqBarreDefilementBarre.parent().width(20);
			jqBarreDefilement.parent().css('top', '0px');
			jqBarreDefilement.css('top', '0px').fill().find('table:first').fill();
			jqBarreDefilement.css('position', 'relative').css('cursor', 'default').disableSelection();
			jqBarreDefilementBarre.find('td:first').height(tailleBarreDefilement).end().height(tailleBarreDefilement).width(20).css('top', '0px');
			jqListe.find(options.selectorElements).scrollTop(0);
			jqBarreDefilement.find('table').fill();
			jqBarreDefilement.find('td').fill();
		},

		calculerDimensions = function(jqElem, jqListe, jqEdit, jqDerouleur, options)
		{
		   	jqEdit.attr('size', '1');

		   	var positionRelative = false;
		   	if (jqElem.offsetParent().css('position') == 'relative')
		   	{
			   	positionRelative = true;
		   	    jqElem.data('inputSelectEditTailleMax', jqElem.width());
		   	}
		   	if (jqElem.closest('.jq_center').length == 1)
		   		jqElem.removeData('inputSelectEditTailleMax');
		   	jqElem.trigger('inputSelectPreRedim');

		   	var padding = 0;
			var pad = 0;

			if (jqEdit.css('paddingLeft') != 0)
			{
			   	pad = parseInt(jqEdit.css('paddingLeft'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}
			if (jqEdit.css('paddingRight') != 0)
			{
			   	pad = parseInt(jqEdit.css('paddingRight'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}
			if (jqEdit.css('borderLeftWidth') != 0)
			{
			   	pad = parseInt(jqEdit.css('borderLeftWidth'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}
			if (jqEdit.css('borderRightWidth') != 0)
			{
			   	pad = parseInt(jqEdit.css('borderRightWidth'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}
			if (jqEdit.parent().css('paddingLeft') != 0)
			{
			   	pad = parseInt(jqEdit.parent().css('paddingLeft'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}
			if (jqEdit.parent().css('paddingRight') != 0)
			{
			   	pad = parseInt(jqEdit.parent().css('paddingRight'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}
			if (jqEdit.parent().css('borderLeftWidth') != 0)
			{
			   	pad = parseInt(jqEdit.parent().css('borderLeftWidth'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}
			if (jqEdit.parent().css('borderRightWidth') != 0)
			{
			   	pad = parseInt(jqEdit.parent().css('borderRightWidth'));
			   	if (isNaN(pad))
			   		pad = 0;
				padding += pad;
			}

		   	//jqEdit.attr('size', '');
		   	//jqEdit.removeAttr('size');
		   	for (i=0; i < jqEdit.get(0).attributes.length; i++)
			{
				if (jqEdit.get(0).attributes[i].nodeName == 'size')
				   	 jqEdit.get(0).attributes[i].nodeValue = '';
			}

			var tailleMax = jqElem.data('inputSelectEditTailleMax');
		   	if (tailleMax != undefined && jqElem.width() > tailleMax)
		   	{
		   	   	jqEdit.width(tailleMax - jqDerouleur.outerWidth() - padding);
		   		jqElem.width(tailleMax);
		   	}
		   	else if (positionRelative == true)
		   	{
		   	   	if (jqElem.innerWidth() > jqListe.outerWidth())
				{
				   	jqEdit.width(jqListe.outerWidth() - jqDerouleur.outerWidth() - padding);
					jqElem.width(jqListe.outerWidth());
				}
		   	   	else
		   	   	   	jqListe.width(jqListe.parent().innerWidth());
		   	}

			jqListe.css('visibility', 'hidden');
			jqListe.css('position', 'absolute');
			//jqListe.css('overflow', 'hidden');
			jqListe.css('white-space', 'nowrap');
			jqListe.css('z-index', 100);

			if (positionRelative == true)
			{
			   	jqEdit.width(jqElem.innerWidth() - jqDerouleur.outerWidth() - padding);

				if (jqElem.innerWidth() > jqListe.outerWidth())
				{
				   	jqEdit.width(jqListe.outerWidth() - jqDerouleur.outerWidth() - padding);
					jqElem.width(jqListe.outerWidth());
				}
			}
			else
			   	jqEdit.width(jqListe.outerWidth() - jqDerouleur.outerWidth() - padding);

			if (jqListe.data('inputSelectListeNbElements') == 0)
				jqListe.width(jqElem.width());

			var jqBarreDefilement = jqListe.find(options.selectorBarreDefilement);
			jqBarreDefilement.show();

			calculerDimensionsBarreDefilement(jqListe, jqListe.data('inputSelectListeNbElements'), options);
			jqBarreDefilement.hide();
			jqListe.hide().css('visibility', 'visible');

			jqElem.trigger('inputSelectPostRedim');

			jqElem.data('inputSelectWidth', jqElem.width());
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
				   	var elem = $(this);
					if (elem.data('inputSelect') != 1)
					{
						var liste = elem.find(options.selectorListe + ':first');
						var edit = elem.find(options.selectorEdit + ':first');
						var derouleur = elem.find(options.selectorDerouleur + ':first');
						var info = elem.find(options.selectorInfo + ':first');
						var erreur = elem.find(options.selectorErreur + ':first');
						var retour = elem.find(options.selectorRetour + ':first');

						info.hide();
						erreur.hide();
						retour.hide();

						init(elem, liste, edit, derouleur, options);

						initListe(liste, elem, edit, options);

						derouleur.each(function()
						{
							initDerouleur($(this), elem, liste, edit, options);
						});

						edit.each(function()
						{
							initEdit($(this), elem, liste, derouleur, info, options);
						});

						info.each(function()
						{
							initInfo($(this), options);
						});

						erreur.each(function()
						{
							initErreur($(this), options);
						});

						elem.find(options.selectorCategorie).each(function()
						{
							initCategorie($(this), options);
						});

						elem.find(options.selectorElement).each(function()
						{
							initElement($(this), liste, edit, info, options);
						});

						retour.each(function()
						{
							initRetour($(this), elem);
						});

						liste.hide().css('visibility', 'visible');
						if (liste.data('inputSelectListeNbElements') == 0)
						   	liste.width(elem.width());
						else
						   	liste.width(liste.outerWidth() + derouleur.outerWidth());
						calculerDimensions(elem, liste, edit, derouleur, options);

						elem.data('inputSelect', 1);
						liste.data('inputSelect', 1);
					}
				});
			},

			ajouterElement: function (id, libelle, description, categorie, activer)
			{
			   	var options = $.extend({}, defaults, options || {});
				var valeur = '', insere = false, existeDeja = false, elemVide = false, nbElements = 0;
				var jqClone, jqLast, jqElem;
				var jqListe = $(this).find('.jq_input_select_liste:first');
				var jqInfo = $(this).find('.jq_input_select_info:first');
				var jqEdit = $(this).find('.jq_input_select_edit:first');
				var jqDerouleur = $(this).find('.jq_input_select_derouleur:first');

				$(this).find('.jq_input_select_element').each(function()
				{
					var cat = $(this).data('inputSelectCat').toLowerCase();

					if (jqClone == undefined)
					{
						jqClone = $(this).parent().clone();
						jqClone.find('.jq_clignotant').andSelf().stop(true, true).removeData('clignotement').removeData('clignotementActif').removeData('clignotementExistant')
						   	   	   	   	   	   	   	   	   	   	.css('color', null)
						   	   	   	   	   	   	   	   	   	   	.css('background-color', null)
						   	   	   	   	   	   	   	   	   	   	.css('border-top-color', null)
						   	   	   	   	   	   	   	   	   	   	.css('border-left-color', null)
						   	   	   	   	   	   	   	   	   	   	.css('border-right-color', null)
						   	   	   	   	   	   	   	   	   	   	.css('border-bottom-color', null)
						   	   	   	   	   	   	   	   	   	   	.css('opacity', null)
						   	   	   	   	   	   	   	   	   	   	.removeClass('jq_clignotant');
					}

					if (insere == false && cat == categorie)
					{
						nbElements++;

						jqLast = $(this).parent();

						var lib = $(this).data('inputSelectLib').toLowerCase();
						if (lib == '')
						{
							jqElem = $(this);
							elemVide = true;
						}
						else if (lib > libelle.toLowerCase())
							insere = true;

						if ($(this).data('inputSelectId') == id)
						{
							existeDeja = true;
							jqElem = $(this);
						}
					}
				});

				if (elemVide == true && nbElements == 1)
				{
					jqElem.find('.jq_input_select_element_libelle').find('td').text(libelle);

					jqElem.data('inputSelectId', id);
					jqElem.data('inputSelectLib', libelle);
					jqElem.data('inputSelectDesc', description);
					jqElem.data('inputSelectCat', categorie);

					jqElem.removeData('inputSelectVide');

					if (activer == true)
						jqElem.addClass('jq_input_select_element_defaut');

					initElement(jqElem, jqListe, jqEdit, jqInfo, defaults, id, libelle, description, categorie);
					var nbElemVisibles = filtrerListe(jqEdit, jqListe, options);
					if (nbElemVisibles >= options.nbElementsAffiches + 1)
					{
						jqListe.data('inputSelectListeNbElementsVisibles', nbElemVisibles);
						afficherBarreDefilement(jqListe, options);
						calculerDimensionsBarreDefilement(jqListe, nbElemVisibles, options);
					}
					else
						cacherBarreDefilement(jqListe, options);
					//jqListe.height(200);
					jqListe.find('table:first').fill();
					/*jqListe.width('');
					jqListe.width(jqListe.width() + jqDerouleur.outerWidth());*/
					//calculerDimensions($(this), jqListe, jqEdit, jqDerouleur, defaults);
				}
				else if (existeDeja == false)
				{
					if (insere == false)
					{
					   	if (jqLast == undefined)
						{
					   		$(this).find('.jq_input_select_categorie').each(function()
					   		{
					   		   	if (categorie == $(this).data('inputSelectId').toLowerCase())
					   		   		jqLast = $(this).parent();
					   		});
					   	}
						jqClone.insertAfter(jqLast);
					}
					else
						jqClone.insertBefore(jqLast);

					jqClone.html(jqClone.html());

					jqClone.find('.jq_input_select_element_libelle').find('td').text(libelle);

					var jqCloneChild = jqClone.children();
					if (activer == true)
						jqCloneChild.addClass('jq_input_select_element_defaut');

					//jqClone.find('.jq_clignotant').andSelf().removeClass('jq_clignotant');

					initElement(jqCloneChild, jqListe, jqEdit, jqInfo, defaults, id, libelle, description, categorie);

					/*var nbElemVisibles = filtrerListe(jqEdit, jqListe, options);
					if (nbElemVisibles >= options.nbElementsAffiches + 1)
					{
						jqListe.data('inputSelectListeNbElementsVisibles', nbElemVisibles);
						afficherBarreDefilement(jqListe, options);
						calculerDimensionsBarreDefilement(jqListe, nbElemVisibles, options);
					}
					else
						cacherBarreDefilement(jqListe, options);
					jqListe.find('table:first').fill();*/

					/*jqListe.data('inputSelectListeRedim', 1);
					jqListe.width('');
					jqListe.width(jqListe.width() + jqDerouleur.outerWidth());*/
					//calculerDimensions($(this), jqListe, jqEdit, jqDerouleur, defaults);
				}
				else if (activer == true)
					setBuffer(jqElem, jqListe, jqEdit, defaults);
			},

			supprimerElement: function (id)
			{
			   	var options = $.extend({}, defaults, options || {});
			   	var jqElements = $(this).find('.jq_input_select_element');
			   	var jqListe = $(this).find(options.selectorListe + ':first');
				var jqEdit = $(this).find(options.selectorEdit + ':first');

				jqElements.each(function()
				{
				   	if (id != '' && $(this).data('inputSelectId') == id)
				   	{
				   	   	if (jqListe.data('inputSelectBufId') == id)
				   	   		resetBuffer(jqListe, jqEdit, options);

				   	   	if (jqElements.length > 1)
				   	   	   	$(this).remove();
				   	   	else
				   	   	{
					   	   	$(this).find('.jq_input_select_element_libelle').find('td:first').text('');
							$(this).data('inputSelectId', '');
							$(this).data('inputSelectLib', '');
							$(this).data('inputSelectDesc', '');
							$(this).data('inputSelectCat', '');
							$(this).data('inputSelectVide', 1);
							$(this).hide();
						}
				   	}
				});
			},

			selectionnerElement: function (id)
			{
			   	var options = $.extend({}, defaults, options || {});
			   	var jqListe = $(this).find(options.selectorListe + ':first');
				var jqEdit = $(this).find(options.selectorEdit + ':first');

				$(this).find('.jq_input_select_element').each(function()
				{
					if (id != '' && $(this).data('inputSelectId') == id)
					   	setBuffer($(this), jqListe, jqEdit, options);
				});
			},

			ajouterCategorie: function (id, libelle)
			{
			   	var options = $.extend({}, defaults, options || {});
				var jqClone;
				var insertionOk = false;

				$(this).find('.jq_input_select_categorie').each(function()
				{
				   	if ($(this).data('inputSelectId') == id)
				   		insertionOk = true;
				});

				if (insertionOk === false)
				{
					$(this).find('.jq_input_select_categorie').each(function()
					{
					   	if (jqClone == undefined)
					   	{
					   	   	jqClone = $(this).parent().clone();
					   		jqClone.find(options.selectorCategorieLibelle + ':first').find('td:first').html(libelle);
					   	}
					   	if (insertionOk === false && $.trim(jqClone.find(options.selectorCategorieLibelle + ':first').find('td:first').text()) > libelle)
						{
						   	insertionOk = true;
					   		$(this).parent().before(jqClone);
					   	}
					});
				}

				if (jqClone != undefined)
				{
				   	if (insertionOk === false)
					   	$(this).find('.jq_input_select_element:last').parent().after(jqClone);

				   	initCategorie(jqClone.children(), options, id);
				}
			},

			supprimerCategorie: function (id)
			{
			   	var jqListe = $(this).find('.jq_input_select_categorie');

				jqListe.each(function()
				{
				   	if (id != '' && $(this).data('inputSelectId') == id)
				   	{
				   	   	if (jqListe.length > 1)
				   	   	   	$(this).remove();
				   	   	else
				   	   	{
					   	   	$(this).find('.jq_input_select_categorie_libelle').find('td:first').text('');
							$(this).data('inputSelectId', '');
							$(this).hide();
						}
				   	}
				});
			},

			recupererValeur: function ()
			{
				var valeur = '';

				var jqListe = $(this).find('.jq_input_select_liste');
				if (jqListe != null && jqListe != undefined)
					valeur = getBufferId(jqListe);

				return valeur;
			},

			recupererRetour: function ()
			{
				var retour = $(this).data('inputSelectRetour');

				if (retour == undefined || retour == '')
					return '';

				return retour + '=' + inputSelect.recupererValeur.apply(this);
			},

			fixerValeur: function (id)
			{
				return this.each(function()
				{
					var jqListe = $(this).find('.jq_input_select_liste:first');
					var jqEdit = $(this).find('.jq_input_select_edit:first');

					jqListe.find('.jq_input_select_element').each(function()
					{
					   	if ($(this).data('inputSelectId') == id)
						   	setBuffer($(this), jqListe, jqEdit, defaults);
					});
				});
			},

			fixerValeurFromDesc: function (desc)
			{
				return this.each(function()
				{
					var jqListe = $(this).find('.jq_input_select_liste:first');
					var jqEdit = $(this).find('.jq_input_select_edit:first');

					desc = $.trim(desc);

					jqListe.find('.jq_input_select_element').each(function()
					{
					   	if ($(this).data('inputSelectDesc') == desc)
						   	setBuffer($(this), jqListe, jqEdit, defaults);
					});
				});
			},

			afficherMessageErreur: function (jqElem)
			{
				$(this).data('inputSelectErreur', 1);
				jqElem.InfoBullePop({type: 'erreur'}, $(this).find('.jq_input_select_erreur'));
			},

			effacerMessageErreur: function (jqElem)
			{
				if ($(this).data('inputSelectErreur') == 1)
				{
					$(this).data('inputSelectErreur', 0);
					jqElem.InfoBulleDepop({type: 'erreur'}, $(this).find('.jq_input_select_erreur'));
				}
			},

			reset: function ()
			{
				return this.each(function ()
				{
					var liste = $(this).find(defaults.selectorListe);
					var edit = $(this).find(defaults.selectorEdit);
					var reset = false;

					liste.find(defaults.selectorElements).each(function()
					{
						if ($(this).hasClass(defaults.classeElementParDefaut) == true)
						{
							setBuffer($(this), liste, edit, defaults);
							reset = true;
						}
					});

					if (reset === false)
						resetBuffer(liste, edit, defaults);
				});
			},

			activer: function (activer)
			{
				return this.each(function ()
				{
					if (activer != false)
						$(this).data('inputSelectVerouiller', 0);
					else
						$(this).data('inputSelectVerouiller', 1);

					var jqEdit = $(this).find('.jq_input_select_edit');
					var jqDerouleur = $(this).find('.jq_input_select_derouleur');
					if (jqEdit != null && jqEdit != undefined)
					{
						if (activer != false)
						{
							jqEdit.data('inputSelectVerouiller', 0);
							jqEdit.Clignoter({}, 40, false);
							jqEdit.css('cursor', 'auto');
							jqEdit.enableSelection();
							jqDerouleur.Clignoter({}, 40, false);
							jqDerouleur.css('cursor', 'pointer');
						}
						else
						{
							jqEdit.data('inputSelectVerouiller', 1);
							jqEdit.Clignoter({}, 40, true);
							jqEdit.css('cursor', 'not-allowed');
							jqEdit.disableSelection();
							jqDerouleur.Clignoter({}, 40, true);
							jqDerouleur.css('cursor', 'not-allowed');
						}
					}
				});
			},

			rechargement: function (params, vidage)
			{
				return this.each(function ()
				{
				   	if (vidage !== false)
					   	vider($(this) , defaults);
					//if (params != '')
					//{
						var donnees = '';
						if (params != -1)
							donnees = params;
						var param = $(this).data('inputSelectRechargParam');
						if (param != undefined && param != '')
						{
						   	if (donnees != '')
							   	donnees += '&'
						   	donnees += param;
						}
						if (donnees != '')
							donnees += '&';
						donnees += 'ref=' + $(this).data('inputSelectRef');
						$(this).data('donnees', donnees);
						eval($(this).data('inputSelectRechargFonc') + '.call(this)');
					//}
				});
			},

			recalculerDimensions: function()
			{
				return this.each(function()
				{
				   	var jqListe = $(this).find(defaults.selectorListe + ':first');
					var jqEdit = $(this).find(defaults.selectorEdit + ':first');
					var jqDerouleur = $(this).find(defaults.selectorDerouleur + ':first');
				   	calculerDimensions($(this), jqListe, jqEdit, jqDerouleur, defaults);
				});
			},

			activerRechargement: function()
			{
				return this.each(function()
				{
				   	$(this).data('inputSelectRechargePret', 1);
				   	$(this).find(defaults.selectorListe + ':first').data('inputSelectRechargePret', 1);
				});
			},

			desactiverRechargement: function()
			{
				return this.each(function()
				{
				   	$(this).data('inputSelectRechargePret', 0);
				   	$(this).find(defaults.selectorListe + ':first').data('inputSelectRechargePret', 0);
				});
			},

			setClignotement: function()
			{
			   	var options = $.extend({}, defaults, options || {});

				return this.each(function()
				{
					var valeur = false;

					$(this).find(options.selectorElement).each(function()
					{
						if (valeur === false && $(this).data('inputSelectSel') == 1)
						{
						   	valeur = true;
						   	$(this).Clignoter({}, 30, true);
						}
					});

					if (valeur === true)
						$(this).find(defaults.selectorEdit + ':first').Clignoter({}, 30, true);
				});
			},

			setDimensions: function()
			{
			   	var options = $.extend({}, defaults, options || {});

				return this.each(function()
				{
				   	var jqElem = $(this);
				   	var jqListe = jqElem.find(options.selectorListe + ':first');
					var jqEdit = jqElem.find(options.selectorEdit + ':first');
					var jqDerouleur = jqElem.find(options.selectorDerouleur + ':first');

				   	if (jqElem.data('inputSelectWidth') != jqElem.width())
					{
					   	jqListe.hide().css('visibility', 'visible');
						if (jqListe.data('inputSelectListeNbElements') == 0)
						   	jqListe.width(jqElem.width());
						else
						   	jqListe.width(jqListe.outerWidth() + jqDerouleur.outerWidth());
					  	calculerDimensions(jqElem, jqListe, jqEdit, jqDerouleur, options);
					}
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputSelect: inputSelect.construct,
		inputSelectAjouterElement: inputSelect.ajouterElement,
		inputSelectSupprimerElement: inputSelect.supprimerElement,
		inputSelectSelectionnerElement: inputSelect.selectionnerElement,
		inputSelectAjouterCategorie: inputSelect.ajouterCategorie,
		inputSelectSupprimerCategorie: inputSelect.supprimerCategorie,
		inputSelectRecupererValeur: inputSelect.recupererValeur,
		inputSelectRecupererRetour: inputSelect.recupererRetour,
		inputSelectFixerValeur: inputSelect.fixerValeur,
		inputSelectFixerValeurFromDesc: inputSelect.fixerValeurFromDesc,
		inputSelectAfficherMessageErreur: inputSelect.afficherMessageErreur,
		inputSelectEffacerMessageErreur: inputSelect.effacerMessageErreur,
		inputSelectReset: inputSelect.reset,
		inputSelectActiver: inputSelect.activer,
		inputSelectRechargement: inputSelect.rechargement,
		inputSelectRecalculerDimensions: inputSelect.recalculerDimensions,
		inputSelectActiverRechargement: inputSelect.activerRechargement,
		inputSelectDesactiverRechargement: inputSelect.desactiverRechargement,
		inputSelectSetClignotement: inputSelect.setClignotement,
		inputSelectSetDimensions: inputSelect.setDimensions
	});
})(jQuery)