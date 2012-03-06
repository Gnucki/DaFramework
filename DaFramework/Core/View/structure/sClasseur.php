<?php

require_once 'cst.php';
require_once INC_SELEMORG;


define ('CLASSEUR', '_classeur');
define ('CLASSEUR_ONGLETS', '_classeur_onglets');
define ('CLASSEUR_ONGLET', '_classeur_onglet');
define ('CLASSEUR_CONTENU', '_classeur_contenu');

define ('CLASSEUR_JQ', 'jq_classeur');
define ('CLASSEUR_JQ_ID', 'jq_classeur_id');
define ('CLASSEUR_JQ_ONGLETS', 'jq_classeur_onglets');
define ('CLASSEUR_JQ_ONGLETMODELE', 'jq_classeur_ongletmodele');
define ('CLASSEUR_JQ_CONTENU', 'jq_classeur_contenu');


class SClasseur extends SElemOrg
{
   	protected $cadreOnglets;
   	protected $cadreContenu;
   	protected $centrer;

    public function __construct($prefixIdClass, $id/*, $contenu = NULL*/, $tabMaxLargeur = true, $centrer = false, $equiCellules = false, $remplirParent = true)
    {
       	parent::__construct(2, 1, $prefixIdClass.CLASSEUR, $tabMaxLargeur, $equiCellules, $remplirParent);
       	$this->AjouterClasse(CLASSEUR);
       	$this->AddClass(CLASSEUR_JQ);

       	$this->cadreOnglets = new SElemOrg(1, 1, $prefixIdClass.CLASSEUR_ONGLETS, false, false, false);
       	$this->cadreOnglets->AjouterClasse(CLASSEUR_ONGLETS);
       	$this->cadreOnglets->AddClass(CLASSEUR_JQ_ONGLETS);
       	$this->cadreOnglets->AjouterClasseCellule(1, 1, CLASSEUR_JQ_ONGLETMODELE);
       	$onglet = new SElement($prefixIdClass.CLASSEUR_ONGLET, false);
       	$onglet->AjouterClasse(CLASSEUR_ONGLET);
       	$this->cadreOnglets->AttacherCellule(1, 1, $onglet);
       	$this->AttacherCellule(1, 1, $this->cadreOnglets);

       	$this->cadreContenu = new SElement($prefixIdClass.CLASSEUR_CONTENU);
       	$this->cadreContenu->AjouterClasse(CLASSEUR_CONTENU);
       	$this->cadreContenu->AddClass(CLASSEUR_JQ_CONTENU);
       	$this->AttacherCellule(2, 1, $this->cadreContenu);

       	$divId = new SBalise(BAL_DIV);
       	$divId->AddClass(CLASSEUR_JQ_ID);
       	$divId->SetText(strval($id));
       	$this->Attach($divId);

		$this->centrer = $centrer;

       	//if ($contenu !== NULL)
       	//	$this->AjouterContenu($contenu);
	}

	/*public function AjouterContenu($contenu)
	{
	   	if ($this->centrer === true)
		{
	   		$org = new SOrganiseur(1, 3, true);
	   		$org->AjouterPropCellule(1, 1, PROP_WIDTH, '50%');
	   		$org->AttacherCellule(1, 2, $contenu);
	   		$org->AjouterPropCellule(1, 3, PROP_WIDTH, '50%');
	   		$this->cadreContenu->Attach($org);
	   	}
	   	else
	   	   	$this->cadreContenu->Attach($contenu);
	}*/
}

?>