
<!-- BEGIN CONTAINER -->
<div class="page-container">

	<!-- BEGIN CONTENT -->

	<!-- Template Name: Login -->
	<div class="page-content-wrapper">
		<div class="page-content">

	<!-- section -->
		<section>

		<h1> This is the title </h1>
		
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
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/ezy_js_scripts.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tpo10_files/spin-js/spin.min.js"></script>

