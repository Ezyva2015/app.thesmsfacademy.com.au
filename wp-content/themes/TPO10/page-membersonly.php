<?php /* Template Name: Members Only Template */ get_header(); ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h1><?php the_title(); ?></h1>
            <!-- BEGIN PAGE HEADER-->

            <div class="page-bar">
                

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
<!-- END CONTAINER -->
<?php get_footer(); ?>
