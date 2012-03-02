<?php

require_once INC_SBALISE;

class JsListeScripts extends SBalise
{
   	static private $js;
   	private $scripts;

	public function __construct()
	{
	   	$this->scripts = array();
	}

	static public function GetInstance()
	{
		if (JsListeScripts::$js == NULL)
	   		JsListeScripts::$js = new JsListeScripts();
		return JsListeScripts::$js;
	}

	static public function Init()
	{
	   	JsListeScripts::$js == NULL;
	}

	public function AddScript($fichier)
	{
	   	$balise = new SBalise(BAL_SCRIPT);
	   	$balise->AddProp(PROP_TYPE, TYPE_JAVASCRIPT);
	   	$balise->AddProp(PROP_SRC, $fichier);
	   	$this->scripts[] = $balise;
	}

	public function BuildHTML()
	{
	   	$HTML = '';
	   	while(list($i, $script) = each($this->scripts))
		{
		    $HTML .= $script->BuildHTML();
		}
		return $HTML;
	}

}

JsListeScripts::Init();

?>