<?php get_header(); ?>

<div class="page-container">
    <?php get_sidebar(); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <h1><?php _e( 'My Courses', 'html5blank' ); ?></h1>

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="/">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li> My Courses </li>
                </ul>

            </div>

            <div class="tiles">
                <?php if (have_posts()): while (have_posts()) : the_post(); ?>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class("tile bg-blue-steel text-center"); ?>>
                        <a href="<?php the_permalink(); ?>">
                            <div class="tile-body">
                                <!-- post thumbnail -->
                                <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail(array(120,120)); // Declare pixel size you need inside the array ?>
                                    </a>
                                <?php else: ?>
                                    <i class="fa fa-briefcase"></i>
                                <?php endif; ?>
                                <!-- /post thumbnail -->

                            </div>
                            <div class="tile-object">
                                <div class="name">
                                    <?php the_title(); ?>
                                </div>

                            </div>
                        </a>


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

                <?php endwhile; ?>

                <?php else: ?>

                    <!-- article -->
                    <article>
                        <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
                    </article>
                    <!-- /article -->

                <?php endif; ?>
            </div>

            <?php get_template_part('pagination'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
