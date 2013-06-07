<? error_reporting(E_ALL); ?>
<?	
	include_once "config.php";
   class log_of_offense
   {
      function createSQL($find, $count = false)
      {
		   $fields = "*";
		   if($count)
			   $fields = "COUNT(*) as count_rec";
			else $fields = "*, 
				t1.fio as fio_stsm, 
				t2.fio as fio_personal, 
				t3.type as str_type_of_offense";
			
         return "select ".$fields." from log_of_offenses t0
            inner join personal t1 on t1.id = t0.id_stsm
            inner join personal t2 on t2.id = t0.id_personal
            inner join type_of_offense t3 on t3.id = t0.id_type_of_offense
          where 
            t0.text like '%%".$find."%%'
            or t1.fio like '%%".$find."%%'
            or t2.fio like '%%".$find."%%'
            or t3.type like '%%".$find."%%'
            ";
      }

		function createSQL_View($id)
		{
			return "
			select *,
				t1.fio as fio_stsm, 
				t2.fio as fio_personal, 
				t3.type as str_type_of_offense
			from log_of_offenses t0
            inner join personal t1 on t1.id = t0.id_stsm
            inner join personal t2 on t2.id = t0.id_personal
            inner join type_of_offense t3 on t3.id = t0.id_type_of_offense
          where 
            t0.id = $id
			";
		}
		
		function getName()
		{
			return "log_of_offense";
		}
		
  		function getCaption()
		{
			return LOG_OF_OFFENSES;
		}

		function onClick_Table($id)
      {
      	return "document.location = 'index.php?".$this->getName()."=&view=".$id."';";
      }
                
		function getColumns()
		{
			$arr = array();
			$arr[IDENTIFICATOR] = 'id';
			$arr[DATE_OF_VIOLATION] = 'date';			
			$arr[TYPE_OF_OFFENSE] = 'str_type_of_offense';
			$arr[THE_SENIOR_PERSON_ON_DUTY] = 'fio_stsm';
			$arr[SECURITY_GUARD] = 'fio_personal';         
			// $arr['Текст'] = 'text';
			// $arr['Скан документа:'] = 'scan';
			return $arr;
		}
		
		function getColumns_View()
		{
			$arr = $this->getColumns();
			$arr['<img src="images/1367971109_message.png" height=20px/>'.TEXT_DESCR] = 'text';
			$arr[SCAN_OF_DOCUMENT] = 'scan';
			return $arr;
		}
		
		function echo_view_extended($id)
		{
			include_once "participants_of_criminal.php";
			// include_once "print_tables.php";
			$new_obj = new participants_of_criminal($id);
			echo_tabl($new_obj, $find, -1);
			echo_addform($new_obj);
		}
		
		function createTagSelect($query, $field, $name, $value)
		{
			$ret = "<select name='$name'>";
			$result = mysql_query($query) or die("cann't execute query");
			for( $i = 0; $i < mysql_num_rows($result); $i++ )
			{
				$id = mysql_result($result, $i, "id");
				$type = mysql_result($result, $i, $field);
				$checked = ($value == $type ? "selected" : "");
				$ret .= "<option value=$id $checked>$type</option>";
			};
      		$ret .= "</select>";
			return $ret;
		}
		
		function createInputTag($name, $value = "")
		{
			
			if($name == "str_type_of_offense")
				return $this->createTagSelect("select id,type from type_of_offense", "type", $name, $value);
			if($name == "fio_stsm")
				return $this->createTagSelect("select id, fio from personal where stsm = 1", "fio", $name, $value);
			if($name == "fio_personal")
				return $this->createTagSelect("select id, fio from personal where stsm <> 1", "fio", $name, $value);
			else if($name == "text")
				return "<textarea name='$name' cols='40' rows='3'>$value</textarea><br>";
			else if($name == "scan")			
			{
				$res = "<input type='file' name='$name' value=''/>";
				if(strlen($value) > 0)
				{
					$res .= "<input type='hidden' name='val_$name' value='$value'/>";					
					$res .= "<br/> <img src='$value'/> <br/>";
				};
				return $res;
			}
			else if($name == "date")
			{
				return "<input type='text' name='$name' value='$value' id='datepicker'				
				/> $value";
								
			}	
			else
				return "$value";
		}
		
		function insert()
		{
			if(isset( $_GET['participants_of_criminal']))
			{
				include_once "participants_of_criminal.php";
				$id = $_POST['id_log_of_offenses']; 
				$new_obj = new participants_of_criminal($id);
				$new_obj->insert();
				refreshTo("index.php?".$this->getName()."&view=".$id);
				exit();
			}
			
			
			mysql_set_charset("utf8");
			$id_type_of_offense = $_POST['str_type_of_offense'];
			$id_stsm = $_POST['fio_stsm'];
			$id_personal = $_POST['fio_personal'];
			$date = htmlspecialchars($_POST['date']);
			$text = htmlspecialchars($_POST['text']);
			$scan = $_FILES["scan"]["name"];
				
			if( strlen($_FILES["scan"]["name"]) > 0 )
			{
				$filename = uniqid();
			
				$folder = substr($filename, 0, 2);
											
				if( !file_exists("scans/$folder"))
					mkdir( "scans/$folder", 0777 );

				$filename .= ".".pathinfo($_FILES['scan']['name'], PATHINFO_EXTENSION);
				
				// echo "filename = $filename <br>";
								
				$fileto = "scans/$folder/$filename";
				// echo "fileto = $fileto <br>";
				if( copy( $_FILES["scan"]["tmp_name"], $fileto ) )
				{
					$scan = $fileto;
					// echo "scan = $scan <br>";					
				};
			};
		
			//echo "[".$date."]";
			//exit();
			$query = "insert into log_of_offenses(
				`date`, id_type_of_offense, id_stsm, id_personal, text, scan
			)
				values('$date', $id_type_of_offense, $id_stsm, $id_personal, '$text', '$scan')";
			//echo $query;
			//exit(0);
			$result = mysql_query( $query ) or die(CAN_NOT_INSERT.", query = [".$query."]");
		}
	  
		function delete($id)
		{
			if(isset( $_GET['participants_of_criminal']))
			{
				include_once "participants_of_criminal.php";
				$id_log = $_GET['id_log_of_offenses']; 
				$new_obj = new participants_of_criminal($id_log);
				$new_obj->delete($id);
				refreshTo("index.php?".$this->getName()."&view=".$id_log);
				exit();
			}
			
			mysql_set_charset("utf8");
			$query = "delete from log_of_offenses where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_DELETE.", query = [".$query."]");
		}
		
		
		function update($id)
		{
			mysql_set_charset("utf8");
			$id_type_of_offense = $_POST['str_type_of_offense'];
			$id_stsm = $_POST['fio_stsm'];
			$id_personal = $_POST['fio_personal'];
			$date = htmlspecialchars($_POST['date']);
			$text = htmlspecialchars($_POST['text']);
			$scan = htmlspecialchars($_POST['val_scan']);
				
			if( strlen($_FILES["scan"]["name"]) > 0 )
			{
				$filename = uniqid();
			
				$folder = substr($filename, 0, 2);
											
				if( !file_exists("scans/$folder"))
					mkdir( "scans/$folder", 0777 );

				$filename .= ".".pathinfo($_FILES['scan']['name'], PATHINFO_EXTENSION);
				
				// echo "filename = $filename <br>";
								
				$fileto = "scans/$folder/$filename";
				// echo "fileto = $fileto <br>";
				if( copy( $_FILES["scan"]["tmp_name"], $fileto ) )
				{
					$scan = $fileto;
					// echo "scan = $scan <br>";					
				};
			};
		
			//echo "[".$date."]";
			//exit();
			$query = "update log_of_offenses
				set 
					`date` = '$date', 
					id_type_of_offense = $id_type_of_offense, 
					id_stsm = $id_stsm, 
					id_personal = $id_personal, 
					text = '$text', 
					scan = '$scan'
				where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_UPDATE.", query = [".$query."]");
		}
		
		function getColumns_Insert()
		{
			$arr = $this->getColumns();		
			$arr["<img src='images/1367971109_message.png' height=20px/> ".TEXT_DESCR] = 'text';
			$arr[SCAN_OF_DOCUMENT] = 'scan';
			unset($arr[IDENTIFICATOR]);
			return $arr;
		}
		
      function convertToPrintData($name, $data)
      {
      	if($name == 'fio_stsm')
				return "<img src='images/1367971172_user.png' height=20px/>".$data;
      	else if($name == 'fio_personal')
				return "<img src='images/1367971172_user.png' height=20px/>".$data;				
         else if($name == "scan")
            return "<img src='$data'/>"; 

         return $data;
      }
   }
?>
