(function ($)
{
	var inputCheckbox = function()
	{
		var
		defaults =
		{
			selectorElem: '.jq_input_checkbox_element',
			selectorElemEdit: '.jq_input_checkbox_edit',
			selectorElemDesc: '.jq_input_checkbox_description',
			selectorElemId: '.jq_input_checkbox_id',
			selectorInfo: '.jq_input_checkbox_info',
			selectorErreur: '.jq_input_checkbox_erreur',
			selectorRetour: '.jq_input_checkbox_retour',
			radioMode: false,
			obligatoire: false
		},

		init = function(jqElem, options)
		{
			if (jqElem.hasClass('jq_input_form') == false)
				jqElem.addClass('jq_input_form');
			if (options.obligatoire == true && jqElem.hasClass('jq_input_form_oblig') == false)
				jqElem.addClass('jq_input_form_oblig');
			if (jqElem.hasClass('jq_input_checkbox') == false)
				jqElem.addClass('jq_input_checkbox');

			if (options.radioMode == true)
			{
				jqElem.data('inputCheckboxRadioMode', 1);
				jqElem.bind('changeEtatInput', function(e, valeur)
				{
					jqElem.find(options.selectorElemEdit).each(function()
					{
						if ($(this).data('inputCheckboxRadioActive') == 0 && $(this).data('inputCheckboxChecked') == 1)
							uncheck($(this));
					});
				});
			}
		},

		initElement = function(jqElem, jqInfo, options)
		{
			if (jqElem.hasClass('jq_input_checkbox_element') == false)
				jqElem.addClass('jq_input_checkbox_element');

			jqInfo.hide();

			var jqDesc = jqElem.find(options.selectorElemDesc);
			var info = $.trim(jqDesc.html());
			if (info != '')
				jqElem.data('inputCheckboxInfo', info);
			jqDesc.remove();

			jqElem.find(options.selectorElemEdit).mouseenter(function()
			{
				var info = jqElem.data('inputCheckboxInfo');
				if (info != undefined && info != '')
				{
					jqInfo.find('td').html(info);
					$(this).InfoBullePop({type: 'info'}, jqInfo);
					$(this).InfoBullePop({type: 'erreur'}, jqErreur);
				}
			});

			var jqId = jqElem.find(options.selectorElemId);
			var id = $.trim(jqId.text());
			if (id != '')
				jqElem.data('inputCheckboxId', id);
			jqId.remove();
		},

		initEdit = function(jqEdit, jqElem, options)
		{
			var jqEditVal = jqEdit.find('td:first');
			if (jqEditVal.hasClass('jq_input_checkbox_editval') == false)
				jqEditVal.addClass('jq_input_checkbox_editval');

			if ($.trim(jqEditVal.text()) != '')
			   	jqEdit.addClass('jq_input_checkbox_edit_checkdefault');

			jqEditVal.text('x');
			jqEditVal.css('font-size', '12px');
			jqEditVal.css('font-family', 'verdana');
			jqEditVal.width(0);
			var width = jqEditVal.innerWidth();
			jqEditVal.css('padding-top', '0px');
			jqEditVal.css('padding-left', '0px');
			jqEditVal.css('padding-right', '0px');
			jqEditVal.css('padding-bottom', '0px');
			var height = jqEditVal.innerHeight();
			jqEditVal.css('padding-bottom', (jqEditVal.innerHeight() - parseInt(jqEditVal.css('font-size'))) + 'px');
			var padding = Math.round((jqEditVal.innerHeight() - jqEditVal.innerWidth())/2);
			jqEditVal.css('min-width', width + 'px');
			jqEditVal.css('min-height', height + 'px');
			jqEditVal.css('height', height + 'px');
			jqEditVal.text(' ');
			var ecart = 0;
			if (jqEditVal.height() != height)
				ecart = height - jqEditVal.height();
			jqEditVal.height(height + ecart);
			jqEditVal.css('padding-left', padding + 'px');
			jqEditVal.css('padding-right', padding + 'px');

			jqEdit.css('min-height', jqEdit.width());
			jqEdit.css('max-height', jqEdit.width());

			if (jqEdit.hasClass('jq_input_checkbox_edit_checkdefault') == true)
				check(jqEdit);
			else
				jqEdit.data('inputCheckboxChecked', 0);

			jqEdit.disableSelection();
			jqEdit.css('cursor', 'pointer');

			jqEdit.mousedown(function(e)
			{
			   	$(this).data('inputCheckboxCliquee', 1);
			   	$(this).one('mouseup', function()
				{
				   	$(this).data('inputCheckboxCliquee', 0);
				});
			});

			jqEdit.mouseup(function(e)
			{
				if (jqElem.data('inputCheckboxVerouiller') != 1 && jqEdit.data('inputCheckboxCliquee') == 1)
				{
					if ($(this).data('inputCheckboxChecked') == 0)
					{
						if (options.radioMode == true)
						{
							jqElem.find(options.selectorElemEdit).data('inputCheckboxRadioActive', 0);
							$(this).data('inputCheckboxRadioActive', 1);
						}
						check($(this));
					}
					else if (options.radioMode != true)
						uncheck($(this));

					$(this).trigger('changeEtatInput', $(this).data('inputCheckboxChecked'));
				}

				if (jqElem.closest('.jq_visualiseur_vue').length == 0)
					e.stopPropagation();
			});
		},

		initErreur = function(jqErreur, options)
		{
			if (jqErreur.hasClass('jq_input_checkbox_erreur') == false)
				jqErreur.addClass('jq_input_checkbox_erreur');

			jqErreur.hide();
		},

		initRetour = function(jqRetour, jqElem)
		{
			var retour = $.trim(jqRetour.text());

			if (retour == undefined)
				retour = '';

			jqElem.data('inputTextRetour', retour);
			jqRetour.remove();
		},

		check = function(jqEdit)
		{
			jqEdit.data('inputCheckboxChecked', 1);
			jqEdit.find('td').text('x');
			jqEdit.Clignoter({}, 30, true);
		},

		uncheck = function(jqEdit)
		{
			jqEdit.data('inputCheckboxChecked', 0);
			jqEdit.find('td').text(' ');
			jqEdit.Clignoter({}, 30, false);
		}

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_form') == false)
					{
						var checkbox = $(this);
						var element = checkbox.find(options.selectorElem);
						var edit = checkbox.find(options.selectorElemEdit);
						var info = checkbox.find(options.selectorInfo);
						var erreur = checkbox.find(options.selectorErreur);
						var retour = checkbox.find(options.selectorRetour);

						info.hide();
						erreur.hide();
						retour.hide();
						init(checkbox, options);

						element.each(function()
						{
							initElement($(this), info, options);
						});

						edit.each(function()
						{
							initEdit($(this), checkbox, options);
						});

						erreur.each(function()
						{
							initErreur($(this), options);
						});

						retour.each(function()
						{
							initRetour($(this), checkbox);
						});
					}
				});
			},

			checker: function (coche)
			{
			   	if ($(this).hasClass('jq_input_checkbox') == true)
			   	{
				   	var jqEdit = $(this).find('.jq_input_checkbox_edit');
					if (coche == true)
					   	check(jqEdit);
					else
					   	uncheck(jqEdit);
				}
			},

			recupererValeur: function (reset, valeurReset)
			{
				var valeur = '';

				if ($(this).hasClass('jq_input_checkbox') == true)
			   	{
					$(this).find('.jq_input_checkbox_element').each(function()
					{
						if ($(this).find('.jq_input_checkbox_edit').data('inputCheckboxChecked') == 1)
						{
							valeur = $(this).data('inputCheckboxId');
							if (valeur == undefined || valeur == '')
								valeur = true;
						}
					});
				}

				return valeur;
			},

			recupererRetour: function ()
			{
				var retour = $(this).data('inputTextRetour');

				if (retour == undefined || retour == '')
					return '';

				var valeur = inputCheckbox.recupererValeur.apply(this);

				if (valeur === true)
					valeur = '1';
				else if (valeur == false)
					valeur = '0';

				return retour + '=' + valeur;
			},

			afficherMessageErreur: function (jqElem)
			{
				$(this).data('inputCheckboxErreur', 1);
				jqElem.InfoBullePop({type: 'erreur'}, $(this).find('.jq_input_checkbox_erreur'));
			},

			effacerMessageErreur: function (jqElem)
			{
				if ($(this).data('inputCheckboxErreur') == 1)
				{
					$(this).data('inputCheckboxErreur', 0);
					jqElem.InfoBulleDepop({type: 'erreur'}, $(this).find('.jq_input_checkbox_erreur'));
				}
			},

			reset: function ()
			{
				return this.each(function ()
				{
					var edit = $(this).find(defaults.selectorElemEdit);

					edit.each(function()
					{
						if (edit.hasClass('jq_input_checkbox_edit_checkdefault') == true)
							check(edit);
						else
							uncheck(edit);
					});
				});
			},

			activer: function (activer)
			{
				return this.each(function ()
				{
					if (activer != false)
						$(this).data('inputCheckboxVerouiller', 0);
					else
						$(this).data('inputCheckboxVerouiller', 1);

					var jqEdit = $(this).find('.jq_input_checkbox_edit');
					if (jqEdit != null && jqEdit != undefined)
					{
						if (activer != false)
						{
							jqEdit.css('cursor', 'pointer');
							jqEdit.Clignoter({}, 40, false);
						}
						else
						{
							jqEdit.css('cursor', 'not-allowed');
							jqEdit.Clignoter({}, 40, true);
						}
					}
				});
			},

			setReadOnly: function ()
			{
				return this.each(function ()
				{
				   	if ($(this).hasClass('jq_input_checkbox') == true)
				   	{
				   	   	$(this).data('inputCheckboxVerouiller', 1);

						var jqEdit = $(this).find('.jq_input_checkbox_edit');
						if (jqEdit != null && jqEdit != undefined)
						{
							jqEdit.css('cursor', 'default');
							jqEdit.Clignoter({}, 45, true);
						}
				   	}
				});
			},

			setCurseur: function (curseur)
			{
				return this.each(function ()
				{
				   	if ($(this).hasClass('jq_input_checkbox') == true)
				   	   	$(this).find('.jq_input_checkbox_edit').css('cursor', curseur);
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputCheckbox: inputCheckbox.construct,
		inputCheckboxChecker: inputCheckbox.checker,
		inputCheckboxRecupererValeur: inputCheckbox.recupererValeur,
		inputCheckboxRecupererRetour: inputCheckbox.recupererRetour,
		inputCheckboxAfficherMessageErreur: inputCheckbox.afficherMessageErreur,
		inputCheckboxEffacerMessageErreur: inputCheckbox.effacerMessageErreur,
		inputCheckboxReset: inputCheckbox.reset,
		inputCheckboxActiver: inputCheckbox.activer,
		inputCheckboxSetReadOnly: inputCheckbox.setReadOnly,
		inputCheckboxSetCurseur: inputCheckbox.setCurseur
	});
})(jQuery)