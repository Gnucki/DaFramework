<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetGrade.php';


class MGradeGlobal extends MObjetGrade
{
	public function GetNom()
	{
	   	return 'MGradeGlobal';
	}

	public function GetObjetBase()
	{
	   	return new BObjetBase(TABLE_GRADEGLOBAL);
	}

	protected function GetNouvelleListeGradesJoueurs()
	{
	   	return new MListeGradesGlobauxJoueurs();
	}
}

?>