<?	
error_reporting(E_ALL);	
class whc_index
{
	
	function exec($config)
	{	
		if( isset($_GET["json"]) )
		{
			include_once "whc_json.php";
			$json = new whc_json();
			$json->exec($config);
			exit(0);
		}

		include_once "whc_basepage.php";
		include_once "whc_bbcode.php";
		include_once "whc_tables.php";
			
		include_once "whc_index_open_base.php";
		
			
		//mysql_set_charset("cp1251");
		$find = "";
		$page = 0;
	
		if( isset($_GET["find"]) )
			$find = htmlspecialchars($_GET["find"]);
	
		if( isset($_GET["page"]) )
			$page = htmlspecialchars($_GET["page"]);

		$objs = create_objects();
		
		if(count($objs) == 0)
		{
			echo SORRY_NOT_FOUND_PAGES;
			exit(0);
		};

		$selected_name = "";
		$selected_obj = "";
		$selected_obj_type = "";
		$fisrt_page = "";
		$whc_security = new whc_security();

		foreach ($objs as $name => $obj)
		{
			if(strlen($fisrt_page) == 0)
				$fisrt_page = $name;
			//echo $name."<br>";
			if(isset($_GET[$name]))
			{
				$selected_name = $name;
				$selected_obj = $obj;
				$selected_obj_type = $obj->getType();
				break;
			}
		};
	
		if(strlen($selected_name) == 0)
			refreshTo("index.php?".$fisrt_page);
		
		if($selected_obj_type == "simplepage")
		{	
			include_once "whc_echo_simplepage.php";
			echo_header($objs, $selected_name, $find);
			echo_simplepage($selected_obj);
		}
		else if($selected_obj_type == "report")
		{
			echo_header($objs, $selected_name, $find);
			$selected_obj->printPage();
		}
		else if( isset($_GET["insert"]) )
		{
			if($whc_security->isLogged())
			  $selected_obj->insert();
			
			refreshTo("index.php?".$selected_obj->getName()."=");
			exit(0);
		}
		else if( isset($_GET["update"]) )
		{		   	   
			if($whc_security->isLogged())
			  $selected_obj->update($_GET["update"]);
			refreshTo("index.php?".$selected_obj->getName()."=&view=".
				$_GET["update"]);
			exit(0);
		}
		else if( isset($_GET["delete"]) )
		{
			if($whc_security->isLogged())
			  $selected_obj->delete($_GET["delete"]);
			refreshTo("index.php?".$selected_obj->getName()."=");
			exit(0);
		}
		else if( isset($_GET["view"]) )
		{
			echo_title_page(VIEWER);
			echo_view($selected_obj, $_GET["view"]);
		}	
		else if( isset($_GET["edit"]) )
		{
	      if($whc_security->isLogged())
	      {	
			  echo_title_page(EDITOR);
			  echo_edit($selected_obj, $_GET["edit"]);
			}
			else
			{
				echo_title_page(VIEWER);
				echo_view($selected_obj, $_GET["view"]);
			}
		}	
		else
		{	
			echo_header($objs, $selected_name, $find);
	
			if($selected_obj->getType() == "sqltable")
			{
				echo_find($objs, $selected_name, $find);
				echo_tabl($selected_obj, $find, $page);
				
				if($whc_security->isLogged())
					echo_addform($selected_obj);
			}
	/*
			echo_header($objs, $selected_name, $find);
			echo_tabl($selected_obj, $find, $page);
			echo_addform($selected_obj);
	*/
		}

		include "whc_index_close_base.php";
	}
}
?>
