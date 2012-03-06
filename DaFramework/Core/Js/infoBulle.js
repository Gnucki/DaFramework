(function ($)
{
	var infoBulle = function()
	{
		var
		defaults =
		{
			type: 'info', // 'aide', 'info', 'erreur'
			width: 'auto', // 'auto', 'manuel'
			depopAuto: true
		},

		infoBullePopEvent = function(e)
		{
			var topOffset = 15;
			var leftOffset = 15;
			if ($(document).height() < (e.pageY+15+e.data.element.height()))
				topOffset = $(document).height() - (e.pageY+15+e.data.element.height());
			e.data.element.css('top',e.pageY+topOffset);
			e.data.element.css('left',e.pageX+leftOffset);
		},

		infoBulleClickEvent = function(e)
		{
			e.data.children().remove();
		},

		removeSizeCache = function(jqElem) // bug IE, attribut interne.
		{
			jqElem.removeAttr('sizcache').children().each(function()
			{
				removeSizeCache($(this));
			});
		}

		return {
			construct: function (options, jqElem)
			{
				if (jqElem.get(0) != undefined)
				{
					var options = $.extend({}, defaults, options || {});
					return this.each(function()
					{
						options.depopAuto = true;

						$(this).mouseenter(function()
						{
							$(this).InfoBullePop(options, jqElem);
						});
					});
				}
			},

			pop: function (options, jqElem)
			{
				if (jqElem.get(0) != undefined)
				{
					var options = $.extend({}, defaults, options || {});
					return this.each(function()
					{
						removeSizeCache(jqElem);

						var infoBulleDiv;
						$('#infoBullePopDiv').each(function()
						{
							infoBulleDiv = $(this);
						});

						if (infoBulleDiv == undefined)
						{
							infoBulleDiv = $('body').prepend('<div id="infoBullePopDiv"></div>').find('#infoBullePopDiv');
							infoBulleDiv.css('position', 'absolute');
							infoBulleDiv.css('z-index', 200);
							infoBulleDiv.css('overflow', 'hidden');
						}

						var rand = parseInt(Math.random() * 1000);
						infoBulleDiv.prepend('<div id="infoBulle' + rand +'">'+jqElem.html()+'</div>').find('#infoBulle' + rand).hide().each(function()
						{
						   	var infoBulle = $(this);
						   	window.setTimeout(function(){infoBulle.fadeIn(500)}, 300);
						});

						infoBulleDiv.width('');
						if (infoBulleDiv.width() > 250)
							infoBulleDiv.width(250);

						if (options.depopAuto == true)
						{
							$(this).mouseleave(function()
							{
								$(this).InfoBulleDepop(options, jqElem);
							});
						}

						var attributs =
						{
							element: infoBulleDiv,
							width: options.width
						};

						$(document).bind('click', infoBulleDiv, infoBulleClickEvent);
						$(document).bind('mousemove', attributs, infoBullePopEvent);
					});
				}
			},

			depop: function (options, jqElem)
			{
				if (jqElem.get(0) != undefined)
				{
					var options = $.extend({}, defaults, options || {});
					return this.each(function()
					{
						var infoBulleDiv = $('#infoBullePopDiv');
						var hasChild = false;

						removeSizeCache(jqElem);

						infoBulleDiv.children().each(function()
						{
							$(this).removeAttr('sizcache');
							$(this).removeAttr('sizset');
							if ($.trim($(this).html()) == $.trim(jqElem.html()))
							{
								$(this).remove();
								infoBulleDiv.width('');
								if (infoBulleDiv.width() > 250)
									infoBulleDiv.width(250);
							}
							else
								hasChild = true;
						});

						if (hasChild == false)
						{
							$(document).unbind('mousemove', infoBullePopEvent);
						}
					});
				}
			}
		};
	}();
	$.fn.extend(
	{
		InfoBulle: infoBulle.construct,
		InfoBullePop: infoBulle.pop,
		InfoBulleDepop: infoBulle.depop
	});
})(jQuery)