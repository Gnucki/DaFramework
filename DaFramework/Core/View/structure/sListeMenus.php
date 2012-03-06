<?php

require_once 'cst.php';
require_once INC_IOBJETHTML;
require_once INC_SMENU;
require_once INC_SBALISE;

class SListeMenus extends SBalise
{
    //protected $menus;
    protected $currentMenu;

    public function __construct()
    {
       	parent::__construct(BAL_DIV);
       	$this->currentMenu = NULL;
	   	//$this->menus = array();
	}

	public function AddMenu($titre, $id, $class)
	{
	   	$this->currentMenu = new SMenu($titre, $id, $class);
	   	$this->Attach($this->currentMenu);
	   	//$this->menus[] = $this->currentMenu;
	}

	public function AddSousMenu($titre, $id, $class)
	{
	   	if ($this->currentMenu != NULL)
		{
		   	$nouvSousMenu = new SMenu($titre, $id, $class);
	   		$this->currentMenu->AddSousMenu($nouvSousMenu);
	   	}
	}

	/*public function BuildHTML()
    {
       	$HTML = '';
       	while(list($i, $menu) = each($this->menus))
		{
		    $HTML .= $menu->BuildHTML();
		}
		return $HTML;
	}*/
}
?>