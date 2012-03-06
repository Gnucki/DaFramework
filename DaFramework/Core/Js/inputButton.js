var timersButton = new Array();

(function ($)
{
	var inputButton = function()
	{
		var
		defaults =
		{
			selectorCadre: '.jq_input_button_cadre',
			selectorFonction: '.jq_input_button_fonction',
			selectorParam: '.jq_input_button_param',
			selectorBouton: '.jq_input_button_bouton',
			selectorValeurOnClick: '.jq_input_button_valeuronclick',
			classeListener: 'jq_input_button_listener',
			classeBoutonAjax: 'jq_input_button_ajax',
			classeBoutonReset: 'jq_input_button_reset',
			resetOnClick: false
		},

		verifierValiditeFormulaire = function(jqElem, jqBouton, options, popErreurMess)
		{
			var validiteFormulaire = true;
			var visualiseur = false;

			if (jqElem.find('.jq_visualiseur').length >= 1)
			   	visualiseur = true;

			jqElem.find('.jq_input_form').each(function()
			{
				if ($(this).closest('.jq_input_button_listener').data('inputFormVal') == jqElem.data('inputFormVal') && (visualiseur == false || $(this).closest('.jq_visualiseur').length == 0))
				{
					if ($(this).hasClass('jq_input_form_oblig') == true)
					{
						if ($(this).hasClass('jq_input_text') == true)
						{
							if ($(this).inputTextRecupererValeur() == '')
							{
								validiteFormulaire = false;
								if (popErreurMess == true)
									$(this).inputTextAfficherMessageErreur(jqBouton);
							}
							else
								$(this).inputTextEffacerMessageErreur(jqBouton);
						}
						else if ($(this).hasClass('jq_input_select') == true)
						{
							if ($(this).inputSelectRecupererValeur() == '')
							{
								validiteFormulaire = false;
								if (popErreurMess == true)
									$(this).inputSelectAfficherMessageErreur(jqBouton);
							}
							else
								$(this).inputSelectEffacerMessageErreur(jqBouton);
						}
						else if ($(this).hasClass('jq_input_checkbox') == true)
						{
							if ($(this).inputCheckboxRecupererValeur() == '')
							{
								validiteFormulaire = false;
								if (popErreurMess == true)
									$(this).inputCheckboxAfficherMessageErreur(jqBouton);
							}
							else
								$(this).inputCheckboxEffacerMessageErreur(jqBouton);
						}
						else if ($(this).hasClass('jq_input_file') == true)
						{
							if ($(this).inputFileRecupererValeur() == '')
							{
								validiteFormulaire = false;
								if (popErreurMess == true)
									$(this).inputFileAfficherMessageErreur(jqBouton);
							}
							else
								$(this).inputFileEffacerMessageErreur(jqBouton);
						}
						else if ($(this).hasClass('jq_input_new') == true)
						{
							if ($(this).inputNewRecupererValeur() == '')
							{
								validiteFormulaire = false;
								if (popErreurMess == true)
									$(this).inputNewAfficherMessageErreur(jqBouton);
							}
							else
								$(this).inputNewEffacerMessageErreur(jqBouton);
						}
						else if ($(this).hasClass('jq_input_liste') == true)
						{
							if ($(this).inputListeRecupererValeur() == '')
							{
								validiteFormulaire = false;
								if (popErreurMess == true)
									$(this).inputListeAfficherMessageErreur(jqBouton);
							}
							else
								$(this).inputListeEffacerMessageErreur(jqBouton);
						}
						else if ($(this).hasClass('jq_input_listedb') == true)
						{
							if ($(this).inputListeDoubleRecupererValeur() == '')
							{
								validiteFormulaire = false;
								if (popErreurMess == true)
									$(this).inputListeDoubleAfficherMessageErreur(jqBouton);
							}
							else
								$(this).inputListeDoubleEffacerMessageErreur(jqBouton);
						}
					}
				}
			});

			return validiteFormulaire;
		},

		onClick = function(jqBouton, jqElem)
		{
			var fonction = jqBouton.data('jqInputButtonFonction');
			var param;

			if (fonction != undefined && fonction != '')
			{
				param = jqBouton.data('jqInputButtonParam');
				var retour = '';
				var visualiseur = false;

				if (param == undefined)
					param = '';

				jqElem.find('.jq_visualiseur').each(function()
				{
				   	retour = $(this).visualiseurRecupererRetour();
				   	if (param != '')
						param += '&' + retour;
					else
						param += retour;
				   	visualiseur = true;
				});

				jqElem.find('.jq_input_form').each(function()
				{
					if ($(this).closest('.jq_input_button_listener').data('inputFormVal') == jqElem.data('inputFormVal'))
					{
						retour = '';
						if ($(this).hasClass('jq_input_text') == true)
							retour = $(this).inputTextRecupererRetour();
						else if ($(this).hasClass('jq_input_select') == true)
							retour = $(this).inputSelectRecupererRetour();
						else if ($(this).hasClass('jq_input_checkbox') == true)
							retour = $(this).inputCheckboxRecupererRetour();
						else if ($(this).hasClass('jq_input_file') == true)
							retour = $(this).inputFileRecupererRetour();
						else if ($(this).hasClass('jq_input_new') == true)
							retour = $(this).inputNewRecupererRetour();
						else if ($(this).hasClass('jq_input_liste') == true)
							retour = $(this).inputListeRecupererRetour();
						else if ($(this).hasClass('jq_input_listedb') == true)
							retour = $(this).inputListeDoubleRecupererRetour();
						else if ($(this).hasClass('jq_color') == true)
							retour = $(this).colorRecupererRetour();

						if (retour != '' && (visualiseur == false || $(this).closest('.jq_visualiseur').length == 0))
						{
							if (param != '')
								param += '&' + retour;
							else
								param += retour;
						}
					}
				});

				clickBoutonAjax(jqBouton, param);
			}
		},

		clickBoutonAjax = function(jqBouton, param, factice)
		{
		   	if (jqBouton.data('jqInputButtonAjax') == 1 || factice === true)
			{
				var valOnClick = jqBouton.data('jqInputButtonValeurOnClick');
				if (valOnClick == '')
					valOnClick = jqBouton.data('jqInputButtonValeur');
				jqBouton.find('td').html(valOnClick + '<div class="point1" style="display: inline-block">.</div><div class="point2" style="display: inline-block">.</div><div class="point3" style="display: inline-block">.</div>');
				var id = 'jq_input_bouton_' + parseInt(Math.random() * 1000);
				jqBouton.attr('id', id);
				desactiver(jqBouton, true);
				verouiller(jqBouton, true);
				pointsCligno(jqBouton.attr('id'));
				timersButton[id] = setInterval('pointsCligno(\''+jqBouton.attr('id')+'\')', 1400);
			}

			if (factice !== true)
			{
				var fonction = jqBouton.data('jqInputButtonFonction');
				if (param == undefined)
				   	param = jqBouton.data('jqInputButtonParam');

				jqBouton.data('donnees', param);
				eval(fonction + '.call(jqBouton)');
			}
		},

		traiterEventForm = function(jqElem, params)
		{
			if (params.action == 'rechargement')
			{
			   	var jqInputSelect = jqElem.find('.jq_input_select');

				jqInputSelect.each(function()
				{
					var type = $(this).data('inputSelectType');
					if (type != undefined && type != '' && typeof(params.cibles) == 'object' && (params.cibles instanceof Array) && params.cibles[type] != undefined)
					{
						var retour = '';
						var dependances = $(this).data('inputSelectDependance');

						jqInputSelect.each(function()
						{
						   	var typeDep = $(this).data('inputSelectType');

						   	if (typeDep != undefined && typeDep != '' && typeof(dependances) == 'object' && (dependances instanceof Array) && dependances[typeDep] != undefined)
						   	{
						   	   	var param = $(this).inputSelectRecupererRetour();
								if (param != '')
								{
						   	   		if (retour !== '')
						   	   			retour += '&';
						   	   		retour += param;
						   	   	}
						   	}
						});

						$(this).inputSelectRechargement(retour);
					}
				});
			}
		},

		activer = function(jqBouton)
		{
			if (jqBouton.data('jqInputButtonVerouiller') != 1)
				jqBouton.stop(true, true).css('cursor', 'pointer').Clignoter({}, 40 , false).data('jqInputButtonActif', 1);
		},

		desactiver = function(jqBouton, attente)
		{
			if (jqBouton.data('jqInputButtonVerouiller') != 1)
			{
				jqBouton.stop(true, true).Clignoter({}, 40 , true).data('jqInputButtonActif', 0);
				if (attente === true)
					jqBouton.css('cursor', 'wait');
				else
				   	jqBouton.css('cursor', 'not-allowed');
			}
		},

		verouiller = function(jqBouton, enfants)
		{
			jqBouton.data('jqInputButtonVerouiller', 1);

			if (enfants == true)
			{
				var cadre = jqBouton.data('jqInputButtonListener');

				if (cadre != undefined && cadre != '')
				{
					jqListener = $('#' + cadre);
					jqListener.find('.jq_input_form').each(function()
					{
						if ($(this).hasClass('jq_input_text') == true)
							$(this).inputTextActiver(false);
						else if ($(this).hasClass('jq_input_select') == true)
							$(this).inputSelectActiver(false);
						else if ($(this).hasClass('jq_input_checkbox') == true)
							$(this).inputCheckboxActiver(false);
						else if ($(this).hasClass('jq_input_file') == true)
							$(this).inputFileActiver(false);
						else if ($(this).hasClass('jq_input_new') == true)
							$(this).inputNewActiver(false);
						else if ($(this).hasClass('jq_input_liste') == true)
							$(this).inputListeActiver(false);
						else if ($(this).hasClass('jq_input_listedb') == true)
							$(this).inputListeDoubleActiver(false);
						else if ($(this).hasClass('jq_input_button') == true)
							$(this).inputButtonActiver(false);
					});
				}
			}
		},

		deverouiller = function(jqBouton, enfants)
		{
			if (enfants == true && jqBouton.data('jqInputButtonVerouiller') == 1)
			{
				jqBouton.data('jqInputButtonVerouiller', 0);

				var cadre = jqBouton.data('jqInputButtonListener');

				if (cadre != undefined && cadre != '')
				{
					jqListener = $('#' + cadre);
					jqListener.find('.jq_input_form').each(function()
					{
						if ($(this).hasClass('jq_input_text') == true)
							$(this).inputTextActiver(true);
						else if ($(this).hasClass('jq_input_select') == true)
							$(this).inputSelectActiver(true);
						else if ($(this).hasClass('jq_input_checkbox') == true)
							$(this).inputCheckboxActiver(true);
						else if ($(this).hasClass('jq_input_file') == true)
							$(this).inputFileActiver(true);
						else if ($(this).hasClass('jq_input_new') == true)
							$(this).inputNewActiver(true);
						else if ($(this).hasClass('jq_input_liste') == true)
							$(this).inputListeActiver(true);
						else if ($(this).hasClass('jq_input_listedb') == true)
							$(this).inputListeDoubleActiver(true);
						else if ($(this).hasClass('jq_input_button') == true && $(this) != jqBouton)
							$(this).inputButtonActiver(true);
					});
				}
			}
			else
				jqBouton.data('jqInputButtonVerouiller', 0);
		},

		reActiver = function(jqBouton, jqElem)
		{
			jqBouton.removeAttr('id');
			jqBouton.find('td').html(jqBouton.data('jqInputButtonValeur'));
			deverouiller(jqBouton, true);
			if (jqElem == undefined || verifierValiditeFormulaire(jqElem, jqBouton) == true)
				activer(jqBouton);
		};

		// Var globale d'ou le ';' plus haut.
		pointsCligno = function(idBouton)
		{
			jqBouton = $('#' + idBouton);
			var id = jqBouton.attr('id');
			if (id == undefined || id == null || id ==  '')
				clearInterval(timersButton[idBouton]);

			jqBouton.find('.point3').fadeTo(200, 0, function()
			{
				jqBouton.find('.point2').fadeTo(200, 0, function()
				{
					jqBouton.find('.point1').fadeTo(200, 0, function()
					{
						jqBouton.find('.point1').fadeTo(200, 1, function()
						{
							jqBouton.find('.point2').fadeTo(200, 1, function()
							{
								jqBouton.find('.point3').fadeTo(200, 1);
							});
						});
					});
				});
			});
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_form') == false)
					{
						if ($(this).hasClass('jq_input_button') == false)
							$(this).addClass('jq_input_button');

						var bouton = $(this);

						if (bouton.hasClass(options.classeBoutonAjax) == true)
						{
							bouton.data('jqInputButtonAjax', 1);
							bouton.removeClass(options.classeBoutonAjax);
						}
						else
						   	bouton.data('jqInputButtonAjax', 0);

						bouton.find(options.selectorBouton).css('white-space', 'nowrap');
						bouton.find(options.selectorBouton).css('text-align','center');
						bouton.css('text-align','center');

						bouton.data('jqInputButtonActif', 1);
						bouton.data('jqInputButtonVerouiller', 0);
						bouton.data('jqInputButtonFonction', $.trim(bouton.find(options.selectorFonction).text()));
						bouton.disableSelection();

						bouton.data('jqInputButtonParam', $.trim(bouton.find(options.selectorParam).text()));

						bouton.data('jqInputButtonValeur', $.trim(bouton.find('td').text()));
						bouton.find(options.selectorValeurOnClick).css('white-space', 'nowrap');
						bouton.data('jqInputButtonValeurOnClick', $.trim(bouton.find(options.selectorValeurOnClick).text()));

						if (options.resetOnClick === true || bouton.hasClass(options.classeBoutonReset) == true)
							bouton.data('jqInputButtonReset', 1);
						else
							bouton.data('jqInputButtonReset', 0);

						bouton.data('jqInputButtonNextReset', 1);

						bouton.addClass('jq_input_form');
						var cadre = $.trim(bouton.find(options.selectorCadre).text());
						var listener = null;

						if (cadre != '')
						   	listener = $('#' + cadre);

						if (listener != null)
						{
						   	listener.addClass(options.classeListener).data('inputFormVal', parseInt(Math.random() * 100000));
							bouton.data('jqInputButtonListener', cadre);
						   	listener.bind('changeEtatInput', function(e)
							{
								if (verifierValiditeFormulaire($(this), bouton, options) == false)
								{
									if (bouton.data('jqInputButtonActif') == 1)
										desactiver(bouton);
								}
								else
								{
									if (bouton.data('jqInputButtonActif') == 0)
										activer(bouton);
								}

								e.stopPropagation();
							});

							listener.unbind('eventForm');
							listener.bind('eventForm', function(e, params)
							{
								traiterEventForm($(this), params);
								e.stopPropagation();
							});
						}

						bouton.css('cursor', 'pointer');

						bouton.mousedown(function(e)
						{
						   	if (bouton.closest('.jq_visualiseur_vue').length == 0)
								e.stopPropagation();

						   	bouton.data('inputButtonAppuye', 1);
						   	bouton.one('mouseup', function()
							{
							   	bouton.data('inputButtonAppuye', 0);
							});
						});

						bouton.mouseup(function(e)
						{
						   	if (bouton.closest('.jq_visualiseur_vue').length == 0)
								e.stopPropagation();

						   	if (bouton.data('inputButtonAppuye') == 1)
						   	{
								if (listener != null)
								{
									listener.trigger('changeEtatInput');

									if (bouton.data('jqInputButtonActif') == 1)
										onClick(bouton, listener);

									listener.find('.jq_form_erreur'+cadre).slideUp(300, function() { $(this).find('td').html(''); });
								}
								else
								{
								   	var param = bouton.data('jqInputButtonParam');
								   	var fonction = bouton.data('jqInputButtonFonction');
								   	if (bouton.data('jqInputButtonAjax') == 1)
									   	clickBoutonAjax(bouton);
									else
									{
										if (param == undefined)
											param = '';
				   	   	   	   	   	   	if (fonction != '' && fonction != undefined)
										   	eval(fonction + '(' + param + ');');
										else if (bouton.closest('.jq_visualiseur_vue').length == 1)
										{
										   	clickBoutonAjax(bouton, '', true);
											setTimeout(function()
											{
												reActiver(bouton);
											}, 5000);
										}
									}
								}
							}
						});

						bouton.mouseenter(function()
					   	{
					   	   	if (bouton.data('jqInputButtonActif') != 0)
					   	   	   	bouton.Clignoter({}, 30, true);
					   	});

					   	bouton.mouseleave(function()
					   	{
					   	   	$(this).Clignoter({}, 30, false);
					   	});
						//bouton.Clignoter({declenchement: 'mouseenter'}, 30).css('cursor', 'pointer');

						bouton.find(options.selectorCadre).remove();
						bouton.find(options.selectorFonction).remove();
						bouton.find(options.selectorParam).remove();
						var width = bouton.width();
						bouton.find(options.selectorValeurOnClick).remove();

						var offsetWidth = 0;
						if (bouton.parent().css('width') != '100%')
							offsetWidth = 30;

						bouton.width(width + offsetWidth);

						if (listener != null)
						{
						   	bouton.mouseenter(function()
							{
								verifierValiditeFormulaire(listener, bouton, options, true);
							});

							listener.css('position', 'relative');
							var erreur = listener.find('.jq_form_erreur'+cadre);
							erreur.css('position', 'absolute').width(listener.innerWidth());
							var padding = erreur.outerWidth() - listener.outerWidth();
							erreur.css('left', '0').width(erreur.width()-padding).slideUp();
						}
					}
				});
			},

			reset: function ()
			{
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_button') && $(this).data('jqInputButtonReset') == 1)
					{
					   	if ($(this).data('jqInputButtonNextReset') == 1)
					   	{
							var cadre = $(this).data('jqInputButtonListener');

							if (cadre != undefined && cadre != '')
							{
								listener = $('#' + cadre);
								listener.find('.jq_input_form').each(function()
								{
									if ($(this).hasClass('jq_input_text') == true)
										$(this).inputTextReset();
									else if ($(this).hasClass('jq_input_select') == true)
										$(this).inputSelectReset();
									else if ($(this).hasClass('jq_input_checkbox') == true)
										$(this).inputCheckboxReset();
									else if ($(this).hasClass('jq_input_file') == true)
										$(this).inputFileReset();
									else if ($(this).hasClass('jq_input_new') == true)
										$(this).inputNewReset();
									else if ($(this).hasClass('jq_input_liste') == true)
										$(this).inputListeReset();
									else if ($(this).hasClass('jq_input_listedb') == true)
										$(this).inputListeDoubleReset();
								});

								listener.find('.jq_input_image').each(function()
								{
								   	$(this).inputImageReset();
								});
							}
						}
						else
						   	$(this).data('jqInputButtonNextReset', 1);
					}
				});
			},

			pret: function ()
			{
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_button'))
					{
						var cadre = $(this).data('jqInputButtonListener');

						if (cadre != undefined && cadre != '')
						{
							var listener = $('#' + cadre);
							reActiver($(this), listener);
						}
						else
						   	reActiver($(this));
						$(this).css('cursor', 'pointer');
					}
				});
			},

			activer: function (on)
			{
				return this.each(function ()
				{
					if (on != false)
					{
						var cadre = $(this).data('jqInputButtonListener');

						if (cadre != undefined && cadre != '')
						{
							var listener = $('#' + cadre);
							reActiver($(this), listener);
						}
						else
						{
							deverouiller($(this), false);
							activer($(this));
						}
					}
					else
					{
						desactiver($(this));
						verouiller($(this));
					}
				});
			},

			dissocierSousForm: function ()
			{
				return this.each(function ()
				{
					/*if ($(this).hasClass('jq_input_button'))
					{
						var rand = parseInt(Math.random() * 100000);
						var cadre = $(this).data('jqInputButtonListener');

						if (cadre != undefined && cadre != '')
						{
							var listener = $('#' + cadre);
							listener.data('inputFormVal', rand);
							/*listener.find('.jq_input_form').each(function()
							{
								var val = $(this).data('inputFormVal');
								if (val == undefined)
									val = 0;
								val = parseInt(val);
								if (isNaN(val))
									val = 0;

								$(this).data('inputFormVal', val + rand);
							});*//*
						}
					}*/
				});
			},

			initialiserEtat: function ()
			{
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_button'))
					{
						var cadre = $(this).data('jqInputButtonListener');

						if (cadre != undefined && cadre != '')
						{
							var listener = $('#' + cadre);
							listener.trigger('changeEtatInput');
						}
						/*else
						{
							deverouiller($(this), false);
							activer($(this));
						}*/
					}
				});
			},

			notifNewSelect: function (id, libelle, description, categorie)
			{
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_button'))
					{
						var donnees =
						{
							id: id,
							libelle: libelle,
							description: description,
							categorie: categorie
						};

						$(this).trigger('newElemSelect', donnees);
					}
				});
			},

			notifNewText: function (libelle)
			{
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_button'))
					{
						var donnees =
						{
							libelle: libelle
						};

						$(this).trigger('newText', donnees);
					}
				});
			},

			notifErreur: function (libelle)
			{
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_button'))
					{
						var cadre = $(this).data('jqInputButtonListener');

						if (cadre != undefined && cadre != '')
						{
							var listener = $('#' + cadre);

							var erreur = listener.find('.jq_form_erreur'+cadre+':first');
							var erreurAffichee = false;
							erreur.each(function()
							{
							   	erreurAffichee = true;
								var html = erreur.find('td:first').html();
								if (html != null && html != '')
								   	html += '<br/>';
								else
								   	html = '';
								erreur.find('td:first').html(html + libelle);
								erreur.slideDown(300);
							});

							if (erreurAffichee === false)
								$(this).trigger('erreurPop', libelle);

							$(this).data('jqInputButtonNextReset', 0);
						}
					}
				});
			},

			init: function ()
			{
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_button'))
					{
						var cadre = $(this).data('jqInputButtonListener');

						if (cadre != undefined && cadre != '')
						{
							var listener = $('#' + cadre);
							listener.trigger('changeEtatInput');
						}
					}
				});
			},

			setClignotement: function ()
			{
			   	var options = $.extend({}, defaults, options || {});

				return this.each(function ()
				{
				   	if ($(this).data('jqInputButtonVerouiller') == 1 || $(this).data('jqInputButtonActif') == 0)
						$(this).stop(true, true).Clignoter({}, 40 , true);
				});
			},

			setDimensions: function ()
			{
			   	var options = $.extend({}, defaults, options || {});

				return this.each(function ()
				{
				   	$(this).width('');
				   	var width = $(this).width();
					$(this).find(options.selectorValeurOnClick).remove();

					var offsetWidth = 0;
					if ($(this).parent().css('width') != '100%' && $(this).parent().css('width') != 'auto')
					{
						offsetWidth = 30;
						$(this).width(width + offsetWidth);
					}
				});
			},

			cliqueFactice: function ()
			{
			   	var options = $.extend({}, defaults, options || {});

				return this.each(function ()
				{
				   	clickBoutonAjax($(this), '', true);
				   	reActiver($(this));
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputButton: inputButton.construct,
		inputButtonReset: inputButton.reset,
		inputButtonPret: inputButton.pret,
		inputButtonActiver: inputButton.activer,
		inputButtonDissocierSousForm: inputButton.dissocierSousForm,
		inputButtonInitialiserEtat: inputButton.initialiserEtat,
		inputButtonNotifNewSelect: inputButton.notifNewSelect,
		inputButtonNotifNewText: inputButton.notifNewText,
		inputButtonNotifErreur: inputButton.notifErreur,
		inputButtonInitialiser: inputButton.init,
		inputButtonSetClignotement: inputButton.setClignotement,
		inputButtonSetDimensions: inputButton.setDimensions,
		inputButtonCliqueFactice: inputButton.cliqueFactice
	});
})(jQuery)

