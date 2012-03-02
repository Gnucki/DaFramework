<?php

require_once 'cst.php';
require_once INC_STABLEAU;
require_once INC_SLISTENONORDONNEE;


define ('','');


class SDoubleListe extends STableau
{
    protected $listeGauche;
    protected $listeDroite;

    public function __construct($titre = '', $titreListeGauche = '', $titreListeDroite = '',
	   	   	   	  	   	   	   	$elementsListeGauche = '', $elementsListeDroite = '')
    {
       	parent::__construct();

       	if ($titre !== '')
		{
       		$this->AddLigne();
       		$cellule = $this->AddCellule();
       		$cellule->SetText($titre);
       	}

       	$this->AddLigne();
       	$cellule = $this->AddCellule();

	   	$conteneur = new SBalise(BAL_DIV);
	   	$conteneur->AddProp(PROP_CLASS, $class);
	   	$cellule->Attach($conteneur);

	   	$tabListe = new Tableau();
	   	$conteneur->Attach($tabListe);

	   	if ($titreListeGauche !== '' && $titreListeDroite !== '')
		{
	   		$tabListe->AddLigne();
	   		$cellule = $tabListe->AddCellule();
	   		$cellule->SetText($titreListeGauche);

	   		$cellule = $tabListe->AddCellule();
	   		$cellule->SetText($titreListeDroite);
	   	}

	   	$tabListe->AddLigne();
	   	$this->listeGauche = $tabListe->AddCellule();
	   	$this->listeDroite = $tabListe->AddCellule();

	   	if ($elementsListeGauche !== '' && is_array($elementsListeGauche))
	   		$this->RemplirListeGauche($elementsListeGauche);

	   	if ($elementsListeDroite !== '' && is_array($elementsListeDroite))
	   		$this->RemplirListeDroite($elementsListeDroite);
	}

	public function RemplirListeGauche($elements)
	{
	   	$liste = $this->RemplirListe($elements);
	   	$this->listeGauche->Attach($liste);
	}

	public function RemplirListeDroite($elements)
	{
	   	$liste = $this->RemplirListe($elements);
	   	$this->listeDroite->Attach($liste);
	}

	protected function RemplirListe($elements)
	{
	   	$liste = new SListeNonOrdonnee();

	   	while (list($id, $element) = each($elements))
		{
			$liste->AjouterElement($element, $id, $class, $id);
		}

	   	return $liste;
	}
}

?>