<?php

namespace DaFramework\Model\Classes
{
	require_once PATH_BASE.'DataField.php';
	require_once PATH_BASE.'DataInt.php';
	require_once PATH_BASE.'DataBool.php';
	require_once PATH_BASE.'DataString.php';
	require_once PATH_BASE.'DataList.php';


	class DataObject
	{
		/*************************************/
		// CLASS FIELDS
		//
	   	private $fields;
		private $lists;
	   	private $jointures;
	   	private $bufferColSel;
	   	private $bufferColIns;
	   	private $bufferColModif;
	   	private $bufferColCond;
		private $bufferColOrdre;
		private $joinedDataObjects;
		private $clePrimaire;
		private $idAutoInc;
		private $noId;
		private $supprimerSurJointure;
		private $modifierSurJointure;
		private $columnNameAsMapping;

		private static $numChamp;


		/*************************************/
		// CLASS PROPERTIES
		//
		public final function ClassName()
		{
			return get_class($this);
		}

		// Get the data table name. By default the class' name.
		public function TableName()
		{
			return self::ClassName();
		}

		public function NewRequestFactory()
		{
			return new RequestFactory();
		}

		protected function Fields()
		{
			return $this->fields;
		}

		protected function Field($columnName)
		{
			return $this->fields[$columnName];
		}

		public function FieldValue($columnName, $value = NULL)
		{
			if ($value !== NULL)
				$this->Field($columnName)->Value($value);
			else
				return $this->Field($columnName)->Value();
			return $this;
		}

		public function FieldSqlValue($columnName)
		{
			return $this->Field($columnName)->SqlValue();
		}

		// Get/Set a field value accross many joints.
		public function JointFieldValue($jointColumnNames, $value = NULL)
		{
			$field = $this->JointField($jointColumnNames);
			if ($field !== NULL)
			{
				if ($value !== NULL)
					$field->Value($value);
				else
					return $field->Value();
			}
			if ($value !== NULL)
				return $this;
			return NULL;
		}

		// Get/Set a field sql value accross many joints.
		public function JointFieldSqlValue($jointColumnNames, $value = NULL)
		{
			$field = $this->JointField($jointColumnNames);
			if ($field !== NULL)
			{
				if ($value !== NULL)
					$field->SqlValue($value);
				else
					return $field->SqlValue();
			}
			if ($value !== NULL)
				return $this;
			return NULL;
		}

		// Get a field accross many joints.
		protected function JointField($jointColumnNames, $index = 0)
		{
			$jointColumnNamesArray = $jointColumnNames;
			if (!is_array($jointColumnNames))
				$jointColumnNamesArray = $this->JointColumnNamesFromStringToArray($jointColumnNames);

			$returnedField = NULL;

			// Does this field exists?
			if (array_key_exists($jointColumnNamesArray[$index], $this->fields))
			{
				$field = $this->fields[$jointColumnNamesArray[$index]];
				// Is it the last?
				if (array_key_exists($index + 1, $jointColumnNamesArray))
				{
					if ($field->IsJoint())
						$returnedField = $field->Value()->JointField($jointColumnNamesArray, $index + 1);
				}
				else
					$returnedField = $field;
			}
	//		else
	//			GLog::LeverException(EXM_, $this->ClassName().'::JointField, field ['.$jointColumnNamesArray[$index].'] doesn't exist for this table class ['.$this->TableName().'].');

			return $returnedField;
		}

		// Get the primary key's fields.
		public function PrimaryKeyFields()
		{
			$primaryKeyFields = array();
			foreach ($this->fields as $dataField)
			{
				if ($dataField->IsPrimaryKey())
					$primaryKeyFields[] = $dataField->ColumnName();
			}
			return $primaryKeyFields;
		}

		protected function DataList($jointClassName, $jointClassColumnName)
		{
			return $this->lists[$jointClassName.'&'.$jointClassColumnName];
		}

		// Get/Set a list value.
		public function ListValue($jointClassName, $jointClassColumnName, $value = NULL)
		{
			if ($value !== NULL)
				$this->DataList($jointClassName, $jointClassColumnName)->Value($value);
			else
				return $this->DataList($jointClassName, $jointClassColumnName)->Value();
			return $this;
		}

		/*************************************/
		// CLASS CONSTRUCTORS
		//
		// Constructor.
		public function __construct()
		{
			$this->ResetBuffers();
			$this->fields = array();
			$this->lists = array();
			if ($this->idAutoInc === NULL)
				$this->idAutoInc = true;
			$this->supprimerSurJointure = false;
			$this->modifierSurJointure = false;
			$this->columnNameAsMapping = array();

			$this->AddFields();
		}


		/*************************************/
		// DATA FIELDS
		//
		// Set object data fields values from array of format post:
		// array('nom_col1=value', 'nom_col1,nom_col2,...=value', ...);
		// where nom_col1 is for $this and nom_col2, ... for joined objects.
		public function SetFieldsFromPost($post)
		{
			foreach ($post as $columnName => $value)
			{
				$columnNameArray = $columnName;
				if (strpos($columnName, ',') !== false)
					$columnNameArray = explode(',', $columnName);
				$this->SetFieldFromArray($columnNameArray, $value);
			}
		}

		// Set object data fields values from array of format returned by PDO.
		protected function SetFieldsFromSQL($sqlResults)
		{
			foreach ($this->columnNameAsMapping as $columnName => $as)
			{
				$this->SetFieldSQL($columnName, $sqlResults[$as]);
			}

			if ($this->joinedDataObjects !== NULL)
			{
				foreach($this->joinedDataObjects as $joinedDataObject)
				{
					$joinedDataObject->SetObjectFromSQL($sqlResults);
				}
			}

			$this->columnNameAsMapping = array();
		}

		// Method where you add the description of class data columns.
		// Implementation exemple:
		// $this->AddIntField(...);
		// $this->AddStringField(...);
		// ...;
		protected function AddFields()
		{
		}

		protected function AddIntField($columnName, $isNullable = false, $isPrimaryKey = false, $isAutoIncremental = false, $defaultValue = NULL)
		{
			$field = new DataIntField($columnName, $isNullable, $isPrimaryKey, $isAutoIncremental, $defaultValue);
			$this->fields[$columnName] = &$field;
			return $field;
		}

		protected function AddStringField($columnName, $isNullable = false, $isPrimaryKey = false, $isAutoIncremental = false, $defaultValue = NULL)
		{
			$field = new DataStringField($columnName, $isNullable, $isPrimaryKey, $isAutoIncremental, $defaultValue);
			$this->fields[$columnName] = &$field;
			return $field;
		}

		protected function AddBoolField($columnName, $isNullable = false, $isPrimaryKey = false, $isAutoIncremental = false, $defaultValue = NULL)
		{
			$field = new DataField($columnName, $isNullable, $isPrimaryKey, $isAutoIncremental, $defaultValue);
			$this->fields[$columnName] = &$field;
			return $field;
		}

		protected function ConvertJointColumnNamesFromArrayToString($jointColumnNamesArray)
		{
		   	$jointColumnNamesString = '';

		   	foreach ($jointColumnNames as $columnName)
		   	{
		   	   	if ($jointColumnNamesString !== '')
		   	   		$jointColumnNamesString .= ',';
			   	$jointColumnNamesString .= $columnName;
			}

			return $jointColumnNamesString;
		}

		protected function ConvertJointColumnNamesFromStringToArray($jointColumnNamesString)
		{
			return explode(',', $jointColumnNamesString);
		}

		protected function IsFieldExists($jointColumnNames, $index = 0)
		{
		   	$jointColumnNamesArray = $jointColumnNames;
			if (!is_array($jointColumnNames))
		   	   	$jointColumnNamesArray = $this->JointColumnNamesFromStringToArray($jointColumnNames);

			$exists = false;

			if (array_key_exists($jointColumnNamesArray[$index], $this->Fields()))
			{
		   	   	if (array_key_exists($index + 1, $jointColumnNamesArray))
		   	   	{
		   	   		$field = $this->Field($jointColumnNamesArray[$index]);
		   	   	   	if ($field->IsJoint())
		   	   		   	$exists = $field->Value()->IsFieldExists($jointColumnNamesArray, $index + 1);
		   	   	}
				else
					$exists = true;
		   	}

			return $exists;
		}

		protected function IsPrimaryKeyField($columnName)
		{
			return $this->Field($columnName)->IsPrimaryKey();
		}


		/*************************************/
		// DATA LISTS
		//
		// Method where you add the description of class data lists.
		// Implementation exemple:
		// $this->AddList(...);
		// $this->AddList(...);
		// ...;
		protected function AddLists()
		{
		}

		protected function AddList($jointClassName, $jointClassColumnName, $jointColumnName = NULL)
		{
			$primaryKeyFields = $this->PrimaryKeyFields();
			if ($jointColumnName === NULL)
			{
				if (count($primaryFields) === 1)
					$jointColumnName = $primaryKeyFields[0];
				else
				{
	//				GLog::LeverException(EXM_, DataField::Value, the joint column name for the joint class name ['.$this->value->GetClassName().'] must be explicited.');
					return NULL;
				}
			}

			$list = new DataList($jointClassName, $jointClassColumnName, $jointColumnName);
			$this->lists[$jointClassName.'&'.$jointClassColumnName] = &$list;
			return $list;
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
}

?>