<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SINPUT;

/* CSS minimum:
// [] = $prefixIdClass.
.[]_select_label
{
}

.[]_select_contenu
{
}

.[]_select_select
{
	width: 200px;
	position: relative;
}

.[]_select_valeur
{
	width: 100%;
}

.[]_select_valeuredit
{
	width: 99%;
}

.[]_select_derouleur
{
	cursor: pointer;
	font-family: Verdana, sans-serif;
	font-size: 11px;
}

.[]_select_liste
{
	width: 100%;
	overflow: hidden;
	position: absolute;
	visibility: hidden;
	padding: 0;
	margin: 0;
	height: 0;
	z-index: 4;
	cursor: pointer;
}

.[]_select_listetab
{
	width: 100%;
}

.[]_select_info
{
	position: absolute;
	z-index: 5;
	display: none;
}

.[]_select_element
{
}
*/


define ('SELECT_LABEL', '_select_label');
define ('SELECT_CONTENU', '_select_contenu');
define ('SELECT_SELECT', '_select_select');
define ('SELECT_VALEUR', '_select_valeur');
define ('SELECT_VALEUREDIT', '_select_valeuredit');
define ('SELECT_DEROULEUR', '_select_derouleur');
define ('SELECT_LISTE', '_select_liste');
define ('SELECT_LISTETAB', '_select_listetab');
define ('SELECT_INFO', '_select_info');
define ('SELECT_ELEMENT', '_select_element');

define ('SELECT_ID', 'select_id');
define ('SELECT_LIBELLE', 'select_libelle');
define ('SELECT_DESCRIPTION', 'select_description');


// $prefixIdComp sert au cas où il existerait plusieurs select sur la page avec le même $prefixIdClass.
class SSelectPerso extends STableau
{
	protected $prefixIdClass;
	protected $prefixIdComp;
	protected $liste;

	public function __construct($prefixIdClass, $label = '', $prefixIdComp = '')
	{
		parent::__construct();
		$this->prefixIdClass = $prefixIdClass;
		$this->prefixIdComp = $prefixIdComp;

		$this->AddLigne();

		if ($label !== '')
		{
			$cellule = $this->AddCellule();
			$cellule->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_LABEL);
			$cellule->SetText($label);
		}

		$cellule = $this->AddCellule();
		$cellule->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_CONTENU);

		$select = new SBalise(BAL_DIV);
		$select->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_SELECT);
		$cellule->Attach($select);

		$info = new SBalise(BAL_DIV);
		$info->AddProp(PROP_ID, $this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
		$info->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_INFO);
		$cellule->Attach($info);

		$selectTab = new STableau(true);
		$select->Attach($selectTab);

		$selectTab->AddLigne();
		$cellule = $selectTab->AddCellule();
		$cellule->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_VALEUR);

		$edit = new SInput($this->prefixIdClass.$this->prefixIdComp.SELECT_VALEUREDIT, 'text', '', $this->prefixIdClass.SELECT_VALEUREDIT);
		$jsFonc = new JsFonction(JS_INPUTSELECT_ONKEYUP_NAME, 4);
	   	$jsFonc->AddParamEvent();
	   	$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_VALEUREDIT);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
		$edit->AddProp(PROP_ONKEYUP, $jsFonc->BuildJS());
		$jsFonc = new JsFonction(JS_INPUTSELECT_ONFOCUS_NAME, 3);
	   	$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_VALEUREDIT);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
		$edit->AddProp(PROP_ONFOCUS, $jsFonc->BuildJS());
		$jsFonc = new JsFonction(JS_INPUTSELECT_ONBLUR_NAME, 3);
	   	$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_VALEUREDIT);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
		$edit->AddProp(PROP_ONBLUR, $jsFonc->BuildJS());
		$cellule->Attach($edit);

		$cellule = $selectTab->AddCellule();
		$cellule->AddProp(PROP_ID, $this->prefixIdClass.$this->prefixIdComp.SELECT_DEROULEUR);
		$cellule->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_DEROULEUR);
		$jsFonc = new JsFonction(JS_INPUTSELECT_ONCLICK_NAME, 3);
	   	$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_VALEUREDIT);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
		$cellule->AddProp(PROP_ONCLICK, $jsFonc->BuildJS());
		$jsFonc = new JsFonction(JS_INPUTSELECT_ONMOUSEOVER_NAME, 4);
		$jsFonc->AddParamThis();
	   	$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_VALEUREDIT);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
		$cellule->AddProp(PROP_ONMOUSEOVER, $jsFonc->BuildJS());
		$jsFonc = new JsFonction(JS_INPUTSELECT_ONMOUSEOUT_NAME, 4);
		$jsFonc->AddParamThis();
	   	$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_VALEUREDIT);
		$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
		$cellule->AddProp(PROP_ONMOUSEOUT, $jsFonc->BuildJS());
		$cellule->SetText('v');

		$selectTab->AddLigne();
		$cellule = $selectTab->AddCellule();
		$cellule->AddProp(PROP_COLSPAN, 2);

		$liste = new SBalise(BAL_DIV);
		$liste->AddProp(PROP_ID, $this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
		$liste->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_LISTE);
		$cellule->Attach($liste);

		$this->liste = new STableau();
		$this->liste->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_LISTETAB);
		$liste->Attach($this->liste);
	}

	public function AjouterElement($id, $libelle, $description = '')
	{
		if ($id != '' && $libelle != '')
		{
			$this->liste->AddLigne();
			$cellule = $this->liste->AddCellule();
			$cellule->AddProp(PROP_ID, $this->prefixIdClass.$this->prefixIdComp.SELECT_ELEMENT.$id);
			$cellule->AddProp(PROP_CLASS, $this->prefixIdClass.SELECT_ELEMENT);
			$jsFonc = new JsFonction(JS_INPUTSELECT_ONMOUSEDOWNELEMENT_NAME, 4);
			$jsFonc->AddParamThis();
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
			$jsFonc->AddParamText($this->prefixIdClass.SELECT_VALEUREDIT);
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
			$cellule->AddProp(PROP_ONMOUSEDOWN, $jsFonc->BuildJS());
			$jsFonc = new JsFonction(JS_INPUTSELECT_ONMOUSEUPELEMENT_NAME, 4);
			$jsFonc->AddParamThis();
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
			$jsFonc->AddParamText($this->prefixIdClass.SELECT_VALEUREDIT);
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
			$cellule->AddProp(PROP_ONMOUSEUP, $jsFonc->BuildJS());
			$jsFonc = new JsFonction(JS_INPUTSELECT_ONMOUSEOVERELEMENT_NAME, 5);
			$jsFonc->AddParamThis();
			$jsFonc->AddParamEvent();
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
			$jsFonc->AddParamText($this->prefixIdClass.SELECT_VALEUREDIT);
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
			$cellule->AddProp(PROP_ONMOUSEOVER, $jsFonc->BuildJS());
			$jsFonc = new JsFonction(JS_INPUTSELECT_ONMOUSEOUTELEMENT_NAME, 5);
			$jsFonc->AddParamThis();
			$jsFonc->AddParamEvent();
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_LISTE);
			$jsFonc->AddParamText($this->prefixIdClass.SELECT_VALEUREDIT);
			$jsFonc->AddParamText($this->prefixIdClass.$this->prefixIdComp.SELECT_INFO);
			$cellule->AddProp(PROP_ONMOUSEOUT, $jsFonc->BuildJS());

			$divId = new SBalise(BAL_DIV);
			$divId->AddProp(PROP_CLASS, SELECT_ID);
			$divId->AddProp(PROP_STYLE, 'display: none');
			$divId->SetText($id);
			$cellule->Attach($divId);

			$divLibelle = new SBalise(BAL_DIV);
			$divLibelle->AddProp(PROP_CLASS, SELECT_LIBELLE);
			$divLibelle->SetText($libelle);
			$cellule->Attach($divLibelle);

			if ($description !== '')
			{
				$divDescription = new SBalise(BAL_DIV);
				$divDescription->AddProp(PROP_CLASS, SELECT_DESCRIPTION);
				$divDescription->AddProp(PROP_STYLE, 'display: none');
				$divDescription->SetText($description);
				$cellule->Attach($divDescription);
			}
		}
	}
}