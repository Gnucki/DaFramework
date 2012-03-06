<?php

require_once 'cst.php';
require_once INC_GSESSION;
require_once INC_SINPUTFILE;


/*echo '<?xml version="1.0" encoding="utf-8"?>';*/
//echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n\n";
session_start();
$uploadOk = false;

$fichier = NULL;
while (list($f, $fich) = each($_FILES))
{
   	$fichier = $fich;
}

$type = '';
$id = -1;
while (list($nom, $val) = each($_POST))
{
	if (strpos($nom, 'type') !== false)
		$type = $val;
	else if (strpos($nom, 'id') !== false)
		$id = intval($val);
}

echo '<html><head></head><body>';// onload="alert(window.document.body.innerHTML);">';

/*echo '-'.$type;
echo '-'.$id;
echo '-';*/

if ($type != '' && $fichier != NULL)
{
	$cheminDest = '';
	switch ($type)
	{
		case TYPEFICHIER_IMAGEPERSO:
		   	if ($id > 0)
			   	$cheminDest = 'stockage/images/perso/'.$id.'/'.basename($fichier['name']);
			break;
		case TYPEFICHIER_IMAGEGROUPE:
			if ($id > 0)
			   	$cheminDest = 'stockage/images/groupe/'.$id.'/'.basename($fichier['name']);
			break;
		case TYPEFICHIER_IMAGEGLOBALE_COMMUNAUTE:
		   	//if (GDroit::ADroit(DROIT_ADMIN) === true)
			   	$cheminDest = 'images/Communaute/'.basename($fichier['name']);
			echo $cheminDest.'.';
			break;
		case TYPEFICHIER_IMAGEGLOBALE_GRADE:
		   	//if (GDroit::ADroit(DROIT_ADMIN) === true)
			   	$cheminDest = 'images/Grade/'.basename($fichier['name']);
			echo $cheminDest.'.';
			break;
		case TYPEFICHIER_IMAGEGLOBALE_LANGUE:
		   	//if (GDroit::ADroit(DROIT_ADMIN) === true)
			   	$cheminDest = 'images/Langue/'.basename($fichier['name']);
			echo $cheminDest.'.';
			break;
		case TYPEFICHIER_IMAGEGLOBALE_JEU:
		   	//if (GDroit::ADroit(DROIT_ADMIN) === true)
			   	$cheminDest = 'images/Jeu/'.basename($fichier['name']);
			echo $cheminDest.'.';
			break;
	}

	if ($cheminDest != '')
	{
		$cheminSrc = $fichier['tmp_name'];
		if (move_uploaded_file($cheminSrc, PATH_SERVER_LOCAL.$cheminDest))
		{
			//echo $type.'-'.basename($fichier['name']).';'.basename($fichier['name']).';'.PATH_SERVER_HTTP.$cheminDest;
			$uploadOk = true;
		}
	}
}

//if ($uploadOk === false)
//	echo 'noFichier';

echo '</body></html>';

?>