<?
	// COINS
	
	include_once "../config.php";
	
	// configure connection to database
	
	$config['db']['prefix_table'] = 'coins_';

	// configure languages
	$file_language = 'language_en.php';
	
	if(file_exists($config['current']['lang']))
		$file_language = $config['current']['lang'];

	include_once $file_language;

	// configure other
	function create_objects()
	{
		$objs = array();
		
		$content = file_get_contents("def.json");
		echo "<hr>";
		return whc_read_def_json($content);
	};
?>
