<?

	$db_host = "localhost";
	$db_username = "project_security";
	$db_userpass = "project_security";
	$db_namedb = "project_security";	
  $db_prefix_table = "col_book_";	
	
	// include_once "language_en.php";
	include_once "language_ru.php";

	function create_objects()
	{
		$objs = array();
		
		include_once "example_page.php";
		$example_page = new example_page();
		$objs[$example_page->getName()] = $example_page;
				
		return $objs;
	}

?>
