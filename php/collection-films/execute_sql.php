
<html>
<head>
<title> collection my films </title>
<meta http-equiv="Content-Type" content="text/html; charset=windows1251">
</head>
<body>
<center>

<?
	include "basepage.php";	
	include "config.php";
	include "bbcode.php";

	if(!isLogined())
	{
		refreshTo("index.php");
		exit;
	}
	
	$db = mysql_connect( $db_host, $db_username, $db_userpass);
	mysql_select_db( $db_namedb, $db);
	mysql_set_charset("cp1251");


	$text = "";

	if( isset($_POST['execute_sql']) )
	{
		$text = $_POST['text'];
		$result = mysql_query( $text );
		echo "[".$result."]<br>";
	};

	echo "<br><br>
	Execute SQL:<br><br>
	<form action='execute_sql.php' method='POST' >
		<textarea name='text' style=\"margin: 0pt; width: 80%; height: 150px;\" >$text</textarea><br><br>
		<input type='submit' name='execute_sql' />
	</form>
	
	<a href='index.php'>К списку фильмов</a>
	";
	
	


	

?>

</body>
</html>
