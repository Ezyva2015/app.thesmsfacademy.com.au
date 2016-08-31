<?php /* Template Name: BGL360 Import Members*/ echo "<div style='display:none'>";

	require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

	//echo $_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php' . '<br>';
	//$postManToken = '93e27fae-9973-848a-d983-6cc07657c14d';
	//$grant_type = 'authorization_code';
	//$code = (!empty($_GET['code'])) ? $_GET['code'] : 'Y3K3mI';
	//$scope = 'investment';
	//$clientId = '5dbf9b2c-981f-44e4-8212-d3b5c74795a1';
	//$clientSecret = 'b5a0ff39-ef93-4bc7-b5de-e0ace2d7a6fc';
	//$redirectUril = 'https://app.thesmsfacademy.com.au/wp-content/bgl360/index.php';
	//$getAccessToken = "https://api-staging.bgl360.com.au/oauth/token?grant_type=$grant_type&code=$code&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";
	//
	//$curlPostUri    = "https://api-staging.bgl360.com.au/oauth/token?grant_type=$grant_type&code=$code&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";
	//$curlPostFields = "grant_type=$grant_type&code=iq04CF&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";
	//$curlPostUriBase = "https://api-staging.bgl360.com.au/oauth/token";


	/**
	 * Include relevant files
	 */
	//require ("/bgl360/app/Http/ServiceBgl360.php");
	//
	//require ("/bgl360/app/Http/ResourceRequestBgl360.php");

	require ($_SERVER['DOCUMENT_ROOT']."/bgl360/app/Http/ServiceBgl360.php");
	require ($_SERVER['DOCUMENT_ROOT']."/bgl360/app/Http/AuthenticationBgl360.php");
	require ($_SERVER['DOCUMENT_ROOT']."/bgl360/app/Http/ResourceRequestBgl360.php");
	require ($_SERVER['DOCUMENT_ROOT']."/bgl360/app/Http/Member.php");


	//require ("bgl360/app/Http/Member.php");


	/**
	 * Call namespaces
	 */
	use App\ServiceBgl360;
	use App\AuthenticationBgl360;
	use App\ResourceRequestBgl360;



	/**
	 * Declare local and global variables
	 */
	global $wpdb;


	/**
	 * Instantiate classes
	 */
	$current_user 			= wp_get_current_user();
	$service_bgl360          = new ServiceBgl360($wpdb, $current_user->ID);
	$resource_request_bgl360 = new ResourceRequestBgl360();

	//echo "This is the post data";
	//print_r($_REQUEST);
	//echo "current user id " .  $current_user->ID . ' <br>';

	$fundList = $_REQUEST['fundList'];
	$accessToken = $_REQUEST['accessToken'];
	$currentUser= $service_bgl360->getCurrentAccessTokenByUser();
	//echo "<pre>";
	//print_r($currentUser);
	//echo "current token of the user " . $currentUser[0]['access_token'] . '<br>';
	//echo "access token " . $currentUser[0]['bgl360_token'];
    if($_POST)
	{
		// echo "<pre>";
		$members = $resource_request_bgl360->getFundMembers($fundList, $currentUser[0]['access_token']);
		// print_r($members);
		echo '<content-label><label for="fundList">Choose Fund Member: </label><content-label>';
		echo '<content-dropdown><select name="pensionMemberRefKey" id="select-fund-member">';
			echo '<option value="">- Select One -</option>';
			for($i=0; $i<count($members); $i++)
			{
				$member = new \App\Member($members, $i);
				echo '<option value="'  . $member->fundMemberMemberRefKey . '">' . $member->fundMemberFullName . '</option>';
			}
		echo '
		</select><content-dropdown>';
	}
	else {
		//echo print_r($service_bgl360,true);
	}
?>