<?php

require_once 'cst.php';


define ('FORMATTEXTE_SIMPLE', 1);


class GTexte
{
	public static function Formater($chaine, $format, $affichage = true)
	{
	   	$chaineFormatee = $chaine;

	   	switch ($format)
		{
	   		case FORMATTEXTE_SIMPLE:
	   			$chaineFormatee = self::FormaterTexteSimple($chaine, $affichage);
	   			break;
	   	}

	   	return $chaineFormatee;
	}

	public static function FormaterTexteSimple($chaine, $affichage = true)
	{
	   	$xml = array();
	   	$offset = 0;
	   	$oldOffset = -8;
	   	$chaineFormatee = '';
	   	$infBal = to_html('<');
	   	$supBal = to_html('>');

	   	while(($pos = strpos($chaine, $infBal, $offset)) !== false)
		{
		   	$offset = strpos($chaine, $supBal, $pos);
		   	$att = strpos($chaine, ' ', $pos);

		   	if ($offset === false)
		   		$offset = strlen($chaine);

		   	// Balise fermée.
		   	if (substr($chaine, $pos + 8, 1) === '/')
			{
		   		$balise = strtolower(substr($chaine, $pos + 9, $offset - $pos - 9));
		   		switch ($balise)
				{
			   		case BAL_I:
			   		case BAL_U:
			   		case BAL_B:
			   		   	$chaineFormatee .= substr($chaine, $oldOffset + 8, $pos - $oldOffset - 8);
			   		   	// Partie qui permet de réordonner les balises dans un ordre correcte.
						if (in_array($balise, $xml))
			   		   	{
			   		   	   	$baliseDer = array_pop($xml);
							while ($baliseDer !== NULL)
							{
							   	$chaineFormatee .= '</'.$baliseDer.'>';

							   	if ($balise === $baliseDer)
							   		$baliseDer = NULL;
							   	else
							   	   	$baliseDer = array_pop($xml);
							}
						}
						break;
					default:
					   	$chaineFormatee .= substr($chaine, $oldOffset + 8, $offset - $oldOffset);
			   	}
		   	}
		   	// Balise ouverte.
		   	else
		   	{
		   	   	$balise = '';
		   	   	// Pas d'attributs à la balise.
			   	if ($att === false || $att >= $offset)
			   		$balise = strtolower(substr($chaine, $pos + 8, $offset - $pos - 8));
			   	// La balise possède des attributs (par ex style, class, ...).
				else
			   	   	$balise = strtolower(substr($chaine, $pos + 8, $att - $pos - 8));
			   	switch ($balise)
				{
			   		case BAL_I:
			   		case BAL_U:
			   		case BAL_B:
			   			$xml[] = $balise;
			   			$chaineFormatee .= substr($chaine, $oldOffset + 8, $pos - $oldOffset - 8).'<'.$balise.'>';
			   			break;
					default:
					   	$chaineFormatee .= substr($chaine, $oldOffset + 8, $offset - $oldOffset);
			   	}
			}

			$oldOffset = $offset;
	   	}

	   	// Fermeture automatique des balises encore ouverte.
	   	$baliseDer = array_pop($xml);
		while ($baliseDer !== NULL)
		{
		   	$chaineFormatee .= '</'.$baliseDer.'>';
		   	$baliseDer = array_pop($xml);
		}

	   	if ($offset !== 0)
	   		$offset += 8;

	   	$chaineFormatee .= substr($chaine, $offset, strlen($chaine));
	   	// Si c'est pour un affichage normal, on remplace les sauts de lignes par leurs équivalents html.
	   	// Si c'est dans une textarea on ne doit pas le faire.
	   	if ($affichage === true)
	   	   	$chaineFormatee = str_replace(array("\n\r", "\r\n", "\n", "\r"), '<br/>', $chaineFormatee);
		return $chaineFormatee;
	}
}

?>