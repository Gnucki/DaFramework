<?php

require_once 'cst.php';
require_once INC_SBALISE;

class CssListeStyles extends SBalise
{
   	static private $css;
   	private $styles;

	public function __construct()
	{
	   	$this->styles = array();
	}

	static public function GetInstance()
	{
		if (self::$css == NULL)
	   		self::$css = new CssListeStyles();
		return self::$css;
	}

	static public function Init()
	{
	   	CssListeStyles::$css == NULL;
	}

	public function AddStyle($fichier)
	{
		$style = new SBalise(BAL_LINK);
		$style->AddProp(PROP_REL, 'stylesheet');
		$style->AddProp(PROP_TYPE, 'text/css');
		$style->AddProp(PROP_HREF, $fichier);
	   	$this->styles[] = $style;
	}

	public function BuildHTML()
	{
	   	$HTML = '';
	   	while(list($i, $style) = each($this->styles))
		{
		    $HTML .= $style->BuildHTML();
		}
		return $HTML;
	}

}

CssListeStyles::Init();

?>