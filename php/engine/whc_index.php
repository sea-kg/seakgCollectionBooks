<?	
error_reporting(E_ALL);	
class whc_index
{	
	function exec($config)
	{	
		include_once "whc_basepage.php";
		include_once "whc_bbcode.php";
		include_once "whc_tables.php";

		$db = mysql_connect( 
			$config['db']['host'], 
			$config['db']['username'], 
			$config['db']['userpass']
		) 
		or die(
				'could not 
					connecting to mysql: "'
					.$config['db']['host'].'@'.$config['db']['username'].'"'
		);

		mysql_select_db( $config['db']['dbname'], $db) 
			or die('could not select database: "'.$config['db']['dbname'].'"');
			
			
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
		else if( isset($_GET["insert"]) )
		{
			$selected_obj->insert();
			refreshTo("index.php?".$selected_obj->getName()."=");
			exit(0);
		}
		else if( isset($_GET["update"]) )
		{
			$selected_obj->update($_GET["update"]);
			refreshTo("index.php?".$selected_obj->getName()."=&view=".
				$_GET["update"]);
			exit(0);
		}
		else if( isset($_GET["delete"]) )
		{
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
			echo_title_page(EDITOR);
			echo_edit($selected_obj, $_GET["edit"]);
		}	
		else
		{	
			echo_header($objs, $selected_name, $find);
	
			if($selected_obj->getType() == "sqltable")
			{
				echo_find($objs, $selected_name, $find);
				echo_tabl($selected_obj, $find, $page);
				echo_addform($selected_obj);
			}
			else if($selected_obj->getType() == "report")
			{
				echo_filter($selected_obj, $find, $page);
				$selected_obj->printPage();
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
