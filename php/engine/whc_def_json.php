<?
	include_once "whc_obj.php";
	function whc_read_def_json($content)
	{
		$arr_objs = array();
		$json = json_decode($content, true);
				
		echo "start2<br>";
		if(isset($json['objs']))
		{
			echo "objs:<br>";
			$arr = $json['objs'];
			foreach ($arr as $name => $obj) {
				echo "$name<br>";
				$arr_objs[$name] = new whc_obj($name, $obj);
			};
		};
		echo "end<br>";
		return $arr_objs;
	};
?>
