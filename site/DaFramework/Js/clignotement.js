//-------------------------------------------------------------------------------------------------------------------------------
// Fonctions et classes de gestion du clignotement des éléments.
//-------------------------------------------------------------------------------------------------------------------------------
// Liste des classes d'éléments qui clignotent.
// Un élément qui clignote doit avoir une classe (attribut class HTML) et sa classe doit être un des éléments de la liste.
// Pour définir un clignotement pour une classe: tableauObjetsClignotants[NOM_CLASS] = new ObjetClignotant();
var tabOC = new Array();
var tabObjCli = new Array();
var tabObjCliVis = new Array();

(function ($)
{
	var clignotant = function()
	{
		var
		defaults =
		{
			declenchement: 'manuel',
			animation: true
		},

		COULEUR_PIC = 0,
		COULEUR_FIN = 1,
		COULEUR_RET = 2,

		COLOR = 'color',
		COLOR_BACKGROUND = 'background-color',
		COLOR_BORDERTOP = 'border-top-color',
		COLOR_BORDERLEFT = 'border-left-color',
		COLOR_BORDERRIGHT = 'border-right-color',
		COLOR_BORDERBOTTOM = 'border-bottom-color',
		COLOR_OPACITY = 'opacity',

		getColor = function(jqElem, attr)
		{
			var color;

			color = jqElem.css(attr);
			if (color == '' || color == 'rgba(0,0,0,0)' || color == 'rgba(0, 0, 0, 0)')
			   	color = 'transparent';

			return color;
		},

		parseColor = function (couleur)
		{
		   	var rgb =
			{
				r: 0,
				g: 0,
				b: 0
			};

			var posDeb = couleur.indexOf('(', 0);
			var posFin = couleur.indexOf(',', posDeb+1);
			rgb.r = parseInt(couleur.substring(posDeb+1, posFin));
			posDeb = posFin;
			posFin = couleur.indexOf(',', posDeb+1);
			rgb.g = parseInt(couleur.substring(posDeb+1, posFin));
			posDeb = posFin;
			posFin = couleur.indexOf(')', posDeb+1);
			rgb.b = parseInt(couleur.substring(posDeb+1, posFin));

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

			return rgb;
		},

		init = function(jqElem, visualiseur)
		{
			var className = jqElem.attr('class');
			var tabClassName = className.split(' ');
			var tab;
			className = '';
			var tabObjetClignotant = tabObjCli;
			if (visualiseur === true)
				tabObjetClignotant = tabObjCliVis;

			for (var i = 0; i < tabClassName.length; i++)
			{
				if (tabObjetClignotant[tabClassName[i]] != undefined)
				{
					className = tabClassName[i];
					tab = tabObjetClignotant[tabClassName[i]];
					break;
				}
			}

			if (className != '')
			{
				var clignotement = new Array();
				var clignotementExistant = new Array();
				clignotement[0] = 1;
				clignotementExistant[0] = 1;

				var clignotementCouleur = new Array();
				clignotementCouleur[0] = new Array();
				clignotementCouleur[0][COULEUR_FIN] = new Array();
				clignotementCouleur[0][COULEUR_FIN][COLOR] = getColor(jqElem, 'color'),
				clignotementCouleur[0][COULEUR_FIN][COLOR_BACKGROUND] = getColor(jqElem, 'backgroundColor');
				clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERTOP] = getColor(jqElem, 'borderTopColor');
				clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERLEFT] = getColor(jqElem, 'borderLeftColor');
				clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERRIGHT] = getColor(jqElem, 'borderRightColor');
				clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERBOTTOM] = getColor(jqElem, 'borderBottomColor');
				clignotementCouleur[0][COULEUR_FIN][COLOR_OPACITY] = jqElem.css('opacity');
				if (clignotementCouleur[0][COULEUR_FIN][COLOR_OPACITY] == undefined)
					clignotementCouleur[0][COULEUR_FIN][COLOR_OPACITY] = 1;

				var clignotementTiming = new Array();

				var multiClignoValTab = tab.multiClignoVal;

				for (multiClignoVal in multiClignoValTab)
				{
					var j = multiClignoVal;
					clignotement[j] = 0;
					clignotementExistant[j] = 1;

					var k = COULEUR_PIC;
					clignotementCouleur[j] = new Array();
					clignotementCouleur[j][k] = new Array();
					clignotementCouleur[j][k][COLOR] = tab.GetRGBCouleur(tab.NORM_ECRITURE, tab.TIMING_PIC, j);
					clignotementCouleur[j][k][COLOR_BACKGROUND] = tab.GetRGBCouleur(tab.NORM_BACKGROUND, tab.TIMING_PIC, j);
					clignotementCouleur[j][k][COLOR_BORDERTOP] = tab.GetRGBCouleur(tab.NORM_BORD_HAUT, tab.TIMING_PIC, j);
					clignotementCouleur[j][k][COLOR_BORDERLEFT] = tab.GetRGBCouleur(tab.NORM_BORD_GAUCHE, tab.TIMING_PIC, j);
					clignotementCouleur[j][k][COLOR_BORDERRIGHT] = tab.GetRGBCouleur(tab.NORM_BORD_DROIT, tab.TIMING_PIC, j);
					clignotementCouleur[j][k][COLOR_BORDERBOTTOM] = tab.GetRGBCouleur(tab.NORM_BORD_BAS, tab.TIMING_PIC, j);
					clignotementCouleur[j][k][COLOR_OPACITY] = tab.GetOpacitePic(j);
					if (clignotementCouleur[j][k][COLOR_OPACITY] == '')
					{
						if (clignotementCouleur[j][k][COLOR] != '' ||
						    clignotementCouleur[j][k][COLOR_BACKGROUND] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERTOP] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERLEFT] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERRIGHT] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERBOTTOM] != '')
							clignotementCouleur[j][k][COLOR_OPACITY] = 1;
					}

					k = COULEUR_FIN;
					clignotementCouleur[j][k] = new Array();
					clignotementCouleur[j][k][COLOR] = tab.GetRGBCouleur(tab.NORM_ECRITURE, tab.TIMING_FIN, j);
					clignotementCouleur[j][k][COLOR_BACKGROUND] = tab.GetRGBCouleur(tab.NORM_BACKGROUND, tab.TIMING_FIN, j);
					clignotementCouleur[j][k][COLOR_BORDERTOP] = tab.GetRGBCouleur(tab.NORM_BORD_HAUT, tab.TIMING_FIN, j);
					clignotementCouleur[j][k][COLOR_BORDERLEFT] = tab.GetRGBCouleur(tab.NORM_BORD_GAUCHE, tab.TIMING_FIN, j);
					clignotementCouleur[j][k][COLOR_BORDERRIGHT] = tab.GetRGBCouleur(tab.NORM_BORD_DROIT, tab.TIMING_FIN, j);
					clignotementCouleur[j][k][COLOR_BORDERBOTTOM] = tab.GetRGBCouleur(tab.NORM_BORD_BAS, tab.TIMING_FIN, j);
					clignotementCouleur[j][k][COLOR_OPACITY] = tab.GetOpaciteFin(j);
					if (clignotementCouleur[j][k][COLOR_OPACITY] == '')
					{
						if (clignotementCouleur[j][k][COLOR] != '' ||
						    clignotementCouleur[j][k][COLOR_BACKGROUND] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERTOP] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERLEFT] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERRIGHT] != '' ||
							clignotementCouleur[j][k][COLOR_BORDERBOTTOM] != '')
							clignotementCouleur[j][k][COLOR_OPACITY] = 1;
					}

					clignotementTiming[j] = new Array();
					clignotementTiming[j][COULEUR_PIC] = tab.GetDureePic(j);
					clignotementTiming[j][COULEUR_FIN] = tab.GetDureeFin(j);
					clignotementTiming[j][COULEUR_RET] = tab.GetDureeRetour(j);
				}

				jqElem.data('clignotement', clignotement);
				jqElem.data('clignotementExistant', clignotementExistant);
				jqElem.data('clignotementCouleur', clignotementCouleur);
				jqElem.data('clignotementTiming', clignotementTiming);
				jqElem.data('clignotementActif', 0);
				jqElem.data('clignotementOn', 1);

				return true;
			}

			return false;
		},

		getCouleurAnimation = function(jqElem, pic)
		{
			var couleur = new Array();
			couleur[COLOR] = new Array();
			couleur[COLOR_BACKGROUND] = new Array();
			couleur[COLOR_BORDERTOP] = new Array();
			couleur[COLOR_BORDERLEFT] = new Array();
			couleur[COLOR_BORDERRIGHT] = new Array();
			couleur[COLOR_BORDERBOTTOM] = new Array();
			couleur[COLOR_OPACITY] = new Array();
			var clignotementCouleur = jqElem.data('clignotementCouleur');
			var clignotement = jqElem.data('clignotement');

			for (multiClignoVal in clignotementCouleur)
			{
				if (clignotement[multiClignoVal] == 1)
				{
					setCouleurAnimation(clignotementCouleur, couleur, COLOR, multiClignoVal, pic);
					setCouleurAnimation(clignotementCouleur, couleur, COLOR_BACKGROUND, multiClignoVal, pic);
					setCouleurAnimation(clignotementCouleur, couleur, COLOR_BORDERTOP, multiClignoVal, pic);
					setCouleurAnimation(clignotementCouleur, couleur, COLOR_BORDERLEFT, multiClignoVal, pic);
					setCouleurAnimation(clignotementCouleur, couleur, COLOR_BORDERRIGHT, multiClignoVal, pic);
					setCouleurAnimation(clignotementCouleur, couleur, COLOR_BORDERBOTTOM, multiClignoVal, pic);
					setCouleurAnimation(clignotementCouleur, couleur, COLOR_OPACITY, multiClignoVal, pic);
				}
			}

			var couleurTab = {};
			if (couleur[COLOR]['valeur'] != undefined)
				couleurTab = $.extend({ color: couleur[COLOR]['valeur'] }, couleurTab);
			if (couleur[COLOR_BACKGROUND]['valeur'] != undefined)
				couleurTab = $.extend({ backgroundColor: couleur[COLOR_BACKGROUND]['valeur'] }, couleurTab);
			if (couleur[COLOR_BORDERTOP]['valeur'] != undefined)
				couleurTab = $.extend({ borderTopColor: couleur[COLOR_BORDERTOP]['valeur'] }, couleurTab);
			if (couleur[COLOR_BORDERLEFT]['valeur'] != undefined)
				couleurTab = $.extend({ borderLeftColor: couleur[COLOR_BORDERLEFT]['valeur'] }, couleurTab);
			if (couleur[COLOR_BORDERRIGHT]['valeur'] != undefined)
				couleurTab = $.extend({ borderRightColor: couleur[COLOR_BORDERRIGHT]['valeur'] }, couleurTab);
			if (couleur[COLOR_BORDERBOTTOM]['valeur'] != undefined)
				couleurTab = $.extend({ borderBottomColor: couleur[COLOR_BORDERBOTTOM]['valeur'] }, couleurTab);
			if (couleur[COLOR_OPACITY]['valeur'] != undefined &&
					(jQuery.support.opacity ||
					 jqElem.get(0).nodeName == 'DIV' ||
					 jqElem.get(0).nodeName == 'INPUT' ||
						((parseInt(jqElem.css('borderTopWidth')) == 0 || isNaN(parseInt(jqElem.css('borderTopWidth')))) &&
						 (parseInt(jqElem.css('borderLeftWidth')) == 0 || isNaN(parseInt(jqElem.css('borderLeftWidth')))) &&
						 (parseInt(jqElem.css('borderRightWidth')) == 0 || isNaN(parseInt(jqElem.css('borderRightWidth')))) &&
						 (parseInt(jqElem.css('borderBottomWidth')) == 0 || isNaN(parseInt(jqElem.css('borderBottomWidth'))))
						)
					)
				) // HACK IE Y_Y.. L'opacité sur un td qui possède des bords ne sera pas prise en compte pour IE.
				couleurTab = $.extend({ opacity: couleur[COLOR_OPACITY]['valeur'] }, couleurTab);

			return couleurTab;
		},

		setCouleurAnimation = function(clignotementCouleur, couleur, prop, multiClignoVal, pic)
		{
			var j = multiClignoVal;

			if (couleur[prop]['multiClignoVal'] == undefined || parseInt(couleur[prop]['multiClignoVal']) < parseInt(j))
			{
				if (clignotementCouleur[j] != undefined && clignotementCouleur[j][COULEUR_FIN] != undefined && clignotementCouleur[j][COULEUR_FIN][prop] != '' && pic != true)
				{
					couleur[prop]['valeur'] = clignotementCouleur[j][COULEUR_FIN][prop];
					couleur[prop]['multiClignoVal'] = j;
				}
				else if (clignotementCouleur[j] != undefined && clignotementCouleur[j][COULEUR_PIC] != undefined && clignotementCouleur[j][COULEUR_PIC][prop] != '')
				{
					couleur[prop]['valeur'] = clignotementCouleur[j][COULEUR_PIC][prop];
					couleur[prop]['multiClignoVal'] = j;
				}
			}
		},

		setClignotementActif = function(jqElem)
		{
			var clignotement = jqElem.data('clignotement');
			var maxMultiClignoVal = 0;

			for (multiClignoVal in clignotement)
			{
				if (clignotement[multiClignoVal] == 1 && parseInt(multiClignoVal) > maxMultiClignoVal)
					maxMultiClignoVal = multiClignoVal;
			}

			jqElem.data('clignotementActif', maxMultiClignoVal);
		},

		clignote = function(jqElem, multipCligno, enfant, rechargement, duree, animation, visualiseur, dejaInit)
		{
			if (multipCligno > 0)
			{
			   	if (visualiseur === true)
				{
				   	visualiseur = true;

				   	var className = jqElem.attr('class');
					var tabClassName = className.split(' ');
					var tab;
					className = '';
					for (var i = 0; i < tabClassName.length; i++)
					{
						if (tabClassName[i].substring(0, 2) != 'jq')
							className = tabClassName[i];
					}

					if (className != '' && jqElem.hasClass('jq_clignotant_' + multipCligno) == false)
	   				   	jqElem.addClass('jq_clignotant_' + multipCligno);
			   	}

				if (jqElem.hasClass('jq_clignotant') == true)
				{
					if (rechargement != true)
					{
					   	var clignotement = jqElem.data('clignotement');
						clignotement[multipCligno] = 1;
						jqElem.data('clignotement', clignotement);
					}

					var clignotementExistant = jqElem.data('clignotementExistant');
					var clignotementActif = jqElem.data('clignotementActif');
					if (clignotementExistant[multipCligno] == 1 && parseInt(clignotementActif) < multipCligno && jqElem.data('clignotementOn') == 1)
					{
						var clignotementTiming = jqElem.data('clignotementTiming');

						var timingPic = 250;
						var timingFin = 150;

						if (clignotementTiming[multipCligno] != undefined)
						{
							timingPic = clignotementTiming[multipCligno][COULEUR_PIC];
							timingFin = clignotementTiming[multipCligno][COULEUR_FIN];
						}

						if (timingPic == '')
							timingPic = 250;
						if (timingFin == '')
							timingFin = 150;

						if (rechargement != true)
						{
							clignotementActif = multipCligno;
							jqElem.data('clignotementActif', clignotementActif);
						}
						else if (duree != undefined && duree != -1)
						{
							timingPic = 0;
							timingFin = duree;
						}

						var couleurPic = getCouleurAnimation(jqElem, true);
						var couleurFin = getCouleurAnimation(jqElem, false);

						jqElem.stop(true, false);

						var color = jqElem.css('backgroundColor');
						if (color == undefined || color == '' || color == 'transparent' || color == 'rgba(0,0,0,0)' || color == 'rgba(0, 0, 0, 0)')
			   			{
			   			   	var opacity = jqElem.css('opacity');
			   			   	var backgroundColor = '';

			   			   	if (couleurPic.backgroundColor != undefined)
			   			   		backgroundColor = couleurPic.backgroundColor;
			   			   	if (backgroundColor != '')
			   			   	{
			   			   	   	jqElem.css('opacity', 0);
			   			   	   	jqElem.css('backgroundColor', couleurPic.backgroundColor);
			   			   		if (couleurPic.opacity == undefined)
			   			   	   	   	couleurPic = $.extend({ opacity: opacity }, couleurPic);
			   			   	}
			   			}

			   			if (couleurPic.backgroundColor == 'transparent')
			   				delete couleurPic.backgroundColor;
			   			if (couleurFin.backgroundColor == 'transparent')
			   				delete couleurFin.backgroundColor;

			 			if (animation === true && animationsActives === true)
			 			{
							jqElem.data('clignotementEtat', 0).animate(couleurPic, parseInt(timingPic), 'easeInCubic', function() {$(this).data('clignotementEtat', 1);})
													.animate(couleurFin, parseInt(timingFin), 'easeOutQuint', function() {$(this).data('clignotementEtat', 2);});
						}
						else
						{
						   	jqElem.css(couleurPic).css(couleurFin).data('clignotementEtat', 2);
						}
					}
				}

				var jqEnfants = jqElem.children();
				if (jqEnfants.length == 0)
					jqElem.addClass('jq_clignotant_fininit');
				else
				{
					jqEnfants.each(function()
					{
						$(this).Clignoter({animation: animation}, multipCligno, true, true, visualiseur, dejaInit);
					});
				}
			}
		},

		declignote = function(jqElem, multipCligno, enfant, animation, visualiseur, dejaInit)
		{
			if (multipCligno > 0)
			{
				if (jqElem.hasClass('jq_clignotant') == true)
				{
				   	var clignotement = jqElem.data('clignotement');
					if (typeof(clignotement)=='object' && (clignotement instanceof Array))
					{
						clignotement[multipCligno] = 0;
						jqElem.data('clignotement', clignotement);

						var clignotementExistant = jqElem.data('clignotementExistant');
						var clignotementActif = jqElem.data('clignotementActif');
						if (clignotementExistant[multipCligno] == 1 && /*parseInt(clignotementActif) == multipCligno && */jqElem.data('clignotementOn') == 1)
						{
							var clignotementTiming = jqElem.data('clignotementTiming');

							var timingRet = 300;

							if (clignotementTiming[multipCligno] != undefined)
								timingRet = clignotementTiming[multipCligno][COULEUR_RET];

							if (timingRet == '')
								timingRet = 300;

							setClignotementActif(jqElem);
							var couleurDeb = getCouleurAnimation(jqElem, false);
							var etatClignotement = jqElem.data('clignotementEtat');

							if (etatClignotement === 0)
							  	timingRet = 40;

							jqElem.stop(true, false);

							var color = couleurDeb.backgroundColor;
							var opacity = -1;
							var backgroundColor = jqElem.css('backgroundColor');
							if (color == '' || color == 'transparent' || color == 'rgba(0,0,0,0)' || color == 'rgba(0, 0, 0, 0)')
				   			{
				   			   	delete couleurDeb.backgroundColor;
				   			   	if (backgroundColor != '' && backgroundColor != 'transparent' && backgroundColor != 'rgba(0,0,0,0)' && backgroundColor != 'rgba(0, 0, 0, 0)')
				   			   	{
									opacity = couleurDeb.opacity;
									if (couleurDeb.opacity == undefined || couleurDeb.opacity == '')
									   	opacity = 1;
					   			   	if (couleurDeb.opacity == undefined)
					   			   	   	couleurDeb = $.extend({ opacity: 0 }, couleurDeb);
					   			   	else
					   			   	   	couleurDeb.opacity = 0;
					   			}
				   			}

				 			if (animation === true && animationsActives === true && opacity == -1) // Effacer le opacity == -1 pour avoir un fondu avec opacité.
				 			{
								jqElem.animate(couleurDeb, parseInt(timingRet), 'easeInCubic', function()
								{
								   	if (opacity != -1)
								   	{
								   	   	$(this).css('backgroundColor', color);
								   	   	$(this).css('opacity', opacity);
								   	}
								});
							}
							else
							{
							   	jqElem.css(couleurDeb);
							   	if (opacity != -1)
								{
								   	jqElem.css('backgroundColor', color);
								   	jqElem.css('opacity', opacity);
								}
							}
						}
					}
				}

				var jqEnfants = jqElem.children();
				if (jqEnfants.length == 0)
					jqElem.addClass('jq_clignotant_fininit');
				else
				{
					jqEnfants.each(function()
					{
						$(this).Clignoter({animation: animation}, multipCligno, false, true, visualiseur, dejaInit);
					});
				}

				if (enfant !== true)
				   	jqElem.closest('.jq_clignotant_fininit').removeClass('jq_clignotant_fininit');
			}
		};

		return {
			construct: function (options, multipCligno, cligno, enfant, visualiseur, dejaInit)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
				   	if (dejaInit == undefined)
				   	{
				   	   	var jqClignotantFinInit = $(this).find('.jq_clignotant_fininit:first');
				   	   	if (jqClignotantFinInit.length == 0 || jqClignotantFinInit.closest('.jq_clignotant_debinit').length == 1)
				   	   		dejaInit = false;
				   	   	else
				   	   	   	dejaInit = true;
				   	}
				   	if (dejaInit === true && $(this).parent().hasClass('jq_clignotant_fininit') === true)
				   		dejaInit = false

					if (options.declenchement == 'mouseenter')
					{
						if ($(this).hasClass('jq_clignotant') == false && dejaInit === false)
						{
							$(this).mouseenter(function()
							{
							   	if ($(this).hasClass('jq_clignotant') == false && dejaInit === false)
							   	{
								   	if (init($(this)) == true)
										$(this).addClass('jq_clignotant');
							   	}
								clignote($(this), multipCligno, enfant, false, -1, options.animation, visualiseur, dejaInit);
							});

							$(this).mouseleave(function()
							{
							   	if ($(this).hasClass('jq_clignotant') == false && dejaInit === false)
							   	{
								   	if (init($(this)) == true)
										$(this).addClass('jq_clignotant');
							   	}
								declignote($(this), multipCligno, enfant, options.animation, visualiseur, dejaInit);
							});
						}
					}
					else if (options.declenchement == 'manuel')
					{
					   	if (visualiseur === undefined)
						{
					   		if ($(this).closest('.jq_visualiseur_vue').length == 1)
					   			visualiseur = true;
					   		else
					   		   	visualiseur = false;
					   	}
					   	else if (visualiseur === false && $(this).hasClass('jq_visualiseur_vue') === true)
					   		visualiseur = -1;

					   	if (visualiseur !== -1)
						{
							if ($(this).hasClass('jq_clignotant') === false && dejaInit === false)
							{
								if (init($(this), visualiseur) === true)
									$(this).addClass('jq_clignotant');
								if (enfant != true)
								   	$(this).addClass('jq_clignotant_debinit');
							}

							if (cligno == true)
								clignote($(this), multipCligno, enfant, false, -1, options.animation, visualiseur, dejaInit);
							else
								declignote($(this), multipCligno, enfant, options.animation, visualiseur, dejaInit);
						}
					}
				});
			},

			activer: function (options, duree)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).hasClass('jq_clignotant') == true)
					{
						$(this).data('clignotementOn', 1);
						clignote($(this), 100, false, true, duree);
					}
				});
			},

			desactiver: function (options)
			{
				var options = $.extend({}, defaults, options || {});
				return this.each(function ()
				{
					if ($(this).hasClass('jq_clignotant') == true)
					{
						$(this).data('clignotementOn', 0);

						$(this).css(COLOR,'');
						$(this).css(COLOR_BACKGROUND,'');
						$(this).css(COLOR_BORDERTOP,'');
						$(this).css(COLOR_BORDERLEFT,'');
						$(this).css(COLOR_BORDERRIGHT,'');
						$(this).css(COLOR_BORDERBOTTOM,'');
						$(this).css(COLOR_OPACITY,'');
					}
				});
			},

			reinitialiser: function (visualiseur)
			{
				$(this).stop(true, true).removeClass('jq_clignotant').removeData('clignotement').removeData('clignotementActif').removeData('clignotementExistant').removeData('clignotementOn');

				return this.each(function ()
				{
				   	var clignotementCouleur = $(this).data('clignotementCouleur');
				   	if (clignotementCouleur != undefined && clignotementCouleur != null)
					{
					   	if (visualiseur === true)
						{
						   	$(this).css(COLOR, clignotementCouleur[0][COULEUR_FIN][COLOR]);
							$(this).css(COLOR_BACKGROUND, clignotementCouleur[0][COULEUR_FIN][COLOR_BACKGROUND]);
							$(this).css(COLOR_BORDERTOP, clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERTOP]);
							$(this).css(COLOR_BORDERLEFT, clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERLEFT]);
							$(this).css(COLOR_BORDERRIGHT, clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERRIGHT]);
							$(this).css(COLOR_BORDERBOTTOM, clignotementCouleur[0][COULEUR_FIN][COLOR_BORDERBOTTOM]);
							$(this).css(COLOR_OPACITY, clignotementCouleur[0][COULEUR_FIN][COLOR_OPACITY]);
					   	}
					   	else
					   	{
						   	$(this).css(COLOR, '');
							$(this).css(COLOR_BACKGROUND, '');
							$(this).css(COLOR_BORDERTOP, '');
							$(this).css(COLOR_BORDERLEFT, '');
							$(this).css(COLOR_BORDERRIGHT, '');
							$(this).css(COLOR_BORDERBOTTOM, '');
							$(this).css(COLOR_OPACITY, '');
						}
					}
					$(this).removeData('clignotementCouleur');
				});
			},

			recupererCouleurInitiale: function (cssAtt)
			{
			   	var clignotementCouleur = $(this).data('clignotementCouleur');
				if (clignotementCouleur != undefined && clignotementCouleur != null)
				   	return clignotementCouleur[0][COULEUR_FIN][cssAtt];
				return $(this).css(cssAtt);
			},

			changerCouleurInitiale: function (cssAtt, valeur)
			{
			   	return this.each(function ()
				{
				   	var clignotementCouleur = $(this).data('clignotementCouleur');
					if (clignotementCouleur != undefined && clignotementCouleur != null)
					   	clignotementCouleur[0][COULEUR_FIN][cssAtt] = valeur;
					if ($(this).data('clignotementActif') == 0)
						$(this).css(cssAtt, valeur);
				});
			}
		};
	}();
	$.fn.extend(
	{
		Clignoter: clignotant.construct,
		ClignoterDesactiver: clignotant.desactiver,
		ClignoterActiver: clignotant.activer,
		ClignoterReinitialiser: clignotant.reinitialiser,
		ClignoterRecupererCouleurInitiale: clignotant.recupererCouleurInitiale,
		ClignoterChangerCouleurInitiale: clignotant.changerCouleurInitiale
	});
})(jQuery)


// Classes qui permettent de gérer différentes instances d'objets qui clignotent au même moment.
// Appeler la fonction précédente qui les utilisent pour s'en servir.
// Classe de définition du clignotement d'une classe (attribut class d'une balise html).
ObjetClignotant = function()
{
	this.rougePic;
	this.vertPic;
	this.bleuPic;
	this.rougeFin;
	this.vertFin;
	this.bleuFin;

	this.opacitePic;
	this.opaciteFin;

	this.dureePic;
	this.dureeFin;
	this.dureeRetour;

	this.multiClignoVal;

	this.InitObjetClignotant();
};

ObjetClignotant.prototype =
{
	InitObjetClignotant: function()
	{
		this.rougePic = new Array();
		this.vertPic = new Array();
		this.bleuPic = new Array();
		this.rougeFin = new Array();
		this.vertFin = new Array();
		this.bleuFin = new Array();

		this.opacitePic = new Array();
		this.opaciteFin = new Array();

		this.dureePic = new Array();
		this.dureeFin = new Array();
		this.dureeRetour = new Array();

		this.multiClignoVal = new Array();

		this.NORM_ECRITURE = 0;
		this.NORM_BACKGROUND = 1;
		this.NORM_BORD_HAUT = 2;
		this.NORM_BORD_GAUCHE = 3;
		this.NORM_BORD_DROIT = 4;
		this.NORM_BORD_BAS = 5;

		this.TIMING_PIC = 0;
		this.TIMING_FIN = 1;
	},

	//---
	SetCliEcriture: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno)
	{
		this.SetClignotement(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, this.NORM_ECRITURE, multipCligno);
	},

	SetCliBackground: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno)
	{
		this.SetClignotement(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, this.NORM_BACKGROUND, multipCligno);
	},

	SetCliBords: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno)
	{
		this.SetCliBordHaut(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno);
		this.SetCliBordGauche(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno);
		this.SetCliBordBas(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno);
		this.SetCliBordDroit(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno);
	},

	SetCliBordHaut: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno)
	{
		this.SetClignotement(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, this.NORM_BORD_HAUT, multipCligno);
	},

	SetCliBordGauche: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno)
	{
		this.SetClignotement(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, this.NORM_BORD_GAUCHE, multipCligno);
	},

	SetCliBordDroit: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno)
	{
		this.SetClignotement(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, this.NORM_BORD_DROIT, multipCligno);
	},

	SetCliBordBas: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, multipCligno)
	{
		this.SetClignotement(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, this.NORM_BORD_BAS, multipCligno);
	},

	//---
	SetClignotement: function(rougePic, vertPic, bleuPic, rougeFin, vertFin, bleuFin, index, multipCligno)
	{
		if (this.multiClignoVal[multipCligno] == undefined)
			this.multiClignoVal[multipCligno] = 1;

		this.rougePic[index + (10*multipCligno)] = rougePic;
		this.vertPic[index + (10*multipCligno)] = vertPic;
		this.bleuPic[index + (10*multipCligno)] = bleuPic;
		this.rougeFin[index + (10*multipCligno)] = rougeFin;
		this.vertFin[index + (10*multipCligno)] = vertFin;
		this.bleuFin[index + (10*multipCligno)] = bleuFin;
	},

	SetTimingClignotement: function(dureePic, dureeFin, dureeRetour, multipCligno)
	{
		if (this.multiClignoVal[multipCligno] == undefined)
			this.multiClignoVal[multipCligno] = 1;

		this.dureePic[(10*multipCligno)] = dureePic;
		this.dureeFin[(10*multipCligno)] = dureeFin;
		this.dureeRetour[(10*multipCligno)] = dureeRetour;
	},

	SetCliOpacite: function(opacitePic, opaciteFin, multipCligno)
	{
		if (this.multiClignoVal[multipCligno] == undefined)
			this.multiClignoVal[multipCligno] = 1;

		this.opacitePic[(10*multipCligno)] = opacitePic;
		this.opaciteFin[(10*multipCligno)] = opaciteFin;
	},

	//---
	GetOpacitePic: function(multipCligno)
	{
		if (this.opacitePic[(10*multipCligno)] == undefined || this.opacitePic[(10*multipCligno)] == -1)
			return '';

		return this.opacitePic[(10*multipCligno)];
	},

	GetOpaciteFin: function(multipCligno)
	{
		if (this.opaciteFin[(10*multipCligno)] == undefined || this.opaciteFin[(10*multipCligno)] == -1)
			return '';

		return this.opaciteFin[(10*multipCligno)];
	},

	//---
	GetDureePic: function(multipCligno)
	{
		if (this.dureePic[(10*multipCligno)] == undefined || this.dureePic[(10*multipCligno)] == -1)
			return '';

		return this.dureePic[(10*multipCligno)];
	},

	GetDureeFin: function(multipCligno)
	{
		if (this.dureeFin[(10*multipCligno)] == undefined || this.dureeFin[(10*multipCligno)] == -1)
			return '';

		return this.dureeFin[(10*multipCligno)];
	},

	GetDureeRetour: function(multipCligno)
	{
		if (this.dureeRetour[(10*multipCligno)] == undefined || this.dureeRetour[(10*multipCligno)] == -1)
			return '';

		return this.dureeRetour[(10*multipCligno)];
	},

	//---
	GetRGBCouleur: function(index, timing, multipCligno)
	{
		if (timing == this.TIMING_PIC)
		{
			if (this.rougePic[index + (10*multipCligno)] != undefined && this.rougePic[index + (10*multipCligno)] != -1)
				return 'rgb(' + this.rougePic[index + (10*multipCligno)] + ',' + this.vertPic[index + (10*multipCligno)] + ',' + this.bleuPic[index + (10*multipCligno)] + ')';
		}
		else if (timing == this.TIMING_FIN)
		{
			if (this.rougeFin[index + (10*multipCligno)] != undefined && this.rougeFin[index + (10*multipCligno)] != -1)
				return 'rgb(' + this.rougeFin[index + (10*multipCligno)] + ',' + this.vertFin[index + (10*multipCligno)] + ',' + this.bleuFin[index + (10*multipCligno)] + ')';
		}

		return '';
	},

	GetRGBCouleurEcriturePic: function(multipCligno)
	{
	   	var index = this.NORM_ECRITURE;
	   	return this.GetRGBCouleur(index, this.TIMING_PIC, multipCligno);
	},

	GetRGBCouleurEcritureFin: function(multipCligno)
	{
	   	var index = this.NORM_ECRITURE;
	   	return this.GetRGBCouleur(index, this.TIMING_FIN, multipCligno);
	},

	GetRGBCouleurBackgroundPic: function(multipCligno)
	{
	   	var index = this.NORM_BACKGROUND;
	   	return this.GetRGBCouleur(index, this.TIMING_PIC, multipCligno);
	},

	GetRGBCouleurBackgroundFin: function(multipCligno)
	{
	   	var index = this.NORM_BACKGROUND;
	   	return this.GetRGBCouleur(index, this.TIMING_FIN, multipCligno);
	},

	GetRGBCouleurBordHautPic: function(multipCligno)
	{
	   	var index = this.NORM_BORD_HAUT;
	   	return this.GetRGBCouleur(index, this.TIMING_PIC, multipCligno);
	},

	GetRGBCouleurBordHautFin: function(multipCligno)
	{
	   	var index = this.NORM_BORD_HAUT;
	   	return this.GetRGBCouleur(index, this.TIMING_FIN, multipCligno);
	},

	GetRGBCouleurBordGauchePic: function(multipCligno)
	{
	   	var index = this.NORM_BORD_GAUCHE;
	   	return this.GetRGBCouleur(index, this.TIMING_PIC, multipCligno);
	},

	GetRGBCouleurBordGaucheFin: function(multipCligno)
	{
	   	var index = this.NORM_BORD_GAUCHE;
	   	return this.GetRGBCouleur(index, this.TIMING_FIN, multipCligno);
	},

	GetRGBCouleurBordBasPic: function(multipCligno)
	{
	   	var index = this.NORM_BORD_BAS;
	   	return this.GetRGBCouleur(index, this.TIMING_PIC, multipCligno);
	},

	GetRGBCouleurBordBasFin: function(multipCligno)
	{
	   	var index = this.NORM_BORD_BAS;
	   	return this.GetRGBCouleur(index, this.TIMING_FIN, multipCligno);
	},

	GetRGBCouleurBordDroitPic: function(multipCligno)
	{
	   	var index = this.NORM_BORD_DROIT;
	   	return this.GetRGBCouleur(index, this.TIMING_PIC, multipCligno);
	},

	GetRGBCouleurBordDroitFin: function(multipCligno)
	{
	   	var index = this.NORM_BORD_DROIT;
	   	return this.GetRGBCouleur(index, this.TIMING_FIN, multipCligno);
	},

	GetRGBCouleurEcriturePicTab: function(multipCligno)
	{
	   	var index = this.NORM_ECRITURE;
	   	var rgb =
		{
		  	r: this.rougePic[index + (10*multipCligno)],
		  	g: this.vertPic[index + (10*multipCligno)],
		  	b: this.bleuPic[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurEcritureFinTab: function(multipCligno)
	{
	   	var index = this.NORM_ECRITURE;
	   	var rgb =
		{
		  	r: this.rougeFin[index + (10*multipCligno)],
		  	g: this.vertFin[index + (10*multipCligno)],
		  	b: this.bleuFin[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBackgroundPicTab: function(multipCligno)
	{
	   	var index = this.NORM_BACKGROUND;
	   	var rgb =
		{
		  	r: this.rougePic[index + (10*multipCligno)],
		  	g: this.vertPic[index + (10*multipCligno)],
		  	b: this.bleuPic[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBackgroundFinTab: function(multipCligno)
	{
	   	var index = this.NORM_BACKGROUND;
	   	var rgb =
		{
		  	r: this.rougeFin[index + (10*multipCligno)],
		  	g: this.vertFin[index + (10*multipCligno)],
		  	b: this.bleuFin[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordHautPicTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_HAUT;
	   	var rgb =
		{
		  	r: this.rougePic[index + (10*multipCligno)],
		  	g: this.vertPic[index + (10*multipCligno)],
		  	b: this.bleuPic[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordHautFinTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_HAUT;
	   	var rgb =
		{
		  	r: this.rougeFin[index + (10*multipCligno)],
		  	g: this.vertFin[index + (10*multipCligno)],
		  	b: this.bleuFin[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordGauchePicTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_GAUCHE;
	   	var rgb =
		{
		  	r: this.rougePic[index + (10*multipCligno)],
		  	g: this.vertPic[index + (10*multipCligno)],
		  	b: this.bleuPic[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordGaucheFinTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_GAUCHE;
	   	var rgb =
		{
		  	r: this.rougeFin[index + (10*multipCligno)],
		  	g: this.vertFin[index + (10*multipCligno)],
		  	b: this.bleuFin[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordBasPicTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_BAS;
	   	var rgb =
		{
		  	r: this.rougePic[index + (10*multipCligno)],
		  	g: this.vertPic[index + (10*multipCligno)],
		  	b: this.bleuPic[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordBasFinTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_BAS;
	   	var rgb =
		{
		  	r: this.rougeFin[index + (10*multipCligno)],
		  	g: this.vertFin[index + (10*multipCligno)],
		  	b: this.bleuFin[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordDroitPicTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_DROIT;
	   	var rgb =
		{
		  	r: this.rougePic[index + (10*multipCligno)],
		  	g: this.vertPic[index + (10*multipCligno)],
		  	b: this.bleuPic[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurBordDroitFinTab: function(multipCligno)
	{
	   	var index = this.NORM_BORD_DROIT;
	   	var rgb =
		{
		  	r: this.rougeFin[index + (10*multipCligno)],
		  	g: this.vertFin[index + (10*multipCligno)],
		  	b: this.bleuFin[index + (10*multipCligno)]
		};
	   	return this.GetRGBCouleurTabFiltree(rgb);
	},

	GetRGBCouleurTabFiltree: function(rgb)
	{
	   	if (rgb.r == undefined)
	   		rgb.r = -1;
	   	if (rgb.g == undefined)
	   		rgb.g = -1;
	   	if (rgb.b == undefined)
	   		rgb.b = -1;
	   	return rgb;
	},

	RecupererRetour: function()
	{
	   	var retour = '';
	   	var rgbPic, rgbFin;

		for (var j in this.multiClignoVal)
		{
		  	var retourClignoVal = '';
		  	var clignoValOk = false;

			rgbPic = this.GetRGBCouleurEcriturePicTab(j);
			rgbFin = this.GetRGBCouleurEcritureFinTab(j);
			if (rgbPic.r != -1 || rgbPic.g != -1 || rgbPic.b != -1 || rgbFin.r != -1 || rgbFin.g != -1 || rgbFin.b != -1)
				clignoValOk = true;
			retourClignoVal += rgbPic.r + ',' + rgbPic.g + ',' + rgbPic.b + ',' + rgbFin.r + ',' + rgbFin.g + ',' + rgbFin.b;

			rgbPic = this.GetRGBCouleurBackgroundPicTab(j);
			rgbFin = this.GetRGBCouleurBackgroundFinTab(j);
			if (rgbPic.r != -1 || rgbPic.g != -1 || rgbPic.b != -1 || rgbFin.r != -1 || rgbFin.g != -1 || rgbFin.b != -1)
				clignoValOk = true;
			retourClignoVal += ',' + rgbPic.r + ',' + rgbPic.g + ',' + rgbPic.b + ',' + rgbFin.r + ',' + rgbFin.g + ',' + rgbFin.b;

			rgbPic = this.GetRGBCouleurBordHautPicTab(j);
			rgbFin = this.GetRGBCouleurBordHautFinTab(j);
			if (rgbPic.r != -1 || rgbPic.g != -1 || rgbPic.b != -1 || rgbFin.r != -1 || rgbFin.g != -1 || rgbFin.b != -1)
				clignoValOk = true;
			retourClignoVal += ',' + rgbPic.r + ',' + rgbPic.g + ',' + rgbPic.b + ',' + rgbFin.r + ',' + rgbFin.g + ',' + rgbFin.b;

			rgbPic = this.GetRGBCouleurBordGauchePicTab(j);
			rgbFin = this.GetRGBCouleurBordGaucheFinTab(j);
			if (rgbPic.r != -1 || rgbPic.g != -1 || rgbPic.b != -1 || rgbFin.r != -1 || rgbFin.g != -1 || rgbFin.b != -1)
				clignoValOk = true;
			retourClignoVal += ',' + rgbPic.r + ',' + rgbPic.g + ',' + rgbPic.b + ',' + rgbFin.r + ',' + rgbFin.g + ',' + rgbFin.b;

			rgbPic = this.GetRGBCouleurBordBasPicTab(j);
			rgbFin = this.GetRGBCouleurBordBasFinTab(j);
			if (rgbPic.r != -1 || rgbPic.g != -1 || rgbPic.b != -1 || rgbFin.r != -1 || rgbFin.g != -1 || rgbFin.b != -1)
				clignoValOk = true;
			retourClignoVal += ',' + rgbPic.r + ',' + rgbPic.g + ',' + rgbPic.b + ',' + rgbFin.r + ',' + rgbFin.g + ',' + rgbFin.b;

			rgbPic = this.GetRGBCouleurBordDroitPicTab(j);
			rgbFin = this.GetRGBCouleurBordDroitFinTab(j);
			if (rgbPic.r != -1 || rgbPic.g != -1 || rgbPic.b != -1 || rgbFin.r != -1 || rgbFin.g != -1 || rgbFin.b != -1)
				clignoValOk = true;
			retourClignoVal += ',' + rgbPic.r + ',' + rgbPic.g + ',' + rgbPic.b + ',' + rgbFin.r + ',' + rgbFin.g + ',' + rgbFin.b;

			if (clignoValOk === true)
			{
				if (retour != '')
			  		retour += ';';
			  	retour += j + ':' + retourClignoVal;
			}
		}

		return retour;
	}
};