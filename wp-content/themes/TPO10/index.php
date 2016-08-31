<?php get_header(); ?>

	<main role="main" class="page-container">
        <?php get_sidebar(); ?>
		<!-- section -->
		<section class="page-content-wrapper">
            <article class="page-content">
                <h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

                <?php get_template_part('loop'); ?>

                <?php get_template_part('pagination'); ?>
            </article>

		</section>
		<!-- /section -->
	</main>



<?php get_footer(); ?>
