<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors','On');

	include "create_zip.php";
	include "basepage.php";	
	include "config.php";
	include "bbcode.php";

	$db = mysql_connect( $db_host, $db_username, $db_userpass);
	mysql_select_db( $db_namedb, $db);
	// mysql_set_charset("utf8");
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
	{
		echo "result is null: [".$query."] <br>";
		exit;
	};

	$folder = "zip/".to_file_name($find,"0");
	$files_to_zip = array();
	
	if(!file_exists($folder))
		mkdir($folder);
	
	if(!file_exists($folder))
	{
		echo "directory is not maked. [".$folder."]<br>";
		exit;
	};
	
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


		$basefilename = to_file_name($name_ru, $film_year);
		

		/*echo $folder;
		if(!file_exists($folder) && !mkdir($folder))
		{
			echo "directory is not maked. [".$folder."]";
			exit;
		};*/
			
		$filename_poster = "";

		// copy poster

		$poster_source = "posters/$id_film/$poster";

		if(file_exists($poster_source))
		{
	//		echo "poster_source: ".$poster_source."<br>";
			$path_parts = pathinfo($poster_source);
			$filename_poster = "$folder/poster_$basefilename.".$path_parts['extension'];
			if(copy($poster_source, $filename_poster))
			{
				echo "<a href='$filename_poster'> $filename_poster </a><br>";
				$files_to_zip[] = $filename_poster;
			}
			else
				$filename_poster = "";
		}



		// write xml

		$xml .= "\r\n<film>\r\n
		\t<id_film>$id_film</id_film>
		\t<disk>$disk</disk>
		\t<name_orig>".bbcode_format_real($name_orig)."</name_orig>
		\t<name_ru>$name_ru</name_ru>
		\t<film_year>$film_year</film_year>
		\t<creater>$creater</creater>
		\t<actors>".bbcode_format_real($actors)."</actors>
		\t<descript>".bbcode_format_real($descript)."</descript>
		\t<poster>".basename($filename_poster)."</poster>
		\t<film_time>$film_time</film_time>
		\t<ganre>$ganre</ganre>
		\t<film_country>$film_country</film_country>
		</film>
		";

		$filename_xml = "$folder/info_$basefilename.xml";

		file_put_contents($filename_xml, $xml);
		echo "<a href='$filename_xml'> $filename_xml </a><br>";

		$files_to_zip[] = $filename_xml;
	}

	$filename_zip = $folder.".zip";

	//if true, good; if false, zip creation failed
	if( create_zip($files_to_zip, $filename_zip, true))
	{
		//echo "$filename_zip";

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($filename_zip));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filename_zip));
		ob_clean();
		flush();
		readfile($filename_zip); 
		@unlink($filename_zip);
		
		foreach($files_to_zip as $file) {
			//make sure the file exists
			@unlink($file);
		}
		rmdir($folder);
	}
	else
		echo "not created archive";
?>
