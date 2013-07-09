<?
	include_once "whc_base.php";
	
	class whc_security
	{
		function login()
		{
			if(!$this->isLogged())
			{
				if(isset($_POST['email']) && isset($_POST['password']))
				{
					$email = $_POST['email'];
					$password = $_POST['password'];
					
					if($this->checkUser($email, $password))
					{
						$_SESSION['user'] = array();
						$_SESSION['user']['username']	= $email;
					};
				}
			}
		}
		
		function logout()
		{			
			if($this->isLogged())
				unset($_SESSION['user']);
		}

		function checkUser($email, $password)
		{
			return true;
		}
		
		function isLogged()
		{
			return (isset($_SESSION['user']));
		}
		
		function echo_form_login()
		{
			$comeback = $_SERVER['REQUEST_URI'];
			
			if(!$this->isLogged())
			{
				echo "
				<form method='POST' action='../engine/whc_security.php?login'>
					".EMAIL.":<br>
					<input type='text' name='email' size='5' value=''/><br>
					".PASSWORD.":<br>
					<input type='password' name='password' size='5' value=''/> <br>
					<input type='hidden' name='comeback' value='$comeback'/> 
					<input type='submit' value='".LOGIN."'/><br>
				</form>";
			}	
			else
			{
				echo "
					".HELLO.", ".$_SESSION['user']['username']."!<br>
					<br>
					<a href='../account/index.php'>".MYACCOUNT."</a><br>
					<br>
					<form method='POST' action='../engine/whc_security.php?logout'>
						<input type='submit' value='".LOGOUT."'/>
						<input type='hidden' name='comeback' value='$comeback'/>
					</form>					
				";
			};
		}
	}	
	
	if(isset($_GET['login']))
	{
		$security = new whc_security();
		$security->login();
		if(isset($_POST['comeback']))
			refreshTo($_POST['comeback']);
	};
	
	if(isset($_GET['logout']))
	{
		$security = new whc_security();
		$security->logout();
		if(isset($_POST['comeback']))
			refreshTo($_POST['comeback']);
	};
?>
