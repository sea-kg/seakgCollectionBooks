<?   
   include_once "basepage.php";	
	include_once "config.php";
	include_once "bbcode.php";
	
   function echo_tabl($obj, $find, $page = 0)
   {      
      $db = mysql_connect( $db_host, $db_username, $db_userpass);
   	mysql_select_db( $db_namedb, $db);
      mysql_set_charset("utf8");
     	
     	$start_record = 0;
		$end_record = 100;
		$result = mysql_query( $obj->createSQL($find, true) );
		$count_all = mysql_result($result, 0, "count_rec");
		   		   
     	if( $page >= 0 )
     	{
		   $start_record = $page * 10;
		   $end_record = 10;
		   //	echo "[start: $start_record count: $end_record ]";
		};
		
	   $query = $obj->createSQL($find)." ORDER BY t0.id DESC LIMIT $start_record,$end_record;";
	 
	   
		echo "<!-- ".$query." -->";
	   $result = mysql_query( $query );
	   
	   $color = "";
	   $color1 = "#adffb9";
	   $color2 = "#fff6ad";

		if( $page >= 0 )
     	{
     	
			echo "
			<hr>
			".FOUND." ($count_all); ".PAGES.":
			";

			$count_pages = $count_all / 10;

			for( $i = 0; $i < $count_pages; $i++)
			{
				if( $page == $i )
					echo "<font size=5>(".($i+1).")</font>, ";
				else
					echo "<a href='index.php?".$obj->getName()."=&find=".$find."&page=".$i."&find=$find'>(".($i+1).")</a>, ";
			};

			echo "
			<hr>  ";
	   }
	   echo "    
	   <table cellspacing='0' cellpadding='10' >";
		
		
      $arr = $obj->getColumns();
      
      echo "
      <tr bgcolor='$color'>";
      
      foreach ($arr as $caption => $name) {
         echo "<td>".$caption."</td>\r\n";
      };
	
      for( $i = 0; $i < mysql_num_rows($result); $i++ )
      {
	      if( $i % 2 == 0 ) $color = $color1; else $color = $color2;
         $id = mysql_result($result, $i, "id");
         /*echo "
	      <tr class='notfirst' onclick=\"document.location = 'index.php?".$obj->getName()."=&view=".$id."';\" bgcolor='$color'>\r\n";*/
         echo "
	      <tr class='notfirst' onclick=\"".$obj->onClick_Table($id)."\" bgcolor='$color'>\r\n";	      
	      foreach ($arr as $caption => $name) {
	         $data = mysql_result($result, $i, $name);
	         $data = $obj->convertToPrintData($name, $data);
            echo "<td><center>".$data."</center></td>\r\n";
         };          
	      echo "</tr>\r\n";
      }
      
      echo "</table><br/>";

      if($count_all == 0 )
			echo NOT_FOUND_RECORDS."<br><br>";
   }
   
   function echo_addform($obj, $find)
   {
  	
   	$arr = $obj->getColumns_Insert();
  	
   	echo "<br/><hr/><br/>
      <form action='index.php?".$obj->getName()."=&insert=&find=".$find."' name='insert_".$obj->getName()."' method='POST' enctype='multipart/form-data'>
      <input type='hidden' name='".$name."' value=''/>
      <table width='50%'>";
      // var_dump($arr);
      
      foreach ($arr as $caption => $name) {
      	echo "
	      <tr> 
		      <td align='right' width=50%>".$caption."</td>
		      <td align='left' width=50%>".$obj->createInputTag($name, "")."</td>
	      </tr>
	      	";           
         };      
      echo "</tr>\r\n";
     
      echo "	      
	      <tr>
		      <td colspan=2><br><center><input type='submit' value='".INSERT_RECORD."'/></center></td>
	      </tr>	      

      </table>
      </form>";
   }
   
   
   function echo_view($obj, $id)
   {      
      $db = mysql_connect( $db_host, $db_username, $db_userpass);
   	mysql_select_db( $db_namedb, $db);
      mysql_set_charset("utf8");
      	      
		$query = $obj->createSQL_View($id);
		echo "<!-- ".$query." -->";
				
      $result = mysql_query( $query ) or die(INCORRECT_SQL_QUERY." = [".$query."]");
		  
		$back = "<a href='index.php?".$obj->getName()."'><img src='images/1367972162_go-next-rtl.png' height=20px/></a>";
		$rows = mysql_num_rows($result);
		if($rows == 0)
		{
			echo NOT_FOUND_RECORD_IN_DATABASE."<br>".$back;
			return;
		}
		if($rows > 1)
		{
			echo FOUND_MORE_THAT_ONE."<br>".$back;
			return;
		}
		$arr = $obj->getColumns_View();
		  
		echo "
		<table>
			<tr>
				<td>
					".$back."
				</td>
				<td> | </td>
				<td>
					<a onClick=\"ConfirmDelete('"."index.php?".$obj->getName()."=&delete=$id"."');\"><img src='images/1367970998_file_delete.png' width=20px/></a> 
				</td>
				<td> | </td>				
				<td>
					<a href='index.php?".$obj->getName()."=&edit=$id'><img src='images/1367971059_file_edit.png' width=20px/></a>
				</td>
			</tr>
		</table>";
		
      echo "
      <hr>      
      <table cellspacing='0' cellpadding='10' >";      
      foreach ($arr as $caption => $name) {
	         
	         $data = mysql_result($result, 0, $name);
	         $data = $obj->convertToPrintData($name, $data);
				echo "
					<tr bgcolor='$color'>
				   	<td valign='top'>".$caption."</td>
				   	<td valign='top'>".$data."</td>
				   </tr>";
      };	     
      echo "</table><br/><hr/>";
      
      
      $obj->echo_view_extended($id);
      
   }
   
   function echo_edit($obj, $id)
   {
      $db = mysql_connect( $db_host, $db_username, $db_userpass);
   	mysql_select_db( $db_namedb, $db);
      mysql_set_charset("utf8");
      	      
		$query = $obj->createSQL_View($id);
		echo "<!-- ".$query." -->";
				
      $result = mysql_query( $query ) or die(INCORRECT_SQL_QUERY." = ".$query);
		  
		$rows = mysql_num_rows($result);
		if($rows == 0)
		{
			echo NOT_FOUND_RECORDS_IN_DATABASE."<br>";
			return;
		}
		if($rows > 1)
		{
			echo FOUND_MORE_THAT_ONE."<br>";
			return;
		}
		$arr = $obj->getColumns_View();
		  
		  
		echo "
		<table>
			<tr>
				<td>
					<a href='index.php?".$obj->getName()."&view=$id'><img src='images/1367972162_go-next-rtl.png' height=20px/></a> 
				</td>
			</tr>
		</table>";
		
      echo "
      <hr>
      <form action='index.php?".$obj->getName()."=&update=$id' id='update_' method='POST' enctype='multipart/form-data'>
      
      <table cellspacing='0' cellpadding='10' >";
      foreach ($arr as $caption => $name) {
	         
	         $data = mysql_result($result, 0, $name);
//	         $data = $obj->convertToPrintData($name, $data);
				echo "
					<tr bgcolor='$color'>
				   	<td valign='top'>".$caption."</td>
				   	<td valign='top'>".$obj->createInputTag($name, $data)."</td>
				   </tr>";
      };	     
      echo "</table>
      <input type='submit' value='".UPDATE_DATA."'/>
      </form>
      <hr/>";
   }
   
   function echo_title_page($name = "")
   {
	   echo "Project Security";
   	if($name != "")
   		echo " (".$name.")";
   	
   	echo "<br/><br/>";
   
   }
   
   function echo_header($objs, $name, $find)
	{	
		echo_title_page(SEARCH);
	   echo "| ";	   
	   foreach ($objs as $name1 => $obj)
		{
			//echo $name."<br>";
			if($name1 != $name)
				echo "<a href='index.php?".$name1."'>".$obj->getCaption()."</a> | ";
			else
				echo $obj->getCaption()." | ";
		};
 
      echo "<br>
      <br>
      <form action='index.php' name='form_search' method='GET'>
      <input type='hidden' name='".$name."' value=''/>
      <table>
	      <tr>
		      <td>".FIND.":</td>
		      <td><input type='text' name='find' value='$find' size=100/></td>
		      <td><input type='submit' value='".FIND."'/></td>
	      </tr>

      </table>
      </form>";
	};
?>
