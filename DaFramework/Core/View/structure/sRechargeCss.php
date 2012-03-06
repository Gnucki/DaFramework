<?php

require_once 'cst.php';
require_once INC_SBALISE;

define ('XMLCSS_LISTE','liste');
define ('XMLCSS_CSS','css');
define ('XMLCSS_ID','id');
define ('XMLCSS_LIEN','lien');

class SRechargeCss extends SBalise
{
	public function __construct()
	{
		parent::__construct(XMLCSS_LISTE);
	}

	protected function AjouterElement($id, $lien)
	{
		$element = new SBalise(XMLCSS_CSS, true);
		
		$balId = new SBalise(XMLCSS_ID, true);
		$balId->SetText($id);
		
		$balLien = new SBalise(XMLCSS_LIEN, true);
		$balLien->SetText($lien);
		
		$element->Attach($balId);
		$element->Attach($balLien);

		$this->Attach($element);
	}
}

?>