<? error_reporting(E_ALL); ?>
<?		
   class films
   {          
	function createSQL($find, $count = false)
	{
		$fields = "*";
		if($count)
		  $fields = "COUNT(*) as count_rec";
		return "select ".$fields." from ".$this->getTableName()." t0 
		where 
			t0.name_orig like '%$find%' or
			t0.name_ru like '%$find%' or
			t0.film_year like '%$find%' or
			t0.creater like '%$find%' or
			t0.actors like '%$find%' or
			t0.descript like '%$find%' or
			t0.disk like '%$find%' or
			t0.film_country like '%$find%' or
			t0.ganre like '%$find%'";
	}
		
	function getType()
	{
		return "sqltable"; 
	}

	function createSQL_View($id)
	{
		return "select * from ".$this->getTableName()." t0 where t0.id_film = $id";
	}

	function getCaption()
	{
		return FILMS;
	}

	function getTableName()
	{
		return "list_films"; // $config['db']['prefix_table']."".$this->getName();
	}
     
	function getName()
	{
		return "films";
	}
		
  	function getColumns()
		{
			$arr = array();
			$arr[IDENTIFICATOR] = 'id_film';
			$arr[FILM_DISK] = 'disk';
			$arr[FILM_POSTER] = 'poster';
      	$arr[FILM_NAME] = 'name_orig';
			$arr[FILM_COUNTRY] = 'film_country';
			$arr[FILM_GANRE] = 'ganre';
			$arr[FILM_CREATOR] = 'creater';
			$arr[FILM_YEAR] = 'film_year';
			$arr[FILM_TIME] = 'film_time';
			//$arr[FILM_ACTORS] = 'actors';
			//$arr[FILM_DESCRIPTION] = 'descript';

			return $arr; 
		}

		function createInputTag($name, $value = "", $row)
		{
			$value = htmlentities($value, ENT_QUOTES);
			if($name == 'id_film')
				return "<input type=hidden name='$name' value='$value'/>$value";		
			else if(	$name == 'disk' 
							|| $name == 'name_orig'
							|| $name == 'name_ru'
							|| $name == 'film_country'
							|| $name == 'ganre'
							|| $name == 'creater'
							|| $name == 'film_year'
							|| $name == 'film_time'
				)
				return "<input type='text' name='$name' value='$value'/>";
			else if($name == 'actors' || $name == 'descript')
				return "<textarea name='$name' width='80%' style='margin: 0pt; width: 100%; height: 150px;'>$value</textarea>";
			else if($name == 'poster' )			
			{
				$id_film = $row['id_film'];
				$old_poster = ($value != "" && $id_film != "") ? "<img src='posters/$id_film/$value' height='200px'/>" : "";
				return "
	<input name='$name' value='' size='50%' type='file'/> <br> 
	<input name='poster_name' value='$value' size='50%' type='hidden'/>
	$old_poster 
";
			}
			else
				return I_DONT_KNOW_WHAT_ARE_YOU_WHAT;
		}
		
	function onClick_Table($row)
	{
		return "document.location = 'index.php?".
			$this->getName()."=&view=".$row['id_film']."';";
	}
    

	function getColumns_Insert()
	{
		$arr = array();
		$arr[FILM_DISK] = 'disk';			
		$arr[NAME_ORIG] = 'name_orig';
		$arr[NAME_RU] = 'name_ru';			
		$arr[FILM_COUNTRY] = 'film_country';
		$arr[FILM_GANRE] = 'ganre';
		$arr[FILM_CREATOR] = 'creater';
		$arr[FILM_YEAR] = 'film_year';
		$arr[FILM_TIME] = 'film_time';
		$arr[FILM_ACTORS] = 'actors';
		$arr[FILM_DESCRIPTION] = 'descript';
		// $arr[FILM_POSTER] = 'poster';
		return $arr;
	}

	function echo_view_extended($id)
	{

	}

	function getColumns_View()
	{
		$arr = array();
		$arr[IDENTIFICATOR] = 'id_film';
		$arr = array_merge($arr, $this->getColumns_Insert());	
		$arr[FILM_POSTER] = 'poster';
		return $arr;
	}

    function insert()
    {
			mysql_set_charset("utf8");
      
			$disk = htmlspecialchars($_POST['disk']);
			$name_orig = htmlspecialchars($_POST['name_orig']);
			$name_ru = htmlspecialchars($_POST['name_ru']);
			$film_country = htmlspecialchars($_POST['film_country']);
			$ganre = htmlspecialchars($_POST['ganre']);
			$creater = htmlspecialchars($_POST['creater']);
			$film_year = htmlspecialchars($_POST['film_year']);
			$film_time = htmlspecialchars($_POST['film_time']);
			$actors = htmlspecialchars($_POST['actors']);
			$descript = htmlspecialchars($_POST['descript']);
			// $poster = $this->upload_poster("");
			$table_name = $this->getTableName();

			$query = "insert into $table_name 
				(disk, name_orig, name_ru, film_country, ganre, creater, 
					film_year, film_time, actors, descript, poster) 
				values('$disk', '$name_orig', '$name_ru', '$film_country', 
					'$ganre', '$creater', 
					'$film_year', '$film_time', '$actors', '$descript', '$poster')";
			$result = mysql_query( $query ) or die(CAN_NOT_INSERT.", query = [".$query."]");
    }

		function delete($id)
		{
			mysql_set_charset("utf8");
			$query = "delete from ".$this->getTableName()." where id_film = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_DELETE.", query = [".$query."]");
		}
		
		function update($id)
		{
			mysql_set_charset("utf8");
      
  			$disk = addslashes(htmlspecialchars($_POST['disk']));
			$name_orig = addslashes(htmlspecialchars($_POST['name_orig']));
			$name_ru = addslashes(htmlspecialchars($_POST['name_ru']));
			$film_country = addslashes(htmlspecialchars($_POST['film_country']));
			$ganre = addslashes(htmlspecialchars($_POST['ganre']));
			$creater = addslashes(htmlspecialchars($_POST['creater']));
			$film_year = addslashes(htmlspecialchars($_POST['film_year']));
			$film_time = addslashes(htmlspecialchars($_POST['film_time']));
			$actors = addslashes(htmlspecialchars($_POST['actors']));
			$descript = addslashes(htmlspecialchars($_POST['descript']));
			$poster = addslashes($_POST["poster_name"]);
			$table_name = $this->getTableName();

			$poster = $this->upload_poster($id, $poster);

			$query = "update ".$this->getTableName()." set 
				disk='$disk',
				name_orig='$name_orig',
				name_ru='$name_ru',
				film_country='$film_country',
				ganre='$ganre',
				creater='$creater',
				film_year='$film_year',
				film_time='$film_time',
				actors='$actors',
				descript='$descript',
				poster='$poster'
			where id_film = $id";

			$result = mysql_query( $query ) or die(CAN_NOT_UPDATE.", query = [".$query."]");
		}
		
		function convertToPrintData($name, $data, $row, $type_)
		{
			if($name == 'id_film')
				return $data.')';
			else if($name == 'disk')
				return "<a href='index.php?films=&find=$data'>$data</a>";
			else if($name == 'name_orig')
				return $data.' / '.$row['name_ru'];
			else if($name == 'poster')
			{
				$height = ($type_ == "view") ? "200px" : "40px";
				return '<img 
								src="posters/'.$row['id_film'].'/'.$data.'" 
								height="'.$height.'" />';
			}
			return $data;
		}

		function upload_poster($id_film, $poster_name)
		{
			if( strlen($_FILES["poster"]["name"]) > 0 )
			{
				mkdir( "posters/$id_film", 0777 );

				$fileto = "posters/$id_film/".$_FILES["poster"]["name"];
				if( copy( $_FILES["poster"]["tmp_name"], $fileto ) )
				{
					$poster = $_FILES["poster"]["name"];
					return $poster;
				};
				//exit;
			};
			return $poster_name;
		}
   }
?>
