<?php

require_once 'cst.php';
require_once INC_SBALISE;


class SImage extends SBalise
{
	public function __construct($location, $noImage = '', $verifValideImage = true)
	{
	   	parent::__construct(BAL_IMAGE);

		// Protection contre le CSRF (ne pas enlever!!).
		if ($location !== '' && ($verifValideImage === false || ($verifValideImage === true && getimagesize(PATH_SERVER_LOCAL.$location) !== false)))
			$this->AddProp(PROP_SRC, PATH_SERVER_HTTP.$location);
		else
		{
			//if ($noImage !== '')
				$this->AddProp(PROP_SRC, $noImage);
			//else
			//	$this->AddProp(PROP_SRC, 'url::noImage'); // A REMPLACER..
		}
	}
}

?>