<?
	include_once "whc_base.php";
	include_once "../config.php";
	
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
					
					$privateKey = $this->generatePrivateKey(
						$email, $password
					);

					if($this->checkUser($privateKey))
					{ 
						$query = "
							select 
								id, name, conf 
							from 
								whc_users 
							where 
								private_key = '$privateKey'";
									
						$result = mysql_query( $query );
						$blob = mysql_result($result, 0, 'conf');
						$username = mysql_result($result, 0, 'name');
						$id = mysql_result($result, 0, 'id');

						$_SESSION['user'] = array();
						$_SESSION['user']['username']	= $username;
						$_SESSION['user']['id']	= $id;
						
						if(strlen($blob) != 0 )
						{
							$str1 = base64_decode($blob);
							$_SESSION['user']['conf'] = json_decode($str1);
						};
					};
				}
			}
		}
		
		function logout()
		{			
			if($this->isLogged())
				unset($_SESSION['user']);
		}

		function checkUser($privateKey)
		{
			$query = "select * from whc_users where private_key='$privateKey'";
			$result = mysql_query( $query );
			//  or die("incorrect sql query");
			$rows = mysql_num_rows($result);
			return ($rows == 1);
		}
		
		function checkCurrentUser($privateKey)
		{
			if(!$this->isLogged())
				return false;
			$id = $_SESSION['user']['id'];
			
			$query = "select * from whc_users where private_key='$privateKey' and id = $id";
			$result = mysql_query( $query );
			//  or die("incorrect sql query");
			$rows = mysql_num_rows($result);
			return ($rows == 1);
		}
		
		function isLogged()
		{
			return (isset($_SESSION['user']));
		}
		
		function generatePrivateKey($email, $password)
		{
			return md5($password.strtoupper($email));
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
