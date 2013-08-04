<?
include_once "../engine/whc_base.php";
include_once "../engine/whc_security.php";
include_once "../config.php";

	class coin
	{          
		function createSQL($find, $count = false)
		{
			$fields = "*";
			if($count)
			  $fields = "COUNT(*) as count_rec";
			return "select ".$fields." from ".$this->getTableName()." t0";/*
			where 
				t0.name_orig like '%$find%' or
				t0.name_ru like '%$find%' or
				t0.film_year like '%$find%' or
				t0.creater like '%$find%' or
				t0.actors like '%$find%' or
				t0.descript like '%$find%' or
				t0.disk like '%$find%' or
				t0.film_country like '%$find%' or
				t0.ganre like '%$find%'";*/
		}
		
		function getType()
		{
			return "sqltable"; 
		}

		function createSQL_View($id)
		{
			return "select * from ".$this->getTableName()." t0 where t0.id = $id";
		}

		function getCaption()
		{
			return COINS;
		}

		function getTableName()
		{
			return "whc_coins"; // $config['db']['prefix_table']."".$this->getName();
		}
		 
		function getName()
		{
			return "coins";
		}
		
		function getColumns()
		{
			$whc_security = new whc_security();
			
			$arr = array();
			$arr[IDENTIFICATOR] = 'id';
			
			//if($whc_security->isLogged())
			
			$arr[COIN_COUNTRY] = 'country';
			$arr[COIN_START_DAY] = 'start_day';
			$arr[COIN_SERIE] = 'serie';
			$arr[COIN_NAME] = 'name';
			$arr[COIN_NOMINAL] = 'nominal';

			// $arr[COIN_AVERS] = 'avers';
			// $arr[COIN_REVERS] = 'revers';
			// $arr[COIN_MATERIAL] = 'material';
			// $arr[COIN_TIRAG] = 'tirag';
			
			// $arr[COIN_CAT_NUMBER] = 'cat_number';
			// $arr[COIN_GRAVER] = 'graver';
			$arr[COIN_MON_DVOR] = 'mon_dvor';
			// $arr[COIN_GURT] = 'gurt';
			// $arr[COIN_KACHESTVO] = 'kachestvo';
			// $arr[COIN_DESCR] = 'descr';

			return $arr; 
		}

		function createInputTag($name, $value = "", $row)
		{
			$value = htmlentities($value, ENT_QUOTES, 'UTF-8');

			if($name == 'id_film')
				return "<input type=hidden name='$name' value='$value'/>$value";		
			else if(	$name == 'country' 
							|| $name == 'start_day'
							|| $name == 'serie'
							|| $name == 'name'
							|| $name == 'nominal'
							|| $name == 'mon_dvor'
							|| $name == 'material'
							|| $name == 'tirag'
							|| $name == 'cat_number'
							|| $name == 'graver'
							|| $name == 'kachestvo'
				)
				return "<input type='text' name='$name' value='$value'/>";
			else if(	$name == 'avers' 
								|| $name == 'revers'
								|| $name == 'gurt'
								|| $name == 'descr'
			)
				return "<textarea name='$name' width='80%' style='margin: 0pt; width: 100%; height: 150px;'>$value</textarea>";
/*			else if($name == 'poster' )			
			{
				$id_film = $row['id_film'];
				$old_poster = ($value != "" && $id_film != "") ? "<img src='posters/$id_film/$value' height='200px'/>" : "";
				return "
	<input name='$name' value='' size='50%' type='file'/> <br> 
	<input name='poster_name' value='$value' size='50%' type='hidden'/>
	$old_poster 
";
			}*/
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
		$whc_security = new whc_security();
		$arr = array();
		

		$arr[COIN_COUNTRY] = 'country';
		$arr[COIN_START_DAY] = 'start_day';
		$arr[COIN_SERIE] = 'serie';
		$arr[COIN_NAME] = 'name';
		$arr[COIN_NOMINAL] = 'nominal';
		$arr[COIN_MON_DVOR] = 'mon_dvor';

		$arr[COIN_AVERS] = 'avers';
		$arr[COIN_REVERS] = 'revers';
		$arr[COIN_MATERIAL] = 'material';
		$arr[COIN_TIRAG] = 'tirag';
			
		$arr[COIN_CAT_NUMBER] = 'cat_number';
		$arr[COIN_GRAVER] = 'graver';
		
		$arr[COIN_GURT] = 'gurt';
		$arr[COIN_KACHESTVO] = 'kachestvo';
		$arr[COIN_DESCR] = 'descr';

		// if($whc_security->isLogged())		
		//   $arr[FILM_DISK] = 'disk';
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



/*
class coin
{          
	function getType()
	{
		return "simplepage"; 
	}

	function echo_page()
	{
		include_once "../engine/whc_security.php";
		$security = new whc_security();
		
		if(!$security->isLogged())
		{
			$security->echo_form_login();
			return;
		};	
		
		// добавить возможно включать и отключать коллекции
		// next time will be getting from database
		$json = file_get_contents("def_account.json");
		
		$id = $_SESSION['user']['id'];
		$query = "
							select 
								id, name, conf 
							from 
								whc_users 
							where 
								id = $id";
								
		$result = mysql_query($query);
		
		$username =mysql_result($result,0,'name');
		$comeback = $_SERVER['REQUEST_URI'];
		
		echo "
			<form	method='POST' action='../account/account.php?change_name'>
				<input type='hidden' name='comeback' value='$comeback'/>
				Your name:
					<input type='text' name='username' value='$username'/>
				<input type='submit' value='Save'/>
			</form>
			<br/>
			<hr/>
";

echo "
			<form	method='POST' action='../account/account.php?change_password'>
				<input type='hidden' name='comeback' value='$comeback'/>
				Current e-mail:
					<input type='text' name='current_email'/>
					<br/>
				Current password:
					<input type='password' name='current_password'/>
					<br/><br/>					
				New password:
					<input type='password' name='new_password'/>
					<br/>
				New password(repeat): 
					<input type='password' name='new_password2'/>
					<br/>
				
				<input type='submit' value='Change password'/>
			</form>
";
	
	}

	function getCaption()
	{
		return GENERAL;
	}

	function getName()
	{
		return "account";
	}
};

if(isset($_GET['change_name']))
{
	$whc_security = new whc_security();
	if($whc_security->isLogged())
	{
		$username = $_POST['username']; 
		$id = $_SESSION['user']['id'];
		$query = "update whc_users set name='$username' where id = $id";
		$result = mysql_query($query);
		if($result == '1')
			$_SESSION['user']['username']	= $username;
	}

	if(isset($_POST['comeback']))
		refreshTo($_POST['comeback']);
};

if(isset($_GET['change_password']))
{
	$whc_security = new whc_security();
	if($whc_security->isLogged())
	{
		$current_email = $_POST['current_email'];
		$current_password = $_POST['current_password'];
		
		$new_password = $_POST['new_password'];
		$new_password2 = $_POST['new_password2'];		
		
		$privateKey_old = $whc_security->generatePrivateKey(
						$current_email, $current_password
					);
					
		$privateKey_new1 = $whc_security->generatePrivateKey(
						$current_email, $new_password
					);
					
		$privateKey_new2 = $whc_security->generatePrivateKey(
						$current_email, $new_password2
					);					
						
		if($privateKey_new1 == $privateKey_new2 
			&& $whc_security->checkCurrentUser($privateKey_old))
		{
			$id = $_SESSION['user']['id'];
			$query = "
			update 
				whc_users 
			set 
				private_key='$privateKey_new1' 
			where 
				id = $id
			";
			$result = mysql_query($query);		
		}
	}

	if(isset($_POST['comeback']))
		refreshTo($_POST['comeback']);
};
	*/
?>
