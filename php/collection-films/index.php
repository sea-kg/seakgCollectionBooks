
<html>
<head>
<title> collection my films </title>
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
	$find = "";

	if( isset($_GET["find"]) )
	{
		$find = htmlspecialchars($_GET["find"]);
	};


	if( isset( $_POST["addnewfilm"] ) && isLogined() )
	{
		$name_orig = htmlspecialchars(addslashes($_POST["name_orig"]));
		
		$insert = "INSERT INTO list_films( name_orig ) VALUES(\"$name_orig\")";
		
		$result = mysql_query($insert);

		//echo $result;
		
		//exit;
		refreshTo("index.php?find=$find");
	};




	echo "
	collection-films<br>
<br>
<br>
<form action='index.php' method='GET'>
<table>
	<tr>
		<td>Find:</td>
		<td><input type='text' name='find' value='$find' size=100/></td>
		<td><input type='submit' value='FIND'/></td>
	</tr>

</table>
</form>
<br> ";


if(isLogined())
{
	echo "
<!-- print form for adding film -->

<form action='index.php' method='post'>
	<table>
	<tr>
		<td>Original name:</td>
		<td><input type='text' name='name_orig' value=''/></td>
		<td><input type='submit' name='addnewfilm' value='Add NEW FILM'/> or <a href='execute_sql.php'> execute sql</a> </td>
	</tr>
</table>
</form>
";

};

	$query = createQueryForFind($find, true);

	$result = mysql_query( $query );
	$count_all_films = mysql_result($result, 0, "count_films");;

	$page = 0;
	if( isset($_GET['page']) ) $page = $_GET['page'];

//	echo "[page: ".$page."]";

	$start_record = $page * 10;
	$end_record = 10;
//	echo "[start: $start_record count: $end_record ]";

	$query = createQueryForFind($find)." ORDER BY id_film DESC LIMIT $start_record,$end_record;";



	$result = mysql_query( $query );
	
	$color = "";
	$color1 = "#adffb9";
	$color2 = "#fff6ad";

	echo "
	<hr>
	find films ($count_all_films); pages:
	";

	$count_pages = $count_all_films / 10;

	for( $i = 0; $i < $count_pages; $i++)
	{
		if( $page == $i )
			echo "<font size=5>(".($i+1).")</font>, ";
		else
			echo "<a href='index.php?page=".$i."&find=$find'>(".($i+1).")</a>, ";
	};

	echo "

	<hr>
	<table cellspacing='0' cellpadding='10' >";

	echo "
	<tr bgcolor='$color'>
		<td> id </td>
		<td> disk </td>
		<td> poster </td>
		<td> name </td>
		<td> country </td>		
		<td> ganre </td>
		<td> creator </td>
		<td> year </td>
		<td> time </td>
	</tr>";
	
	for( $i = 0; $i < mysql_num_rows($result); $i++ )
	{
		$id_film = mysql_result($result, $i, "id_film");
		$name_orig = mysql_result($result, $i, "name_orig");
		$name_ru = mysql_result($result, $i, "name_ru");
		$film_year = mysql_result($result, $i, "film_year");
		$creater = mysql_result($result, $i, "creater");
		//$actors = mysql_result($result, $i, "actors");
		//$descript = mysql_result($result, $i, "descript");
		$poster = mysql_result($result, $i, "poster");
		$film_time = mysql_result($result, $i, "film_time");
 		$disk = mysql_result($result, $i, "disk");
		$ganre = mysql_result($result, $i, "ganre");
		$film_country = mysql_result($result, $i, "film_country");

		if( $i % 2 == 0 ) $color = $color1; else $color = $color2;

		
		echo "
		<tr bgcolor='$color'>
			<td> $id_film) </td>
			<td> <a href='?find=$disk'>".bbcode_format($disk)."</a> </td>
			<td> <img src='posters/$id_film/$poster' width=50px> </td>
			<td> <a href='film.php?id=$id_film'>$name_orig / $name_ru</a> </td>
			<td> $film_country </td>		
			<td> $ganre </td>
			<td> $creater </td>
			<td> $film_year </td>
			<td> $film_time </td>
			

		</tr>";
	}
	
	echo "</table>";

	echo "<hr/><center><a href='getzip.php?find=$find'>DOWNLOAD ZIP</a></center>";
	echo "<hr/><center><a href='getposter.php?find=$find'>GET POSTER</a></center>";
	
	echo "<table width=100%>
		<tr>
			<td align='right'>
			".GetShortAccount()."
			</td>
		</tr>
	</table>";
?>

</body>
</html>
