<?php get_header(); ?>

	<main role="main" class="page-container">
        <?php get_sidebar(); ?>
		<!-- section -->
		<section class="page-content-wrapper">
            <div class="page-content">
                <h1><?php _e( 'Categories for ', 'tpo10' ); single_cat_title(); ?></h1>

                <?php get_template_part('loop'); ?>

                <?php get_template_part('pagination'); ?>
            </div>
		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
