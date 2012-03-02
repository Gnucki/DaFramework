(function ($)
{
	var inputListeDouble = function()
	{
		var
		defaults =
		{
			selectorInfo: '.jq_input_listedb_info',
			selectorErreur: '.jq_input_listedb_erreur',
			selectorRetour: '.jq_input_listedb_retour',
			selectorListeDispo: '.jq_input_listedb_dispo',
			selectorListeSel: '.jq_input_listedb_sel',
			obligatoire: false
		},

		init = function(jqElem, options)
		{
		   	jqElem.addClass('jq_input_form');
			if (options.obligatoire == true && jqElem.hasClass('jq_input_form_oblig') == false)
				jqElem.addClass('jq_input_form_oblig');
			if (jqElem.hasClass('jq_input_listedb') == false)
				jqElem.addClass('jq_input_listedb');

			jqElem.data('inputListeDoubleErreur', 0);

			var jqDispo = jqElem.find(options.selectorListeDispo + ':first');
			var jqSel = jqElem.find(options.selectorListeSel + ':first');
			jqDispo.closest('td').css('vertical-align', 'top');
			jqDispo.find('td:first').css('vertical-align', 'top');
			jqSel.closest('td').css('vertical-align', 'top');
			jqSel.find('td:first').css('vertical-align', 'top');
			jqDispo.find('.jq_liste:first').liste();
			jqSel.find('.jq_liste:first').liste();

			jqElem.fill();
			jqElem.find('table:first').fill();
			jqElem.find('td:first').css('vertical-align', 'top');
			jqElem.closest('td').css('vertical-align', 'top');
		},

		initRetour = function(jqRetour, jqElem, options)
		{
		   	jqElem.data('inputListeDbRetour', $.trim(jqRetour.text()));
		   	jqRetour.remove();
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).data('inputListeDouble') != 1)
					{
						var elem = $(this);
						var info = elem.find(options.selectorInfo);
						var erreur = elem.find(options.selectorErreur);
						var retour = elem.find(options.selectorRetour);

						erreur.hide();
						info.hide();
						retour.hide();

						init(elem, options);

						/*erreur.each(function()
						{
							initErreur($(this), options);
						});*/

						retour.each(function()
						{
							initRetour($(this), elem, options);
						});

						/*$(this).InfoBulle({}, info);*/

						elem.data('inputListeDouble', 1);
					}
				});
			},

			recupererValeur: function ()//reset, valeurReset)
			{
			   	var options = $.extend({}, defaults, options || {});
				return $(this).find(options.selectorListeSel + ':first').find('.jq_liste:first').listeRecupererValeur();
			},

			recupererRetour: function ()
			{
			   	var options = $.extend({}, defaults, options || {});
				return $(this).find(options.selectorListeSel + ':first').find('.jq_liste:first').listeRecupererRetour($(this).data('inputListeDbRetour'));
			},

			afficherMessageErreur: function (jqElem)
			{
				$(this).data('inputListeDbErreur', 1);
				jqElem.InfoBullePop({type: 'erreur'}, $(this).find('.jq_input_listedb_erreur:first'));
			},

			effacerMessageErreur: function (jqElem)
			{
				if ($(this).data('inputTextErreur') == 1)
				{
					$(this).data('inputListeDbErreur', 0);
					jqElem.InfoBulleDepop({type: 'erreur'}, $(this).find('.jq_input_listedb_erreur'));
					$(this).find('.jq_input_listedb:first').InfoBulleDepop({type: 'erreur'}, $(this).find('.jq_input_listedb_erreur:first'));
				}
			},

			reset: function ()
			{
				return this.each(function ()
				{
					/*var valeur = $(this).data('inputTextValDefaut');

					if (valeur == undefined)
						valeur = '';

					var jqEdit = $(this).find('.jq_input_text_editval:first');
					if (jqEdit != null && jqEdit != undefined)
					{
						jqEdit.val(valeur);
						jqEdit.keyup();
					}*/
				});
			},

			activer: function (activer)
			{
				return this.each(function ()
				{
					/*if (activer != false)
						$(this).data('inputTextVerouiller', 0);
					else
						$(this).data('inputTextVerouiller', 1);

					var jqEdit = $(this).find('.jq_input_text_editval:first');
					if (jqEdit != null && jqEdit != undefined)
					{
						if (activer != false)
						{
							jqEdit.css('cursor', 'auto');
							jqEdit.enableSelection();
							jqEdit.Clignoter({}, 40, false);
						}
						else
						{
							jqEdit.css('cursor', 'not-allowed');
							jqEdit.disableSelection();
							jqEdit.Clignoter({}, 40, true);
						}
					}*/
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputListeDouble: inputListeDouble.construct,
		inputListeDoubleAfficherMessageErreur: inputListeDouble.afficherMessageErreur,
		inputListeDoubleEffacerMessageErreur: inputListeDouble.effacerMessageErreur,
		inputListeDoubleRecupererValeur: inputListeDouble.recupererValeur,
		inputListeDoubleRecupererRetour: inputListeDouble.recupererRetour,
		inputListeDoubleFixerValeur: inputListeDouble.fixerValeur,
		inputListeDoubleReset: inputListeDouble.reset,
		inputListeDoubleActiver: inputListeDouble.activer
	});
})(jQuery)