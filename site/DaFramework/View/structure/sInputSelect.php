<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SINPUT;
require_once INC_SORGANISEUR;
require_once INC_SELEMENT;


define ('INPUTSELECT', '_select');
define ('INPUTSELECT_VALEUR', '_select_valeur');
define ('INPUTSELECT_VALEUREDIT', '_select_valeuredit');
define ('INPUTSELECT_DEROULEUR', '_select_derouleur');
define ('INPUTSELECT_LISTE', '_select_liste');
define ('INPUTSELECT_LISTE_BARDEF', '_select_liste_bardef');
define ('INPUTSELECT_LISTE_BARDEF_BAS', '_select_liste_bardef_bas');
define ('INPUTSELECT_LISTE_BARDEF_HAUT', '_select_liste_bardef_haut');
define ('INPUTSELECT_LISTE_BARDEF_BARRE', '_select_liste_bardef_barre');
define ('INPUTSELECT_INFO', '_select_info');
define ('INPUTSELECT_ERREUR', '_select_erreur');
define ('INPUTSELECT_ELEMENT', '_select_element');
define ('INPUTSELECT_CATEGORIE', '_select_categorie');

define ('INPUTSELECT_JQ', 'jq_input_select');
define ('INPUTSELECT_JQ_DEROULEUR', 'jq_input_select_derouleur');
define ('INPUTSELECT_JQ_EDIT', 'jq_input_select_edit');
define ('INPUTSELECT_JQ_RETOUR', 'jq_input_select_retour');
define ('INPUTSELECT_JQ_ERREUR', 'jq_input_select_erreur');
define ('INPUTSELECT_JQ_INFO', 'jq_input_select_info');
define ('INPUTSELECT_JQ_TYPE', 'jq_input_select_type');
define ('INPUTSELECT_JQ_IMPACT', 'jq_input_select_impact');
define ('INPUTSELECT_JQ_DEPENDANCE', 'jq_input_select_dependance');
define ('INPUTSELECT_JQ_RECFONC', 'jq_input_select_rechargefonc');
define ('INPUTSELECT_JQ_RECPARAM', 'jq_input_select_rechargeparam');
define ('INPUTSELECT_JQ_CHANGEFONC', 'jq_input_select_changefonc');
define ('INPUTSELECT_JQ_CHANGEPARAM', 'jq_input_select_changeparam');
define ('INPUTSELECT_JQ_REF', 'jq_input_select_ref');
define ('INPUTSELECT_JQ_LISTE', 'jq_input_select_liste');
define ('INPUTSELECT_JQ_BARREDEFILEMENT', 'jq_input_select_bardef');
define ('INPUTSELECT_JQ_BARREDEFILEMENT_BAS', 'jq_input_select_bardef_bas');
define ('INPUTSELECT_JQ_BARREDEFILEMENT_HAUT', 'jq_input_select_bardef_haut');
define ('INPUTSELECT_JQ_BARREDEFILEMENT_BARRE', 'jq_input_select_bardef_barre');
define ('INPUTSELECT_JQ_ELEMENTS', 'jq_input_select_elements');
define ('INPUTSELECT_JQ_ELEMENT', 'jq_input_select_element');
define ('INPUTSELECT_JQ_ELEMENT_CATEGORIE', 'jq_input_select_element_categorie');
define ('INPUTSELECT_JQ_ELEMENT_ID', 'jq_input_select_element_id');
define ('INPUTSELECT_JQ_ELEMENT_LIBELLE', 'jq_input_select_element_libelle');
define ('INPUTSELECT_JQ_ELEMENT_DESCRIPTION', 'jq_input_select_element_description');
define ('INPUTSELECT_JQ_ELEMENT_DEFAUT', 'jq_input_select_element_defaut');
define ('INPUTSELECT_JQ_ELEMENT_NONFILTRE', 'jq_input_select_element_nonfiltre');
define ('INPUTSELECT_JQ_CATEGORIE', 'jq_input_select_categorie');
define ('INPUTSELECT_JQ_CATEGORIE_ID', 'jq_input_select_categorie_id');
define ('INPUTSELECT_JQ_CATEGORIE_LIBELLE', 'jq_input_select_categorie_libelle');

define ('INPUTSELECTFIND_JQ', 'jq_input_select_find');
define ('INPUTFILESELECT_JQ', 'jq_input_file_select');
define ('INPUTNEWSELECT_JQ', 'jq_input_new_select');
define ('LISTEINPUTSELECT_JQ', 'jq_liste_input_select');
define ('LISTEINPUTSELECTFIND_JQ', 'jq_liste_input_select_find');

define ('INPUTSELECT_TYPE_FICHIER', 'fichier');
define ('INPUTSELECT_TYPE_NEW', 'new');
define ('INPUTSELECT_TYPE_LISTE', 'liste');
define ('INPUTSELECT_TYPE_FIND', 'find');
define ('INPUTSELECT_TYPE_LISTEFIND', 'fliste');


// Input de type combobox.
class SInputSelect extends SBalise
{
   	protected $prefixIdClass;
   	protected $liste;
	protected $currentCategorie;
	protected $nbElemCurCat;
	protected $nbCat;
   	protected $niveau;

	public function __construct($prefixIdClass, $typeInput = '', $oblig = false, $retour = '', $info = '', $erreur = '', $type = '', $impact = '', $dependance = '', $rechargeFonc = '', $rechargeParam = '', $changeFonc = '', $changeParam = '', $niveau = '')
	{
		parent::__construct(BAL_DIV);
		GSession::PoidsJavascript(4);
		$this->currentCategorie == NULL;
		$this->nbElemCurCat = 0;
		$this->nbCat = 0;

		$this->prefixIdClass = $prefixIdClass;
		$this->niveau = $niveau;
		switch ($typeInput)
		{
			case INPUTSELECT_TYPE_FICHIER:
				$this->AddClass(INPUTFILESELECT_JQ);
				break;
			case INPUTSELECT_TYPE_NEW:
				$this->AddClass(INPUTNEWSELECT_JQ);
				break;
			case INPUTSELECT_TYPE_LISTE:
				$this->AddClass(LISTEINPUTSELECT_JQ);
				break;
			case INPUTSELECT_TYPE_LISTEFIND:
				$this->AddClass(INPUTSELECTFIND_JQ);
				$this->AddClass(LISTEINPUTSELECT_JQ);;
				break;
			case INPUTSELECT_TYPE_FIND:
				$this->AddClass(INPUTSELECTFIND_JQ);
				$this->AddClass(INPUTSELECT_JQ);
				break;
			default:
				$this->AddClass(INPUTSELECT_JQ);
		}
		$this->AddClass('jq_fill');
		if ($oblig == true)
			$this->AddClass('jq_input_form_oblig');

		$elem = new SElement($this->prefixIdClass.INPUTSELECT.$this->niveau);
		$elem->AjouterClasse(INPUTSELECT.$this->niveau);
		$this->Attach($elem);

		$org = new SOrganiseur(2, 2, true);
		$elem->Attach($org);
		$org->FusionnerCellule(2, 1, 0, 1);
		//$org->SetCelluleDominante(1, 1);
		$org->SetLargeurCellule(1, 1, '100%');
		$org->SetLargeurCellule(1, 2, '0%');

		// Edit.
		$element = new SElement($this->prefixIdClass.INPUTSELECT_VALEUR.$this->niveau);//, true, '', '', false);
		$element->AjouterClasse(INPUTSELECT_VALEUR.$this->niveau);
		$edit = new SInput('', 'text', '', $this->prefixIdClass.INPUTSELECT_VALEUREDIT.$this->niveau);
		$edit->AddClass(INPUTSELECT_VALEUREDIT.$this->niveau);
		$edit->AddClass(INPUTSELECT_JQ_EDIT);
		$element->Attach($edit);
		$org->AttacherCellule(1, 1, $element);

		// Dérouleur.
		$element = new SElement($this->prefixIdClass.INPUTSELECT_DEROULEUR.$this->niveau);
		$element->AjouterClasse(INPUTSELECT_DEROULEUR.$this->niveau);
		$element->AddClass(INPUTSELECT_JQ_DEROULEUR);
		$org->AttacherCellule(1, 2, $element);

		// Liste.
		$div = new SBalise(BAL_DIV);
		$div->AddClass(INPUTSELECT_JQ_LISTE);
		$div->AddStyle('display:none;');
		$orgListe = new SOrganiseur(1, 2, true);
		$liste = new SElement($this->prefixIdClass.INPUTSELECT_LISTE.$this->niveau);
		$liste->AjouterClasse(INPUTSELECT_LISTE.$this->niveau);
		//$liste->AddClass(INPUTSELECT_JQ_ELEMENTS);
		$divElem = new SBalise(BAL_DIV);
		$divElem->AddClass(INPUTSELECT_JQ_ELEMENTS);
		$this->liste = new STableau(true);
		$divElem->Attach($this->liste);
		//$liste->Attach($this->liste);
		$liste->Attach($divElem);
		$orgListe->AttacherCellule(1, 1, $liste);
		// Barre de défilement.
		$elemDef = new SElement($this->prefixIdClass.INPUTSELECT_LISTE_BARDEF.$this->niveau);
		$elemDef->AjouterClasse(INPUTSELECT_LISTE_BARDEF.$this->niveau);
		$elemDef->AddClass(INPUTSELECT_JQ_BARREDEFILEMENT);
		$elemDefHaut = new SElement($this->prefixIdClass.INPUTSELECT_LISTE_BARDEF_HAUT.$this->niveau);
		$elemDefHaut->AjouterClasse(INPUTSELECT_LISTE_BARDEF_HAUT.$this->niveau);
		$elemDefHaut->AddClass(INPUTSELECT_JQ_BARREDEFILEMENT_HAUT);
		$elemDef->Attach($elemDefHaut);
		$divDefBarre = new SBalise(BAL_DIV);
		$elemDefBarre = new SElement($this->prefixIdClass.INPUTSELECT_LISTE_BARDEF_BARRE.$this->niveau);
		$elemDefBarre->AjouterClasse(INPUTSELECT_LISTE_BARDEF_BARRE.$this->niveau);
		$elemDefBarre->AddClass(INPUTSELECT_JQ_BARREDEFILEMENT_BARRE);
		$divDefBarre->Attach($elemDefBarre);
		$elemDef->Attach($divDefBarre);
		$elemDefBas = new SElement($this->prefixIdClass.INPUTSELECT_LISTE_BARDEF_BAS.$this->niveau);
		$elemDefBas->AjouterClasse(INPUTSELECT_LISTE_BARDEF_BAS.$this->niveau);
		$elemDefBas->AddClass(INPUTSELECT_JQ_BARREDEFILEMENT_BAS);
		$elemDef->Attach($elemDefBas);
		$orgListe->AttacherCellule(1, 2, $elemDef);
		$div->Attach($orgListe);
		$org->AttacherCellule(2, 1, $div);

		// Retour.
		if ($retour !== '')
		{
			$divRetour = new SBalise(BAL_DIV);
			$divRetour->SetText(strval($retour));
			$divRetour->AddClass(INPUTSELECT_JQ_RETOUR);
			$divRetour->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divRetour);
		}

		// Info.
		$divInfo = new SBalise(BAL_DIV);
		$elemInfo = new SElement(CLASSCADRE_INFO, false);
		$elemInfo->SetText($info);
		$divInfo->AddClass(INPUTSELECT_JQ_INFO);
		$divInfo->Attach($elemInfo);
		$divInfo->AddProp(PROP_STYLE, 'display:none');
		$this->Attach($divInfo);

		// Erreur.
		if ($erreur !== '')
		{
			$divErreur = new SBalise(BAL_DIV);
			$elemErreur = new SElement(CLASSCADRE_ERREUR, false);
			$elemErreur->SetText($erreur);
			$divErreur->AddClass(INPUTSELECT_JQ_ERREUR);
			$divErreur->Attach($elemErreur);
			$divErreur->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divErreur);
		}

		// Type.
		if ($type !== '')
		{
			$divType = new SBalise(BAL_DIV);
			$divType->SetText(strval($type));
			$divType->AddClass(INPUTSELECT_JQ_TYPE);
			$divType->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divType);
		}

		// Impact (Noms des différents types de select (séparés par des ',')
		// qui doivent se recharger si changement de celui-ci).
		if ($impact !== '')
		{
			$divImpact = new SBalise(BAL_DIV);
			$divImpact->SetText(to_html($impact));
			$divImpact->AddClass(INPUTSELECT_JQ_IMPACT);
			$divImpact->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divImpact);
		}

		// Dépendance (Noms des différents types de select (séparés par des ',')
		// dont la valeur est importante pour le rechargement de ce select).
		if ($dependance !== '')
		{
			$divDep = new SBalise(BAL_DIV);
			$divDep->SetText(to_html($dependance));
			$divDep->AddClass(INPUTSELECT_JQ_DEPENDANCE);
			$divDep->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divDep);
		}

		// RechargeFonc (Nom de la fonction Ajax de rechargement de la combobox).
		if ($rechargeFonc !== '')
		{
			$divRecFonc = new SBalise(BAL_DIV);
			$divRecFonc->SetText(strval($rechargeFonc));
			$divRecFonc->AddClass(INPUTSELECT_JQ_RECFONC);
			$divRecFonc->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divRecFonc);
		}

		// RechargeParam (Paramètres de la fonction Ajax de rechargement de la combobox).
		if ($rechargeParam !== '')
		{
			$divRecParam = new SBalise(BAL_DIV);
			$divRecParam->SetText(to_ajax($rechargeParam));
			$divRecParam->AddClass(INPUTSELECT_JQ_RECPARAM);
			$divRecParam->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divRecParam);
		}

		// ChangeFonc (Nom de la fonction Ajax qui est appelée quand la valeur de la combobox change).
		if ($changeFonc !== '')
		{
			$divChangeFonc = new SBalise(BAL_DIV);
			$divChangeFonc->SetText(strval($changeFonc));
			$divChangeFonc->AddClass(INPUTSELECT_JQ_CHANGEFONC);
			$divChangeFonc->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divChangeFonc);
		}

		// RechargeParam (Paramètres de la fonction Ajax qui est appelée quand la valeur de la combobox change).
		if ($changeParam !== '')
		{
			$divChangeParam = new SBalise(BAL_DIV);
			$divChangeParam->SetText(to_ajax($changeParam));
			$divChangeParam->AddClass(INPUTSELECT_JQ_CHANGEPARAM);
			$divChangeParam->AddProp(PROP_STYLE, 'display:none');
			$this->Attach($divChangeParam);
		}
	}

	public function AjouterCategorie($id, $libelle)
	{
		if ($this->nbElemCurCat == 0 && $this->currentCategorie != NULL)
			$this->AjouterElement('', '');
		if ($libelle != '')
		{
		   	if ($id == '')
		   	   	$id = $this->nbCat;
		   	$this->nbCat++;
			$this->nbElemCurCat = 0;
			$this->liste->AddLigne();
			$cellule = $this->liste->AddCellule();
			$cellule->AddClass(INPUTSELECT_JQ_CATEGORIE);

			$elemLibelle = new SElement($this->prefixIdClass.INPUTSELECT_CATEGORIE.$this->niveau);
			$elemLibelle->AjouterClasse(INPUTSELECT_CATEGORIE.$this->niveau);
			$elemLibelle->AddClass(INPUTSELECT_JQ_CATEGORIE_LIBELLE);
			$elemLibelle->SetText($libelle);
			$cellule->Attach($elemLibelle);

			$divId = new SBalise(BAL_DIV);
			$divId->AddProp(PROP_CLASS, INPUTSELECT_JQ_CATEGORIE_ID);
			$divId->SetText(strval($id));
			$cellule->Attach($divId);

			$this->currentCategorie = $id;
		}
	}

	public function AjouterElement($id, $libelle, $description = '', $valParDefaut = false, $elementFiltre = true)
	{
		//if ($id != '' && $libelle != '')
		//{
		   	GSession::PoidsJavascript(1);
			$this->nbElemCurCat++;

			$this->liste->AddLigne();
			$cellule = $this->liste->AddCellule();
			$cellule->AddClass(INPUTSELECT_JQ_ELEMENT);
			if ($valParDefaut === true)
				$cellule->AddClass(INPUTSELECT_JQ_ELEMENT_DEFAUT);

			$divId = new SBalise(BAL_DIV);
			$divId->AddProp(PROP_CLASS, INPUTSELECT_JQ_ELEMENT_ID);
			$divId->SetText(strval($id));
			$cellule->Attach($divId);

			$elemLibelle = new SElement($this->prefixIdClass.INPUTSELECT_ELEMENT.$this->niveau);
			$elemLibelle->AjouterClasse(INPUTSELECT_ELEMENT.$this->niveau);
			$elemLibelle->AddClass(INPUTSELECT_JQ_ELEMENT_LIBELLE);
			if ($elementFiltre !== true)
				$elemLibelle->AddClass(INPUTSELECT_JQ_ELEMENT_NONFILTRE);
			$elemLibelle->SetText($libelle);
			$cellule->Attach($elemLibelle);

			if ($description !== NULL && $description !== '')
			{
				$divDescription = new SBalise(BAL_DIV);
				$divDescription->AddProp(PROP_CLASS, INPUTSELECT_JQ_ELEMENT_DESCRIPTION);
				if (is_string($description))
				   	$divDescription->SetText($description);
				else
				   	$divDescription->Attach($description);
				$cellule->Attach($divDescription);
			}

			if ($this->currentCategorie != NULL)
			{
				$divCategorie = new SBalise(BAL_DIV);
				$divCategorie->AddProp(PROP_CLASS, INPUTSELECT_JQ_ELEMENT_CATEGORIE);
				$divCategorie->SetText(strval($this->currentCategorie));
				$divCategorie->AddStyle('display:none;');
				$cellule->Attach($divCategorie);
			}
		//}
	}

	public function AjouterElementsFromListe($nomRef, $colId = COL_ID, $colLibelle = array(COL_LIBELLE, COL_LIBELLE), $colDescription = '', $idParDefaut = NULL)
	{
	   	foreach (GReferentiel::GetReferentiel($nomRef) as $mObjet)
		{
		   	$valParDefaut = false;
		   	$id = $mObjet->GetChampSQLFromTableau($colId);
		   	if ($idParDefaut !== NULL && $id == $idParDefaut)
		   		$valParDefaut = true;
		   	if ($colDescription !== '')
		   	   	$this->AjouterElement($id, $mObjet->GetChampSQLFromTableau($colLibelle), $mObjet->GetChampSQLFromTableau($colDescription), $valParDefaut);
		   	else
		   	   	$this->AjouterElement($id, $mObjet->GetChampSQLFromTableau($colLibelle), '', $valParDefaut);
		}

		$this->AjouterReference($nomRef);
	}

	public function AjouterReference($nomRef)
	{
	   	// Référentiel.
		$divRef = new SBalise(BAL_DIV);
		$divRef->SetText($nomRef);
		$divRef->AddClass(INPUTSELECT_JQ_REF);
		$divRef->AddProp(PROP_STYLE, 'display:none');
		$this->Attach($divRef);
	}

	public function BuildHTML()
	{
		if ($this->nbElemCurCat == 0)
			$this->AjouterElement('', '');

		return parent::BuildHTML();
	}
}