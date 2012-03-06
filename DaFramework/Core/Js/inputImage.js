(function ($)
{
	var inputImage = function()
	{
		var
		defaults =
		{
			selectorFile: '.jq_input_image_file',
			selectorImage: '.jq_input_image_image',
			globalType: 'image',
			obligatoire: false
		},

		init = function(jqElem, options)
		{
			if (jqElem.hasClass('jq_input_image') == false)
				jqElem.addClass('jq_input_image');

			jqElem.data('inputImage', 1);

			var jqInputFile = jqElem.find(options.selectorFile+':first');
			var jqInputSelect = jqInputFile.find(options.selectorSelect + ':first');
			jqInputFile.inputFile({globalType: options.globalType});
			var jqImage = jqElem.find(options.selectorImage+':first');
			jqImage.width(jqImage.parent().innerWidth());
			//jqImage.width(jqElem.width());

			jqInputFile.bind('changeEtatInput', function(e, src)
			{
			   	jqImage.parent().height('');
			   	jqImage.parent().height(jqImage.parent().height());
			   	if (src === '')
			   		jqImage.hide();
			   	else
			   	   	jqImage.show();
			   	jqImage.attr('src', src);
			   	jqImage.trigger('redimensionnerChampsListe');
			});

			if (jqImage.attr('src') == '')
				jqImage.hide();

			jqElem.data('inputFileGlobalType', options.globalType);

			jqImage.load(function()
			{
			   	$(this).trigger('redimensionnerChampsListe');
			});
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).data('inputImage') != 1)
						init($(this), options);
				});
			},

			fixerValeur: function (valeur)
			{
				return this.each(function()
				{
					$(this).find('.jq_input_select:first').inputSelectFixerValeurFromDesc(valeur);
				});
			},

			reset: function (valeur)
			{
				return this.each(function()
				{
					$(this).find('.jq_input_select:first').inputSelectReset();
				});
			}
		};
	}();
	$.fn.extend(
	{
		inputImage: inputImage.construct,
		inputImageFixerValeur: inputImage.fixerValeur,
		inputImageReset: inputImage.reset
	});
})(jQuery)