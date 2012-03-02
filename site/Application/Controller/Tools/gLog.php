<?php

require_once 'cst.php';
require_once INC_CSTEXCEPTIONS;
require_once INC_CSTWARNINGS;
require_once INC_GREPONSE;


class GLog
{
	public static function LeverException($code, $libelle, $affichageJoueur = false, $logFichier = true)
	{
	   	if ($affichageJoueur === true)
		   	GReponse::AjouterElementErreur(strval($code), $libelle);

		if ($logFichier === true)
		{
		   	if (is_int($libelle))
		   		$libelle = GSession::Libelle($libelle, false, true);

			$fichier = fopen(PATH_SERVER_LOCAL.'log/exceptions'.date('Y-m-d').'.txt', 'a+');
			$remoteHost = '';
			if (array_key_exists('REMOTE_HOST', $_SERVER))
				$remoteHost = $_SERVER['REMOTE_HOST'];
			fwrite($fichier, date('H:i:s').' - '.$_SERVER['REMOTE_ADDR'].' - '.$remoteHost.' - '.$code.': '.$libelle."\r\n");
			fclose($fichier);
		}
	}

	public static function LeverWarning($code, $libelle, $affichageJoueur = false, $logFichier = true)
	{
		if ($affichageJoueur === true)
		   	GReponse::AjouterElementWarning(strval($code), $libelle);

		if ($logFichier === true)
		{
		   	if (is_int($libelle))
		   		$libelle = GSession::Libelle($libelle, false, true);

			$fichier = fopen(PATH_SERVER_LOCAL.'log/warnings'.date('Y-m-d').'.txt', 'a+');
			$remoteHost = '';
			if (array_key_exists('REMOTE_HOST', $_SERVER))
				$remoteHost = $_SERVER['REMOTE_HOST'];
			fwrite($fichier, date('H:i:s').' - '.$_SERVER['REMOTE_ADDR'].' - '.$remoteHost.' - '.$code.': '.$libelle."\r\n");
			fclose($fichier);
		}
	}
}

?>