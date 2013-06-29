<?	
	include_once "../engine/whc_index.php";
	include_once "config.php";
	
	$index = new whc_index();
	$index->exec($config);
?>
