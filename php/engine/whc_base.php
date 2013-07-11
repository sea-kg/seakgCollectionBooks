<?
	session_start();

	function refreshTo($new_page)
	{
		header ("Location: $new_page");
		exit;
	};
	
	
	function init_database($config)
	{
		$db = mysql_connect( 
			$config['db']['host'], 
			$config['db']['username'], 
			$config['db']['userpass']
		) 
		or die(
				'could not 
					connecting to mysql: "'
					.$config['db']['host'].'@'.$config['db']['username'].'"'
		);

		mysql_select_db( $config['db']['dbname'], $db) 
			or die('could not select database: "'.$config['db']['dbname'].'"');

		mysql_set_charset("utf8");

		return $db;
	};
?>
