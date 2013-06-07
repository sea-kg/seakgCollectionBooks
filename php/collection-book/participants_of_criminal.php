<? error_reporting(E_ALL); ?>
<?	
   class participants_of_criminal
   {
   	function participants_of_criminal($id_log_of_offenses)
   	{
   		$this->id_log_of_offenses = $id_log_of_offenses;
   	}
   	
    	function createSQL($find, $count = false)
      {
		   $fields = "*";
		   if($count)
			   $fields = "COUNT(*) as count_rec";
			else $fields = "*, 
				t1.fio as fio_criminal,
				t1.fof as fof_criminal";
				
         return "select ".$fields." from participants_of_criminal t0
            inner join criminal t1 on t1.id = t0.id_criminal
          where 
          	(t0.resolution like '%%".$find."%%'
            or t1.fio like '%%".$find."%%')
            and id_log_of_offenses = ".$this->id_log_of_offenses;
      }
      
      function onClick_Table($id)
      {
      	return "ConfirmDelete('index.php?".$this->getName()."&id_log_of_offenses=".$this->id_log_of_offenses."&delete=$id');";
      }
      
		function createSQL_View($id)
		{
			return "
			select *,
				t1.fio as fio_criminal
			from participants_of_criminal t0
            inner join criminal t1 on t1.id = t0.id_criminal
          where 
            t0.id = $id
			";
		}
		
		function getName()
		{
			return "log_of_offense=&participants_of_criminal=";
		}
		
  		function getCaption()
		{
			return PARTICIPANTS_OF_CRIMINAL;
		}
          
		function getColumns()
		{
			$arr = array();
			$arr[IDENTIFICATOR] = 'id';
			$arr[CRIMINAL] = 'fio_criminal';
			$arr[OURS] = 'fof_criminal';
			$arr[RESOLUTION] = 'resolution';
			return $arr;
		}
		
		function getColumns_View()
		{
			$arr = $this->getColumns();
			//$arr['Запись в журнале'] = 'id_log_of_offenses';
			return $arr;
		}
		
		function getColumns_Insert()
		{
			$arr = $this->getColumns();
			// $arr['Запись в журнале'] = 'id_log_of_offenses';
			unset($arr[IDENTIFICATOR]);
			unset($arr[OURS]);
			unset($arr[RESOLUTION]);
			return $arr;
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
			
			if($name == "fio_criminal")
			{
				return 
					$this->createTagSelect("select id, fio from criminal", "fio", $name, $value) ."
					<input type='hidden' name='id_log_of_offenses' value='".$this->id_log_of_offenses."'/>";
			}
			else
				return "$value";
		}
		
		function insert()
		{
			mysql_set_charset("utf8");
			$id_criminal = $_POST['fio_criminal'];
			
			$query = "insert into participants_of_criminal(
				id_log_of_offenses, id_criminal
			)
				values(".$this->id_log_of_offenses.", $id_criminal)";
			$result = mysql_query( $query ) or die(CAN_NOT_INSERT.", query = [".$query."]");
		}
	  
		function delete($id)
		{
			mysql_set_charset("utf8");
			$query = "delete from participants_of_criminal where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_DELETE.", query = [".$query."]");
		}
		
		
		function update($id)
		{
		}
		
		
		
      function convertToPrintData($name, $data)
      {
			if($name == 'fio_criminal')
				return "<img src='images/1367971172_user.png' height=20px/>".$data;
         else if($name == "fof_criminal")
            return ($data == 0 ? "Нет" : "<img src='images/1367971099_notification_warning.png' height=20px/> Да" ); 
			else if($name == 'id_log_of_offenses')			
				return "$data";
				
         return $data;
      }
      
      var $id_log_of_offenses;
   }
?>
