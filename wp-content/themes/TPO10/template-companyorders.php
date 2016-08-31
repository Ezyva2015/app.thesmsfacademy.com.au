<script src="https://code.jquery.com/jquery-1.10.1.min.js" ></script>
<script>
        jQuery(document).ready(function(){
            jQuery("form").on('submit',function(event){
                event.preventDefault();
                data = jQuery(this).serialize();
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo get_template_directory_uri();?>/template-companydetails.php",
                    data: data
                }).done(function( response ) {
                    alert( "Data Saved: " + response );
                    var result = jQuery.parseJSON(response);
						result['companyName']; // return 'John'
						
						
						jQuery('#companyname').val(result['companyName']);
						jQuery('#d1').val(result['d1']);
						jQuery('#d2').val(result['d2']);
						jQuery('#d3').val(result['d3']);
						jQuery('#d4').val(result['d4']);
                });
            });
        });
    </script>
<?php /* Template Name: Company Orders */  //get_header();



/**
 * Get wp user
 */
$current_user = wp_get_current_user();

//If not logged in then page should redirect to main website login page
// if($current_user->ID < 1) { header("location: https://app.thesmsfacademy.com.au/wp-login.php"); }



/**
 * Declare local and global variables
 */
global $wpdb;


//echo "<pre>";

$current_user = wp_get_current_user();




	/**
	 * Tim's code
	 */


		$formId		  		  = 11;
		$form 		  		  = GFAPI::get_form( $formId );
		$title 		  		  = $form['title'];
		$current_user   	  = wp_get_current_user();
    	$user_id 	          = $current_user->ID;
   	 	$search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $user_id );
		$entries 			= GFAPI::get_entries( $formId,$search_criteria, null, $paging );
		//echo print_r($entries, true);
		




				


 ?>

<!--TEMPLATE DISPLAY-->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php get_sidebar(); ?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h1><?php the_title(); ?></h1>
            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="/">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php
                        if(empty($post->post_parent))
						{
                            $link = '<a href="'.$post->post_name.'">'.get_the_title( $post->ID ).'</a>';
                        }
                        else
						{
                            $ancestors = get_post_ancestors( $post );
							$links = '';
                            foreach($ancestors as $ancestor)
							{
                                $links = '<a href="'.get_page_template_slug( $ancestor ).'">'.get_the_title($ancestor).'</a><i class="fa fa-angle-right"></i> '.$links;
                            }
                            $link = $links.'<a href="'.$post->post_name.'">'.get_the_title( $post->ID ).'</a>';
                        }
                        echo $link;
                        ?>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <!-- section -->
            <section>
                <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	                    <form>
	                    <label for="companyList">Choose Fund: </label>


                        <?php
							//the_content();
							$importForm = '<select name="companyList" id="companyList"><option value="">- Select One - </option>';

						// print_r($funds);
						foreach($entries as $entry)
							{
								$value = $entry['1'];
								$id		= $entry['id'];
								$importForm .= '<option value="' . $id . '">'.$value.'</option>';
							}
							$importForm .= '</select>';
						 	echo $importForm;
                        ?>
                        <input id="companyname" type="text" name="companyname" >
                       <input type="text" name="address" >
                       <input type="text" name="d1" id="d1" >
                       <input type="text" name="d2" id="d2">
                       <input type="text" name="d3" id="d3">
                       <input type="text" name="d4" id="d4">
					  <input type="submit" name="submit" value="Fetch">
					   </form>
					   
                        <br class="clear">
                    </article>
                    <!-- /article -->
                <?php endwhile; ?>
                <?php else: ?>
                    <!-- article -->
                    <article>
                        <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
                    </article>
                    <!-- /article -->
                <?php endif; ?>
            </section>
            <!-- /section -->
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php get_footer(); ?>
