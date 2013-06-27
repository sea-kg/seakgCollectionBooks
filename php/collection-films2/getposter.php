<html>
<head>
<title> collection my films </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
</head>
<body>

<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors','On');

	include "create_zip.php";
	include "basepage.php";	
	include "config.php";
	include "bbcode.php";

	$db = mysql_connect( $db_host, $db_username, $db_userpass);
	mysql_select_db( $db_namedb, $db);
	mysql_set_charset("utf8");
	$find = "";

	if( ! isset($_GET["find"]) )
	{
		refreshTo("index.php");
	};

	$find = $_GET["find"];

	if(count($find) == 0)
	{
		
	}

	$query = createQueryForFind($find);	
	$result = mysql_query( $query );

	if( mysql_num_rows($result) == 0)
		exit;

	$simple_list = "";


	echo "<b>$find ----------------------------------------------------------------------------</b><br>";

	for($i = 0; $i < mysql_num_rows($result); $i++)
	{
		$xml = "";
		$xml .= chr(60).chr(63).'xml version="1.0" encoding="utf-8" '.chr(63).chr(62);

		$id_film = mysql_result($result, $i, "id_film");
		$name_orig = mysql_result($result, $i, "name_orig");
		$name_ru = mysql_result($result, $i, "name_ru");
		$film_year = mysql_result($result, $i, "film_year");
		$creater = mysql_result($result, $i, "creater");
		$actors = mysql_result($result, $i, "actors");
		$descript = mysql_result($result, $i, "descript");
		$poster = mysql_result($result, $i, "poster");
		$film_time = mysql_result($result, $i, "film_time");
		$disk = mysql_result($result, $i, "disk");
		$ganre = mysql_result($result, $i, "ganre");
		$film_country = mysql_result($result, $i, "film_country");


		
		echo "<b>$name_ru / $name_orig;</b> $film_year; Прод: $film_time; Реж: $creater; Жанр: $ganre; <br>";
		$simple_list .= "$name_ru<br>";
	}

	echo "<br><br>$simple_list";
?>

</body>
