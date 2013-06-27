<?
	include "basepage.php";	
	include "config.php";
	include "bbcode.php";

	$db = mysql_connect( $db_host, $db_username, $db_userpass);
	mysql_select_db( $db_namedb, $db);
	mysql_set_charset("cp1251");


	$query = "
		SELECT *  FROM list_films";



	$result = mysql_query( $query );

	for( $i = 0; $i < mysql_num_rows($result); $i++ )
	{
		$id_film = mysql_result($result, $i, "id_film");
		$name_orig = mysql_result($result, $i, "name_orig");
		$name_ru = mysql_result($result, $i, "name_ru");
		$film_year = mysql_result($result, $i, "film_year");
		$creater = mysql_result($result, $i, "creater");
		$film_time = mysql_result($result, $i, "film_time");
		$ganre = mysql_result($result, $i, "ganre");
		
		$access_date = $film_time;
		$date_elements  = explode(":",$access_date);
		
		$good = "ok";
		
		if( !is_numeric( $film_year ) ) $good = "bad";

		if( count( $date_elements ) < 3 ) $good = "bad";
		
		if( $good == "ok" )
		{
			if( !is_numeric( $date_elements[0] ) ) $good = "bad";
			if( !is_numeric( $date_elements[1] ) ) $good = "bad";
			if( !is_numeric( $date_elements[2] ) ) $good = "bad";	
		};
		
		if( $good == "ok" )
		{			
			$time_zero = mktime($date_elements[0],$date_elements[1],$date_elements[2],0,0,0) - mktime(0,0,0,0,0,0);	
			$film_time = round($time_zero / 60);

			$titre = 10 + (rand(1,20) - 5 ) ;
			echo "
№: $id_film\r\n<br>
Назва: $name_orig / $name_ru\r\n<br>
Рік: $film_year\r\n<br>
Режисер: $creater\r\n<br>
Жанр: $ganre\r\n<br>
Тривалість фільма: $film_time\r\n<br>
Тривалість титрів: $titre\r\n<br>
Тривалість фільма без титрів: ".($film_time - $titre)."\r\n<br><br>";
		};
	}
?>
