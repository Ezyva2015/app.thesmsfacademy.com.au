<?php get_header(); ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<?php get_sidebar(); ?>
	<!-- BEGIN CONTENT -->

	//Template Name: Order Form

	

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
							if(empty($post->post_parent)){
								$link = '<a href="'.$post->post_name.'">'.get_the_title( $post->ID ).'</a>';	
							}
							else {
								$ancestors = get_post_ancestors( $post );
								
								foreach($ancestors as $ancestor){
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
				<?php the_content(); ?>
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
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tpo10_files/tpo10_js_scripts.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tpo10_files/spin-js/spin.min.js"></script>


<script>
	jQuery(document).ready(function(){
		jQuery('#input_65_145').change(function(event) {
		jQuery('#input_65_14, #input_65_20, #input_65_117, #input_65_22, #input_65_118, #input_65_24, #input_65_119, #input_65_23, #input_65_120 ').val('');
			event.preventDefault();
			data = jQuery(this).serialize();
			jQuery.ajax({
				type: "POST",
				url: "<?php echo get_template_directory_uri();?>/template-companydetails2.php",
				data: data
			}).done(function( response ) {
				//alert( "Data Saved: " + response );
				var result = jQuery.parseJSON(response);
					result['companyName']; // return 'John'
					jQuery('#input_65_18').val(result['companyAddress']);
					jQuery('#input_65_14').val(result['companyName']);
					
					var d1 = result['d1'].split(' ');
					
					jQuery('#input_65_20').val(d1[0]);
					jQuery('#input_65_117').val(d1[1]);
					
					if(result['numdirs'] > 1){
						
						if(jQuery('#choice_65_21_1').attr('checked')){
							jQuery('#choice_65_21_1').parent().addClass('checked');
						}else{	
							jQuery('#choice_65_21_1').click();
							jQuery('#choice_65_21_1').parent().addClass('checked');
						}
						
						
						var d2 = result['d2'].split(' ');
						jQuery('#field_65_22').show();
						jQuery('#field_65_118').show();
						jQuery('#input_65_22').val(d2[0]);
						jQuery('#input_65_118').val(d2[1]);
					}
					if(result['numdirs'] > 2){
						if(jQuery('#choice_65_21_2').attr('checked')){
							jQuery('#choice_65_21_2').parent().addClass('checked');
						}else{	
							jQuery('#choice_65_21_2').click();
							jQuery('#choice_65_21_2').parent().addClass('checked');
						}
						
						var d3 = result['d3'].split(' ');
						jQuery('#field_65_24').show();
						jQuery('#field_65_119').show();
						jQuery('#input_65_24').val(d3[0]);
						jQuery('#input_65_119').val(d3[1]);
						
					}
					if(result['numdirs'] > 3){
						if(jQuery('#choice_65_21_3').attr('checked')){
							jQuery('#choice_65_21_3').parent().addClass('checked');
						}else{	
							jQuery('#choice_65_21_3').click();
							jQuery('#choice_65_21_3').parent().addClass('checked');
						}
						
						var d4 = result['d4'].split(' ');
						jQuery('#field_65_23').show();
						jQuery('#field_65_120').show();
						jQuery('#input_65_23').val(d4[0]);
						jQuery('#input_65_120').val(d4[1]);
						
					}
					//
					//jQuery('#d3').val(result['d3']);
					//jQuery('#d4').val(result['d4']);
			});
		});
	
	   
	});
</script>

<!--FSHEEN S0LUTIONS-->



<script>
	jQuery(document).ready(function(){
		jQuery('#input_65_147').change(function(event) {
			jQuery('#input_65_77, #input_65_75, #input_65_125, #input_65_126, #input_65_78, #input_65_127, #input_65_79, #input_65_128').val('');
			event.preventDefault();
			data = jQuery(this).serialize();
			jQuery.ajax({
				type: "POST",
				url: "<?php echo get_template_directory_uri();?>/template-companydetails2.php",
				data: data
			}).done(function( response ) {
				//alert( "Data Saved: " + response );
				var result = jQuery.parseJSON(response);
					result['companyName']; // return 'John'
					jQuery('#input_65_73').val(result['companyAddress']);
					jQuery('#input_65_69').val(result['companyName']);
					
					var d1 = result['d1'].split(' ');
					jQuery('#input_65_75').val(d1[0]);
					jQuery('#input_65_125').val(d1[1]);
					
					if(result['numdirs'] > 1){
						jQuery('#label_65_76_1').parent().addClass('checked');
						var d2 = result['d2'].split(' ');
						jQuery('#field_65_77').show();
						jQuery('#input_65_77').val(d2[0]);
						jQuery('#input_65_126').val(d2[1]);
					}
					if(result['numdirs'] > 2){
						jQuery('#label_65_76_2').parent().addClass('checked');
						var d3 = result['d3'].split(' ');
						jQuery('#field_65_78').show();
						jQuery('#input_65_78').val(d3[0]);
						jQuery('#input_65_127').val(d3[1]);
						
					}
					if(result['numdirs'] > 3){
						jQuery('#label_65_76_3').parent().addClass('checked');
						var d4 = result['d4'].split(' ');
						jQuery('#field_65_79').show();
						jQuery('#input_65_79').val(d4[0]);
						jQuery('#input_65_128').val(d4[1]);
						
					}
					//
					//jQuery('#d3').val(result['d3']);
					//jQuery('#d4').val(result['d4']);
			});
		});
	
	   
	});
</script>



<!-- <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tpo10_files/bootbox_js/bootbox.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/tpo10_files/editcombobox/style.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/tpo10_files/editcombobox/custom-style.css" /> -->
<!-- <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tpo10_files/editcombobox/jquery.combobox.js"></script> -->
	
<!-- END CONTAINER -->
<?php get_footer(); ?>
