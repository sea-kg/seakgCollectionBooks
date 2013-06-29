<html>
<head>
<title> website for home collections </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">

</head>

<body>
<center>
website for home collections: <br><br>

<?
	include_once "config.php";
	$arr = getItems();	
	foreach($arr as $caption => $index_php)
	{
		if(file_exists($index_php))
			refreshTo($index_php);
//		echo "<a href='$index_php'>".$caption."<br>"	
	}
?>
</body>
</html>
