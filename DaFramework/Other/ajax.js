var pathFonctions = 'fonctions/';
var dureeRechargement = 20000;
var animationsActives = true;
var idPage = parseInt(Math.random() * 1000000);
//document.cookie = "pageActiveReload=" + idPage;

$(document).ready(function()
{
   	//if (navigator.userAgent.indexOf('MSIE') >= 0)// || navigator.userAgent.indexOf('Firefox') >= 0 || navigator.userAgent.indexOf('Opera') >= 0)
   	//	animationsActives = false;

   	/*$(document).mouseenter(function()
   	{
   	   	PageActive();
   	});*/

   	$(window).unload(function()
	{
	   	PageActive();
	});
});

function PageActive()
{
	var expDate = new Date()
    expDate.setTime(expDate.getTime() + (24 * 3600 * 1000));
    document.cookie = "pageActive=" + idPage + ";expires=" + expDate.toGMTString();
    //document.cookie = "pageActiveReload=0";
}

// Fonction d'obtention de l'HttpRequest.
function ObtenirXMLHttpRequest()
{
	var xhr;

    try
	{
       	xhr = new ActiveXObject("MSXML2.DOMDocument.4.0");
    }
	catch (e0)
	{
		try
		{
	    	xhr = new ActiveXObject('MSXML2.XMLHTTP.3.0');
	    }
	    catch (e1)
		{
	       	try
			{
	        	xhr = new ActiveXObject('Msxml2.XMLHTTP');
	        }
	        catch (e2)
			{
				try
				{
	        	  	xhr = new ActiveXObject('Microsoft.XMLHTTP');
		        }
		        catch (e3)
				{
					try
					{
						xhr = new XMLHttpRequest();
		          	}
					catch (e4)
					{
						xhr = false;
					}
				}
			}
		}
	}

	return xhr;
};

// Fonction qui permet d'appeler le fichier PhP passé en paramètre en passant data comme donnée au fichier
function AppelFonctionServeur(xhr, fichierPHP, data)
{
	xhr.open('POST', fichierPHP, true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send(data);
	// ou
	// xhr.open('GET', url);
};

// Permet de charger un affichage à partir d'un fichier XML.
function ChargerFromXML(xml)
{
	var jqContexte = $(this);
	var chargerSuite = false;
	var modificationPresentationCss = false;
	var modificationPresentationJs = false;
	var presentationVisualiseur = false;

alert(XMLtoText(xml, true));

	$(xml).find('element').each(function()
	{
	   	var jqElem = $(this);
		var type = $.trim(jqElem.children('type').text());

		switch (type)
		{
			case 'liste':
			   	var typeSynchro = $.trim($(this).children('typeSynchro:first').text());
			   	var numero = $.trim($(this).children('numero:first').text());
			   	var nbPages = $.trim($(this).children('nbPages:first').text());
			   	var nouvTypeSynchro = $.trim($(this).children('nouvTypeSynchro:first').text());
			   	var typeSynchroTravail = typeSynchro;
			   	if (nouvTypeSynchro != '')
			   		typeSynchroTravail = nouvTypeSynchro;

			   	$('.jq_liste').each(function()
			   	{
			   	   	var jqListe = $(this);
			   	   	if (nouvTypeSynchro != '' && jqListe.data('listeTypeSynchro') == typeSynchro && jqListe.data('listeNumero') == numero)
						jqListe.listeChangerTypeSynchro(nouvTypeSynchro);

			   	   	if (jqListe.data('listeTypeSynchro') == typeSynchroTravail)
			  	  	{
			  	  	   	if (nbPages != '')
			  	  	   	   	jqListe.listeChangerNbPages(nbPages);

						if	(numero === '' || jqListe.data('listeNumero') == numero)
						{
						   	jqElem.find('action').each(function()
							{
							   	var typeAction = $.trim($(this).find('typeAction').text());

							   	switch (typeAction)
								{
								   	case 'ajoutContenu':
								   	   	var id = $.trim($(this).find('id').text());
							   			var contenu = XMLtoText($(this).find('contenu').get(0), true);
							   			jqListe.listeAjouterContenuElement(id, contenu);
							   			break;
								   	case 'creat':
							   			var contenu = XMLtoText($(this).find('contenu').get(0), true);
							   			jqListe.listeCreerElement(contenu);
							   			break;
							   		case 'modif':
							   			var contenu = XMLtoText($(this).find('contenu').get(0), true);
										jqListe.listeModifierElement(contenu);
							   			break;
							   		case 'supp':
							   			var id = $.trim($(this).find('id').text());
							   			jqListe.listeSupprimerElement(id);
							   			break;
							   	}
							});
				   	   	}
				   	}
			   	});
				break;
			case 'select':
				if (jqContexte.hasClass('jq_input_button') == true)
				{
					$(this).find('creat').each(function()
					{
						var id = $.trim($(this).find('id').text());
						var desc = $.trim($(this).find('desc').text());
						var lib = $.trim($(this).find('lib').text());
						var cat = $.trim($(this).find('cat').text());
						jqContexte.inputButtonNotifNewSelect(id, lib, desc, cat);
					});
				}
				if (jqContexte.hasClass('jq_input_select') == true)
				{
				   	var ref = $.trim($(this).find('ref').text());
				   	var jqInputSelect = $('.jq_input_select');

				   	$(this).find('creatCat').each(function()
					{
						var id = $.trim($(this).find('id').text());
						var libelle = $.trim($(this).find('lib').text());
						jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectAjouterCategorie(id, libelle);
					   	});
					});

				   	var elemCreat = $(this).find('creat');
					elemCreat.each(function()
					{
						var id = $.trim($(this).find('id').text());
						var desc = $.trim($(this).find('desc').text());
						var lib = $.trim($(this).find('lib').text());
						var cat = $.trim($(this).find('cat').text());
						var activer = $.trim($(this).find('activer').text());
						if (activer == '0')
							activer = false;
						else if (activer == '1')
						   	activer = true;
						else if (elemCreat.length > 1)
						   	activer = false;
						else
							activer = true;
						var activerAutre = false;
						if (jqContexte.data('inputSelectRef') == ref)
						   	jqContexte.inputSelectAjouterElement(id, lib, desc, cat, activer);
						else
						   	activerAutre = activer;
						if (ref != '')
						{
						   	jqInputSelect.each(function()
						   	{
						   	   	if ($(this).data('inputSelectRef') == ref)
						   	   	   	$(this).inputSelectAjouterElement(id, lib, desc, cat, activerAutre);
						   	});
						}
					});

					$(this).find('sel').each(function()
					{
					   	var id = $.trim($(this).find('id').text());
					   	jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectSelectionnerElement(id);
					   	});
					});

					$(this).find('supp').each(function()
					{
						var id = $.trim($(this).find('id').text());
						jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectSupprimerElement(id);
					   	});
					});

					$(this).find('suppCat').each(function()
					{
						var id = $.trim($(this).find('id').text());
						jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectSupprimerCategorie(id);
					   	});
					});
				}
				else
				{
				   	var ref = $.trim($(this).find('ref').text());
				   	var jqInputSelect = $('.jq_input_select');
				   	$(this).find('creatCat').each(function()
					{
						var id = $.trim($(this).find('id').text());
						var libelle = $.trim($(this).find('lib').text());
						jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectAjouterCategorie(id, libelle);
					   	});
					});
					$(this).find('creat').each(function()
					{
						var id = $.trim($(this).find('id').text());
						var desc = $.trim($(this).find('desc').text());
						var lib = $.trim($(this).find('lib').text());
						var cat = $.trim($(this).find('cat').text());
						var activer = $.trim($(this).find('activer').text());
						if (activer == '1')
							activer = true;
						else
						   	activer = false;
						jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectAjouterElement(id, lib, desc, cat, activer);
					   	});
					});
					$(this).find('sel').each(function()
					{
					   	var id = $.trim($(this).find('id').text());
					   	jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectSelectionnerElement(id);
					   	});
					});
					$(this).find('supp').each(function()
					{
						var id = $.trim($(this).find('id').text());
						jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectSupprimerElement(id);
					   	});
					});
					$(this).find('suppCat').each(function()
					{
						var id = $.trim($(this).find('id').text());
						jqInputSelect.each(function()
					   	{
					   	   	if ($(this).data('inputSelectRef') == ref)
					   	   	   	$(this).inputSelectSupprimerCategorie(id);
					   	});
					});
				}
				break;
			case 'text':
				if (jqContexte.hasClass('jq_input_button') == true)
				{
					$(this).find('modif').each(function()
					{
						var lib = $.trim($(this).find('lib').text());
						jqContexte.inputButtonNotifNewText(lib);
					});
				}
				break;
			case 'contenu':
			   	if (jqContexte.hasClass('jq_classeur_onglet') == true && jqContexte.closest('#'+$.trim($(this).find('cadre').text())).length >= 1)
				{
				   	var contenu = XMLtoText($(this).find('contenu').get(0), true);
					var jqClasseur = jqContexte.closest('.jq_classeur');
					jqOnglet = jqClasseur.classeurAjouterContenuOnglet(jqContexte, contenu);
					if (jqOnglet != null)
					{
						var jqOngletContenu = jqOnglet.data('classeurContenu');
						if (jqOngletContenu != undefined && jqOngletContenu != '')
						{
						   	if (jqOngletContenu.css('display') == 'none')
						   		jqOngletContenu.css('visibility', 'hidden').height(0).show();
							AppliquerJavascript(jqOngletContenu);
							jqClasseur.classeurResetVisibiliteOnglet(jqOnglet);
							jqOngletContenu.css('visibility', 'visible').height('');
						}
					}
				}
				else
				{
					var jqCadre = $('#'+$.trim($(this).find('cadre').text()));
					var contenu = $(this).find('contenu:first').get(0);
					if (contenu != undefined)
					{
					   	jqCadre.show();//.css('visibility', 'hidden').height(0);
						jqCadre.html(XMLtoText(contenu, true));
						AppliquerJavascript(jqCadre);
						jqCadre.css('visibility', 'visible').height('');
					}
				}
				break;
			case 'erreur':
			   	var lib = $.trim($(this).find('lib').text());
			   	if (jqContexte.hasClass('jq_input_button') == true)
					jqContexte.inputButtonNotifErreur(lib);
				else
				   	jqContexte.trigger('erreurPop', lib);
				break;
			case 'onglet':
			   	var classeur = $.trim(jqElem.find('classeur').text());
			   	$('.jq_classeur').each(function()
			   	{
			   	   	if ($(this).data('classeurId') === classeur)
					{
					   	var nom = $.trim(jqElem.find('nom').text());
					   	var contenu = XMLtoText(jqElem.find('contenu').get(0), true);
					   	var fonctionChargement = $.trim(jqElem.find('fonctionChargement').text());
					   	var param = $.trim(jqElem.find('param').text());
					   	var charge = $.trim(jqElem.find('charge').text());
					   	var activer = $.trim(jqElem.find('activer').text());
			   	   		var jqOnglet = $(this).classeurAjouterOnglet(nom, contenu, fonctionChargement, param, charge, activer);
			   	   		AppliquerJavascript(jqOnglet);
			   	   	}
			   	});
				break;
			case 'classeur':
			   	var classeur = $.trim(jqElem.find('id').text());
			   	$('.jq_classeur').each(function()
			   	{
			   	   	if ($(this).data('classeurId') === classeur)
			   	   	   	$(this).classeurRecharger();
			   	});
			   	break;
			case 'suite':
			   	var contexte = $.trim(jqElem.find('contexte').text());
			   	if (chargerSuite === false)
			   		chargerSuite = new Array();
			   	chargerSuite[chargerSuite.length] = contexte;
			   	break;
			case 'css':
			   	var module = $.trim(jqElem.find('module').text());
			   	var source = $.trim(jqElem.find('source').text());
			   	var jqCss = $('head').find('#' + module);
			   	//if (modificationPresentationCss === false)
			   	//   	$('.jq_clignotant').ClignoterReinitialiser();
			   	if (jqCss.length >= 1)
			   		jqCss.attr('href', source);
			   	else
			   	   	$('head').append('<link id="' + module + '" rel="stylesheet" type="text/css" href="' + source + '"/>');
				modificationPresentationCss = true;
			   	break;
			case 'js':
			   	if (modificationPresentationJs === true)
			   		tabOC = new Array();
			   	var module = $.trim(jqElem.find('module').text());
			   	var source = $.trim(jqElem.find('source').text());
			   	var visualiseur = $.trim(jqElem.find('visualiseur').text());
			   	var jqJs = $('head').find('#' + module);
			   	if (jqJs.length >= 1)
			   		jqJs.attr('src', source);
			   	else
			   	   	$('head').append('<script id="' + module + '" type="text/javascript" src="' + source + '"/>');
			   	if (visualiseur == '1')
			   		presentationVisualiseur = true;
				modificationPresentationJs = true;
			   	break;
		}
	});

	if (modificationPresentationJs === true)
	{
	   	if (presentationVisualiseur === true)
	   	{
	   		tabObjCliVis = new Array();
			for (val in tabOC)
			{
			  	tabObjCliVis[val] = tabOC[val];
			}
	   		if (modificationPresentationCss === false)
	   		{
	   		   	var jqVisualiseur = $('.jq_visualiseur_vue');
	   		   	if (modificationPresentationCss === false)
	   		   	  	jqVisualiseur.find('.jq_clignotant').ClignoterReinitialiser();
		   	   	jqVisualiseur.find('.jq_clignotant_fininit').removeClass('jq_clignotant_fininit');
				jqVisualiseur.find('.jq_clignotant_debinit').removeClass('jq_clignotant_debinit');
				jqVisualiseur.find('.jq_input_form').each(function()
				{
				   	SetInputClignotementEtDimensions.call(this);
				});
	   		}
	   	}
	   	else
	   	{
	   	   	tabObjCli = new Array();
			for (val in tabOC)
			{
			  	tabObjCli[val] = tabOC[val];
			}

	   	   	if (modificationPresentationCss === false)
	   		{
	   		   	$('.jq_clignotant').ClignoterReinitialiser();
		   	   	$('.jq_clignotant_fininit').removeClass('jq_clignotant_fininit');
				$('.jq_clignotant_debinit').removeClass('jq_clignotant_debinit');
				$('.jq_input_form').each(function()
				{
				   	SetInputClignotementEtDimensions.call(this);
				});
	   		}
	   	}
	}

	if (modificationPresentationCss === true)
	{
	   	setTimeout(function()
	   	{
	   	   	$('.jq_fill').height('').fill();
		   	$('.jq_clignotant').ClignoterReinitialiser();
	   	   	$('.jq_clignotant_fininit').removeClass('jq_clignotant_fininit');
	   	   	$('.jq_clignotant_debinit').removeClass('jq_clignotant_debinit');
			$('.jq_input_form').each(function()
			{
			   	SetInputClignotementEtDimensions.call(this);
			});

			var jqVisualiseur = $('.jq_visualiseur_vue');
   		   	jqVisualiseur.find('.jq_clignotant').ClignoterReinitialiser();
	   	   	jqVisualiseur.find('.jq_clignotant_fininit').removeClass('jq_clignotant_fininit');
			jqVisualiseur.find('.jq_clignotant_debinit').removeClass('jq_clignotant_debinit');
			jqVisualiseur.find('.jq_input_form').each(function()
			{
			   	SetInputClignotementEtDimensions.call(this);
			});

			$('.jq_liste').each(function()
			{
				$(this).listeSetDimensions();
			});
		}, 200);
	}

	return chargerSuite;
};

function SetInputClignotementEtDimensions()
{
   	if ($(this).hasClass('jq_input_text') == true)
		$(this).inputTextSetClignotement();
	else if ($(this).hasClass('jq_input_select') == true)
		$(this).inputSelectSetClignotement().inputSelectSetDimensions();
	else if ($(this).hasClass('jq_input_button') == true)
		$(this).inputButtonSetClignotement().inputButtonSetDimensions();
	else if ($(this).hasClass('jq_input_new') == true)
		$(this).inputNewSetClignotement().inputNewSetDimensions();
	/*else if ($(this).hasClass('jq_input_checkbox') == true)
		$(this).inputCheckboxSetClignotement();
	else if ($(this).hasClass('jq_input_file') == true)
		$(this).inputFileSetClignotement();
	else if ($(this).hasClass('jq_input_liste') == true)
		$(this).inputListeSetClignotement();
	else if ($(this).hasClass('jq_input_listedb') == true)
		$(this).inputListeDoubleSetClignotement();*/
};

// From XML to Text.
function XMLtoText(xml, noRoot)
{
   	var text = '';
	var children = xml.childNodes;
	var childrenLength = children.length;
	
	if (noRoot !== true)
	{
		text = '<' + xml.nodeName;
		var attributs = xml.attributes;
		for (var i = 0; i < attributs.length; i++)
		{
		  	 text += ' ' + attributs[i].name + '="' + attributs[i].value + '"';
		}
		if (childrenLength === 0)
			text += '/>';
		else
			text += '>';
	}
		
  	for(var j = 0; j < childrenLength; j++)
	{
	   	 if (children[j].nodeType == 1)
	  	  	 text += XMLtoText(children[j]);
		 else if (children[j].nodeType == 3 && noRoot != true)
		   	text += children[j].nodeValue;
	}

	if (noRoot != true && childrenLength !== 0)
	   	text += '</' + xml.nodeName + '>';

	return text;
};

var AJAX_NON_INITIALISE = 0;
var AJAX_CONNEXION_OUVERTE = 1;
var AJAX_REQUETE_ENVOYEE = 2;
var AJAX_RECUPERATION_ENCOURS = 3;
var AJAX_RECUPERATION_TERMINEE = 4;
var AJAX_SUCCES = 5;
var AJAX_ERREUR_ANALYSE = 6;
var AJAX_ERREUR_CHARGEMENT = 7;

function TraitementAjax(url, data, dataType, type, success, error, complete)
{
   	var appeleur = this;

   	if (data == undefined || data == '')
   	{
   		data = $(this).data('donnees');
   		if (data !== '' && data != undefined)
   			data += '&';
   		else
   		   	data = '';
   		data += 'idPage=' + idPage;
   	}
   	else
   	   	data += '&idPage=' + idPage;
   	if (dataType == undefined)
   	   	dataType = 'xml';
   	if (type == undefined)
   		type = 'POST';
   	if (success == undefined || success == '')
   		success = function(retour) { TraitementAjaxSucces.call(appeleur, retour, dataType); };
   	if (error == undefined || success == '')
   		error = function(retour, message, erreur) { TraitementAjaxErreur.call(appeleur, retour, message, erreur); };
   	if (complete == undefined || complete == '')
   		complete = function(retour, message) { TraitementAjaxComplete.call(appeleur, retour, message); };

	$.ajax(
	{
	   	type: type,
	   	url: url,
		data: data,
		dataType: dataType,
		success: success,
		error: error,
		complete: complete
	});
};

function TraitementAjaxSucces(retour, dataType)
{
   	if (dataType == 'xml')
   	{
   	   	var suite = ChargerFromXML.call(this, retour);
   	  	if (suite !== false)
   	  	{
   	  	   	var donnees = 'suite=1';
   	  	   	for (var i = 0; i < suite.length; i++)
			{
		  	  	donnees += '&contextes[' + i + ']=' + suite[i];
			}
   	  	   	var ancienneDonnees = $(this).data('donnees');
   	  	   	$(this).data('donnees', donnees);
   		    Recharger.call(this);
   		    $(this).data('donnees', ancienneDonnees);
   		}
   	}
};

function TraitementAjaxErreur(retour, message, erreur)
{
   	alert(message);
	alert(retour.responseText);
	alert(erreur);

	if ($(this).hasClass('jq_input_button') == true)
	{
		$(this).inputButtonReset();
		$(this).inputButtonPret();
	}

	AlertErreur(retour.responseText);
};

function AlertErreur(dname)
{
   	try // IE.
	{
	  	xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  	   	xmlDoc.async=false;
  	   	xmlDoc.load(dname);

  	   	if (xmlDoc.parseError.errorCode != 0)
    	{
		    alert("Ligne " + xmlDoc.parseError.line +
		    ", Position " + xmlDoc.parseError.linePos +
		    "\nCode: " + xmlDoc.parseError.errorCode +
		    "\nRaison: " + xmlDoc.parseError.reason +
		    "\nSource: " + xmlDoc.parseError.srcText);
		    return(null);
    	}
  	}
	catch(e)
  	{
  	   	try // Autres.
    	{
		    xmlDoc=document.implementation.createDocument("","",null);
		    xmlDoc.async=false;
		    xmlDoc.load(dname);
		    if (xmlDoc.documentElement.nodeName=="parsererror")
		    {
			   	alert(xmlDoc.documentElement.childNodes[0].nodeValue);
			    return(null);
		    }
		}
	  	catch(e) {alert(e.message)}
  	}
	try
	{
	   	return(xmlDoc);
	}
	catch(e) {alert(e.message)}
	return(null);
};

function TraitementAjaxComplete(retour, message)
{
	//alert(retour.responseText);
	//alert(retour.getAllResponseHeaders());

	if ($(this).hasClass('jq_input_button') == true)
	{
		$(this).inputButtonReset();
		$(this).inputButtonPret();
	}
};

// Fonction javascript qui permet de réappliquer le javascript sur un élément.
function AppliquerJavascript(jqElem)
{
   	jqElem.find('.jq_color').color();
	jqElem.find('.jq_buffercouleur').ColorBuffer();
	jqElem.find('.jq_buffercouleur').css('top','200px').css('left','400px');

	jqElem.find('.jq_input_file').inputFile();
	jqElem.find('.jq_input_image').inputImage();
	jqElem.find('.jq_input_text').inputText();//{width: ''});
	jqElem.find('.jq_input_select').inputSelect().inputSelectActiverRechargement();
	jqElem.find('.jq_input_checkbox').inputCheckbox();

	//jqElem.find('.jq_input_radiobox').inputCheckbox({radioMode: true});
	var jqNews = jqElem.find('.jq_input_new');
	jqNews.inputNew();
	//jqElem.find('.jq_input_file').inputFile();
	var jqBoutons = jqElem.find('.jq_input_button');
	jqBoutons.inputButton();
	//jqElem.find('.jq_input_button_reset').inputButton({resetOnClick: true});
	// Initialisations post déclaration.
	jqBoutons.inputButtonDissocierSousForm().inputButtonInitialiserEtat();
	jqNews.inputNewCacher().inputNewActiverRechargement();

	//jqElem.find('.jq_classeur').classeur();
	jqElem.find('.jq_liste').liste();
	jqElem.find('.jq_input_liste').inputListe();
	jqElem.find('.jq_input_listedb').inputListeDouble();
	jqElem.find('.jq_classeur').classeur();

	jqElem.find('.jq_fill').fill();
};

function AppliquerJavascriptListe(jqElem)
{
	jqElem.find('.jq_liste').liste();
};

// Fonction qui charge à partir d'une liste de contextes.
function ChargerContextes()
{//alert('1-' + $(this).data('donnees'));
	TraitementAjax.call(this, pathFonctions + 'General/fCharger.php');
};

// Fonction qui ajoute un élément à un contexte.
function AjouterAuContexte()
{//alert('2-' + $(this).data('donnees'));
	TraitementAjax.call(this, pathFonctions + 'General/fCreer.php');
};

// Fonction qui modifie un élément d'un contexte.
function ModifierDansContexte()
{//alert('3-' + $(this).data('donnees'));
	TraitementAjax.call(this, pathFonctions + 'General/fModifier.php');
};

// Fonction qui supprime un élément d'un contexte.
function SupprimerDuContexte()
{//alert('4-' + $(this).data('donnees'));
	TraitementAjax.call(this, pathFonctions + 'General/fSupprimer.php');
};

function CliquerContexte()
{
	TraitementAjax.call(this, pathFonctions + 'General/fCliquer.php');
};

// Fonction qui recharge un référentiel d'un contexte.
function ChargerReferentielContexte()
{//alert('5-' + $(this).data('donnees'));
	TraitementAjax.call(this, pathFonctions + 'General/fChargerReferentiel.php');
};

function AjouterAuReferentiel()
{//alert('6-' + $(this).data('donnees'));
	TraitementAjax.call(this, pathFonctions + 'General/fAjouterAuReferentiel.php');
};

function SupprimerDuReferentiel()
{//alert('7-' + $(this).data('donnees'));
	TraitementAjax.call(this, pathFonctions + 'General/fSupprimerDuReferentiel.php');
};

function CreerJoueur()
{
	var donnees = $(this).data('donnees');
	donnees += '&utc='+((new Date().getTimezoneOffset() * 60) * (-1));
	$(this).data('donnees', donnees);
	AjouterAuContexte.call(this);
}

// Fonction de chargement de l'organisation.
function ChargerOrganisation()
{
	TraitementAjax.call(this, pathFonctions + 'General/fChargerOrganisation.php', '', 'html', 'POST', function(retour)
	{
		var jqBody = $('body');
		jqBody.html(retour);

		var backgroundImage = jqBody.css('background-image');
		var repeat = jqBody.css('background-repeat');
		if (repeat == undefined || repeat == '' || repeat == 'none' || repeat == 'no-repeat')
		{
			backgroundImage = backgroundImage.substring(4, backgroundImage.length - 1);
			// Corrige un bug Opera et IE qui met des "" autour du nom de l'image.
			backgroundImage = backgroundImage.replace('"','');
			backgroundImage = backgroundImage.replace('"','');
			$('#cadre_background_image').attr('src', backgroundImage).width('100%').disableSelection().css('display', 'block');
			jqBody.css('background-image', 'url("")');
		}

		var jqCadreInfoErreur = $('#cadre_info_erreur');
		var width = jqCadreInfoErreur.width();
		jqCadreInfoErreur.css('position', 'absolute').width(width).slideUp();
		jqBody.bind('erreurPop', function(e, libelle)
		{
		   	var rand = parseInt(Math.random() * 10000);
		   	var id = 'jq_erreur_' + rand;
		   	jqCadreInfoErreur.find('td:first').append('<div id="' + id + '" class="jq_erreur" style="display: none">' + libelle + '</div>');
			jqCadreInfoErreur.slideDown(300);
			jqCadreInfoErreur.find('#'+id).slideDown(300);
			setTimeout(function()
			{
			   	jqCadreInfoErreur.find('#'+id).slideUp(300, function(){$(this).remove()});
			   	var nbErreurs = 0;
			   	jqCadreInfoErreur.find('.jq_erreur').each(function()
			   	{
			   	   	nbErreurs++;
			   	});

			   	if (nbErreurs === 0)
			   		jqCadreInfoErreur.slideUp(300);
			}, 10000);
		});

		var jqCadreContenu = $('#cadre_contenu_contenu');
		jqCadreContenu.css('max-width', jqCadreContenu.width());

		var donnees = 'garderContextes=1&initialisation=1';
		$(this).data('donnees', donnees);
		ChargerContextes.call(this, donnees);

		//var pageActiveReload = RecupererValeurCookie('pageActiveReload');
		//if (pageActiveReload == idPage)
		//   	PageActive();
	});
};

function RecupererValeurCookie(nom)
{
   	var posDeb = document.cookie.indexOf(nom + '=');
   	posDeb += nom.length + 1;
    if (posDeb >= 0)
	{
		var posFin = document.cookie.indexOf(';', posDeb);
	    if (posFin < 0)
		   	posFin = document.cookie.length;
		return document.cookie.substring(posDeb, posFin);
	}
	return '';
}

function Recharger()
{//alert('8-' + $(this).data('donnees'));
   	TraitementAjax.call(this, pathFonctions + 'General/fRecharger.php');
}

function RechargerAuto()
{
   	var donnees = 'auto=1';
	$(this).data('donnees', donnees);
   	TraitementAjax.call(this, pathFonctions + 'General/fRecharger.php');
    //setTimeout('RechargerAuto()', dureeRechargement);
}
//setTimeout('RechargerAuto()', dureeRechargement);