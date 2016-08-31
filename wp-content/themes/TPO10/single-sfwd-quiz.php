<?php get_header(); ?>

<div class="page-container">
    <?php get_sidebar(); ?>

    <main role="main" class="page-content-wrapper container">
        <!-- section -->
        <section class="page-content row">
            <div class="col-md-9">
                <?php if (have_posts()): while (have_posts()) : the_post(); ?>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <!-- post title -->
                        <h1>
                            <?php the_title(); ?>
                            <!--<a href="<?php /*the_permalink(); */?>" title="<?php /*the_title(); */?>"></a>-->
                        </h1>
                        <!-- /post title -->

                        <?php get_template_part('inc/page','breadcrumbs'); ?>

                        <!-- post details -->
                        <span class="date"><?php the_time('F j, Y'); ?></span>
                        <span class="author"><?php _e( 'Published by', 'html5blank' ); ?> <?php the_author_posts_link(); ?></span>
                        <!--<span class="comments"><?php /*if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); */?></span>-->
                        <!-- /post details -->

                        <!-- post thumbnail -->
                        <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
                            <div><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php the_post_thumbnail(); // Fullsize image for the single post ?>
                            </a></div>
                        <?php endif; ?>
                        <!-- /post thumbnail -->

                        <?php the_content(); // Dynamic Content ?>

                        <?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

                        <!--<p><?php /*_e( 'Categorised in: ', 'html5blank' ); the_category(', '); // Separated by commas */?></p>-->

                        <!--<p><?php /*_e( 'This post was written by ', 'html5blank' ); the_author(); */?></p>-->

                        <?php edit_post_link(); // Always handy to have Edit Post Links available ?>

                        <?php /*comments_template(); */?>

                    </article>
                    <!-- /article -->

                <?php endwhile; ?>

                <?php else: ?>

                    <!-- article -->
                    <article>

                        <h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

                    </article>
                    <!-- /article -->

                <?php endif; ?>
            </div>
            <aside class="col-md-3">
                <?php dynamic_sidebar('learndash_sidebar'); ?>
            </aside>

        </section>
        <!-- /section -->
    </main>

</div>

<?php get_footer(); ?>
