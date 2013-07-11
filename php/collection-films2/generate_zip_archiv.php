<?		
include_once "../engine/whc_base.php";
include_once "../engine/whc_security.php";
include_once "../config.php";

class generate_zip_archiv
{		
	function getType()
	{
		return "report"; 
	}

	function getCaption()
	{
		return "Generate Zip Archiv";
	}
	
	function getName()
	{
		return "generate_zip_archiv";
	}
	
	function printPage()
	{
		echo "
			<br>
			<hr/>
			<form method='GET' action='generate_zip_archiv.php'>
				Filter: <input type='text' name='find'/>
				<input type='submit' value='Generate zip archiv'/>
			</form>
		";
	}  	
}

if(isset($_GET['find']))
{
	$filename = basename($_SERVER['SCRIPT_FILENAME']);	
	if($filename == 'generate_zip_archiv.php')
	{
		include_once "films.php";
		include_once "create_zip.php";
		include_once "../engine/whc_basepage.php";
		
		$find = $_GET['find'];
		
		$films = new films();

		$folder = "zip/".to_file_name($find,"");
		$files_to_zip = array();
		
//		if(file_exists($folder))
//			unlink($folder);
	
		if(!file_exists($folder))
			mkdir($folder);
	
		if(!file_exists($folder))
		{
			echo "directory is not maked. [".$folder."]<br>";
			exit;
		};
		
		$query = $films->createSQL($find);
		// mysql_set_charset("utf8");
					
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
		
			$xml = "";
			$xml .= '<?xml version="1.0" encoding="utf-8" ?>';
			

			$id_film = $row['id_film'];
			$name_ru = $row['name_ru'];
			$film_year = $row['film_year'];
			$poster = $row['poster'];

			$basefilename = to_file_name($name_ru, $film_year);
		
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
					// echo "<a href='$filename_poster'> $filename_poster </a><br>";
					$files_to_zip[] = $filename_poster;
				}
				else
					$filename_poster = "";
			}
			$row['poster'] = basename($filename_poster);

			//var_dump($row);
			
			// write xml
			$xml .= "\n<film>\n";
			foreach ($row as $name => $data) {
				$xml .= "\t<".$name.">".$data."</".$name.">\n";
			};	
			$xml .= "\n</film>\n";
		
			$filename_xml = "$folder/info_$basefilename.xml";

			// echo $xml;
			
			file_put_contents($filename_xml, $xml);
			$files_to_zip[] = $filename_xml;
		}	
		
		$filename_zip = $folder.".zip";

		// exit;
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
	}	
}

?>
