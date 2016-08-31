<?php
error_reporting(0);

function rss_feed(){
$rss = new DOMDocument();
	$rss->load('http://thedunnthing.com/feed');
	$feed = array();
	foreach ($rss->getElementsByTagName('item') as $node) {

		$item = array ( 
			'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
			'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
			'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
			'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
			);
		array_push($feed, $item);
	}
	$limit = 5;
	$rss_feed = '';
	for($x=0;$x<$limit;$x++) {
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
		$rss_feed = $rss_feed.'<li><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
		$rss_feed = $rss_feed.'<small><em>Posted on '.$date.'</em></small></li>';
		$rss_feed = $rss_feed.'<p>'.$description.'</p>';
		//$rss_feed = print_r($rss, true);
		
	}
	
	return $rss_feed;
}	

function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}

add_shortcode('dashboard', 'dashboard_shortcode');


function dashboard_shortcode(){
		global $wpdb;
		$forms = $wpdb->get_results( $wpdb->prepare( "SELECT title, is_active FROM wp_rg_form " )  );
		$active_forms = count($forms);
		$completed = $wpdb->get_results( $wpdb->prepare( "SELECT wp_rg_form_meta.display_meta, wp_rg_lead.orderStatus, wp_rg_lead.date_created, wp_rg_lead.id, wp_rg_lead.form_id, wp_rg_form.title FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'complete' ORDER BY wp_rg_lead.date_created DESC", wp_get_current_user()->ID )  );
		$completed_orders = count($completed);
		$grouped_feed = array();
		$grouped_orders_mtd = $wpdb->get_results( $wpdb->prepare( "SELECT wp_rg_form.title, COUNT(wp_rg_form.title) as counter, wp_rg_lead.date_created FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE  wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'complete' AND wp_rg_lead.date_created BETWEEN
      DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() GROUP BY wp_rg_form.title", wp_get_current_user()->ID )  );
	 
	   $grouped_orders_ytd = $wpdb->get_results( $wpdb->prepare( "SELECT wp_rg_form.title, COUNT(wp_rg_form.title) as counter, wp_rg_lead.date_created FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE  wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'complete' AND wp_rg_lead.date_created BETWEEN
      DATE_SUB(NOW(), INTERVAL 365 DAY) AND NOW() GROUP BY wp_rg_form.title", wp_get_current_user()->ID )  );
		foreach($grouped_orders_ytd as $g){
				$groupedytd[$g->title] = $g->counter;
			
		}
		
		foreach($grouped_orders_mtd as $g){
				$groupedmtd[$g->title] = $g->counter;
				//echo 'COunt: '.$g->counter;
			
		}
		
		
		
		$total_companies_ytd = $groupedytd['Company Incorporation']+$groupedytd['Company Incorporation - Special Purpose'];
		$total_new_smsf_ytd  = $groupedytd['New SMSF']+$groupedytd['SMSF Trust Deed'];
		$total_pensions_ytd  = $groupedytd['SMSF Pension'];
		$total_sdv_ytd		 = $groupedytd['SMSF Trust Deed Upgrade'];
		$total_inv_ytd		 = $groupedytd['Investment Strategy'];
		$total_lrba_ytd		 = $groupedytd['Limited Recourse Borrowing Arrangement'];
		
		$total_companies_mtd = $groupedmtd['Company Incorporation']+$groupedmtd['Company Incorporation - Special Purpose'];
		$total_new_smsf_mtd  = $groupedmtd['New SMSF']+$groupedmtd['SMSF Trust Deed'];
		$total_pensions_mtd  = $groupedmtd['SMSF Pension'];
		$total_sdv_mtd		 = $groupedmtd['SMSF Trust Deed Upgrade'];
		$total_inv_mtd		 = $groupedmtd['Investment Strategy'];
		$total_lrba_mtd		 = $groupedmtd['Limited Recourse Borrowing Arrangement'];
		$_user_id = get_current_user_id();
		
	$nsfprice = get_user_meta($_user_id, 'smsf_establishment', 1);
    $sdvprice = get_user_meta($_user_id, 'smsf_deed', 1);
    $cotprice = get_user_meta($_user_id, 'smsf_change', 1);
    $lrbaprice = get_user_meta($_user_id, 'smsf_borrowing', 1);
    $coyprice = get_user_meta($_user_id, 'company_inc', 1);
    $coyspprice = get_user_meta($_user_id, 'company_incsp', 1);
    $abpprice = get_user_meta($_user_id, 'account_base_pension', 1);
    $trisprice = get_user_meta($_user_id, 'transition_to_retirement', 1);
    $statdecprice = get_user_meta($_user_id, 'statutory_declaration', 1);
    $acqprice = get_user_meta($_user_id, 'acquire_an_asset', 1);
    $sellprice = get_user_meta($_user_id, 'sell_an_asset', 1);
    $worktestprice = get_user_meta($_user_id, 'satisfy_work_test', 1);
    $consentprice = get_user_meta($_user_id, 'trust_consent', 1);
    $windupprice = get_user_meta($_user_id, 'wind_up_smsf', 1);
    $corprice = get_user_meta($_user_id, 'met_condition_of_release', 1);
	 
	$totalrevmtd = ($nsfprice * $total_new_smsf_mtd)+($total_companies_mtd*$coyprice)+($total_pensions_mtd*$abpprice);
	$totalrevmtd = $totalrevmtd + ($sdvprice * $total_sdv_mtd)+($total_con_mtd*$conprice)+($total_lrba_mtd*$lrbaprice);
		$totalrevmtd = number_format($totalrevmtd,2,'.',',');
		
		$totalrevytd = ($nsfprice * $total_new_smsf_ytd)+($total_companies_ytd*$coyprice)+($total_pensions_ytd*$abpprice);
		$totalrevytd = $totalrevytd + ($sdvprice * $total_sdv_ytd)+($total_con_ytd*$conprice)+($total_lrba_ytd*$lrbaprice);
		$totalrevytd = number_format($totalrevytd,2,'.',',');
		
		$total_companies = $total_companies_mtd + $total_companies_ytd;
		$total_new_smsf  = $total_new_smsf_mtd + $total_new_smsf_ytd;
		$total_pensions = $total_pensions_mtd + $total_pensions_ytd;
		$total_sdv = $total_sdv_mtd + $total_sdv_ytd;
		$total_inv = $total_in_mtd + $total_inv_ytd;
		$total_lrba = $total_lrba_mtd + $total_lrba_ytd;
		
		if(is_null($total_companies)){
			$total_companies = 0;
		}
		if(is_null($total_new_smsf)){
			$total_new_smsf  = 0;
		}
		if(is_null($total_pensions)){
			$total_pensions  = 0;
		}
		if(is_null($total_sdv)){
			$total_sdv		 = 0;
		}
		if(is_null($total_inv)){
			$total_inv		 = 0;
		}
		if(is_null($total_lrba)){
			$total_lrba		 = 0;
		}
		
		
		
		$coys = 0;
		$inc_coys = 0;
		$inc_coys_feed = '';
		$order_feed = '';
		$form_id_excluded = array(3, 4, 5, 60, 66, 68, 71);

		foreach($completed as $c){
			if((($c->form_id == "11") || ($c->form_id == "58"))){
				$coys = $coys + 1;
			}
			if (!in_array($c->form_id, $form_id_excluded)) {
		 		// if((($c->form_id != "71") && ($c->form_id != "68"))){
				$order_feed = $order_feed.' '.'<li>
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="label label-sm label-info">
										<i class="fa fa-shopping-cart"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc">
										 '.$c->title.' ordered ( #'.$c->form_id.$c->id.' ) 
									</div>
								</div>
							</div>
						</div>
						<div class="col2">
							<div class="date">
								 '.humanTiming(strtotime($c->date_created)).'
							</div>
						</div>
					</li>';
			}	
		
		}
		
		if($coys > 0){
			$coys_percent = round(($coys/$completed_orders)*100);
		}
		else {
			$coys_percent = 0;
		}
		$saved = $wpdb->get_results( $wpdb->prepare( "SELECT wp_rg_form_meta.display_meta, wp_rg_lead.asic_status, wp_rg_lead.orderStatus, wp_rg_lead.date_created, wp_rg_lead.id, wp_rg_lead.form_id, wp_rg_form.title FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'incomplete'", wp_get_current_user()->ID )  );
		
		$allOrders = $wpdb->get_results( $wpdb->prepare( "SELECT wp_rg_lead.asic_status, wp_rg_lead.orderStatus, wp_rg_lead.date_created, wp_rg_lead.id, wp_rg_lead.form_id, wp_rg_form.title FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE wp_rg_lead.created_by = %d AND wp_rg_lead.asic_status <> 'Order complete' AND wp_rg_lead.asic_status <> ''", wp_get_current_user()->ID )  );
		foreach($allOrders as $s){
			if((($s->form_id == "11") || ($s->form_id == "58"))){
				$inc_coys = $inc_coys + 1;
				$inc_coys_feed = $inc_coys_feed.' '.'<li>
					<div class="col1">
						<div class="cont" style="width:50%;">
							<div class="cont-col1">
								<div class="label label-sm label-warning">
									<i class="fa fa-exclamation"></i>
								</div>
							</div>
							<div class="cont-col2" >
								<div class="desc">
									 '.$s->title.' ( #'.$s->form_id.$s->id.' )
								</div>
							</div>
							
						</div>
						<div class="col3">
								<div class="desc">
							 		'.$s->asic_status.'
								</div>
							</div>
					</div>
					
				</li>';
			}
		}
		
		
		
		$saved_orders = count($saved);







		//get current user logged ing
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		//Count total Courses
		$args = array('post_type' => 'sfwd-courses', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC' );
		$courses = get_posts($args);
		$tcourses = count($courses);

		//Count total enrolled and not enrolled
		$total_enrolled = 0;
		$total_not_enrolled = 0;
		$total_completed = 0;

		$ii = 0;
		foreach($courses as $key => $course) {
			$ii++;
			$status = '';
			$course_id = $course->ID;
			$meta = get_post_meta($course_id, '_sfwd-courses', true);
			if (!empty($meta['sfwd-courses_course_access_list'])) {
				$course_access_list = explode(',', $meta['sfwd-courses_course_access_list']);
			} else {
				$course_access_list = array();
			}


			//$topics = $course['topics'];
			//if(strlen(get_the_title( $key )) > 0) {
			$accreditation_activity_code = get_post_custom_values('accreditation_activity_code', $course_id);
			$issue_date_aac = get_post_custom_values('issue_date_aac', $course_id);
			$expiry_date_aac = get_post_custom_values('expiry_date_acc', $course_id);
			$cpd_points = get_post_custom_values('cpd_points', $course_id);
			$issue_date_cpd = get_post_custom_values('issue_date_cpd', $course_id);
			$expiry_date_cpd = get_post_custom_values('expiry_date_cpd', $course_id);
			$cpe_points = get_post_custom_values('cpe_points', $course_id);
			$issue_date_cpe = get_post_custom_values('issue_date_cpe', $course_id);
			$expiry_date_cpe = get_post_custom_values('expiry_date_cpe', $course_id);
			$fpa_points = get_post_custom_values('fpa_points', $course_id);
			$issue_date_fpa = get_post_custom_values('issue_date_fpa', $course_id);
			$expiry_date_fpa = get_post_custom_values('expiry_date_fpa', $course_id);
			$published_date = get_the_date('M. d, Y', $course_id);


			//echo $enrolledOrNot.'<br/>';
			if (in_array($user_id, $course_access_list) || learndash_user_group_enrolled_to_course($user_id, $course_id)) {
				$enrolled = 'Enrolled = ' . $total_enrolled;
				$total_enrolled ++;


//				echo " you are enrolled to $user_id, $course_id <br>";
			} else {
				$enrolled = '<a href="' . get_permalink($course_id) . '">Enrol Now</a> = ' . $total_not_enrolled;
				$total_not_enrolled++;
//				echo " you are not enrolled to $user_id, $course_id <br>";
			}

			//date("d/m/Y", get_user_meta( $user_id, 'course_completed_'.$course_id, $single ))
			if (strlen(get_user_meta($user_id, 'course_completed_' . $course_id, $single)) > 0) {
				$dateCompleted = date("d/m/Y", get_user_meta($user_id, 'course_completed_' . $course_id, $single));
				$enrolled = 'Completed';
//				echo " you   completted =  $user_id, $course_id <br>";
				$total_completed++;
			} else {
				$dateCompleted = '';
			}
		}






//	echo "<pre>";
//		print_r($companies);
//	echo "</pre>";
	
		
		//foreach($leads as $lead){
			
			//$output .= '<tr><td>'.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td><button class="btn default btn-xs purple" onclick="SetHiddenFormSettingsTPO('.$lead->id.', \'update\',\''.get_action_link($lead->form_id, $lead->id, $wpdb).'\')"><i class="fa fa-edit"></i> Resume</button> <button class="btn default btn-xs black" onclick="SetHiddenFormSettingsTPO('.$lead->id.', \'delete\',\''.get_action_link($lead->form_id, $lead->id, $wpdb).'\')"><i class="fa fa-trash-o"></i> Delete</button></tr></form>';
		//}
		
		
		
		$output = '
		
		<style type="text/css">
					.glyphicon
			{
				margin-right:4px !important; /*override*/
			}

			.pagination .glyphicon
			{
				margin-right:0px !important; /*override*/
			}

			.pagination a
			{
				color:#555;
			}

			.panel ul
			{
				padding:0px;
				margin:0px;
				list-style:none;
			}

			.news-item
			{
				padding:4px 4px;
				margin:0px;
				border-bottom:1px dotted #555;
				list-style: none; 
				font-size: 14px;
			}
		</style>
		<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 '.$completed_orders.'
							</div>
							<div class="desc">
								 Completed Orders
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue">
						<div class="visual">
							<i class="fa fa-save"></i>
						</div>
						<div class="details">
							<div class="number">
								 '.$saved_orders.'
							</div>
							<div class="desc">
								 Saved Orders
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green">
						<div class="visual">
							<i class="fa fa-calendar"></i>
						</div>
						<div class="details">
							<div class="number">
								 $'.$totalrevmtd.'
							</div>
							<div class="desc">
								 Revenue (MTD)
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow-casablanca">
						<div class="visual">
							<i class="fa fa-dollar"></i>
						</div>
						<div class="details">
							<div class="number">
								 $'.$totalrevytd.'
							</div>
							<div class="desc">
								 Revenue (YTD)
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="portlet box purple-wisteria">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i>Document Orders
							</div>
							<div class="actions">
								<a href="javascript:;" class="btn btn-sm btn-default easy-pie-chart-reload">
								<i class="fa fa-repeat"></i> Reload </a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-2">
									<div style="text-align: center;">
										<div>
											<span style="font-size: 34px;"> '  . $total_companies .  '    </span>
											
										</div>
										
										Companies 
										
									</div>
								</div>
								<div class="margin-bottom-10 visible-sm">
								
								</div>
								<div class="col-md-2">
									<div style="text-align: center;">
										<div>
											<span style="font-size: 34px;">
											'.$total_new_smsf.' </span>
											
										</div>
										
										New Funds
										
									</div>
								</div>
								<div class="margin-bottom-10 visible-sm">
								</div>
								<div class="col-md-2">
									<div style="text-align: center;">
										<div>
											<span style="font-size: 34px;">
											'.$total_pensions.' </span>
										</div>
										Pensions 
										
									</div>
								</div>
								<div class="margin-bottom-10 visible-sm">
								</div>
								<div class="col-md-2">
									<div style="text-align: center;">
										<div>
											<span style="font-size: 34px;">
											'.$total_sdv.' </span>
											
										</div>

										SMSF Deed Upgrades

									</div>
								</div>
								<div class="margin-bottom-10 visible-sm">
								</div>
								<div class="col-md-2">
									<div style="text-align: center;">
										<div>
											<span style="font-size: 34px;">'.$total_lrba.'
											</span>
											
										</div>
										
										LRBAs
										
									</div>
								</div>
								<div class="margin-bottom-10 visible-sm">
								</div>
								<div class="col-md-2">
									<div style="text-align: center;">
										<div>
											<span style="font-size: 34px;">'.$total_inv.'
							
											</span>
											
										</div>
										
										Investment Strategies
										
									</div>
								</div>
							</div>
						</div>
					</div>
					
				
				</div>
				
			</div>
			<div class="row ">
				
				<div class="col-md-6 col-sm-6">
					<div class="portlet box blue-steel">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bell-o"></i>Recent Activities
							</div>
							
						</div>
						<div class="portlet-body">
							<div class="scrollable">
								<ul class="feeds">
									'.$order_feed.'
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">

					<div class="portlet box yellow" >
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bell-o"></i>Orders which need attention
							</div>	
						</div>
						<div class="portlet-body">
							<div class="scrollable" id="inc_coys">
							
								<ul class="feeds">
									'.$inc_coys_feed.'
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="row ">
				
				
			<div class="col-md-3 col-sm-3 ">
					<div class="portlet box purple-wisteria">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i>Courses
							</div>
							<div class="actions">
								<a href="javascript:;" class="btn btn-sm btn-default easy-pie-chart-reload">
								<i class="fa fa-repeat"></i> Reload </a>
							</div>
						</div>
						<div class="portlet-body" style="height:320px;">
							
									<div style="text-align: center; height:33%">
										<div>

											<span style="font-size: 34px;">'.$tcourses.'</span>
											
										</div>
										
										Available 
										
									</div>
									<div class="margin-bottom-30 visible-sm">
								
									</div>
									<div style="text-align: center; height:33%">
										<div>

											<span style="font-size: 34px;">
											  ' . $total_enrolled . '</span>
											
										</div>
										
										Enrolled
										
									</div>
									<div class="margin-bottom-30 visible-sm">
								
									</div>
									<div style="text-align: center; height:33%">
										<div>

											<span style="font-size: 34px;">
											'. $total_completed .' </span>
										</div>
										Completed 
										
									</div>
									<div class="margin-bottom-30 visible-sm">
								
									</div>
								
						</div>
					</div>
					
				
			</div>	
				
				
				<div class="col-md-3 col-sm-3">
					<div class="portlet box blue-steel">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-rss"></i>The Dunn Thing
							</div>
							
						</div>
						<div class="portlet-body" style="height:320px;">
							<div class="scrollable">
								<ul class="feeds">
									<li>'.rss_feed().'</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-6 col-sm-6">
					<div class="portlet box blue">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-gift"></i>Upcoming Training
									</div>
							
								</div>
								<div class="portlet-body" style="height:320px;">
									';
									if(i4w_has_tags("177,181,185")){
									$output2 = '[table id=11 datatables_filter=0 datatables_lengthchange=0 datatables_paginate=0 datatables_info=0 /]';
									} else {
									$output2 = '[table id=11 datatables_filter=0 datatables_lengthchange=0 datatables_paginate=0 datatables_info=0 hide_columns="3" /]';
									}
									$output = $output.$output2.'
								</div>
					</div>
					
					
				</div>
			</div>
			

<script type="text/javascript">
    $(function () {
    
    	


        jQuery(".scrollable").slimscroll({

    height: "300px",
    size: "10px",
    position: "right",
    color: "#ffcc00",
    alwaysVisible: true,

    railVisible: true,
    railColor: "#222",
    railOpacity: 0.3,
    wheelStep: 10,
    allowPageScroll: true,
    disableFadeOut: true
        });


        jQuery(".demo1").bootstrapNews({
            newsPerPage: 3,
            autoplay: true,
			pauseOnHover:true,
            direction: \'up\',
            newsTickerInterval: 4000,
            onToDo: function () {
                
            }
        });
		
		jQuery(".demo2").bootstrapNews({
            newsPerPage: 4,
            autoplay: true,
			pauseOnHover: true,
			navigation: false,
            direction: \'down\',
            newsTickerInterval: 2500,
            onToDo: function () {
              
            }
        });

        jQuery("#demo3").bootstrapNews({
            newsPerPage: 3,
            autoplay: false,
            
            onToDo: function () {
                  
            }
        });
    });
</script>';
		
		return $output;
		
	}	
	
?>