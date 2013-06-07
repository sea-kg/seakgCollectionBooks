<html>
<head>
<title> website for home collections </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">

</head>

<body>
<center>
website for home collections: <br><br>

<?
	$files = scandir("./");
	
	foreach($files as $file)
	{
		$pos = strpos($file, "collection-");
		if(  $pos !== false && is_dir($file))
			echo "<a href='$file/index.php'>".$file."<br>";
	}
?>
</body>
</html>
