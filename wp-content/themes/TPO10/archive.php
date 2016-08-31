<?php get_header(); ?>

<div class="page-container">
<?php get_sidebar(); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <h1><?php _e( 'Archives', 'html5blank' ); ?></h1>

            <?php get_template_part('loop'); ?>

            fooo

            <?php get_template_part('pagination'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
