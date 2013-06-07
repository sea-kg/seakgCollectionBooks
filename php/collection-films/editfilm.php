
<html>
<head>
<title> collection my films (film) </title>
<meta http-equiv="Content-Type" content="text/html; charset=windows1251">
</head>
<body>
<center>

<?
	include "basepage.php";	
	include "config.php";

	if(!isLogined())
	{
		refreshTo("index.php");
		exit;
	}
	
	$db = mysql_connect( $db_host, $db_username, $db_userpass);
	mysql_select_db( $db_namedb, $db);
	// mysql_set_charset("cp1251");
	$find = "";

	if( ! isset($_GET["id"]) )
	{
		refreshTo("index.php");
	};

	$id_film = $_GET["id"];
	

	if( isset($_POST["save_film"]) )
	{

		$id_film = addslashes($_POST["id_film"]);
		$name_orig = htmlspecialchars(addslashes($_POST["name_orig"]));
		$name_ru = addslashes($_POST["name_ru"]);
		$film_year = addslashes($_POST["film_year"]);
		$creater = addslashes($_POST["creater"]);
		$actors = addslashes($_POST["actors"]);
		$descript = addslashes($_POST["descript"]);
		$poster = addslashes($_POST["poster_name"]);
		$film_time = addslashes($_POST["film_time"]);
		$disk = addslashes($_POST["disk"]);
		$ganre = addslashes($_POST["ganre"]);
		$film_country = addslashes($_POST["film_country"]);
		
		if( strlen($_FILES["poster"]["name"]) > 0 )
		{
			mkdir( "posters/$id_film", 0777 );

			$fileto = "posters/$id_film/".$_FILES["poster"]["name"];
			if( copy( $_FILES["poster"]["tmp_name"], $fileto ) )
			{
				$poster = $_FILES["poster"]["name"]; 	
			};
			//exit;
		};



		$update = "	UPDATE list_films SET 
					name_orig = \"$name_orig\",
					name_ru = \"$name_ru\",
					film_year = \"$film_year\",
					creater = \"$creater\",
					actors = \"$actors\",
					descript = \"$descript\",
					film_time = \"$film_time\",
					disk = \"$disk\",
					poster = \"$poster\",
					ganre = \"$ganre\",
					film_country = \"$film_country\"
				WHERE id_film = $id_film;";
		
		$result = mysql_query( $update );
		//echo "[".$update."] result".$result;
		
		//echo "<a href='film.php?id=$id_film'>Перейти дальше</a>";
		//exit;
		refreshTo("film.php?id=$id_film");
	};





	echo "<br> <a href = 'index.php'>to list of films</a> | <a href = 'film.php?id=$id_film'>Cancel</a>  ";


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
	<form action='editfilm.php?id=$id_film' method='post' enctype='multipart/form-data'>
	<table cellspacing='0' cellpadding='10' >
		<tr> 
			<td> id: </td> 
			<td> $id_film <input type='hidden' name='id_film' value='$id_film' size=80% /></td> 
		</tr>
		<tr> 
			<td> disk: </td> 
			<td> <input type='text' name='disk' value='$disk' size=80%></td> 
		</tr>
		<tr> 
			<td> name orig: </td> 
			<td> <input type='text' name='name_orig' value='$name_orig' size=80%> </td> 
		</tr>
		<tr> 
			<td> name ru: </td> 
			<td> <input type='text' name='name_ru' value='$name_ru' size=80%> </td> 
		</tr>
		<tr> 
			<td> film country: </td> 
			<td> <input type='text' name='film_country' value='$film_country' size=80%> </td> 	
		</tr>

		<tr> 
			<td> ganre: </td> 
			<td> <input type='text' name='ganre' value='$ganre' size=80%>  </td> 
		</tr>
		<tr> 
			<td> creator: </td> 
			<td> <input type='text' name='creater' value='$creater' size=80%>  </td> 
		</tr>
		<tr> 
			<td> year: </td> 
			<td> <input type='text' name='film_year' value='$film_year' size=80%>  </td> 
		</tr>
		<tr> 
			<td> time: </td> 
			<td> <input type='text' name='film_time' value='$film_time' size=80%>  </td> 
		</tr>
		<tr> 
			<td> poster: </td> 
			<td> <input type='file' name='poster' value='' size=80%> <br> <input type='hidden' name='poster_name' value='$poster' size=80%> </td> 
		</tr>
		<tr> 
			<td valign = 'top'> actors: </td> 
			<td> <textarea name='actors' width=80% style=\"margin: 0pt; width: 100%; height: 150px;\">$actors</textarea></td> 
		</tr>
		<tr> 
			<td valign = 'top'> description: </td> 
			<td> <textarea name='descript' width=80% style=\"margin: 0pt; width: 100%; height: 150px;\">$descript</textarea>  </td> 
		</tr>
		
		<tr> 
			<td> </td> 
			<td> <input type='submit' name='save_film' value='Save' size=80%>  </td> 
		</tr>
	</table>
	</form>
	</td>
</tr>
</table>

";

?>

</body>
</html>
