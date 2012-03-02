<?php

require_once 'cst.php';
require_once INC_SELEMORG;


define ('SCADRE', '_scadre');
define ('SCADRE_TITRE', '_scadre_titre');
define ('SCADRE_CONTENU', '_scadre_contenu');


class SCadre extends SElemOrg
{
   	protected $cadreTitre;
   	protected $cadreContenu;
   	protected $centrer;

    public function __construct($prefixIdClass = '', $titre = '', $contenu = NULL, $tabMaxLargeur = false, $centrer = false, $equiCellules = false, $remplirParent = true)
    {
       	parent::__construct(2, 1, $prefixIdClass.SCADRE, $tabMaxLargeur, $equiCellules, $remplirParent);
       	$this->AjouterClasse(SCADRE);

       	$this->cadreTitre = new SElement($prefixIdClass.SCADRE_TITRE);
       	$this->cadreTitre->AjouterClasse(SCADRE_TITRE);
       	$this->AttacherCellule(1, 1, $this->cadreTitre);

       	$this->cadreContenu = new SElement($prefixIdClass.SCADRE_CONTENU);
       	$this->cadreContenu->AjouterClasse(SCADRE_CONTENU);
       	$this->AttacherCellule(2, 1, $this->cadreContenu);

		$this->centrer = $centrer;

       	if ($titre !== '')
       		$this->AjouterTitre($titre);

       	if ($contenu !== NULL)
       		$this->AjouterContenu($contenu);
	}

	public function AjouterTitre($titre)
	{
	   	if (is_string($titre) || is_int($titre))
	   		$this->cadreTitre->SetText($titre);
	   	else
	   	   	$this->cadreTitre->Attach($titre);
	}

	public function AjouterContenu($contenu)
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
	}
}

?>