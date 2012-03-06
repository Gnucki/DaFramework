<?php

require_once 'cst.php';
require_once INC_GDATE;
require_once PATH_BASE.'bObjetBase.php';


define ('MOM_CHAMP_VALEUR', 'valeur');
define ('MOM_CHAMP_TYPE', 'type');
define ('MOM_CHAMP_COMP', 'comp'); // Comportement.
define ('MOM_CHAMP_COMPVAR', 'compvar'); // Variables du comportement.
define ('MOM_CHAMP_NOTNULL', 'notnull');
define ('MOM_CHAMP_VALPARDEFAUT', 'defaut');
define ('MOM_CHAMP_MIN', 'min');
define ('MOM_CHAMP_MAX', 'max');
define ('MOM_CHAMP_LONGUEURMIN', 'lmin');
define ('MOM_CHAMP_LONGUEURMAX', 'lmax');
define ('MOM_CHAMP_REGEXP', 'regexp');
define ('MOM_CHAMP_NOMCLASSE', 'nomclasse');
define ('MOM_CHAMP_ARGSTRING', 'argstr');
define ('MOM_CHAMP_ARGS', 'args');

define ('MOM_LISTE_VALEUR', 'valeur');
define ('MOM_LISTE_TYPEOBJETS', 'typeObjets');

define ('MOM_CHAMPTYPE_INT', 'int');
define ('MOM_CHAMPTYPE_STR', 'str');
define ('MOM_CHAMPTYPE_OBJ', 'obj');
define ('MOM_CHAMPTYPE_BOOL', 'bool');
define ('MOM_CHAMPTYPE_DATE', 'date');
define ('MOM_CHAMPTYPE_TIME', 'date');
define ('MOM_CHAMPTYPE_DATETIME', 'date');
define ('MOM_CHAMPTYPE_LIST', 'list');

define ('MOM_JOINTURE_COLTHIS', 'colthis');
define ('MOM_JOINTURE_COLAUTRE', 'colautre');
define ('MOM_JOINTURE_OBJET', 'objet');
define ('MOM_JOINTURE_NUMOBJET', 'numobjet');
define ('MOM_JOINTURE_TYPE', 'type');

define ('MOM_TYPEREQ_CHARGEMENT', 'chargement');
define ('MOM_TYPEREQ_AJOUT', 'ajout');
define ('MOM_TYPEREQ_MODIFICATION', 'modification');
define ('MOM_TYPEREQ_SUPPRESSION', 'suppression');
define ('MOM_TYPEREQ_GETNBELEMENTS', 'getnbelements');

define ('MOM_COMPCHAMP_LIBELLE', 'libelle');
define ('MOM_COMPCHAMP_ORDRE', 'ordre');


class MObjetMetier
{
   	private $initialise;
   	protected $champs;
	protected $listes;
   	protected $jointures;
   	protected $bufferColSel;
   	protected $bufferColIns;
   	protected $bufferColModif;
   	protected $bufferColCond;
   	protected $objetsJoints;
	private $clePrimaire;
	protected $idAutoInc;
	protected $noId;
	protected $bufferColOrdre;
	protected $supprimerSurJointure;
	protected $modifierSurJointure;
	private $mappingColAs;

	private static $numChamp;

	public function __construct($id = NULL)
	{
		if ($id != NULL)
			$this->SetObjet($id);
	}

	public function __destruct()
	{
		$this->UnsetObjet();
	}

	public function SetObjet($id = NULL)
	{
	   	if ($this->initialise !== true)
	   	{
		   	$this->objetsJoints = NULL;
		   	$this->ResetBuffers();
		   	$this->champs = array();
			$this->listes = array();
		   	$this->initialise = true;
		   	$this->idAutoInc = true;
		   	$this->supprimerSurJointure = false;
		   	$this->modifierSurJointure = false;
			$this->mappingColAs = array();
		}

		if ($this->clePrimaire === NULL)
			$this->ClePrimaire(COL_ID, true);
	}

	public function SetObjetFromTableau($tableau)
	{
	    foreach ($tableau as $nom => $valeur)
		{
		   	$noms = $nom;
			if (strpos($nom, ',') !== false)
	   	   		$noms = explode(',', $nom);
		   	$this->SetChampFromTableau($noms, $valeur);
		}
	}

	public function SetObjetFromSQL($resultat, $bufferColSelExt = NULL)
	{
	   	/*$bufferColSel = $this->bufferColSel;
	   	if ($bufferColSelExt !== NULL)
	   		$bufferColSel = $bufferColSelExt;

		foreach ($bufferColSel as $nom => $as)
		{
		   	$nomCol = $nom;
			if ($as !== NULL)
			{
			   	if (is_array($as))
			   		$nomCol = $as[SQLFONCTION_AS];
			   	else
			   	   	$nomCol = $as;
			}

			$this->SetChampSQL($nom, $resultat[$nomCol]);
		}*/

		foreach ($this->mappingColAs as $col => $as)
		{
			$this->SetChampSQL($col, $resultat[$as]);
		}

		if ($this->objetsJoints !== NULL)
		{
			foreach($this->objetsJoints as $mObjetJoint)
			{
				$mObjetJoint->SetObjetFromSQL($resultat);
			}
		}

		$this->mappingColAs = array();
	}

	public function UnsetObjet()
	{
		unset($this->champs);
	}

	public function GetNom()
	{
	   	return 'MObjetMetier';
	}

	public function GetObjetBase()
	{
	   	return NULL;
	}

	public function GetNouvelleListe()
	{
	   	return NULL;
	}

	/*************************************/
	public function ClePrimaire($clePrimaire = NULL, $autoInc = NULL)
	{
		if ($clePrimaire === NULL)
			return $this->clePrimaire;

		if ($autoInc !== NULL)
			$this->autoInc = $autoInc;

		if (is_string($clePrimaire))
			$this->clePrimaire = array($clePrimaire);
		else if (is_array($clePrimaire))
			$this->clePrimaire = $clePrimaire;
	}

	protected function AutoInc()
	{
		if ($this->autoInc === true)
			return true;
		return false;
	}

	protected function IsChampClePrimaire($nomChamp)
	{
		foreach ($this->ClePrimaire() as $colClePrimaire)
		{
			if ($colClePrimaire === $nomChamp)
				return true;
		}
		return false;
	}

	/*************************************/
	public function Id($id = NULL)
	{
	   	if ($id === -1)
	   		$id = NULL;
		return $this->ValeurIntVerifiee(COL_ID, $id, 1, NULL, NULL, true);
	}

	/*************************************/
	protected function InitChampInt($nom, $type, $min, $max, $valeurParDefaut, $notNull)
	{
	   	if ($this->InitChamp($nom, $type, $valeurParDefaut, $notNull))
	   	{
		   	$this->champs[$nom][MOM_CHAMP_MIN] = $min;
		   	$this->champs[$nom][MOM_CHAMP_MAX] = $max;
		   	$this->champs[$nom][MOM_CHAMP_REGEXP] = '^[0-9]+$';
		}
	}

	protected function InitChampStr($nom, $type, $longueurMin, $longueurMax, $regexp, $valeurParDefaut, $notNull)
	{
	   	if ($this->InitChamp($nom, $type, $valeurParDefaut, $notNull))
	   	{
		   	$this->champs[$nom][MOM_CHAMP_LONGUEURMIN] = $longueurMin;
		   	$this->champs[$nom][MOM_CHAMP_LONGUEURMAX] = $longueurMax;
		   	$this->champs[$nom][MOM_CHAMP_REGEXP] = $regexp;
		}
	}

	protected function InitChampObjet($nom, $type, $nomClasse, $argumentsString, $arguments, $valeurParDefaut, $notNull)
	{
	   	if ($this->InitChamp($nom, $type, $valeurParDefaut, $notNull))
	   	{
	   	   	$this->champs[$nom][MOM_CHAMP_NOMCLASSE] = $nomClasse;
	   	   	$this->champs[$nom][MOM_CHAMP_ARGSTRING] = $argumentsString;
	   	   	$this->champs[$nom][MOM_CHAMP_ARGS] = $arguments;
	   	}
	}

	private function InitChamp($nom, $type, $valeurParDefaut, $notNull)
	{
	   	if (!array_key_exists($nom, $this->champs))
	   	{
	   		$this->champs[$nom] = array();
	   		$this->champs[$nom][MOM_CHAMP_VALEUR] = NULL;
	   		$this->champs[$nom][MOM_CHAMP_TYPE] = $type;
	   		$this->champs[$nom][MOM_CHAMP_NOTNULL] = $notNull;
	   		$this->champs[$nom][MOM_CHAMP_VALPARDEFAUT] = $valeurParDefaut;
			$this->champs[$nom][MOM_CHAMP_COMP] = NULL;

	   		return true;
	   	}

	   	return false;
	}

	private function GetChampComportement($nom)
	{
		return $this->champs[$nom][MOM_CHAMP_COMP];
	}

	private function GetChampComportementVar($nom)
	{
		return $this->champs[$nom][MOM_CHAMP_COMPVAR];
	}

	private function SetChampComportement($nom, $comp, $compVar = NULL)
	{
		$this->champs[$nom][MOM_CHAMP_COMP] = $comp;
		$this->champs[$nom][MOM_CHAMP_COMPVAR] = $compVar;
	}

	protected function SetChampComportementLibelle($nom)
	{
		$this->SetChampComportement($nom, COL_LIBELLE);
	}

	protected function SetChampComportementOrdre($nom, $colOrdres = NULL)
	{
		$this->SetChampComportement($nom, COL_ORDRE, $colOrdres);
	}

	protected function NomChampFromTableauToString($noms)
	{
	   	$nomStr = '';

	   	foreach ($noms as $nom)
	   	{
	   	   	if ($nomStr !== '')
	   	   		$nomStr .= ',';
		   	$nomStr .= $nom;
		}

		return $nomStr;
	}

	public function IsChampExiste($nom, $index = 0)
	{
	   	$noms = $nom;
		if (!is_array($noms) && strpos($nom, ',') !== false)
	   	   	$noms = explode(',', $nom);

		$existe = false;

		if (is_array($noms) && array_key_exists($index, $noms) && array_key_exists($noms[$index], $this->champs))
		{
	   	   	if (array_key_exists($index+1, $noms))
	   	   	{
	   	   	   	$champ = $this->GetChampObjetNonNul($noms[$index]);
	   	   	   	if ($champ !== NULL)
	   	   		   	$existe = $champ->IsChampExiste($noms, $index+1);
	   	   	}
			else
				$existe = true;
	   	}
	   	else if (!is_array($noms))
	   	    $existe = array_key_exists($nom, $this->champs);

		return $existe;
	}

	public function GetChamps()
	{
		return $this->champs;
	}

	public function GetChamp($nom, $index = MOM_CHAMP_VALEUR)
	{
	   	$champVal = NULL;

	   	if ($this->IsChampExiste($nom) === true && array_key_exists($index, $this->champs[$nom]))
		   	$champVal = $this->champs[$nom][$index];

		return $champVal;
	}

	public function GetChampMinFromTableau($noms)
	{
		return $this->GetChampPropFromTableau($noms, MOM_CHAMP_MIN);
	}

	public function GetChampMin($nom)
	{
		return $this->GetChamp($nom, MOM_CHAMP_MIN);
	}

	public function GetChampMaxFromTableau($noms)
	{
		return $this->GetChampPropFromTableau($noms, MOM_CHAMP_MAX);
	}

	public function GetChampMax($nom)
	{
		return $this->GetChamp($nom, MOM_CHAMP_MAX);
	}

	public function GetChampLongueurMinFromTableau($noms)
	{
		return $this->GetChampPropFromTableau($noms, MOM_CHAMP_LONGUEURMIN);
	}

	public function GetChampLongueurMin($nom)
	{
		return $this->GetChamp($nom, MOM_CHAMP_LONGUEURMIN);
	}

	public function GetChampLongueurMaxFromTableau($noms)
	{
		return $this->GetChampPropFromTableau($noms, MOM_CHAMP_LONGUEURMAX);
	}

	public function GetChampLongueurMax($nom)
	{
		return $this->GetChamp($nom, MOM_CHAMP_LONGUEURMAX);
	}

	public function GetChampRegExpFromTableau($noms)
	{
		return $this->GetChampPropFromTableau($noms, MOM_CHAMP_REGEXP);
	}

	public function GetChampRegExp($nom)
	{
		return $this->GetChamp($nom, MOM_CHAMP_REGEXP);
	}

	public function GetChampValeurParDefautMaxFromTableau($noms)
	{
		return $this->GetChampPropFromTableau($noms, MOM_CHAMP_VALPARDEFAUT);
	}

	public function GetChampValeurParDefaut($nom)
	{
		return $this->GetChamp($nom, MOM_CHAMP_VALPARDEFAUT);
	}

	public function IsChampNonNulFromTableau($noms)
	{
		return $this->GetChampPropFromTableau($noms, MOM_CHAMP_NOTNULL);
	}

	public function IsChampNonNul($nom)
	{
		return $this->GetChamp($nom, MOM_CHAMP_NOTNULL);
	}

	public function GetChampObjetNonNul($nom)
	{
	   	if ($this->champs[$nom][MOM_CHAMP_TYPE] === MOM_CHAMPTYPE_OBJ)
		{
		   	// Si l'objet n'existe pas, on le crée complètement vide à partir de son nom de classe.
			if ($this->champs[$nom][MOM_CHAMP_VALEUR] === NULL)
			{
				require_once PATH_METIER.$this->champs[$nom][MOM_CHAMP_NOMCLASSE].'.php';

			   	eval("\$this->champs[\$nom][MOM_CHAMP_VALEUR] = new ".$this->champs[$nom][MOM_CHAMP_NOMCLASSE]."(".$this->champs[$nom][MOM_CHAMP_ARGSTRING].");");
				$this->champs[$nom][MOM_CHAMP_VALEUR] =& $this->champs[$nom][MOM_CHAMP_VALEUR];
			}

			return $this->champs[$nom][MOM_CHAMP_VALEUR];
		}
		else
		   GLog::LeverException(EXM_0141, $this->GetNom().'::GetChampObjetNonNul, le champ ['.$nom.'] n\'est pas un objet.');

		return NULL;
	}

	protected function GetChampPropFromTableau($noms, $prop, $index = 0)
	{
	   	$valeur = NULL;

	   	if (is_array($noms) && array_key_exists($index, $noms))
		{
	   	   	if (array_key_exists($index+1, $noms))
	   	   	{
	   	   	   	$champ = $this->GetChampObjetNonNul($noms[$index]);
	   	   	   	if ($champ !== NULL)
	   	   	   	{
	   	   		   	// Si le champ est la colonne id d'un objet alors on vérifie si l'objet peut être nul et non son id.
					if ($prop === MOM_CHAMP_NOTNULL && $noms[$index+1] === COL_ID)
					   	$valeur = $this->GetChamp($noms[$index], $prop);
					// Sinon on monte d'un cran.
					else
					   	$valeur = $champ->GetChampPropFromTableau($noms, $prop, $index+1);
	   	   		}
	   	   	}
	   	   	else
	   	   	   	$valeur = $this->GetChamp($noms[$index], $prop);
	   	}
	   	else if (!is_array($noms))
	   	   	$valeur = $this->GetChamp($noms, $prop);

	   	return $valeur;
	}

	public function GetChampFromTableau($noms, $index = 0)
	{
	   	$valeur = NULL;

	   	if (is_array($noms) && array_key_exists($index, $noms))
		{
	   	   	if (array_key_exists($index+1, $noms))
	   	   	{
	   	   	   	$champ = $this->GetChampObjetNonNul($noms[$index]);
	   	   	   	if ($champ !== NULL)
	   	   		   	$valeur = $champ->GetChampFromTableau($noms, $index+1);
	   	   	}
			else
				$valeur = $this->GetChamp($noms[$index]);
	   	}
	   	else if (!is_array($noms))
	   	    $valeur = $this->GetChamp($noms);

	   	return $valeur;
	}

	public function GetChampSQLFromTableau($noms, $index = 0)
	{
	   	$valeur = NULL;

	   	if (is_array($noms) && array_key_exists($index, $noms))
		{
	   	   	if (array_key_exists($index+1, $noms))
	   	   	{
	   	   	   	$champ = $this->GetChampObjetNonNul($noms[$index]);
	   	   	   	if ($champ !== NULL)
	   	   		   	$valeur = $champ->GetChampSQLFromTableau($noms, $index+1);
	   	   	}
			else
				$valeur = $this->GetChampSQL($noms[$index]);
	   	}
	   	else if (!is_array($noms))
	   	    $valeur = $this->GetChampSQL($noms);

	   	return $valeur;
	}

	public function GetChampSQL($nom)
	{
	   	$champ = $this->champs[$nom];
	   	$valeur = $champ[MOM_CHAMP_VALEUR];
	   	$type = $champ[MOM_CHAMP_TYPE];

		if ($valeur === NULL || $valeur === SQL_NULL)
		   	return $valeur;

		switch ($type)
		{
	   		case MOM_CHAMPTYPE_OBJ:
	   			return $valeur->Id();
	   		case MOM_CHAMPTYPE_DATETIME:
	   			return $valeur->DateTimeSQL();
	   		case MOM_CHAMPTYPE_DATE:
	   			return $valeur->DateSQL();
	   		case MOM_CHAMPTYPE_TIME:
	   			return $valeur->TimeSQL();
	   		default:
	   			return $valeur;
	   	}
	}

	protected function SetChamp($nom, $valeur)
	{
	   	if ($this->champs[$nom][MOM_CHAMP_NOTNULL] === true && $valeur === SQL_NULL)
	   		GLog::LeverException(EXM_0130, $this->GetNom().'::SetChamp, le champ ['.$nom.'] ne peut pas être nul.');
	   	else
		   $this->champs[$nom][MOM_CHAMP_VALEUR] = $valeur;
		return $this->champs[$nom][MOM_CHAMP_VALEUR];
	}

	public function SetChampFromTableau($noms, $valeur, $index = 0)
	{
	   	if (is_array($noms) && array_key_exists($index, $noms))
		{
	   	   	if (array_key_exists($index+1, $noms))
	   	   	{
	   	   	   	$champ = $this->GetChampObjetNonNul($noms[$index]);
	   	   	   	if ($champ !== NULL)
	   	   		   	$champ->SetChampFromTableau($noms, $valeur, $index+1);
	   	   	}
			else
				$this->SetChampSQL($noms[$index], $valeur);
	   	}
	   	else if (!is_array($noms))
	   	    $this->SetChampSQL($noms, $valeur);
	}

	protected function SetChampSQL($nom, $valeurSQL)
	{
	   	$champ = $this->champs[$nom];
	   	$valeur = $champ[MOM_CHAMP_VALEUR];
	   	$type = $champ[MOM_CHAMP_TYPE];

		switch ($type)
		{
	   		case MOM_CHAMPTYPE_OBJ:
	   		   	if ($valeur === NULL || $valeur === SQL_NULL)
				   	$this->GetChampObjetNonNul($nom);
	   			$this->champs[$nom][MOM_CHAMP_VALEUR]->Id($valeurSQL);
	   			break;
	   		case MOM_CHAMPTYPE_DATETIME:
	   			$this->ValeurDateTimeVerifiee($nom, $valeurSQL);
	   			break;
	   		case MOM_CHAMPTYPE_DATE:
	   			$this->ValeurDateVerifiee($nom, $valeurSQL);
	   			break;
	   		case MOM_CHAMPTYPE_TIME:
	   			$this->ValeurTimeVerifiee($nom, $valeurSQL);
	   			break;
	   		case MOM_CHAMPTYPE_INT:
	   		   	$min = $champ[MOM_CHAMP_MIN];
	   		   	$max = $champ[MOM_CHAMP_MAX];
	   			$this->ValeurIntVerifiee($nom, $valeurSQL, $min, $max);
	   			break;
	   		case MOM_CHAMPTYPE_STR:
	   		   	$longueurMin = $champ[MOM_CHAMP_LONGUEURMIN];
	   		   	$longueurMax = $champ[MOM_CHAMP_LONGUEURMAX];
	   		   	$regexp = $champ[MOM_CHAMP_REGEXP];
	   			$this->ValeurStrVerifiee($nom, $valeurSQL, $longueurMin, $longueurMax, $regexp);
	   			break;
	   		case MOM_CHAMPTYPE_BOOL:
	   			$this->ValeurBoolVerifiee($nom, $valeurSQL);
	   			break;
	   		default:
	   			$this->champs[$nom][MOM_CHAMP_VALEUR] = $valeurSQL;
	   	}
	}

	protected function SetChampDefaut($nom)
	{
	   	$champ = $this->champs[$nom];
	   	$type = $champ[MOM_CHAMP_TYPE];
	   	$valeur = $champ[MOM_CHAMP_VALEUR];
	   	$valParDefaut = $champ[MOM_CHAMP_VALPARDEFAUT];

	   	switch ($type)
		{
	   		case MOM_CHAMPTYPE_OBJ:
	   		   	$this->GetChampObjetNonNul($nom);
	   			$this->champs[$nom][MOM_CHAMP_VALEUR]->Id($valParDefaut);
	   			break;
	   		case MOM_CHAMPTYPE_DATETIME:
	   			$this->ValeurDateTimeVerifiee($nom, $valParDefaut);
	   			break;
	   		case MOM_CHAMPTYPE_DATE:
	   			$this->ValeurDateVerifiee($nom, $valParDefaut);
	   			break;
	   		case MOM_CHAMPTYPE_TIME:
	   			$this->ValeurTimeVerifiee($nom, $valParDefaut);
	   			break;
	   		case MOM_CHAMPTYPE_INT:
	   		   	$min = $champ[MOM_CHAMP_MIN];
	   		   	$max = $champ[MOM_CHAMP_MAX];
	   			$this->ValeurIntVerifiee($nom, $valParDefaut, $min, $max);
	   			break;
	   		case MOM_CHAMPTYPE_STR:
	   		   	$longueurMin = $champ[MOM_CHAMP_LONGUEURMIN];
	   		   	$longueurMax = $champ[MOM_CHAMP_LONGUEURMAX];
	   		   	$regexp = $champ[MOM_CHAMP_REGEXP];
	   			$this->ValeurStrVerifiee($nom, $valParDefaut, $longueurMin, $longueurMax, $regexp);
	   			break;
	   		case MOM_CHAMPTYPE_BOOL:
	   			$this->ValeurBoolVerifiee($nom, $valParDefaut);
	   			break;
	   		default:
	   			$this->champs[$nom][MOM_CHAMP_VALEUR] = $valParDefaut;
	   	}
	}

	/*************************************/
	private function InitListe($nom, $typeObjets)
	{
	   	if (!array_key_exists($nom, $this->listes))
	   	{
	   		$this->listes[$nom] = array();
	   		$this->champs[$nom][MOM_LISTE_VALEUR] = NULL;
	   		$this->champs[$nom][MOM_LISTE_TYPEOBJETS] = $typeObjets;

	   		return true;
	   	}

	   	return false;
	}

	protected function GetListe($nom)
	{
		return $this->listes[$nom][MOM_LISTE_VALEUR];
	}

	protected function SetListe($nom, $valeur)
	{
		$this->listes[$nom][MOM_LISTE_VALEUR] = $valeur;
		return $this->listes[$nom][MOM_LISTE_VALEUR];
	}

	/*************************************/
	public function ValeurIntVerifiee($nom, $valeur, $min = NULL, $max = NULL, $valeurParDefaut = NULL, $notNull = false)
	{
	   	$this->InitChampInt($nom, MOM_CHAMPTYPE_INT, $min, $max, $valeurParDefaut, $notNull);

		if ($valeur !== NULL)
		{
		   	if ($valeur === SQL_NULL)
		   		return $this->SetChamp($nom, $valeur);

			$val = intval($valeur);

			if ($val != 0 || $valeur === 0 || $valeur === '0')
			{
				if (($min !== NULL && $max !== NULL && $val >= $min && $val <= $max) ||
					($min !== NULL && $val >= $min) ||
					($max !== NULL && $val <= $max))
					return $this->SetChamp($nom, $val);
			}

			GLog::LeverException(EXM_0131, $this->GetNom().'::ValeurIntVerifiee, la valeur ['.$valeur.'] n\'appartient pas à l\'ensemble ['.$min.','.$max.'] pour le champ ['.$nom.'].');
		}

		return $this->GetChamp($nom);
	}

	public function ValeurStrVerifiee($nom, $valeur, $longueurMin = 0, $longueurMax = NULL, $regexp = NULL, $valeurParDefaut = NULL, $notNull = false)
	{
	   	$this->InitChampStr($nom, MOM_CHAMPTYPE_STR, $longueurMin, $longueurMax, $regexp, $valeurParDefaut, $notNull);

		if ($valeur !== NULL)
		{
		   	if ($valeur === SQL_NULL)
			   	return $this->SetChamp($nom, $valeur);

			$val = strval($valeur);

			if (strlen($val) < $longueurMin)
				GLog::LeverException(EXM_0132, $this->GetNom().'::ValeurStrVerifiee, la valeur ['.$val.'] ne fait pas les ['.$longueurMin.'] caractères minimum requis pour le champ ['.$nom.'].');
			else
			{
				if ($longueurMax !== NULL && $longueurMax > 0 && $val !== '')
					$val = substr($val, 0, $longueurMax);
				if ($val === false)
					$val = '';

				if ($regexp != NULL && preg_match($regexp, $val) === false)
				   	GLog::LeverException(EXM_0133, $this->GetNom().'::ValeurStrVerifiee, la valeur ['.$val.'] ne remplit pas les conditions de l\'expression régulière ['.$regexp.'] pour le champ ['.$nom.'].');
				else
				   	$this->SetChamp($nom, $val);
			}
		}

		return $this->GetChamp($nom);
	}

	public function ValeurBoolVerifiee($nom, $valeur, $valeurParDefaut = NULL, $notNull = false)
	{
	   	$this->InitChamp($nom, MOM_CHAMPTYPE_BOOL, $valeurParDefaut, $notNull);

		if ($valeur !== NULL)
		{
		   	if ($valeur === SQL_NULL)
			   	return $this->SetChamp($nom, $valeur);

			if ($valeur == false || $valeur == 0 || $valeur === '0')
				$this->SetChamp($nom, false);
			else
				$this->SetChamp($nom, true);
		}

		return $this->GetChamp($nom);
	}

	public function ValeurDateTimeVerifiee($nom, $valeur, $valeurParDefaut = NULL, $notNull = false)
	{
	   	$this->InitChamp($nom, MOM_CHAMPTYPE_DATETIME, $valeurParDefaut, $notNull);

		if ($valeur !== NULL)
		{
		   	if ($valeur === SQL_NULL)
			   	return $this->SetChamp($nom, $valeur);

			$date = $this->GetChamp($nom);
			if ($date !== NULL && $valeur === DATE_SQL)
			{
			   	if ($date === SQL_NULL)
			   		return $date;
			   	else
				   	return $date->DateTimeSQL();
			}
			else if ($valeur !== DATE_SQL && $valeur !== NULL)
			{
				$date = new GDate($valeur);
				$this->SetChamp($nom, $date);
			}
		}

		return $this->GetChamp($nom);
	}

	public function ValeurDateVerifiee($nom, $valeur, $valeurParDefaut = NULL, $notNull = false)
	{
		$this->InitChamp($nom, MOM_CHAMPTYPE_DATE, $valeurParDefaut, $notNull);

		if ($valeur !== NULL)
		{
		   	if ($valeur === SQL_NULL)
			   	return $this->SetChamp($nom, $valeur);

			$date = $this->GetChamp($nom);
			if ($date !== NULL && $valeur === DATE_SQL)
			{
			   	if ($date === SQL_NULL)
			   		return $date;
			   	else
				   	return $date->DateSQL();
			}
			else if ($valeur !== DATE_SQL && $valeur !== NULL)
			{
				$date = new GDate($valeur);
				$this->SetChamp($nom, $date);
			}
		}

		return $this->GetChamp($nom);
	}

	public function ValeurTimeVerifiee($nom, $valeur, $valeurParDefaut = NULL, $notNull = false)
	{
		$this->InitChamp($nom, MOM_CHAMPTYPE_TIME, $valeurParDefaut, $notNull);

		if ($valeur !== NULL)
		{
		   	if ($valeur === SQL_NULL)
			   	return $this->SetChamp($nom, $valeur);

			$date = $this->GetChamp($nom);
			if ($date !== NULL && $valeur === DATE_SQL)
			{
			   	if ($date === SQL_NULL)
			   		return $date;
			   	else
				   	return $date->TimeSQL();
			}
			else if ($valeur !== DATE_SQL && $valeur !== NULL)
			{
				$date = new GDate($valeur);
				$this->SetChamp($nom, $date);
			}
		}

		return $this->GetChamp($nom);
	}

	// Fonction à nombre d'arguments variables. Faire attention à l'ordre!
	public function ValeurObjetVerifiee()
	{
	   	$arguments = func_get_args();
	   	$nom = $arguments[0];
	   	$nomClasse = $arguments[1];
	   	$valParDefaut = NULL;
	   	if (array_key_exists(2, $arguments))
	   	   	$valParDefaut = $arguments[2];
	   	$notNull = false;
	   	if (array_key_exists(3, $arguments))
	   	   	$notNull = $arguments[3];

	   	$argumentsString = '';
   	   	foreach($arguments as $num => $argument)
		{
		   	if ($num >= 4)
			{
			   	if ($argumentsString !== '')
	   	   		   	$argumentsString .= ', ';

				if ($argument === NULL)
				{
				   	// Si lors de l'initialisation on avait des arguments non nul mais que l'objet n'a pas été créé car l'id était nul,
				   	// alors on reporte la valeur non nulle sur les arguments qui ont une valeur nulle.
				   	$argsParDefaut = NULL;
				   	if (array_key_exists($nom, $this->champs))
				   		$argsParDefaut = $this->champs[$nom][MOM_CHAMP_ARGS];

				   	if ($argsParDefaut !== NULL && $argsParDefaut[$num] !== NULL)
					{
				   		if (is_string($argsParDefaut[$num]))
			   	   			$argumentsString .= '\''.$argsParDefaut[$num].'\'';
			   	   		else
						   	$argumentsString .= $argsParDefaut[$num];
				   	}
				   	else
	   	   			   	$argumentsString .= 'NULL';
	   	   		}
	   	   		else if (is_string($argument))
	   	   			$argumentsString .= '\''.$argument.'\'';
	   	   		else
				   	$argumentsString .= $argument;
	   	   	}
   	   	}

	   	$this->InitChampObjet($nom, MOM_CHAMPTYPE_OBJ, $nomClasse, $argumentsString, $arguments, $valParDefaut, $notNull);

	   	if (array_key_exists(4, $arguments) && $arguments[4]/*id*/ !== NULL)
		{
	   	   	$valeur = $this->GetChamp($nom);
			if ($valeur === NULL)
			{
				require_once PATH_METIER.$nomClasse.'.php';

				eval("\$valeur = new ".$nomClasse."(".$argumentsString.");");
				$valeur = &$valeur;
				$this->SetChamp($nom, $valeur);
			}
			else
			   	eval("\$valeur->SetObjet(".$argumentsString.");");
		}

		return $this->GetChamp($nom);
	}

	// Fonction à nombre d'arguments variables. Faire attention à l'ordre!
	public function ValeurListeVerifiee($nom, $typeObjets, $valeur)
	{
		$this->InitListe($nom, $typeObjets);

		if ($valeur !== NULL)
			$this->SetListe($nom, $valeur);

		return $this->GetListe($nom);
	}

	public function UniqueResultatVerifie($liste, $exceptionAucun = true, $exceptionPlusieurs = true, $warningAucun = false, $warningPlusieurs = false)
	{
	   	if ($liste !== NULL)
		{
			if (count($liste) === 0)
			{
			  	if ($exceptionAucun === true)
			  	   	GLog::LeverException(EXM_0138, $this->GetNom().'::UniqueResultatVerifie, aucun résultat récupéré.');
				if ($warningAucun === true)
			  	   	GLog::LeverWarning(WAM_0138, $this->GetNom().'::UniqueResultatVerifie, aucun résultat récupéré.');
			}
			else if (count($liste) > 1)
			{
			  	if ($exceptionAucun === true)
			  	   	GLog::LeverException(EXM_0139, $this->GetNom().'::UniqueResultatVerifie, ['.count($liste).'] résultats récupérés.');
				if ($warningAucun === true)
			  	   	GLog::LeverWarning(WAM_0139, $this->GetNom().'::UniqueResultatVerifie, ['.count($liste).'] résultats récupérés.');
			}

			// On renvoie quand même le premier résultat si possible.
			if (count($liste) >= 1)
				return $liste[0];
		}
		else
		   	GLog::LeverException(EXM_0143, $this->GetNom().'::UniqueResultatVerifie, la liste des résultats n\'existe pas.');

		return NULL;
	}

	/*************************************/
	public function Ajouter()
	{
	   	$retour = false;
	   	$requeteOk = true;
	   	$cols = array();

	   	$select = false;
	   	if ($this->bufferColIns !== NULL && count($this->bufferColIns) > 0)
	   	   	$select = true;

	   	foreach ($this->champs as $nom => $champ)
		{
		   	if ($this->IsChampClePrimaire($nom) === false || $this->AutoInc() === false)//if ($nom !== COL_ID || ($this->idAutoInc === false && $this->noId !== true))
			{
			   	$valeur = $this->GetChampSQL($nom);

			 	// Cas d'un insert into ... select ...
			 	if (($this->jointures !== NULL && count($this->jointures) > 0) || $select === true)
				{
				   	if (array_key_exists($nom, $this->bufferColIns))
			 		   	$valeur = $this->bufferColIns[$nom];
			 		else if ($valeur !== NULL)
			 		{
					   	$tab = array();
					   	$tab[SQLFONCTION_TYPE] = SQLFONCTION_VALEUR;
						$tab[SQLFONCTION_VALEUR_PARAM] = $valeur;
					   	$valeur = $tab;
					}
				}

				// Cas où le champ est nul et ne doit pas l'être.
			   	if ($champ[MOM_CHAMP_NOTNULL] === true && ($valeur === NULL || $valeur === SQL_NULL))
			   	{
			   	   	if ($champ[MOM_CHAMP_VALPARDEFAUT] === NULL || $champ[MOM_CHAMP_VALPARDEFAUT] === SQL_NULL)
			   	   	{
			   	   		GLog::LeverException(EXM_0134, $this->GetNom().'::Ajouter, le champ ['.$nom.'] ne peut pas être nul.');
			   	   		$requeteOk = false;
			   	   		break;
			   	   	}
			   	   	else
			   	   	{
			   	   	   	$this->SetChampDefaut($nom);
			   	   	   	$valeur = $this->GetChampSQL($nom);
			   	   	   	// Cas d'un insert into ... select ...
						if (($this->jointures !== NULL && count($this->jointures) > 0) || $select === true)
						{
						   	$tab = array();
						   	$tab[SQLFONCTION_TYPE] = SQLFONCTION_VALEUR;
							$tab[SQLFONCTION_VALEUR_PARAM] = $valeur;
						   	$valeur = $tab;
						}
			   	   	}
				}

			   	$cols[$nom] = $valeur;
			}
		}

		$id = false;

		// Si la requête est ok, alors on ajoute les jointures et on l'exécute.
		if ($requeteOk === true)
		{
			$bObjetBase = $this->GetObjetBase();
			$bObjetBase->SetNumJointure(0);
			$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_AJOUT);

			foreach ($cols as $nom => $valeur)
			{
				$this->AjouterBaseColInsertion($bObjetBase, $nom, $valeur);
			}

			// Cas d'un insert into ... select ...
			if (($this->jointures !== NULL && count($this->jointures) > 0) || $select === true)
			{
			   	if ($this->bufferColCond !== NULL)
				{
				   	foreach ($this->bufferColCond as $nom => $valeur)
					{
						$this->AjouterBaseColCondition($bObjetBase, $nom, $valeur);
					}
				}
			}

			$id = $bObjetBase->Ajouter(NULL, NULL, $select);
		}

		if ($id !== false)
		{
		   	$retour = true;
			if ($this->AutoInc() === true)
				$this->Id($id);
		}

		$this->ResetBuffers();
		if ($retour === false)
			GLog::LeverException(EXM_0144, $this->GetNom().'::Ajouter, échec de l\'insertion en base.');
		return $retour;
	}

	public function Modifier()
	{
	   	$retour = false;

	   	//if ($this->noId === true)
	   	//	$this->GetColCondNoId();
	   	$colCond = $this->bufferColCond;
		if ($colCond === NULL)
			$colCond = $this->GetColCondClePrimaire();

		if ($colCond !== NULL)//($this->noId !== true && $this->Id() !== NULL) || $colCond !== NULL)
		{
			$colSet = $this->bufferColModif;
		  	if ($colSet === NULL)
			{
			   	$colSet = array();
			   	foreach ($this->champs as $nom => $champ)
				{
				   	/*$valeur = NULL;
					if ($champ[MOM_CHAMP_TYPE] === MOM_CHAMPTYPE_OBJ && $champ[MOM_CHAMP_VALEUR] !== NULL)
					   	$valeur = $champ[MOM_CHAMP_VALEUR]->Id();
					else
				   	   	$valeur = $champ[MOM_CHAMP_VALEUR];*/
					$appartientColCond = false;
					foreach ($colCond as $col)
					{
						if ($col === $nom)
							$appartientColCond = true;
					}

					if ($appartientColCond === false)
					{
						$valeur = $this->GetChampSQL($nom);
						if ($valeur !== NULL)
							$colSet[$nom] = $valeur;
					}
				}
			}

			$bObjetBase = $this->GetObjetBase();
			$bObjetBase->SetNumJointure(0);
			$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_MODIFICATION);

			foreach ($colSet as $nom => $valeur)
			{
				$this->AjouterBaseColModification($bObjetBase, $nom, $valeur);
			}
			foreach ($colCond as $nom => $valeur)
			{
				$this->AjouterBaseColCondition($bObjetBase, $nom, $valeur);
			}

			$retour = $bObjetBase->Modifier();
		}
		else
		   	GLog::LeverException(EXM_0135, $this->GetNom().'::Modifier, la valeur de la clé primaire n\'est pas renseignée.');

		$this->ResetBuffers();
		if ($retour === false)
			GLog::LeverException(EXM_0145, $this->GetNom().'::Modifier, échec de la modification en base.');
		return $retour;
	}

	public function Supprimer()
	{
	   	$retour = false;

	   	//if ($this->noId === true)
	   	//	$this->GetColCondNoId();
	   	$colCond = $this->bufferColCond;
		if ($colCond === NULL)
			$colCond = $this->GetColCondClePrimaire();

		if ($colCond !== NULL)//($this->noId !== true && $this->Id() !== NULL) || $colCond !== NULL)
		{
			$bObjetBase = $this->GetObjetBase();
			$bObjetBase->SetNumJointure(0);
			$bObjetBase->SupprimerSurJointure(true);
			$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_SUPPRESSION);

			foreach ($colCond as $nom => $valeur)
			{
				$this->AjouterBaseColCondition($bObjetBase, $nom, $valeur);
			}

			$retour = $bObjetBase->Supprimer();
		}
		else
		   	GLog::LeverException(EXM_0136, $this->GetNom().'::Supprimer, la valeur de la clé primaire n\'est pas renseignée.');

		$this->ResetBuffers();
		if ($retour === false)
			GLog::LeverException(EXM_0146, $this->GetNom().'::Supprimer, échec de la suppression en base.');
		return $retour;
	}

	public function Charger($exceptionAucun = true, $exceptionPlusieurs = true, $warningAucun = false, $warningPlusieurs = false, $inscriptionResultat = true)
	{
	   	$retour = false;
	   	$requeteOk = true;
	   	$colSelDef = true;
	   	$colCondDef = true;

	   	if ($this->bufferColSel === NULL)
	   	{
	   	   	$colSelDef = false;
	   	   	$this->AjouterToutesColSelection();
	   	}

	   	if ($this->bufferColCond === NULL)
		{
		   	$colCondDef = false;
			// Il suffit de posséder les valeurs de la clé primaire pour agir sur l'enregistrement.
		   	$this->bufferColCond = $this->GetColCondClePrimaire();
			// Cas où la clé primaire n'est pas remplie.
			if ($this->bufferColCond === NULL)
			{
				$this->bufferColCond = array();
				foreach ($this->champs as $nom => $champ)
				{
					/*$valeur = NULL;
					if ($champ[MOM_CHAMP_TYPE] === MOM_CHAMPTYPE_OBJ && !is_int($champ[MOM_CHAMP_VALEUR]) && $champ[MOM_CHAMP_VALEUR] !== NULL)
						$valeur = $champ[MOM_CHAMP_VALEUR]->Id();
					else
						$valeur = $champ[MOM_CHAMP_VALEUR];*/
					$valeur = $this->GetChampSQL($nom);

					if ($valeur !== NULL)
						$this->AjouterColCondition($nom);
				}
			}
		}

		if ($this->bufferColCond === NULL || count($this->bufferColCond) === 0)
		{
			$requeteOk = false;
			GLog::LeverException(EXM_0149, $this->GetNom().'::Charger, aucune condition pour le chargement de l\'objet.');
		}

		if ($requeteOk === true)
		{
		   	// Si les colonnes de condition ont été définies à la main et pas les colonnes de sélection,
		   	// ou si ni les colonnes de sélection ni les colonnes de condition n'ont été définies à la main,
			// on supprime de la sélection les colonnes de condition.
		   	if ($colSelDef === false)
			{
				foreach ($this->bufferColCond as $nom => $valeur)
				{
				 	if (array_key_exists($nom, $this->bufferColSel))
					   	unset($this->bufferColSel[$nom]);
				}
			}
			// Si les colonnes de sélection ont été définies à la main et pas les colonnes de condition,
			// on supprime des conditions les colonnes de sélection.
			else if ($colCondDef === false && $colSelDef === true)
			{
			   	foreach ($this->bufferColSel as $nom => $valeur)
				{
				 	if (array_key_exists($nom, $this->bufferColCond))
					   	unset($this->bufferColCond[$nom]);
				}
			}

			// Chargement en base.
		   	$listeResultats = array();
			$bObjetBase = $this->GetObjetBase();
			$bObjetBase->SetNumJointure(0);
			// On ajoute l'ordre de chargement.
			if ($this->bufferColOrdre !== NULL)
			{
			   	foreach ($this->bufferColOrdre as $ordre => $col)
				{
				   	$this->AjouterBaseColOrdre($bObjetBase, $col[SQLORDRE_COL], $ordre, $col[SQLORDRE_TYPE]);
				}
			}
			// On ajoute les jointures s'il y en a.
			$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_CHARGEMENT);

			foreach ($this->bufferColSel as $nom => $valeur)
			{
				$this->AjouterBaseColSelection($bObjetBase, $nom, $valeur);
			}
			foreach ($this->bufferColCond as $nom => $valeur)
			{
				$this->AjouterBaseColCondition($bObjetBase, $nom, $valeur);
			}

			$listeResultats = $bObjetBase->Charger();

			if ($listeResultats !== false)
			{
			   	$retour = count($listeResultats);

				// On vérifie que le résultat est unique puis on met les valeurs chargées dans l'objet.
				$resultat = $this->UniqueResultatVerifie($listeResultats, $exceptionAucun, $exceptionPlusieurs, $warningAucun, $warningPlusieurs);

				if ($resultat !== NULL && $inscriptionResultat === true)
				   	$this->SetObjetFromSQL($resultat);
				else if ($exceptionAucun === true)
				   	$retour = false;
			}
			else
			   	$retour = false;
		}

		$this->ResetBuffers();
		if ($retour === false)
			GLog::LeverException(EXM_0147, $this->GetNom().'::Charger, échec du chargement en base.');
		return $retour;
	}

	public function ModifierSiExistantAjouterSinon()
	{
	   	$retour = false;

	   	if ($this->noId === true)
	   		$this->GetColCondNoId();
	   	$colCond = $this->bufferColCond;
		if (($this->noId !== true && $this->Id() !== NULL) || $colCond !== NULL)
		{
	  	  	if ($colCond === NULL && $this->noId !== true)
		   	   	$this->AjouterColCondition(COL_ID);

		   	$retour = $this->Charger(false, true, false, false, false);

		 	if ($retour !== false)
			{
		   		if ($retour === 0)
		   			$this->Ajouter();
		   		else
		   		   	$this->Modifier();
	   		}
		}
		else
		   	GLog::LeverException(EXM_0148, $this->GetNom().'::ModifierSiExistantAjouterSinon, pas d\'id.');

	   	return $retour;
	}

	/*************************************/
	public function ResetBuffers()
	{
		// On reset les buffers des jointures également.
		if ($this->objetsJoints !== NULL)
		{
			foreach ($this->objetsJoints as $mObjetJoint)
			{
				$mObjetJoint->ResetBuffers();
			}
		}

		if ($this->bufferColSel !== NULL)
		   	unset($this->bufferColSel);
		if ($this->bufferColIns !== NULL)
		   	unset($this->bufferColIns);
		if ($this->bufferColModif !== NULL)
		   	unset($this->bufferColModif);
		if ($this->bufferColCond !== NULL)
		   	unset($this->bufferColCond);
		if ($this->objetsJoints !== NULL)
		   	unset($this->objetsJoints);
		if ($this->jointures !== NULL)
		   	unset($this->jointures);
		if ($this->bufferColOrdre !== NULL)
		   	unset($this->bufferColOrdre);
		$this->bufferColSel = NULL;
		$this->bufferColIns = NULL;
		$this->bufferColModif = NULL;
		$this->bufferColCond = NULL;
		$this->bufferColOrdre = NULL;
		$this->objetsJoints = NULL;
		$this->jointures = NULL;
	}

	protected function GetColCondClePrimaire()
	{
		$colCond = NULL;
		foreach ($this->ClePrimaire() as $nomChamp)
		{
			if ($colCond === NULL)
				$colCond = array();
			$valeur = $this->GetChampSQL($nomChamp);
			if ($valeur === NULL)
				return NULL;
			$colCond[$nomChamp] = $valeur;
		}
		return $colCond;
	}

	public function AjouterColSelection($nomsCol, $jointures = NULL)
	{
	   	$numJointure = 0;

	   	// Cas de la sélection d'une colonne pour une jointure spécifique.
	   	if ($jointures !== NULL)
	   	{
	   	   	$this->currentJointure = 0;
			$numJointure = $this->AjouterJointuresFromTableau($jointures);
		}
		// Cas de la sélection d'une colonne pour la jointure courante définie par la fonction Jointure().
		else
		   	$numJointure = $this->currentJointure;
		$mObjet = $this->objetsJoints[$numJointure];
		if (is_array($nomsCol) && !array_key_exists(SQLFONCTION_TYPE, $nomCol))
		{
		   	foreach ($nomsCol as $nomCol)
		   	{
				$mObjet->AjouterBufferColSelection($nomCol);
			}
		}
		else
		   	$mObjet->AjouterBufferColSelection($nomsCol);

		return $this;
	}

	private function AjouterBufferColSelection($col)
	{
	   	if ($this->bufferColSel === NULL)
			$this->bufferColSel = array();

		$nom = $col;
		if (is_array($col))
			$nom = $col[SQLFONCTION_COL];

		switch ($this->GetChampComportement($nom))
		{
			case COL_LIBELLE:
				$mLibelle = $this->AjouterJointure(COL_LIBELLE, COL_ID);
				$mLibelle->AjouterColSelection(COL_ID);
				$mLibelle->AjouterColSelection(COL_LIBELLE);
				$mLibelle->AjouterColCondition(COL_LANGUE, GSession::Langue(COL_ID));
				break;
			default:
			   	if (is_array($nom))
			   		$this->bufferColSel[$nom] = $col;
			   	else
				   	$this->bufferColSel[$nom] = NULL;
		}
	}

	// Permet de récupérer la valeur d'un champ ($nomExt) d'une jointure ($numJointure) dans le champ ($nom) de cet objet.
	public function AjouterColSelectionExt($numJointure, $nom, $nomExt, $as = NULL, &$bufferColSelExt = NULL)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_EXT;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomExt;
		if ($as === NULL)
		   	$as = $nom;
		$tab[SQLFONCTION_AS] = $as;
		$tab[SQLFONCTION_INC] = 0;

		$this->AjouterColSelection($nom, $tab, $bufferColSelExt);
	}

	public function AjouterColSelectionMax($nom, $as = NULL, &$bufferColSelExt = NULL)
	{
	   	$this->AjouterColSelectionMaxExt(0, $nom, $nom, $as, $bufferColSelExt);
	}

	public function AjouterColSelectionMaxExt($numJointure, $nom, $nomExt, $as = NULL, &$bufferColSelExt = NULL)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_MAX;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomExt;
		if ($as === NULL)
		   	$as = $nom;
		$tab[SQLFONCTION_AS] = $as;
		$tab[SQLFONCTION_INC] = 0;

		$this->AjouterColSelection($nom, $tab, $bufferColSelExt);
	}

	public function AjouterColSelectionCount($nom, $as = NULL, &$bufferColSelExt = NULL)
	{
	   	$this->AjouterColSelectionCountExt(0, $nom, $nom, $as, $bufferColSelExt);
	}

	public function AjouterColSelectionCountExt($numJointure, $nom, $nomExt, $as = NULL, &$bufferColSelExt = NULL)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_COUNT;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomExt;
		if ($as === NULL)
		   	$as = $nom;
		$tab[SQLFONCTION_AS] = $as;
		$tab[SQLFONCTION_INC] = 0;

		$this->AjouterColSelection($nom, $tab, $bufferColSelExt);
	}

	public function AjouterToutesColSelection()
	{
	   	if ($this->bufferColSel === NULL)
	   	   	$this->bufferColSel = array();

	   	foreach ($this->champs as $nom => $champ)
		{
		   	$this->AjouterColSelection($nom, NULL);
		}
	}

	public function AjouterColInsertion($nom, $tab)
	{
	   	if ($this->bufferColIns === NULL)
	   	   	$this->bufferColIns = array();

	   	$this->bufferColIns[$nom] = $tab;
	}

	public function AjouterColInsertionExt($numJointure, $nom, $nomExt, $inc = 0)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_EXT;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomExt;
		$tab[SQLFONCTION_AS] = NULL;
		$tab[SQLFONCTION_INC] = $inc;

		$this->AjouterColInsertion($nom, $tab);
	}

	public function AjouterColInsertionMax($nom, $inc = 0)
	{
	   	$this->AjouterColInsertionMaxExt(0, $nom, $nom, $inc);
	}

	public function AjouterColInsertionMaxExt($numJointure, $nom, $nomExt, $inc = 0)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_MAX;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomExt;
		$tab[SQLFONCTION_AS] = NULL;
		$tab[SQLFONCTION_INC] = $inc;

		$this->AjouterColInsertion($nom, $tab);
	}

	public function AjouterColInsertionCount($nom, $inc = 0)
	{
	   	$this->AjouterColInsertionCountExt(0, $nom, $nom, $inc);
	}

	public function AjouterColInsertionCountExt($numJointure, $nom, $nomExt, $inc = 0)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_COUNT;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomExt;
		$tab[SQLFONCTION_AS] = NULL;
		$tab[SQLFONCTION_INC] = $inc;

		$this->AjouterColInsertion($nom, $tab);
	}

	public function AjouterColModification($nom, $valeur = NULL)
	{
	   	if ($this->bufferColModif === NULL)
	   	   	$this->bufferColModif = array();

	   	if ($valeur === NULL)
	   	    $this->bufferColModif[$nom] = $this->GetChampSQL($nom);
	   	else
	   	   	$this->bufferColModif[$nom] = $valeur;
	}

	public function AjouterColCondition($nom, $valeur = NULL)
	{
	   	if ($this->bufferColCond === NULL)
	   	   	$this->bufferColCond = array();

	   	if ($valeur === NULL)
	   	    $this->bufferColCond[$nom] = $this->GetChampSQL($nom);
	   	else
	   	   	$this->bufferColCond[$nom] = $valeur;
	}

	public function ResetColCondition($nom)
	{
	   	$this->bufferColCond = array();
	}

	public function ModifierColSelection($nom, $as)
	{
		$this->bufferColSel[$nom] = $as;
	}

	public function SupprimerColSelection($nom)
	{
	   	unset($this->bufferColSel[$nom]);
	}

	public function AjouterColOrdre($nom, $ordre, $desc = false)
	{
		switch ($this->GetChampComportement($nom))
		{
			case COL_LIBELLE:
				$mLibelle = $this->ValeurObjetVerifiee(COL_LIBELLE, 'MLibelle');
				$mLibelle->AjouterColOrdre($col, $ordre);
				break;
			default:
				if ($this->bufferColOrdre === NULL)
					$this->bufferColOrdre = array();

				$ordreTab = array();
				$ordreTab[SQLORDRE_TYPE] = $desc;
				$ordreTab[SQLORDRE_COL] = $nom;
				$this->bufferColOrdre[$ordre] = $ordreTab;
		}
	}

	public function ModifierSurJointure($modifier = NULL)
	{
	   	if ($modifier === NULL)
	   	   	return $this->modifierSurJointure;

	   	$this->modifierSurJointure = $modifier;
	}

	public function SupprimerSurJointure($supprimer = NULL)
	{
	   	if ($supprimer === NULL)
	   	   	return $this->supprimerSurJointure;

	   	$this->supprimerSurJointure = $supprimer;
	}

	public function Jointure($jointures)
	{
		$this->currentJointure = $this->AjouterJointuresFromTableau($jointures);
	}

	private function AjouterJointuresFromTableau($jointures)
	{
	   	$numObjetJointure = 0;
		$numJointure = 0;
	   	$isJointureExiste = true;

	   	foreach ($jointures as $jointure)
		{
		   	if ($isJointureExiste === true)
		   	{
			   	$numJointure = $this->GetNumJointure($jointure[0], $jointure[1], $numObjetJointure);
			   	if ($numJointure <= 0)
			   		$isJointureExiste = false;
				else
					$numObjetJointure = $numJointure;
			}
			if ($isJointureExiste === false)
			{
			   	if (!array_key_exists(2, $jointure))
			   	   	$jointure[2] = SQL_INNER_JOIN;
				$this->AjouterJointure($jointure[0], $jointure[1], $numObjetJointure, $jointure[2]);
				return count($this->jointures);
			}
	   	}

		return $numJointure;
	}

	private function GetNumJointure($colThisJointure, $colAutreJointure, $numObjetJointure)
	{
	   	foreach ($this->jointures as $numJointure => $jointure)
		{
			if ($jointure[MOM_JOINTURE_COLTHIS] === $colThisJointure &&
			   	$jointure[MOM_JOINTURE_COLAUTRE] === $colAutreJointure &&
			   	$jointure[MOM_JOINTURE_NUMOBJET] === $numObjetJointure)
			   	return $numJointure;
		}

		return -1;
	}

	public function AjouterJointure($colThisJointure, $colAutreJointure, $numObjetJointure = 0, $typeJointure = SQL_INNER_JOIN)
	{
	   	if ($this->jointures === NULL)
	   	   	$this->jointures = array();

	   	$numJointure = count($this->jointures) + 1;
	   	$this->jointures[$numJointure] = array();
	   	$this->jointures[$numJointure][MOM_JOINTURE_COLTHIS] = $colThisJointure;
	   	$this->jointures[$numJointure][MOM_JOINTURE_COLAUTRE] = $colAutreJointure;
	   	$this->jointures[$numJointure][MOM_JOINTURE_OBJET] = $mObjetMetier;
		$this->jointures[$numJointure][MOM_JOINTURE_TYPE] = $typeJointure;

		$mObjetMetier = $this->GetChampObjetNonNul($colThisJointure);
		if ($mObjetMetier)
		{
			if ($this->objetsJoints === NULL)
				$this->objetsJoints = array();
			$this->objetsJoints[$numJointure] = $mObjetMetier;
		}
		else
		   	GLog::LeverException(EXM_0142, $this->GetNom().'::AjouterJointure, objet inexistant pour la colonne ['.$colThisJointure.'] de l\'objet ['.$this->GetNom().'].');

		return $mObjetMetier;
	}

	protected function GetObjetBasePourRequete($typeRequete)
	{
	   	$numObjetJointure = 0;
	   	$bObjetBase = GetObjetBasePourJointure($typeRequete);
	   	$bObjetBase->SetNumJointure(0);
	   	$objetsBases = array();

	   	if ($this->jointures !== NULL)
		{
		   	foreach ($this->jointures as $numJointure => $jointure)
			{
			   	$mObjetMetierJoint = $this->objetsJoints[$numJointure];

				if ($mObjetMetierJoint !== NULL)
				{
				   	$bObjetBaseRef = $objetsBases[$jointure[MOM_JOINTURE_NUMOBJET]];
				   	$bObjetBaseJoint = $mObjetMetierJoint->GetObjetBasePourJointure($typeRequete);
				   	$bObjetBaseJoint->SetNumJointure($numJointure);
				   	$objetsBases[$numJointure] = $bObjetBaseJoint;
				   	$bObjetBaseRef->AjouterJointure($jointure[MOM_JOINTURE_COLTHIS], $bObjetBaseJoint, $jointure[MOM_JOINTURE_COLAUTRE], $jointure[MOM_JOINTURE_TYPE]);
				}
				else
					GLog::LeverException(EXM_0140, $this->GetNom().'::GetObjetBasePourRequete, les objets n\'ont pas été initialisés pour le niveau de jointure ['.$numJointure.'].');
			}
		}

		return $bObjetBase;
	}

	// Renvoie un objet base préparé pour une jointure.
	protected function GetObjetBasePourJointure($typeRequete)
	{
	   	$bObjetBase = $this->GetObjetBase();

	   	if ($typeRequete === MOM_TYPEREQ_CHARGEMENT)
		{
		   	if ($this->bufferColSel === NULL)
	   	   	   	$this->AjouterToutesColSelection();

			foreach ($this->bufferColSel as $col => $as)
			{
			   	$this->AjouterBaseColSelection($bObjetBase, $col, $as);
			}

			if ($this->bufferColCond !== NULL)
			{
			   	foreach ($this->bufferColCond as $col => $val)
				{
				   	$this->AjouterBaseColCondition($bObjetBase, $col, $val);
				}
			}

			if ($this->bufferColOrdre !== NULL)
			{
			   	foreach ($this->bufferColOrdre as $ordre => $col)
				{
				   	$this->AjouterBaseColOrdre($bObjetBase, $col[SQLORDRE_COL], $ordre, $col[SQLORDRE_TYPE]);
				}
			}
		}
		else if ($typeRequete === MOM_TYPEREQ_SUPPRESSION)
		   	$bObjetBase->SupprimerSurJointure($this->SupprimerSurJointure());
		else if ($typeRequete === MOM_TYPEREQ_MODIFICATION)
		{
		   	if ($this->ModifierSurJointure() === true)
			{
			   	if ($this->bufferColModif !== NULL)
				{
					foreach ($this->bufferColModif as $col => $valeur)
					{
				   	   	$this->AjouterBaseColModification($bObjetBase, $col, $valeur);
					}
				}
				else
				{
				   	foreach ($this->champs as $nom => $champ)
					{
						$valeur = $this->GetChampSQL($nom);
					   	if ($valeur !== NULL && $nom !== COL_ID)
					   		$this->AjouterBaseColModification($bObjetBase, $nom, $this->GetChampSQL($nom));
					}
				}
			}
		}

		if (($this->bufferColCond === NULL && $typeRequete !== MOM_TYPEREQ_MODIFICATION && $typeRequete !== MOM_TYPEREQ_SUPPRESSION)/* || $typeRequete === MOM_TYPEREQ_AJOUT*/)
		{
		   	foreach ($this->champs as $nom => $champ)
			{
			 	$valeur = $this->GetChampSQL($nom);
			   	if ($valeur !== NULL)
			   	   	$this->AjouterBaseColCondition($bObjetBase, $nom, $this->GetChampSQL($nom));
			}
		}
		// Cas où l'on modifie l'enregistrement via une jointure.
		else if ($typeRequete === MOM_TYPEREQ_MODIFICATION && $this->ModifierSurJointure() === true && $this->bufferColCond !== NULL)
		{
			foreach ($this->bufferColCond as $col => $val)
			{
				$this->AjouterBaseColCondition($bObjetBase, $col, $val);
			}
		}

		return $bObjetBase;
	}

	protected function GetAsCol($col)
	{
		if (self::$numChamp === NULL)
			self::$numChamp = 0;
		$as = 'C'.self::$numChamp;
		self::$numChamp++;
		$this->mappingColAs[$col] = $as;
		return $as;
	}

	public function AjouterBaseColSelection($bObjetBase, $col, $as)
	{
		switch ($this->GetChampComportement($col))
		{
			case COL_LIBELLE:
				$bObjetBase->AjouterJointure(COL_LIBELLE, $this->LibelleObj()->GetObjetBase(), COL_ID);
				$bObjetBase->AjouterColSelect(COL_ID, $this->LibelleObj()->GetAsCol($col));
				$bObjetBase->AjouterColSelect(COL_LIBELLE, $this->LibelleObj()->GetAsCol($col));
				$bObjetBase->AjouterColWhere(COL_LANGUE, GSession::Langue(COL_ID));
				break;
			default:
				$bObjetBase->AjouterColSelect($col, $this->GetAsCol($col));
		}
		self::$numChamp++;

	}

	public function AjouterBaseColInsertion($bObjetBase, $col, $valeur)
	{
	   	$bObjetBase->AjouterColInsert($col, $valeur);
	}

	public function AjouterBaseColModification($bObjetBase, $col, $valeur)
	{
		switch ($this->GetChampComportement($col))
		{
			case COL_LIBELLE:
				break;
			default:
				$bObjetBase->AjouterColUpdate($col, $valeur);
		}
	}

	public function AjouterBaseColCondition($bObjetBase, $col, $valeur)
	{
	   	$bObjetBase->AjouterColWhere($col, $valeur);
	}

	public function AjouterBaseColOrdre($bObjetBase, $col, $ordre, $desc = false)
	{
	   	$bObjetBase->AjouterColOrderBy($col, $ordre, $desc);
	}
}

?>