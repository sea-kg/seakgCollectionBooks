<? 
	error_reporting(E_ALL); 
	
	function create_objects()
	{
		$objs = array();
		
		include_once "personal.php";
		$objs["personal"] = new personal();
		
		include_once "type_of_offense.php";
		$objs["type_of_offense"] = new type_of_offense();
		
		include_once "criminal.php";
		$objs["criminal"] = new criminal();
		
		include_once "log_of_offense.php";
		$objs["log_of_offense"] = new log_of_offense();
		
		return $objs;
	}

?>
