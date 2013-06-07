<? error_reporting(E_ALL); ?>
<?
	include_once "basepage.php";
	include_once "config.php";
?>

<html>
<head>
<title> Project Security </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">

	<style type="text/css">
		.notfirst:hover {
			 background-color: red;
		}
	</style>	    	


<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>

<script>
function SetCaretAtEnd(elem) {
        var elemLen = elem.value.length;
        // For IE Only
        if (document.selection) {
            // Set focus
            elem.focus();
            // Use IE Ranges
            var oSel = document.selection.createRange();
            // Reset position to 0 & then set at end
            oSel.moveStart('character', -elemLen);
            oSel.moveStart('character', elemLen);
            oSel.moveEnd('character', 0);
            oSel.select();
        }
        else if (elem.selectionStart || elem.selectionStart == '0') {
            // Firefox/Chrome
            elem.selectionStart = elemLen;
            elem.selectionEnd = elemLen;
            elem.focus();
        } // if
    } // SetCaretAtEnd()
    
  
function ConfirmDelete(url)
{
	
	  if(confirm("<?php echo ARE_YOU_SURE_REMOVE_RECORD; ?>"))
		  	document.location = url;
}
    
</script>
</head>

<!-- body OnLoad="document.form_search.find.focus();" -->
<body OnLoad="SetCaretAtEnd(document.form_search.find); ">

<center>

<?
	include_once "bbcode.php";
	include_once "print_tables.php";
	include_once "create_objects.php";

	$db = mysql_connect( $db_host, $db_username, $db_userpass);
	mysql_select_db( $db_namedb, $db);
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
			break;
		}
	};
	
	if(strlen($selected_name) == 0)
		refreshTo("index.php?".$fisrt_page);
	
	if( isset($_GET["insert"]) )
	{
		$selected_obj->insert();
		refreshTo("index.php?".$selected_obj->getName()."=");
		exit(0);
	}
	
	if( isset($_GET["update"]) )
	{
		$selected_obj->update($_GET["update"]);
		refreshTo("index.php?".$selected_obj->getName()."=&view=".$_GET["update"]);
		exit(0);
	}
   
   if( isset($_GET["delete"]) )
	{
		$selected_obj->delete($_GET["delete"]);
		refreshTo("index.php?".$selected_obj->getName()."=");
		exit(0);
	}
   
	if( isset($_GET["view"]) )
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
		echo_tabl($selected_obj, $find, $page);
		echo_addform($selected_obj);
	}
?>

<script>
$(document).ready(function(){
	$( "#datepicker" ).datepicker();
	var date = $( "#datepicker" ).val();
	$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd 00:00:00" );
	$( "#datepicker" ).datepicker( "setDate", date );
	$( "#datepicker").datepicker("refresh");  
});
</script>
</body>
</html>
