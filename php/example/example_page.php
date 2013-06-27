<? error_reporting(E_ALL); ?>
<?		
   class example_page
   {          
		function createSQL($find, $count = false)
		{
			$fields = "*";
			if($count)
			  $fields = "COUNT(*) as count_rec";
			return "select ".$fields." from ".$this->getTableName()." t0 
      where 
        room like '%%".$find."%%' or 
        cupboard like '%%".$find."%%' or
        shelf like '%%".$find."%%'";
		}
		
		function createSQL_View($id)
		{
			return "select * from ".$this->getTableName()." t0 where id = $id";
		}
      
		function getCaption()
		{
			return PLACES;
		}

    function getTableName()
    {
      include "config.php";
      return $db_prefix_table."".$this->getName();
    }
     
	  function getName()
		{
			return "example_page";
		}
		
  	function getColumns()
		{
			$arr = array();
			$arr[IDENTIFICATOR] = 'id';
      $arr[ROOM] = 'room';
			$arr[CUPBOARD] = 'cupboard';
			$arr[SHELF] = 'shelf';
			return $arr; 
		}

		function createInputTag($name, $value = "")
		{
			if($name == 'id')
				return "<input type=hidden name='$name' value='$value'/>$value";		
			else if($name == "room" || $name == "cupboard" || $name = "shelf")
				return "<input type='text' name='$name' value='$value'/>";
			else
				return I_DONT_KNOW_WHAT_ARE_YOU_WHAT;
		}
		
		function onClick_Table($id)
    {
      	return "document.location = 'index.php?".$this->getName()."=&view=".$id."';";
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
      
			$room = htmlspecialchars($_POST['room']);
  		$cupboard = htmlspecialchars($_POST['cupboard']);
  		$shelf = htmlspecialchars($_POST['shelf']);

			$query = "insert into ".$this->getTableName()."(room,cupboard,shelf) values('$room', '$cupboard', '$shelf')";
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
		
		function convertToPrintData($name, $data)
		{
			if($name == 'room')
				return "<img src='images/1371140348_exit.png' height=20px/>".$data;
			else if($name == 'cupboard')
  			return "<img src='images/1371140207_cabinet.png' height=20px/>".$data;
  		else if($name == 'shelf')
  			return "<img src='images/1371140146_shelf.png' height=20px/>".$data;
			return $data;
		}
   }
?>
