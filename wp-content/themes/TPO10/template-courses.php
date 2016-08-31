<?php /* Template Name: Courses Page Template */ get_header(); ?>

    <main role="main" class="page-container">
        <?php get_sidebar(); ?>
        <!-- section -->
        <section class="page-content-wrapper">
            <section class="page-content">

                <?php //if (have_posts()): the_post(); ?>
                    <h1><?php the_title(); ?></h1>

                    <?php get_template_part('inc/page','breadcrumbs'); ?>

                    <!--<article id="post-<?php /*the_ID(); */?>" <?php /*post_class(); */?>>
                        
                        <br class="clear">
                    </article>-->
                    <section class="tileslg">
                        <?php
                        $the_query = new WP_Query( array(
                            'post_type' => 'sfwd-courses',
                            'category_name'=> 'course',
                            /*'orderby'   => 'ID',
                            'order'     => 'ASC'*/
                        ) );
                        ?>
                        <?php if ($the_query->have_posts()): while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<?php //if (have_posts()): while (have_posts()) : the_post(); ?>
                            <!-- article -->
                            <article id="post-<?php the_ID(); ?>" <?php post_class("tilelg bg-blue-steel text-center"); ?>>
                                <a href="http://smsf101tsa.m101-training.com.au/">
                                    <div class="tilelg-body">
                                        <!-- post thumbnail -->
                                        	
                                            <i class="fa fa-briefcase"></i>
                                     
                                        <!-- /post thumbnail -->

                                    </div>
                                    <div class="tilelg-object">
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
                    </section>

                    <?php get_template_part('pagination'); ?>

                <?php //endif; ?>

            </section>

        </section>
        <!-- /section -->
    </main>


<?php get_footer(); ?>