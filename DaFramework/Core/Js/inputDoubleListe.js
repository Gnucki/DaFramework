(function($)
{
	$.fn.inputListe = function(options, numeroListe) 
	{
		if (options == 'RecupererValeur')
		{
			if (numeroListe == undefined || parseInt(numeroListe) <= 0)
				numeroListe = 1;
			
			var valeur = '';
			
			var jqListe = $(this).find('.jq_input_liste_liste[inputListeNumero='+numeroListe+']');
			if (jqListe != null && jqListe != undefined)
				valeur = jqListe.val();

			if (valeur == undefined || valeur == null)
				valeur = '';
				
			return $.trim(valeur);
		}
		else
		{
			var defaults = 
			{
				selectorListes: '.jq_input_liste_liste',
				selectorListesObligatoires: '.jq_input_liste_liste_oblig',
				listesConnectees: true,
				type: 'listeSimple', 
				obligatoire: true
			};  
		
			var options = $.extend(defaults, options);  
			
			return this.each(function() 
			{
				var edit = $(this).find(options.selectorEdit);
				var idConnexionListes = Math.floor(Math.random()*100000);
				var numeroListe = 0;
				
				_initInputListe($(this), options);
				
				$(this).find(options.selectorListes).each(function()
				{
					numeroListe++;
					_initInputListeListe($(this), options, idConnexionListes, numeroListe);
				});
				
				$(this).find(options.selectorListesObligatoires).each(function()
				{
					numeroListe++;
					_initInputListeListeObligatoire($(this), options, idConnexionListes, numeroListe);
					
					$(this).children().each(function()
					{
						_initInputListeElements($(this), options);
					});
				});
			});
		}
	};
	
	_initInputListe = function(jqListe, options)
	{
		if (jqListe.hasClass('jq_input_form') == false)
			jqListe.addClass('jq_input_form');
		if (jqListe.hasClass('jq_input_liste_liste') == false)
			jqListe.addClass('jq_input_liste_liste');
	};
	
	_initInputListeListe = function(jqListe, options, idConnexionListes, numeroListe)
	{		
		jqListe.sortable( {revert: true} );
		jqListe.disableSelection();
		jqListe.attr('inputListeNumero', numeroListe);
		
		if (options.listesConnectees == true)
		{
			jqListe.attr('inputListeConnexionId', idConnexionListes);
			jqListe.sortable('option','connectWith',options.selectorListes + '[inputListeConnexionId='+idConnexionListes+']');
		}
	};
	
	_initInputListeListeObligatoire = function(jqListe, options, idConnexionListes, numeroListe)
	{
		if (jqListe.hasClass('jq_input_liste_liste_oblig') == false)
			jqListe.addClass('jq_input_liste_liste_oblig');
		
		jqListe.sortable( {revert: true} );
		jqListe.disableSelection();
		jqListe.attr('inputListeNumero', numeroListe);
		
		if (options.listesConnectees == true)
		{
			jqListe.attr('inputListeConnexionId', idConnexionListes);
			jqListe.sortable('option','connectWith',options.selectorListes + '[inputListeConnexionId='+idConnexionListes+']');
		}
	};
	
	_initInputListeElements = function(jqElem, options)
	{
	
	};
})
(jQuery);

$(document).ready(function()
{
	$('.jq_input_doubleliste').inputListe();
});

