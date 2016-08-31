<?php /*Template Name: Documents Navigation*/
get_header(); ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php get_sidebar(); ?>
    <!-- BEGIN CONTENT -->

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

                <div class="row search-container">
                    <input class="col-sm-8" id="search-text" type="text" placeholder="just start typing here ...">
                </div>

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

<!-- <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tpo10_files/bootbox_js/bootbox.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/tpo10_files/editcombobox/style.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/tpo10_files/editcombobox/custom-style.css" /> -->
<!-- <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/tpo10_files/editcombobox/jquery.combobox.js"></script> -->

<!-- END CONTAINER -->

<?php get_footer(); ?>
