<? error_reporting(E_ALL); ?>
<?		
class account
{          
	function getType()
	{
		return "simplepage"; 
	}

	function echo_page()
	{
		include_once "../engine/whc_security.php";
		$security = new whc_security();
		
		if(!$security->isLogged())
		{
			$security->echo_form_login();
			return;
		};	
		
		// next time will be getting from database		
		$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
		
		var_dump(json_decode($json)); 
		echo "<br><br>";
		var_dump(json_decode($json, true));
		echo "<br><br>";
		echo json_encode(json_decode($json, true))."<br><br>";

		echo "
			<table>
				<tr>
					<td>
					</td>
				</tr>
			</table>
		";

		//echo "<form>";
		
	}

	function getCaption()
	{
		return GENERAL;
	}

	function getName()
	{
		return "account";
	}
}
?>
