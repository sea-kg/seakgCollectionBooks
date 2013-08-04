<?
	include_once "config.php";
	$arr = $config['collection'];

	if(isset($_GET['json']))
	{
		// $comeback = $_SERVER['REQUEST_URI'];
		//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$comeback = "http://$_SERVER[HTTP_HOST]/";
		
		$json = array();
		foreach($arr as $caption => $index_php)
		{
			if(file_exists($index_php))
				$json[$caption] = $comeback.$index_php;
		}
		echo json_encode($json);
		exit(0);
	}
  
	foreach($arr as $caption => $index_php)
	{
		if(file_exists($index_php))
			refreshTo($index_php);
//		echo "<a href='$index_php'>".$caption."<br>"	
	}
?>
</body>
</html>
