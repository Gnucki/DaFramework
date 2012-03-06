<?php

namespace
{
	/*
		Getter/Setter.
	*/
	class A
	{
		private $A = 1;
		public $B = 2;
		private $D = 3;
		
		public function __get($propertyName)
		{
			echo '-'.$propertyName.'-';
			$baseReflectionClass = new \ReflectionClass($this);
			if ($baseReflectionClass->hasProperty($propertyName))
			{
				if ($propertyName == 'A')
					echo $this->A;
				else
					echo 'A1';
			}
			else
				echo 'A2';
		}
		
		public function __set($propertyName, $propertyValue) 
		{
			echo 'A10';
		}
	}
	
	class B extends A
	{	
		private $E = 4;
		public $F = 5;
		
		public function __get($propertyName)
		{
			echo 'B1';
			parent::__get($propertyName);
			if ($propertyName == 'E')
				$this->E = 6;
		}
		
		public function __set($propertyName, $propertyValue) 
		{
			echo 'B10';
		}
	}
	
	echo "<br/><br/><br/>";
	$b = new B();
	echo 'A: ';
	echo $b->A."<br/>";
	echo 'B: ';
	echo $b->B.'<br/>';
	echo 'C: ';
	echo $b->C.'<br/>';
	echo 'D: ';
	echo $b->D.'<br/>';
	echo 'E: ';
	echo $b->E.'<br/>';
	echo 'F: ';
	echo $b->F.'<br/>';
	$b->E = 7;
	
	
	/*
		Enumérations.
	*/
	abstract class Enum 
	{
		private $Valeur;
		private static $classLastItemValues = array();
		
		public function __get($propertyName)
		{
			if ($propertyName == "Valeur")
				return $this->Valeur;
		}
		
		public function __construct($itemValue = null)
		{
			$className = get_class($this);
			$lastItemValue = -1;
			if (array_key_exists($className, self::$classLastItemValues))
				$lastItemValue = self::$classLastItemValues[$className];
			if ($itemValue === null)
			{
				if ($lastItemValue !== null)
				{
					$lastItemValue++;
					$this->Valeur = $lastItemValue;
					self::$classLastItemValues[$className] = $lastItemValue;
				}
				//else
					// ON DOIT FORCEMENT DONNER UNE VALEUR A UN ELEMENT DUNE ENUMERATION SI ON L'A FAIT POUR UN AUTRE.
			}
			else
			{
				if (!array_key_exists($className, self::$classLastItemValues))
					$lastItemValue = self::$classLastItemValues[$className] = null;
				if ($lastItemValue === null)
					$this->Valeur = $itemValue;
				//else
					// ON NE PEUT PAS DONNER UNE VALEUR A UN ELEMENT SI ON NE L'A PAS FAIT POUR LES AUTRES.
			}
		}
	}

	class AEnum extends Enum
	{
		public static $A = null;
		public static $B = null;
		public static $C = null;
		
		static function Initialization()
		{
			self::$A = new AEnum();
			self::$B = new AEnum();
			self::$C = new AEnum();
		}
	}
	AEnum::Initialization();
	
	class BEnum extends Enum
	{
		public static $A = null;
		public static $B = null;
		public static $C = null;
		
		static function Initialization()
		{
			self::$A = new BEnum(3);
			self::$B = new BEnum(4);
			self::$C = new BEnum(5);
		}
	}
	BEnum::Initialization();

	echo "<br/><br/><br/>";
	echo(AEnum::$A->Valeur);
	echo('<br/>');
	echo(AEnum::$B->Valeur);
	echo('<br/>');
	echo(AEnum::$C->Valeur);
	echo('<br/>');
	echo(BEnum::$A->Valeur);
	echo('<br/>');
	echo(BEnum::$B->Valeur);
	echo('<br/>');
	echo(BEnum::$C->Valeur);
	
	function test(AEnum $aEnum)
	{
		switch ($aEnum)
		{
			case AEnum::$A:
				echo 'switchAA';
				break;
			case AEnum::$B:
				echo 'switchAB';
				break;
			case AEnum::$C:
				echo 'switchAC';
				break;
		}
	}
	echo "<br/><br/><br/>";
	test(AEnum::$A);
	echo('<br/>');
	test(AEnum::$B);
	echo('<br/>');
	test(AEnum::$C);
	
	
// Création d'une nouvelle ressource cURL
$ch = curl_init();

// Configuration de l'URL et d'autres options
curl_setopt($ch, CURLOPT_URL, "http://www.fnac.com/");
curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10); 

// Récupération de l'URL et affichage sur le naviguateur
$file_contents = curl_exec($ch);

// Fermeture de la session cURL
curl_close($ch);

$lines = array(); 
$lines = explode("\n", $file_contents); 

// display file line by line 
foreach($lines as $line_num => $line) 
{ 
	echo "Line # {$line_num} : ".htmlspecialchars($line)."<br />\n"; 
}

echo '<script type="text/javascript">
alert(2);
var test = document.getElementById("scrum");
alert(test.id); 
</script>';
}

?>