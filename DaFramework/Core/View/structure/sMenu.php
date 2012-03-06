<?php

require_once 'cst.php';
require_once INC_SELEMENT;
require_once INC_JSFONCTION;


class SMenu extends SElement
{
    //private $sousMenus;
    protected $id;
    protected $jsOnClick;

    public function __construct($titre = '', $id = '', $class = '', $onClick = '')
    {
       	parent::__construct($class, $id);
	   	//$this->sousMenus = array();

		$this->id = $id;
	   	if ($id !== '')
	   	   	$this->AddProp(PROP_ID, $id);
	   	if ($class !== '')
	   		$this->AddProp(PROP_CLASS, $class);
	   	if ($titre !== '')
	   	   	$this->SetText($titre);
	   	$this->jsOnClick = '';
	   	if ($onClick !== '')
		   	$this->jsOnClick .= $onClick;
	}

	public function AddSousMenu($nouvSousMenu)
	{
	   	$this->enfants[] = $nouvSousMenu;
	}

	public function GetId()
	{
	   	return $this->id;
	}

	public function BuildHTML()
    {
       	if ($this->jsOnClick !== '')
       	{
       	   	$jsFoncStopEvent = new JsFonction(JS_STOPEVENEMENT_NAME, JS_STOPEVENEMENT_NBPARAMS);
	   		$jsFoncStopEvent->AddParamEvent();
       		$this->AddProp(PROP_ONCLICK, $this->jsOnClick.';'.$jsFoncStopEvent->BuildJS());
       	}

		return parent::BuildHTML();

		/*$HTML = parent::BuildHTML();
       	while(list($i, $sousMenu) = each($this->sousMenus))
		{
		    $HTML .= $sousMenu->BuildHTML();
		}
		return $HTML;*/
	}
}

?>