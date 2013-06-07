<? error_reporting(E_ALL); ?>
<?	
   class type_of_offense
   {
      function createSQL($find, $count = false)
      {
		   $fields = "*";
		   if($count)
			   $fields = "COUNT(*) as count_rec";

         return "select ".$fields." from type_of_offense t0 where type like '%%".$find."%%'";    
      }

		function createSQL_View($id)
		{
			return "select * from type_of_offense t0 where id = $id";
		}
		
		function getName()
		{
			return "type_of_offense";
		}
		
  		function getCaption()
		{
			return TYPES_OF_OFFENSE;
		}
		
		function onClick_Table($id)
      {
      	return "document.location = 'index.php?".$this->getName()."=&view=".$id."';";
      }
      		
      function getColumns()
      {
         $arr = array();
         $arr[IDENTIFICATOR] = 'id';
         $arr[TYPE] = 'type';
         return $arr;
      }
      
      function echo_view_extended($id)
		{
		
		}
		
		function getColumns_View()
		{
			return $this->getColumns();
		}
		
      function getColumns_Insert()
      {
      	$arr = $this->getColumns();
      	unset($arr[IDENTIFICATOR]);
      	return $arr;
      }
      
      function createInputTag($name, $value = "")
		{
			if($name == 'id')
				return "<input type=hidden name='$name' value='$value'/>$value";
			else if($name == "type")
				return "<input type='text' name='$name' value='$value'/>";
			else 
				return I_DONT_KNOW_WHAT_ARE_YOU_WHAT;
		}
		
      function insert()
      {
      	//$db = mysql_connect( $db_host, $db_username, $db_userpass);
	   	//mysql_select_db( $db_namedb, $db);
   	   mysql_set_charset("utf8");
      
			$type = htmlspecialchars($_POST['type']);
			$query = "insert into type_of_offense(type) values('$type')";
			$result = mysql_query( $query ) or die(CAN_NOT_INSERT.", query = [".$query."]");		
      }
      
		function delete($id)
		{
			mysql_set_charset("utf8");
			$query = "delete from type_of_offense where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_DELETE.", query = [".$query."]");
		}
      
      function update($id)
		{
			mysql_set_charset("utf8");
      
			$type = htmlspecialchars($_POST['type']);
			$query = "update type_of_offense set type='$type' where id = $id";
			$result = mysql_query( $query ) or die(CAN_NOT_UPDATE.", query = [".$query."]");
		}
		
      function convertToPrintData($name, $data)
      {
         return $data;
      }
   }
?>
