
<html>
<head>
<title> collection my films (film) </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
</head>
<body>
<center>

<?
	include "basepage.php";	
	include "config.php";
	include "bbcode.php";

	$db = mysql_connect( $db_host, $db_username, $db_userpass);
	mysql_select_db( $db_namedb, $db);
	// mysql_set_charset("utf8");
	// mysql_set_charset("cp1251");
	$find = "";

	if( ! isset($_GET["id"]) )
	{
		refreshTo("index.php");
	};

	$id_film = $_GET["id"];
	
	echo "<br> <a href = 'index.php'>К списку фильмов</a> ";
	
	if(isLogined())
		echo "| <a href = 'editfilm.php?id=$id_film' >Редактировать информацию о фильме</a> ";
	


	$query = " SELECT * FROM list_films WHERE id_film = $id_film;";
	$result = mysql_query( $query );

	$id_film = mysql_result($result, 0, "id_film");
	$name_orig = mysql_result($result, 0, "name_orig");
	$name_ru = mysql_result($result, 0, "name_ru");
	$film_year = mysql_result($result, 0, "film_year");
	$creater = mysql_result($result, 0, "creater");
	$actors = mysql_result($result, 0, "actors");
	$descript = mysql_result($result, 0, "descript");
	$poster = mysql_result($result, 0, "poster");
	$film_time = mysql_result($result, 0, "film_time");
	$disk = mysql_result($result, 0, "disk");
	$ganre = mysql_result($result, 0, "ganre");
	$film_country = mysql_result($result, 0, "film_country");

	
	echo "<hr>
<table width='100%'>
<tr>
	<td width='30%' valign = 'top'> 
		<img width=250px src='posters/$id_film/$poster'/> 
	
	</td>

	<td width='70%' valign = 'top'>
	<table cellspacing='0' cellpadding='10'>
		<tr> 
			<td> id: </td> 
			<td> ".bbcode_format($id_film)." </td> 
		</tr>
		<tr> 
			<td> Диск: </td> 
			<td> ".bbcode_format($disk)." </td> 
		</tr>
		<tr> 
			<td> Название: </td> 
			<td> ".bbcode_format($name_orig." / ".$name_ru)." </td> 
		</tr>
		<tr> 
			<td> Страна: </td> 
			<td> ".bbcode_format($film_country)." </td> 	
		</tr>
		<tr> 
			<td> Жанр: </td> 
			<td> ".bbcode_format($ganre)." </td> 
		</tr>
		<tr> 
			<td> Режисер: </td> 
			<td> ".bbcode_format($creater)." </td> 
		</tr>
		<tr> 
			<td> Год выпуска: </td> 
			<td> ".bbcode_format($film_year)." </td> 
		</tr>
		<tr> 
			<td> Продолжительность: </td> 
			<td> ".bbcode_format($film_time)." </td> 
		</tr>
		<tr> 
			<td valign = 'top' > В фильме снимались: </td> 
			<td> ".bbcode_format($actors)." </td> 
		</tr>
		<tr> 
			<td valign = 'top'> Сюжет: </td> 
			<td> ".bbcode_format($descript)." </td> 
		</tr>
	</table>
	</td>
</tr>
</table>
";

?>

</body>
</html>
