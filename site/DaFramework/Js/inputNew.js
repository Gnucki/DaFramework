(function ($)
{
	var inputNew = function()
	{
		var
		defaults =
		{
			selectorSelect: '.jq_input_new_select',
			selectorText: '.jq_input_new_text',
			selectorElement: '.jq_input_new_element',
			selectorForm: '.jq_input_new_form',
			selectorDeclencheur: '.jq_input_new_declencheur',
			selectorType: '.jq_input_new_type',
			obligatoire: false
		},

		init = function(jqElem, options)
		{
			if (jqElem.hasClass('jq_input_form') == false)
				jqElem.addClass('jq_input_form');
			if (options.obligatoire == true && jqElem.hasClass('jq_input_form_oblig') == false)
				jqElem.addClass('jq_input_form_oblig');
			if (jqElem.hasClass('jq_input_new') == false)
				jqElem.addClass('jq_input_new');

			var jqSelect = jqElem.find(options.selectorSelect + ':first');
			var jqText = jqElem.find(options.selectorText + ':first');

			if (jqSelect.html() != null)
			{
				jqSelect.inputSelect({isEnfantInput: true});
				jqElem.data('inputNewInputType', 'select');
			}
			else if (jqText.html() != null)
			{
				jqText.inputText({isEnfantInput: true, width: ''});
				jqElem.data('inputNewInputType', 'text');
			}

			jqElem.bind('newElemSelect', function(e, donnees)
			{
				var jqSel = $(this).find('.jq_input_select:first');
				if ($(this).data('inputNewInputType') == 'select')
					jqSel.inputSelectAjouterElement(donnees.id, donnees.libelle, donnees.description, donnees.categorie, true);

				$('.jq_input_select').each(function()
				{
					if (jqSel.data('inputSelectRef') == $(this).data('inputSelectRef'))
						$(this).inputSelectAjouterElement(donnees.id, donnees.libelle, donnees.description, donnees.categorie, false);
				});

				e.stopPropagation();
			});

			jqElem.bind('newText', function(e, donnees)
			{
				if ($(this).data('inputNewInputType') == 'text')
					$(this).find('.jq_input_text:first').inputTextFixerValeur(donnees.libelle);

				e.stopPropagation();
			});
		},

		initElem = function(jqNew, jqElem, options)
		{
			var jqDeclencheur = jqElem.children(options.selectorDeclencheur);
			var jqForm = jqElem.children(options.selectorForm);

			if (jqDeclencheur.hasClass('jq_input_new_declencheur') == false)
				jqDeclencheur.addClass('jq_input_new_declencheur');

			jqDeclencheur.css('cursor', 'pointer');
			jqDeclencheur.disableSelection();

			jqForm.css('position', 'absolute');
			jqForm.find('.jq_fill').fill();

			jqDeclencheur.mousedown(function()
			{
			   	jqElem.data('inputNewDec', 1);
			   	jqDeclencheur.one('mouseup', function()
				{
				   	$(this).data('inputNewDec', 0);
				});
			});

			jqDeclencheur.mouseup(function()
			{
				if (jqNew.data('inputNewVerouiller') != 1 && jqElem.data('inputNewDec') == 1)
				{
					if (jqElem.data('inputNewPop') != 1)
					{
						jqNew.find(options.selectorElement).data('inputNewPop', 0);
						jqElem.data('inputNewPop', 1);
						jqNew.find(options.selectorElement).each(function ()
						{
							form = $(this).find(options.selectorForm+':first');
							declencheur = $(this).find(options.selectorDeclencheur+':first');

							if ($(this).data('inputNewPop') != 1)
							{
								form.fadeOut(300);
								declencheur.Clignoter({}, 30, false);
							}
							else
							{
								form.fadeIn(300);
								declencheur.Clignoter({}, 30, true);
							}
						});
					}
					else
					{
						jqElem.data('inputNewPop', 0);
						jqForm.fadeOut(300);
						jqDeclencheur.Clignoter({}, 30, false);
					}
				}

				jqDeclencheur.fill();
				jqDeclencheur.find('table:first').fill();
			});

			jqForm.bind('inputNewFormFermer', function()
			{
			   	if (jqElem.data('inputNewPop') == 1)
				{
				   	jqElem.data('inputNewPop', 0);
					jqForm.fadeOut(300);
					jqDeclencheur.Clignoter({}, 30, false);
				}
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
						var nouv = $(this);
						var elem = nouv.find(options.selectorElement+':first').siblings().andSelf();

						nouv.find('.jq_input_new').inputNew();

						init(nouv, options);

						elem.each(function()
						{
							initElem(nouv, $(this), options);
						});

						if ($(this).offsetParent().width() < $(this).width())
							elem.width($(this).offsetParent().width());
					}
				});
			},

			ajouterElement: function (id, libelle, description, categorie, activer)
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').inputSelectAjouterElement(id, libelle, description, categorie, activer);

				});
			},

			fixerValeur: function (valeur)
			{
				return this.each(function()
				{
					if ($(this).data('inputNewInputType') == 'text')
						$(this).find('.jq_input_text:first').inputTextFixerValeur(valeur);
				});
			},

			recupererValeur: function (reset, valeurReset)
			{
				if ($(this).data('inputNewInputType') == 'select')
					return $(this).find('.jq_input_select:first').inputSelectRecupererValeur(reset, valeurReset);
				else if ($(this).data('inputNewInputType') == 'text')
					return $(this).find('.jq_input_text:first').inputTextRecupererValeur(reset, valeurReset);
				return '';
			},

			recupererRetour: function ()
			{
				if ($(this).data('inputNewInputType') == 'select')
					return $(this).find('.jq_input_select:first').inputSelectRecupererRetour();
				else if ($(this).data('inputNewInputType') == 'text')
					return $(this).find('.jq_input_text:first').inputTextRecupererRetour();
				return '';
			},

			afficherMessageErreur: function (jqElem)
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').inputSelectAfficherMessageErreur(jqElem);
					else if ($(this).data('inputNewInputType') == 'text')
						$(this).find('.jq_input_text:first').inputTextAfficherMessageErreur(jqElem);
				});
			},

			effacerMessageErreur: function (jqElem)
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').inputSelectEffacerMessageErreur(jqElem);
					else if ($(this).data('inputNewInputType') == 'text')
						$(this).find('.jq_input_text:first').inputTextEffacerMessageErreur(jqElem);
				});
			},

			reset: function ()
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').inputSelectReset();
					else if ($(this).data('inputNewInputType') == 'text')
						$(this).find('.jq_input_text:first').inputTextReset();
				});
			},

			activer: function (activer)
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').inputSelectActiver(activer);
					else if ($(this).data('inputNewInputType') == 'text')
						$(this).find('.jq_input_text:first').inputTextActiver(activer);

					var jqForm = $(this).find('.jq_input_new_form');
					var jqDeclencheur = $(this).find('.jq_input_new_declencheur');
					if (activer != false)
					{
						$(this).data('inputNewVerouiller', 0);
						jqForm.enableSelection();
						jqDeclencheur.Clignoter({}, 40, false);
						jqDeclencheur.css('cursor', 'pointer');
					}
					else
					{
						var jqElem = $(this).find('.jq_input_new_element');
						jqElem.data('inputNewPop', 0);
						$(this).data('inputNewVerouiller', 1);
						jqForm.disableSelection();
						jqForm.hide();
						jqDeclencheur.Clignoter({}, 30, false);
						jqDeclencheur.Clignoter({}, 40, true);
						jqDeclencheur.css('cursor', 'not-allowed');
					}
				});
			},

			cacher: function (activer)
			{
				return this.each(function ()
				{
					$(this).find('.jq_input_new_form').each(function()
					{
						$(this).hide();
					});
				});
			},

			activerRechargement: function (valeur, vidage)
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').inputSelectActiverRechargement();
				});
			},

			setClignotement: function ()
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').inputSelectSetClignotement();
				});
			},

			setDimensions: function ()
			{
				return this.each(function ()
				{
					if ($(this).data('inputNewInputType') == 'select')
						$(this).find('.jq_input_select:first').width('').inputSelectSetDimensions();
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputNew: inputNew.construct,
		inputNewAjouterElement: inputNew.ajouterElement,
		inputNewAfficherMessageErreur: inputNew.afficherMessageErreur,
		inputNewEffacerMessageErreur: inputNew.effacerMessageErreur,
		inputNewRecupererValeur: inputNew.recupererValeur,
		inputNewRecupererRetour: inputNew.recupererRetour,
		inputNewReset: inputNew.reset,
		inputNewActiver: inputNew.activer,
		inputNewCacher: inputNew.cacher,
		inputNewActiverRechargement: inputNew.activerRechargement,
		inputNewSetClignotement: inputNew.setClignotement,
		inputNewSetDimensions: inputNew.setDimensions
	});
})(jQuery)