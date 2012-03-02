(function ($)
{
	var classeur = function()
	{
		var
		defaults =
		{
			selectorOngletModele: '.jq_classeur_ongletmodele',
			selectorOnglets: '.jq_classeur_onglets',
			selectorContenu: '.jq_classeur_contenu',
			selectorId: '.jq_classeur_id'
		},

		init = function(jqElem, options)
		{
		   	if (jqElem.hasClass('jq_classeur') == false)
				jqElem.addClass('jq_classeur');

			jqElem.data('classeurLargeur', jqElem.parent().width());
			var jqId = jqElem.find(options.selectorId);
			jqElem.data('classeurId', $.trim(jqId.text()));
			jqId.remove();

			jqElem.data('classeurNbOnglets', 0);
		},

		initOnglets = function(jqOnglets, options)
		{
		   	if (jqOnglets.hasClass('jq_classeur_onglets') == false)
				jqOnglets.addClass('jq_classeur_onglets');

			var jqOngletModele = jqOnglets.find(options.selectorOngletModele);

			if (jqOngletModele.hasClass('jq_classeur_ongletmodele') == false)
				jqOngletModele.addClass('jq_classeur_ongletmodele');

			jqOngletModele.hide();
		},

		initContenu = function(jqContenu, options)
		{
		   	if (jqContenu.hasClass('jq_classeur_contenu') == false)
				jqContenu.addClass('jq_classeur_contenu');
		},

		initOnglet = function(jqOnglet, jqElem, contenu, fonctionChargement, param, charge, activer)
		{
		   	jqOnglet.removeClass('jq_classeur_ongletmodele');
			jqOnglet.addClass('jq_classeur_onglet');

			jqOnglet.data('classeurContenu', contenu);
			jqOnglet.data('classeurFoncCharg', fonctionChargement);
			jqOnglet.data('classeurCharge', charge);
			jqOnglet.disableSelection().css('cursor', 'pointer').Clignoter({declenchement: 'mouseenter'}, 30);
			jqOnglet.data('classeurOngletActif', 0);
			jqOnglet.data('donnees', param);
			jqElem.data('classeurNbOnglets', jqElem.data('classeurNbOnglets') + 1);
			jqOnglet.data('classeurOngletNum', jqElem.data('classeurNbOnglets'));

			jqOnglet.click(function()
		   	{
		   	   	var rechargementOnglet = false;
		   	   	if (jqOnglet.data('classeurActif') != 1)
				{
			   	   	var jqContenu = jqElem.find('.jq_classeur_contenu');
			   	   	jqContenu.css('position', 'relative');

			 	 	jqElem.find('.jq_classeur_onglets:first').find('.jq_classeur_onglet').each(function()
			   	   	{
			   	   	   	if ($(this).data('classeurOngletActif') === 1 && jqOnglet.data('classeurOngletNum') != $(this).data('classeurOngletNum'))
			   	   	   	{
			   	   	   	   	var jqOngletContenu = $(this).data('classeurContenu');
						 	if (jqOngletContenu != undefined && jqOngletContenu != '')
						 	   	jqOngletContenu.hide();
			   	   	   		$(this).stop(true, true).css('cursor', 'pointer').Clignoter({}, 40 , false).data('classeurOngletActif', 0);
			   	   	   	}
			   	   	   	else if ($(this).data('classeurOngletActif') === 1 && jqOnglet.data('classeurOngletNum') == $(this).data('classeurOngletNum'))
			   	   	   	   	rechargementOnglet = true;
			   	   	});

			   	   	if (jqOnglet.data('classeurCharge') != 1)
					   	jqOnglet.data('classeurCharge', 1);

					var fonction = $.trim(jqOnglet.data('classeurFoncCharg'));
			   	   	if (fonction != '')
						eval(fonction + '.call(jqOnglet.get(0));');

					if (rechargementOnglet === false)
					{
				 	 	jqOnglet.data('classeurOngletActif', 1);
				   	   	activerOnglet(jqOnglet, jqElem);
				   	}
			   	}
		   	});

		   	if (jqElem.data('classeurActif') != 1 || activer == 1)
			{
			   	jqElem.data('classeurActif', 1);
				jqOnglet.click();
			}
		},

		activerOnglet = function(jqOnglet, jqElem)
		{
		   	if (jqOnglet.data('classeurOngletActif') === 1)
			{
			 	var jqOngletContenu = jqOnglet.data('classeurContenu');
			 	if (jqOngletContenu != undefined && jqOngletContenu != '')
			 	   	jqOngletContenu.show();
			   	jqOnglet.stop(true, true).css('cursor', 'default').Clignoter({}, 40 , true);
			}
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).data('classeur') != 1)
					{
					   	var elem = $(this);
					   	elem.data('classeur', 1);
					   	onglets = $(this).find(options.selectorOnglets);
					   	contenu = $(this).find(options.selectorContenu);

						init(elem, options);

						onglets.each(function()
						{
						   	initOnglets($(this), options);
						});

						contenu.each(function()
						{
						   	initContenu($(this), options);
						});
					}
				});
			},

			ajouterOnglet: function (nom, contenu, fonctionChargement, param, charge, activer)
			{
			   	var jqOnglets = $(this).find('.jq_classeur_onglets');
				var jqOngletModele = jqOnglets.find('.jq_classeur_ongletmodele');
			   	var jqDernierOnglet = jqOngletModele;

			   	jqOnglets.find('.jq_classeur_onglet').each(function()
			   	{
			   	   	jqDernierOnglet = $(this);
			   	});

			   	var jqOnglet = jqOngletModele.clone();
			   	jqDernierOnglet.after(jqOnglet);
			   	jqOnglet.find('td').css('white-space', 'nowrap');
			   	jqOnglet.find('td').html(nom);
			   	jqOnglet.show();
			   	jqOnglet.find('.jq_clignotant').andSelf().removeClass('jq_clignotant');

				// Changement de ligne.
				if ($(this).data('classeurLargeur') !== $(this).parent().width())
			   	{
			   	  	jqOnglet.remove();
			   	   	jqOnglet = jqOngletModele.clone();
			   	   	jqOnglet.find('.jq_clignotant').ClignoterReinitialiser();
		   	   		jqOnglet.find('.jq_clignotant_fininit').removeClass('jq_clignotant_fininit');
			   	   	//jqOnglet.find('.jq_clignotant').andSelf().removeClass('jq_clignotant');
			   	    var jqLigne = $(document.createElement('tr'));
			   	   	jqLigne.get(0).appendChild(jqOnglet.get(0));
			   	   	var jqTable = $(document.createElement('table'));
			   	   	jqTable.get(0).appendChild(jqLigne.get(0));
			   	   	jqDerniereLigne = jqOngletModele.parent().parent().parent();
					jqDerniereLigne.siblings().each(function()
					{
					    jqDerniereLigne = $(this);
					});
					jqDerniereLigne.after(jqTable);
					jqDerniereLigne.css('width', '100%');
			   	   	jqTable.attr('cellpadding', 0);
			   	   	jqTable.attr('cellspacing', 0);
			   	   	jqOnglet.find('td').css('white-space', 'nowrap');
			   	   	jqOnglet.find('td').html(nom);
			   	   	jqOnglet.show();
			   	}

			   	initOnglet(jqOnglet, $(this), contenu, fonctionChargement, param, charge, activer);

				return jqOnglet;
			},

			ajouterContenuOnglet: function (jqOnglet, contenu)
			{
			   	if ($(this).data('classeur') == 1)
				{
				   	var jqContenu = $(this).find('.jq_classeur_contenu');
				   	var jqOngletContenu = jqOnglet.data('classeurContenu');
				   	if (jqOngletContenu == undefined || jqOngletContenu == '')
					{
					   	jqContenu.find('td:first').append('<div class="jq_classeur_ongletcontenu" style="position: relative;"></div>');
						var jqLastOngletContenu = jqContenu.find('td:first').children('.jq_classeur_ongletcontenu:last');
						jqLastOngletContenu.html(contenu);
					    jqOnglet.data('classeurContenu', jqLastOngletContenu);
					    jqLastOngletContenu.hide();
					}
					else
					{
					   	jqOngletContenu.html('');
					   	jqOngletContenu.append(contenu);
					   	jqOngletContenu.html(jqOngletContenu.html());
					}
				    activerOnglet(jqOnglet, $(this));
				    return jqOnglet;
				}
				return null;
			},

			resetVisibiliteOnglet: function(jqOnglet)
			{
			   	var jqOngletContenu = jqOnglet.data('classeurContenu');
				if (jqOngletContenu != undefined && jqOngletContenu != '')
				{
					if (jqOnglet.data('classeurOngletActif') === 1)
					 	jqOngletContenu.show();
					else
					   	jqOngletContenu.hide();
				}
			},

			recharger: function()
			{
			   	$(this).find('.jq_classeur_onglets:first').find('.jq_classeur_onglet').each(function()
			   	{
			   	   	if ($(this).data('classeurOngletActif') == 1)
			   	   	   	$(this).click();
			   	});
			}
		};
	}();
	$.fn.extend(
	{
		classeur: classeur.construct,
		classeurAjouterOnglet: classeur.ajouterOnglet,
		classeurAjouterContenuOnglet: classeur.ajouterContenuOnglet,
		classeurResetVisibiliteOnglet: classeur.resetVisibiliteOnglet,
		classeurRecharger: classeur.recharger
	});
})(jQuery)