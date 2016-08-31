<?php
	
	include "/../../../../wp-load.php";
		
	if ( isset($_POST['form_id']) )
	{
		ezy_manual_clear_temp_data( $_POST['form_id'] );
	}
	
?>