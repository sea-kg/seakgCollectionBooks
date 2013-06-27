<?
	
	$db_host = "localhost";
	$db_username = "phpuser";
	$db_userpass = "phpuser";
	$db_namedb = "collection_films";


	$db_prefix_table = "col_book_";	
	
	// include_once "language_en.php";
	include_once "language_ru.php";


	function create_objects()
	{
		$objs = array();
		
		include_once "films.php";
		$films = new films();
		$objs[$films->getName()] = $films;
				
		return $objs;
	}


/*
	function createQueryForFind($find, $count = false)
	{
		$fields = "*";
		if($count)
			$fields = "COUNT(*) as count_films";

		return "
		SELECT $fields FROM list_films 
		WHERE
			name_orig like '%$find%' or
			name_ru like '%$find%' or
			film_year like '%$find%' or
			creater like '%$find%' or
			actors like '%$find%' or
			descript like '%$find%' or
			disk like '%$find%' or
			film_country like '%$find%' or
			ganre like '%$find%' ";
	}

	function rus2translit($string)
	{
	    $converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => "'",  'ы' => 'y',   'ъ' => "'",
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
	 
		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
		'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
	    );
	    return strtr($string, $converter);
	}

	function to_file_name($str, $year) 
	{ 
		$str_result = "";
		$symbols = array('0', '1', '2', '3', '4', '5', '6', '7', 
			  '8', '9',     'a', 'b', 'c', 'd', 'e',
			  'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
			  'n',     'o', 'p', 'q', 'r', 's', 't', 
			  'u', 'v', 'w', 'x', 'y', 'z', '_', ' '); 

		$str = strtolower(rus2translit($str)); 
		for ($i = 0; $i < strlen($str); $i++) 
		{ 
			$s = $str[$i]; 
			if (in_array($s, $symbols)) $str_result.= $s;
		} 

		$str_result = trim($str_result);

		$str_result .= "_";
		
		$str_year = "";
		for ($i = 0; $i < strlen($year); $i++) 
		{ 
			$s = $year[$i]; 
			if (in_array($s, $symbols)) $str_year.= $s;
		} 

		$str_result .= trim($str_year);

		while ( strpos($str_result,'  ')!==false )
		{
		   $str_result = str_replace('  ',' ',$str_result);
		}; 


		$str_result = str_replace(' ', '_', $str_result); 


		return $str_result; 
	}
*/
?>
