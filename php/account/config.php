<?
	// ACCOUT
	
	include_once "../config.php";
	
	// configure connection to database
	
	$config['db']['prefix_table'] = 'account_';

	// configure languages
	$file_language = 'language_en.php';
	
	if(file_exists($config['current']['lang']))
		$file_language = $config['current']['lang'];

	include_once $file_language;


	// configure other
	function create_objects()
	{
		$objs = array();
		
		include_once "account.php";
		$account = new account();
		$objs[$account->getName()] = $account;
		return $objs;
	};
?>
