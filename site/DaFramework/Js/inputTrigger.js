(function($)
{
	$.fn.inputTrigger = function(options) 
	{
		var defaults = 
		{
			evenement: 'goToSuivant', // Evenement renvoyé par le trigger.
			type: 'click', // Type d'événement qui déclenche le trigger.
			desactiverSelection: true, // Désactive la sélection de l'élément.
			curseur: 'auto', // Type du curseur au survol de l'élément.
			donnees: null // A préciser si besoin!
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

