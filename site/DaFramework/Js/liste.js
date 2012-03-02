(function ($)
{
	var liste = function()
	{
		var
		defaults =
		{
			width: 'auto',
			selectorInfo: '.jq_liste_info',
			selectorType: '.jq_liste_type',
			selectorTypeSynchro: '.jq_liste_typesynchro',
			selectorNumero: '.jq_liste_numero',
			selectorNiveau: '.jq_liste_niveau',
			selectorErreur: '.jq_liste_erreur',
			selectorRetour: '.jq_liste_retour',
			classeSortable: 'jq_liste_sortable',
			selectorSortableFoncInIn: '.jq_liste_sortable_foncinin',
			selectorSortableParamInIn: '.jq_liste_sortable_paraminin',
			selectorSortableFoncInOut: '.jq_liste_sortable_foncinout',
			selectorSortableParamInOut: '.jq_liste_sortable_paraminout',
			selectorSortableFoncOutIn: '.jq_liste_sortable_foncoutin',
			selectorSortableParamOutIn: '.jq_liste_sortable_paramoutin',
			selectorNbElemParPage: '.jq_liste_nbelemparpage',
			selectorElementModele: '.jq_liste_elementmodele',
			selectorElementCreation: '.jq_liste_elementcreat',
			selectorListe: '.jq_liste_liste',
			selectorElement: '.jq_liste_element',
			selectorElementFonction: '.jq_liste_element_fonction',
			selectorElementParam: '.jq_liste_element_param',
			selectorElementOrdre: '.jq_liste_element_ordre',
			selectorElementId: '.jq_liste_element_id',
			selectorElementMenus: '.jq_liste_element_menus',
			selectorElementMenu: '.jq_liste_element_menu',
			selectorElementMenuElem: '.jq_liste_element_menuelem',
			selectorElementMenuElemLib: '.jq_liste_element_menuelem_lib',
			selectorElementMenuElemBoutonFonc: '.jq_liste_element_menuelem_boutonfonc',
			selectorElementMenuElemBoutonParam: '.jq_liste_element_menuelem_boutonparam',
			selectorElementMenuElemBoutonCadre: '.jq_liste_element_menuelem_boutoncadre',
			classeElementMenuElemBoutonAjax: 'jq_liste_element_menuelem_boutonajax',
			classeElementMenuElemBoutonReset: 'jq_liste_element_menuelem_boutonreset',
			selectorElementChamps: '.jq_liste_element_champs',
			selectorElementChamp: '.jq_liste_element_champ',
			selectorElementChampValeur: '.jq_liste_element_champ_valeur',
			selectorElementChampNom: '.jq_liste_element_champ_nom',
			selectorElementChampType: '.jq_liste_element_champ_type',
			selectorElem: '.jq_liste_elem',
			selectorElemMenus: '.jq_liste_elem_menus',
			selectorElemMenu: '.jq_liste_elem_menu',
			selectorElemMenuElem: '.jq_liste_elem_menuelem',
			selectorElemMenuElemBouton: '.jq_liste_elem_menuelem_bouton',
			selectorElemChamp: '.jq_liste_elem_champ',
			selectorElemChampNom: '.jq_liste_elem_champ_nom',
			selectorElemChampType: '.jq_liste_elem_champ_type',
			selectorElemEtage: '.jq_liste_elem_etage',
			selectorElemEtageNum: '.jq_liste_elem_etage_num',
			selectorElemEtageChargeFonc: '.jq_liste_elem_etage_chargefonc',
			selectorElemEtageChargeParam: '.jq_liste_elem_etage_chargeparam',
			selectorElemTitre: '.jq_liste_elem_titre',
			selectorElemIndic: '.jq_liste_elem_indic',
			selectorElemContenu: '.jq_liste_elem_contenu',
			selectorElemContenuChargeFonc: '.jq_liste_elem_contenu_chargefonc',
			selectorElemContenuChargeParam: '.jq_liste_elem_contenu_chargeparam',
			classeElemPliant: 'jq_liste_elem_pliant',
			selectorPageChangeFonc: '.jq_liste_page_changefonc',
			selectorPageChangeParam: '.jq_liste_page_changeparam',
			selectorPageNavigateur: '.jq_liste_page_navigateur',
			selectorPageBarreDefilement: '.jq_liste_page_barredefilement',
			selectorPagePrec: '.jq_liste_page_prec',
			selectorPageCourante: '.jq_liste_page_courante',
			selectorPageSuiv: '.jq_liste_page_suiv',
			selectorPagePrem: '.jq_liste_page_prem',
			selectorPageDer: '.jq_liste_page_der',
			selectorInputText: '.jq_liste_input_text',
			selectorInputSelect: '.jq_liste_input_select',
			selectorInputCheckbox: '.jq_liste_input_checkbox',
			selectorInputFile: '.jq_liste_input_file',
			selectorInputImage: '.jq_liste_input_image',
			selectorInputListe: '.jq_liste_input_liste',
			selectorInputListeDouble: '.jq_liste_input_listedb',
			selectorInputColor: '.jq_liste_color',
			selectorVisualiseur: '.jq_visualiseur',
			classeStatique: 'jq_liste_statique',
			fonctionMenuPop: 'menuPop',
			fonctionEtageGo: 'etageGo',
			cadreEtage: 'etage',
			typeChampConsultation: 'consult',
			typeChampModification: 'modif',
			obligatoire: false
		},

		init = function(jqElem, options)
		{
			jqElem.addClass('jq_input_form');
			jqElem.data('listePage', 1);
			jqElem.data('listePageCourante', 1);

			jqElem.data('listeOffsetPadding', calculerOffsetPaddingListeParente(jqElem));

			/*if (options.obligatoire == true && jqElem.hasClass('jq_input_form_oblig') == false)
				jqElem.addClass('jq_input_form_oblig');*/
			if (jqElem.hasClass('jq_liste') == false)
				jqElem.addClass('jq_liste');

			var jqType = jqElem.find(options.selectorType + ':first');
			var jqTypeSynchro = jqElem.find(options.selectorTypeSynchro + ':first');
			var jqNumero = jqElem.find(options.selectorNumero + ':first');
			var jqNiveau = jqElem.find(options.selectorNiveau + ':first');
			jqElem.data('listeType', $.trim(jqType.text()));
			jqElem.data('listeTypeSynchro', $.trim(jqTypeSynchro.text()));
			jqElem.data('listeNumero', $.trim(jqNumero.text()));
			jqElem.data('listeNiveau', parseInt($.trim(jqNiveau.text())));
			jqType.remove();
			jqTypeSynchro.remove();
			jqNumero.remove();
			jqNiveau.remove();

			if (jqElem.hasClass(options.classeSortable) == true)
			{
			   	var jqNbElemParPage = jqElem.find(options.selectorNbElemParPage + ':first');
				jqElem.data('listeNbElemParPage', $.trim(jqNbElemParPage.text()));
				jqNbElemParPage.remove();

				var jqSortFoncInIn = jqElem.find(options.selectorSortableFoncInIn + ':first');
				jqElem.data('listeSortFoncInIn', $.trim(jqSortFoncInIn.text()));
				jqSortFoncInIn.remove();

				var jqSortFoncInOut = jqElem.find(options.selectorSortableFoncInOut + ':first');
				jqElem.data('listeSortFoncInOut', $.trim(jqSortFoncInOut.text()));
				jqSortFoncInOut.remove();

				var jqSortFoncOutIn = jqElem.find(options.selectorSortableFoncOutIn + ':first');
				jqElem.data('listeSortFoncOutIn', $.trim(jqSortFoncOutIn.text()));
				jqSortFoncOutIn.remove();

				jqElem.find(options.selectorListe + ':first').data('listeSortableOn', 1).sortable(
				{
				   	forcePlaceholderSize: true,
				   	items: options.selectorElem,
				   	connectWith: '.' + jqElem.data('listeType'),
					receive: function(e, ui)
					{
					   	resetOrdre(jqElem, options);
					   	var fonction = jqElem.data('listeSortFoncOutIn');
					   	var page = jqElem.data('listePage');
					   	var offset = 0;
					   	if (page > 1)
					   		offset = 1;
						if (fonction != '')
						{
							var param = ui.item.data('listeSortParamOutIn');
							jqElem.data('donnees', param + ((ui.item.data('listeElemOrdre') + ((page - 1) * jqElem.data('listeNbElemParPage'))) - offset));
							eval(fonction + '.call(jqElem)');
						}
						jqElem.sortable('refresh');
					},
					update: function(e, ui)
					{
					   	if (!ui.sender && $(this).data('listeSortableOn') == 1)
					   	{
						   	resetOrdre(jqElem, options);
						   	var fonction = jqElem.data('listeSortFoncInIn');
						   	var page = jqElem.data('listePage');
						   	var offset = 0;
						   	if (page > 1)
						   		offset = 1;
							if (fonction != '')
							{//alert(offset);alert(page);
							//alert(jqElem.data('listeNbElemParPage'));
							//alert(((ui.item.data('listeElemOrdre') + ((page - 1) * jqElem.data('listeNbElemParPage'))) - offset));
							   	var param = ui.item.data('listeSortParamInIn');
								jqElem.data('donnees', param + ((ui.item.data('listeElemOrdre') + ((page - 1) * jqElem.data('listeNbElemParPage'))) - offset));
								eval(fonction + '.call(jqElem)');
							}
						}
					},
					remove: function(e, ui)
					{
					   	resetOrdre(jqElem, options);
					   	var fonction = jqElem.data('listeSortFoncInOut');
					   	var page = jqElem.data('listePage');
					   	var offset = 0;
					   	if (page > 1)
					   		offset = 1;
						if (fonction != '')
						{
							var param = ui.item.data('listeSortParamInOut');
							jqElem.data('donnees', param + ((ui.item.data('listeElemOrdre') + ((page - 1) * jqElem.data('listeNbElemParPage'))) - offset));
							eval(fonction + '.call(jqElem)');
						}
						jqElem.sortable('refresh');
					},
					over: function()
					{
					   	$(this).data('listeSortableOn', 1);
					   	jqElem.trigger('redimensionnerChampsListe');
					},
					out: function()
					{
					   	$(this).data('listeSortableOn', 0);
					},
					stop: function(e, ui)
					{
					   	ui.item.css('top', '0').css('left', '0');
					}
				});
			}

			var jqPageChangeFonc = jqElem.find(options.selectorPageChangeFonc + ':first');
			var jqPageChangeParam = jqElem.find(options.selectorPageChangeParam + ':first');
			jqElem.data('listePageChangeFonc', $.trim(jqPageChangeFonc.text()));
			jqElem.data('listePageChangeParam', $.trim(jqPageChangeParam.text()));
			jqPageChangeFonc.remove();
			jqPageChangeParam.remove();

			jqElem.bind('listeChangePage', function()
			{
			   	var page = jqElem.data('listePage');
			   	if (jqElem.data('listePageCourante') !== page)
				{
				   	var pageChangeFonc = jqElem.data('listePageChangeFonc');
					var pageChangeParam = jqElem.data('listePageChangeParam') + '=' + page;
					jqElem.data('listePageCourante', page);
					jqElem.data('donnees', pageChangeParam);
					eval(pageChangeFonc + '.call(jqElem)');
				}
			});
		},

		initElementModele = function(jqElem, options, sousListe)
		{
		   	jqElem.css('visibility', 'hidden').height(0).show();
		   	jqElem.data('listeOffsetPaddingElem', calculerOffsetPaddingElemListe(jqElem));

		   	jqElem.find(options.selectorElemChamp).each(function()
			{
			   	$(this).find(options.selectorElemChampNom)/* + ':first')*/.hide();
			   	$(this).find(options.selectorElemChampType)/* + ':first')*/.hide();
			});

			jqElem.find(options.selectorElemEtage).each(function()
			{
			   	$(this).find(options.selectorElemEtageChargeFonc)/* + ':first')*/.hide();
			   	$(this).find(options.selectorElemEtageChargeParam)/* + ':first')*/.hide();
			});

			if (jqElem.hasClass('jq_liste_elementmodele') == false)
				jqElem.addClass('jq_liste_elementmodele');

			jqElem.find(options.selectorElemMenu).hide();

   	   	   	/*if (sousListe !== true)
			{
				//jqElem.css('min-width', jqElem.width());
				//jqElem.css('max-width', jqElem.width());

				var jqChamps = jqElem.find(options.selectorElemChamp);
				jqChamps.each(function()
				{
				   	//if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro)
					//{
					   	//$(this).data('listeOffsetPaddingChamp', calculerOffsetPaddingChampElem($(this)));

					   	/*var width = $(this).parent().width();//$(this).outerWidth(true);
					   	$(this).css('position', 'relative');
						$(this).css('min-width', width);
						$(this).css('max-width', width);
						var newWidth = $(this).parent().width();//$(this).outerWidth(true);
						if (width !== newWidth)
						{
						   	$(this).css('max-width', width - (width - newWidth));
						   	$(this).css('min-width', width - (width - newWidth));
						}*/
					//}
				//});
				/*jqChamps.each(function()
				{
					$(this).css('min-width', $(this).width());
					$(this).css('max-width', $(this).width());
				});*/
			//}

			jqElem.hide();
		},

		initElementCreation = function(jqElem, jqListe, jqElemModele, options)
		{
			if (jqElem.hasClass('jq_liste_elementcreat') == false)
				jqElem.addClass('jq_liste_elementcreat');

			//jqElem.css('visibility', 'visible').height('').show(); //pour debug;
			jqElem./*css('visibility', 'hidden').height(0).*/show();
			jqElem.css('position', 'relative');
			jqElem.find(options.selectorElemMenu).hide();

			jqElem.find('input').hide();
   	   	 	jqElem.css('min-width', jqElemModele.css('min-width'));
			jqElem.css('max-width', jqElemModele.css('max-width'));

			var jqChamps = jqElem.find(options.selectorElemChamp);
			jqChamps.find('td:first').children().hide();
			var listeTypeSynchro = jqListe.data('listeTypeSynchro');
			jqChamps.each(function()
			{
			   	if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro)
				{
				   	var width = $(this).parent().width();//$(this).outerWidth(true);
				   	$(this).css('position', 'relative');
					$(this).css('min-width', width);
					$(this).css('max-width', width);
					var newWidth = $(this).parent().width();//$(this).outerWidth(true);
					if (width !== newWidth)
					{
					   	$(this).css('max-width', width - (width - newWidth));
					   	$(this).css('min-width', width - (width - newWidth));
					}
				}
			});
			jqChamps.width('100%').find('td:first').children().show();
			jqElem.find('input').show();

			jqElem.data('listeElemMenuElemPop', 0);
			jqElem.data('listeElemRand', parseInt(Math.random() * 100000));

			var listeTypeSynchro = jqListe.data('listeTypeSynchro');
			jqElem.find(options.selectorElemEtage).each(function()
			{
			   	if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro && $(this).data('listeElemEtageElemId') == null)
				{
					var jqNumEtage = $(this).children(options.selectorElemEtageNum + ':first');
					$(this).attr('id', jqElem.data('listeElemRand')+'__'+$.trim(jqNumEtage.text()));
					jqNumEtage.remove();

					$(this).bind('redimensionnerChampsListe', function()
					{
					   	var etageCache = false;
					   	if ($(this).css('display') == 'none')
						{
					   		$(this).css('visibility', 'hidden').show();
					   		etageCache = true;
					   	}
					   	var jqChampsEtage = $(this).find(options.selectorElemChamp);
					   	jqChampsEtage.height('');
					   	jqChampsEtage.find('table:first').height('');
						jqChampsEtage.each(function()
					   	{
							$(this).fill().addClass('jq_fill');
						   	$(this).find('table:first').fill().addClass('jq_fill');
						});
						if (etageCache === true)
							$(this).hide().css('visibility', 'visible');
					});

					if ($(this).children().hasClass(options.classeElemPliant) == true)
					{
					   	var jqTitre = $(this).find('td:first').children(options.selectorElemTitre + ':first');
						var jqContenu = $(this).find('td:first').children(options.selectorElemContenu + ':first');
						var jqIndic = jqTitre.find(options.selectorElemIndic + ':first');
						jqTitre.css('overflow', 'visible').disableSelection().css('cursor', 'pointer');
						jqIndic.css('font-family', 'Courier New').css('text-align', 'center').find('td:first').css('text-align', 'center');
						jqContenu.height('');

						if ($.trim(jqIndic.find('td:first').text()) == '+')
						{
							jqTitre.data('listeElemPliantPlie', 1);
							jqContenu.hide();
						}
						else
						{
							jqTitre.data('listeElemPliantPlie', 0);
							jqContenu.show();
						}

						jqTitre.mousedown(function(e)
						{
						   	$(this).data('listeElemPliantClique', 1);
						   	$(this).one('mouseup', function()
							{
							   	$(this).data('listeElemPliantClique', 0);
							});
						});

						jqTitre.mouseup(function(e)
						{
						   	if ($(this).data('listeElemPliantClique') == 1)
							{
							   	var jqContenu = $(this).siblings(options.selectorElemContenu + ':first');
							   	var jqIndic = $(this).find(options.selectorElemIndic + ':first');
							   	if ($(this).data('listeElemPliantPlie') != 1)
								{
							   		jqContenu.slideUp(500, function() {jqElem.trigger('redimensionnerChampsListe');});
							   		$(this).data('listeElemPliantPlie', 1);
							   		jqIndic.find('td:first').text('+');
							  	}
							   	else
							   	{
							   	   	jqContenu.slideDown(500, function() {jqElem.trigger('redimensionnerChampsListe');});
							   	   	$(this).data('listeElemPliantPlie', 0);
							   	   	jqIndic.find('td:first').text('-');
							   	   	chargerContenu(jqElem);
							   	}
							}

							if ($(this).closest('.jq_visualiseur_vue').length == 0)
						   	   	e.stopPropagation();
						});

						if (jqElem.data('listeElemContenuChargeFonc') == undefined)
						{
							var jqChargeFonc = $(this).find(options.selectorElemContenuChargeFonc + ':first');
							var jqChargeParam = $(this).find(options.selectorElemContenuChargeParam + ':first');
							jqElem.data('listeElemContenuChargeFonc', $.trim(jqChargeFonc.text()));
							jqElem.data('listeElemContenuChargeParam', $.trim(jqChargeParam.text()));
							jqChargeFonc.remove();
							jqChargeParam.remove();
							if (jqElem.data('listeElemContenuChargeFonc') == '')
								jqElem.data('listeElemContenuCharge', 1);
							else
							   	jqElem.data('listeElemContenuCharge', 0);
						}
					}
				}
			});

			jqElem.find(options.selectorInputColor).color();
			jqElem.find(options.selectorInputFile).inputFile();
			jqElem.find(options.selectorInputImage).inputImage();
			jqElem.find(options.selectorInputText).inputText();
			jqElem.find(options.selectorInputSelect).inputSelect().inputSelectActiverRechargement();
			jqElem.find(options.selectorInputCheckbox).inputCheckbox();
			jqElem.find(options.selectorInputListe).inputListe();
			jqElem.find(options.selectorInputListeDouble).inputListeDouble();

			jqElem.find(options.selectorElemMenus + ':last').width(0).show().find(options.selectorElemMenu).each(function()
			{
				var jqMenu = $(this);
				jqMenu.css('position', 'absolute');
				jqMenu.css('top', '0');
				jqMenu.css('z-index', 2);

				$(this).find(options.selectorElemMenuElem).each(function()
				{
				   	var jqMenuElem = $(this);
				   	var jqCadre = $(this).find(options.selectorElementMenuElemBoutonCadre + ':first');
					var jqFonction = $(this).find(options.selectorElementMenuElemBoutonFonc + ':first');
					var jqParam = $(this).find(options.selectorElementMenuElemBoutonParam + ':first');

					if ($.trim(jqFonction.text()) == options.fonctionMenuPop)
					{
					   	var numMenu = $.trim(jqParam.text());
						jqMenuElem.click(function(e)
						{
						   	if ($(this).data('jqInputButtonAjax') != 1 || $(this).data('jqInputButtonActif') == 1)
						   	   	$(this).trigger('menuPop', {numMenu: numMenu});
						   	e.stopPropagation();
						});
						jqFonction.text('');
						jqParam.text('');
					}

				   	var cadre = $.trim(jqCadre.text());
					var posCadreEtage = cadre.indexOf(options.cadreEtage);
					if (posCadreEtage >= 0)
					{
					   	var longCadreEtage = options.cadreEtage.length;
					   	cadre = cadre.substring(posCadreEtage + longCadreEtage);
						var numEtage = parseInt(cadre);
						jqCadre.text(jqElem.data('listeElemRand')+'__'+numEtage);
					}

					var optionsBouton =
					{
						selectorCadre: options.selectorElementMenuElemBoutonCadre,
						selectorFonction: options.selectorElementMenuElemBoutonFonc,
						selectorParam: options.selectorElementMenuElemBoutonParam,
						selectorBouton: options.selectorElemMenuElemBouton,
						classeBoutonAjax: options.classeElementMenuElemBoutonAjax,
						classeBoutonReset: options.classeElementMenuElemBoutonReset
					};

					jqMenuElem.inputButton(optionsBouton)/*.inputButtonInitialiser()*/.inputButtonDissocierSousForm().inputButtonInitialiserEtat();
					jqMenuElem.width('100%');
					jqMenuElem.children().width('100%');
					jqMenuElem.Clignoter({declenchement: 'mouseenter'}, 30 + jqListe.data('listeNiveau'));
				});

				jqMenu.hide();
			});

			jqChamps.fill().addClass('jq_fill');
			jqChamps.find('table:first').fill().addClass('jq_fill');

			jqElem.mouseenter(function()
			{
			   	popMenu(jqElem, $(this).data('listeElemMenuElemPop'), options, true);
			});

			jqElem.mouseleave(function()
			{
			   	$(this).find(options.selectorElemMenu).stop(true, true).animate({width: '0px'}, 300, function() {$(this).hide()});
			});

			jqElem.bind('menuPop', function(e, data)
			{
			   	$(this).data('listeElemMenuElemPop', data.numMenu);
			   	popMenu(jqElem, data.numMenu, options, true);
			});

			jqElem.mouseenter(function()
			{
			   	$(this).Clignoter({}, 20 + jqListe.data('listeNiveau'), true);
			});

			jqElem.mouseleave(function()
			{
			   	$(this).Clignoter({}, 20 + jqListe.data('listeNiveau'), false);
			});
			//jqElem.Clignoter({declenchement: 'mouseenter'}, 20 + jqListe.data('listeNiveau'));
			jqElem.css('visibility', 'visible').height('');
		},

		initElement = function(jqElem, jqListe, jqElemModele, options, sousListe)
		{
			var jqNouvelElem = jqElemModele.clone(true);
			jqNouvelElem.find(options.selectorElemChamp).each(function()
			{
			   	var jqNom = $(this).find(options.selectorElemChampNom + ':first');
			   	var jqType = $(this).find(options.selectorElemChampType + ':first');
				$(this).data('listeElemChampNom', $.trim(jqNom.text()));
				$(this).data('listeElemChampType', $.trim(jqType.text()));
				jqNom.remove();
				jqType.remove();
			});
			jqNouvelElem.removeClass('jq_liste_elementmodele');
			jqNouvelElem.addClass('jq_liste_elem');
			jqNouvelElem.css('position', 'relative');

			jqNouvelElem.data('listeElemId', $.trim(jqElem.find(options.selectorElementId + ':first').text()));
			jqNouvelElem.data('listeElemOrdre', parseInt($.trim(jqElem.find(options.selectorElementOrdre + ':first').text())));
			var listeElemFonction = $.trim(jqElem.find(options.selectorElementFonction + ':first').text());
			jqNouvelElem.data('listeElemFonction', listeElemFonction);
			if (listeElemFonction !== '')
				jqNouvelElem.css('cursor', 'pointer');
			jqNouvelElem.data('listeElemParam', $.trim(jqElem.find(options.selectorElementParam + ':first').text()));
			jqNouvelElem.data('listeElemMenuElemPop', 0);
			jqNouvelElem.data('listeElemRand', parseInt(Math.random() * 100000));

			var jqChamps = jqNouvelElem.find(options.selectorElemChamp);
			var listeTypeSynchro = jqListe.data('listeTypeSynchro');
			var jqElemChamps = jqElem.find(options.selectorElementChamps + ':first').find(options.selectorElementChamp);
			jqElemChamps.each(function()
			{
			   	var jqElemChamp = $(this);
			   	var valeur = $.trim($(this).find(options.selectorElementChampValeur + ':first').html());
				var nom = $.trim($(this).find(options.selectorElementChampNom + ':first').text());
				var type = $.trim($(this).find(options.selectorElementChampType + ':first').text());

				jqChamps.each(function()
				{
				   	$(this).parent().css('position', 'relative');
					$(this).bind('changeEtatInput', function()
					{
						$(this).data('listeElemChampModifie', 1);
					});

				   	if ($(this).data('listeElemChampNom') == nom && $(this).data('listeElemChampType') == type)
				   	{
				   	   	$(this).find('td:first').append(jqElemChamp.find(options.selectorElementChampValeur + ':first').contents());//.append(jqElemChamp.find(options.selectorElementChampValeur + ':first'));//.html(valeur);
				   	   	if ($(this).data('listeElemChampType') === options.typeChampConsultation)
				   	   	{
				   	   	   	var jqImage = $(this).find('img');
				   	   	   	jqImage.width(0);
				   	   	   	if (jqImage.attr('src') == '')
				   	   	   		jqImage.hide();
				   	   	}
				   	}
				});
			});

			placerElement(jqNouvelElem, jqListe, jqElemModele, options);

			//jqNouvelElem.find('.jq_clignotant').ClignoterReinitialiser();
			//jqNouvelElem.find('.jq_clignotant_fininit').removeClass('jq_clignotant_fininit');
			//jqNouvelElem.find('.jq_clignotant_debinit').removeClass('jq_clignotant_debinit');

			jqNouvelElem.css('visibility', 'hidden').height(0).show();
			if (sousListe !== true)
			   	jqNouvelElem.find(options.selectorInputColor).color();
			jqNouvelElem.find(options.selectorInputFile).inputFile();
			jqNouvelElem.find(options.selectorInputImage).inputImage();
			jqNouvelElem.find(options.selectorInputText).inputText();
			jqNouvelElem.find(options.selectorInputSelect).inputSelect();
			jqNouvelElem.find(options.selectorInputCheckbox).inputCheckbox();
			jqNouvelElem.find(options.selectorInputListe).inputListe();
			jqNouvelElem.find(options.selectorInputListeDouble).inputListeDouble();
			jqNouvelElem.find(options.selectorVisualiseur).visualiseur();

			jqNouvelElem.find(options.selectorElemEtage).each(function()
			{
			   	if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro && $(this).data('listeElemEtageElemId') == null)
				{
					var jqNumEtage = $(this).children(options.selectorElemEtageNum + ':first');
					$(this).attr('id', jqNouvelElem.data('listeElemId')+'__'+jqNouvelElem.data('listeElemRand')+'__'+$.trim(jqNumEtage.text()));
					jqNumEtage.remove();

					var jqChargeFonc = $(this).children(options.selectorElemEtageChargeFonc + ':first');
					var jqChargeParam = $(this).children(options.selectorElemEtageChargeParam + ':first');
					$(this).data('listeElemEtageChargeFonc', $.trim(jqChargeFonc.text()));
					$(this).data('listeElemEtageChargeParam', $.trim(jqChargeParam.text()));
					$(this).data('listeElemEtageElemId', jqNouvelElem.data('listeElemId'));
					jqChargeFonc.remove();
					jqChargeParam.remove();

					if ($(this).data('listeElemEtageChargeFonc') == '')
						$(this).data('listeElemEtageCharge', 1);

					$(this).bind('redimensionnerChampsListe', function()
					{
					   	var etageCache = false;
					   	if ($(this).css('display') == 'none')
						{
					   		$(this).css('visibility', 'hidden').show();
					   		etageCache = true;
					   	}
					   	var jqChampsEtage = $(this).find(options.selectorElemChamp);
					   	jqChampsEtage.height('');
					   	jqChampsEtage.find('table:first').height('');
						jqChampsEtage.each(function()
					   	{
							$(this).fill().addClass('jq_fill');
						   	$(this).find('table:first').fill().addClass('jq_fill');
						});
						if (etageCache === true)
							$(this).hide().css('visibility', 'visible');
					});

					if ($(this).children().hasClass(options.classeElemPliant) == true)
					{
					   	var jqTitre = $(this).find('td:first').children(options.selectorElemTitre + ':first');
						var jqContenu = $(this).find('td:first').children(options.selectorElemContenu + ':first');
						var jqIndic = jqTitre.find(options.selectorElemIndic + ':first');
						jqTitre.css('overflow', 'visible').disableSelection().css('cursor', 'pointer');
						jqIndic.css('font-family', 'Courier New').css('text-align', 'center').find('td:first').css('text-align', 'center');
						jqContenu.height('');

						if ($.trim(jqIndic.find('td:first').text()) == '+')
						{
							jqTitre.data('listeElemPliantPlie', 1);
							jqContenu.hide();
						}
						else
						{
							jqTitre.data('listeElemPliantPlie', 0);
							jqContenu.show();
						}

						jqTitre.mousedown(function(e)
						{
						   	$(this).data('listeElemPliantClique', 1);
						   	$(this).one('mouseup', function()
							{
							   	$(this).data('listeElemPliantClique', 0);
							});
						});

						jqTitre.mouseup(function(e)
						{
						   	if ($(this).data('listeElemPliantClique') == 1)
							{
							   	var jqContenu = $(this).siblings(options.selectorElemContenu + ':first');
							   	var jqIndic = $(this).find(options.selectorElemIndic + ':first');
							   	if ($(this).data('listeElemPliantPlie') != 1)
								{
							   		jqContenu.slideUp(500, function() {jqNouvelElem.trigger('redimensionnerChampsListe');});
							   		$(this).data('listeElemPliantPlie', 1);
							   		jqIndic.find('td:first').text('+');
							  	}
							   	else
							   	{
							   	   	jqContenu.slideDown(500, function() {jqNouvelElem.trigger('redimensionnerChampsListe');});
							   	   	$(this).data('listeElemPliantPlie', 0);
							   	   	jqIndic.find('td:first').text('-');
							   	   	chargerContenu(jqNouvelElem);
							   	}
							}

							if ($(this).closest('.jq_visualiseur_vue').length == 0)
						   	   	e.stopPropagation();
						});

						if (jqNouvelElem.data('listeElemContenuChargeFonc') == undefined)
						{
							var jqChargeFonc = $(this).find(options.selectorElemContenuChargeFonc + ':first');
							var jqChargeParam = $(this).find(options.selectorElemContenuChargeParam + ':first');
							jqNouvelElem.data('listeElemContenuChargeFonc', $.trim(jqChargeFonc.text()));
							jqNouvelElem.data('listeElemContenuChargeParam', $.trim(jqChargeParam.text()));
							jqChargeFonc.remove();
							jqChargeParam.remove();
							if (jqNouvelElem.data('listeElemContenuChargeFonc') == '')
								jqNouvelElem.data('listeElemContenuCharge', 1);
							else
							   	jqNouvelElem.data('listeElemContenuCharge', 0);
						}
					}
				}
			});

			jqElemChamps.each(function()
			{
			   	var jqElemChampValeur = $(this).find(options.selectorElementChampValeur + ':first');
			   	var valeur = $.trim(jqElemChampValeur.html());
				var nom = $.trim($(this).find(options.selectorElementChampNom + ':first').text());
				var type = $.trim($(this).find(options.selectorElementChampType + ':first').text());

				jqChamps.each(function()
				{
				   	if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro)
					{
					   	if ($(this).data('listeElemChampType') === options.typeChampConsultation)
					   	{
					   	   	$(this).find('img').each(function()
							{
							   	$(this).width($(this).parent().innerWidth());
					   	   	   	$(this).load(function()
								{
								   	$(this).trigger('redimensionnerChampsListe');
								});
							});
						}

					   	if ($(this).data('listeElemChampNom') == nom && (typeof(nom) == 'string'))
						{
					   		$(this).find('.jq_input_text').each(function()
					   		{
					   		   	$(this).inputTextFixerValeur(valeur);
					   		});

							$(this).find('.jq_input_select').each(function()
					   		{
					   		   	$(this).inputSelectFixerValeur(valeur);
					   		});

					   		$(this).find('.jq_input_image').each(function()
					   		{
							   	jqElemChampValeur.find('img').each(function()
							   	{
							   	   	valeur = $(this).attr('src');
							   	});

					   		   	$(this).inputImageFixerValeur(valeur);
					   		});

					   		if ($(this).data('listeElemChampType') === options.typeChampConsultation)
							{
						   		$(this).find('.jq_input_checkbox').each(function()
						   		{
						   		   	$(this).inputCheckboxSetReadOnly();
						   		});
						   	}
					   	}
					}
				});
			});

			jqChamps.fill().addClass('jq_fill');
			jqChamps.find('table:first').fill().addClass('jq_fill');
			//jqChamps.css('position', 'relative').width('100%').css('min-width', '').css('max-width', '');

			var jqMenuModele = jqElemModele.find(options.selectorElemMenus + ':last').find(options.selectorElemMenu + ':first');
			var jqMenuElemModele = jqMenuModele.find(options.selectorElemMenuElem + ':first');

			jqElem.find(options.selectorElementMenus + ':first').find(options.selectorElementMenu).each(function()
			{
				var jqMenu;
				var jqMenuPrec = jqNouvelElem.find(options.selectorElemMenu + ':last');
				if (jqMenuPrec.data('listeElemMenuInit') == 1)
					jqMenu = jqMenuModele.clone();
				else
					jqMenu = jqMenuPrec;

				jqMenu.data('listeElemMenuInit', 1);
				var premierMenuElem = true;
				jqMenu.find(options.selectorElemMenuElem).each(function()
				{
				   	if (premierMenuElem == true)
				   	{
				   	   	$(this).data('listeElemMenuElemInit', 0);
				   	   	if ($(this).hasClass('jq_input_form') == true)
				   	   		$(this).removeClass('jq_input_form');
				   	   	premierMenuElem = false;
				   	}
				   	else
				   	   	$(this).remove();
				});
				jqMenuPrec.parent().append(jqMenu);
				jqMenu.css('position', 'absolute');
				jqMenu.css('top', '0');
				jqMenu.css('z-index', 2);

				$(this).find(options.selectorElementMenuElem).each(function()
				{
				   	var lib = $.trim($(this).find(options.selectorElementMenuElemLib + ':first').html());
					var jqCadre = $(this).find(options.selectorElementMenuElemBoutonCadre + ':first').clone();
					var jqFonction = $(this).find(options.selectorElementMenuElemBoutonFonc + ':first').clone();
					var jqParam = $(this).find(options.selectorElementMenuElemBoutonParam + ':first').clone();

					var jqMenuElem;
					var jqMenuElemPrec = jqMenu.find(options.selectorElemMenuElem + ':last');
					if (jqMenuElemPrec.data('listeElemMenuElemInit') == 1)
						jqMenuElem = jqMenuElemModele.clone();
					else
					   	jqMenuElem = jqMenuElemPrec;

					jqMenuElemPrec.parent().append(jqMenuElem);
					jqMenuElem.find('.jq_clignotant').andSelf().removeClass('jq_clignotant');
					jqMenuElem.append(jqCadre);
					jqMenuElem.append(jqFonction);
					jqMenuElem.append(jqParam);

					if (jqMenuElem.hasClass('jq_input_form') == true)
				   	   	jqMenuElem.removeClass('jq_input_form');
				   	jqMenuElem.find('.jq_clignotant').andSelf().removeClass('jq_clignotant');

					var fonctions = $.trim(jqFonction.text());
					var params = $.trim(jqParam.text());
					var separateur = new RegExp(";+", 'g');
					var fonctab = fonctions.split(separateur);
					var paramtab = params.split(separateur);
					for (var i = 0; i < fonctab.length; i++)
					{
					  	switch (fonctab[i])
					  	{
					  	   	case options.fonctionMenuPop:
							   	jqMenuElem.data('listeElemMenuElemNumMenuPop', paramtab[i]);
							   	jqMenuElem.mousedown(function(e)
								{
								   	$(this).data('listeMenuElemClique', 1);
								   	$(this).one('mouseup', function()
									{
									   	$(this).data('listeMenuElemClique', 0);
									});
								});
								jqMenuElem.mouseup(function(e)
								{
								   	if ($(this).data('listeMenuElemClique') == 1 && $(this).data('jqInputButtonAjax') != 1 || $(this).data('jqInputButtonActif') == 1)
								   	   	$(this).trigger('menuPop', {numMenu: $(this).data('listeElemMenuElemNumMenuPop')});
								   	e.stopPropagation();
								});
								fonctions = suppElementDansChaine(fonctions, i, ';');
								params = suppElementDansChaine(params, i, ';');
								break;
							case options.fonctionEtageGo:
								jqMenuElem.data('listeElemMenuElemNumEtageGo', paramtab[i]);
								jqMenuElem.mousedown(function(e)
								{
								   	$(this).data('listeMenuElemClique', 1);
								   	$(this).one('mouseup', function()
									{
									   	$(this).data('listeMenuElemClique', 0);
									});
								});
								jqMenuElem.mouseup(function(e)
								{
								   	if ($(this).data('listeMenuElemClique') == 1 && $(this).data('jqInputButtonAjax') != 1 || $(this).data('jqInputButtonActif') == 1)
								   	   	$(this).trigger('etageGo', {numEtage: $(this).data('listeElemMenuElemNumEtageGo')});
								   	e.stopPropagation();
								});
								fonctions = suppElementDansChaine(fonctions, i, ';');
								params = suppElementDansChaine(params, i, ';');
								break;
						}
					}
					fonctions = fonctions.replace(separateur, '');
					params = params.replace(separateur, '');
					jqFonction.text(fonctions);
					jqParam.text(params);

					var cadre = $.trim(jqCadre.text());
					var posCadreEtage = cadre.indexOf(options.cadreEtage);
					if (posCadreEtage >= 0)
					{
					   	var longCadreEtage = options.cadreEtage.length;
					   	cadre = cadre.substring(posCadreEtage + longCadreEtage);
						var numEtage = parseInt(cadre);
						jqCadre.text(jqNouvelElem.data('listeElemId')+'__'+jqNouvelElem.data('listeElemRand')+'__'+numEtage);
					}

					if ($(this).hasClass(options.classeElementMenuElemBoutonAjax) === true)
					   	jqMenuElem.addClass(options.classeElementMenuElemBoutonAjax);
					if ($(this).hasClass(options.classeElementMenuElemBoutonReset) === true)
					   	jqMenuElem.addClass(options.classeElementMenuElemBoutonReset);

					jqMenuElem.data('listeElemMenuElemInit', 1);
					jqMenuElem.find(options.selectorElemMenuElemBouton + ':first').find('td').html(lib);

					var optionsBouton =
					{
						selectorCadre: options.selectorElementMenuElemBoutonCadre,
						selectorFonction: options.selectorElementMenuElemBoutonFonc,
						selectorParam: options.selectorElementMenuElemBoutonParam,
						selectorBouton: options.selectorElemMenuElemBouton,
						classeBoutonAjax: options.classeElementMenuElemBoutonAjax,
						classeBoutonReset: options.classeElementMenuElemBoutonReset
					};

					jqMenuElem.inputButton(optionsBouton)/*.inputButtonInitialiser()*/.inputButtonDissocierSousForm().inputButtonInitialiserEtat();
					jqMenuElem.width('100%');
					jqMenuElem.children().width('100%');

					jqCadre.remove();
					jqFonction.remove();
					jqParam.remove();
				});

				jqMenu.hide();
			});

			jqNouvelElem.find(options.selectorElemMenus + ':first').width(0).show();

			jqNouvelElem.mousedown(function(e)
			{
				var position = {x: e.pageX, y: e.pageY, options: options, elem: jqNouvelElem};
				$(document).bind('mouseup', position, listeElementMouseUp);
				if (jqListe.hasClass(options.classeSortable) == true)
				   	$(this).css('cursor', 'move');
			});

			jqNouvelElem.mouseup(function()
			{
			   	if (jqListe.hasClass(options.classeSortable) == true)
				   	$(this).css('cursor', 'pointer');
			});

			jqNouvelElem.mouseenter(function()
			{
			   	popMenu(jqNouvelElem, $(this).data('listeElemMenuElemPop'), options);
			});

			jqNouvelElem.mouseleave(function()
			{
			   	var num = 0;
			   	var numMenu = $(this).data('listeElemMenuElemPop');
			   	$(this).find(options.selectorElemMenus + ':first').find(options.selectorElemMenu).each(function()
				{
				   	if (num == numMenu)
				   	{
				   	   	var duree = ($(this).width()/200)*300;
			   		   	$(this).stop(true, false).animate({width: '0px'}, duree, function() {$(this).hide()});
			   		}
			   		num++;
			   	});
			});

			jqNouvelElem.bind('menuPop', function(e, data)
			{
			   	$(this).data('listeElemMenuElemPop', data.numMenu);
			   	popMenu(jqNouvelElem, data.numMenu, options);
			   	e.stopPropagation();
			});

			jqNouvelElem.bind('etageGo', function(e, data)
			{
			   	allerEtage(jqNouvelElem, data.numEtage, options);
			   	e.stopPropagation();
			});

			if (jqListe.hasClass(options.classeSortable) == true)
			{
				jqNouvelElem.css('cursor', 'pointer');
				jqNouvelElem.disableSelection();

				var jqSortParamInIn = jqElem.find(options.selectorSortableParamInIn + ':first');
				jqNouvelElem.data('listeSortParamInIn', $.trim(jqSortParamInIn.text()));

				var jqSortParamInOut = jqElem.find(options.selectorSortableParamInOut + ':first');
				jqNouvelElem.data('listeSortParamInOut', $.trim(jqSortParamInOut.text()));

				var jqSortParamOutIn = jqElem.find(options.selectorSortableParamOutIn + ':first');
				jqNouvelElem.data('listeSortParamOutIn', $.trim(jqSortParamOutIn.text()));
			}

			jqNouvelElem.mouseenter(function()
			{
			   	$(this).Clignoter({}, 20 + jqListe.data('listeNiveau'), true);
			});

			jqNouvelElem.mouseleave(function()
			{
			   	$(this).Clignoter({}, 20 + jqListe.data('listeNiveau'), false);
			});
			//jqNouvelElem.Clignoter({declenchement: 'mouseenter'}, 20 + jqListe.data('listeNiveau'));
			allerEtage(jqNouvelElem, 1, options, true);
			jqElem.remove();
			jqNouvelElem.css('visibility', 'visible').height('');

			return jqNouvelElem;
		},

		initElementStatique = function(jqElem, jqListe, options, sousListe)
		{
			var jqNouvelElem = jqElem;
			jqNouvelElem.addClass('jq_liste_elem');
			jqNouvelElem.css('position', 'relative');

			jqNouvelElem.data('listeElemId', $.trim(jqElem.find(options.selectorElementId + ':first').text()));
			jqNouvelElem.data('listeElemOrdre', parseInt($.trim(jqElem.find(options.selectorElementOrdre + ':first').text())));
			var listeElemFonction = $.trim(jqElem.find(options.selectorElementFonction + ':first').text());
			jqNouvelElem.data('listeElemFonction', listeElemFonction);
			if (listeElemFonction !== '')
				jqNouvelElem.css('cursor', 'pointer');
			jqNouvelElem.data('listeElemParam', $.trim(jqElem.find(options.selectorElementParam + ':first').text()));
			jqNouvelElem.data('listeElemMenuElemPop', 0);
			jqNouvelElem.data('listeElemRand', parseInt(Math.random() * 100000));

			var listeTypeSynchro = jqListe.data('listeTypeSynchro');

			jqNouvelElem.css('visibility', 'hidden').height(0).show();
			if (sousListe !== true)
			   	jqNouvelElem.find(options.selectorInputColor).color();
			jqNouvelElem.find(options.selectorInputText).inputText();
			jqNouvelElem.find(options.selectorInputSelect).inputSelect();
			jqNouvelElem.find(options.selectorInputCheckbox).inputCheckbox();
			jqNouvelElem.find(options.selectorInputFile).inputFile();
			jqNouvelElem.find(options.selectorInputImage).inputImage();
			jqNouvelElem.find(options.selectorInputListe).inputListe();
			jqNouvelElem.find(options.selectorInputListeDouble).inputListeDouble();
			jqNouvelElem.find(options.selectorVisualiseur).visualiseur();

			jqNouvelElem.find(options.selectorElemEtage).each(function()
			{
			   	if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro && $(this).data('listeElemEtageElemId') == null)
				{
					var jqNumEtage = $(this).children(options.selectorElemEtageNum + ':first');
					$(this).attr('id', jqNouvelElem.data('listeElemId')+'__'+jqNouvelElem.data('listeElemRand')+'__'+$.trim(jqNumEtage.text()));
					jqNumEtage.remove();

					var jqChargeFonc = $(this).children(options.selectorElemEtageChargeFonc + ':first');
					var jqChargeParam = $(this).children(options.selectorElemEtageChargeParam + ':first');
					$(this).data('listeElemEtageChargeFonc', $.trim(jqChargeFonc.text()));
					$(this).data('listeElemEtageChargeParam', $.trim(jqChargeParam.text()));
					$(this).data('listeElemEtageElemId', jqNouvelElem.data('listeElemId'));
					jqChargeFonc.remove();
					jqChargeParam.remove();

					if ($(this).data('listeElemEtageChargeFonc') == '')
						$(this).data('listeElemEtageCharge', 1);

					$(this).bind('redimensionnerChampsListe', function()
					{
					   	var etageCache = false;
					   	if ($(this).css('display') == 'none')
						{
					   		$(this).css('visibility', 'hidden').show();
					   		etageCache = true;
					   	}
					   	var jqChampsEtage = $(this).find(options.selectorElemChamp);
					   	jqChampsEtage.height('');
					   	jqChampsEtage.find('table:first').height('');
						jqChampsEtage.each(function()
					   	{
							$(this).fill().addClass('jq_fill');
						   	$(this).find('table:first').fill().addClass('jq_fill');
						});
						if (etageCache === true)
							$(this).hide().css('visibility', 'visible');
					});

					if ($(this).children().hasClass(options.classeElemPliant) == true)
					{
					   	var jqTitre = $(this).find('td:first').children(options.selectorElemTitre + ':first');
						var jqContenu = $(this).find('td:first').children(options.selectorElemContenu + ':first');
						var jqIndic = jqTitre.find(options.selectorElemIndic + ':first');
						jqTitre.css('overflow', 'visible').disableSelection().css('cursor', 'pointer');
						jqIndic.css('font-family', 'Courier New').css('text-align', 'center').find('td:first').css('text-align', 'center');
						jqContenu.height('');

						if ($.trim(jqIndic.find('td:first').text()) == '+')
						{
							jqTitre.data('listeElemPliantPlie', 1);
							jqContenu.hide();
						}
						else
						{
							jqTitre.data('listeElemPliantPlie', 0);
							jqContenu.show();
						}
						jqTitre.click(function(e)
						{
						   	var jqContenu = $(this).siblings(options.selectorElemContenu + ':first');
						   	var jqIndic = $(this).find(options.selectorElemIndic + ':first');
						   	if ($(this).data('listeElemPliantPlie') != 1)
							{
						   		jqContenu.slideUp(500);
						   		$(this).data('listeElemPliantPlie', 1);
						   		jqIndic.find('td:first').text('+');
						  	}
						   	else
						   	{
						   	   	jqContenu.slideDown(500);
						   	   	$(this).data('listeElemPliantPlie', 0);
						   	   	jqIndic.find('td:first').text('-');
						   	   	chargerContenu(jqNouvelElem);
						   	}

						   	e.stopPropagation();
						});

						if (jqNouvelElem.data('listeElemContenuChargeFonc') == undefined)
						{
							var jqChargeFonc = $(this).find(options.selectorElemContenuChargeFonc + ':first');
							var jqChargeParam = $(this).find(options.selectorElemContenuChargeParam + ':first');
							jqNouvelElem.data('listeElemContenuChargeFonc', $.trim(jqChargeFonc.text()));
							jqNouvelElem.data('listeElemContenuChargeParam', $.trim(jqChargeParam.text()));
							jqChargeFonc.remove();
							jqChargeParam.remove();
							if (jqNouvelElem.data('listeElemContenuChargeFonc') == '')
								jqNouvelElem.data('listeElemContenuCharge', 1);
							else
							   	jqNouvelElem.data('listeElemContenuCharge', 0);
						}
					}
				}
			});

			jqNouvelElem.find(options.selectorElemMenus + ':first').find(options.selectorElemMenu).each(function()
			{
				var jqMenu = $(this);
				jqMenu.css('position', 'absolute');
				jqMenu.css('top', '0');
				jqMenu.css('z-index', 2);

				$(this).find(options.selectorElemMenuElem).each(function()
				{
				   	var lib = $.trim($(this).find(options.selectorElementMenuElemLib + ':first').html());
					var jqCadre = $(this).find(options.selectorElementMenuElemBoutonCadre + ':first').clone();
					var jqFonction = $(this).find(options.selectorElementMenuElemBoutonFonc + ':first').clone();
					var jqParam = $(this).find(options.selectorElementMenuElemBoutonParam + ':first').clone();

					var jqMenuElem = $(this);
					var fonctions = $.trim(jqFonction.text());
					var params = $.trim(jqParam.text());
					var separateur = new RegExp(";+", 'g');
					var fonctab = fonctions.split(separateur);
					var paramtab = params.split(separateur);
					for (var i = 0; i < fonctab.length; i++)
					{
					  	switch (fonctab[i])
					  	{
					  	   	case options.fonctionMenuPop:
							   	jqMenuElem.data('listeElemMenuElemNumMenuPop', paramtab[i]);
								jqMenuElem.click(function(e)
								{
								   	if ($(this).data('jqInputButtonAjax') != 1 || $(this).data('jqInputButtonActif') == 1)
								   	   	$(this).trigger('menuPop', {numMenu: $(this).data('listeElemMenuElemNumMenuPop')});
								   	e.stopPropagation();
								});
								fonctions = suppElementDansChaine(fonctions, i, ';');
								params = suppElementDansChaine(params, i, ';');
								break;
							case options.fonctionEtageGo:
								jqMenuElem.data('listeElemMenuElemNumEtageGo', paramtab[i]);
								jqMenuElem.click(function(e)
								{
								   	if ($(this).data('jqInputButtonAjax') != 1 || $(this).data('jqInputButtonActif') == 1)
								   	   	$(this).trigger('etageGo', {numEtage: $(this).data('listeElemMenuElemNumEtageGo')});
								   	e.stopPropagation();
								});
								fonctions = suppElementDansChaine(fonctions, i, ';');
								params = suppElementDansChaine(params, i, ';');
								break;
						}
					}
					fonctions = fonctions.replace(separateur, '');
					params = params.replace(separateur, '');
					jqFonction.text(fonctions);
					jqParam.text(params);

					var cadre = $.trim(jqCadre.text());
					var posCadreEtage = cadre.indexOf(options.cadreEtage);
					if (posCadreEtage >= 0)
					{
					   	var longCadreEtage = options.cadreEtage.length;
					   	cadre = cadre.substring(posCadreEtage + longCadreEtage);
						var numEtage = parseInt(cadre);
						jqCadre.text(jqNouvelElem.data('listeElemId')+'__'+jqNouvelElem.data('listeElemRand')+'__'+numEtage);
					}

					if ($(this).hasClass(options.classeElementMenuElemBoutonAjax) === true)
					   	jqMenuElem.addClass(options.classeElementMenuElemBoutonAjax);
					if ($(this).hasClass(options.classeElementMenuElemBoutonReset) === true)
					   	jqMenuElem.addClass(options.classeElementMenuElemBoutonReset);

					jqMenuElem.data('listeElemMenuElemInit', 1);
					jqMenuElem.find(options.selectorElemMenuElemBouton + ':first').find('td').html(lib);

					var optionsBouton =
					{
						selectorCadre: options.selectorElementMenuElemBoutonCadre,
						selectorFonction: options.selectorElementMenuElemBoutonFonc,
						selectorParam: options.selectorElementMenuElemBoutonParam,
						selectorBouton: options.selectorElemMenuElemBouton,
						classeBoutonAjax: options.classeElementMenuElemBoutonAjax,
						classeBoutonReset: options.classeElementMenuElemBoutonReset
					};

					jqMenuElem.inputButton(optionsBouton)/*.inputButtonInitialiser()*/.inputButtonDissocierSousForm().inputButtonInitialiserEtat();
					jqMenuElem.width('100%');
					jqMenuElem.children().width('100%');

					jqCadre.remove();
					jqFonction.remove();
					jqParam.remove();
				});

				jqMenu.hide();
			});

			jqNouvelElem.find(options.selectorElemMenus + ':first').width(0).show();

			jqNouvelElem.mousedown(function(e)
			{
				var position = {x: e.pageX, y: e.pageY, options: options, elem: jqNouvelElem};
				$(document).bind('mouseup', position, listeElementMouseUp);
				if (jqListe.hasClass(options.classeSortable) == true)
				   	$(this).css('cursor', 'move');
			});

			jqNouvelElem.mouseup(function()
			{
			   	if (jqListe.hasClass(options.classeSortable) == true)
				   	$(this).css('cursor', 'pointer');
			});

			jqNouvelElem.mouseenter(function()
			{
			   	popMenu(jqNouvelElem, $(this).data('listeElemMenuElemPop'), options);
			});

			jqNouvelElem.mouseleave(function()
			{
			   	var num = 0;
			   	var numMenu = $(this).data('listeElemMenuElemPop');
			   	$(this).find(options.selectorElemMenus + ':first').find(options.selectorElemMenu).each(function()
				{
				   	if (num == numMenu)
				   	{
				   	   	var duree = ($(this).width()/200)*300;
			   		   	$(this).stop(true, false).animate({width: '0px'}, duree, function() {$(this).hide()});
			   		}
			   		num++;
			   	});
			});

			jqNouvelElem.bind('menuPop', function(e, data)
			{
			   	$(this).data('listeElemMenuElemPop', data.numMenu);
			   	popMenu(jqNouvelElem, data.numMenu, options);
			   	e.stopPropagation();
			});

			jqNouvelElem.bind('etageGo', function(e, data)
			{
			   	allerEtage(jqNouvelElem, data.numEtage, options);
			   	e.stopPropagation();
			});

			jqNouvelElem.mouseenter(function()
			{
			   	$(this).Clignoter({}, 20 + jqListe.data('listeNiveau'), true);
			});

			jqNouvelElem.mouseleave(function()
			{
			   	$(this).Clignoter({}, 20 + jqListe.data('listeNiveau'), false);
			});
			//jqNouvelElem.Clignoter({declenchement: 'mouseenter'}, 20 + jqListe.data('listeNiveau'));
			allerEtage(jqNouvelElem, 1, options, true);
			jqNouvelElem.css('visibility', 'visible').height('');

			return jqNouvelElem;
		},

		initPageNavig = function(jqElem, jqListe, options)
		{
		   	jqElem.css('position', 'relative');

		   	var nbPages = parseInt(jqElem.find(options.selectorPageDer).text());
		   	jqListe.data('listeNbPages', nbPages);
		    var jqPageBarreDefilement = jqElem.find(options.selectorPageBarreDefilement + ':first');
		    var jqPageCourante = jqPageBarreDefilement.find(options.selectorPageCourante + ':first');
		    var page = parseInt(jqPageCourante.text());
		    jqListe.data('listePage', page);
		    jqListe.data('listePageCourante', page);
		    jqPageBarreDefilement.parent().css('top', '0px');
			jqPageBarreDefilement.css('top', '0px').width('100%').fill().addClass('jq_fill').find('table:first').fill().addClass('jq_fill');
			jqPageBarreDefilement.css('position', 'relative').css('cursor', 'default').disableSelection();
			jqPageCourante.css('cursor', 'default').css('text-align', 'center').draggable({
				containment: 'parent',
				axis: 'x',
				drag: function(event, ui)
				{
				   	var posBarre = parseInt($(this).css('left'));
				   	var tailleBarre = parseInt(jqElem.data('listePageTailleBarre')) - $(this).width();
				   	var nbPages = parseInt(jqListe.data('listeNbPages'));
				   	var page = 1;
				   	if (tailleBarre > 0)
				   	   	page = Math.round((posBarre * (nbPages - 1) / tailleBarre) + 1);
					var jqAutrePageNavig = jqElem.siblings(options.selectorPageNavigateur).find(options.selectorPageCourante);
					jqAutrePageNavig.css('left', $(this).css('left'));
				   	if (page != jqListe.data('listePage'))
				   	{
						$(this).find('td').text(page);
						jqAutrePageNavig.find('td').text(page);
					   	jqListe.data('listePage', page);
				   	}
				},
				stop: function(event, ui)
				{
				   	var tailleBarre = parseInt(jqElem.data('listePageTailleBarre')) - $(this).width();
				   	var nbPages = parseInt(jqListe.data('listeNbPages'));
				   	var page = jqListe.data('listePage');
				   	var posBarre = 0;
				   	if (nbPages > 1)
				   	   	posBarre = (page - 1) * tailleBarre /(nbPages - 1);
				   	jqListe.trigger('listeChangePage');
				   	$(this).animate({left: posBarre});
				   	jqElem.siblings(options.selectorPageNavigateur).find(options.selectorPageCourante).animate({left: posBarre});
				}
			}).fill().addClass('jq_fill').find('table:first').fill().addClass('jq_fill');

			jqPageCourante.mousedown(function(e)
			{
			   	e.stopPropagation();
			});

			jqPageCourante.bind('mousedown.draggable', function(e)
			{
			   	e.stopPropagation();
			});

			jqPageBarreDefilement.mousedown(function(e)
			{
			   	var offset = $(this).offset();
			   	var jqAutrePageNavig = jqElem.siblings(options.selectorPageNavigateur).andSelf().find(options.selectorPageCourante);
				var tailleBarre = parseInt(jqElem.data('listePageTailleBarre')) - jqAutrePageNavig.width();
				var posCurseur = e.pageX - offset.left - parseInt(jqAutrePageNavig.parent().css('left')) - (jqAutrePageNavig.width() / 2);
				if (posCurseur <= 0)
					posCurseur = 0;
				else if (posCurseur >= tailleBarre)
				   	posCurseur = tailleBarre;
				jqAutrePageNavig.stop(true, false).css('left', posCurseur).trigger('mousedown.draggable', [e]);
				var posBarre = parseInt(jqAutrePageNavig.css('left'));
				var nbPages = parseInt(jqListe.data('listeNbPages'));
				var page = 1;
				if (tailleBarre > 0)
				   	page = Math.round((posBarre * (nbPages - 1) / tailleBarre) + 1);
				jqAutrePageNavig.find('td').text(page);
				jqListe.data('listePage', page);
				jqAutrePageNavig.one('mouseup', function(e)
				{
				   	var posBarre = parseInt(jqAutrePageNavig.css('left'));
				   	var page = 1;
					if (tailleBarre > 0)
					   	page = Math.round((posBarre * (nbPages - 1) / tailleBarre) + 1);
					if (page == jqListe.data('listePage'))
					{
					   	var posBarreExacte = 0;
					   	if (nbPages > 1)
						    posBarreExacte = (page - 1) * tailleBarre /(nbPages - 1);
					   	jqAutrePageNavig.animate({left: posBarreExacte});
					   	jqListe.trigger('listeChangePage');
					}
				});
			});

			var jqPagePrec = jqPageBarreDefilement.find(options.selectorPagePrec + ':first');
			var jqPageSuiv = jqPageBarreDefilement.find(options.selectorPageSuiv + ':first');
			jqPagePrec.css('position', 'absolute').css('top', '0px').css('left', '0px').width(20).find('td').css('text-align', 'center').text('◄').fill().addClass('jq_fill').find('table:first').fill().addClass('jq_fill');
			jqPageSuiv.css('position', 'absolute').css('top', '0px').css('right', '0px').width(20).find('td').css('text-align', 'center').text('►').fill().addClass('jq_fill').find('table:first').fill().addClass('jq_fill');
			jqPageCourante.parent().css('position', 'absolute').css('top', '0px').css('left', jqPagePrec.outerWidth(true)+'px').css('right', jqPageSuiv.outerWidth(true)+'px');
			var tailleBarre = jqPageCourante.width();
			jqElem.data('listePageTailleBarre', tailleBarre);
			if ((tailleBarre / nbPages) <= 30)
			   	jqPageCourante.width(30);
			else
			   	jqPageCourante.width(tailleBarre / nbPages);

			jqPagePrec.mousedown(function(e){e.stopPropagation()});
			jqPageSuiv.mousedown(function(e){e.stopPropagation()});

			jqPagePrec.click(function(e)
			{
			   	var page = jqListe.data('listePage') - 1;
			   	if (page >= 1)
				{
			   		jqListe.data('listePage', page);
			   		var jqAutrePageNavig = jqElem.siblings(options.selectorPageNavigateur).andSelf().find(options.selectorPageCourante);
			   		jqAutrePageNavig.find('td').text(page);
					var tailleBarre = parseInt(jqElem.data('listePageTailleBarre')) - jqAutrePageNavig.width();
				   	var nbPages = parseInt(jqListe.data('listeNbPages'));
					var posBarre = 0;
					if (nbPages > 1)
					   posBarre = (page - 1) * tailleBarre /(nbPages - 1);
				   	jqAutrePageNavig.animate({left: posBarre}, 300, function()
					{
					   	if (page == jqListe.data('listePage'))
					   	   	jqListe.trigger('listeChangePage');
					});
			   	}
			   	e.stopPropagation();
			});

			jqPageSuiv.click(function(e)
			{
			   	var page = jqListe.data('listePage') + 1;
			   	var nbPages = parseInt(jqListe.data('listeNbPages'));
			   	if (page <= nbPages)
				{
				   	jqListe.data('listePage', page);
			   		var jqAutrePageNavig = jqElem.siblings(options.selectorPageNavigateur).andSelf().find(options.selectorPageCourante);
					jqAutrePageNavig.find('td').text(page);
					var tailleBarre = parseInt(jqElem.data('listePageTailleBarre')) - jqAutrePageNavig.width();
				   	var posBarre = 0;
					if (nbPages > 1)
					   posBarre = (page - 1) * tailleBarre /(nbPages - 1);
				   	jqAutrePageNavig.animate({left: posBarre}, 300, function()
					{
					   	if (page == jqListe.data('listePage'))
					   	   	jqListe.trigger('listeChangePage');
					});
			   	}
			   	e.stopPropagation();
			});

			tailleBarre -= jqPageCourante.width();
			var posBarre = 0;
			if (nbPages > 1)
			   	posBarre = (page - 1) * tailleBarre /(nbPages - 1);
			jqPageCourante.css('left', posBarre);

			//if (nbPages <= 1)
			//	jqElem.hide();
		},

		placerElement = function(jqElem, jqListe, jqElemModele, options, ancienOrdre)
		{
		   	var place = false;
		   	var changeOrdre = false;
		   	var jqDernierElem = jqElemModele;
		  	var jqPremierElem = jqElemModele.siblings(options.selectorElem + ':first');//.parent().find(options.selectorElem + ':first');
		   	var ordre = jqElem.data('listeElemOrdre');

		  	jqPremierElem.each(function()
		  	{
		  	   	jqDernierElem = jqPremierElem;
			  	if (ordre <= jqPremierElem.data('listeElemOrdre'))
				{
				   	jqPremierElem.siblings(options.selectorElem).each(function()
				   	{
				   	   	if (ancienOrdre != undefined && jqElem.data('listeElemId') !== $(this).data('listeElemId'))
						{
							var elemOrdre = $(this).data('listeElemOrdre');
					   		if (ancienOrdre > ordre && elemOrdre >= ordre && elemOrdre < ancienOrdre)
					   			$(this).data('listeElemOrdre', elemOrdre + 1);
					   		else if (ancienOrdre < ordre && elemOrdre > ancienOrdre && elemOrdre <= ordre)
							   	$(this).data('listeElemOrdre', elemOrdre - 1);
						}
						else if (jqElem.data('listeElemId') !== $(this).data('listeElemId'))
				   	   	   	$(this).data('listeElemOrdre', $(this).data('listeElemOrdre') + 1);
				   	});
					jqPremierElem.before(jqElem);
					place = true;
					jqPremierElem.data('listeElemOrdre', jqPremierElem.data('listeElemOrdre') + 1);
				}
			});

			if (place === false && jqPremierElem.length >= 1)
			{
			   	jqPremierElem.siblings(options.selectorElem).each(function()
				{
				   	jqDernierElem = $(this);

				   	if (place === false && ordre <= jqDernierElem.data('listeElemOrdre'))
				   	{
					   jqDernierElem.before(jqElem);
					   place = true;

					   if (ordre === jqDernierElem.data('listeElemOrdre'))
					   	   changeOrdre = true;
					}

					if (place === true && changeOrdre === true && ancienOrdre == undefined)
						jqDernierElem.data('listeElemOrdre', jqDernierElem.data('listeElemOrdre') + 1);
					else if (ancienOrdre != undefined && jqElem.data('listeElemId') !== jqDernierElem.data('listeElemId'))
					{
						var elemOrdre = jqDernierElem.data('listeElemOrdre');
				   		if (ancienOrdre > ordre && elemOrdre >= ordre && elemOrdre < ancienOrdre)
				   			jqDernierElem.data('listeElemOrdre', elemOrdre + 1);
				   		else if (ancienOrdre < ordre && elemOrdre > ancienOrdre && elemOrdre <= ordre)
						   	jqDernierElem.data('listeElemOrdre', elemOrdre - 1);
					}
				});
			}

			if (place === false)
				jqDernierElem.after(jqElem);
		},

		popMenu = function(jqElem, numMenu, options, elemCreation)
		{
		   	var num = 0;
		   	var jqMenus;
		   	if (elemCreation === true)
		   	   	jqMenus = jqElem.find(options.selectorElemMenus + ':last');
		   	else
		   	   	jqMenus = jqElem.find(options.selectorElemMenus + ':first');
			jqMenus.find(options.selectorElemMenu).each(function()
			{
			   	if (num == numMenu)
			   	{
					if ($.trim($(this).find(options.selectorElemMenuElem + ':first').text()) !== '')
					{
					   	$(this).closest(options.selectorElemMenus).parent().css('display', 'block');
				   	   	$(this).stop(true, false).animate({width: '200px'}, 300);
				   	}
				}
				else if ($(this).width() !== 0)
				   	$(this).stop(true, true).fadeOut(300, function() {$(this).width(0)});
			   	num++;
			});
		},

		allerEtage = function(jqElem, numEtage, options, direct)
		{
		   	var num = 1;
		   	var elemId = jqElem.data('listeElemId');
		   	var typeSynchro = jqElem.closest('.jq_liste').data('listeTypeSynchro');
		   	jqElem.find(options.selectorElemEtage).each(function()
			{
			   	if ($(this).data('listeElemEtageElemId') == elemId && typeSynchro == $(this).closest('.jq_liste').data('listeTypeSynchro'))
				{
				   	if (direct == true)
					{
						if (num == numEtage)
						{
						   	chargerEtage(jqElem, $(this));
						   	$(this).show();
						}
						else
						   	$(this).hide();
					}
					else
					{
						if (num == numEtage)
						{
						   chargerEtage(jqElem, $(this));
						   $(this).stop(true, false).slideDown(300);
						}
						else
						   $(this).stop(true, false).slideUp(300, function() {$(this).hide();});
					}
					num++;
				}
			});
		},

		chargerContenu = function(jqElem)
		{
		   	if (jqElem.data('listeElemContenuCharge') != 1)
			{
			   	jqElem.data('donnees', jqElem.data('listeElemContenuChargeParam') + '=' + jqElem.data('listeElemId'));
				eval(jqElem.data('listeElemContenuChargeFonc') + '.call(jqElem)');
				jqElem.data('listeElemContenuCharge', 1);
			}
		},

		chargerEtage = function(jqElem, jqEtage)
		{
		   	if (jqEtage.data('listeElemEtageCharge') != 1)
			{
			   	jqElem.data('donnees', jqEtage.data('listeElemEtageChargeParam') + '=' + jqElem.data('listeElemId'));
				eval(jqEtage.data('listeElemEtageChargeFonc') + '.call(jqElem)');
				jqEtage.data('listeElemEtageCharge', 1);
			}
		},

		changerPage = function(jqElem, numPage)
		{
		   	jqElem.data('donnees', jqElem.data('listePageChangeParam') + '=' + numPage);
		  	eval(jqElem.data('listePageChangeFonction') + '.call(jqElem)');
		},

		resetOrdre = function(jqElem, options)
		{
		   	var jqElemPrem = jqElem.find(options.selectorElem + ':first');
			var jqElems = jqElemPrem.siblings(options.selectorElem);
		   	var ordre = 1;
		   	jqElemPrem.data('listeElemOrdre', 0);
			jqElems.each(function()
		   	{
		   	   	$(this).data('listeElemOrdre', ordre);
		   	   	ordre++;
		   	});
		},

		suppElementDansChaine = function(chaine, numElement, separateur)
		{
		   	var posSep = chaine.indexOf(separateur, 0);
		   	if (posSep < 0)
		   		chaine = '';
		   	var posSepFin = -1;

			for (var j = 0; posSep >= 0 && j <= numElement; j++)
			{
			  	if (j >= 1)
				{
				  	posSepFin = chaine.indexOf(';', posSep + 1);
				  	if (posSepFin < 0)
				  		posSepFin = chaine.length;
				}
			  	if (numElement === j)
			  	{
			  		if (j >= 1)
					   	chaine = chaine.substring(0, posSep + 1) + chaine.substring(posSepFin, chaine.length);
					else
					   	chaine = chaine.substring(posSep, chaine.length);
			  	}
			  	if (j >= 1)
			  	   	posSep = posSepFin;
			}

			return chaine;
		},

		calculerOffsetPaddingListeParente = function(jqListe)
		{
		   	var paddingWidth = 0;
		   	var jqParent = jqListe.parent();
		   	var jqClosestListe = jqParent.closest('.jq_liste');

			if (jqClosestListe.length >= 1)
			{
				while (jqParent && jqParent.hasClass('jq_liste') === false)
			   	{
			  	   	paddingWidth += parseInt(jqParent.css('padding-left'));
					paddingWidth += parseInt(jqParent.css('padding-right'));
					jqParent = jqParent.parent();
			   	}
			}

			return paddingWidth;
		},

		calculerOffsetPaddingElemListe = function(jqElem)
		{
		   	var paddingWidth = 0;
		   	var jqParent = jqElem.parent();

			while (jqParent && jqParent.hasClass('jq_liste') === false)
			{
			  	paddingWidth += parseInt(jqParent.css('padding-left'));
				paddingWidth += parseInt(jqParent.css('padding-right'));
				jqParent = jqParent.parent();
			}

			return paddingWidth;
		},

		calculerOffsetPaddingChampElem = function(jqChamp)
		{
		   	var paddingWidth = 0;
		   	var jqParent = jqChamp.parent();

			while (jqParent && jqParent.hasClass('jq_liste_elem') === false && jqParent.hasClass('jq_liste_elementmodele') === false)
			{
			  	paddingWidth += parseInt(jqParent.css('padding-left'));
				paddingWidth += parseInt(jqParent.css('padding-right'));
				jqParent = jqParent.parent();
			}

			return paddingWidth;
		};

		listeElementMouseUp = function(e)
		{
			$(document).unbind('mouseup', listeElementMouseUp);
			if (e.pageX == e.data.x && e.pageY == e.data.y)
			{
				var jqElem = e.data.elem;
				var fonction = jqElem.data('listeElemFonction');
				if (fonction != undefined && fonction != '')
				{
					var param = jqElem.data('listeElemParam');
					jqElem.data('donnees', param);
					eval(fonction + '.call(jqElem)');
				}
			}
		};

		return {
			construct: function (options, sousListe)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function()
				{
					if ($(this).data('liste') != 1)
					{
						var liste = $(this);
						liste.data('liste', 1);
						liste.find('input').hide(); // A ne pas remettre!

						// On recherche et initialise les sous-listes.
						liste.find('.jq_liste').liste(options, true);

						var elemModele = liste.find(options.selectorElementModele + ':first');
						var elemCreation = liste.find(options.selectorElementCreation + ':first');
						var pageNavig = liste.find(options.selectorPageNavigateur + ':first').siblings(options.selectorPageNavigateur).andSelf();
			   	   		var elemCaches = liste.parents(':hidden');
			   	   		elemCaches.css('visibility', 'hidden').height(0).show();

						init(liste, options);

						elemCreation.hide();
						pageNavig.css('visibility', 'hidden').height(0).show();

						liste.find('input').show();
						var nbElem = 0;
						if (liste.hasClass(options.classeStatique) === true)
						{
						  	var elems = liste.find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf();
							elems.each(function()
							{
								initElementStatique($(this), liste, options, sousListe);
								nbElem++;
							});
						}
						else
						{
						   	var elems = liste.find(options.selectorElement + ':first').siblings(options.selectorElement).andSelf();
						   	elems.hide();

							elemModele.each(function()
							{
								initElementModele($(this), options, sousListe);
							});

							elemCreation.each(function()
							{
								initElementCreation($(this), liste, elemModele, options);
							});

							//var nbElem = 0;
							elems.each(function()
							{
								initElement($(this), liste, elemModele, options, sousListe);
								nbElem++;
							});
							if (liste.hasClass(options.classeSortable) == true)
							   	liste.sortable('refresh');
						}

						elemCaches/*.hide()*/.height('').css('visibility', 'visible');

						pageNavig.each(function()
						{
							initPageNavig($(this), liste, options);
						});

						elemCreation.show();
						liste.find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf().show();
						liste.css('visibility', 'visible').height('');
						liste.listeSetDimensions();
						//liste.width(liste.parent().innerWidth());
						if (liste.data('listeNbPages') <= 1)
						   	pageNavig.hide();
						pageNavig.css('visibility', 'visible').height('');

						if (liste.hasClass(options.classeSortable) == true)
							liste.find(options.selectorListe + ':first').css('min-height', '10px');

						//liste.data('listeWidth', -1);

						/*alert(liste.parent().innerWidth());
						alert(liste.innerWidth());*/
					}
				});
			},

			creerElement: function (element, options)
			{
				if ($(this).data('liste') == 1)
				{
				   	var jqListe = $(this);
					var options = $.extend({}, defaults, options || {});
					$(this).append('<div class="jq_liste_elementconstructeur" style="display:none;"></div>');
					var jqElemConstruct = $(this).find('.jq_liste_elementconstructeur:last');
					jqElemConstruct.html(element);
					var jqElem = jqElemConstruct.find(options.selectorElement + ':first');
					var dejaExistant = false;
					var id = $.trim(jqElem.find(options.selectorElementId + ':first').text());
				   	$(this).find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf().each(function()
					{
					   	if ($(this).data('listeElemId') == id)
						   	dejaExistant = true;
					});
					if (dejaExistant === false)
					{
						var jqElemModele = $(this).find(options.selectorElementModele + ':first');
						jqElem.css('visibility', 'hidden').height(0);
						jqElem.find('.jq_liste').liste(options, true);
						var jqNouvelElem = initElement(jqElem, $(this), jqElemModele, options);
						if (jqListe.data('listeNiveau') >= 1)
						   	jqNouvelElem.trigger('redimensionnerChampsListe');

						if ($(this).hasClass(options.classeSortable) == true)
							$(this).sortable('refresh');
					}
					jqElemConstruct.remove();
				}
			},

			modifierElement: function (element, options)
			{
				if ($(this).data('liste') == 1)
				{
				   	var options = $.extend({}, defaults, options || {});
				   	$(this).append('<div class="jq_liste_elementmodifieur" style="display:none;"></div>');
					var jqElemModif = $(this).find('.jq_liste_elementmodifieur:last');
					jqElemModif.html(element);
					var jqElem = jqElemModif.find(options.selectorElement + ':first');
					var id = $.trim(jqElem.find(options.selectorElementId + ':first').text());
					var ordre = parseInt($.trim(jqElem.find(options.selectorElementOrdre + ':first').text()));
					var jqListe = $(this);
					var listeTypeSynchro = jqListe.data('listeTypeSynchro');

					$(this).find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf().each(function()
					{
					   	if ($(this).data('listeElemId') == id)
						{
							var jqChamps = $(this).find(options.selectorElemChamp);
							var jqElemChamps = jqElem.find(options.selectorElementChamps + ':first').find(options.selectorElementChamp + ':first').siblings(options.selectorElementChamp).andSelf();
							jqElemChamps.each(function()
							{
							   	var valeur = $.trim($(this).find(options.selectorElementChampValeur + ':first').html());
								var nom = $.trim($(this).find(options.selectorElementChampNom + ':last').text());
								var type = $.trim($(this).find(options.selectorElementChampType + ':last').text());

								jqChamps.each(function()
								{
								   	$(this).css('position', 'relative').width('100%').css('min-width', '').css('max-width', '');
								   	if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro)
								 	{
									   	if ($(this).data('listeElemChampNom') == nom && $(this).data('listeElemChampType') == type)
									   	{
									   	   	if ($.trim($(this).find('td:first').html()) === '')
									   	   	{
									   	   		$(this).find('td:first').html(valeur);
									   	   		var jqEtages = $(this).parents(options.selectorElemEtage);

									   	   		jqEtages.each(function()
									   	   		{
												   	if ($(this).css('display') == 'none')
												   		$(this).css('visibility', 'hidden').height(0).show();
									   	   		});

									   	   		$(this).find(options.selectorInputColor).color();
												$(this).find(options.selectorInputText).inputText();
												$(this).find(options.selectorInputSelect).inputSelect();
												$(this).find(options.selectorInputCheckbox).inputCheckbox();
												$(this).find(options.selectorInputFile).inputFile();
												$(this).find(options.selectorInputImage).inputImage();
												$(this).find(options.selectorInputListe).inputListe();
												$(this).find(options.selectorInputListeDouble).inputListeDouble();
												$(this).data('listeElemChampModifie', 0);
												$(this).trigger('redimensionnerChampsListe');

									   	   		jqEtages.each(function()
									   	   		{
												   	if ($(this).css('display') == 'block' && $(this).css('visibility') == 'hidden')
												   		$(this).hide().height('').css('visibility', 'visible');
									   	   		});
									   	   	}
									   	}
									}
								});

								jqChamps.each(function()
								{
								   	if ($(this).closest('.jq_liste').data('listeTypeSynchro') == listeTypeSynchro)
								 	{
									   	if ($(this).data('listeElemChampModifie') != 1 && $(this).data('listeElemChampNom') == nom && (typeof(nom) == 'string') && type != options.typeChampModification)
										{
										   	var actualise = false;

									   		$(this).find('.jq_input_text').each(function()
									   		{
									   		   	$(this).inputTextFixerValeur(valeur);
									   		   	actualise = true;
									   		});

									   		$(this).find('.jq_input_checkbox').each(function()
									   		{
									   		   	if (valeur == '1')
									   		   	   	$(this).inputCheckboxChecker(true);
									   		   	else
									   		   	   	$(this).inputCheckboxChecker(false);
									   		   	actualise = true;
									   		});

											$(this).find('.jq_input_select').each(function()
									   		{
									   		   	$(this).inputSelectFixerValeur(valeur);
									   		   	actualise = true;
									   		});

									   		$(this).find('.jq_input_image').each(function()
									   		{
									   		   	$(this).inputImageFixerValeur(valeur);
									   		   	actualise = true;
									   		});

									   		$(this).find('.jq_input_liste').each(function()
									   		{
									   		   	actualise = true;
									   		});

									   		$(this).find('.jq_input_listedb').each(function()
									   		{
									   		   	actualise = true;
									   		});

									   		if ($(this).data('listeElemChampType') === options.typeChampConsultation)
										   	{
										   	   	$(this).find('img').each(function()
												{
												   	$(this).attr('src', valeur);
												   	if (valeur === '')
												   	{
												   		$(this).hide();
												   		$(this).trigger('redimensionnerChampsListe');
												   	}
												   	else
												   	   	$(this).show();
												   	actualise = true;
												});
											}

									   		if (actualise === false)
									   		{
									   		   	if ($.trim($(this).find('td:first').html()) != '')
									   		   	{
										   		   	$(this).find('td:first').html(valeur);
										   		   	$(this).trigger('redimensionnerChampsListe');
										   		}
									   		}

									   		$(this).data('listeElemChampModifie', 0);
									   	}
									}
								});
							});

							if ($(this).data('listeElemOrdre') !== ordre)
							{
							   	var ancienOrdre = $(this).data('listeElemOrdre');
							   	$(this).data('listeElemOrdre', ordre);
							   	var jqElemModele = jqListe.find(options.selectorElementModele + ':first');
								placerElement($(this), jqListe, jqElemModele, options, ancienOrdre);
							}
						}

						$(this).find(options.selectorInputSelect).inputSelectActiverRechargement();
					});

					jqElemModif.remove();
				}
			},

			supprimerElement: function (id, options)
			{
				if ($(this).data('liste') == 1)
				{
				   	var options = $.extend({}, defaults, options || {});
				   	var elemSupprime = false;

					$(this).find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf().each(function()
					{
					   	if ($(this).data('listeElemId') === id)
					   	{
						   	$(this).remove();
						   	elemSupprime = true;
						}
						else if (elemSupprime === true)
							$(this).data('listeElemOrdre', $(this).data('listeElemOrdre') - 1);
					});
				}
			},

			changerTypeSynchro: function (typeSynchro)
			{
			   	return this.each(function()
				{
					if ($(this).data('liste') == 1)
					    $(this).data('listeTypeSynchro', typeSynchro);
				});
			},

			changerNbPages: function (nbPages)
			{
			   	var options = $.extend({}, defaults, options || {});
			   	return this.each(function()
				{
					if ($(this).data('liste') == 1)
					{
					   	var ancienNbPages = $(this).data('listeNbPages');
					   	nbPages = parseInt(nbPages);
					   	if (ancienNbPages != nbPages)
					   	{
					   	   	var jqPageNavig = $(this).find(options.selectorPageNavigateur + ':first').siblings(options.selectorPageNavigateur).andSelf();
						    var jqPageCourante = jqPageNavig.find(options.selectorPageCourante);
							var page = $(this).data('listePage');
							$(this).data('listeNbPages', nbPages);
						    jqPageNavig.find(options.selectorPageDer).find('td:first').text(nbPages);
							if (ancienNbPages == 1 && nbPages > 1)
						    	jqPageNavig.show();
						    else if (ancienNbPages > 1 && nbPages == 1)
						    	jqPageNavig.hide();

						    if (page > nbPages)
						    {
						       	page = nbPages;
						       	$(this).data('listePage', page);
						       	jqPageCourante.find('td:first').text(page);
						       	$(this).trigger('listeChangePage');
						    }
							var tailleBarre = jqPageNavig.data('listePageTailleBarre');
							if ((tailleBarre / nbPages) <= 30)
							   	jqPageCourante.width(30);
							else
							   	jqPageCourante.width(tailleBarre / nbPages);
							tailleBarre -= jqPageCourante.width();

							var posBarre = 0;
							if (nbPages > 1)
							   	posBarre = (page - 1) * tailleBarre /(nbPages - 1);
							jqPageCourante.css('left', posBarre);

							jqPageNavig.find(options.selectorPageBarreDefilement).fill().addClass('jq_fill').find('table:first').addClass('jq_fill');
						}
					}
				});
			},

			recupererValeur: function ()
			{
			   	var options = $.extend({}, defaults, options || {});
				var valeur = '';

				if ($(this).data('liste') == 1)
				{
					$(this).find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf().each(function()
					{
					   	valeur = '1';
					});
				}

				return valeur;
			},

			recupererRetour: function (retour)
			{
			   	var options = $.extend({}, defaults, options || {});
			   	var valeur = '';

				if ($(this).data('liste') == 1)
				{
				   	var numElem = 0;
				   	$(this).find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf().each(function()
					{
					   	if (retour != '')
					   	{
						   	var param = $(this).data('listeElemParam').split('&');
						   	for (var i = 0; i < param.length; i++)
							{
							  	var posCroch = param[i].indexOf('[');
							  	var posEgal = param[i].indexOf('=');
							  	if (posCroch != -1 && posCroch < posEgal)
							  	{
							  	   	if (valeur != '')
					   		   		   	valeur += '&';
							  		valeur += retour + '[' + numElem + ']' + param[i].substring(posCroch, param[i].length);
							  	}
							 	else if (posEgal != -1 && (posCroch > posEgal || posCroch == -1))
							 	{
							 	   	if (valeur != '')
					   		   		   	valeur += '&';
							 		valeur += retour + '[' + numElem + '][' + i + ']' + param[i].substring(posEgal, param[i].length);
							 	}
							}
						}
						else
						{
						   	if (valeur != '')
					   		   	valeur += '&';
						   	valeur += $(this).data('listeElemParam');
						}

						numElem++;
					});
				}

				return valeur;
			},

			ajouterContenuElement: function (id, contenu)
			{
			   	var options = $.extend({}, defaults, options || {});

				if ($(this).data('liste') == 1)
				{
					$(this).find(options.selectorElem + ':first').siblings(options.selectorElem).andSelf().each(function()
					{
						if ($(this).data('listeElemId') === id)
						{
							$(this).find('.' + options.classeElemPliant).each(function()
							{
							   	var jqContenu = $(this).find('td:first').children(options.selectorElemContenu + ':first').find('td:first');
							   	jqContenu.html(contenu);
							   	//jqContenu.css('visibility', 'hidden').height(0).show();
								jqContenu.find('.jq_liste').liste(options, true);
								jqContenu.find(options.selectorInputColor).color();
								jqContenu.find(options.selectorInputText).inputText();
								jqContenu.find(options.selectorInputSelect).inputSelect();
								jqContenu.find(options.selectorInputCheckbox).inputCheckbox();
								jqContenu.find(options.selectorInputFile).inputFile();
								jqContenu.find(options.selectorInputImage).inputImage();
								jqContenu.find(options.selectorInputListe).inputListe();
								jqContenu.find(options.selectorInputListeDouble).inputListeDouble();
								jqContenu.find(options.selectorVisualiseur).visualiseur();
							});
						}
					});
				}
			},

			setDimensions: function ()
			{
			   	var options = $.extend({}, defaults, options || {});

				return this.each(function()
				{
					if ($(this).data('liste') == 1)
					{
					   	//var jqListe = $(this);
					   	//var offsetPadding = calculerOffsetPaddingListeParente($(this));
					   	//var ancienOffsetPadding = $(this).data('listeOffsetPadding');
					   	//var offsetListe = offsetPadding - ancienOffsetPadding;
						//var offsetWidth = $(this).parent().innerWidth() - parseInt($(this).css('width'));
						//var offsetWidth = $(this).parent().innerWidth() - parseInt($(this).css('width'));
						//$(this).data('listeOffsetPadding', offsetPadding);

			   			if ($(this).data('listeWidth') == -1)
						{
			   				$(this).css('margin-right', '0px');
			   				$(this).parent().width('100%');
			   				$(this).width('100%');
			   			}
			   			//else if ($(this).data('listeWidth') != -1)
			   			//   	$(this).width($(this).data('listeWidth') - offsetListe);
			   			//$(this).data('listeWidth', $(this).width());

						var typeSynchro = $(this).data('listeTypeSynchro');
			 			$(this).find(options.selectorElementModele + ':first').siblings(options.selectorElem).andSelf().each(function()
						{
							//var offsetPaddingElem = calculerOffsetPaddingElemListe($(this));
						   	//var ancienOffsetPaddingElem = $(this).data('listeOffsetPaddingElem');
						   	//var offsetElem = offsetListe + offsetPaddingElem - ancienOffsetPaddingElem;
							//$(this).data('listeOffsetPaddingElem', offsetPaddingElem);
							//var width = $(this).width() - offsetElem + offsetWidth;
							//var width = jqListe.width() - offsetPaddingElem;
							//alert(width);
				   			$(this).css('min-width', '');
				   			$(this).css('max-width', '');
				   			$(this).width('');
							//$(this).width(width);
				   			//$(this).css('max-width', width + 'px');
				   			//$(this).css('min-width', width + 'px');

				   			$(this).find(options.selectorElemChamp).each(function()
				   			{
				   			   	if (typeSynchro == $(this).closest('.jq_liste').data('listeTypeSynchro'))
								{
						   			//var offsetPaddingChamp = calculerOffsetPaddingChampElem($(this));
								   	//var ancienOffsetPaddingChamp = $(this).data('listeOffsetPaddingChamp');
								   	//var offsetChamp = offsetListe + offsetElem + offsetPaddingChamp - ancienOffsetPaddingChamp;
									//$(this).data('listeOffsetPaddingChamp', offsetPaddingChamp);
									//var widthChamp = $(this).width() - offsetChamp;
						   			$(this).css('min-width', '');
						   			$(this).css('max-width', '');
						   			$(this).width('');
						   			//$(this).width(widthChamp);
						   			//$(this).css('max-width', widthChamp + 'px');
						   			//$(this).css('min-width', widthChamp + 'px');
						   		}
				   			});
						});
					}
				});
			}
		};
	}();
	$.fn.extend(
	{
		liste: liste.construct,
		listeCreerElement: liste.creerElement,
		listeModifierElement: liste.modifierElement,
		listeSupprimerElement: liste.supprimerElement,
		listeChangerTypeSynchro: liste.changerTypeSynchro,
		listeChangerNbPages: liste.changerNbPages,
		listeRecupererValeur: liste.recupererValeur,
		listeRecupererRetour: liste.recupererRetour,
		listeAjouterContenuElement: liste.ajouterContenuElement,
		listeSetDimensions: liste.setDimensions
	});
})(jQuery)