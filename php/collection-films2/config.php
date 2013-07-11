<?
	// COLLECTION FILMS
	
	include_once "../config.php";

	// configure connection to database
	
	$config['db']['prefix_table'] = 'col_films_';
	
	// configure languages
	$file_language = 'language_en.php';
	
	if(file_exists($config['current']['lang']))
		$file_language = $config['current']['lang'];

	include_once $file_language;

	// configure other
	function create_objects()
	{
		$objs = array();
		
		include_once "films.php";
		$films = new films();
		$objs[$films->getName()] = $films;
				
		include_once "generate_zip_archiv.php";
		$zip = new generate_zip_archiv();
		$objs[$zip->getName()] = $zip;
		
		return $objs;
	};
?>
