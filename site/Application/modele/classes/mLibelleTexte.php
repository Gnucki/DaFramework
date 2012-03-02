<?php

require_once 'cst.php';
require_once PATH_METIER.'mLibelle.php';


class MLibelleTexte extends MLibelle
{
	public function GetNom()
	{
	   	return 'MLibelleTexte';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_LIBELLETEXTE);
	}

	/*************************************/
	public function Libelle($libelle = NULL)
	{
		return $this->ValeurStrVerifiee(COL_LIBELLE, $libelle, 0, NULL);
	}
}

?>