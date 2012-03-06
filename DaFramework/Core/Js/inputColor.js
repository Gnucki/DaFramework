var bufferCouleur;
var activeCouleur;

//------------------------------------------------------------------------------------------------------
// Color
(function($)
{
	var color = function()
	{
		var
		defaults =
		{
			active: true,
			selectorRetour: '.jq_color_retour'
		},

		initRetour = function(jqRetour, jqElem)
		{
			var retour = $.trim(jqRetour.text());

			if (retour == undefined)
				retour = '';

			jqElem.data('colorRetour', retour);
			jqRetour.remove();
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).hasClass('jq_input_form') == false)
					{
						if ($(this).hasClass('jq_color') == false)
							$(this).addClass('jq_color');

						$(this).addClass('jq_input_form');

						if ($(this).data('color') !=  1)
						{
							$(this).data('color', 1).disableSelection();
							$(this).width(30).height(30).css('border', '1px solid black').css('cursor', 'pointer');
							$(this).draggable({helper: 'clone', zIndex: 200, containment: 'document'});
							$(this).droppable({tolerance: 'pointer',
								drop: function(event, ui)
								{
									$(this).css('background-color', ui.helper.css('background-color'));
									$(this).trigger('colorChange', $(this).css('background-color'));
									$(this).mousedown();
								}
							});

							$(this).mousedown(function(e)
							{
								if (options.active == true)
								{
									if (activeCouleur != undefined && $(this).hasClass('jq_color_active') == false)
										activeCouleur.stop(true, true).animate({borderTopColor: 'rgb(0,0,0)',
																				borderLeftColor: 'rgb(0,0,0)',
																				borderBottomColor: 'rgb(0,0,0)',
																				borderRightColor: 'rgb(0,0,0)'}, 600);

									var backgroundColor = $(this).css('background-color');
									$(this).stop(true, true).animate({borderTopColor: backgroundColor,
																	  borderLeftColor: backgroundColor,
																	  borderBottomColor: backgroundColor,
																	  borderRightColor: backgroundColor}, 600);

									if (activeCouleur != undefined && activeCouleur.hasClass('jq_color_active') == true && $(this).hasClass('jq_color_active') == false)
										activeCouleur.removeClass('jq_color_active')

									if ($(this).hasClass('jq_color_active') == false)
									{
										activeCouleur = $(this);
										activeCouleur.addClass('jq_color_active');
									}

									if (bufferCouleur != undefined)
									{
										var couleur = $(this).css('background-color');

										if (couleur.indexOf('#') > 0)
											bufferCouleur.ColorPickerSetColor(couleur);
										else
										{
											if (couleur != 'transparent' && couleur != 'rgba(0, 0, 0, 0)')
											{
												var rgb = {};
												var i = couleur.indexOf('(');
												var j = couleur.indexOf(',');
												rgb.r = parseInt(couleur.substring(i + 1, j));
												i = j;
												j = couleur.indexOf(',', i + 1);
												rgb.g = parseInt(couleur.substring(i + 1, j));
												i = j;
												j = couleur.indexOf(')', i + 1);
												rgb.b = parseInt(couleur.substring(i + 1, j));
												if (!isNaN(rgb.r) && !isNaN(rgb.g) && !isNaN(rgb.b))
													bufferCouleur.ColorPickerSetColor(rgb);
											}
										}
									}
								}

								e.stopPropagation();
							});

							if (options.active == true)
							{
								$(this).dblclick(function()
								{
									$(this).css('background-color', 'transparent');
									$(this).stop(true, true).animate({borderTopColor: 'rgb(255,255,255)',
																	  borderLeftColor: 'rgb(255,255,255)',
																	  borderBottomColor: 'rgb(255,255,255)',
																	  borderRightColor: 'rgb(255,255,255)'}, 600);
									$(this).trigger('colorChange', $(this).css('background-color'));
								});
							}

							var color = $(this);
							$(this).find(options.selectorRetour).each(function()
							{
								initRetour($(this), color);
							});
						}
					}
				});
			},

			set: function (couleur)
			{
				return this.each(function ()
				{
				   	if (couleur != '' && couleur != undefined)
					   	$(this).stop(true, true).animate({backgroundColor: couleur}, 600);
				});
			},

			recupererRetour: function ()
			{
				var retour = $(this).data('colorRetour');
				if (retour == undefined || retour == '')
					return '';

				//var couleur = $(this).css('background-color');
				//if (couleur == 'transparent' || couleur == 'rgba(0, 0, 0, 0)')
				//	return '';

				return retour + '=' + $(this).css('background-color');
			},
		};
	}();
	$.fn.extend(
	{
		color: color.construct,
		colorSet: color.set,
		colorRecupererRetour: color.recupererRetour
	});
})(jQuery);


//------------------------------------------------------------------------------------------------------
// ColorBuffer
(function($)
{
	var colorBuffer = function()
	{
		var defaults =
		{
			selectorDecChange: '.jq_popdiv_declencheurchange',
			//selectorTitre: '.jq_buffercouleur_titre',
			selectorCadre: '.jq_buffercouleur_cadre',
			selectorCadreTitre: '.jq_buffercouleur_cadretitre',
			selectorCadreCouleur: '.jq_buffercouleur_cadrecouleur',
			selectorAide: '.jq_buffercouleur_aide',
			selectorInputColor: '.jq_inputcolor'
		},

		colorBufferCadreTitreMouseUp = function(e)
		{
			$(document).unbind('mouseup', colorBufferCadreTitreMouseUp);
			if (e.pageX == e.data.x && e.pageY == e.data.y)
			{
				var jqElem = e.data.elem;
				if (jqElem.data('colorBufferPlie') == 1)
				{
				   	jqElem.data('colorBufferPlie', 0);
				   	jqElem.find('.jq_buffercouleur_cadrecouleur:first').slideUp(300);
				}
				else
				{
				   	jqElem.data('colorBufferPlie', 1);
				   	jqElem.find('.jq_buffercouleur_cadrecouleur:first').slideDown(300);
				}
			}
		};

		return {
			construct: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).hasClass('jq_buffercouleur') == false)
						$(this).addClass('jq_buffercouleur');

					if ($(this).data('colorBuffer') !=  1)
					{
						$(this).data('colorBuffer', 1);
						$(this).css('cursor', 'move').css('z-index', '101');
						$(this).width(0).children().width(0);
						bufferCouleur = $(this).find(options.selectorInputColor).ColorPicker();

						//$(this).width($(this).find(options.selectorCadre).width());
						$(this).bind('colorChange', function(){}); // Bug IE.
						var width = $(this).find(options.selectorDecChange).width();
						if (width < 20)
							$(this).find(options.selectorDecChange).css('min-width','20px').width(20);

						var jqTitre = $(this).find(options.selectorCadreTitre + ':first');
						var jqElem = $(this);
						jqTitre.mousedown(function(e)
						{
						   	var position = {x: e.pageX, y: e.pageY, options: options, elem: jqElem};
							$(document).bind('mouseup', position, colorBufferCadreTitreMouseUp);
						});
						$(this).draggable({zIndex: 101, containment: 'document'});
						$(this).css('position','absolute');

						var jqAide = $(this).find(options.selectorAide);
						jqAide.hide();
						$(this).find(options.selectorCadreTitre).InfoBulle({}, jqAide);
						$(this).css('height', '0');

						$(this).bind('colorChange', function(e)
						{
							e.stopPropagation();
						});
					}
				});
			}
		};
	}();
	$.fn.extend(
	{
		ColorBuffer: colorBuffer.construct
	});
})(jQuery);


/**
 *
 * Zoomimage
 * Author: Stefan Petre www.eyecon.ro
 *
 */
(function($){
	var EYE = window.EYE = function() {
		var _registered = {
			init: []
		};
		return {
			init: function() {
				$.each(_registered.init, function(nr, fn){
					fn.call();
				});
			},
			extend: function(prop) {
				for (var i in prop) {
					if (prop[i] != undefined) {
						this[i] = prop[i];
					}
				}
			},
			register: function(fn, type) {
				if (!_registered[type]) {
					_registered[type] = [];
				}
				_registered[type].push(fn);
			}
		};
	}();
	$(EYE.init);
})(jQuery);


/**
 *
 * Color picker
 * Original Author: Stefan Petre www.eyecon.ro
 *
 */
 /**
 * Modified by Gnucki
 */
//------------------------------------------------------------------------------------------------------
// InputColor
(function ($) {
	var ColorPicker = function () {
		var
			ids = {},
			inAction,
			charMin = 65,
			visible,
			offsetSliders = 0,
			//tpl = this;//'<div class="jq_inputcolor"><div class="jq_inputcolor_color"><div><div></div></div></div><div class="jq_inputcolor_hue"><div></div></div><div class="jq_inputcolor_new_color"></div><div class="jq_inputcolor_current_color"></div><div class="jq_inputcolor_hex"><input type="text" maxlength="6" size="6" /></div><div class="jq_inputcolor_rgb_r jq_inputcolor_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="jq_inputcolor_rgb_g jq_inputcolor_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="jq_inputcolor_rgb_b jq_inputcolor_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="jq_inputcolor_hsb_h jq_inputcolor_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="jq_inputcolor_hsb_s jq_inputcolor_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="jq_inputcolor_hsb_b jq_inputcolor_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="jq_inputcolor_submit"></div></div>',

			defaults = {
				eventName: 'click',
				onShow: function () {},
				onBeforeShow: function(){},
				onHide: function () {},
				onChange: function () {},
				onSubmit: function () {},
				color: 'ff0000',
				livePreview: true,
				flat: false
			},


			//-------------------------------------------------------------
			fillRGBFields = function  (hsb, cal)
			{
				var rgb = HSBToRGB(hsb);
				$(cal).data('jq_inputcolor').fields
					.eq(1).val(rgb.r).end()
					.eq(2).val(rgb.g).end()
					.eq(3).val(rgb.b).end();
			},

			fillRGBTextes = function  (hsb, cal)
			{
				var rgb = HSBToRGB(hsb);
				$(cal).data('jq_inputcolor').rgbTextes
					.eq(0).val(rgb.r).end()
					.eq(1).val(rgb.g).end()
					.eq(2).val(rgb.b).end();
			},

			fillHSBFields = function  (hsb, cal)
			{
				$(cal).data('jq_inputcolor').fields
					.eq(4).val(hsb.h).end()
					.eq(5).val(hsb.s).end()
					.eq(6).val(hsb.b).end();
			},

			fillHexFields = function (hsb, cal)
			{
				$(cal).data('jq_inputcolor').fields
					.eq(0).val(HSBToHex(hsb)).end();
			},


			//-------------------------------------------------------------
			fillRGBFieldsWithRGB = function  (rgb, cal)
			{
				$(cal).data('jq_inputcolor').fields
					.eq(1).val(rgb.r).end()
					.eq(2).val(rgb.g).end()
					.eq(3).val(rgb.b).end();
			},

			fillRGBTextesWithRGB = function  (rgb, cal)
			{
				$(cal).data('jq_inputcolor').rgbTextes
					.eq(0).val(rgb.r).end()
					.eq(1).val(rgb.g).end()
					.eq(2).val(rgb.b).end();
			},

			fillHSBFieldsWithRGB = function  (rgb, cal)
			{
				var hsb = RGBToHSB(rgb);
				$(cal).data('jq_inputcolor').fields
					.eq(4).val(hsb.h).end()
					.eq(5).val(hsb.s).end()
					.eq(6).val(hsb.b).end();
			},

			fillHexFieldsWithRGB = function (rgb, cal)
			{
				$(cal).data('jq_inputcolor').fields
					.eq(0).val(RGBToHex(rgb)).end();
			},


			//-------------------------------------------------------------
			setSelector = function (hsb, cal)
			{
				$(cal).data('jq_inputcolor').selector.css('backgroundColor', '#' + HSBToHex({h: hsb.h, s: 100, b: 100}));
				$(cal).data('jq_inputcolor').selectorIndic.css({left: parseInt(150 * hsb.s/100, 10), top: parseInt(150 * (100-hsb.b)/100, 10)});
			},

			setHue = function (hsb, cal)
			{
				$(cal).data('jq_inputcolor').hue.css('top', parseInt(150 - 150 * hsb.h/360, 10));
			},

			setNewColor = function (hsb, cal)
			{
				//$(cal).data('jq_inputcolor').newColor.css('backgroundColor', '#' + HSBToHex(hsb));
				var rgb = HSBToRGB(hsb);
				$(cal).data('jq_inputcolor').newColor.colorSet('rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
				//$(cal).data('jq_inputcolor').newColor.css('backgroundColor', 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
			},

			setRGBSliders = function (hsb, cal)
			{
				var rgb = HSBToRGB(hsb);
				$(cal).data('jq_inputcolor').rgbSliders.eq(0).slider('value', rgb.r);
				$(cal).data('jq_inputcolor').rgbSliders.eq(1).slider('value', rgb.g);
				$(cal).data('jq_inputcolor').rgbSliders.eq(2).slider('value', rgb.b);
				offsetSliders = 0;
			},

			setNewColorWithRGB = function (rgb, cal)
			{
				$(cal).data('jq_inputcolor').newColor.colorSet('rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
				//$(cal).data('jq_inputcolor').newColor.css('backgroundColor', 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
			},

			setRGBSlidersWithRGB = function (rgb, cal)
			{
				$(cal).data('jq_inputcolor').rgbSliders.eq(0).slider('value', rgb.r);
				$(cal).data('jq_inputcolor').rgbSliders.eq(1).slider('value', rgb.g);
				$(cal).data('jq_inputcolor').rgbSliders.eq(2).slider('value', rgb.b);
				offsetSliders = 0;
			},


			//-------------------------------------------------------------
			keyDown = function (ev)
			{
				var pressedKey = ev.charCode || ev.keyCode || -1;
				if ((pressedKey > charMin && pressedKey <= 90) || pressedKey == 32)
					return false;

				var cal = $(this).parent().parent();
				if (cal.data('jq_inputcolor').livePreview === true)
					change.apply(this, [0]);
			},

			change = function (ev)
			{
				var cal = $(this).parent().parent(), col;
				var modeRGB = false;

				if (this.parentNode.className.indexOf('_hex') > 0)
					cal.data('jq_inputcolor').color = col = HexToHSB(fixHex(this.value));
				else if (this.parentNode.className.indexOf('_hsb') > 0)
				{
					cal.data('jq_inputcolor').color = col = fixHSB(
					{
						h: parseInt(cal.data('jq_inputcolor').fields.eq(4).val(), 10),
						s: parseInt(cal.data('jq_inputcolor').fields.eq(5).val(), 10),
						b: parseInt(cal.data('jq_inputcolor').fields.eq(6).val(), 10)
					});
				}
				else
				{
					modeRGB = true;
					//cal.data('jq_inputcolor').color = col = RGBToHSB(fixRGB(
					col = fixRGB(
					{
						r: parseInt(cal.data('jq_inputcolor').fields.eq(1).val(), 10),
						g: parseInt(cal.data('jq_inputcolor').fields.eq(2).val(), 10),
						b: parseInt(cal.data('jq_inputcolor').fields.eq(3).val(), 10)
					});
					cal.data('jq_inputcolor').color = RGBToHSB(col);
				}

				if (modeRGB == false)
				{
					if (ev > 0 && ev < 3)
					{
						fillRGBFields(col, cal.get(0));
						fillHexFields(col, cal.get(0));
						fillHSBFields(col, cal.get(0));
						fillRGBTextes(col, cal.get(0));

						if (ev < 2)
						{
							offsetSliders = 1;
							setRGBSliders(col, cal.get(0));
						}
					}
					if (ev < 3)
					{
						setSelector(col, cal.get(0));
						setHue(col, cal.get(0));
						setNewColor(col, cal.get(0));
					}

					var rgb = HSBToRGB(col);
					if (activeCouleur != undefined)
					{
						activeCouleur.colorSet('rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
						//activeCouleur.css('background-color', 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
						activeCouleur.trigger('colorChange', 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
					}
					cal.data('jq_inputcolor').onChange.apply(cal, [col, HSBToHex(col), HSBToRGB(col)]);
				}
				else
				{
					if (ev > 0 && ev < 3)
					{
						fillRGBFieldsWithRGB(col, cal.get(0));
						fillHexFieldsWithRGB(col, cal.get(0));
						fillHSBFieldsWithRGB(col, cal.get(0));
						setSelector(RGBToHSB(col), cal.get(0));
						setHue(RGBToHSB(col), cal.get(0));

						if (ev < 2)
						{
							offsetSliders = 1;
							setRGBSlidersWithRGB(col, cal.get(0));
						}
					}
					if (ev < 3)
					{
						setNewColorWithRGB(col, cal.get(0));
						fillRGBTextesWithRGB(col, cal.get(0));
					}

					if (activeCouleur != undefined && ev < 3)
					{
						activeCouleur.colorSet('rgb(' + col.r + ',' + col.g + ',' + col.b + ')');
						//activeCouleur.css('background-color', 'rgb(' + col.r + ',' + col.g + ',' + col.b + ')');
						activeCouleur.trigger('colorChange', 'rgb(' + col.r + ',' + col.g + ',' + col.b + ')');
					}
					cal.data('jq_inputcolor').onChange.apply(cal, [col, RGBToHex(col), col]);
				}
			},

			blur = function (ev)
			{
				var cal = $(this).parent().parent();
				cal.data('jq_inputcolor').fields.parent().removeClass('jq_inputcolor_focus')
			},

			focus = function ()
			{
				charMin = this.parentNode.className.indexOf('_hex') > 0 ? 70 : 65;
				$(this).parent().parent().data('jq_inputcolor').fields.parent().removeClass('jq_inputcolor_focus');
				$(this).parent().addClass('jq_inputcolor_focus');
			},

			downIncrement = function (ev)
			{
				var field = $(this).parent().find('input').focus();
				var current =
				{
					el: $(this).parent().addClass('jq_inputcolor_slider'),
					max: this.parentNode.className.indexOf('_hsb_h') > 0 ? 360 : (this.parentNode.className.indexOf('_hsb') > 0 ? 100 : 255),
					y: ev.pageY,
					field: field,
					val: parseInt(field.val(), 10),
					preview: $(this).parent().parent().data('jq_inputcolor').livePreview
				};

				$(document).bind('mouseup', current, upIncrement);
				$(document).bind('mousemove', current, moveIncrement);
				ev.stopPropagation();
				ev.preventDefault();
			},

			moveIncrement = function (ev)
			{
				ev.data.field.val(Math.max(0, Math.min(ev.data.max, parseInt(ev.data.val + ev.pageY - ev.data.y, 10))));
				if (ev.data.preview)
					change.apply(ev.data.field.get(0), [1]);

				return false;
			},

			upIncrement = function (ev)
			{
				change.apply(ev.data.field.get(0), [1]);
				ev.data.el.removeClass('jq_inputcolor_slider').find('input').focus();
				$(document).unbind('mouseup', upIncrement);
				$(document).unbind('mousemove', moveIncrement);

				return false;
			},

			downHue = function (ev)
			{
				var current =
				{
					cal: $(this).parent(),
					y: $(this).offset().top
				};

				current.preview = current.cal.data('jq_inputcolor').livePreview;
				$(document).bind('mouseup', current, upHue);
				$(document).bind('mousemove', current, moveHue);
				ev.stopPropagation();
				ev.preventDefault();
			},

			moveHue = function (ev)
			{
				var preview = 0;
				if (ev.data.preview == true)
					preview = 1;

				change.apply(
					ev.data.cal.data('jq_inputcolor')
						.fields
						.eq(4)
						.val(parseInt(360*(150 - Math.max(0,Math.min(150,(ev.pageY - ev.data.y))))/150, 10))
						.get(0),
					[preview]
				);

				return false;
			},

			upHue = function (ev)
			{
				fillRGBFields(ev.data.cal.data('jq_inputcolor').color, ev.data.cal.get(0));
				fillHexFields(ev.data.cal.data('jq_inputcolor').color, ev.data.cal.get(0));
				fillRGBTextes(ev.data.cal.data('jq_inputcolor').color, ev.data.cal.get(0));
				$(document).unbind('mouseup', upHue);
				$(document).unbind('mousemove', moveHue);

				return false;
			},

			downSelector = function (ev)
			{
				var current =
				{
					cal: $(this).parent(),
					pos: $(this).offset()
				};

				current.preview = current.cal.data('jq_inputcolor').livePreview;
				$(document).bind('mouseup', current, upSelector);
				$(document).bind('mousemove', current, moveSelector);
				ev.stopPropagation();
				ev.preventDefault();
			},

			moveSelector = function (ev)
			{
				var preview = 0;
				if (ev.data.preview == true)
					preview = 1;

				change.apply(
					ev.data.cal.data('jq_inputcolor')
						.fields
						.eq(6)
						.val(parseInt(100*(150 - Math.max(0,Math.min(150,(ev.pageY - ev.data.pos.top))))/150, 10))
						.end()
						.eq(5)
						.val(parseInt(100*(Math.max(0,Math.min(150,(ev.pageX - ev.data.pos.left))))/150, 10))
						.get(0),
					[preview]
				);

				return false;
			},

			upSelector = function (ev)
			{
				fillRGBFields(ev.data.cal.data('jq_inputcolor').color, ev.data.cal.get(0));
				fillHexFields(ev.data.cal.data('jq_inputcolor').color, ev.data.cal.get(0));
				fillRGBTextes(ev.data.cal.data('jq_inputcolor').color, ev.data.cal.get(0));
				$(document).unbind('mouseup', upSelector);
				$(document).unbind('mousemove', moveSelector);

				return false;
			},

			enterSubmit = function (ev)
			{
				$(this).addClass('jq_inputcolor_focus');
			},

			leaveSubmit = function (ev)
			{
				$(this).removeClass('jq_inputcolor_focus');
			},

			clickSubmit = function (ev)
			{
				var cal = $(this).parent();
				var col = cal.data('jq_inputcolor').color;

				cal.data('jq_inputcolor').origColor = col;
				setCurrentColor(col, cal.get(0));
				cal.data('jq_inputcolor').onSubmit(col, HSBToHex(col), HSBToRGB(col));
			},

			show = function (ev)
			{
				var cal = $('#' + $(this).data('jq_inputcolor_id'));
				cal.data('jq_inputcolor').onBeforeShow.apply(this, [cal.get(0)]);
				var pos = $(this).offset();
				var viewPort = getViewport();
				var top = pos.top + this.offsetHeight;
				var left = pos.left;

				if (top + 176 > viewPort.t + viewPort.h)
					top -= this.offsetHeight + 176;

				if (left + 356 > viewPort.l + viewPort.w)
					left -= 356;

				cal.css({left: left + 'px', top: top + 'px'});
				if (cal.data('jq_inputcolor').onShow.apply(this, [cal.get(0)]) != false)
					cal.show();

				$(document).bind('mousedown', {cal: cal}, hide);
				return false;
			},

			hide = function (ev) {
				if (!isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0))) {
					if (ev.data.cal.data('jq_inputcolor').onHide.apply(this, [ev.data.cal.get(0)]) != false) {
						ev.data.cal.hide();
					}
					$(document).unbind('mousedown', hide);
				}
			},


			//-------------------------------------------------------------
			isChildOf = function(parentEl, el, container)
			{
				if (parentEl == el)
					return true;

				if (parentEl.contains)
					return parentEl.contains(el);

				if ( parentEl.compareDocumentPosition )
					return !!(parentEl.compareDocumentPosition(el) & 16);

				var prEl = el.parentNode;
				while(prEl && prEl != container)
				{
					if (prEl == parentEl)
						return true;
					prEl = prEl.parentNode;
				}

				return false;
			},

			getViewport = function ()
			{
				var m = document.compatMode == 'CSS1Compat';
				return {
					l : window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
					t : window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
					w : window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
					h : window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight)
				};
			},


			//-------------------------------------------------------------
			fixHSB = function (hsb)
			{
				return {
					h: Math.min(360, Math.max(0, hsb.h)),
					s: Math.min(100, Math.max(0, hsb.s)),
					b: Math.min(100, Math.max(0, hsb.b))
				};
			},

			fixRGB = function (rgb)
			{
				return {
					r: Math.min(255, Math.max(0, rgb.r)),
					g: Math.min(255, Math.max(0, rgb.g)),
					b: Math.min(255, Math.max(0, rgb.b))
				};
			},

			fixHex = function (hex)
			{
				var len = 6 - hex.length;

				if (len > 0)
				{
					var o = [];
					for (var i=0; i<len; i++)
					{
						o.push('0');
					}
					o.push(hex);
					hex = o.join('');
				}

				return hex;
			},


			//-------------------------------------------------------------
			HexToRGB = function (hex)
			{
				var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
				return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
			},

			HexToHSB = function (hex)
			{
				return RGBToHSB(HexToRGB(hex));
			},

			RGBToHSB = function (rgb)
			{
				var hsb = {};
				hsb.b = Math.max(Math.max(rgb.r,rgb.g),rgb.b);
				hsb.s = (hsb.b <= 0) ? 0 : Math.round(100*(hsb.b - Math.min(Math.min(rgb.r,rgb.g),rgb.b))/hsb.b);
				hsb.b = Math.round((hsb.b /255)*100);

				if ((rgb.r==rgb.g) && (rgb.g==rgb.b)) hsb.h = 0;
				else if (rgb.r>=rgb.g && rgb.g>=rgb.b) hsb.h = 60*(rgb.g-rgb.b)/(rgb.r-rgb.b);
				else if (rgb.g>=rgb.r && rgb.r>=rgb.b) hsb.h = 60  + 60*(rgb.g-rgb.r)/(rgb.g-rgb.b);
				else if (rgb.g>=rgb.b && rgb.b>=rgb.r) hsb.h = 120 + 60*(rgb.b-rgb.r)/(rgb.g-rgb.r);
				else if (rgb.b>=rgb.g && rgb.g>=rgb.r) hsb.h = 180 + 60*(rgb.b-rgb.g)/(rgb.b-rgb.r);
				else if (rgb.b>=rgb.r && rgb.r>=rgb.g) hsb.h = 240 + 60*(rgb.r-rgb.g)/(rgb.b-rgb.g);
				else if (rgb.r>=rgb.b && rgb.b>=rgb.g) hsb.h = 300 + 60*(rgb.r-rgb.b)/(rgb.r-rgb.g);
				else hsb.h = 0;

				hsb.h = Math.round(hsb.h);

				return hsb;
			},

			HSBToRGB = function (hsb)
			{
				var rgb = {};
				var h = Math.round(hsb.h);
				var s = Math.round(hsb.s*255/100);
				var v = Math.round(hsb.b*255/100);

				if(s == 0)
					rgb.r = rgb.g = rgb.b = v;
				else
				{
					var t1 = v;
					var t2 = (255-s)*v/255;
					var t3 = (t1-t2)*(h%60)/60;
					if (h==360) h = 0;
					if (h<60) {rgb.r=t1;	rgb.b=t2; rgb.g=t2+t3}
					else if (h<120) {rgb.g=t1; rgb.b=t2;	rgb.r=t1-t3}
					else if (h<180) {rgb.g=t1; rgb.r=t2;	rgb.b=t2+t3}
					else if (h<240) {rgb.b=t1; rgb.r=t2;	rgb.g=t1-t3}
					else if (h<300) {rgb.b=t1; rgb.g=t2;	rgb.r=t2+t3}
					else if (h<360) {rgb.r=t1; rgb.g=t2;	rgb.b=t1-t3}
					else {rgb.r=0; rgb.g=0;	rgb.b=0}
				}

				return {r:Math.round(rgb.r), g:Math.round(rgb.g), b:Math.round(rgb.b)};
			},

			RGBToHex = function (rgb)
			{
				var hex = [
					rgb.r.toString(16),
					rgb.g.toString(16),
					rgb.b.toString(16)
				];

				$.each(hex, function (nr, val)
				{
					if (val.length == 1)
						hex[nr] = '0' + val;
				});

				return hex.join('');
			},

			HSBToHex = function (hsb)
			{
				return RGBToHex(HSBToRGB(hsb));
			};


		/**********************************************************************/
		return {
			init: function (options)
			{
				options = $.extend({}, defaults, options||{});

				if (typeof options.color == 'string')
					options.color = HexToHSB(options.color);
				else if (options.color.r != undefined && options.color.g != undefined && options.color.b != undefined)
					options.color = RGBToHSB(options.color);
				else if (options.color.h != undefined && options.color.s != undefined && options.color.b != undefined)
					options.color = fixHSB(options.color);
				else
					return this;

				return this.each(function ()
				{
					if (!$(this).data('jq_inputcolor_id'))
					{
						var id = 'jq_inputcolor_' + parseInt(Math.random() * 1000);
						$(this).data('jq_inputcolor_id', id);
						var cal = $(this).find('.jq_inputcolor_cal').children().css('display', 'block').css('position', 'relative').children().attr('id', id + '_cal');
						cal.attr('id', id);
						/*if (options.flat) {
							cal.appendTo(this).show();
						} else {
							cal.appendTo(document.body);
						}*/
						options.fields = cal.find('input')
												.bind('keydown', keyDown)
												.bind('change', change)
												.bind('blur', blur)
												.bind('focus', focus);
						options.rgbTextes = $(this).find('.jq_inputcolor_composante_text input').keyup(function()
																								{
																									var rgb =
																									{
																										r: parseInt(options.rgbTextes.eq(0).val(), 10),
																										g: parseInt(options.rgbTextes.eq(1).val(), 10),
																										b: parseInt(options.rgbTextes.eq(2).val(), 10)
																									};

																									if (isNaN(rgb.r))
																									{
																										rgb.r = 0;
																										options.rgbTextes.eq(0).val('0');
																									}
																									else
																										options.rgbTextes.eq(0).val(rgb.r);
																									if (isNaN(rgb.g))
																									{
																										rgb.g = 0;
																										options.rgbTextes.eq(1).val('0');
																									}
																									else
																										options.rgbTextes.eq(1).val(rgb.g);
																									if (isNaN(rgb.b))
																									{
																										rgb.b = 0;
																										options.rgbTextes.eq(2).val('0');
																									}
																									else
																										options.rgbTextes.eq(2).val(rgb.b);

																									options.fields
																										.eq(1).val(rgb.r).end()
																										.eq(2).val(rgb.g).end()
																										.eq(3).val(rgb.b).end();

																									change.apply(options.fields.eq(1).get(0), [1]);
																								});
						options.rgbSliders = $(this).find('.jq_inputcolor_composante_slider');
						options.rgbSliders.css('cursor', 'pointer').slider({
													orientation: 'vertical',
													range: 'min',
													max: 255,
													value: 127,
													slide: function ()
													{
														var rgb =
														{
															r: parseInt(options.rgbSliders.eq(0).slider('value'), 10),
															g: parseInt(options.rgbSliders.eq(1).slider('value'), 10),
															b: parseInt(options.rgbSliders.eq(2).slider('value'), 10)
														};

														options.fields
															.eq(1).val(rgb.r).end()
															.eq(2).val(rgb.g).end()
															.eq(3).val(rgb.b).end();

														options.rgbTextes
															.eq(0).val(rgb.r).end()
															.eq(1).val(rgb.g).end()
															.eq(2).val(rgb.b).end();

														change.apply(options.fields.eq(1).get(0), [1]);
													},
													change: function (event)
													{
														var rgb =
														{
															r: parseInt(options.rgbSliders.eq(0).slider('value'), 10),
															g: parseInt(options.rgbSliders.eq(1).slider('value'), 10),
															b: parseInt(options.rgbSliders.eq(2).slider('value'), 10)
														};

														options.fields
															.eq(1).val(rgb.r).end()
															.eq(2).val(rgb.g).end()
															.eq(3).val(rgb.b).end();

														options.rgbTextes
															.eq(0).val(rgb.r).end()
															.eq(1).val(rgb.g).end()
															.eq(2).val(rgb.b).end();

														// Bug boucle infinie sur Opera.
														//change.apply(options.fields.eq(1).get(0), [2 + offsetSliders]);
													},
													animate: true
												}).mousedown(function(e) {e.stopPropagation()});

						var composante = 0;
						$(this).find('.jq_inputcolor_suiv').each(function()
						{
							composante++;
							$(this).inputTrigger({evenement: 'goToSuivant', curseur: 'pointer', donnees: composante});
						}).css('font-family', 'Courier New').find('td:first').css('text-align', 'center');
						composante = 0;
						$(this).find('.jq_inputcolor_prec').each(function()
						{
							composante++;
							$(this).inputTrigger({evenement: 'goToPrecedent', curseur: 'pointer', donnees: composante});
						}).css('font-family', 'Courier New').find('td:first').css('text-align', 'center');

						$(this).bind('goToSuivant', function(e, comp)
						{
							options.fields.eq(comp).val(parseInt(options.fields.eq(comp).val())+1);
							change.apply(options.fields.eq(comp).get(0), [1]);
						});

						$(this).bind('goToPrecedent', function(e, comp)
						{
							options.fields.eq(comp).val(parseInt(options.fields.eq(comp).val())-1);
							change.apply(options.fields.eq(comp).get(0), [1]);
						});

						cal.find('span').bind('mousedown', downIncrement);
						options.selector = cal.find('.jq_inputcolor_color').bind('mousedown', downSelector);
						options.selectorIndic = options.selector.find('div div');
						var hue = cal.find('.jq_inputcolor_hue');
						options.hue = hue.find('div');
						hue.bind('mousedown', downHue);
						options.newColor = cal.find('.jq_inputcolor_new_color').color({active: false});
						options.newColor.width(30);
						cal.data('jq_inputcolor', options);

						fillRGBFields(options.color, cal.get(0));
						fillHSBFields(options.color, cal.get(0));
						fillHexFields(options.color, cal.get(0));
						fillRGBTextes(options.color, cal.get(0));
						setHue(options.color, cal.get(0));
						setSelector(options.color, cal.get(0));
						setNewColor(options.color, cal.get(0));
						offsetSliders = 1;
						setRGBSliders(options.color, cal.get(0));

						hue.parent().width(150);
						hue.height(150).find('img').height(150);
						hue.parent().width(150);

						//cal.find('.jq_inputcolor_new_color').width($(this).width() - ($(this).find('.jq_inputcolor_visualiseur').width() + $(this).find('.jq_inputcolor_editeur').width()) + 1);

						/*if (options.flat)
							cal.css({position: 'relative', display: 'block'});
						else
							$(this).bind(options.eventName, show);*/
					}
				});
			},

			showPicker: function()
			{
				return this.each(function ()
				{
					if ($(this).data('jq_inputcolor_id'))
						show.apply(this);
				});
			},

			hidePicker: function()
			{
				return this.each(function ()
				{
					if ($(this).data('jq_inputcolor_id'))
						$('#' + $(this).data('jq_inputcolor_id')).hide();
				});
			},

			setColor: function(col)
			{
				var modeRGB = false;

				if (typeof col == 'string')
					col = HexToHSB(col);
				else if (col.r != undefined && col.g != undefined && col.b != undefined)
					modeRGB = true;
				else if (col.h != undefined && col.s != undefined && col.b != undefined)
					col = fixHSB(col);
				else
					return this;

				return this.each(function()
				{
					if ($(this).data('jq_inputcolor_id'))
					{
						var cal = $('#' + $(this).data('jq_inputcolor_id'));
						if (modeRGB == false)
						{
							cal.data('jq_inputcolor').color = col;
							cal.data('jq_inputcolor').origColor = col;
							fillRGBFields(col, cal.get(0));
							fillHSBFields(col, cal.get(0));
							fillHexFields(col, cal.get(0));
							setHue(col, cal.get(0));
							setSelector(col, cal.get(0));
							setNewColor(col, cal.get(0));
							fillRGBTextes(col, cal.get(0));
							offsetSliders = 1;
							setRGBSliders(col, cal.get(0));
						}
						else
						{
							cal.data('jq_inputcolor').color = RGBToHSB(col);
							cal.data('jq_inputcolor').origColor = RGBToHSB(col);
							fillRGBFieldsWithRGB(col, cal.get(0));
							fillHSBFieldsWithRGB(col, cal.get(0));
							fillHexFieldsWithRGB(col, cal.get(0));
							setHue(RGBToHSB(col), cal.get(0));
							setSelector(RGBToHSB(col), cal.get(0));
							setNewColorWithRGB(col, cal.get(0));
							fillRGBTextesWithRGB(col, cal.get(0));
							offsetSliders = 1;
							setRGBSlidersWithRGB(col, cal.get(0));
						}
					}
				});
			}
		};
	}();

	$.fn.extend({
		ColorPicker: ColorPicker.init,
		ColorPickerHide: ColorPicker.hide,
		ColorPickerShow: ColorPicker.show,
		ColorPickerSetColor: ColorPicker.setColor
	});
})(jQuery)
