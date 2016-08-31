<?php /* Template Name: Profile Page Template */ get_header(); ?>

<?php get_header(); ?>
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


                <?php if (have_posts()): while (have_posts()) : the_post(); ?>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                       <div class="row profile">
<div class="col-md-12">
<div id="tab_1_3" class="tab-pane">
<div class="row profile-account">

<div class="col-md-12">
<div class="tab-content">
<div id="tab_1-1" class="tab-pane active">
<?php echo do_shortcode("[gravityform id=3]"); ?>
</div>

</div>
</div>
<!--end col-md-9--></div>
</div>
</div>
<!--END TABS--></div>
<!-- END PAGE CONTENT-->
                        	
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


<?php get_footer(); ?>
