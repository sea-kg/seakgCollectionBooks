<?
include_once "../engine/whc_base.php";
include_once "../engine/whc_security.php";
include_once "../config.php";

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
		
		// добавить возможно включать и отключать коллекции
		// next time will be getting from database
		$json = file_get_contents("def_account.json");
		
		$id = $_SESSION['user']['id'];
		$query = "
							select 
								id, name, conf 
							from 
								whc_users 
							where 
								id = $id";
								
		$result = mysql_query($query);
		
		$username =mysql_result($result,0,'name');
		$comeback = $_SERVER['REQUEST_URI'];
		
		echo "
			<form	method='POST' action='../account/account.php?change_name'>
				<input type='hidden' name='comeback' value='$comeback'/>
				Your name:
					<input type='text' name='username' value='$username'/>
				<input type='submit' value='Save'/>
			</form>
			<br/>
			<hr/>
";

echo "
			<form	method='POST' action='../account/account.php?change_password'>
				<input type='hidden' name='comeback' value='$comeback'/>
				Current e-mail:
					<input type='text' name='current_email'/>
					<br/>
				Current password:
					<input type='password' name='current_password'/>
					<br/><br/>					
				New password:
					<input type='password' name='new_password'/>
					<br/>
				New password(repeat): 
					<input type='password' name='new_password2'/>
					<br/>
				
				<input type='submit' value='Change password'/>
			</form>
";
	
	}

	function getCaption()
	{
		return GENERAL;
	}

	function getName()
	{
		return "account";
	}
};

if(isset($_GET['change_name']))
{
	$whc_security = new whc_security();
	if($whc_security->isLogged())
	{
		$username = $_POST['username']; 
		$id = $_SESSION['user']['id'];
		$query = "update whc_users set name='$username' where id = $id";
		$result = mysql_query($query);
		if($result == '1')
			$_SESSION['user']['username']	= $username;
	}

	if(isset($_POST['comeback']))
		refreshTo($_POST['comeback']);
};

if(isset($_GET['change_password']))
{
	$whc_security = new whc_security();
	if($whc_security->isLogged())
	{
		$current_email = $_POST['current_email'];
		$current_password = $_POST['current_password'];
		
		$new_password = $_POST['new_password'];
		$new_password2 = $_POST['new_password2'];		
		
		$privateKey_old = $whc_security->generatePrivateKey(
						$current_email, $current_password
					);
					
		$privateKey_new1 = $whc_security->generatePrivateKey(
						$current_email, $new_password
					);
					
		$privateKey_new2 = $whc_security->generatePrivateKey(
						$current_email, $new_password2
					);					
						
		if($privateKey_new1 == $privateKey_new2 
			&& $whc_security->checkCurrentUser($privateKey_old))
		{
			$id = $_SESSION['user']['id'];
			$query = "
			update 
				whc_users 
			set 
				private_key='$privateKey_new1' 
			where 
				id = $id
			";
			$result = mysql_query($query);		
		}
	}

	if(isset($_POST['comeback']))
		refreshTo($_POST['comeback']);
};
	
?>
