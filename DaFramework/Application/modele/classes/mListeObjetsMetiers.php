<?php

require_once 'cst.php';
require_once PATH_METIER.'mObjetMetier.php';


define ('MLOM_FILTRE_TYPE', 'type');
define ('MLOM_FILTRE_VALEUR', 'valeur');

define ('MLOM_FILTRETYPE_EGAL', 'egal');
define ('MLOM_FILTRETYPE_DIFF', 'diff');
define ('MLOM_FILTRETYPE_INF', 'inf');
define ('MLOM_FILTRETYPE_SUP', 'sup');
define ('MLOM_FILTRETYPE_ENTRE', 'entre');
define ('MLOM_FILTRETYPE_LIKE', 'like');


class MListeObjetsMetiers
{
	protected $liste;
	protected $filtres;
	protected $filtresJointures;
	protected $jointures;
	protected $estListeId;
	protected $bufferColSel;
	protected $bufferColAjout;
	protected $bufferColModif;
	protected $bufferColOrdre;
	protected $objetMetierReference;
	protected $objetsJoints;
	protected $numOrdre;
	protected $supprimerSurJointure;
	protected $filtreGlobal;
	protected $dejaChargee;
	protected $typeObjets;
	protected $currentJointure;

	public function __construct($typeObjets, $filtreGlobal = false)
	{
		$this->liste = array();
		$this->filtres = array();
		$this->jointures = array();
		$this->bufferColSel = NULL;
		$this->bufferColAjout = NULL;
		$this->bufferColModif = NULL;
		$this->bufferColOrdre = NULL;
		$this->mObjetMetierReference = NULL;
		$this->dejaChargee = false;
		$this->objetsJoints = array();
		$this->supprimerSurJointure = array();
		$this->currentJointure = 0;
		require_once PATH_METIER.$typeObjets.'.php';
		$this->objetsJoints[0] = $this->GetObjetMetierReference();
		$this->typeObjets = $typeObjets;
		if ($filtreGlobal === true)
		   	$this->AutoriserFiltreGlobal();
		else
		   	$this->EstListeId(true);
	}

	public function __destruct()
	{
		unset($this->liste);
		unset($this->filtres);
		unset($this->estListeId);
		unset($this->jointures);
		unset($this->bufferColSel);
		unset($this->bufferColAjout);
		unset($this->bufferColModif);
		unset($this->bufferColOrdre);
		unset($this->mObjetMetierReference);
		unset($this->objetsJoints);
	}

	public function GetNom()
	{
		return 'MListeObjetsMetiers<'.$this->typeObjets.'>';
	}

	public function GetNouvelElement()
	{
		return eval('new '.$this->typeObjets.'();');
	}

	public function GetObjetBase()
	{
		$mObjetMetierRef = $this->GetObjetMetierReference();
		return $mObjetMetierRef->GetObjetBase();
	}

	public function GetObjetMetierReference()
	{
		if ($this->objetMetierReference === NULL)
			$this->objetMetierReference = $this->GetNouvelElement();
		return $this->objetMetierReference;
	}

	public function EstListeId($estListeId = NULL)
	{
	   	if ($estListeId !== NULL)
	   	{
	   	   	$this->estListeId = $estListeId;
	   	   	if ($this->estListeId === true)
	   	   	   	$this->filtreGlobal = false;
	   	}
	   	return $this->estListeId;
	}

	public function GetListe()
	{
	   	$liste = $this->liste;
		return $liste;
	}

	public function SetListe($liste)
	{
	   	$this->liste = $liste;
	}

	public function GetNbElements()
	{
		return count($this->liste);
	}

	public function GetListeId()
	{
		$listeId = array();

		$liste = $this->liste;
		while(list($i, $element) = each($liste))
		{
			$listeId[] = $element->Id();
		}

		return $listeId;
	}

	public function GetElementById($id)
	{
		$liste = $this->liste;
		while(list($i, $element) = each($liste))
		{
			if ($id == $element->Id())
				return $element;
		}

		return NULL;
	}

	public function AjouterElement(MObjetMetier $element, $exception = true)
	{
	   	if ($element->Id() === NULL || $this->GetElementById($element->Id()) === NULL)
		{
		   	if ($this->ElementRespecteFiltres($element) === true)
			   	$this->liste[] = $element;
			else if ($exception === true)
			   	GLog::LeverException(EXM_0180, $this->GetNom().'::AjouterElement, l\'élément d\'id ['.$element->Id().'] ne correspond pas au filtre, il n\'a pas été ajouté à la liste.');
		}
	}

	public function AjouterElementAvecId($id, $exception = true)
	{
	   	if ($this->GetElementById($id) === NULL)
	   	{
		   	$element = $this->GetNouvelElement();
		   	$element->Id($id);
		   	if ($this->ElementRespecteFiltres($element) === true)
			   	$this->liste[] = $element;
			else if ($exception === true)
			   	GLog::LeverException(EXM_0187, $this->GetNom().'::AjouterElementAvecId, l\'élément d\'id ['.$id.'] ne correspond pas au filtre, il n\'a pas été ajouté à la liste.');
		}
	}

	public function AjouterElementFromTableau($tableau, $exception = true, $ajouterAuDebut = false)
	{
	   	$element = $this->GetNouvelElement();
	   	$element->SetObjetFromTableau($tableau);
		if ($element->Id() === NULL || $this->GetElementById($element->Id()) === NULL)
		{
		   	if ($this->ElementRespecteFiltres($element) === true)
		   	{
		   	   	if ($ajouterAuDebut === true)
		   	   		array_unshift($this->liste, $element);
		   	   	else
			   	   	$this->liste[] = $element;
			}
			else if ($exception === true)
			   	GLog::LeverException(EXM_0193, $this->GetNom().'::AjouterElementFromTableau, l\'élément d\'id ['.$element->Id().'] ne correspond pas au filtre, il n\'a pas été ajouté à la liste.');
		}
	}

	public function SupprimerElement($id, $nomChampId = COL_ID)
	{
	   	/*foreach ($this->liste as $i => $element)
		{
			if ($id == $element->Id())
				unset($this->liste[$i]);
		}*/
	   	foreach ($this->liste as $i => $element)
		{
			if ($id == $element->GetChampSQLFromTableau($nomChampId))
				unset($this->liste[$i]);
		}
	}

	// Permet de remplir la liste à partir d'un tableau de la forme $tab[NUM_ELEM][NOM_COL].
	// Le mapping permet de transformer le nom d'une colonne en une autre, par ex:
	// $mapping = array(array(NOM, PRENOM)); transformera la colonne NOM en colonne PRENOM.
	public function SetListeFromTableau($tableau, $mapping = NULL)
	{
	   	$tabFiltree = NULL;
	    foreach ($tableau as $tab)
		{
		   	$element = $this->GetNouvelElement();

			if ($tabFiltree !== NULL)
			   	unset($tabFiltree);
		   	$tabFiltree = array();
		   	foreach ($tab as $nom => $valeur)
		   	{
				$nomFiltre = $nom;
			   	if ($mapping !== NULL)
				{
		   		   	foreach ($mapping as $map)
		   		   	{
						if ($map[0] === $nom)
						{
							$nomFiltre = $map[1];
							break;
						}
					}
		   		}

		   		if ($element->IsChampExiste($nomFiltre) === true)
		   		   	$tabFiltree[$nomFiltre] = $valeur;
			}

		   	$element->SetObjetFromTableau($tabFiltree);
		   	$this->liste[] = $element;
		}
	}

	// Permet d'affecter une valeur à tous les éléments de la liste.
	public function SetListeChampValeur($nom, $valeur)
	{
	   	foreach ($this->liste as $element)
	   	{
	   	   	$element->SetChampFromTableau($nom, $valeur);
	   	}
	}

	// Vérifie si la liste a déjà été chargée.
	public function ListeChargee($listeChargee = NULL)
	{
	   	if ($listeChargee !== NULL)
	   		$this->dejaChargee = $listeChargee;
	   	return $this->dejaChargee;
	}

	/*************************************/
	// Filtre global autorisé (pas de close where), permet de garantir la sécurité pour les modifications et
	// suppressions globales d'une table non souhaitées.
	public function AutoriserFiltreGlobal()
	{
	   	$this->filtreGlobal = true;
	   	$this->estListeId = false;
	}

	protected function AjouterFiltre($colonne, $valeur, $type, $numJointure = 0, $filtre = array())
	{
	   	$this->EstListeId(false);

	   	//$filtre = array();
	   	$filtre[MLOM_FILTRE_VALEUR] = $valeur;
	   	$filtre[MLOM_FILTRE_TYPE] = $type;

	   	if (!array_key_exists($numJointure, $this->filtres))
	   		$this->filtres[$numJointure] = array();
	   	$this->filtres[$numJointure][$colonne] = $filtre;

	   	// On supprime les éléments qui n'appartiennent plus au filtre.
	   	foreach ($this->liste as $i => $element)
		{
	   		if ($this->ElementRespecteFiltres($element) === false)
	   		   	unset($this->liste[$i]);
	   	}
	}

	public function AjouterFiltreEgal($colonne, $valeur)
	{
	   	$this->AjouterFiltreEgalPourJointure(0, $colonne, $valeur);
	}

	public function AjouterFiltreEgalPourJointure($numJointure, $colonne, $valeur)
	{
	   	$this->AjouterFiltre($colonne, $valeur, MLOM_FILTRETYPE_EGAL, $numJointure);
	}

	public function AjouterFiltreDifferent($colonne, $valeur)
	{
	   	$this->AjouterFiltreDifferentPourJointure(0, $colonne, $valeur);
	}

	public function AjouterFiltreDifferentPourJointure($numJointure, $colonne, $valeur)
	{
	   	$this->AjouterFiltre($colonne, $valeur, MLOM_FILTRETYPE_DIFF, $numJointure);
	}

	public function AjouterFiltreInferieur($colonne, $valeur)
	{
	   	$this->AjouterFiltreInferieurPourJointure(0, $colonne, $valeur);
	}

	public function AjouterFiltreInferieurPourJointure($numJointure, $colonne, $valeur)
	{
	   	$this->AjouterFiltre($colonne, $valeur, MLOM_FILTRETYPE_INF, $numJointure);
	}

	public function AjouterFiltreSuperieur($colonne, $valeur)
	{
	   	$this->AjouterFiltreSuperieurPourJointure(0, $colonne, $valeur);
	}

	public function AjouterFiltreSuperieurPourJointure($numJointure, $colonne, $valeur)
	{
	   	$this->AjouterFiltre($colonne, $valeur, MLOM_FILTRETYPE_SUP, $numJointure);
	}

	public function AjouterFiltreEntre($colonne, $valeurInf, $valeurSup)
	{
	   	$this->AjouterFiltreEntrePourJointure(0, $colonne, $valeurInf, $valeurSup);
	}

	public function AjouterFiltreEntrePourJointure($numJointure, $colonne, $valeurInf, $valeurSup)
	{
	   	$valeur = array();

	   	// Au cas où la valeur supérieure serait inférieure, on inverse les valeurs automatiquement.
	   	if ($valeurInf < $valeurSup)
	   	{
	   		$valeur[0] = $valeurInf;
	   		$valeur[1] = $valeurSup;
	   	}
	   	else
	   	{
		   	$valeur[0] = $valeurSup;
	   		$valeur[1] = $valeurInf;
		}

	   	$this->AjouterFiltre($colonne, $valeur, MLOM_FILTRETYPE_ENTRE, $numJointure);
	}

	public function AjouterFiltreLike($colonne, $valeur)
	{
	   	$this->AjouterFiltreLikePourJointure(0, $colonne, $valeur);
	}

	public function AjouterFiltreLikePourJointure($numJointure, $colonne, $valeur)
	{
	   	$this->AjouterFiltre($colonne, $valeur, MLOM_FILTRETYPE_LIKE, $numJointure);
	}

	public function SupprimerFiltre($colonne)
	{
	   	$this->SupprimerFiltrePourJointure(0, $colonne);
	}

	public function SupprimerFiltrePourJointure($numJointure, $colonne)
	{
	   	unset($this->filtres[$numJointure][$colonne]);
	}

	public function GetFiltreValeur($numJointure, $colonne)
	{
	   	if (!array_key_exists($numJointure, $this->filtres) || !array_key_exists($colonne, $this->filtres[$numJointure]))
		   	return NULL;

	   	return $this->filtres[$numJointure][$colonne][MLOM_FILTRE_VALEUR];
	}

	private function GetFiltreValeurSQL($numJointure, $colonne)
	{
	   	$filtre = $this->filtres[$numJointure][$colonne];
	   	$type = $filtre[MLOM_FILTRE_TYPE];

	   	switch ($type)
		{
		   	case MLOM_FILTRETYPE_DIFF:
		   	   	$valeur = array();
		   	   	$valeur[SQLPARAM_TYPE] = SQLPARAM_DIFFERENT;
		   	   	$valeur[SQLPARAM_VALEUR] = $filtre[MLOM_FILTRE_VALEUR];
		   	   	return $valeur;
		   	case MLOM_FILTRETYPE_SUP:
		   	   	$valeur = array();
		   	   	$valeur[SQLPARAM_TYPE] = SQLPARAM_SUPERIEUR;
		   	   	$valeur[SQLPARAM_VALEUR] = $filtre[MLOM_FILTRE_VALEUR];
		   	   	return $valeur;
		   	case MLOM_FILTRETYPE_INF:
		   	   	$valeur = array();
		   	   	$valeur[SQLPARAM_TYPE] = SQLPARAM_INFERIEUR;
		   	   	$valeur[SQLPARAM_VALEUR] = $filtre[MLOM_FILTRE_VALEUR];
		   	   	return $valeur;
		   	case MLOM_FILTRETYPE_LIKE:
		   	   	$valeur = array();
		   	   	$valeur[SQLPARAM_TYPE] = SQLPARAM_LIKE;
		   	   	$valeur[SQLPARAM_VALEUR] = $filtre[MLOM_FILTRE_VALEUR];
		   	   	return $valeur;
		   	case MLOM_FILTRETYPE_ENTRE:
		   	   	$valeur = array();
		   	   	$valeur[SQLPARAM_TYPE] = SQLPARAM_BETWEEN;
		   	   	$valeur[SQLPARAM_VALEURINF] = $filtre[MLOM_FILTRE_VALEUR][0];
		   	   	$valeur[SQLPARAM_VALEURSUP] = $filtre[MLOM_FILTRE_VALEUR][1];
		   	   	return $valeur;
	   		case MLOM_FILTRETYPE_EGAL:
	   		default:
	   			return $filtre[MLOM_FILTRE_VALEUR];
	   	}
	}

	public function ElementRespecteFiltres($element)
	{
	   	$mObjetMetier = $element;
	   	$mObjetsJoints = array();
	   	//$mObjetsJoints[0] = $element;

	   	//foreach ($this->filtres as $numJointure => $filtre)
		$nbJointures = count($this->filtres);
		for ($numJointure = 0; $numJointure < $nbJointures; $numJointure++)
		{
		   	if ($numJointure > 0)
			{
			   	$mObjetMetierRef = $mObjetsJoints[$this->jointures[$numJointure][MOM_JOINTURE_NUMOBJET]];
			   	$mObjetMetier = $mObjetMetierRef->GetChampObjetNonNul($this->jointures[$numJointure][MOM_JOINTURE_COLTHIS]);
			}
			$mObjetsJoints[$numJointure] = $mObjetMetier;

			if (array_key_exists($numJointure, $this->filtres))
			{
				$filtre = $this->filtres[$numJointure];
				foreach ($filtre as $colonne => $valeur)
				{
				   	$valElem = $mObjetMetier->GetChampSQL($colonne);
				   	$type = $valeur[MLOM_FILTRE_TYPE];

				 	if ($valElem !== NULL)
					{
					   	switch ($type)
					   	{
					   	   	case MLOM_FILTRETYPE_DIFF:
					   	   	   	if ($valElem === $valeur[MLOM_FILTRE_VALEUR])
							   	   	return false;
							case MLOM_FILTRETYPE_SUP:
					   	   	   	if ($valElem <= $valeur[MLOM_FILTRE_VALEUR])
							   	   	return false;
							case MLOM_FILTRETYPE_INF:
					   	   	   	if ($valElem >= $valeur[MLOM_FILTRE_VALEUR])
							   	   	return false;
							case MLOM_FILTRETYPE_ENTRE:
					   	   	   	if ($valElem < $valeur[MLOM_FILTRE_VALEUR][0] || $valElem > $valeur[MLOM_FILTRE_VALEUR][1])
							   	   	return false;
							case MLOM_FILTRETYPE_LIKE:
							   	break;
					   	   	case MLOM_FILTRETYPE_EGAL:
					   	   	default:
							   	if ($valElem !== $valeur[MLOM_FILTRE_VALEUR])
							   	   	return false;
						}
					}
				}
			}
		}

		return true;
	}

	/*************************************/
	public function GetObjetsJoints()
	{
	   	return $this->objetsJoints;
	}

	public function GetJointures()
	{
	   	return $this->jointures;
	}

	public function GetFiltres()
	{
	   	return $this->filtres;
	}

	/*************************************/
	public function Ajouter()
	{
	   	$retour = false;

	   	// Si la liste est une liste d'éléments séparés (sans filtre) ou qu'on n'a pas de buffer de colonne
	   	// à ajouter.
	   	if ($this->EstListeId() === true || $this->bufferColAjout === NULL || count($this->bufferColAjout) === 0)
		{
		   	$retour = true;
		   	foreach ($this->liste as $element)
			{
			   	if ($element->Ajouter() === false)
			   	   	$retour = false;
			}
		}
		else
		{
			$colCond = $this->GetColCond();
			$cols = $this->bufferColAjout;

			$form = false;
			foreach ($cols as $valeur)
			{
				if (is_array($valeur))
				   	$form = true;
			}

			$bObjetBase = $this->GetObjetBase();
			$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_AJOUT);
			$bObjetBase->SetNumJointure(0);
			$retour = $bObjetBase->Ajouter($cols, $colCond, $form);
		}

		unset($this->bufferColAjout);
		$this->bufferColAjout = NULL;

		if ($retour === false)
			GLog::LeverException(EXM_0188, $this->GetNom().'::Ajouter, échec de l\'insertion en base.');
		return $retour;
	}

	public function Modifier()
	{
	   	$retour = false;

	   	if ($this->EstListeId() === true)
		{
		   	$retour = true;
		   	foreach ($this->liste as $element)
			{
			   	if ($element->Modifier() === false)
			   	   	$retour = false;
			}
		}
		else
		{
		   	$colCond = $this->GetColCond();
			$colSet = $this->bufferColModif[0];

			if ($this->filtreGlobal === false && count($colCond) == 0 && ($this->jointures === NULL || count($this->jointures) === 0))
				GLog::LeverException(EXM_0181, $this->GetNom().'::Modifier, aucune condition.');
			else if (count($colSet) == 0)
			   	GLog::LeverException(EXM_0182, $this->GetNom().'::Modifier, aucune modification.');
			else
			{
				$bObjetBase = $this->GetObjetBase();
				$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_MODIFICATION);
				$bObjetBase->SetNumJointure(0);
				$retour = $bObjetBase->Modifier($colSet, $colCond, false, $this->filtreGlobal);
			}
		}

		unset($this->bufferColModif);
		$this->bufferColModif = NULL;

		if ($retour === false)
			GLog::LeverException(EXM_0189, $this->GetNom().'::Modifier, échec de la modification en base.');
		return $retour;
	}

	public function Supprimer()
	{
	   	$retour = false;

	   	if ($this->EstListeId() === true)
		{
		   	$retour = true;
		   	foreach ($this->liste as $element)
			{
			   	if ($element->Supprimer() === false)
			   	   	$retour = false;
			}
		}
		else
		{
		   	$colCond = $this->GetColCond();

		   	if ($this->filtreGlobal === false && count($colCond) == 0 && ($this->jointures === NULL || count($this->jointures) === 0))
				GLog::LeverException(EXM_0183, $this->GetNom().'::Supprimer, aucune condition. Echec de la suppression en base.');
			else
			{
				$bObjetBase = $this->GetObjetBase();

				// Si on est dans le cas d'un delete multiple, alors on regarde si les lignes de la table doivent être supprimées.
			   	$suppOk = false;
				foreach ($this->supprimerSurJointure as $supprimer)
				{
				   	if ($supprimer === true)
					{
				   		$suppOk = true;
				   		break;
				   	}
				}
				if ($suppOk === true)
				   	$bObjetBase->SupprimerSurJointure($this->SupprimerSurJointure(0));
				else
				   	$bObjetBase->SupprimerSurJointure(true);

				$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_SUPPRESSION);
				$bObjetBase->SetNumJointure(0);
				$retour = $bObjetBase->Supprimer($colCond, false, $this->filtreGlobal);
			}
		}

		if ($retour === false)
			GLog::LeverException(EXM_0190, $this->GetNom().'::Supprimer, échec de la suppression en base.');
		return $retour;
	}

	public function Charger($nbMaxEnregistrements = -1, $offset = -1)
	{
	   	$retour = false;
	   	$colSel = array();
	   	if ($this->bufferColSel !== NULL && array_key_exists(0, $this->bufferColSel))
	   	   	$colSel = $this->bufferColSel[0];

	   	$colCond = $this->GetColCond();
	   	$listeResultats = array();
		/*$bObjetBase = $this->GetObjetBase();
		// On ajoute l'ordre de chargement.
		if ($this->bufferColOrdre !== NULL && array_key_exists(0, $this->bufferColOrdre))
		{
			foreach ($this->bufferColOrdre[0] as $ordre => $col)
			{
				$this->objetsJoints[0]->AjouterBaseColOrdre($bObjetBase, $col[SQLORDRE_COL], $ordre, $col[SQLORDRE_TYPE]);
			}
		}*/

		// On récupère l'objet base avec les jointures qu'il faut pour notre requête.
		$bObjetBase = $this->GetObjetBasePourRequete(MOM_TYPEREQ_CHARGEMENT);
		// On rajoute la limite du nombre d'enregistrements à récupérer ainsi que l'offset à partir duquel on doit
		// commencer à compter (par ex les 20 premiers enregistrements à partir du 10e).
		$bObjetBase->AjouterLimiteNbEnregistrements($nbMaxEnregistrements, $offset);
		// Requête.
		$listeResultats = $bObjetBase->Charger($colSel, $colCond);

		// Rangement des résultats récupérés.
		if ($listeResultats !== false)
		{
		   	$retour = true;

		   	foreach ($listeResultats as $resultat)
			{
			   	$element = NULL;
			   	if (array_key_exists(COL_ID, $resultat))
			   	   	$element = $this->GetElementById($resultat[COL_ID]);
			   	if ($element === NULL)
			   	   	$element = $this->GetNouvelElement();

			   	$mObjetsJoints = array();
			   	if ($this->bufferColSel !== NULL && array_key_exists(0, $this->bufferColSel))
			   	   	$element->SetObjetFromSQL($resultat, $this->bufferColSel[0]);
			   	$mObjetsJoints[0] = $element;

			   	foreach ($this->jointures as $numJointure => $jointure)
				{
					$mObjetMetierRef = $mObjetsJoints[$jointure[MOM_JOINTURE_NUMOBJET]];
					$mObjetMetier = $mObjetMetierRef->GetChampObjetNonNul($jointure[MOM_JOINTURE_COLTHIS]);
					$mObjetsJoints[$numJointure] = $mObjetMetier;
					if ($mObjetMetier !== NULL && $this->bufferColSel !== NULL && array_key_exists($numJointure, $this->bufferColSel))
			 		   	$mObjetMetier->SetObjetFromSQL($resultat, $this->bufferColSel[$numJointure]);
			 	}
			 	$this->AjouterElement($element);
		   	}
		}

		unset($this->bufferColSel);
		unset($this->bufferColOrdre);
		$this->bufferColSel = NULL;
		$this->bufferColOrdre = NULL;

		if ($retour === false)
			GLog::LeverException(EXM_0191, $this->GetNom().'::Charger, échec du chargement en base.');

		$this->dejaChargee = true;

		return $retour;
	}

	public function GetNbElementsFromBase($nomCol = COL_ID)
	{
	   	$retour = false;
	   	$colSel = array();
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_COUNT;
		$tab[SQLFONCTION_NUMJOINTURE] = 0;
		$tab[SQLFONCTION_COL] = $nomCol;
		$tab[SQLFONCTION_AS] = NULL;
		$tab[SQLFONCTION_INC] = 0;
	   	$colSel[$nomCol] = $tab;

	   	$colCond = $this->GetColCond();

		// Chargement en base.
	   	$listeResultats = array();
		$bObjetBase = $this->GetObjetBase();

		// On ajoute les jointures s'il y en a.
		$this->AjouterJointures($bObjetBase, $this->jointures, MOM_TYPEREQ_GETNBELEMENTS);
		$bObjetBase->SetNumJointure(0);
		$retour = $bObjetBase->GetNbElements($colSel, $colCond);

		if ($retour === false)
			GLog::LeverException(EXM_0192, $this->GetNom().'::GetNbElementsFromBase, échec du chargement en base.');
		return $retour;
	}

	protected function GetColCond($numJointure = 0)
	{
	   	$colCond = array();

	   	if ($numJointure === 0 && $this->EstListeId() === true)
	   	  	$colCond[COL_ID] = $this->GetListeId();
	   	if (array_key_exists($numJointure, $this->filtres))
		{
		   	foreach ($this->filtres[$numJointure] as $colonne => $valeur)
			{
			   	$colCond[$colonne] = $this->GetFiltreValeurSQL($numJointure, $colonne);
			}
		}

		return $colCond;
	}

	public function AjouterColSelection($nomsCol, $jointures = NULL)
	{
	   	$this->GetObjetMetierReference()->AjouterColSelection($nomsCol, $jointures);
		return $this;
	}

	public function AjouterColSelectionCount($nomCol, $inc = 0, $jointures = NULL)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_COUNT;
		$tab[SQLFONCTION_COL] = $nomCol;
		$tab[SQLFONCTION_INC] = $inc;

		$this->AjouterColSelection($tab, $jointures);
	}

	public function AjouterToutesColSelection()
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
		$mObjet->AjouterToutesColSelection();
	}

	// Permet de préparer une requête update (partie set: colonnes à changées).
	public function AjouterColModification($nom, $valeur)
	{
	   	$this->AjouterColModificationPourJointure(0, $nom, $valeur);
	}

	public function AjouterColModificationPourJointure($numJointure, $nom, $valeur)
	{
	   	if ($this->bufferColModif === NULL)
	   	   	$this->bufferColModif = array();

	   	if (!array_key_exists($numJointure, $this->bufferColModif))
		   	$this->bufferColModif[$numJointure] = array();

		$this->bufferColModif[$numJointure][$nom] = $valeur;
	}

	public function AjouterColModificationExt($numJointure, $nomCol, $nomColJointure, $inc = 0)
	{
	   	$tab = array();
		$tab[SQLSET_TYPE] = SQLSET_EXT;
		$tab[SQLSET_NUMJOINTURE] = $numJointure;
		$tab[SQLSET_COL] = $nomColJointure;
		$tab[SQLSET_INC] = $inc;

		$this->AjouterColModification($nomCol, $tab);
	}

	// Permet de préparer une requête insert.
	public function AjouterColInsertion($colonne, $valeur)
	{
	   	if ($this->bufferColAjout === NULL)
	   	   	$this->bufferColAjout = array();

	   	$this->bufferColAjout[$colonne] = $valeur;
	}

	public function AjouterColInsertionExt($numJointure, $nomCol, $nomColJointure, $inc = 0)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_EXT;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomColJointure;
		$tab[SQLFONCTION_AS] = NULL;
		$tab[SQLFONCTION_INC] = $inc;

		$this->AjouterColInsertion($nomCol, $tab);
	}

	public function AjouterColInsertionMax($nomCol, $inc = 0)
	{
	   	$this->AjouterColInsertionMaxExt(0, $nomCol, $nomCol, $inc);
	}

	public function AjouterColInsertionMaxExt($numJointure, $nomCol, $nomColJointure, $inc = 0)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_MAX;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomExt;
		$tab[SQLFONCTION_AS] = NULL;
		$tab[SQLFONCTION_INC] = $inc;

		$this->AjouterColInsertion($nomCol, $tab);
	}

	public function AjouterColInsertionCount($nomCol, $inc = 0)
	{
	   	$this->AjouterColInsertionCountExt(0, $nomCol, $nomCol, $inc);
	}

	public function AjouterColInsertionCountExt($numJointure, $nomCol, $nomColJointure, $inc = 0)
	{
	   	$tab = array();
		$tab[SQLFONCTION_TYPE] = SQLFONCTION_COUNT;
		$tab[SQLFONCTION_NUMJOINTURE] = $numJointure;
		$tab[SQLFONCTION_COL] = $nomColJointure;
		$tab[SQLFONCTION_AS] = NULL;
		$tab[SQLFONCTION_INC] = $inc;

		$this->AjouterColInsertion($nomCol, $tab);
	}

	public function AjouterColOrdre($nom, $ordre = NULL, $desc = false)
	{
	   	$this->AjouterColOrdrePourJointure(0, $nom, $ordre, $desc);
	}

	public function AjouterColOrdrePourJointure($numJointure, $nom, $ordre = NULL, $desc = false)
	{
	   	if ($this->bufferColOrdre === NULL)
	   	{
	   	   	$this->numOrdre = 0;
	   	   	$this->bufferColOrdre = array();
	   	}

	   	if (!array_key_exists($numJointure, $this->bufferColOrdre))
	   	   	$this->bufferColOrdre[$numJointure] = array();

	   	if ($ordre === NULL)
	   		$ordre = $this->numOrdre;
	   	else if ($ordre > $numOrdre)
	   		$this->numOrdre = $ordre;

	   	$ordreTab = array();
	   	$ordreTab[SQLORDRE_TYPE] = $desc;
	   	$ordreTab[SQLORDRE_COL] = $nom;
	   	$this->bufferColOrdre[$numJointure][$ordre] = $ordreTab;
	   	$this->numOrdre++;
	}

	public function SupprimerSurJointure($numJointure, $supprimer = NULL)
	{
	   	if (!array_key_exists($numJointure, $this->supprimerSurJointure) && $supprimer === NULL)
		   	return false;
		else if ($supprimer === NULL)
		   	return $this->supprimerSurJointure[$numJointure];

	   	$this->supprimerSurJointure[$numJointure] = $supprimer;
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
	   	$this->jointures[$numJointure][MOM_JOINTURE_NUMOBJET] = $numObjetJointure;
		$this->jointures[$numJointure][MOM_JOINTURE_TYPE] = $typeJointure;

		// On met en mémoire l'objet joint de référence (pour récupérer le nom des bases à récupérer, ...) et on vérifie que tout
		// est correcte au niveau de la définition de la liaison.
		if (array_key_exists($numObjetJointure, $this->objetsJoints))
		{
			$mObjetMetierRef = $this->objetsJoints[$numObjetJointure];
			$mObjetMetierJoint = $mObjetMetierRef->GetChampObjetNonNul($colThisJointure);
			if ($mObjetMetierJoint !== NULL)
			   	$this->objetsJoints[$numJointure] = $mObjetMetierJoint;
			else
			   	GLog::LeverException(EXM_0184, $this->GetNom().'::AjouterJointure, objet inexistant pour la colonne ['.$colThisJointure.'] de l\'objet ['.$mObjetMetierRef->GetNom().'].');
		}
		else
		   	GLog::LeverException(EXM_0185, $this->GetNom().'::AjouterJointure, objet référence ['.$numObjetJointure.'] de la jointure ['.$numJointure.'] inexistant.');

		return $numJointure;
	}

	public function GetObjetBasePourRequete($typeRequete)
	{
	   	$mObjet = $this->GetObjetMetierReference();
	   	return $mObjet->GetObjetBasePourRequete($typeRequete);
	   	/*$objetsBases = array();
	   	$objetsBases[0] = $this->GetObjetBase();
	   	$objetsBases[0]->SetNumJointure(0);

	   	if ($jointures !== NULL)
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
				   	GLog::LeverException(EXM_0184, $this->GetNom().'::AjouterJointures, les objets n\'ont pas été initialisés pour le niveau de jointure ['.$numJointure.'].');
			}
		}*/
	}

	// Renvoie un objet base préparé pour une jointure.
	/*private function GetObjetBasePourJointure($numJointure, $typeRequete)
	{
	   	//$bObjetBase = $mObjetMetierJoint->GetObjetBase();

		$bObjetBase = $mObjetMetierJoint->GetObjetBasePourJointure($typeRequete);
		$bObjetBase->SetNumJointure($numJointure);
	   	// Si on est dans le cas d'un delete multiple, alors on regarde si les lignes de la table doivent être supprimées.
	   	$bObjetBase->SupprimerSurJointure($this->SupprimerSurJointure($numJointure));

	   	/*if ($typeRequete === MOM_TYPEREQ_CHARGEMENT)
		{
		   	if ($this->bufferColSel !== NULL && array_key_exists($numJointure, $this->bufferColSel))
			{
				foreach ($this->bufferColSel[$numJointure] as $col => $as)
				{
				   	$mObjetMetierJoint->AjouterBaseColSelection($bObjetBase, $col, $as);
				}
			}

			if ($this->bufferColOrdre !== NULL && array_key_exists($numJointure, $this->bufferColOrdre))
			{
				foreach ($this->bufferColOrdre[$numJointure] as $ordre => $col)
				{
				   	$mObjetMetierJoint->AjouterBaseColOrdre($bObjetBase, $col[SQLORDRE_COL], $ordre, $col[SQLORDRE_TYPE]);
				}
			}
		}
		else if ($typeRequete === MOM_TYPEREQ_MODIFICATION)
		{
	   	  	foreach ($this->bufferColModif[$numJointure] as $col => $valeur)
			{
			   	$mObjetMetierJoint->AjouterBaseColModification($bObjetBase, $col, $valeur);
			}
		}

		$colCond = $this->GetColCond($numJointure);

		foreach ($colCond as $col => $valeur)
		{
		   	$mObjetMetierJoint->AjouterBaseColCondition($bObjetBase, $col, $valeur);
		}

		return $bObjetBase;
	}*/

	/*************************************/
	public function ExtraireListe($nomChamp)
	{
		$mListeObjetsMetiers = $this->GetObjetMetierReference()->GetChampFromTableau($nomChamp)->GetNouvelleListe();

	   	foreach ($this->liste as $element)
	   	{
			$mListeObjetsMetiers->AjouterElement($element->GetChampFromTableau($nomChamp));
		}

		return $mListeObjetsMetiers;
	}

	public function ExtraireChamp($nom)
	{
	   	$tableau = array();

	   	foreach ($this->liste as $element)
		{
	   	   	$tableau[] = $element->GetChampSQLFromTableau($nom);
	   	}

	   	return $tableau;
	}

	public function SoustraireListe($mListeObjetsMetiers, $nomChamp = COL_ID)
	{
	   	foreach ($this->liste as $num => $element)
	   	{
	   	   	if ($element !== NULL)
			{
		   	   	foreach ($mListeObjetsMetiers->GetListe() as $elementExt)
		   		{
		   		   	$suppElem = true;
		   		   	// Si on a plusieurs champs à vérifier ou un champ de jointure ou les 2.
			   	   	if (is_array($nomChamp))
			   	   	{
			   	   		foreach ($nomChamp as $nom)
			   	   		{
							if ($element->GetChampSQLFromTableau($nom) !== $elementExt->GetChampSQLFromTableau($nom))
							   	$suppElem = false;
						}
			   	   	}
			   	   	// Si on a un champ simple à vérifier.
			   	   	else if ($element->GetChampSQLFromTableau($nomChamp) !== $elementExt->GetChampSQLFromTableau($nomChamp))
						$suppElem = false;

					if ($suppElem === true)
					{
					   	unset($this->liste[$num]);
						break;
					}
				}
			}
		}
	}
}

?>