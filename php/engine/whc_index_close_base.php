		</td>
	</tr>
</table>
</center>
<script>
$(document).ready(function(){
	$( "#datepicker" ).datepicker();
	var date = $( "#datepicker" ).val();
	$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd 00:00:00" );
	$( "#datepicker" ).datepicker( "setDate", date );
	$( "#datepicker").datepicker("refresh");  
});
</script>
</body>
</html>
