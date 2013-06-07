<? error_reporting(E_ALL); ?>
<?	
	// include_once "config.php";
	
   class personal
   {
		function createSQL($find, $count = false)
		{
			$fields = "*";
			if($count)
			$fields = "COUNT(*) as count_rec";
			return "select ".$fields." from personal t0 where fio like '%%".$find."%%'";
		}
		
		function createSQL_View($id)
		{
			return "select * from personal t0 where id = $id";
		}
      
		function getCaption()
		{
			return PERSONALS;
		}
	   
	   function getName()
		{
			return "personal";
		}
		
		function createInputTag($name, $value = "")
		{
			if($name == 'id')
				return "<input type=hidden name='$name' value='$value'/>$value";		
			else if($name == "fio")
				return "<input type='text' name='$name' value='$value'/>";
			else if($name == "stsm")
			{
				$checked = ($value== '1' ? "checked" : "");
				return "<input type='checkbox' name='$name' $checked/><br>";
			}
			else 
				return I_DONT_KNOW_WHAT_ARE_YOU_WHAT;
		}
		
		function onClick_Table($id)
      {
      	return "document.location = 'index.php?".$this->getName()."=&view=".$id."';";
      }
      
		function getColumns()
		{
			$arr = array();
			$arr[IDENTIFICATOR] = 'id';
			$arr[FULL_NAME] = 'fio';
			$arr[THE_SENIOR_PERSON_ON_DUTY] = 'stsm';
			return $arr; 
		}

		function getColumns_Insert()
		{
			$arr = $this->getColumns();
			unset($arr[IDENTIFICATOR]);
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
      
			$fio = htmlspecialchars($_POST['fio']);
			$stsm = $_POST['stsm'];
			$stsm = ($stsm == "on" ? 1 : 0);
			$query = "insert into personal(fio,stsm) values('$fio', $stsm)";
			$result = mysql_query( $query ) or die(CAN_NOT_INSERT.", query = [".$query."]");
      }

		function delete($id)
		{
			mysql_set_charset("utf8");
			$query = "delete from personal where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_DELETE.", query = [".$query."]");
		}
		
		function update($id)
		{
			mysql_set_charset("utf8");
      
			$fio = htmlspecialchars($_POST['fio']);
			$stsm = $_POST['stsm'];
			$stsm = ($stsm == "on" ? 1 : 0);
			$query = "update personal set fio='$fio', stsm = $stsm where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_UPDATE.", query = [".$query."]");
		}
		
		function convertToPrintData($name, $data)
		{
			if($name == 'fio')
				return "<img src='images/1367971172_user.png' height=20px/>".$data;
			else if($name == 'stsm')
				return ($data == 0 ? YES : NO);
			return $data;
		}
   }
?>
