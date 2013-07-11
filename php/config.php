<?
	include_once "engine/whc_base.php";

	// configure list of collections
	$config = array();
	$config['collection']["My Films New"] = "collection-films2/index.php";
	$config['collection']["My Books"] = "collection-book/index.php";
	$config['collection']["My Films Old"] = "collection-films/index.php";
	$config['collection']["Example"] = "example/index.php";

	// configure for connection to database
	
	$config['db'] = array();
	$config['db']['host'] = "localhost";
	$config['db']['username'] = "phpuser";
	$config['db']['userpass'] = "phpuser";
	$config['db']['dbname'] = "whc_database";	

	$config['db']['link'] = init_database($config);
	
	// configure languages
	$config['lang'] = array();	
	$config['lang']['Русский'] = 'language_ru.php';
	$config['lang']['English'] = 'language_en.php';
	$config['lang']['Deutsch'] = 'language_de.php';
	$config['default']['lang'] = $config['lang']['English'];
	
	if(isset($_SESSION['lang']))
	{
		$lang = $_SESSION['lang'];
		
		if(isset($config['lang'][$lang]))
			$config['current']['lang'] = $config['lang'][$lang];
		else
			$config['current']['lang'] = $config['default']['lang'];
	}
	else
		$config['current']['lang'] = $config['default']['lang'];

	$file_language = 'localization/'.$config['current']['lang'];
	include_once $file_language;
	
	// other configuration
	
	
?>
