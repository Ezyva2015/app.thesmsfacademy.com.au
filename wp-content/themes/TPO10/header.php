
<?php

/**
	 * Get wp user
	 */
	$current_user = wp_get_current_user();

	//If not logged in then page should redirect to main website login page
	

	
/**

 * The Header for our theme

 *

 * Displays all of the <head> section and everything up till <div id="main">

 *

 * @package WordPress

 * @subpackage TPO10

 * @since TPO10 1.0

 */

?><!DOCTYPE html>

<!--[if IE 7]>

<html class="ie ie7" <?php language_attributes(); ?>>

<![endif]-->

<!--[if IE 8]>

<html class="ie ie8" <?php language_attributes(); ?>>

<![endif]-->

<!--[if !(IE 7) | !(IE 8) ]><!-->

<html <?php language_attributes(); ?>>

<!--<![endif]-->

<head>

	<meta charset="utf-8"/>

	<meta name="viewport" content="width=device-width">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta content="width=device-width, initial-scale=1" name="viewport"/>

	<meta content="" name="description"/>

	<meta content="" name="author"/>

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!--[if lt IE 9]>

	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>

	<![endif]-->
<script src="<?php echo site_url(); ?>/assets/global/plugins/jquery-1.11.0.min.js"></script>


	<script type="javascript/text">
	$.noConflict();
	</script>
	
		<!-- BEGIN GLOBAL MANDATORY STYLES -->

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
	
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

	<link href="<?php echo site_url(); ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>

	<!-- END GLOBAL MANDATORY STYLES -->


	<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->

	<link href="<?php echo site_url(); ?>/assets/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>

	<!-- END PAGE LEVEL PLUGIN STYLES -->

	<!-- BEGIN PAGE STYLES -->

	<link href="<?php echo site_url(); ?>/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>

	<!-- END PAGE STYLES -->

	<!-- BEGIN THEME STYLES -->

	<link href="<?php echo site_url(); ?>/assets/global/css/components.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo site_url(); ?>/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>

	<link href="<?php echo site_url(); ?>/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" id="jquery-ui"/>

	<link href="<?php echo site_url(); ?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css"/>

	


	<!-- END THEME STYLES -->

	<!-- BOOTSTRAP TOUR START -->
	<link href="<?php echo site_url(); ?>/scripts/bootstrap-tour/build/css/bootstrap-tour-standalone.min.css" rel="stylesheet"/>
	<script src="<?php echo site_url(); ?>/scripts/bootstrap-tour/test/bootstrap-tour.js"></script>
	<script src="<?php echo site_url(); ?>/scripts/bootstrap-tour/build/js/bootstrap-tour-standalone.min.js"></script>

	
	<!-- BOOTSTRAP TOUR END -->
	<link rel="shortcut icon" href="favicon.ico"/>

	<?php wp_head(); ?>
    <script>
        jQuery.noConflict();
    </script>
    <script type="text/javascript">
		function SetHiddenFormSettingsTPO(id, mode, actionurl) {
			document.getElementById('gform_edit_id').value=id;
			document.getElementById('gform_edit_mode').value=mode;
			document.forms["gravitylist"].action=actionurl;
			document.forms["gravitylist"].submit();
		}			
	</script>
 <?php	if ( !is_user_logged_in() ) {
     if ( is_page() ) { ?>
		<style>
.page.type-page.status-publish.hentry.user-has-not-earned form table td input.wp-submit2 {
    font-size: 16px !important;
    letter-spacing: 1px !important;
    background: #ac343e !important;
    background: -moz-linear-gradient(top, #ac343e 0%, #79010b 100%) !important;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ac343e), color-stop(100%,#79010b)) !important;
    background: -webkit-linear-gradient(top, #ac343e 0%,#79010b 100%) !important;
    background: -o-linear-gradient(top, #ac343e 0%,#79010b 100%) !important;
    background: -ms-linear-gradient(top, #ac343e 0%,#79010b 100%) !important;
    background: linear-gradient(to bottom, #ac343e 0%,#79010b 100%) !important;
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ac343e', endColorstr='#79010b',GradientType=0 ) !important;
    color: #ffffff !important;
    line-height: 40px !important;
    text-shadow: 0 1px 0 #5f0000 !important;
    border: none;
    width: 100%!important;
}

.page-content-wrapper .page-content {
    margin: 0 auto;
    background: url(http://thesmsfacademy.com.au/wp-content/uploads/2015/02/meeting-cyp-2.jpg);
    background-size: cover;
}
input.mid {
    margin: 0px;
	height: 39px!important;
}
div#page .page-content-wrapper form table tr:first-child td:first-child, div#page .page-content-wrapper form table tr:nth-child(2) td:first-child {
    display: block;
    width: 52px;
    padding: 20px 0px!important;
}
form table tr:last-child td:first-child {
    padding: 10px 0px!important;
}
form table tr:nth-child(2) td:last-child,
form table tr:first-child td:last-child  {
    padding: 10px 5px!important;
}
.page-content .page-bar,
.page-container aside.sidebar,
.page-header-inner .top-menu,
.page-content h1 {
    display: none;
}
p.i4w_excerpt_text {
    background: white;
    padding: 10px;
    width: 300px;
    margin: 0 auto;
    border-radius: 0px!important;
}
.page-content-wrapper section article {
    transform: translate(0 , 25%);
}
div#page section form {
    width: 300px;
    margin: 5px auto 0!important;
    padding: 20px 20px 15px;
    background: white;
    position: relative;
}
</style>


	<?php }
}	?>

<style>

span.ginput_card_expiration_container label,
span#input_11_569_2_cardinfo_right label {
    font-size: 11px;
}
select.ginput_card_expiration.ginput_card_expiration_month,
select.ginput_card_expiration.ginput_card_expiration_year {
    background: -webkit-gradient(linear, left top, left 36, from(#FFFFFF), color-stop(4%, #d6d6d6), to(#fbf7f7));
    background: -moz-linear-gradient(top, #FFFFFF, ##d6d6d6 1px, #fbf7f7 15px);
    margin-bottom: 10px;
}

.gform_wrapper .ginput_complex .ginput_cardinfo_right span.ginput_card_security_code_icon {
background-image: url(/wp-content/plugins/gravityforms/images/gf-creditcard-icons.png);
    clear: both;
}
span.ginput_cardinfo_right input.ginput_card_security_code {
    float: left;
    margin: 0px;
    height: 34px;
}
.gform_wrapper div.gform_card_icon {
    background-image: url(/wp-content/plugins/gravityforms/images/gf-creditcard-icons.png);
}
.gform_wrapper label.gfield_label.gfield_label_before_complex {
    width: 100%;
}
span.ginput_cardinfo_right label {
    text-align: left;
    display: block;
    float: none;
    clear: both;
}
.gform_card_icon_container.gform_card_icon_style1 {
    height: 60px;
}
span.ginput_full.ginput_cardextras label,
.ginput_complex.ginput_container.ginput_container_creditcard span.ginput_full label {
    margin-bottom: 20px;
}
</style>


<?php if(is_page(42828)){ ?>
<script src="https://app.thesmsfacademy.com.au/wp-content/themes/TPO10/js/quickpager2.jquery.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>

<script>
jQuery(document).ready(function() {
jQuery("tbody.simplePagerPage1").quickPager();
jQuery("table.table.table-striped tbody").quickPager();
});
</script>
<?php
 }
?>

</head>

<body class="page-header-fixed page-quick-sidebar-over-content">

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">

		<div class="header-main">

		</div>

	</header><!-- #masthead -->	

	<!-- BEGIN HEADER -->

<div class="page-header navbar navbar-fixed-top">

	<!-- BEGIN HEADER INNER -->

	<div class="page-header-inner">

		<!-- BEGIN LOGO -->

		<div class="page-logo">

			<a href="/">

			<img src="<?php echo site_url(); ?>/wp-content/themes/tpo10/img/logo_tsa.png" alt="logo" class="logo-default"/>

			</a>

			<div class="menu-toggler sidebar-toggler hide">

				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->

			</div>

		</div>

		<!-- END LOGO -->

		<!-- BEGIN RESPONSIVE MENU TOGGLER -->

		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">

		</a>

		<!-- END RESPONSIVE MENU TOGGLER -->

		<!-- BEGIN TOP NAVIGATION MENU -->

		<div class="top-menu">

			<ul class="nav navbar-nav pull-right">

		<!-- BEGIN QUICK SIDEBAR TOGGLER -->

				<li class="dropdown dropdown-quick-sidebar-toggler">

					<a href="<?php echo wp_logout_url(); ?>" class="dropdown-toggle">

					<i class="icon-logout"></i>

					</a>

				</li>

				<!-- END QUICK SIDEBAR TOGGLER -->

			</ul>

		</div>

		<!-- END TOP NAVIGATION MENU -->

	</div>

	<!-- END HEADER INNER -->

</div>

<!-- END HEADER -->

<div class="clearfix">

</div>



	<div id="main" class="site-main">
