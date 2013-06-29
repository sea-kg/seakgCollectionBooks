<?	
error_reporting(E_ALL);	

function echo_simplepage($obj)
{
	if($obj->getType() != "simplepage")
		return;
	
	// echo_title_page(CHANGE);	
	// echo_header($objs, $selected_name, $find);
	echo "<hr>";
	
	$obj->echo_page();	
};
?>
