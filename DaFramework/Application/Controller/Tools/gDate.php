<?php

// A METTRE DANS cst.php: LANGUE_FRANCAISE, LANGUE_ANGLAISE, DATEFORMAT_FORUM.
require_once 'cst.php';
require_once INC_GSESSION;


define ('ENTIER',1);
define ('ABREGE',2);

define ('DATE_NOW','date_now');
define ('DATE_SQL','date_sql');

define ('DATEFORMAT_SQL', 'dateformat_sql');
define ('DATEFORMAT_FORUM', 'dateformat_forum');

define ('FH_SQL','fh_sql');			// Fuseau horaire du serveur SQL.
define ('FH_SERVEUR','fh_serveur'); // Fuseau horaire du serveur PHP.
define ('FH_CLIENT','fh_client');	// Fuseau horaire du client.


class GDate
{
	private $annee;
	private $mois;
	private $jour;
	private $jourSemaine;
	private $heures;
	private $minutes;
	private $secondes;
	private $langue;
	private $now;
	private $valide;
	// Fuseaux en entrée et en sortie.
	private $fuseauEntree;
	private $fuseauSortie;

	public function __construct($date = '', $fuseauEntree = FH_SERVEUR, $fuseauSortie = FH_SQL)
	{
		// Maintenant.
		if ($date == DATE_NOW)
		{
			$this->valide = true;
			$this->now = true;
		}
		else
		{
			$this->valide = false;
			$this->now = false;
			$this->ResetDate();
			if ($this->ParserDate($date))
			   	$this->VerifierDate();
		}

		$this->langue = GSession::Langue(COL_ID);
		$this->FuseauEntree($fuseauEntree);
		$this->FuseauSortie($fuseauSortie);
	}

	public function ResetDate()
	{
		$this->Annee(0);
		$this->Mois(0);
		$this->Jour(0);
		$this->JourSemaine(0);
		$this->Heures(0);
		$this->Minutes(0);
		$this->Secondes(0);
	}

	private function ParserDate($date)
	{
		// Format $datetime: AAAA-MM-JJ HH:MM:SS où AAAA-MM-JJ si on n'a besoin que de la date.
		if (preg_match("/^[1-2][0-9]{3}\-[0-1][0-9]\-[0-3][0-9]( [0-5][0-9]:[0-5][0-9]:[0-5][0-9]){0,1}( [1-7]){0,1}$/", $date) != false)
		{
			$this->Annee(substr($date, 0, 4));
			$this->Mois(substr($date, 5, 2));
			$this->Jour(substr($date, 8, 2));

			$heures = substr($date, 11, 2);
			if ($heures !== '')
				$this->Heures($heures);

			$minutes = substr($date, 14, 2);
			if ($minutes !== '')
				$this->Minutes($minutes);

			$secondes = substr($date, 17, 2);
			if ($secondes !== '')
				$this->Secondes($secondes);

			$jourSemaine = substr($date, 20, 2);
			if ($jourSemaine !== '')
				$this->JourSemaine($jourSemaine);

			return true;
		}
		else if ($date !== '')
			GLog::LeverException(EXG_0040, 'GDate::ParserDate, format de date invalide ['.$date.'].');

		return false;
	}

	private function VerifierDate()
	{
		$timeStamp = mktime($this->heures, $this->minutes, $this->secondes, $this->mois, $this->jour, $this->annee);
		if ($timeStamp !== false && $timeStamp !== -1)
		{
			$this->ParserDate(date('Y-m-d H:i:s N', $timeStamp));
			$this->valide = true;
		}
		else
			GLog::LeverException(EXG_0041, 'GDate::VerifierDate, valeurs de date invalides ['.$this->Annee().'-'.$this->Mois().'-'.$this->Jour().' '.$this->Heures().':'.$this->Minutes().':'.$this->Secondes().'].');
	}

	public function SetDateTemps($annee, $mois, $jour, $heures = 0, $minutes = 0, $secondes = 0)
	{
		$this->Annee($annee);
		$this->Mois($mois);
		$this->Jour($jour);
		$this->Heures($heures);
		$this->Minutes($minutes);
		$this->Secondes($secondes);
		$this->VerifierDate();
	}

	public function SetDate($annee, $mois, $jour)
	{
		$this->Annee($annee);
		$this->Mois($mois);
		$this->Jour($jour);
		$this->VerifierDate();
	}

	public function SetTemps($heures, $minutes = 0, $secondes = 0)
	{
		$this->Heures($heures);
		$this->Minutes($minutes);
		$this->Secondes($secondes);
		$this->VerifierDate();
	}

	/***********************************************/
	public function FuseauEntree($fuseauEntree = NULL)
	{
		if ($fuseauEntree != NULL)
			$this->fuseauEntree = $this->FuseauHoraire($fuseauEntree);
		return $this->fuseauEntree;
	}

	public function FuseauSortie($fuseauSortie = NULL)
	{
		if ($fuseauSortie != NULL)
			$this->fuseauSortie = $this->FuseauHoraire($fuseauSortie);
		return $this->fuseauSortie;
	}

	private function FuseauHoraire($fuseau)
	{
		switch ($fuseau)
		{
			case FH_SQL:
				return UTC_SQL;
			case FH_SERVEUR:
				return UTC_SERVEUR;
			case FH_CLIENT:
				return GSession::LireSession('joueurFuseauHoraire');
			default:
				return 'UTC';
		}
	}

	public function Annee($annee = NULL)
	{
		if ($annee != NULL)
			$this->annee = intval($annee);
		return $this->annee;
	}

	public function Mois($mois = NULL)
	{
		if ($mois != NULL)
			$this->mois = intval($mois);
		return $this->mois;
	}

	public function Jour($jour = NULL)
	{
		if ($jour != NULL)
			$this->jour = intval($jour);
		return $this->jour;
	}

	public function JourSemaine($jourSemaine = NULL)
	{
		if ($jourSemaine != NULL)
			$this->jourSemaine = intval($jourSemaine);
		return $this->jourSemaine;
	}

	public function Heures($heures = NULL)
	{
		if ($heures != NULL)
			$this->heures = intval($heures);
		return $heures;
	}

	public function Minutes($minutes = NULL)
	{
		if ($minutes != NULL)
			$this->minutes = intval($minutes);
		return $this->minutes;
	}

	public function Secondes($secondes = NULL)
	{
		if ($secondes != NULL)
			$this->secondes = intval($secondes);
		return $this->secondes;
	}

	/***********************************************/
	public function JourEnLettres($type)
	{
		switch ($this->Mois())
		{
			case 1:
				return $this->Lundi($type);
			case 2:
				return $this->Mardi($type);
			case 3:
				return $this->Mercredi($type);
			case 4:
				return $this->Jeudi($type);
			case 5:
				return $this->Vendredi($type);
			case 6:
				return $this->Samedi($type);
			case 7:
				return $this->Dimanche($type);
			default:
				return '';
		}
	}

	private function Lundi($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Lundi';
				else
					return 'Lun';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'Monday';
				else
					return 'Mon';
			default:
				return '';
		}
	}

	private function Mardi($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Mardi';
				else
					return 'Mar';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'Tuesday';
				else
					return 'Tue';
			default:
				return '';
		}
	}

	private function Mercredi($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Mercredi';
				else
					return 'Mer';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'Wednesday';
				else
					return 'Wed';
			default:
				return '';
		}
	}

	private function Jeudi($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Jeudi';
				else
					return 'Jeu';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'Thursday';
				else
					return 'Thu';
			default:
				return '';
		}
	}

	private function Vendredi($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Vendredi';
				else
					return 'Ven';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'Friday';
				else
					return 'Fri';
			default:
				return '';
		}
	}

	private function Samedi($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Samedi';
				else
					return 'Sam';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'Saturday';
				else
					return 'Sat';
			default:
				return '';
		}
	}

	private function Dimanche($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Dimanche';
				else
					return 'Dim';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'Sunday';
				else
					return 'Sun';
			default:
				return '';
		}
	}

	/***********************************************/
	public function MoisEnLettres($type)
	{
		switch ($this->Mois())
		{
			case 1:
				return $this->Janvier($type);
			case 2:
				return $this->Fevrier($type);
			case 3:
				return $this->Mars($type);
			case 4:
				return $this->Avril($type);
			case 5:
				return $this->Mai($type);
			case 6:
				return $this->Juin($type);
			case 7:
				return $this->Juillet($type);
			case 8:
				return $this->Aout($type);
			case 9:
				return $this->Septembre($type);
			case 10:
				return $this->Octobre($type);
			case 11:
				return $this->Novembre($type);
			case 12:
				return $this->Decembre($type);
			default:
				return '00';
		}
	}

	private function Janvier($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Janvier';
				else
					return 'Jan';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'January';
				else
					return 'Jan';
			default:
				return '01';
		}
	}

	private function Fevrier($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Fevrier';
				else
					return 'Fev';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'February';
				else
					return 'Feb';
			default:
				return '02';
		}
	}

	private function Mars($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Mars';
				else
					return 'Mar';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'March';
				else
					return 'Mar';
			default:
				return '03';
		}
	}

	private function Avril($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Avril';
				else
					return 'Avr';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'April';
				else
					return 'Apr';
			default:
				return '04';
		}
	}

	private function Mai($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Mai';
				else
					return 'Mai';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'May';
				else
					return 'May';
			default:
				return '05';
		}
	}

	private function Juin($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Juin';
				else
					return 'Juin';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'June';
				else
					return 'Jun';
			default:
				return '06';
		}
	}

	private function Juillet($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Juillet';
				else
					return 'Juil';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'July';
				else
					return 'Jul';
			default:
				return '07';
		}
	}

	private function Aout($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Août';
				else
					return 'Aoû';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'August';
				else
					return 'Aug';
			default:
				return '08';
		}
	}

	private function Septembre($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Septembre';
				else
					return 'Sep';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'September';
				else
					return 'Sep';
			default:
				return '09';
		}
	}

	private function Octobre($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Octobre';
				else
					return 'Oct';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'October';
				else
					return 'Oct';
			default:
				return '10';
		}
	}

	private function Novembre($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Novembre';
				else
					return 'Nov';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'November';
				else
					return 'Nov';
			default:
				return '11';
		}
	}

	private function Decembre($type)
	{
		switch ($langue)
		{
			case LANGUE_FRANCAISE:
				if ($type === ENTIER)
					return 'Decembre';
				else
					return 'Dec';
			case LANGUE_ANGLAISE:
				if ($type === ENTIER)
					return 'December';
				else
					return 'Dec';
			default:
				return '12';
		}
	}

	/***********************************************/
	private function DateTime()
	{
		$offset = 0;
		if ($this->valide === false)
			return NULL;
		else if ($this->now === true)
			$timeStamp = time();
		else
		{
			$dateTimeZoneEntree = new DateTimeZone($this->FuseauEntree());
			$dateTimeEntree = new DateTime();
			$dateTimeEntree->SetTimeZone(new DateTimeZone($this->FuseauEntree()));
			$dateTime = new DateTime();
			$dateTime->SetTimeZone(new DateTimeZone('UTC'));
			$offset = $dateTimeZoneEntree->getOffset($dateTime) + $dateTimeEntree->getOffset();	// Offset entre le fuseau d'entrée et l'utc auquel on rajoute l'offset heure d'été.

			$timeStamp = mktime($this->Heures(), $this->Minutes(), $this->Secondes()-$offset, $this->Mois(), $this->Jour(), $this->Annee());

			/*$dateTimeZoneEntree = new DateTimeZone($this->FuseauEntree());
			$dateTimeZoneSortie = new DateTimeZone($this->FuseauSortie());

			$dateTime = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $timeStamp), $dateTimeZoneEntree); 						// Date avec le fuseau horaire d'entrée.
			$offset = $dateTimeZoneSortie->getOffset($dateTime) - $dateTimeZoneEntree->getOffset($dateTime) + $dateTime->getOffset();			// Différence entre le fuseau en sortie et celui en entrée + heures d'hiver/été.																					// Heures d'hiver et d'été.
			$timeStamp = mktime($this->Heures(), $this->Minutes(), $this->Secondes()+$offset, $this->Mois(), $this->Jour(), $this->Annee());
			$dateTime = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $timeStamp), $dateTimeZoneSortie);						// Date avec le fuseau horaire de sortie.*/
		}

		if ($timeStamp !== false)
		{
			$dateTime = new DateTime();
			$dateTime->SetTimeStamp($timeStamp);
			$dateTime->SetTimeZone(new DateTimeZone($this->FuseauSortie()));

			return $dateTime;
		}
		else
		{
			GLog::LeverException(EXG_0042, 'GLog::DateFormat, valeurs de date invalides ['.$this->Annee().'-'.$this->Mois().'-'.$this->Jour().' '.$this->Heures().':'.$this->Minutes().':'.$this->Secondes()-$offset.'].');
			return NULL;
		}
	}

	public function DateTimeFormat($format)
	{
		$dateTime = $this->DateTime();
		if ($dateTime != NULL)
		{
			switch ($format)
			{
				// Ex: "Lun 5 Jan 08 - 1:20:15".
				case DATEFORMAT_FORUM:
					return $this->JourEnLettres(ABREGE).$dateTime->format(' j ').$this->MoisEnLettres(ABREGE).$dateTime->format(' y - G:i:s');
				// Ex: "2008-01-01 10:20:00" - TYPE MYSQL.
				case DATEFORMAT_SQL:
				default:
					return $dateTime->format('Y-m-d H:i:s');
			}
		}
		return NULL;
	}

	public function DateFormat($format)
	{
		$dateTime = $this->DateTime();
		if ($dateTime != NULL)
		{
			switch ($format)
			{
				// Ex: "2008-01-01" - TYPE MYSQL.
				case DATEFORMAT_SQL:
				default:
					return $dateTime->format('Y-m-d');
			}
		}
		return NULL;
	}

	public function TimeFormat($format)
	{
		$dateTime = $this->DateTime();
		if ($dateTime != NULL)
		{
			switch ($format)
			{
				// Ex: "10:20:00" - TYPE MYSQL.
				case DATEFORMAT_SQL:
				default:
					return $dateTime->format('H:i:s');
			}
		}
		return NULL;
	}

	public function DateTimeSQL()
	{
		return $this->DateTimeFormat(DATEFORMAT_SQL, false);
	}

	public function DateSQL()
	{
		return $this->DateFormat(DATEFORMAT_SQL, false);
	}

	public function TimeSQL()
	{
		return $this->TimeFormat(DATEFORMAT_SQL, false);
	}
}

?>