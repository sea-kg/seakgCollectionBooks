<?
	session_start();
	
	
	function getFromPost($name)
	{
		$m = "";
		if( isset( $_POST[$name] ) ) $m = htmlspecialchars( $_POST[$name] );
		return $m;
	};

	function refreshTo($new_page)
	{
		header ("Location: $new_page");
		exit;
	};
	
	function GetShortAccount()
	{
		if(isset($_SESSION['loginname']))
		{
			return "Hello, ".$_SESSION['loginname']." <a href='admin.php?logout'>logout</a>";
		}
		return "<h6><form action='admin.php?login' method='post'>
			User Name: <input type='name' name='loginname' value=''/>
			User Pass: <input type='password' name='loginpass' value=''/> 
			<input type='submit' value='Login'/> </form></h6>";
	}
	
	function isLogined()
	{
		return isset($_SESSION['loginname']);
	}
	
?>
