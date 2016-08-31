

<?php

//Download as csv
/* 
 */
 
 
if($_GET['csv'] == 1) {    
    header("Content-Type: text/csv;  charset=UTF-8");
    header("Content-Disposition: attachment; filename=CPD Report [" . date("Y-m-d") . "].csv"); 
    // Disable caching
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies 
    function outputCSV($data) {
        $output = fopen("php://output", "w");
        foreach ($data as $row) {
            fputcsv($output, $row); // here you can change delimiter/enclosure
        }
        fclose($output);
    } 
    //set header
    $csv_header = array( 
        'Course Code',
        'Course Name',
        'Status',
        'Date Completed',
        'SMSFA Acc Code',
        'SMSFA Points',
        'SMSFA Expiry',
        'CPE Hours',
        'FPA Points',
        'FPA Expiry', 
    ); 

    //set content   
    $content = array(); 

    $content[0] = $csv_header;   

    $args = array(  'post_type'  => 'sfwd-quiz');
    $posts_array = get_posts( $args );   

    $current_user = wp_get_current_user(); 
    $user_id = $current_user->ID; 
     
      $args = array('post_type' => 'sfwd-courses', 'numberposts'       => -1);
      $courses = get_posts($args); 
      $quizzes = get_user_meta( $user_id, '_sfwd-quizzes', $single ); 
      foreach($quizzes as $quiz){ 
        $c = learndash_certificate_details($quiz['quiz'], $user_id);  
      } 
      $args = array('post_type' => 'sfwd-quiz', 'numberposts'       => -1);
      $quizposts = get_posts($args);
      $qlarray = array();                 

     foreach($quizposts as $qp){
        $quizlesson = get_post_meta( $qp->ID, 'lesson_id', true );
        $qlarray[$quizlesson] = $qp->ID;

     } 
       $args =  array('post_type' => 'sfwd-lessons', 'numberposts'       => -1);
       $lessons = get_posts($args);
       $courseQuizArr = array();
      foreach($lessons as $lesson){
        $lessonCourseID = get_post_meta( $lesson->ID, '_sfwd-lessons', true );
        if (array_key_exists($lesson->ID,$qlarray))
          { 
            $courseQuizArr[$lessonCourseID['sfwd-lessons_course']] = $qlarray[$lesson->ID];
          }
        else
          { 
          }  
      } 
    $ii = 0;
    foreach($courses as $key => $course){
        $ii++;
        $status = '';
        $course_id = $course->ID;
        $meta = get_post_meta( $course_id, '_sfwd-courses', true );
        if ( ! empty( $meta['sfwd-courses_course_access_list'] ) ) {
            $course_access_list = explode( ',', $meta['sfwd-courses_course_access_list'] );
        } else {
            $course_access_list = array();
        } 
        $accreditation_activity_code = get_post_custom_values('accreditation_activity_code', $course_id);
        $issue_date_aac = get_post_custom_values('issue_date_aac', $course_id);
        $expiry_date_aac = get_post_custom_values('expiry_date_acc', $course_id);
        $cpd_points = get_post_custom_values('cpd_points', $course_id);
        $issue_date_cpd = get_post_custom_values('issue_date_cpd', $course_id);
        $expiry_date_cpd = get_post_custom_values('expiry_date_cpd', $course_id);                                                   
        $cpe_points = get_post_custom_values('cpe_points', $course_id);
        $issue_date_cpe= get_post_custom_values('issue_date_cpe', $course_id);
        $expiry_date_cpe = get_post_custom_values('expiry_date_cpe', $course_id);
        $fpa_points = get_post_custom_values('fpa_points', $course_id);
        $issue_date_fpa = get_post_custom_values('issue_date_fpa', $course_id);
        $expiry_date_fpa = get_post_custom_values('expiry_date_fpa', $course_id);
        $published_date = get_the_date('M. d, Y', $course_id); 
        $enrolledText = '';
         $enrolled  = ''; 
        if ( in_array( $user_id, $course_access_list )  || learndash_user_group_enrolled_to_course( $user_id, $course_id ) ) {
            $enrolled = 'Enrolled';
            $enrolledText = 'Enrolled';
        } else {
            $enrolled = '<a href="'.get_permalink($course_id).'">Enrol Now</a>';
            $enrolledText = 'Enroll Now';
        } 
        if(strlen(get_user_meta( $user_id, 'course_completed_'.$course_id, $single )) > 0){
            $dateCompleted = date("d/m/Y", get_user_meta( $user_id, 'course_completed_'.$course_id, $single ));
            $enrolled = 'Completed';
            $enrolledText = 'Completed';
        }else {
            $dateCompleted = '';
        } 
            if($enrolled == 'Completed'){ 
                 $car = $courseQuizArr[$course_id]; 
                if(strlen($car) > 0){ 
                    $certificate = learndash_certificate_details($courseQuizArr[$course_id], $user_id);
                }
                else {  
                    $certificate = learndash_certificate_details($course_id, $user_id);
                    echo print_r($certificate, true);
                } 
                $certificate = '<a href="'.$certificate['certificateLink'].'" target="_blank">Download</a>'; 
            }
            else { 
            }  
        if($enrolledText == 'Enrolled' || $enrolledText == 'Completed' || $dateCompleted != null) { 
            
            $title = get_the_title( $course_id );

            //@src https://www.utexas.edu/learn/html/spchar.html
            //Update this text if new special characters
            $special_characters = array(
                '-'=>'&#8211;',
                '—'=>'&#8212;', 
                '"'=>'&#8220;', 
                '>'=>'&#62;',
                '<'=>'&#60',
                "'"=>'&#39;'
            ); 

            foreach($special_characters as $key => $value) {
                $title = str_replace($value, $key, $title);  
            } 

            $content [] = array('TSA-' . $course_id, $title, $enrolledText, htmlspecialchars_decode(' ' . $dateCompleted . ' '), $accreditation_activity_code[0], $cpd_points[0], $expiry_date_fpa[0], $cpe_points[0], $fpa_points[0], $expiry_date_fpa[0]);    

        }  
    }
    outputCSV( $content );
    exit;   
 } else { 
 } 
?>   
<?php /* Template Name: CPD Page Template */ get_header(); ?>

    <main role="main" class="page-container">
        <?php get_sidebar(); ?>
        <!-- section -->
        <section class="page-content-wrapper">
            <section class="page-content">

                <?php //if (have_posts()): the_post(); ?>
                    <h1><?php the_title(); ?></h1>

                    <?php get_template_part('inc/page','breadcrumbs'); ?>


					<?php $current_user = wp_get_current_user(); 
						$user_id = $current_user->ID;
						echo 'Student Number:'.$user_id;
					
					?> 
					 &nbsp; &nbsp;
                    <a href="?csv=1">
                        <input type="button" value="Download CPD Report" />
                     </a>
                    <!--<article id="post-<?php /*the_ID(); */?>" <?php /*post_class(); */?>>
                        
                        <br class="clear">
                    </article>-->
                    
                        <?php
                        $the_query = new WP_Query( array(
                            'post_type' => 'sfwd-courses',
                            
                            /*'orderby'   => 'ID',
                            'order'     => 'ASC'*/
                        ) );
                        ?>
                       
                            <!-- article -->
                            <article id="post-<?php the_ID(); ?>" >
                                			<?php  //'sfwd-quiz'
                                			$args = array(	'post_type'  => 'sfwd-quiz');
                                			$posts_array = get_posts( $args );
                                			//echo print_r($posts_array, true);
                                			
           
                                			
                                			
                                			 ?>	





                                			<?php //$courses = get_user_meta( $user_id, '_sfwd-course_progress', $single ); 
                                					$args = array('post_type' => 'sfwd-courses', 'numberposts'       => -1);
                                					$courses = get_posts($args);
                                					//echo 'Count: '.count($courses_array);
                                					//foreach($courses_array as $coursear){
                                				  
                                					//echo 'test'.$coursear->ID.'<br/>';
                                					//echo print_r($coursear, true).'<br/>';
                                					
                                				  	//}
                                				  	
                                					
                                				  $quizzes = get_user_meta( $user_id, '_sfwd-quizzes', $single ); 
                                				  foreach($quizzes as $quiz){
                                				  
                                					$c = learndash_certificate_details($quiz['quiz'], $user_id);
                                					//echo print_r($c, true).'<br/>';
                                					//echo print_r($quiz, true).'<br/>';
                                					
                                				  }
                                				  
                                				  //get the lessons which the quizzes are associated with
                                				  $args = array('post_type' => 'sfwd-quiz', 'numberposts'       => -1);
                                					$quizposts = get_posts($args);
                                					$qlarray = array();					
                                
                                					foreach($quizposts as $qp){
                                						$quizlesson = get_post_meta( $qp->ID, 'lesson_id', true );
                                						$qlarray[$quizlesson] = $qp->ID;

                                					}
                                					
                                					//echo 'Quiz Array: '.print_r($qlarray, true);
                                				  
                                				   $args =  array('post_type' => 'sfwd-lessons', 'numberposts'       => -1);
                                				   $lessons = get_posts($args);
                                				   $courseQuizArr = array();
                                				  foreach($lessons as $lesson){
                                				  	$lessonCourseID = get_post_meta( $lesson->ID, '_sfwd-lessons', true );
                                					if (array_key_exists($lesson->ID,$qlarray))
													  {
													  //echo 'Lessons ID: '.$lesson->ID.' Quiz ID: '.$qlarray[$lesson->ID].' Course ID: '.$lessonCourseID['sfwd-lessons_course'].'<br/>';
													  	$courseQuizArr[$lessonCourseID['sfwd-lessons_course']] = $qlarray[$lesson->ID];
													  }
													else
													  {
													  //do nothing.
													  }
                                					
                                					
                                					
                                					
                                				  }
												//echo print_r($courseQuizArr, true).'<br/>';
												 
												
												
                                				echo '<table class="tablepress dataTable no-footer" id="keywords">'; 
                                				echo '<thead><th>Code</th><th>Created</th><th>Course</th><th>CPD Points</th><th>SMSFA Expiry</th><th>Status</th><th>Date Completed</th><th>Certificate</th></thead>';
                                				$ii = 0;
												foreach($courses as $key => $course){
													$ii++;
                                					$status = '';
                                					$course_id = $course->ID;
                                					$meta = get_post_meta( $course_id, '_sfwd-courses', true );
                                					if ( ! empty( $meta['sfwd-courses_course_access_list'] ) ) {
														$course_access_list = explode( ',', $meta['sfwd-courses_course_access_list'] );
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
													$issue_date_cpe= get_post_custom_values('issue_date_cpe', $course_id);
													$expiry_date_cpe = get_post_custom_values('expiry_date_cpe', $course_id);
													$fpa_points = get_post_custom_values('fpa_points', $course_id);
													$issue_date_fpa = get_post_custom_values('issue_date_fpa', $course_id);
													$expiry_date_fpa = get_post_custom_values('expiry_date_fpa', $course_id);
													$published_date = get_the_date('M. d, Y', $course_id);
													
                                					
                                					
                                					
                                					//echo $enrolledOrNot.'<br/>';
                                					if ( in_array( $user_id, $course_access_list )  || learndash_user_group_enrolled_to_course( $user_id, $course_id ) ) {
														$enrolled = 'Enrolled';
													} else {
														$enrolled = '<a href="'.get_permalink($course_id).'">Enrol Now</a>';
													}
                                					
                                					//date("d/m/Y", get_user_meta( $user_id, 'course_completed_'.$course_id, $single ))
                                					if(strlen(get_user_meta( $user_id, 'course_completed_'.$course_id, $single )) > 0){
                                						$dateCompleted = date("d/m/Y", get_user_meta( $user_id, 'course_completed_'.$course_id, $single ));
                                						$enrolled = 'Completed';
                                					}else {
                                						$dateCompleted = '';
                                					}
                                					
                                					/*if($cpd_points[0] == '0'){
                                						$points = 'Not yet issued';
                                						$certificate = 'Not issued';	
                                						
                                					}  
                                					else {*/
                                						if($enrolled == 'Completed'){
                                							$points = '<ul class="cpd-register">
														   <li><h5><b>SMSF Association</b></h5><p><b>Accreditation Activity Code : </b>'.$accreditation_activity_code[0].'</p>
														   <p><b>SMSFA Points : </b>'.$cpd_points[0].'</p>
															<p><b>Expiry Date : </b>'.$expiry_date_cpd[0].'</p></li>
														   <li><h5><b>Major accounting bodies (CPA, CAANZ, IPA)</b></h5><p><b>CPE Hours : </b>'.$cpe_points[0].'</p></li>
														   <li><h5><b>Financial Planning Association</b></h5><p><b>FPA Points : </b>'.$fpa_points[0].'</p>
															<p><b>Expiry Date : </b>'.$expiry_date_fpa[0].'</p></li></ul>';
                                							 //need to add timestamp
                                							 
                                							 $car = $courseQuizArr[$course_id];
                                							//echo print_r($courseQuizArr, true).'<br/>';
                                							if(strlen($car) > 0){
                                								//echo 'Going to use Quiz<br/>';
                                								$certificate = learndash_certificate_details($courseQuizArr[$course_id], $user_id);
                                								$certificate = '<a href="'.$certificate['certificateLink'].'" target="_blank">Download</a>'; 
                                							}
                                							else {
                                								//echo 'Going to use Course: '.$course_id.'<br/>';
                                								
                                								$certificate = learndash_get_course_certificate_link($course_id, $user_id);
                                								$certificate = '<a href="'.$certificate.'" target="_blank">Download</a>'; 
                                							}
                                							
                                							
                                						}
                                						else {
                                							$points = '<ul class="cpd-register">
														   <li><h5><b>SMSF Association</b></h5><p><b>Accreditation Activity Code : </b>'.$accreditation_activity_code[0].'</p>
														   <p><b>SMSFA Points : </b>'.$cpd_points[0].'</p>
															<p><b>Expiry Date : </b>'.$expiry_date_cpd[0].'</p></li>
														   <li><h5><b>Major accounting bodies (CPA, CAANZ, IPA)</b></h5><p><b>CPE Hours : </b>'.$cpe_points[0].'</p></li>
														   <li><h5><b>Financial Planning Association</b></h5><p><b>FPA Points : </b>'.$fpa_points[0].'</p>
															<p><b>Expiry Date : </b>'.$expiry_date_fpa[0].'</p></li></ul>'; 
                                							$certificate = 'N/A';
                                						} 
                                					//}
                                					
													
													
													
                                					//$completedOrNot = get_user_meta( $user_id, 'course_completed_'.$key, $single );
														//echo print_r($quiz_attempts, true).'<br/>';
														//if($course['completed'] == 1) {
                                						//	$comOrNot = 'Completed';
                                						//}
                                						//else {
                                							//$comOrNot = 'Enrolled';
                                						//}
 

                                					echo '<tr>'; 
                                					echo '<td>TSA-'.$course_id.'</td>'; 
													echo '<td>'.$published_date.'</td>'; 
                                					echo '<td>'.'<a href="'.get_permalink($course_id).'">'.get_the_title( $course_id ).'</a>'.'</td>'; 
													echo '<td style="padding-left:45px;"><a href="#openModal'.$ii.'"><b>+</b></a></td>'; 
                                					echo '<td>'.$expiry_date_cpd[0].'</td>'; 
                                					echo '<td>'.$enrolled.'</td>';
                                					echo '<td>'.$dateCompleted.'</td>';
                                					echo '<td>'.$certificate.'</td></tr>';
                                					//} 
													echo '<div id="openModal'.$ii.'" class="modalDialog"><div><a href="#close" title="Close" class="xclose">X</a>'.$points.'</div></div>';
                                				}
												
                                				echo '</table>';
                                			?>	
                                			  
                                        	<?php //$pid= the_ID(); echo print_r(get_post_custom($pid), true); ?>
                                            <?php //the_title(); ?>
                                
                                


                                <!-- post title -->
                                <!--<h2>
                            <a href="<?php /*the_permalink(); */?>" title="<?php /*the_title(); */?>"><?php /*the_title(); */?></a>
                        </h2>-->
                                <!-- /post title -->

                                <!-- post details -->
                                <!--<span class="date"><?php /*the_time('F j, Y'); */?> <?php /*the_time('g:i a'); */?></span>
                        <span class="author"><?php /*_e( 'Published by', 'html5blank' ); */?> <?php /*the_author_posts_link(); */?></span>
                        <span class="comments"><?php /*if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); */?></span>-->
                                <!-- /post details -->

                                <?php /*html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php */?>

                                <?php /*edit_post_link(); */?>

                            </article>
                            <!-- /article -->

                        
                  

                    <?php get_template_part('pagination'); ?>

                <?php //endif; ?>

            </section>

        </section>
        <!-- /section -->
    </main>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
function enrol(course_id) {
      $.ajax({
           type: "POST",
           url: '/scripts/enrolgraduate.php',
           data:{action:'call_this'},
           success:function(html) {
             alert(html);
           }

      });
 }
jQuery(document).ready(function() {
	jQuery('#keywords').tablesorter(); 
});

</script>

<?php get_footer(); ?>