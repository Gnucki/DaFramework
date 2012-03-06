(function ($)
{
	var inputFile = function()
	{
		var
		defaults =
		{
			selectorSelect: '.jq_input_file_select',
			selectorNewInput: '.jq_input_file_newinput',
			selectorNewDeclencheur: '.jq_input_file_newdeclencheur',
			//selectorIframeInput: '.jq_input_file_iframeinput',
			globalType: 'image',
			obligatoire: false
		},

		init = function(jqElem, options)
		{
			if (jqElem.hasClass('jq_input_form') == false)
				jqElem.addClass('jq_input_form');
			if (options.obligatoire == true && jqElem.hasClass('jq_input_form_oblig') == false)
				jqElem.addClass('jq_input_form_oblig');
			if (jqElem.hasClass('jq_input_file') == false)
				jqElem.addClass('jq_input_file');

			jqElem.data('inputFileGlobalType', options.globalType);
		},

		initInput = function(jqNew, jqElem, jqDeclencheur, options)
		{
			if (jqDeclencheur.hasClass('jq_input_file_newdeclencheur') == false)
				jqDeclencheur.addClass('jq_input_file_newdeclencheur');

			var jqInput = jqNew.find('input');
			if (jqInput.hasClass('jq_input_file_newinput') == false)
				jqInput.addClass('jq_input_file_newinput');

			jqInput.show();
			jqDeclencheur.find('td').text('+');
			jqDeclencheur.css('cursor', 'pointer');
			jqDeclencheur.css('top', '0');
			jqDeclencheur.disableSelection();

			var jqForm = jqNew.find('form:first');
			jqNew.append('<div class="jq_input_file_iframe"></div>');
			var jqFrame = jqNew.find('.jq_input_file_iframe:first');
			var jqInputSelect = jqElem.find(options.selectorSelect + ':first');

			jqElem.css('position', 'relative');
			jqNew.css('position', 'absolute');
			jqNew.css('overflow', 'hidden');
			jqNew.css('top', '0');
			jqInput.css('font-size', '40px');
			jqNew.width(0);
			jqInput.width(jqDeclencheur.outerWidth());
			jqNew.width('');
			jqNew.height(jqElem.innerHeight());
			jqNew.css('cursor', 'pointer');
			jqInput.css('cursor', 'pointer');
			jqInput.css('opacity', '0');

			jqInput.change(function()
			{
				var id = 'inputFileFrame' + parseInt(Math.random() * 10000);
				jqFrame.html('<iframe id="'+id+'" name="'+id+'" src="#" style="width:0px;height:0px;border:0"></iframe>');
				jqForm.get(0).target = id;
				jqForm.submit();

				jqFrame.find('iframe:first').load(function()
				{
					jqInputSelect.inputSelectRechargement(-1, false);
				});

				//inputFileAttenteRetour.call(jqElem.get(0), id);
				//timersInputFile[id] = setInterval(function () {inputFileAttenteRetour.call(jqElem.get(0), id);}, 200);
			});

			jqInput.click(function(e)
			{
				e.stopPropagation();
				if (jqElem.data('inputFileVerouiller') == 1)
					e.preventDefault();
			});

			jqInput.mousedown(function()
			{
				if (jqElem.data('inputFileVerouiller') != 1)
				{
					jqDeclencheur.Clignoter({}, 30, true);
					$(document).bind('mouseover', jqDeclencheur, declencheurUp);
				}
				else
				{
					e.stopPropagation();
					e.preventDefault();
				}
			});

			jqElem.bind('inputSelectPreRedim', function()
			{
			   	jqNew.height(jqElem.height());
			   	jqDeclencheur.fill();
				jqDeclencheur.find('table:first').fill();

				var padding = 0;
				var pad = 0;

				if (jqElem.find('td:first').css('paddingLeft') != 0)
				{
				   	pad = parseInt(jqElem.find('td:first').css('paddingLeft'));
				   	if (isNaN(pad))
				   		pad = 0;
					padding += pad;
				}
				if (jqElem.find('td:first').css('paddingRight') != 0)
				{
				   	pad = parseInt(jqElem.find('td:first').css('paddingRight'));
				   	if (isNaN(pad))
				   		pad = 0;
					padding += pad;
				}
				if (jqElem.find('td:first').css('borderLeftWidth') != 0)
				{
				   	pad = parseInt(jqElem.find('td:first').css('borderLeftWidth'));
				   	if (isNaN(pad))
				   		pad = 0;
					padding += pad;
				}
				if (jqElem.find('td:first').css('borderRightWidth') != 0)
				{
				   	pad = parseInt(jqElem.find('td:first').css('borderRightWidth'));
				   	if (isNaN(pad))
				   		pad = 0;
					padding += pad;
				}

				jqInputSelect.data('inputSelectEditTailleMax', jqElem.innerWidth() - jqDeclencheur.outerWidth() - padding);
			});

			jqElem.bind('inputSelectPostRedim', function()
			{
			   	jqInput.width(jqDeclencheur.width());
			});

			var isSelectImage = false;
			if (options.globalType == 'image')
			   	isSelectImage = true;
			jqInputSelect.inputSelect({isEnfantInput: true, isSelectImage: isSelectImage});
		},

		declencheurUp = function(e)
		{
			e.data.Clignoter({}, 30, false);
			$(document).unbind('mouseover', declencheurUp);
		};

		// Var globales d'ou le ';' plus haut.
		/*var timersInputFile = new Array();

		var inputFileAttenteRetour = function(idElem)
		{
			var jqElem = $('#' + idElem);
			if (jqElem.html() == null)
				clearInterval(timersInputFile[idElem]);
			var retour = $.trim($(window.frames[idElem].document).text());

			if (retour != undefined && retour != null && retour != '')
			{alert('-');alert(retour);
				clearInterval(timersInputFile[idElem]);
				jqElem.remove();

				if (retour != 'nofichier')
				{
					var i = retour.indexOf(';');
					var id = retour.substring(0, i);
					var j = retour.indexOf(';', i + 1);
					var libelle = retour.substring(i + 1, j);
					i = j;
					j = retour.indexOf(';', i + 1);
					var description = '';
					var categorie = '';
					if (j == -1)
						description = retour.substring(j + 1, retour.length);
					else
					{
						description = retour.substring(i + 1, j);
						categorie = retour.substring(j + 1, retour.length);
					}

					var jqElem = $(this);
					//if (jqElem.data('inputFileGlobalType') == 'image')
						//description = '<img src="'+description+'" style="max-width: 300px, max-height: 300px"/>';

					var jqSel = jqElem.find('.jq_input_select');
					jqSel.inputSelectAjouterElement(id, libelle, description, categorie, true);
					$('.jq_input_select').each(function()
					{
						if (jqSel.data('inputSelectType') == $(this).data('inputSelectType'))
							$(this).inputSelectAjouterElement(id, libelle, description, categorie, false);
					});
				}
			}
		};*/

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_form') == false)
					{
						var elem = $(this);
						var declencheur = elem.find(options.selectorNewDeclencheur);
						var input = elem.find(options.selectorNewInput);

						init(elem, options);

						input.each(function()
						{
							initInput($(this), elem, declencheur, options);
						});
					}
				});
			},

			ajouterElement: function (id, libelle, description, categorie, activer)
			{
				return this.each(function()
				{
					$(this).find('.jq_input_select:first').inputSelectAjouterElement(id, libelle, description, categorie, activer);
				});
			},

			fixerValeur: function (id)
			{
			   	return this.each(function()
				{
				   	$(this).find('.jq_input_select:first').inputSelectFixerValeur(id);
				});
			},

			recupererValeur: function (reset, valeurReset)
			{
				return $(this).find('.jq_input_select:first').inputSelectRecupererValeur(reset, valeurReset);
			},

			recupererRetour: function ()
			{
				return $(this).find('.jq_input_select:first').inputSelectRecupererRetour();
			},

			afficherMessageErreur: function (jqElem)
			{
				return this.each(function ()
				{
					$(this).find('.jq_input_select').inputSelectAfficherMessageErreur(jqElem);
				});
			},

			effacerMessageErreur: function (jqElem)
			{
				return this.each(function ()
				{
					$(this).find('.jq_input_select').inputSelectEffacerMessageErreur(jqElem);
				});
			},

			reset: function ()
			{
				return this.each(function ()
				{
					$(this).find('.jq_input_select').inputSelectReset();
				});
			},

			activer: function (activer)
			{
				return this.each(function ()
				{
					$(this).find('.jq_input_select').inputSelectActiver(activer);

					var jqInput = $(this).find('.jq_input_file_newinput');
					var jqDeclencheur = $(this).find('.jq_input_file_newdeclencheur');
					if (activer != false)
					{
						$(this).data('inputFileVerouiller', 0);
						jqInput.show();
						jqInput.enableSelection();
						jqDeclencheur.Clignoter({}, 40, false);
						jqDeclencheur.css('cursor', 'pointer');
					}
					else
					{
						$(this).data('inputFileVerouiller', 1);
						jqInput.hide();
						jqInput.disableSelection();
						jqDeclencheur.Clignoter({}, 40, true);
						jqDeclencheur.css('cursor', 'not-allowed');
					}
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputFile: inputFile.construct,
		inputFileAjouterElement: inputFile.ajouterElement,
		inputFileAfficherMessageErreur: inputFile.afficherMessageErreur,
		inputFileEffacerMessageErreur: inputFile.effacerMessageErreur,
		inputFileFixerValeur: inputFile.fixerValeur,
		inputFileRecupererValeur: inputFile.recupererValeur,
		inputFileRecupererRetour: inputFile.recupererRetour,
		inputFileReset: inputFile.reset,
		inputFileActiver: inputFile.activer
	});
})(jQuery)