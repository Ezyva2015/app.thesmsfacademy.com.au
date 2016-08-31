<?php get_header(); ?>

	<main role="main" class="page-container">
        <?php get_sidebar(); ?>
		<section class="page-content-wrapper">
            <div class="page-content">
                <h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>

                <?php get_template_part('loop'); ?>

                <?php get_template_part('pagination'); ?>
            </div>
		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>
