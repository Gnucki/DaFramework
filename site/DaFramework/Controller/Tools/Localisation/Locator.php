<?php

namespace DaFramework\Controller\Tools\Localisation
{
	/*************************************************************/
	/* Locator class (decorator pattern).
	/*************************************************************/
	class Locator implements ILocator
	{
		/*************************************/
		// CLASS FIELDS
		//
		private static $instance;

		/*************************************/
		// CLASS PROPERTIES
		//
		public static function Instance()
		{
			if (self::$instance === null)
				self::$instance = new Locator();
			return self::$instance;
		}

		// Get an array mapping languages and time zones.
		public function LanguageTimeZones()
		{
			$languageTimeZones = array();
			// Africain.
			$languageTimeZones['af'] = array('Africa/Abidjan', 'Africa/Mogadishu', 'Africa/Lagos', 'Africa/Dakar', 'Africa/Accra', 'Africa/Bamako', 'Africa/Brazzaville', 'Africa/Kinshasa', 'Africa/Conakry', 'Africa/Kampala', 'Africa/Libreville', 'Africa/Freetown', 'Africa/Monrovia', 'Africa/Ouagadougou', 'Africa/Nairobi', 'Africa/Djibouti', 'Africa/Dar_es_Salaam', 'Africa/Timbuktu', 'Africa/Asmera', 'Africa/Banjul', 'Africa/Blantyre', 'Africa/Douala', 'Africa/Gaborone', 'Africa/Kigali', 'Africa/Lubumbashi', 'Africa/Luanda', 'Africa/Maseru', 'Africa/Lusaka', 'Africa/Windhoek', 'Africa/Malabo', 'Africa/Bujumbura', 'Africa/Lome', 'Africa/Niamey', 'Africa/Maputo', 'Africa/Mbabane', 'Africa/Bissau', 'Africa/Porto-Novo', 'Africa/Harare', 'Africa/Johannesburg', 'Africa/Khartoum', 'Africa/Ndjamena', 'Africa/Asmara', 'America/Jamaica', 'America/Marigot', 'America/St_Vincent', 'America/St_Lucia');
			// Albanais.
			$languageTimeZones['sq'] = array('Europe/Tirane');
			// Algérien.
			$languageTimeZones['ar-dz'] = array('Africa/Algiers');
			// Allemand.
			$languageTimeZones['de'] = array('Europe/Berlin', 'Europe/Luxembourg', 'Europe/Vaduz', 'Europe/Zurich');
			// Allemand (Austrian).
			$languageTimeZones['de-at'] = array('Europe/Vienna');
			// Allemand (Liechtenstein).
			$languageTimeZones['de-li'] = array('Europe/Vaduz');
			// Allemand (Luxembourg).
			$languageTimeZones['de-lu'] = array('Europe/Luxembourg');
			// Allemand (Suisse).
			$languageTimeZones['de-ch'] = array('Europe/Zurich');
			// Américain.
			$languageTimeZones['en-us'] = array('America/New_York', 'America/Los_Angeles', 'America/Chicago', 'America/Detroit', 'America/Phoenix', 'America/Denver', 'America/Edmonton', 'America/Indianapolis', 'America/Louisville', 'America/Montreal', 'America/Toronto', 'America/Vancouver', 'America/Dawson_Creek', 'America/Fort_Wayne', 'America/Monterrey', 'America/Inuvik', 'America/Iqaluit', 'America/Menominee', 'America/Montserrat', 'America/Swift_Current', 'America/St_Thomas', 'America/St_Vincent', 'America/Winnipeg', 'America/Shiprock', 'America/Adak', 'America/Anchorage', 'America/Yakutat', 'America/Atikokan', 'America/Atka', 'America/Barbados', 'America/Belize', 'America/Bogota', 'America/Cambridge_Bay', 'America/Cancun', 'America/Cayman', 'America/Coral_Harbour', 'America/Halifax', 'America/Curacao', 'America/Danmarkshavn', 'America/Dawson', 'America/Knox_IN', 'America/Whitehorse', 'America/Yellowknife', 'America/Dominica', 'America/Ensenada', 'America/Glace_Bay', 'America/Goose_Bay', 'America/Nipigon', 'America/Rainy_River', 'America/Rankin_Inlet', 'America/Regina', 'America/Resolute', 'America/Thunder_Bay', 'America/St_Barthelemy', 'America/St_Johns', 'America/St_Kitts', 'America/St_Lucia', 'America/Grand_Turk', 'America/Grenada', 'America/Guyana', 'America/Virgin', 'America/Tortola', 'America/Port-au-Prince', 'America/Jamaica', 'America/Marigot', 'America/Moncton', 'America/Nassau', 'America/Pangnirtung', 'America/Puerto_Rico', 'America/Port_of_Spain', 'America/Indiana/Indianapolis', 'America/Indiana/Knox', 'America/Indiana/Marengo', 'America/Indiana/Petersburg', 'America/Indiana/Tell_City', 'America/Indiana/Vevay', 'America/Indiana/Vincennes', 'America/Indiana/Winamac', 'America/Kentucky/Louisville', 'America/Kentucky/Monticello', 'America/North_Dakota/Center', 'America/North_Dakota/New_Salem', 'Pacific/Chatham', 'Pacific/Enderbury', 'Pacific/Honolulu', 'Pacific/Johnston');
			// Anglais.
			$languageTimeZones['en'] = array('Europe/London', 'America/New_York', 'America/Los_Angeles', 'America/Chicago', 'America/Detroit', 'America/Phoenix', 'America/Denver', 'America/Edmonton', 'America/Indianapolis', 'America/Louisville', 'America/Montreal', 'America/Toronto', 'America/Vancouver', 'America/Dawson_Creek', 'America/Fort_Wayne', 'America/Monterrey', 'America/Halifax', 'America/Inuvik', 'America/Iqaluit', 'America/Menominee', 'America/Montserrat', 'America/Swift_Current', 'America/St_Thomas', 'America/St_Vincent', 'America/Winnipeg', 'America/Shiprock', 'Europe/Gibraltar', 'Europe/Jersey', 'Europe/Guernsey', 'Antarctica/Rothera', 'Atlantic/St_Helena', 'Atlantic/Bermuda', 'Atlantic/Canary', 'Atlantic/South_Georgia', 'Indian/Chagos', 'America/Anguilla', 'America/Antigua', 'America/Atikokan', 'America/Atka', 'America/Knox_IN', 'America/Whitehorse', 'America/Yellowknife', 'America/Barbados', 'America/Belize', 'America/Bogota', 'America/Cambridge_Bay', 'America/Cancun', 'America/Cayman', 'America/Coral_Harbour', 'America/Curacao', 'America/Danmarkshavn', 'America/Dawson', 'America/Dominica', 'America/Puerto_Rico', 'America/Port-au-Prince', 'America/Ensenada', 'America/Glace_Bay', 'America/Goose_Bay', 'America/Nipigon', 'America/Rainy_River', 'America/Rankin_Inlet', 'America/Regina', 'America/Resolute', 'America/Thunder_Bay', 'America/St_Barthelemy', 'America/St_Johns', 'America/St_Kitts', 'America/St_Lucia', 'America/Grand_Turk', 'America/Grenada', 'America/Guyana', 'America/Virgin', 'America/Tortola', 'America/Jamaica', 'America/Marigot', 'America/Moncton', 'America/Nassau', 'America/Pangnirtung', 'America/Port_of_Spain', 'America/Indiana/Indianapolis', 'America/Indiana/Knox', 'America/Indiana/Marengo', 'America/Indiana/Petersburg', 'America/Indiana/Tell_City', 'America/Indiana/Vevay', 'America/Indiana/Vincennes', 'America/Indiana/Winamac', 'America/Kentucky/Louisville', 'America/Kentucky/Monticello', 'America/North_Dakota/Center', 'America/North_Dakota/New_Salem', 'Australia/Sydney', 'Australia/Melbourne', 'Australia/Canberra', 'Australia/Adelaide', 'Australia/Brisbane', 'Australia/Perth', 'Australia/Queensland', 'Australia/Broken_Hill', 'Australia/Darwin', 'Australia/Hobart', 'Australia/Victoria', 'Australia/Currie', 'Australia/Eucla', 'Australia/Lindeman', 'Australia/Lord_Howe', 'Australia/Tasmania', 'Australia/Yancowinna', 'Australia/South', 'Australia/West', 'Australia/North', 'Australia/ACT', 'Australia/NSW', 'Australia/LHI', 'Pacific/Apia', 'Pacific/Auckland', 'Pacific/Chatham', 'Pacific/Efate', 'Pacific/Enderbury', 'Pacific/Fakaofo', 'Pacific/Fiji', 'Pacific/Funafuti', 'Pacific/Honolulu', 'Pacific/Guadalcanal', 'Pacific/Guam', 'Pacific/Johnston', 'Pacific/Kiritimati', 'Pacific/Norfolk', 'Pacific/Pago_Pago', 'Pacific/Palau', 'Pacific/Pitcairn', 'Pacific/Ponape', 'Pacific/Port_Moresby', 'Pacific/Rarotonga', 'Pacific/Saipan', 'Pacific/Samoa', 'Pacific/Tarawa', 'Pacific/Tongatapu', 'Pacific/Wake', 'Pacific/Yap', 'Asia/Calcutta', 'Asia/Colombo', 'Asia/Hong_Kong');
			// Anglais (Afrique du sud).
			$languageTimeZones['en-za'] = array('Africa/Johannesburg', 'Africa/Mbabane');
			// Anglais (Bélize).
			$languageTimeZones['en-bz'] = array('America/Belize');
			// Anglais (Grande Bretagne).
			$languageTimeZones['en-gb'] = array('Europe/London', 'America/New_York', 'America/Los_Angeles', 'America/Chicago', 'America/Detroit', 'America/Phoenix', 'America/Denver', 'America/Edmonton', 'America/Indianapolis', 'America/Louisville', 'America/Montreal', 'America/Toronto', 'America/Vancouver', 'America/Dawson_Creek', 'America/Fort_Wayne', 'America/Monterrey', 'America/Halifax', 'America/Inuvik', 'America/Iqaluit', 'America/Menominee', 'America/Montserrat', 'America/Swift_Current', 'America/St_Thomas', 'America/St_Vincent', 'America/Winnipeg', 'America/Shiprock', 'Europe/Belfast', 'Europe/Jersey', 'Europe/Guernsey', 'Antarctica/Rothera', 'Atlantic/St_Helena', 'Atlantic/Bermuda', 'Atlantic/South_Georgia', 'Indian/Chagos', 'America/Anguilla', 'America/Antigua', 'America/Atikokan', 'America/Atka', 'America/Barbados', 'America/Belize', 'America/Bogota', 'America/Cambridge_Bay', 'America/Cayman', 'America/Coral_Harbour', 'America/Curacao', 'America/Danmarkshavn', 'America/Dawson', 'America/Dominica', 'America/Nipigon', 'America/Rainy_River', 'America/Rankin_Inlet', 'America/Regina', 'America/Resolute', 'America/Thunder_Bay', 'America/St_Barthelemy', 'America/St_Johns', 'America/St_Kitts', 'America/St_Lucia', 'America/Grand_Turk', 'America/Grenada', 'America/Guyana', 'America/Virgin', 'America/Tortola', 'America/Puerto_Rico', 'America/Port-au-Prince', 'America/Jamaica', 'America/Marigot', 'America/Moncton', 'America/Nassau', 'America/Pangnirtung', 'America/Port_of_Spain', 'America/Indiana/Indianapolis', 'America/Indiana/Knox', 'America/Indiana/Marengo', 'America/Indiana/Petersburg', 'America/Indiana/Tell_City', 'America/Indiana/Vevay', 'America/Indiana/Vincennes', 'America/Indiana/Winamac', 'America/Kentucky/Louisville', 'America/Kentucky/Monticello', 'America/North_Dakota/Center', 'America/North_Dakota/New_Salem', 'Pacific/Chatham', 'Pacific/Efate', 'Pacific/Enderbury', 'Pacific/Fakaofo', 'Pacific/Fiji', 'Pacific/Funafuti', 'Pacific/Honolulu', 'Pacific/Guadalcanal', 'Pacific/Guam', 'Pacific/Johnston', 'Pacific/Kiritimati', 'Pacific/Norfolk', 'Pacific/Pago_Pago', 'Pacific/Palau', 'Pacific/Pitcairn', 'Pacific/Ponape', 'Pacific/Port_Moresby', 'Pacific/Rarotonga', 'Pacific/Saipan', 'Pacific/Samoa', 'Pacific/Tarawa', 'Pacific/Tongatapu', 'Pacific/Wake', 'Pacific/Yap', 'Asia/Calcutta', 'Asia/Colombo', 'Asia/Hong_Kong');
			// Arabe.
			$languageTimeZones['ar'] = array('Asia/Dubai', 'Asia/Damascus', 'Asia/Gaza', 'Asia/Aden', 'Asia/Amman', 'Asia/Muscat', 'Asia/Kuwait', 'Asia/Baghdad', 'Asia/Bahrain', 'Asia/Beirut', 'Asia/Tehran', 'Asia/Kabul', 'Asia/Karachi', 'Asia/Qatar', 'Asia/Riyadh', 'Africa/Nouakchott', 'Africa/Khartoum', 'Africa/Algiers', 'Africa/Cairo', 'Africa/Tunis', 'Africa/Asmara', 'Africa/Ndjamena', 'Asia/Jerusalem', 'Asia/Tel_Aviv');
			// Arabe (Arabie Saoudite).
			$languageTimeZones['ar-sa'] = array('Asia/Riyadh');
			// Arabe (Bahreïn).
			$languageTimeZones['ar-bh'] = array('Asia/Bahrain');
			// Arabe (Emirats arabes unis).
			$languageTimeZones['ar-ae'] = array('Asia/Dubai', 'Asia/Muscat');
			// Australien.
			$languageTimeZones['en-au'] = array('Australia/Sydney', 'Australia/Melbourne', 'Australia/Canberra', 'Australia/Adelaide', 'Australia/Brisbane', 'Australia/Perth', 'Australia/Queensland', 'Australia/Broken_Hill', 'Australia/Darwin', 'Australia/Hobart', 'Australia/Victoria', 'Australia/Currie', 'Australia/Eucla', 'Australia/Lindeman', 'Australia/Lord_Howe', 'Australia/Tasmania', 'Australia/Yancowinna', 'Pacific/Apia', 'Pacific/Auckland', 'Pacific/Fiji', 'Pacific/Fakaofo', 'Pacific/Funafuti', 'Pacific/Norfolk', 'Australia/South', 'Australia/West', 'Australia/North', 'Australia/ACT', 'Australia/NSW', 'Australia/LHI', 'Antarctica/Casey', 'Antarctica/Davis', 'Antarctica/Mawson');
			// Basque.
			$languageTimeZones['eu'] = array('Europe/Madrid');
			// Belge.
			$languageTimeZones['nl-be'] = array('Europe/Brussels');
			// Biélorussie.
			$languageTimeZones['be'] = array('Europe/Minsk');
			// Bulgarre.
			$languageTimeZones['bg'] = array('Europe/Sofia');
			// Canadien.
			$languageTimeZones['en-ca'] = array('America/Montreal', 'America/Toronto', 'America/Vancouver', 'America/Edmonton', 'America/Glace_Bay', 'America/Goose_Bay', 'America/Inuvik', 'America/Iqaluit', 'America/Marigot', 'America/Moncton', 'America/Nipigon', 'America/Rainy_River', 'America/Resolute', 'America/Rankin_Inlet', 'America/Thunder_Bay', 'America/Regina', 'America/Whitehorse', 'America/Yellowknife', 'America/Winnipeg', 'America/Blanc-Sablon', 'Pacific/Chatham');
			// Catalan.
			$languageTimeZones['ca'] = array('Europe/Madrid');
			// Chinois.
			$languageTimeZones['zh'] = array('Asia/Shanghai', 'Asia/Urumqi', 'Asia/Chongqing', 'Asia/Harbin', 'Asia/Kashgar', 'Asia/Hong_Kong', 'Asia/Singapore', 'Asia/Taipei', 'Asia/Kathmandu', 'Asia/Katmandu', 'Asia/Macao', 'Asia/Macau', 'Asia/Ulan_Bator', 'Asia/Ulaanbaatar', 'Pacific/Kiritimati', 'Asia/Hovd', 'Asia/Choibalsan', 'Asia/Chungking', 'Asia/Ho_Chi_Minh', 'Asia/Saigon', 'Asia/Phnom_Penh', 'Asia/Seoul', 'Asia/Pyongyang', 'Asia/Rangoon', 'Asia/Thimbu', 'Asia/Thimphu', 'Asia/Vientiane');
			// Chinois (Hong-Kong).
			$languageTimeZones['zh-hk'] = array('Asia/Hong_Kong', 'Asia/Chungking');
			// Chinois (PRC).
			$languageTimeZones['zh-cn'] = array('Asia/Shanghai', 'Asia/Urumqi', 'Asia/Chongqing', 'Asia/Harbin', 'Asia/Kashgar');
			// Chinois (Singapourg).
			$languageTimeZones['zh-sg'] = array('Asia/Singapore');
			// Chinois (Taïwan).
			$languageTimeZones['zh-tw'] = array('Asia/Taipei');
			// Coréen.
			$languageTimeZones['ko'] = array('Asia/Seoul', 'Pacific/Kosrae', 'Asia/Pyongyang', 'Pacific/Ponape');
			// Crète.
			$languageTimeZones['cs'] = array('Europe/Athens');
			// Croate.
			$languageTimeZones['hr'] = array('Europe/Zagreb');
			// Danois.
			$languageTimeZones['da'] = array('Europe/Copenhagen', 'Atlantic/Faroe', 'Atlantic/Faeroe', 'America/Danmarkshavn', 'America/Godthab', 'America/Scoresbysund', 'America/Thule');
			// Egyptien.
			$languageTimeZones['ar-eg'] = array('Africa/Cairo');
			// Espagnol.
			$languageTimeZones['es'] = array('Europe/Madrid', 'Europe/Andorra', 'Africa/Ceuta', 'Atlantic/Azores', 'Atlantic/Bermuda', 'Atlantic/Canary', 'Atlantic/Cape_Verde', 'America/Mexico_City', 'America/Tijuana', 'America/Aruba', 'America/Asuncion', 'America/Belize', 'America/Bogota', 'America/Buenos_Aires', 'America/Cancun', 'America/Caracas', 'America/Costa_Rica', 'America/La_Paz', 'America/Lima', 'America/Santiago', 'America/Tegucigalpa', 'America/Curacao', 'America/El_Salvador', 'America/Guatemala', 'America/Guayaquil', 'America/Havana', 'America/Managua', 'America/Hermosillo', 'America/Jujuy', 'America/Mazatlan', 'America/Mendoza', 'America/Merida', 'America/Montevideo', 'America/Panama', 'America/Puerto_Rico', 'America/Port_of_Spain', 'America/Rosario', 'America/Santo_Domingo', 'Pacific/Easter', 'Pacific/Galapagos');
			// Espagnol (Argentine).
			$languageTimeZones['es-ar'] = array('America/Argentina/Buenos_Aires', 'America/Buenos_Aires', 'America/Argentina/Cordoba', 'America/Argentina/La_Rioja', 'America/Argentina/Mendoza', 'America/Argentina/Rio_Gallegos', 'America/Argentina/Catamarca', 'America/Argentina/ComodRivadavia', 'America/Argentina/Jujuy', 'America/Argentina/Salta', 'America/Argentina/San_Juan', 'America/Argentina/San_Luis', 'America/Argentina/Tucuman', 'America/Argentina/Ushuaia', 'America/Mexico_City', 'America/Catamarca', 'America/Cordoba', 'America/Hermosillo', 'America/Jujuy', 'America/Mendoza', 'America/Merida', 'America/Rosario');
			// Espagnol (Bolivie).
			$languageTimeZones['es-bo'] = array('America/La_Paz');
			// Espagnol (Chilie).
			$languageTimeZones['es-cl'] = array('America/Santiago', 'Pacific/Easter');
			// Espagnol (Colombie).
			$languageTimeZones['es-co'] = array('America/Bogota');
			// Espagnol (Costa Rica).
			$languageTimeZones['es-cr'] = array('America/Costa_Rica');
			// Espagnol (El Salvador).
			$languageTimeZones['es-sv'] = array('America/El_Salvador');
			// Espagnol (Equateur).
			$languageTimeZones['es-ec'] = array('America/Guayaquil', 'Pacific/Galapagos');
			// Espagnol (Guatemala).
			$languageTimeZones['es-gt'] = array('America/Guatemala');
			// Espagnol (Honduras).
			$languageTimeZones['es-hn'] = array('America/Tegucigalpa');
			// Espagnol (Mexique).
			$languageTimeZones['es-mx'] = array('America/Mexico_City', 'America/Tijuana', 'America/Cancun', 'America/Belize', 'America/Ensenada', 'America/Hermosillo', 'America/Mazatlan');
			// Espagnol (Nicaragua).
			$languageTimeZones['es-ni'] = array('America/Managua');
			// Espagnol (Panama).
			$languageTimeZones['es-pa'] = array('America/Panama');
			// Espagnol (Paraguay).
			$languageTimeZones['es-py'] = array('America/Asuncion');
			// Espagnol (Pérou).
			$languageTimeZones['es-pe'] = array('America/Lima');
			// Espagnol (Puerto Rico).
			$languageTimeZones['es-pr'] = array('America/Puerto_Rico');
			// Espagnol (Trinidad).
			$languageTimeZones['en-tt'] = array('America/Port_of_Spain');
			// Espagnol (Uruguay).
			$languageTimeZones['es-uy'] = array('America/Montevideo');
			// Espagnol (Venezuela).
			$languageTimeZones['es-ve'] = array('America/Caracas', 'America/Aruba');
			// Estonien.
			$languageTimeZones['et'] = array('Europe/Tallinn');
			// Estonien.
			$languageTimeZones['sx'] = array('Europe/Tallinn');
			// Faeroese.
			$languageTimeZones['fo'] = array('Atlantic/Faeroe', 'Atlantic/Faroe');
			// Finlandais.
			$languageTimeZones['fi'] = array('Europe/Helsinki', 'Europe/Mariehamn');
			// Français.
			$languageTimeZones['fr'] = array('Europe/Paris', 'Europe/Monaco', 'Indian/Reunion', 'Indian/Mauritius', 'America/Guadeloupe', 'America/Martinique', 'Pacific/Noumea', 'Pacific/Tahiti', 'America/Miquelon', 'Indian/Mayotte', 'Pacific/Wallis', 'Africa/Dakar', 'Africa/Bamako', 'Africa/Libreville', 'Indian/Kerguelen', 'Antarctica/DumontDUrville', 'Indian/Mahe', 'America/Montreal', 'America/Winnipeg', 'America/Blanc-Sablon', 'America/Toronto', 'America/Vancouver', 'America/Cayenne', 'America/Danmarkshavn', 'America/Dawson', 'America/Dominica', 'America/Edmonton', 'America/Glace_Bay', 'America/Goose_Bay', 'America/Inuvik', 'America/Iqaluit', 'America/Marigot', 'America/Moncton', 'America/Nipigon', 'America/Rainy_River', 'America/Resolute', 'America/Rankin_Inlet', 'America/Thunder_Bay', 'America/Regina', 'America/St_Vincent', 'America/Port-au-Prince', 'America/St_Barthelemy', 'America/St_Lucia', 'America/Whitehorse', 'America/Yellowknife', 'Pacific/Efate', 'Pacific/Gambier', 'Pacific/Marquesas');
			// Français.
			$languageTimeZones['fr-fr'] = array('Europe/Paris', 'Europe/Monaco', 'Indian/Reunion', 'Indian/Mauritius', 'America/Guadeloupe', 'America/Martinique', 'Pacific/Noumea', 'Pacific/Tahiti', 'America/Miquelon', 'Indian/Mayotte', 'Pacific/Wallis', 'Africa/Dakar', 'Africa/Bamako', 'Africa/Libreville', 'Indian/Kerguelen', 'Antarctica/DumontDUrville', 'Indian/Mahe', 'America/Montreal', 'America/Winnipeg', 'America/Blanc-Sablon', 'America/Cayenne', 'Pacific/Efate', 'Pacific/Marquesas');
			// Français (Belgique).
			$languageTimeZones['fr-be'] = array('Europe/Brussels');
			// Français (Canada).
			$languageTimeZones['fr-ca'] = array('America/Montreal', 'America/Winnipeg', 'America/Blanc-Sablon', 'America/Toronto', 'America/Vancouver', 'America/Cayenne', 'America/Danmarkshavn', 'America/Dawson', 'America/Dominica', 'America/Edmonton', 'America/Glace_Bay', 'America/Goose_Bay', 'America/Inuvik', 'America/Iqaluit', 'America/Marigot', 'America/Moncton', 'America/Nipigon', 'America/Rainy_River', 'America/Resolute', 'America/Rankin_Inlet', 'America/Thunder_Bay', 'America/Regina', 'America/Whitehorse', 'America/Yellowknife');
			// Français (Luxembourg).
			$languageTimeZones['fr-lu'] = array('Europe/Luxembourg');
			// Français (Suisse).
			$languageTimeZones['fr-ch'] = array('Europe/Zurich');
			// Galicien.
			$languageTimeZones['gd'] = array('Europe/Lisbon', 'Europe/Madrid');
			// Grec.
			$languageTimeZones['el'] = array('Europe/Athens', 'Europe/Nicosia', 'Asia/Nicosia');
			// Hébreux.
			$languageTimeZones['he'] = array('Asia/Jerusalem', 'Asia/Tel_Aviv');
			// Hollandais.
			$languageTimeZones['nl'] = array('Europe/Amsterdam', 'America/Aruba', 'America/Curacao', 'America/Paramaribo');
			// Hongrois.
			$languageTimeZones['hu'] = array('Europe/Budapest');
			// Indonésien.
			$languageTimeZones['in'] = array('Asia/Jakarta', 'Asia/Jayapura', 'Asia/Pontianak', 'Asia/Dili', 'Asia/Ujung_Pandang', 'Asia/Makassar', 'Asia/Manila');
			// Indou.
			$languageTimeZones['hi'] = array('Asia/Calcutta', 'Asia/Kolkata', 'Asia/Colombo', 'Asia/Dacca', 'Asia/Dhaka');
			// Iranien.
			$languageTimeZones['fa'] = array('Asia/Tehran');
			// Iraquien.
			$languageTimeZones['ar-iq'] = array('Asia/Baghdad');
			// Irlandais.
			$languageTimeZones['en-ie'] = array('Europe/Dublin', 'Europe/Isle_of_Man');
			// Islandais.
			$languageTimeZones['is'] = array('Atlantic/Reykjavik');
			// Italien.
			$languageTimeZones['it'] = array('Europe/Rome', 'Europe/Vatican', 'Europe/San_Marino');
			// Italien (Suisse).
			$languageTimeZones['it-ch'] = array('Europe/Zurich');
			// Jamaicain.
			$languageTimeZones['en-jm'] = array('America/Jamaica');
			// Japonais.
			$languageTimeZones['ja'] = array('Asia/Tokyo', 'Pacific/Ponape', 'Pacific/Saipan', 'Pacific/Yap');
			// Jordanien.
			$languageTimeZones['ar-jo'] = array('Asia/Amman');
			// Koweitien.
			$languageTimeZones['ar-kw'] = array('Asia/Kuwait');
			// Lettische.
			$languageTimeZones['lv'] = array('Europe/Vilnius');
			// Libanais.
			$languageTimeZones['ar-lb'] = array('Asia/Beirut');
			// Littuanien.
			$languageTimeZones['lt'] = array('Europe/Vilnius');
			// Lybien.
			$languageTimeZones['ar-ly'] = array('Africa/Tripoli');
			// Macédoine.
			$languageTimeZones['mk'] = array('Europe/Skopje');
			// Malésien.
			$languageTimeZones['ms'] = array('Asia/Kuala_Lumpur', 'Asia/Brunei', 'Asia/Kuching');
			// Maltais.
			$languageTimeZones['mt'] = array('Europe/Malta');
			// Marocain.
			$languageTimeZones['ar-ma'] = array('Africa/Casablanca');
			// Néo-zélandais.
			$languageTimeZones['en-nz'] = array('Pacific/Auckland', 'Pacific/Samoa', 'Pacific/Fakaofo', 'Pacific/Pago_Pago', 'Pacific/Rarotonga');
			// Norvégien.
			$languageTimeZones['no'] = array('Europe/Oslo', 'Arctic/Longyearbyen', 'Atlantic/Jan_Mayen');
			// Oman.
			$languageTimeZones['ar-om'] = array('Asia/Muscat');
			// Polonais.
			$languageTimeZones['pl'] = array('Europe/Warsaw');
			// Portugais.
			$languageTimeZones['pt'] = array('Europe/Lisbon', 'Atlantic/Madeira', 'America/Sao_Paulo', 'America/Bahia', 'America/Belem', 'America/Boa_Vista', 'America/Campo_Grande', 'America/Cuiaba', 'America/Eirunepe', 'America/Fortaleza', 'America/Maceio', 'America/Manaus', 'America/Noronha', 'America/Porto_Acre', 'America/Porto_Velho', 'America/Recife', 'America/Rio_Branco', 'America/Santarem', 'Asia/Dili');
			// Portugais (Brésil).
			$languageTimeZones['pt-br'] = array('America/Sao_Paulo', 'America/Bahia', 'America/Belem', 'America/Boa_Vista', 'America/Campo_Grande', 'America/Cuiaba', 'America/Eirunepe', 'America/Fortaleza', 'America/Maceio', 'America/Manaus', 'America/Noronha', 'America/Porto_Acre', 'America/Porto_Velho', 'America/Recife', 'America/Rio_Branco', 'America/Santarem');
			// Quatar.
			$languageTimeZones['ar-qa'] = array('Asia/Qatar');
			// Rhaeto-Romanic.
			$languageTimeZones['rm'] = array('Europe/Zurich');
			// Roumain.
			$languageTimeZones['ro'] = array('Europe/Bucharest');
			// Roumain (Moldavie).
			$languageTimeZones['ro-mo'] = array('Europe/Chisinau');
			// Russe.
			$languageTimeZones['ru'] = array('Europe/Moscow', 'Europe/Tallinn', 'Europe/Riga', 'Europe/Volgograd', 'Europe/Kaliningrad', 'Europe/Samara', 'Europe/Uzhgorod', 'Asia/Vladivostok', 'Asia/Irkutsk', 'Asia/Almaty', 'Asia/Anadyr', 'Asia/Aqtau', 'Asia/Aqtobe', 'Asia/Ashgabat', 'Asia/Ashkhabad', 'Asia/Bishkek', 'Asia/Dushanbe', 'Asia/Kamchatka', 'Asia/Krasnoyarsk', 'Asia/Magadan', 'Asia/Novosibirsk', 'Asia/Omsk', 'Asia/Qyzylorda', 'Asia/Sakhalin', 'Asia/Samarkand', 'Asia/Tashkent', 'Asia/Tbilisi', 'Asia/Yakutsk', 'Asia/Yekaterinburg', 'Asia/Yerevan');
			// Russe (Moldavie).
			$languageTimeZones['ru-mo'] = array('Europe/Chisinau', 'Europe/Tiraspol');
			// Serbe.
			$languageTimeZones['sr'] = array('Europe/Belgrade', 'Europe/Sarajevo', 'Europe/Podgorica');
			// Slovaque.
			$languageTimeZones['sk'] = array('Europe/Bratislava', 'Europe/Prague');
			// Slovéne.
			$languageTimeZones['sl'] = array('Europe/Ljubljana');
			// Sorbian.
			$languageTimeZones['sb'] = array('Europe/Prague', 'Europe/Berlin');
			// Suèdois.
			$languageTimeZones['sv'] = array('Europe/Stockholm', 'America/St_Barthelemy');
			// Suèdois (Finlande).
			$languageTimeZones['sv-fi'] = array('Europe/Mariehamn');
			// Syrien.
			$languageTimeZones['ar-sy'] = array('Asia/Damascus');
			// Thaïlandais.
			$languageTimeZones['th'] = array('Asia/Bangkok', 'Asia/Ho_Chi_Minh', 'Asia/Phnom_Penh', 'Asia/Rangoon', 'Asia/Vientiane');
			// Tsonga (Afrique du sud).
			$languageTimeZones['ts'] = array('Africa/Johannesburg');
			// Tswana (Afrique du sud).
			$languageTimeZones['tn'] = array('Africa/Johannesburg');
			// Tunisien.
			$languageTimeZones['ar-tn'] = array('Africa/Tunis');
			// Turc.
			$languageTimeZones['tr'] = array('Europe/Istanbul', 'Asia/Istanbul', 'Europe/Nicosia', 'Asia/Ashgabat', 'Asia/Ashkhabad', 'Asia/Baku', 'Asia/Nicosia', 'Asia/Qyzylorda', 'Asia/Tbilisi', 'Asia/Yerevan');
			// Ukrainien.
			$languageTimeZones['uk'] = array('Europe/Kiev', 'Europe/Simferopol', 'Europe/Zaporozhye');
			// Urdu.
			$languageTimeZones['ur'] = array('Asia/Karachi', 'Asia/Dacca', 'Asia/Dhaka');
			// Vietnamien.
			$languageTimeZones['vi'] = array('Asia/Ho_Chi_Minh', 'Asia/Saigon');
			// Xhosa (Afrique).
			$languageTimeZones['xh'] = array('Africa/Johannesburg', 'Africa/Harare', 'Africa/Mbabane');
			// Yémen.
			$languageTimeZones['ar-ye'] = array('Asia/Aden');
			// Yiddish.
			$languageTimeZones['ji'] = array('Asia/Jerusalem', 'Asia/Tel_Aviv');
			// Zulu (Afrique).
			$languageTimeZones['zu'] = array('Africa/Johannesburg', 'Africa/Harare', 'Africa/Mbabane');

			return $languageTimeZones;
		}


		/*************************************/
		// CLASS CONSTRUCTORS
		//
		private function __construct()
		{
		}


		/*************************************/
		// CLASS METHODS
		//
		public function Language()
		{
		   	$langagesAcceptes = explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
			$langue = LANGUE_ANGLAISE;

			switch (strtolower($langagesAcceptes[0]))
			{
				case 'fr':
				case 'fr-fr':
				case 'fr-be':
				case 'fr-ca':
				case 'fr-lu':
				case 'fr-ch':
					$langue = LANGUE_FRANCAISE;
					break;
				case 'en':
				case 'en-us':
				case 'en-za':
				case 'en-bz':
				case 'en-gb':
				default:
					$langue = LANGUE_ANGLAISE;
			}

			return $langue;
		}

		public function Community($langueId = '')
		{
			if ($langueId === '' || $langueId === NULL)
				$langueId = self::Langue();

		   	$mLangue = new MLangue($langueId);
			$mLangue->Charger();
			if ($mLangue->Communaute() != NULL)
				return $mLangue->Communaute()->Id();

			return 0;
		}

		public function TimeZone($decalage)
		{
		   	$languageTimeZones = self::LangueFuseaux();
		   	$langagesAcceptes = explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		   	$scores = array();
		   	$scoreMax = 0;
		   	$fuseauHoraire = 'UTC';
		   	$timeStamp = time();
		   	$dateTime = new DateTime();
			$dateTime->SetTimeStamp($timeStamp);
			$dateTime->SetTimeZone(new DateTimeZone('UTC'));

		   	// Pour chaque langue acceptée.
		   	while (list($i, $langage) = each($langagesAcceptes))
			{
			   	$coeff = 1 - (0.1 * intval($i));
		   		$pos = stripos($langage, ';');
		   		if ($pos !== false)
		   			$langage = substr($langage, 0, $pos);

		   		$langage = strtolower($langage);

				if (array_key_exists($langage, $languageTimeZones))
				{
				   	$fuseaux = $languageTimeZones[$langage];
				   	// Pour chaque fuseaux de la langue.
				   	while (list($i, $fuseau) = each($fuseaux))
				   	{
				   	   	$dateTimeZone = new DateTimeZone($fuseau);

				   	    // Si le décalage horaire est le même que celui passé en argument.
				   	   	if ($dateTimeZone->GetOffset($dateTime) == $decalage)
				   	   	{
							if (!array_key_exists($fuseau, $scores))
					 		   	$scores[$fuseau] = 0;

					 		// Augmentation du score de probabilité du fuseau.
							$scores[$fuseau] += $coeff;

							// Si le score du fuseau devient le plus grand c'est le nouveau fuseau dominant.
							if ($scoreMax < $scores[$fuseau])
							{
							   	$scoreMax = $scores[$fuseau];
							   	$fuseauHoraire = $fuseau;
							}
						}

						unset($dateTimeZone);
					}
				}
		   	}

			unset($languageTimeZones);

			// Si on n'a pas trouvé un fuseau horaire par l'algo intelligent, on prend le premier qui correspond au décalage.
			if ($fuseauHoraire == 'UTC')
			{
				$fuseaux = timezone_abbreviations_list();
				foreach ($fuseaux as $fuseau)
				{
					foreach ($fuseau as $ville)
					{
						if ($ville['offset'] == $decalage)
						{
							$fuseauHoraire = $ville['timezone_id'];
							return $fuseauHoraire;
						}
					}
				}
			}

		   	return $fuseauHoraire;
		}


	}
}

?>