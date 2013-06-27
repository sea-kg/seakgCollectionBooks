<?	

	function getValue($get, $default_value)
	{
		return (isset($_GET[$get]) == true ? $_GET[$get] : $default_value);
	};
	
	
	$db_host = getValue("db_host", "mysql.hostinger.ru");
	$db_username = getValue("db_username", "u976100563_films");
	$db_userpass = getValue("db_userpass", "");
	$db_namedb = getValue("db_namedb","u976100563_films");
	
	
	echo "
	<form action='testdb.php' method='get'>
		DB Host: <input type='text' name='db_host' value='$db_host'/><br/>
		DB UserName: <input type='text' name='db_username' value='$db_username'/><br/>
		DB UserPass: <input type='text' name='db_userpass' value='$db_userpass'/><br/>
		DB Name:  <input type='text' name='db_namedb' value='$db_namedb'/><br/>
		<input type='submit' value='try connect'/><br/>
	</form>
	";
	
	$db = mysql_connect( $db_host, $db_username, $db_userpass) or die("it not connected to database [ $db_host, $db_username, $db_userpass ] ");
	mysql_select_db( $db_namedb, $db) or die("it not selected database $db_name");
?>
