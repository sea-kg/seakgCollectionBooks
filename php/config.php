<?
	include_once "engine/whc_base.php";

	function getItems()
	{
		$arr = array();
		$arr["My Books"] = "collection-book/index.php";
		$arr["My Films Old"] = "collection-films/index.php";
		$arr["My Films New"] = "collection-films2/index.php";
		$arr["Example"] = "example/index.php";
		return $arr;
	};

	$config = array();
	$config['db']['host'] = "localhost";
	$config['db']['username'] = "phpuser";
	$config['db']['userpass'] = "phpuser";
	$config['db']['dbname'] = "collection_films";

	echo 'db.host: '.$config['db']['host'].'<br>';

?>
