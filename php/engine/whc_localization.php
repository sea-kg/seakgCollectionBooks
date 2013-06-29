<?
	include_once "whc_base.php";
	
	class whc_localization
	{
		function change()
		{
			if(!isset($_POST['new_lang']))
				return;
			
			$new_lang = $_POST['new_lang'];
				
			include_once "../config.php"	;
			
			$langs = $config["lang"];
			
			foreach($langs as $caption => $value)
				if($caption == $new_lang)
					$_SESSION['lang'] = $new_lang;
		}

		function echo_form_change($config)
		{		
			$comeback = $_SERVER['REQUEST_URI'];
			
			echo "Language: ";		
			$langs = $config['lang'];
			foreach($langs as $caption => $value)
				if($value == $config['current']['lang'])
					$current_lang = $caption;

			echo $current_lang;
			echo "<form 
						method='POST' 
						action='../engine/whc_localization.php?change_language'>
					<table>
						<tr>
							<td>
								<select name='new_lang'>";

				foreach($langs as $caption => $value)
					if($value != $config['current']['lang'])
						echo "<option value='$caption'>$caption</option>";
			
			echo "</select>
							</td>
							<td>
								<input type='hidden' name='comeback' value='$comeback'/>
								<input type='submit' value='Change'/>
							</td>
						</tr>
					</table>
				</form>";	
		}
	}
	
	if(isset($_GET['change_language']))
	{
      $localization = new whc_localization();
		$localization->change();
		if(isset($_POST['comeback']))
			refreshTo($_POST['comeback']);
	};
?>
