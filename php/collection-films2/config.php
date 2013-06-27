<?
	include_once "../config.php";

	// you can reconfigure connection to database if it is need:
	// $config['db']['host'] = "localhost";
	//	$config['db']['username'] = "phpuser";
	//	$config['db']['userpass'] = "phpuser";
	//	$config['db']['namedb'] = "collection_films";
	
	$config['db']['prefix_table'] = 'col_book_';
	
	/* 
		todo move in base functions
		$arr = array();
		$arr['ru'] = 'language_ru.php';
		$arr['en'] = 'language_en.php';
		$arr['de'] = 'language_de.php';
	*/

	$file_language = 'language_ru.php';

	if(isset($_SESSION['lang']))
		$file_language = 'language_'.$_SESSION['lang'].'.php';
	
	include_once $file_language;


	function create_objects()
	{
		$objs = array();
		
		include_once "films.php";
		$films = new films();
		$objs[$films->getName()] = $films;
				
		return $objs;
	};
	

?>
