<?
	session_start();

	function refreshTo($new_page)
	{
		header ("Location: $new_page");
		exit;
	};
?>
