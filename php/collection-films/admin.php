<?	
	include "basepage.php";	
	include "config.php";
	
	if(isset($_GET['logout']) && isset($_SESSION['loginname']))
	{
		unset($_SESSION['loginname']);
		refreshTo("index.php");
	}
	
	if(
		isset($_GET['login']) && 
		!isset($_SESSION['loginname']) &&
		isset($_POST['loginname']) &&
		isset($_POST['loginpass'])
	)
	{
		if(md5($_POST['loginpass']) == "562db78bfca6456db5b890ee95a9616f" && $_POST['loginname'] == "admin")
		{
			$_SESSION['loginname'] = $_POST['loginname'];
			refreshTo("index.php");
		};
	}

	echo "Not correct operation";
?>
