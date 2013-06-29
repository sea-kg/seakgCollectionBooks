<html>
<head>
<title> <? echo TITLE_SITE; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">

	<style type="text/css">
		.notfirst:hover {
			 background-color: red;
		}
	</style>	    	


<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>

<script>
function SetCaretAtEnd(elem) {
        var elemLen = elem.value.length;
        // For IE Only
        if (document.selection) {
            // Set focus
            elem.focus();
            // Use IE Ranges
            var oSel = document.selection.createRange();
            // Reset position to 0 & then set at end
            oSel.moveStart('character', -elemLen);
            oSel.moveStart('character', elemLen);
            oSel.moveEnd('character', 0);
            oSel.select();
        }
        else if (elem.selectionStart || elem.selectionStart == '0') {
            // Firefox/Chrome
            elem.selectionStart = elemLen;
            elem.selectionEnd = elemLen;
            elem.focus();
        } // if
    } // SetCaretAtEnd()
    
  
function ConfirmDelete(url)
{
	
	  if(confirm("<?php echo ARE_YOU_SURE_REMOVE_RECORD; ?>"))
		  	document.location = url;
}
    
</script>
</head>

<!-- body OnLoad="document.form_search.find.focus();" -->
<body OnLoad="SetCaretAtEnd(document.form_search.find); ">

<? 
	// $bgcolor_1 = '#c5f6c5';
	$bgcolor_border = "bgcolor='#cdcdcd' width=3px height=3px";
//	$bgcolor_2 = '#c5cec5';
	$bgcolor_2 = '#ecece7';
?>
<center>
<table width=100% height=100% cellspacing='0px' cellpadding='5px'>
	<tr>
		<td bgcolor="<? echo $bgcolor_2; ?>" valign='top'>
		<center>
			<img src='../engine/images/logo.png'/>
				<br> <br> <br>
				<hr>
				<? include_once "../config.php"; ?>
				<table cellpadding='10px' cellspacing='2px'>
					<tr>
						<td nowrap>
							<center>
								<? echo YOUR_COLLECTIONS ?> :
							</center>
						</td>
					</tr>

				<?

					$collections = $config['collection'];	
					foreach($collections as $caption => $index_php)
					{
						echo "<tr>
									<td nowrap><center>
						<a href='../$index_php'>".$caption."</a> 
									</center>
									</td>
								</tr>";
					};
				?>
				</table>
			<br/>
			<hr/>
			<?
					// languages
					include_once("whc_localization.php");
					$localization = new whc_localization();
					$localization->echo_form_change($config);

					echo "<hr>";
					// security
					include_once("whc_security.php");			
					$security = new whc_security();
					$security->echo_form_login();			
					
			?>
		</center>	
		</td>
	
		<td <? echo $bgcolor_border; ?> />
		<td width=100% valign='top' bgcolor="<? echo $bgcolor_2; ?>">
			<center>
				<br>

