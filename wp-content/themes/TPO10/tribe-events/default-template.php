<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */
 
 
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
							$links = '';
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

  

		<?php tribe_get_view(); ?>



             
            </section>
            <!-- /section -->


        </div>
    </div>
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
<?php get_footer(); ?>

