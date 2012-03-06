(function($)
{
	$.fn.inputTrigger = function(options) 
	{
		var defaults = 
		{
			evenement: 'goToSuivant', // Evenement renvoy� par le trigger.
			type: 'click', // Type d'�v�nement qui d�clenche le trigger.
			desactiverSelection: true, // D�sactive la s�lection de l'�l�ment.
			curseur: 'auto', // Type du curseur au survol de l'�l�ment.
			donnees: null // A pr�ciser si besoin!
		};  
	
		var options = $.extend(defaults, options);

		return this.each(function() 
		{
			$(this).css('cursor', options.curseur);
			
			if (options.desactiverSelection == true)
				$(this).disableSelection();
			
			if (options.type == 'click')
			{
				$(this).click(function(event)
				{
					event.stopPropagation();
					$(this).trigger(options.evenement, options.donnees);
				});
				
				$(this).mousedown(function(event)
				{
					event.stopPropagation();
				});
			}
		});
	};
})
(jQuery);

