<?php
	
	include "/../../../../wp-load.php";
	
	$msg = '';
	
	$frm_id = $_POST['form_id'];

	if ( isset( $frm_id ) )
	{
		if ( isset( $_POST['gform_save_state_'.$frm_id] ) )
		{
			$msg .= json_encode( $_POST );
			ezy_manual_save_temp_data( $frm_id, $_POST );
		}
	}
?>