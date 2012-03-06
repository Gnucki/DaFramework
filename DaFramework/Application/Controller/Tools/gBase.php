<?php

require_once 'cst.php';
require_once INC_GLOG;


class GBase
{
   	private static $db;
   	private static $transactionEnCours;

	private static function GetBase()
	{
	   	if (self::$db == NULL)
	   	{
	   	   	try
			{
			   	self::$transactionEnCours = false;
    	  	  	self::$db = new PDO(CONNEXION, USERBDD, PASSWORDBDD);
    		}
			catch (PDOException $e)
			{
			   	// Notification utilisateur.
			   	GLog::LeverException(EXG_0080, 'Erreur de connexion à la base de données.', true, false);
			   	// Log dans le fichier d'exception.
				GLog::LeverException(EXG_0080, 'GBase::GetBase, erreur de connexion à la base de données ['.$e->getMessage().'].');
			    die();
			}
	   	}

	   	return self::$db;
	}

	public static function DemarrerTransaction()
	{
	   	$db = self::GetBase();

	   	if (self::$transactionEnCours === false)
		{
		   	self::$transactionEnCours = true;
		   	if ($db !== NULL)
			{
		   	   	$db->beginTransaction();
		   	   	return true;
		   	}
		}
		else
		   	GLog::LeverException(EXG_0081, 'GBase::DemarrerTransaction, une transaction est déjà en cours.');

	   	return false;
	}

	public static function ValiderTransaction()
	{
	   	$db = self::GetBase();

	   	if (self::$transactionEnCours === true)
		{
		   	self::$transactionEnCours = false;
		   	if ($db !== NULL)
			{
		   	   	$db->commit();
		   	   	return true;
		   	}
		}
		else
		   	GLog::LeverException(EXG_0082, 'GBase::ValiderTransaction, pas de transaction en cours. Echec de la validation.');

	   	return false;
	}

	public static function AnnulerTransaction()
	{
	   	$db = self::GetBase();

	   	if (self::$transactionEnCours === true)
		{
		   	self::$transactionEnCours = false;
		   	if ($db !== NULL)
			{
		   	   	$db->rollback();
		   	   	return true;
		   	}
		}
		else
		   	GLog::LeverException(EXG_0083, 'GBase::AnnulerTransaction, pas de transaction en cours. Echec de l\'annulation.');

	   	return false;
	}

	public static function DernierIdInsere()
	{
	   	$id = NULL;
	   	$db = self::GetBase();

	 	if ($db !== NULL)
		{
			$id = $db->LastInsertId();

		   	if ($id == 0)
			   	$id = NULL;
		}

		return $id;
	}

	public static function PreparerRequete($requete)
	{
	   	$requetePreparee = '';
	   	$db = self::GetBase();

	 	if ($db !== NULL)
			$requetePreparee = $db->prepare($requete);

		return $requetePreparee;
	}

	public static function EstEnTransaction()
	{
	   	if (self::$transactionEnCours === NULL)
	   		self::$transactionEnCours = false;

		return self::$transactionEnCours;
	}
}

?>