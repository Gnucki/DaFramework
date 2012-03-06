<?php

require_once 'cst.php';
require_once INC_GLOG;
require_once PATH_METIER.'mListeObjetsMetiers.php';


define ('REF_TYPE_FICHIERS', 'fichier');
define ('REF_TYPE_DONNEES', 'donnees');

define ('REF_DONNEES_LISTE', 'liste');
define ('REF_DONNEES_CHARGEES', 'chargees');
define ('REF_DONNEES_COLSASAUVEGARDER', 'sauv');
define ('REF_DONNEES_DIFFSELOK', 'diffselok');
define ('REF_FICHIERS_CHEMIN', 'chemin');
define ('REF_FICHIERS_EXTENSIONS', 'ext');
define ('REF_FICHIERS_IMAGES', 'img');
define ('REF_FICHIERS_NOMS', 'noms');
define ('REF_FICHIERS_SAUVEGARDER', 'sauv');
define ('REF_FICHIERS_DIFFSELOK', 'diffselok');

define ('REF_FICHIERSEXTENSIONS_IMAGES', 'bmp,jpg,jpeg,png,gif');

define ('REF_CONTEXTE_AUCUN', '0-0');


class GReferentiel
{
 	private static $initialise;
   	private static $referentiels;

   	public static function Initialiser()
   	{
	   	if (self::$initialise !== true)
	   	{
	   	   	self::$referentiels = array();
	   	   	self::$referentiels[REF_TYPE_FICHIERS] = array();
	   	   	self::$referentiels[REF_TYPE_DONNEES] = array();
	   	   	self::$initialise = true;
	   	}
	}

	public static function Sauvegarder()
	{
	   	foreach (self::$referentiels[REF_TYPE_FICHIERS] as $contexte => $referentielsContexte)
		{
		   	foreach ($referentielsContexte as $nom => $referentiel)
			{
		   	 	if ($referentiel[REF_FICHIERS_SAUVEGARDER] === true && $referentiel[REF_FICHIERS_NOMS] !== NULL)
				{
		   	 		if ($contexte !== REF_CONTEXTE_AUCUN)
					   	GContexte::Referentiel($contexte, $nom, REF_TYPE_FICHIERS, $referentiel[REF_FICHIERS_NOMS]);
					else
					   	GSession::Referentiel($nom, REF_TYPE_FICHIERS, $referentiel[REF_FICHIERS_NOMS]);
		   	 	}
		   	}
	   	}

	   	foreach (self::$referentiels[REF_TYPE_DONNEES] as $contexte => $referentielsContexte)
		{
		   	foreach ($referentielsContexte as $nom => $referentiel)
			{
		   	 	if ($referentiel[REF_DONNEES_COLSASAUVEGARDER] !== NULL && $referentiel[REF_DONNEES_CHARGEES] === true)
				{
				   	$refSauve = array();

	   	 		   	$nbRefSauves = 0;
				    foreach ($referentiel[REF_DONNEES_LISTE]->GetListe() as $mObjet)
		   	 		{
		   	 		   	$refSauve[$nbRefSauves] = array();
		   	 		   	foreach ($referentiel[REF_DONNEES_COLSASAUVEGARDER] as $nomCol)
	   	 		   		{
	   	 		   		   	$nomColSauvee = '';
							if (is_array($nomCol))
							{
								foreach ($nomCol as $nomColUnite)
								{
								   	if ($nomColSauvee !== '')
								   	   	$nomColSauvee .= ',';
								   	$nomColSauvee .= $nomColUnite;
								}
							}
							else
							   	$nomColSauvee = $nomCol;

	   	 		   		   	$refSauve[$nbRefSauves][$nomColSauvee] = $mObjet->GetChampSQLFromTableau($nomCol);
	   	 		   		}
	   	 		   		$nbRefSauves++;
					}

					if ($contexte !== REF_CONTEXTE_AUCUN)
					   	GContexte::Referentiel($contexte, $nom, REF_TYPE_DONNEES, $refSauve);
					else
					   	GSession::Referentiel($nom, REF_TYPE_DONNEES, $refSauve);
		   	 	}
		   	}
	   	}
	}

	public static function NomReferentielGeneral($nom)
	{
	   	$nomRef = $nom;
	   	$posT = strpos($nomRef, '-');
	   	$posU = strpos($nomRef, '_');

	   	if ($posT !== false || $posU !== false)
	   	{
			if ($posT === false)
				$nomRef = substr($nomRef, 0, $posU);
			else if ($posU === false)
			   	$nomRef = substr($nomRef, 0, $posT);
			else if ($posT <= $posU)
			   	$nomRef = substr($nomRef, 0, $posT);
			else
			   	$nomRef = substr($nomRef, 0, $posU);
		}

		return $nomRef;
	}

	public static function ContexteCourant()
	{
	   	$contexte = GContexte::ContexteCourant();
	   	if ($contexte == NULL)
	   		$contexte === REF_CONTEXTE_AUCUN;
	   	return $contexte;
	}

   	public static function AjouterReferentiel($nom, MListeObjetsMetiers $mListe, $sauveCols = NULL, $dejaCharge = false, $fromAncienRef = false)
   	{
	   	self::Initialiser();

	   	$nomRef = '';
		if (is_array($nom))
		{
			foreach ($nom as $nomCol)
			{
			   	if ($nomRef !== '')
			   	   	$nomRef .= ',';
			   	$nomRef .= $nomCol;
			}
		}
		else
		   	$nomRef = $nom;

		$contexte = self::ContexteCourant();
		if (!array_key_exists($contexte, self::$referentiels[REF_TYPE_DONNEES]))
			self::$referentiels[REF_TYPE_DONNEES][$contexte] = array();
	   	if (!array_key_exists($nomRef, self::$referentiels[REF_TYPE_DONNEES][$contexte]))
		{
			$referentiel = array();
			if ($fromAncienRef === true)
			{
				$ancienRef = NULL;
			   	if ($contexte !== REF_CONTEXTE_AUCUN)
			   	   	$ancienRef = GContexte::Referentiel($contexte, $nomRef, REF_TYPE_DONNEES);
			   	else
			   	   	$ancienRef = GSession::Referentiel($nomRef, REF_TYPE_DONNEES);
			   	if ($ancienRef === NULL)
			   		$ancienRef = array();

			   	foreach ($ancienRef as $ancienneValeur)
			   	{
				   	$mListe->AjouterElementFromTableau($ancienneValeur);
				}

				$dejaCharge = true;
			}
			$referentiel[REF_DONNEES_LISTE] = $mListe;
			$referentiel[REF_DONNEES_CHARGEES] = $dejaCharge;
			$referentiel[REF_DONNEES_COLSASAUVEGARDER] = $sauveCols;
			$referentiel[REF_DONNEES_DIFFSELOK] = false;

			self::$referentiels[REF_TYPE_DONNEES][$contexte][$nomRef] = $referentiel;
		}
	}

	public static function GetReferentiel($nom)
	{
	   	$nomRef = '';
		if (is_array($nom))
		{
			foreach ($nom as $nomCol)
			{
			   	if ($nomRef !== '')
			   	   	$nomRef .= ',';
			   	$nomRef .= $nomCol;
			}
		}
		else
		   	$nomRef = $nom;

		$contexte = self::ContexteCourant();
	   	if (!array_key_exists($contexte, self::$referentiels[REF_TYPE_DONNEES]) || !array_key_exists($nomRef, self::$referentiels[REF_TYPE_DONNEES][$contexte]))
		   	 GLog::LeverException(EXG_0120, 'GReferentiel::GetReferentiel, le référentiel ['.$nomRef.'] n\'existe pas pour le contexte ['.$contexte.'].');
		else
		{
		   	$referentiel = &self::$referentiels[REF_TYPE_DONNEES][$contexte][$nomRef];
		   	if ($referentiel[REF_DONNEES_CHARGEES] === false)
		   	{
			   	$referentiel[REF_DONNEES_LISTE]->Charger();
			   	$referentiel[REF_DONNEES_CHARGEES] = true;
			}
			$ref = $referentiel[REF_DONNEES_LISTE]->GetListe();
			return $ref;
		}

		return array();
	}

	public static function GetDifferentielReferentielForSelect($nom, $colId, $colLib, $colDesc = '', $idParDefaut = NULL, $colCat = '', $colCatLib = '')
	{
	   	$nomRef = '';
		if (is_array($nom))
		{
			foreach ($nom as $nomCol)
			{
			   	if ($nomRef !== '')
			   	   	$nomRef .= ',';
			   	$nomRef .= $nomCol;
			}
		}
		else
		   	$nomRef = $nom;

		$contexte = self::ContexteCourant();
		if (self::$referentiels[REF_TYPE_DONNEES][$contexte][$nomRef][REF_DONNEES_DIFFSELOK] === false)
		{
		   	$changementRef = false;
		   	self::$referentiels[REF_TYPE_DONNEES][$contexte][$nomRef][REF_DONNEES_DIFFSELOK] = true;
		   	$nouveauRef = self::GetReferentiel($nomRef);
		   	$ancienRef = NULL;
		   	$anciennesCat = array();
		   	$nouvellesCat = array();
		   	if ($contexte !== REF_CONTEXTE_AUCUN)
		   	   	$ancienRef = GContexte::Referentiel($contexte, $nomRef, REF_TYPE_DONNEES);
		   	else
		   	   	$ancienRef = GSession::Referentiel($nomRef, REF_TYPE_DONNEES);
		   	if ($ancienRef === NULL)
		   		$ancienRef = array();
			else
			{
			   	foreach ($ancienRef as &$ancienneValeur)
				{
					if ($colCat !== '' && $colCatLib !== '')
						$anciennesCat[] = $ancienneValeur[$colCat];
				}

			   	foreach ($nouveauRef as &$mObjet)
			   	{
			   	   	if ($colCat !== '' && $colCatLib !== '')
			   	   	   	$nouvellesCat[$mObjet->GetChampSQLFromTableau($colCat)] = 1;
				    foreach ($ancienRef as &$ancienneValeur)
					{
					   	if ($ancienneValeur !== NULL && $mObjet !== NULL)
						{
						   	$identique = true;
						   	foreach ($ancienneValeur as $nomCol => $valCol)
							{
						    	if ($mObjet->GetChampSQLFromTableau(explode(',', $nomCol)) !== $valCol)
						    		$identique = false;
						    }
						    if ($identique === true)
							{
							   	if ($idParDefaut != NULL && $mObjet->GetChampSQLFromTableau($colId) == $idParDefaut)
								{
								   	if ($changementRef === false)
									{
								   	 	GReponse::AjouterElementSelect($nomRef);
								   	 	$changementRef = true;
								   	}
								   	GReponse::AjouterElementSelectSelection($idParDefaut);
							   	}
						    	$ancienneValeur = NULL;
						    	$mObjet = NULL;
						    	break;
						    }
						}
				    }
				}
			}

			$categorieCree = array();
			foreach ($nouveauRef as &$mObjet)
			{
			   	if ($mObjet !== NULL)
				{
				   	if ($changementRef === false)
					{
				   	 	GReponse::AjouterElementSelect($nomRef);
				   	 	$changementRef = true;
				   	}

					$activer = false;
					$id = $mObjet->GetChampSQLFromTableau($colId);
					if ($idParDefaut !== NULL && $id == $idParDefaut)
					   	$activer = true;
					$categorie = '';
					if ($colCat !== '')
					{
						$categorie = $mObjet->GetChampSQLFromTableau($colCat);
						if ($colCatLib !== '' && !array_key_exists($categorie, $categorieCree))
						{
						  	GReponse::AjouterElementSelectCreationCategorie($categorie, $mObjet->GetChampSQLFromTableau($colCatLib));
							$categorieCree[$categorie] = 1;
						}
					}
					$description = '';
				 	if ($colDesc !== '')
				 	   	$description = $mObjet->GetChampSQLFromTableau($colDesc);

					GReponse::AjouterElementSelectCreation($id, $mObjet->GetChampSQLFromTableau($colLib), $description, $activer, $categorie);
				}
			}

			foreach ($ancienRef as &$ancienneValeur)
			{
			   	if ($ancienneValeur !== NULL)
				{
				   	if ($changementRef === false && $ancienneValeur !== NULL)
					{
				   	 	GReponse::AjouterElementSelect($nomRef);
				   	 	$changementRef = true;
				   	}

				   	GReponse::AjouterElementSelectSuppression($ancienneValeur[$colId]);
				   	//if ($colCat !== '' && $colCatLib !== '')
					//   $anciennesCat[] = $ancienneValeur[$colCat];
				}
			}

			foreach ($anciennesCat as $categorie)
			{
			   	if ($changementRef === false)
				{
				   	GReponse::AjouterElementSelect($nomRef);
				   	$changementRef = true;
				}

			   	if (!array_key_exists($categorie, $nouvellesCat))
			   		GReponse::AjouterElementSelectSuppressionCategorie($categorie);
			}
		}
	}

	public static function AjouterReferentielFichiers($nom, $chemin, $extensions, $sauvegarder = true)
	{
	   	self::Initialiser();

	   	$contexte = self::ContexteCourant();
		if (!array_key_exists($contexte, self::$referentiels[REF_TYPE_FICHIERS]))
			self::$referentiels[REF_TYPE_FICHIERS][$contexte] = array();
	   	if (!array_key_exists($nom, self::$referentiels[REF_TYPE_FICHIERS][$contexte]))
		{
			$referentiel = array();
		   	$referentiel[REF_FICHIERS_CHEMIN] = $chemin;
		   	$referentiel[REF_FICHIERS_EXTENSIONS] = self::SetExtensionsDesirees($extensions);
			$referentiel[REF_FICHIERS_IMAGES] = false;
			if ($extensions === REF_FICHIERSEXTENSIONS_IMAGES)
				$referentiel[REF_FICHIERS_IMAGES] = true;
		   	$referentiel[REF_FICHIERS_NOMS] = NULL;
		   	$referentiel[REF_FICHIERS_SAUVEGARDER] = $sauvegarder;
		   	$referentiel[REF_FICHIERS_DIFFSELOK] = false;

		   	self::$referentiels[REF_TYPE_FICHIERS][$contexte][$nom] = $referentiel;
		}
	}

	public static function GetReferentielFichiers($nom)
	{
	   	$ref = array();

	   	$contexte = self::ContexteCourant();
	   	if (!array_key_exists($contexte, self::$referentiels[REF_TYPE_FICHIERS]) || !array_key_exists($nom, self::$referentiels[REF_TYPE_FICHIERS][$contexte]))
		   	 GLog::LeverException(EXG_0121, 'GReferentiel::GetReferentielFichiers, le référentiel ['.$nom.'] n\'existe pas pour le contexte ['.$contexte.'].');
		else
		{
		   	$referentiel = &self::$referentiels[REF_TYPE_FICHIERS][$contexte][$nom];
		   	if ($referentiel[REF_FICHIERS_NOMS] === NULL)
			   	self::ChargerNomsFichiers($referentiel);

			$ref = $referentiel[REF_FICHIERS_NOMS];
		}

		return $ref;
	}

	public static function GetCheminReferentielFichiers($nom)
	{
	   	$chemin = '';

	   	$contexte = self::ContexteCourant();
	   	if (!array_key_exists($contexte, self::$referentiels[REF_TYPE_FICHIERS]) || !array_key_exists($nom, self::$referentiels[REF_TYPE_FICHIERS][$contexte]))
		   	 GLog::LeverException(EXG_0122, 'GReferentiel::GetCheminReferentielFichiers, le référentiel ['.$nom.'] n\'existe pas pour le contexte ['.$contexte.'].');
	   	else
		   	$chemin = self::$referentiels[REF_TYPE_FICHIERS][$contexte][$nom][REF_FICHIERS_CHEMIN];

		return $chemin;
	}

	private static function ChargerNomsFichiers(&$referentiel)
	{
	   	$chemin = PATH_SERVER_LOCAL.$referentiel[REF_FICHIERS_CHEMIN];
	   	$extensions = $referentiel[REF_FICHIERS_EXTENSIONS];
	   	$images = $referentiel[REF_FICHIERS_IMAGES];
	   	$fichiers = array();

	   	$repertoire = opendir($chemin);
		while ($fichier = readdir($repertoire))
		{
		    if ($fichier !== '.' && $fichier != '..')
		    {
			    $posExt = strrpos($fichier, '.');
			    if ($posExt !== false)
				{
			    	$ext = substr($fichier, $posExt + 1);
					foreach ($extensions as $extension)
					{
			    		if ($ext === $extension || $extension === '' || $extension === '*')
			    		{
			    		   	// Protection CSRF.
			    		   	if (($images === true && getimagesize($chemin.$fichier) !== false) || $images === false)
			    		   	{
								$fichiers[] = $fichier;
				    			break;
			    		   	}
			    		}
			    	}
			    }
			}
		}
		closedir($repertoire);

		$referentiel[REF_FICHIERS_NOMS] = $fichiers;
	}

	public static function GetDifferentielReferentielFichiersForSelect($nom)
	{
	   	$contexte = self::ContexteCourant();
	   	if (self::$referentiels[REF_TYPE_FICHIERS][$contexte][$nom][REF_FICHIERS_DIFFSELOK] === false)
		{
		   	self::$referentiels[REF_TYPE_FICHIERS][$contexte][$nom][REF_FICHIERS_DIFFSELOK] = true;
		   	$nouveauRef = self::GetReferentielFichiers($nom);
		   	$ancienRef = NULL;
		   	if ($contexte !== REF_CONTEXTE_AUCUN)
		   	   	$ancienRef = GContexte::Referentiel($contexte, $nom, REF_TYPE_FICHIERS);
		   	else
		   	   	$ancienRef = GSession::Referentiel($nom, REF_TYPE_FICHIERS);
		   	if ($ancienRef === NULL)
		   		$ancienRef = array();

		   	foreach ($nouveauRef as &$fichier)
		   	{
			    foreach ($ancienRef as &$ancienFichier)
				{
			    	if ($ancienFichier === $fichier)
					{
			    		$ancienFichier = NULL;
			    		$fichier = NULL;
			    		break;
			    	}
			    }
			}

			$changementRef = false;
			$chemin = self::GetCheminReferentielFichiers($nom);
			foreach ($nouveauRef as &$fichier)
			{
			   	if ($fichier !== NULL)
				{
				   	if ($changementRef === false)
					{
				   	 	GReponse::AjouterElementSelect($nom);
				   	 	$changementRef = true;
				   	}

					GReponse::AjouterElementSelectCreation($chemin.$fichier, $fichier, PATH_SERVER_HTTP.$chemin.$fichier);
				}
			}

			foreach ($ancienRef as &$ancienFichier)
			{
			   	if ($ancienFichier !== NULL)
				{
				   	if ($changementRef === false && $ancienFichier !== NULL)
					{
				   	 	GReponse::AjouterElementSelect($nom);
				   	 	$changementRef = true;
				   	}

				   	GReponse::AjouterElementSelectSuppression($chemin.$ancienFichier);
				}
			}
		}
	}

	private static function SetExtensionsDesirees($extensions)
	{
	   	$extensionsTab = $extensions;
		if (!is_array($extensions))
			$extensionsTab = explode(',', $extensions);
		return $extensionsTab;
	}
}

?>