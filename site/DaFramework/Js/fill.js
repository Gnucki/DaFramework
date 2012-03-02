(function ($)
{
	var fill = function()
	{
		return {
			construct: function ()
			{
				return this.each(function()
				{
					var padding = 0;
					var diff = $(this).outerHeight(true) - $(this).innerHeight();

					var pad = parseInt($(this).parent().css('padding-top'));
					if (isNaN(pad) == false)
						padding += pad;
					pad = parseInt($(this).parent().css('padding-bottom'));
					if (isNaN(pad) == false)
						padding += pad;

					var taille = $(this).parent().innerHeight()
											- padding
											- diff;

					if ($(this).height() < taille)
					{
						$(this).height(taille);

						if (taille != $(this).height())
						{
							diff = $(this).height() - taille;// $(this).outerHeight(true);
							$(this).height((taille - diff));
						}
					}
				});
			}
		};
	}();
	$.fn.extend(
	{
		fill: fill.construct
	});
})(jQuery)

