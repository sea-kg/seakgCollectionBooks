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
		return "select * from ".$this->getTableName()." t0 where id = $id";
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

		function createInputTag($name, $value = "")
		{
			if($name == 'id_film')
				return "<input type=hidden name='$name' value='$value'/>$value";		
			else if(	$name == 'disk' 
							|| $name == 'name_orig'
							|| $name == 'name_ru'
							/* || $name == 
							|| $name == 
							|| $name == 
							|| $name == 
							|| $name == 
							|| $name == */
				)
				return "<input type='text' name='$name' value='$value'/>";
			else
				return I_DONT_KNOW_WHAT_ARE_YOU_WHAT;
		}
		
	function onClick_Table($id)
	{
		return "document.location = 'index.php?".
			$this->getName()."=&view=".$id."';";
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
		$arr[FILM_POSTER] = 'poster';
		return $arr;
	}

		function echo_view_extended($id)
		{
			
		}
		
		function getColumns_View()
		{
			return $this->getColumns();
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
			$poster = htmlspecialchars($_POST['poster']);
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
			$query = "delete from ".$this->getTableName()." where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_DELETE.", query = [".$query."]");
		}
		
		function update($id)
		{
			mysql_set_charset("utf8");
      
  		$room = htmlspecialchars($_POST['room']);
  		$cupboard = htmlspecialchars($_POST['cupboard']);
  		$shelf = htmlspecialchars($_POST['shelf']);

			$query = "update ".$this->getTableName()." set room='$room', cupboard = '$cupboard', shelf = '$shelf' where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_UPDATE.", query = [".$query."]");
		}
		
		function convertToPrintData($name, $data, $row)
		{
			if($name == 'id_film')
				return $data.')';
			else if($name == 'disk')
				return "<a href='index.php?films=&find=$data'>$data</a>";
			else if($name == 'name_orig')
				return $data.' / '.$row['name_ru'];
			else if($name == 'poster')
				return '<img src="../../collection-films/images/'.$row['id_film'].'/'.$data.'" height=20px/>';

/*
[FILM_DISK] = 'disk';
			$arr[FILM_POSTER] = 'poster';
      	$arr[NAME_ORIG] = 'name_orig';
			$arr[NAME_RU] = 'name_ru';
			$arr[FILM_COUNTRY] = 'film_country';
			$arr[FILM_GANRE] = 'ganre';
			$arr[FILM_CREATOR] = 'creater';
			$arr[FILM_YEAR] = 'film_year';
			$arr[FILM_TIME] = 'film_time';
*/
			

			/*if($name == 'room')
				return "<img src='images/1371140348_exit.png' height=20px/>".$data;
			else if($name == 'cupboard')
  			return "<img src='images/1371140207_cabinet.png' height=20px/>".$data;
  		else if($name == 'shelf')
  			return "<img src='images/1371140146_shelf.png' height=20px/>".$data;
*/
			return $data;
		}
   }
?>
