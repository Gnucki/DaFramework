(function ($)
{
	var inputText = function()
	{
		var
		defaults =
		{
			width: '',//'auto',
			classeAutoWidth: 'jq_input_text_autowidth',
			selectorEdit: '.jq_input_text_editval',
			selectorInfo: '.jq_input_text_info',
			selectorErreur: '.jq_input_text_erreur',
			selectorRetour: '.jq_input_text_retour',
			selectorFV: '.jq_input_text_fv', // Format valide.
			selectorCV: '.jq_input_text_cv', // Caractères valides.
			classeDecimal: 'jq_input_text_dec',
			selectorMin: '.jq_input_text_min',
			selectorMax: '.jq_input_text_max',
			caracteresValides: '',//'\^\[\\w \]\*\$',
			formatValide: '',
			obligatoire: false,
			isEnfantInput: false
		},

		init = function(jqElem, options)
		{
		   	if (jqElem.hasClass(options.classeAutoWidth) == true)
		   	   	options.width = 'auto';

			if (options.isEnfantInput != true)
				jqElem.addClass('jq_input_form');

			//jqElem.data('inputText', 1);

			if (options.obligatoire == true && jqElem.hasClass('jq_input_form_oblig') == false)
				jqElem.addClass('jq_input_form_oblig');
			if (jqElem.hasClass('jq_input_text') == false)
				jqElem.addClass('jq_input_text');

			jqElem.data('inputTextErreur', 0);
		},

		initEdit = function(jqEdit, jqElem, options)
		{
		   	if (jqEdit.val() === '- null -')
		   		jqEdit.val('');

		   	jqEdit.data('inputTextCV', options.caracteresValides);
			jqEdit.data('inputTextFV', options.formatValide);
			if (jqEdit.data('inputTextCV') == '')
				jqEdit.data('inputTextCV', $.trim(jqElem.find(options.selectorCV).text()));
			if (jqEdit.data('inputTextFV') == '')
				jqEdit.data('inputTextFV', $.trim(jqElem.find(options.selectorFV).text()));
			jqElem.find(options.selectorCV).remove();
			jqElem.find(options.selectorFV).remove();

			if (jqElem.hasClass(options.classeDecimal) == true)
			{
				jqElem.removeClass(options.classeDecimal)
				jqEdit.data('inputTextDec', 1);

				var min = jqElem.find(options.selectorMin + ':first');
				var max = jqElem.find(options.selectorMax + ':first');

				jqEdit.data('inputTextMin', $.trim(min.text()));
				jqEdit.data('inputTextMax', $.trim(max.text()));

				min.remove();
				max.remove();
			}

			if (options.width == 'auto')
			{
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

				var taille = jqEdit.attr('size');
				if (taille == undefined || taille === 1)
				   	jqEdit.width(jqEdit.parent().innerWidth() - padding);
				else if (jqEdit.offsetParent().css('position') != 'absolute')
				{
				   	var largeur = jqEdit.parent().width();
					jqEdit.attr('size', 1);
					if (jqEdit.parent().width() < largeur)
					{
					   	for (i=0; i < jqEdit.get(0).attributes.length; i++)
						{
							if (jqEdit.get(0).attributes[i].nodeName == 'size')
							   	 jqEdit.get(0).attributes[i].nodeValue = '';
						}
						jqEdit.width(jqEdit.parent().innerWidth() - padding);
						//jqEdit.removeAttr('size');
					}
					else
					   	jqEdit.attr('size', taille);
				}

				if (jqEdit.width() > jqEdit.parent().width())
					jqEdit.width(jqEdit.parent().innerWidth() - padding);
			}
			else if (options.width != 'auto' && options.width != '')
				jqEdit.width(parseInt(options.width));

			if (jqEdit.hasClass('jq_input_text_editval') == false)
				jqEdit.addClass('jq_input_text_editval');

			if (jqEdit.val() != '' && verifierFormatTexte(jqEdit) == true)
			{
			   	var animation = true;
			   	if (jqElem.data('inputText') != 1)
			   	   	animation = false;
				jqEdit.Clignoter({animation: animation}, 30, true);
			}

			jqEdit.keypress(function(e)
			{
				verifierValeurTexte(jqEdit, true);
			});

			jqEdit.keyup(function(e)
			{
				var numTouche;

				if (window.event) // IE.
					numTouche = e.keyCode;
				else if (e.which) // Firefox/Opera.
					numTouche = e.which;

				if (numTouche == 13 && this.nodeName.toLowerCase() != 'textarea') // Entrée.
					$(this).blur();

				if (verifierValeurTexte(jqEdit) == true)
				{
					var valeur = $.trim(jqEdit.val());
					jqEdit.trigger('changeEtatInput', valeur);
					if (valeur != null && valeur != undefined && valeur != '' && verifierFormatTexte(jqEdit) == true)
						jqEdit.Clignoter({}, 30, true);
					else
						jqEdit.Clignoter({}, 30, false);
				}
				else
					jqEdit.Clignoter({}, 30, false);
			});

			jqEdit.focus(function()
			{
				if (jqElem.data('inputTextVerouiller') == 1)
					$(this).blur();
			});

			jqEdit.blur(function()
			{
				var valeur = $.trim(jqEdit.val());
				var changementValeur = false;

				if (jqEdit.data('inputTextDec') == 1 && valeur != '' && valeur != undefined)
				{
					var min = jqEdit.data('inputTextMin');
					var max = jqEdit.data('inputTextMax');
					valeur = parseInt(valeur);

					if (min != undefined)
					{
					   	min = parseInt(min);
						if (valeur < min)
						{
						   	valeur = min;
						   	jqEdit.val(valeur);
						   	changementValeur = true;
						}
					}
					if (max != undefined)
					{
					   	max = parseInt(max);
						if (valeur > max)
						{
						   	valeur = max;
						   	jqEdit.val(valeur);
						   	changementValeur = true;
						}
					}
				}

				if (changementValeur == true)
				{
					jqEdit.data('inputTextPrevValue', valeur);
					jqEdit.trigger('changeEtatInput', valeur);
					if (valeur != null && valeur != undefined && valeur != '' && verifierFormatTexte(jqEdit) == true)
						jqEdit.Clignoter({}, 30, true);
					else
						jqEdit.Clignoter({}, 30, false);
				}
			});

			jqEdit.click(function(e)
			{
				e.stopPropagation();
			});

			jqEdit.mouseenter(function()
			{
			   	if (jqElem.inputTextRecupererValeur() === '')
			   	   	$(this).InfoBullePop({type: 'erreur'}, jqElem.find('.jq_input_text_erreur'));
			});
		},

		initErreur = function(jqErreur, options)
		{
			if (jqErreur.hasClass('jq_input_text_erreur') == false)
				jqErreur.addClass('jq_input_text_erreur');
		},

		initRetour = function(jqRetour, jqElem)
		{
			var retour = $.trim(jqRetour.text());

			if (retour == undefined)
				retour = '';

			jqElem.data('inputTextRetour', retour);
			jqRetour.remove();
		},

		verifierValeurTexte = function(jqEdit, avantChangement)
		{
		   	if (jqEdit.get(0).nodeName.toLowerCase() == 'textarea')
		   		return true;

			var retour = true;
			var valeur = $.trim(jqEdit.val());
			var regExp = new RegExp(jqEdit.data('inputTextCV'), 'gi');
			if (valeur != '' && regExp.test(valeur) == false)
			{
				retour = false;
				jqEdit.val(jqEdit.data('inputTextPrevValue'));
			}

			if (jqEdit.data('inputTextDec') == 1 && valeur != '' && valeur != undefined && avantChangement != true)
			{
				var min = jqEdit.data('inputTextMin');
				var max = jqEdit.data('inputTextMax');
				valeur = parseInt(valeur);

				if (min != undefined)
				{
				   	min = parseInt(min);
					if (valeur < min)
					   	retour = false;
				}
				if (max != undefined)
				{
				   	max = parseInt(max);
					if (valeur > max)
					{
					   	valeur = max;
						jqEdit.val(valeur);
					}
				}
			}

			jqEdit.data('inputTextPrevValue', valeur);

			return retour;
		},

		verifierFormatTexte = function(jqEdit)
		{
			var retour = true;

			if (jqEdit.get(0).nodeName.toLowerCase() == 'textarea')
			   	return retour;

			var regExp = new RegExp(jqEdit.data('inputTextFV'), 'gi');
			if (regExp.test($.trim(jqEdit.val())) == false)
				retour = false;

			return retour;
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).data('inputText') != 1)
					{
						var elem = $(this);
						var edit = elem.find(options.selectorEdit);
						var info = elem.find(options.selectorInfo);
						var erreur = elem.find(options.selectorErreur);
						var retour = elem.find(options.selectorRetour);

						erreur.hide();
						info.hide();
						retour.hide();

						init(elem, options);

						edit.each(function()
						{
							initEdit($(this), elem, options);
						});

						erreur.each(function()
						{
							initErreur($(this), options);
						});

						retour.each(function()
						{
							initRetour($(this), elem);
						});

						elem.data('inputTextValDefaut', edit.val());

						edit.InfoBulle({}, info);

						retour.remove();

						$(this).data('inputText', 1);
					}
				});
			},

			recupererValeur: function (reset, valeurReset)
			{
				var valeur = '';

				var jqEdit = $(this).find('.jq_input_text_editval:first');
				if (jqEdit != null && jqEdit != undefined)
				{
					verifierValeurTexte(jqEdit);

					if (verifierFormatTexte(jqEdit) == true)
						valeur = jqEdit.val();

					if (reset == true)
						jqEdit.val(valeurReset);
				}

				if (valeur == undefined || valeur == null)
					valeur = '';

				return $.trim(valeur);
			},

			recupererRetour: function ()
			{
				var retour = $(this).data('inputTextRetour');

				if (retour == undefined || retour == '')
					return '';

				return retour + '=' + inputText.recupererValeur.apply(this);
			},

			fixerValeur: function (valeur)
			{
				return this.each(function()
				{
					var jqEdit = $(this).find('.jq_input_text_editval:first');
					if (jqEdit != null && jqEdit != undefined)
					{
						verifierValeurTexte(jqEdit);
						jqEdit.val(valeur);
						if (jqEdit.val() != '' && verifierFormatTexte(jqEdit) == true)
						{
							var animation = true;
						   	if ($(this).data('inputText') != 1)
						   	   	animation = false;
						  	jqEdit.Clignoter({}, 30, true);
						}
					}
				});
			},

			afficherMessageErreur: function (jqElem)
			{
				$(this).data('inputTextErreur', 1);
				jqElem.InfoBullePop({type: 'erreur'}, $(this).find('.jq_input_text_erreur'));
			},

			effacerMessageErreur: function (jqElem)
			{
				if ($(this).data('inputTextErreur') == 1)
				{
					$(this).data('inputTextErreur', 0);
					jqElem.InfoBulleDepop({type: 'erreur'}, $(this).find('.jq_input_text_erreur'));
					$(this).find('.jq_input_text_edit:first').InfoBulleDepop({type: 'erreur'}, $(this).find('.jq_input_text_erreur'));
				}
			},

			reset: function ()
			{
				return this.each(function ()
				{
					var valeur = $(this).data('inputTextValDefaut');

					if (valeur == undefined)
						valeur = '';

					var jqEdit = $(this).find('.jq_input_text_editval:first');
					if (jqEdit != null && jqEdit != undefined)
					{
						jqEdit.val(valeur);
						jqEdit.keyup();
					}
				});
			},

			activer: function (activer)
			{
				return this.each(function ()
				{
					if (activer != false)
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
					}
				});
			},

			setClignotement: function (activer)
			{
			   	var options = $.extend({}, defaults, options || {});

				return this.each(function ()
				{
				   	var jqEdit = $(this).find('.jq_input_text_editval:first');
					var valeur = $.trim(jqEdit.val());

					if (valeur != null && valeur != undefined && valeur != '' && verifierFormatTexte(jqEdit) == true)
						jqEdit.Clignoter({}, 30, true);
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputText: inputText.construct,
		inputTextAfficherMessageErreur: inputText.afficherMessageErreur,
		inputTextEffacerMessageErreur: inputText.effacerMessageErreur,
		inputTextRecupererValeur: inputText.recupererValeur,
		inputTextRecupererRetour: inputText.recupererRetour,
		inputTextFixerValeur: inputText.fixerValeur,
		inputTextReset: inputText.reset,
		inputTextActiver: inputText.activer,
		inputTextSetClignotement: inputText.setClignotement
	});
})(jQuery)