<?php
include "D:\inetpub\app\wwwroot\wp-blog-header.php";
global $wpdb;


$leadID = $_GET['lid'];
$userID = get_current_user_id();
if(!is_null($leadID)){
	$leads = $wpdb->get_results( $wpdb->prepare( "DELETE FROM wp_rg_lead WHERE created_by ='".$userID."' AND id='".$leadID."' ")  );
	header( 'Location: https://app.thesmsfacademy.com.au/saved/documents/' ) ;
}
else {
header( 'Location: https://app.thesmsfacademy.com.au/saved/documents/' ) ;
}
		

?>