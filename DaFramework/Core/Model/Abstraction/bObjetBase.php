<?php

require_once 'cst.php';
require_once INC_CSTBASE;
require_once INC_CSTSQL;
require_once INC_CSTFONCTIONS;
require_once INC_GBASE;


// Niveau de log (défini dans le constructeur de BObjetBase):
// On ne log rien.
define('LOG_AUCUN', 1); 	// On ne log rien.
define('LOG_ERREUR', 2);	// On log les erreurs.
define('LOG_REQ', 3); 		// On log les requêtes après leur exécution.
define('LOG_PERF', 4);		// On log les requêtes avant et après leur exécution.


class BObjetBase
{
	protected $liaisons;
	protected $colonneLiaison;
	protected $typeJointure;
	protected $colonneJointure;
	protected $numJointure;
	protected $supprimerSurJointure;

	protected $parametres;
	protected $selections;
	protected $ordres;
	protected $groupes;

	protected $nomTable;
	protected $niveauLog;
	protected $numero;
	protected $nbMaxEnregistrements;
	protected $offset;

	protected $parametresJointureGauche;
	protected $parametresJointureDroite;
	static protected $indent = 0;

	public function __construct($nomTable)
	{
		$this->nomTable = $nomTable;
		$this->selections = array();
		$this->parametres = array();
		$this->liaisons = array();
		$this->ordres = array();
		$this->groupes = array();
		$this->parametresJointureGauche = array();
		$this->parametresJointureDroite = array();
		$this->numJointure = -1;
		$this->niveauLog = (int) LOG_REQ;
		$this->numero = self::$indent;
		$this->nbMaxEnregistrements = -1;
		$this->offset = -1;
		self::$indent++;
		if (self::$indent > 99)
			self::$indent = 0;
	}

	private function LogguerPostRequete($req, $requete, array & $params)
	{
		$erreur = $requete->errorInfo();
		if ($erreur[0] == 0 && $this->niveauLog === (int) LOG_AUCUN)
			return;

		$fichierLog = fopen(PATH_SERVER_LOCAL.'log/sql'.date('Y-m-d').'.txt', 'a+');
		fwrite($fichierLog, date('H:i:s') . ' - ' . $req . "\r\n parametre(s): ");

		foreach ($params as $param)
			fwrite($fichierLog, $param . ", ");

		fwrite($fichierLog, "\r\n resultat: ");

		foreach ($erreur as $value)
			fwrite($fichierLog, $value . " - ");

		fwrite($fichierLog, "\r\n\r\n\r\n");
		fclose($fichierLog);
	}

	private function LogguerPreRequete($req)
	{
		$fichierLog = fopen(PATH_SERVER_LOCAL.'log/sql'.date('Y-m-d').'.txt', 'a+');
		fwrite($fichierLog, date('H:i:s') . ' - ' . $req . "\r\n");
		fclose($fichierLog);
	}

	public function Nettoyer()
	{
		unset ($this->selections);
		unset ($this->parametres);
		unset ($this->ordres);
		unset ($this->groupes);
		$this->selections = array();
		$this->parametres = array();
		$this->ordres = array();
		$this->groupes = array();
		$this->nbMaxEnregistrements = -1;
		$this->offset = -1;

		$this->NettoyerJointures();
	}

	protected function NettoyerJointures()
	{
		foreach ($this->liaisons as $jointure)
			$jointure->NettoyerJointures();

		unset ($this->liaisons);
		unset ($this->parametresJointureGauche);
		unset ($this->parametresJointureDroite);
		$this->liaisons = array();
		$this->parametresJointureGauche = array();
		$this->parametresJointureDroite = array ();
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Ajout des différents paramètres d'une requête.
	public function AjouterColInsert($col, $val)
	{
		$this->selections[$col] = $val;
	}

	public function AjouterColUpdate($col, $val)
	{
		if ($val !== NULL)
			$this->selections[$col] = $val;
	}

	public function AjouterColSelect($col, $as = NULL)
	{
		if ($as !== false)
		{
			if ($as != NULL)
			{
			   	if (is_array($as))
				{
				   	$nomCol = $as[SQLFONCTION_AS];
				   	if ($nomCol !== NULL)
				   		$this->selections[strval($nomCol)] = $as;
				   	else
				   	   	$this->selections[] = $as;
			   	}
			   	else
				   	$this->selections[strval($as)] = $col;
			}
			else
				$this->selections[] = $col;
		}
	}

	public function AjouterColWhere($col, $val)
	{
		if (is_array($val) && !array_key_exists(SQLPARAM_TYPE, $val))
		{
			$nbVal = count($val);
			if ($nbVal >= 2)
			{
				$tab = array ();
				$tab[SQLPARAM_TYPE] = SQLPARAM_IN;
				$tab[SQLPARAM_IN_VALEURS] = $val;
				$this->parametres[$col] = $tab;
			}
			else if ($nbVal == 1)
				$this->parametres[$col] = $val[0];
		}
		else
			$this->parametres[$col] = $val;
	}

	public function AjouterColOrderBy($col, $ordre, $desc = false)
	{
	   	$tab = array();
	   	if ($desc === true)
	   	   	$tab[SQLORDRE_TYPE] = SQLORDRE_DESC;
	  	else if ($desc === false)
		   	$tab[SQLORDRE_TYPE] = SQLORDRE_ASC;
		else if ($desc >= 0)
			$tab[SQLORDRE_TYPE] = SQLORDRE_ASC;
		else
	   	   	$tab[SQLORDRE_TYPE] = SQLORDRE_DESC;
		$tab[SQLORDRE_COL] = $col;
		$this->ordres[$ordre] = $tab;
	}

	public function AjouterColGroupBy($col)
	{
		$this->groupes[] = $col;
	}

	public function AjouterLimiteNbEnregistrements($nbMaxEnregistrements, $offset)
	{
		$this->nbMaxEnregistrements = $nbMaxEnregistrements;
		$this->offset = $offset;
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Appels externes pour lancer une requête.
	public function Ajouter($cols = NULL, $colCond = NULL, $select = false)
	{
	   	if ($cols !== NULL)
		{
		   	foreach ($cols as $col => $val)
			{
			   	$this->AjouterColInsert($col, $val);
			}
		}

		if ($colCond !== NULL)
		{
			foreach ($colCond as $col => $val)
			{
				$this->AjouterColWhere($col, $val);
			}
		}

	   	return $this->ExecuterRequeteInsertion(true, $select);
	}

	public function Modifier($colSet = NULL, $colCond = NULL, $from = false, $colCondVideAutorisee = false)
	{
	   	if ($colCondVideAutorisee === false && ($colCond === NULL || count($colCond) == 0) && $this->JointuresOntConditions() === false)
	   	   	GLog::LeverException(EXB_0000, 'BObjetBase::Modifier, aucune condition pour la table ['.$this->nomTable.']. Echec de la modification en base.');
	   	else
		{
		   	if ($colSet !== NULL)
			{
			   	foreach ($colSet as $col => $val)
				{
				   	$this->AjouterColUpdate($col, $val);
				}
			}

			if ($colCond !== NULL)
			{
				foreach ($colCond as $col => $val)
				{
				   	$this->AjouterColWhere($col, $val);
				}
			}

			return $this->ExecuterRequeteMiseAJour(true, $from);
		}

		return false;
	}

	public function Supprimer($colCond = NULL, $from = false, $colCondVideAutorisee = false)
	{
	   	if ($colCondVideAutorisee === false && ($colCond === NULL || count($colCond) == 0) && $this->JointuresOntConditions() === false)
	   	   	GLog::LeverException(EXB_0001, 'BObjetBase::Supprimer, aucune condition pour la table ['.$this->nomTable.']. Echec de la suppression en base.');
	   	else
		{
		   	if ($colCond !== NULL)
			{
				foreach ($colCond as $col => $val)
				{
				   	$this->AjouterColWhere($col, $val);
				}
			}

			return $this->ExecuterRequeteSuppression(true, $from);
		}

		return false;
	}

	public function Charger($colSel = NULL, $colCond = NULL)
	{
	   	if ($colSel !== NULL)
		{
		   	foreach ($colSel as $col => $as)
			{
			   	$this->AjouterColSelect($col, $as);
			}
		}

		if ($colCond !== NULL)
		{
			foreach ($colCond as $col => $val)
			{
			   	$this->AjouterColWhere($col, $val);
			}
		}

		return $this->ExecuterRequeteConsultation();
	}

	public function GetNbElements($colSel = NULL, $colCond = NULL)
	{
	   	if ($colSel !== NULL)
		{
		   	foreach ($colSel as $col => $as)
			{
			   	$this->AjouterColSelect($col, $as);
			}
		}

		if ($colCond !== NULL)
		{
			foreach ($colCond as $col => $val)
			{
			   	$this->AjouterColWhere($col, $val);
			}
		}

		return $this->ExecuterRequeteRecuperationNbElements();
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------
	private function ExecuterRequete($requete, array &$params, $nettoyer = true)
	{
		if ($this->niveauLog >= (int) LOG_PERF)
			$this->LogguerPreRequete($requete);

		$requetePreparee = GBase::PreparerRequete($requete);
		if ($requetePreparee !== '')
		{
			$this->AjouterParametresRequete($requetePreparee, $params);
			$requetePreparee->execute();
		}
		else
		   	GLog::LeverException(EXB_0002, 'BObjetBase::ExecuterRequete, la requête préparée est vide pour la table ['.$this->nomTable.'].');

		if ($this->niveauLog >= (int) LOG_ERREUR)
			$this->LogguerPostRequete($requete, $requetePreparee, $params);

		if ($nettoyer === true)
			$this->Nettoyer();

		$erreur = $requetePreparee->errorInfo();
		if ($erreur[0] != 0)
		{
		   	$texteErreur = '';
		   	foreach ($erreur as $value)
		   	{
		   	   	if ($texteErreur !== '')
		   	   		$texteErreur .= ' - ';
			   	$texteErreur .= $value;
			}
			GLog::LeverException(EXB_0003, 'BObjetBase::ExecuterRequete, l\'erreur suivante s\'est produite lors de l\'exécution de la requête: ['.$texteErreur.'].');
			return false;
		}

		if ($requetePreparee === '')
		   	return false;

		return $requetePreparee;
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Requête de type select...
	private function ExecuterRequeteConsultation($nettoyer = true)
	{
		$params = array();
		$requete = $this->ConstruireRequeteConsulation($params);

		$requetePreparee = $this->ExecuterRequete($requete, $params, $nettoyer);

		if ($requetePreparee !== false)
		{
			$resultats = $requetePreparee->fetchAll();
			$resultatsFiltres = array();
			foreach ($resultats as $key => $resultat)
			{
			   	$resultatFiltre = array();
			   	foreach ($resultat as $nomCol => $valCol)
				{
					if (!is_int($nomCol))
					{
						if (is_string($valCol))
							$resultatFiltre[$nomCol] = to_html($valCol);
						else
							$resultatFiltre[$nomCol] = $valCol;
					}
				}
				$resultatsFiltres[$key] = $resultatFiltre;
			}

			return $resultatsFiltres;
		}

		return false;
	}

   	// Requête de type insert...
	private function ExecuterRequeteInsertion($nettoyer = true, $select = false)
	{
		$params = array();
		$requete = $this->ConstruireRequeteInsertion($params, $select);

		if ($this->ExecuterRequete($requete, $params, $nettoyer) === false)
		  	return false;
		else
		   	return GBase::DernierIdInsere();
	}

	// Requête de type update...
	private function ExecuterRequeteMiseAJour($nettoyer = true, $from = false)
	{
		$params = array();
		$requete = $this->ConstruireRequeteMiseAJour($params, $from);

		if ($this->ExecuterRequete($requete, $params, $nettoyer) === false)
		  	return false;
		else
		   	return true;
	}

	// Requête de type delete...
	private function ExecuterRequeteSuppression($nettoyer = true, $from = false)
	{
		$params = array();
		$requete = $this->ConstruireRequeteSuppression($params, $from);

		if ($this->ExecuterRequete($requete, $params, $nettoyer) === false)
		  	return false;
		else
		   	return true;
	}

	// Requête de type select count...
	private function ExecuterRequeteRecuperationNbElements($nettoyer = false)
	{
		$params = array();
		$requete = $this->ConstruireRequeteRecuperationNbElements($params);

		$requetePreparee = $this->ExecuterRequete($requete, $params, $nettoyer);

		if ($requetePreparee !== false)
		{
			$resultats = $requetePreparee->fetchAll();
			foreach ($resultats as $resultat)
			{
			   	foreach ($resultat as $valeur)
				{
			   	   	return $valeur;
			   	}
			}
		}

		return false;
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Construction des requêtes.
	// Formatage des paramêtres pour le passage au SQL (empêche les injections).
	private function AjouterParametresRequete($requete, array &$params)
	{
		$numParam = 0;
		foreach ($params as $param)
		{
			$numParam += 1;
			if (is_int($param))
				$requete->bindValue($numParam, $param, PDO::PARAM_INT);
			else if (is_string($param) && $param !== SQL_NULL)
				$requete->bindValue($numParam, to_utf8($param), PDO::PARAM_STR);
			else if (is_bool($param))
				$requete->bindValue($numParam, $param, PDO::PARAM_BOOL);
			else if (is_null($param) || $param === SQL_NULL)
				$requete->bindValue($numParam, NULL, PDO::PARAM_NULL);
			else
				$requete->bindValue($numParam, $param);
		}
	}

	private function ConstruireRequeteConsulation(array &$params)
	{
		$select = $this->ConstruireSelect($params);
		if ($select === '')
			$select = SQL_ALL;
		$req = SQL_SELECT . ESPACE . $select . ESPACE . SQL_FROM . ESPACE . $this->ConstruireFrom($params);

		$where = $this->ConstruireWhere($params);
		if ($where !== '')
			$req .= ESPACE . SQL_WHERE . ESPACE . $where;

		$groupby = $this->ConstruireGroupBy();
		if ($groupby !== '')
			$req .= ESPACE . SQL_GROUP_BY . ESPACE . $groupby;

		$orderby = $this->ConstruireOrderBy();
		if ($orderby !== '')
			$req .= ESPACE . SQL_ORDER_BY . ESPACE . $orderby;

		$limit = $this->ConstruireLimit();
		if ($limit !== '')
			$req .= ESPACE . SQL_LIMIT . ESPACE . $limit;

		return $req;
	}

	private function ConstruireRequeteInsertion(array &$params, $select = false)
	{
	   	$insert = $this->ConstruireInsert();
	   	$req = SQL_INSERT_INTO . ESPACE . $this->GetName(true) . ESPACE . PARANTHESE_DEBUT . $insert . PARANTHESE_FIN;

		if (($this->liaisons === NULL || count($this->liaisons) === 0) && $select === false)
		{
			$values = $this->ConstruireValues($params);
			$req .= ESPACE . SQL_VALUES . ESPACE . PARANTHESE_DEBUT . $values . PARANTHESE_FIN;
		}
		else
		{
			$select = $this->ConstruireSelect($params, true);
			if ($select === '')
				$select = SQL_ALL;
			$req .= ESPACE . SQL_SELECT . ESPACE . $select . ESPACE . SQL_FROM . ESPACE . $this->ConstruireFrom($params);

			$where = $this->ConstruireWhere($params);
			if ($where !== '')
				$req .= ESPACE . SQL_WHERE . ESPACE . $where;
		}

		return $req;
	}

	private function ConstruireRequeteMiseAJour(array &$params, $from = false)
	{
	   	$req = SQL_UPDATE;

		if (($this->liaisons === NULL || count($this->liaisons) === 0) && $from === false)
		{
		   	$set = $this->ConstruireSet($params);
		   	$req .= ESPACE . $this->GetNameFrom() . ESPACE . SQL_SET . ESPACE . $set;

			$where = $this->ConstruireWhere($params);
			if ($where !== '')
			   	 $req .= ESPACE . SQL_WHERE . ESPACE . $where;
		}
		else
		{
			$req .= ESPACE . $this->ConstruireFrom($params);
			$set = $this->ConstruireSet($params);
			$req .= ESPACE . SQL_SET . ESPACE . $set;

			$where = $this->ConstruireWhere($params);
			if ($where !== '')
				$req .= ESPACE . SQL_WHERE . ESPACE . $where;
		}

		return $req;
	}

	private function ConstruireRequeteSuppression(array &$params, $from = false)
	{
	   	$req = SQL_DELETE;

		if (($this->liaisons === NULL || count($this->liaisons) === 0) && $from === false)
		{
			$req .= ESPACE . SQL_FROM . ESPACE . $this->nomTable;

			$where = $this->ConstruireWhere($params, true);
			if ($where !== '')
				$req .= ESPACE . SQL_WHERE . ESPACE . $where;
		}
		else
		{
			$req .= ESPACE . $this->ConstruireDelete() . ESPACE . SQL_FROM . ESPACE . $this->ConstruireFrom($params);

			$where = $this->ConstruireWhere($params);
			if ($where !== '')
				$req .= ESPACE . SQL_WHERE . ESPACE . $where;
		}

		return $req;
	}

	private function ConstruireRequeteRecuperationNbElements(array &$params)
	{
		$select = $this->ConstruireSelect($params);
		$req = SQL_SELECT . ESPACE . $select . ESPACE . SQL_FROM . ESPACE . $this->ConstruireFrom($params);

		$where = $this->ConstruireWhere($params);
		if ($where !== '')
			$req .= ESPACE . SQL_WHERE . ESPACE . $where;

		$groupby = $this->ConstruireGroupBy();
		if ($groupby !== '')
			$req .= ESPACE . SQL_GROUP_BY . ESPACE . $groupby;

		return $req;
	}

	private function ConstruireSelect(array &$params, $modeInsertion = false)
	{
		$select = '';

		foreach ($this->GetSelections() as $key => $value)
		{
			if ($select !== '')
				$select .= VIRGULE;

			if (is_array($value))
			{
				switch ($value[SQLFONCTION_TYPE])
				{
					case SQLFONCTION_COUNT:
						$paramCount = $value[SQLFONCTION_COL];
						if ($paramCount === NULL)
							$paramCount = 1;
						$select .= 'count('/*..'distinct' . ESPACE*/ . $this->GetNameJointure($value[SQLFONCTION_NUMJOINTURE]) . SQL_SEPARATEUR . $paramCount . ')';
						if ($value[SQLFONCTION_INC] !== NULL && $value[SQLFONCTION_INC] !== 0)
						{
							if ($value[SQLFONCTION_INC] > 0)
								$select .= ' + ' . $value[SQLFONCTION_INC];
							else
								$select .= ' - ' . abs($value[SQLFONCTION_INC]);
						}
						break;
					case SQLFONCTION_MAX:
						$paramMax = $value[SQLFONCTION_COL];
						$select .= 'max(' . $this->GetNameJointure($value[SQLFONCTION_NUMJOINTURE]) . SQL_SEPARATEUR . $paramMax . ')';
						if ($value[SQLFONCTION_INC] !== NULL && $value[SQLFONCTION_INC] !== 0)
						{
							if ($value[SQLFONCTION_INC] > 0)
								$select .= ' + ' . $value[SQLFONCTION_INC];
							else
								$select .= ' - ' . abs($value[SQLFONCTION_INC]);
						}
						break;
					case SQLFONCTION_VALEUR:
					   	$params[] = $value[SQLFONCTION_VALEUR_PARAM];
						$select .= SQL_PARAM;
						break;
					case SQLFONCTION_EXT:
					   	$nomJointure = $this->GetNameJointure($value[SQLFONCTION_NUMJOINTURE]);
						$select .= $nomJointure . SQL_SEPARATEUR;
						if ($value[SQLFONCTION_INC] !== NULL && $value[SQLFONCTION_INC] !== 0)
						{
							if ($value[SQLFONCTION_INC] > 0)
								$select .= $value[SQLFONCTION_COL] . ' + ' . $value[SQLFONCTION_INC];
							else
								$select .= $value[SQLFONCTION_COL] . ' - ' . abs($value[SQLFONCTION_INC]);
						}
						else
						   	$select .= $value[SQLFONCTION_COL];
						break;
				}
			}
			else
			{
			   	if ($value === NULL)
			   		$select .= 'NULL';
				else
				   	$select .= $this->GetName() . SQL_SEPARATEUR . $value;
			}

			if (!is_int($key) && $modeInsertion === false)
				$select .= ESPACE . SQL_AS . ESPACE . $key;
		}

		if ($modeInsertion === false)
		{
			foreach ($this->liaisons as $jointure)
			{
				$selectJointure = $jointure->ConstruireSelect($params, $modeInsertion);
				if ($select != '' && $selectJointure != '')
					$select .= VIRGULE;
				$select .= $selectJointure;
			}
		}

		return $select;
	}

	private function ConstruireInsert()
	{
		$insert = '';

		foreach ($this->GetSelections() as $key => $value)
		{
			if ($insert !== '')
				$insert .= VIRGULE;
			$insert .= $key;
		}

		return $insert;
	}

	private function ConstruireValues(array &$params)
	{
		$values = '';

		foreach ($this->GetSelections() as $value)
		{
			if ($values !== '')
				$values .= VIRGULE;
			$params[] = $value;
			$values .= SQL_PARAM;
		}

		return $values;
	}

	private function ConstruireDelete()
	{
		$delete = '';

		if ($this->supprimerSurJointure === true)
		   	$delete .= $this->GetName();

		foreach ($this->liaisons as $jointure)
		{
		   	$deleteJointure = $jointure->ConstruireDelete();

			if ($deleteJointure !== '')
			{
			   	if ($delete !== '')
			   		$delete .= VIRGULE . ESPACE;
				$delete .= $deleteJointure;
			}
		}

		return $delete;
	}

	private function ConstruireWhere(array &$params, $noNumero = false, $whereJointure = true)
	{
		$where = '';

		foreach ($this->GetParametres() as $key => $value)
		{
			if ($where !== '')
				$where .= ESPACE . SQL_AND . ESPACE;
			if (is_array($value))
			{
				switch ($value[SQLPARAM_TYPE])
				{
					case SQLPARAM_BETWEEN:
						$where .= $this->GetName($noNumero) . SQL_SEPARATEUR . $key . ESPACE . SQL_BETWEEN . ESPACE . SQL_PARAM . ESPACE . SQL_AND . ESPACE . SQL_PARAM;
						$params[] = $value[SQLPARAM_VALEURINF];
						$params[] = $value[SQLPARAM_VALEURSUP];
						break;
					case SQLPARAM_SUPERIEUR:
						$where .= $this->GetName($noNumero) . SQL_SEPARATEUR . $key . ESPACE . SQL_SUPERIEUR . ESPACE . SQL_PARAM;
						$params[] = $value[SQLPARAM_VALEUR];
						break;
					case SQLPARAM_INFERIEUR:
						$where .= $this->GetName($noNumero) . SQL_SEPARATEUR . $key . ESPACE . SQL_INFERIEUR . ESPACE . SQL_PARAM;
						$params[] = $value[SQLPARAM_VALEUR];
						break;
					case SQLPARAM_DIFFERENT:
						$where .= $this->GetName($noNumero) . SQL_SEPARATEUR . $key . ESPACE . SQL_DIFFERENT . ESPACE . SQL_PARAM;
						$params[] = $value[SQLPARAM_VALEUR];
						break;
					case SQLPARAM_LIKE:
						$where .= $this->GetName($noNumero) . SQL_SEPARATEUR . $key . ESPACE . SQL_LIKE . ESPACE . SQL_PARAM;
						$params[] = $value[SQLPARAM_VALEUR];
						break;
					case SQLPARAM_IN:
						$valeurs = $value[SQLPARAM_IN_VALEURS];
					default:
					   	if ($valeurs === NULL)
					   		$valeurs = $value;
					   	if ($valeurs != NULL && is_array($valeurs))
						{
						   	$where .= $this->GetName($noNumero) . SQL_SEPARATEUR . $key . ESPACE . SQL_IN . ESPACE . '(';
						   	$premiereValeur = true;
							foreach ($valeurs as $valeur)
							{
							   	if ($premiereValeur === false)
								   	$where .= ',' . ESPACE;
								$where .= SQL_PARAM;
								$params[] = $valeur;
							   	$premiereValeur = false;
							}
							$where .= ')';
						}
						break;
				}
			}
			else
			{
				$egal = EGAL;
				if ($value === NULL || $value === SQL_NULL)
					$egal = ESPACE . SQL_IS . ESPACE;
				$where .= $this->GetName($noNumero) . SQL_SEPARATEUR . $key . $egal . SQL_PARAM;
				$params[] = $value;
			}

			unset($this->parametres[$key]);
		}

		if ($whereJointure === true)
		{
			foreach ($this->liaisons as $jointure)
			{
				$whereJointure = $jointure->ConstruireWhere($params);
				if ($whereJointure !== '')
				{
					if ($where !== '')
						$where .= ESPACE . SQL_AND . ESPACE;
					$where .= $whereJointure;
				}
			}
		}

		return $where;
	}

	private function ConstruireFrom(array &$params, $racine = true)
	{
	   	$from = '';
	   	if ($racine === true)
		   	$from = $this->GetNameFrom();

		foreach ($this->liaisons as $jointure)
		{
		   	$typeJointure = $jointure->LireTypeJointure();
		   	if ($typeJointure == SQL_CROSS_JOIN)
		   		$from .= ESPACE . $typeJointure . ESPACE . $jointure->GetNameFrom();
		   	else
		   	{
			   	$from .= ESPACE . $typeJointure . ESPACE . $jointure->GetNameFrom() . ESPACE . SQL_ON . ESPACE . $this->GetName() . SQL_SEPARATEUR . $jointure->LireColonneLiaison() . EGAL . $jointure->GetName() . SQL_SEPARATEUR . $jointure->LireColonneJointure() . $this->LireParametresJointureGauche($params, $jointure->parametresJointureGauche) . $this->LireParametresJointureDroite($params);
			   	$where = $jointure->ConstruireWhere($params, false, false);
			   	if ($where !== '')
			   		$from .= ESPACE . SQL_AND . ESPACE . $where;
			}
			$from .= $jointure->ConstruireFrom($params, false);
		}

		return $from;
	}

	private function ConstruireSet(array &$params)
	{
		$set = '';

		foreach ($this->GetSelections() as $colonne => $valeur)
		{
			if ($set !== '')
				$set .= VIRGULE;
			if (is_array($valeur))
			{
				switch ($valeur[SQLSET_TYPE])
				{
				   	case SQLSET_EXT:
					   	$nomJointure = $this->GetNameJointure($valeur[SQLSET_NUMJOINTURE]);
						$set .= $this->GetName() . SQL_SEPARATEUR . $colonne . EGAL . $nomJointure . SQL_SEPARATEUR;
						if ($valeur[SQLSET_INC] !== NULL && $valeur[SQLSET_INC] !== 0)
						{
							if ($valeur[SQLSET_INC] > 0)
								$set .= $valeur[SQLSET_COL] . ' + ' . $valeur[SQLSET_INC];
							else
								$set .= $valeur[SQLSET_COL] . ' - ' . abs($valeur[SQLSET_INC]);
						}
						else
						   	$set .= $valeur[SQLSET_COL];
						break;
					/*case SQLSET_INCREMENT:
						$set .= $this->GetName() . SQL_SEPARATEUR . $colonne . EGAL . $colonne . PLUS . SQL_PARAM;
						$params[] = $valeur[SQLSET_INCREMENT_VALEUR];
						break;*/
				}
			}
			else if ($valeur === SQL_NOW)
				$set .= $this->GetName() . SQL_SEPARATEUR . $colonne . EGAL . 'Now()';
			else
			{
				$set .= $this->GetName() . SQL_SEPARATEUR . $colonne . EGAL . SQL_PARAM;
				$params[] = $valeur;
			}
		}

		foreach ($this->liaisons as $jointure)
		{
		   	$setJointure = $jointure->ConstruireSet($params);

			if ($setJointure !== '')
			{
			   	if ($set !== '')
			   		$set .= VIRGULE . ESPACE;
				$set .= $setJointure;
			}
		}

		return $set;
	}

	public function ConstruireOrderBy($root = true)
	{
		$ordres = $this->GetOrdres();
		foreach ($ordres as $key => $ordre)
			$ordres[$key] = $this->GetName() . SQL_SEPARATEUR . $ordre[SQLORDRE_COL] . ESPACE . $ordre[SQLORDRE_TYPE];

		$ordresJointure = array ();
		foreach ($this->liaisons as $jointure)
			$ordresJointure = $jointure->ConstruireOrderBy(false);

		foreach ($ordresJointure as $key => $ordre)
			$ordres[$key] = $ordre;

		if ($root === false)
			return $ordres;

		$orderby = '';

		ksort($ordres);
		foreach ($ordres as $ordre)
		{
			if ($orderby !== '')
				$orderby .= VIRGULE;
			$orderby .= $ordre;
		}

		return $orderby;
	}

	private function ConstruireGroupBy()
	{
		$groupby = '';

		foreach ($this->GetGroupes() as $colonne)
		{
			if ($groupby !== '')
				$groupby .= VIRGULE;
			$groupby .= $this->GetName() . SQL_SEPARATEUR . $colonne;
		}

		foreach ($this->liaisons as $jointure)
		{
			if ($groupby !== '')
				$groupby .= VIRGULE;
			$groupby .= $jointure->ConstruireGroupBy();
		}

		return $groupby;
	}

	private function ConstruireLimit()
	{
		$limit = '';

		if ($this->nbMaxEnregistrements > 0)
		{
			$limit = $this->nbMaxEnregistrements;
			if ($this->offset > 0)
				$limit .= ESPACE . SQL_OFFSET . ESPACE . $this->offset;
		}

		return $limit;
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Récupération des paramètres de la classe.
	public function GetParametres()
	{
		return $this->parametres;
	}

	public function GetSelections()
	{
		return $this->selections;
	}

	public function GetOrdres()
	{
		return $this->ordres;
	}

	public function GetGroupes()
	{
		return $this->groupes;
	}

	public function GetName($noNumero = false)
	{
		if ($noNumero)
		   	return $this->nomTable;
		return /*$this->nomTable*/'T' . $this->numero;
	}

	public function GetNameFrom()
	{
		return $this->nomTable . ' T' /*. $this->nomTable*/ . $this->numero;
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Fonctions des jointures.
	public function AjouterJointure($colThisJointure, $bObjetBase, $colAutreJointure, $typeJointure = SQL_INNER_JOIN, $paramJointureGauche = array (), $paramJointureDroite = array())
	{
		$bObjetBase->RenseignerInfosLiaison($colThisJointure, $colAutreJointure, $typeJointure, $paramJointureGauche, $paramJointureDroite);
		$this->liaisons[] = $bObjetBase;
	}

	private function RenseignerInfosLiaison($colLiaison, $colJointure, $typeJoin, $paramJointureGauche, $paramJointureDroite)
	{
		$this->colonneLiaison = $colLiaison;
		$this->colonneJointure = $colJointure;
		$this->typeJointure = $typeJoin;
		$this->parametresJointureGauche = $paramJointureGauche;
		$this->parametresJointureDroite = $paramJointureDroite;
	}

	private function LireTypeJointure()
	{
		return $this->typeJointure;
	}

	private function LireColonneLiaison()
	{
		return $this->colonneLiaison;
	}

	private function LireColonneJointure()
	{
		return $this->colonneJointure;
	}

	// Permet de récupérer le nom d'une jointure à partir de son numéro.
	public function GetNameJointure($numJointure)
	{
	   	if ($numJointure === $this->numJointure)
		    return $this->GetName();

	   	$retour = '';
		foreach ($this->liaisons as $jointure)
		{
			$retour = $jointure->GetNameJointure($numJointure);
			if ($retour !== '')
				break;
		}

		return $retour;
	}

	// Permet de vérifier si les jointures ont des conditions.
	public function JointuresOntConditions()
	{
		if ($this->GetParametres() !== NULL && count($this->GetParametres()) > 0)
			return true;

	   	$retour = false;
		foreach ($this->liaisons as $jointure)
		{
			$retour = $jointure->JointuresOntConditions();
			if ($retour === true)
				break;
		}

		return $retour;
	}

	public function SetNumJointure($numJointure)
	{
	   	$this->numJointure = $numJointure;
	}

	public function SupprimerSurJointure($supprimer)
	{
	   	$this->supprimerSurJointure = $supprimer;
	}

	private function LireParametresJointureGauche(array & $params, $paramJointureGauche)
	{
		$complementFromJointure = '';

		foreach($paramJointureGauche as $key => $value)
		{
			$complementFromJointure .= ESPACE . SQL_AND . ESPACE;
			if (is_array($value))
			{
				switch ($value[SQLPARAM_TYPE])
				{
					case SQLPARAM_BETWEEN :
						$complementFromJointure .= $this->GetName() . SQL_SEPARATEUR . $key . ESPACE . SQL_BETWEEN . ESPACE . SQL_PARAM . ESPACE . SQL_AND . ESPACE . SQL_PARAM;
						$params[] = $value[SQLPARAM_BETWEEN_BORNEINF];
						$params[] = $value[SQLPARAM_BETWEEN_BORNESUP];
						break;
				}
			}
			else
			{
				$egal = EGAL;
				if ($value === null)
					$egal = ESPACE . SQL_IS . ESPACE;
				$complementFromJointure .= $this->GetName() . SQL_SEPARATEUR . $key . $egal . SQL_PARAM;
				$params[] = $value;
			}
		}

		return $complementFromJointure;
	}

	private function LireParametresJointureDroite(array & $params)
	{
		$complementFromJointure = '';

		foreach($this->parametresJointureDroite as $key => $value)
		{
			$complementFromJointure .= ESPACE . SQL_AND . ESPACE;
			if (is_array($value))
			{
				switch ($value[SQLPARAM_TYPE])
				{
					case SQLPARAM_BETWEEN :
						$complementFromJointure .= $this->GetName() . SQL_SEPARATEUR . $key . ESPACE . SQL_BETWEEN . ESPACE . SQL_PARAM . ESPACE . SQL_AND . ESPACE . SQL_PARAM;
						$params[] = $value[SQLPARAM_BETWEEN_BORNEINF];
						$params[] = $value[SQLPARAM_BETWEEN_BORNESUP];
						break;
				}
			}
			else
			{
				$egal = EGAL;
				if ($value === null)
					$egal = ESPACE . SQL_IS . ESPACE;
				$complementFromJointure .= $this->GetName() . SQL_SEPARATEUR . $key . $egal . SQL_PARAM;
				$params[] = $value;
			}
		}

		return $complementFromJointure;
	}
}

?>