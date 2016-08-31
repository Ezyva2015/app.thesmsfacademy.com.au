<?php

error_reporting(0);
header("X-XSS-Protection: 0");

require_once('includes/yearsBetweenDates.php');
require_once('includes/coy/company.php');
require_once('includes/dashboard.php');
require_once('includes/benchmark_calc.php');
require_once('inc/gform_default_render.php');
require_once('inc/gform-btn-save.php');
require_once('includes/ifs/Services/Infusionsoft/isdk.enhanced.php');
//require_once('includes/ifs/Services/Logger/Logger.php');


//Logger::$path = dirname(__FILE__).'/logs/log.txt';

function my_forcelogin_whitelist( $whitelist ) {
  	$whitelist[] = site_url( '/cron/mergedocs.php' );
	$whitelist[] = site_url( '/xmlrpc.php' );
  	return $whitelist;
}
add_filter('v_forcelogin_whitelist', 'my_forcelogin_whitelist', 10, 1);


function mysack_queue(){
wp_print_scripts(array('sack'));
}
add_action( 'admin_enqueue_scripts', 'mysack_queue' ); 
//display custom login message
add_action('register_form', 'login_form_message');
function login_form_message() {
    echo '<p>Custom Login Form Message</p>';
}

//Years between two fields
new GWYearCount( array(
    'form_id'        => 15,
    'start_field_id' => 70,
     'end_field_id'   => 110,
     'count_field_id' => 264
 ) );

//Years between two fields
new GWYearCount( array(
    'form_id'        => 87,
    'start_field_id' => 618,
     'end_field_id'   => 110,
     'count_field_id' => 629
 ) );
 
 
 //Years between two fields
new GWYearCount( array(
    'form_id'        => 74,
    'start_field_id' => 618,
     'end_field_id'   => 110,
     'count_field_id' => 629
 ) );
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
    External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
    Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
    'default-color' => 'FFF',
    'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
    'default-image'         => get_template_directory_uri() . '/img/headers/default.jpg',
    'header-text'           => false,
    'default-text-color'        => '000',
    'width'             => 1000,
    'height'            => 198,
    'random-default'        => false,
    'wp-head-callback'      => $wphead_cb,
    'admin-head-callback'       => $adminhead_cb,
    'admin-preview-callback'    => $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
    Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
    wp_nav_menu(
    array(
        'theme_location'  => 'header-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        //wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        //wp_enqueue_script('conditionizr'); // Enqueue it!

        //wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        //wp_enqueue_script('modernizr'); // Enqueue it!

        //wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        //wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
       // wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        //wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
   // wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    //wp_enqueue_style('normalize'); // Enqueue it!

    //wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    //wp_enqueue_style('html5blank'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{

}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    //return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    //return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
    <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
<?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
    <br />
<?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
        <?php
            printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php }

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination 
add_action( 'wp_enqueue_scripts', 'wpdocs_TPO10_scrpt_and_style' );


// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
//add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]


/*------------------------------------*\
    Register Menu
\*------------------------------------*/
function register_my_menus() {
  register_nav_menus(
    array(
      'sidebar-menu' => __( 'Sidebar Menu' ),
      'extra-menu' => __( 'Extra Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
    ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}



add_shortcode('support_tickets', 'tickets_shortcode');


function tickets_shortcode(){
        global $current_user;
        $email = $current_user->user_email;
        
        $tickets = new WC_Freshdesk_Tickets( 'https://library.thesmsfacademy.com.au/', 'ecQRnykjMLCZsasfkDnV', 0 );
        
        
        $display = $tickets->tickets_table( $email );
        //$display = $tickets->get_user_tickets( $email, 0 );
        //echo $tickets->tickets_table( $email );
        return $display;
    }



    
add_shortcode('support_articles', 'solution_category_shortcode');
add_shortcode('support_folders', 'solution_folder_shortcode');
add_shortcode('saved_orders', 'saved_orders_shortcode'); 
add_shortcode('completed_orders', 'completed_orders_shortcode');
add_shortcode('completed_order', 'completed_order_shortcode'); 




function saved_orders_shortcode(){
        global $wpdb;
        $view = rgget("type");

                if($view == "edit") {
                    $output = 'test-edit';
                    $lead_id = rgget("q");
                    $data = RGFormsModel::get_lead( $lead_id );
                    //echo "<script type='text/javascript'>alert('".$data['form_id']."');</script>";
                    if(!empty($data)){
                        $saveState = new GFStatefulForms();
                        add_filter( 'gform_pre_render', array( $saveState, 'try_restore_saved_state' ) );
                        gravity_form( $data["form_id"], false, false, false, '', false );

                    }
                    else {
                    $leads = $wpdb->get_results( $wpdb->prepare( "SELECT wp_rg_form_meta.display_meta, wp_rg_lead.orderStatus, wp_rg_lead.date_created, wp_rg_lead.id, wp_rg_lead.form_id, wp_rg_form.title FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'incomplete' ORDER BY wp_rg_lead.id DESC", wp_get_current_user()->ID )  );
                    foreach($leads as $lead){
                        $output .= '<tr><td>'.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td><a class="btn default btn-xs purple" href="https://app.thesmsfacademy.com.au/saved/documents/?q='.$lead->id.'&type=edit"><i class="fa fa-trash-o"></i> Resume</a> <a class="btn default btn-xs black" href="https://app.thesmsfacademy.com.au/wp-content/themes/TPO10/includes/dOrder.php?lid='.$lead->id.'"><i class="fa fa-trash-o"></i> Delete</a></tr></form>';
                    }
            
                    $output = '<table class="table table-striped table-bordered table-advance table-hover" width="100%"><thead><tr><th>Order ID</th><th>Reference</th><th>Type</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>'.$output.'</table>';
        
                    return $output;
                    }
                }
            else {

            $leads = $wpdb->get_results( $wpdb->prepare( "SELECT wp_rg_form_meta.display_meta, wp_rg_lead.orderStatus, wp_rg_lead.date_created, wp_rg_lead.id, wp_rg_lead.form_id, wp_rg_form.title FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'incomplete' ORDER BY wp_rg_lead.id DESC", wp_get_current_user()->ID )  );
            //$output = wp_get_current_user()->ID;
            foreach($leads as $lead){
                $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td><button class="btn default btn-xs purple" style="text-align: left; border:none;" onclick="SetHiddenFormSettingsTPO('.$lead->id.', \'update\',\''.get_action_link($lead->form_id, $lead->id, $wpdb).'\')"><i class="fa fa-edit"></i> Resume</button> <a class="btn default btn-xs black" href="https://app.thesmsfacademy.com.au/wp-content/themes/TPO10/includes/dOrder.php?lid='.$lead->id.'"><i class="fa fa-trash-o"></i> Delete</a></tr></form>';
            }
            
            $output = '<table class="table table-striped table-bordered table-advance table-hover" width="100%"><thead><tr><th>Order ID</th><th>Reference</th><th>Type</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>'.$output.'</table>';
        	$output = $output.'<form name="gravitylist" action="'.get_action_link($lead->form_id, $lead->id, $wpdb).'" method="post">
        <input type="hidden" id="gform_edit_id" name="gform_edit_id" value="" />
        <input type="hidden" id="gform_edit_mode" name="gform_edit_mode" value="" /></form>';  
            return $output;
            
            }
            
            
            
        
        
        
        
    }   




function get_pdf_file_url($form_id, $lead_id) {
    global $wpdb;
    $mylink = $wpdb->get_row( "SELECT * FROM wp_tpl_docs WHERE lead_id = $lead_id and form_id = $form_id ", ARRAY_A ); 
    return $mylink['file_url'];
} 
function completed_order_shortcode(){

        global $wpdb;
        //global $gfpdf;
        $output = '';
        $leads = $wpdb->get_results( $wpdb->prepare( "SELECT wp_tpl_docs.file_url, wp_rg_lead.unique_id, wp_rg_form_meta.display_meta, wp_rg_lead.orderStatus, wp_rg_lead.date_created, wp_rg_lead.id, wp_rg_lead.form_id, wp_rg_form.title, wp_rg_lead.eco_ref, wp_rg_lead.asic_status FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_tpl_docs ON wp_rg_lead.id = wp_tpl_docs.lead_id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'complete' ORDER BY wp_rg_lead.id DESC", wp_get_current_user()->ID )  ); 
 
		 foreach($leads as $lead){
		 } 
		 $output = '<script src="/scripts/sorttable.js"></script><table class="table table-striped table-bordered table-advance table-hover sortable footable" style="width:95%!important;"><thead><tr><th>Order ID</th><th>Reference</th><th>Entity</th><th>Type</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>'.$output.'
		<tfoot class="hide-if-no-paging pagination-centered">
			<tr>
				<td colspan="7">
					<div class="pagination"></div>
				</td>
			</tr>
		</tfoot></table>';
        $output = $output.'<form name="gravitylist" action="'.get_action_link($lead->form_id, $lead->id, $wpdb).'" method="post">
        <input type="hidden" id="gform_edit_id" name="gform_edit_id" value="" />
        <input type="hidden" id="gform_edit_mode" name="gform_edit_mode" value="" /></form>';


        return $output;

}



function completed_orders_shortcode(){


        global $wpdb;
        //global $gfpdf;
        $output = '';
        $leads = $wpdb->get_results( $wpdb->prepare( "SELECT wp_tpl_docs.file_url, wp_rg_lead.unique_id, wp_rg_form_meta.display_meta, wp_rg_lead.orderStatus, wp_rg_lead.date_created, wp_rg_lead.id, wp_rg_lead.form_id, wp_rg_form.title, wp_rg_lead.eco_ref, wp_rg_lead.asic_status FROM wp_rg_lead LEFT JOIN wp_rg_form ON wp_rg_lead.form_id = wp_rg_form.id LEFT JOIN wp_tpl_docs ON wp_rg_lead.id = wp_tpl_docs.lead_id LEFT JOIN wp_rg_form_meta ON wp_rg_lead.form_id = wp_rg_form_meta.form_id WHERE wp_rg_lead.created_by = %d AND wp_rg_lead.orderStatus = 'complete' ORDER BY wp_rg_lead.id DESC", wp_get_current_user()->ID )  ); 
 
		
        // echo "<div> This is the div</div>"; 
    $stop = 0;
        foreach($leads as $lead){


            $stop++;
            if((($lead->form_id == "11") || ($lead->form_id == "58")) AND $lead->eco_ref != ""){

                //is a company incorporation
                switch($lead->asic_status){
                    case "Order complete":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td>
                          <div class="btn-group">

                          <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Download
                            <span class="fa fa-caret-down"></span></a>
                          <ul class="dropdown-menu multi-level" style="min-width: 107px;">
                            <li class="dropdown-submenu">
                                <a tabindex="-1" class="btn-xs"href="#"><i class="fa fa-book fa-fw"></i> Documents</a>
                                <ul class="dropdown-menu" style="min-width: 107px;">
                                    <li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/corp/getDocs.php?orderid='.$lead->eco_ref.'">Direct Download</a></li>
                                    <li>2 <a href="https://app.thesmsfacademy.com.au/corp/getDocs.php?orderid='.$lead->eco_ref.'" class="dropbox-saver action-dropbox-options" data-filename="'.$lead->eco_ref.'.pdf">Save</a></li>
                                 
                                    <li>
                                       <div class="action-google-drive-options" >
                                            <div
                                            class="g-savetodrive"
                                            data-filename="'.$lead->eco_ref.'.pdf" data-sitename="TSA Campus"
                                            data-src="https://app.thesmsfacademy.com.au/corp/getDocs.php?orderid='.$lead->eco_ref.'">
                                            </div>
                                        </div>
                                    </li>

                            
                                </ul>
                            </li>
                            <li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/corp/getCert.php?orderid='.$lead->eco_ref.'"><i class="fa fa-certificate fa-fw"></i> Certificate</a></li>
                            <li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/corp/getCasFile.php?orderid='.$lead->eco_ref.'"><i class="fa fa-briefcase fa-fw"></i> CAS File</a></tr></li>
                            
                          </ul></div></tr></form>';
                    break;
                    
                    case "complete":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td>
                          <div class="btn-group">
                          <a class="btn-xs btn-primary " style="float: left; background-color: #4b8df8;" href="#"><i class="fa fa-download fa-fw"></i> Download</a>
                          <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#">
                            <span class="fa fa-caret-down"></span></a>
                          <ul class="dropdown-menu" style="min-width: 107px;">
                            <li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/corp/getDocs.php?orderid='.$lead->eco_ref.'"><i class="fa fa-book fa-fw"></i> Documents</a></li>
                            <li>3 <a href="https://app.thesmsfacademy.com.au/corp/getDocs.php?orderid='.$lead->eco_ref.'" class="dropbox-saver action-dropbox-options" ></a></li>
                            <li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/corp/getCert.php?orderid='.$lead->eco_ref.'"><i class="fa fa-certificate fa-fw"></i> Certificate</a></li>
                            <li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/corp/getCasFile.php?orderid='.$lead->eco_ref.'"><i class="fa fa-briefcase fa-fw"></i> CAS File</a></tr></li>
                          </ul></div></tr></form>';
                    break;
                    
                    case "Submitted to ASIC Temporarily reserved subject to ASIC decision":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td><i class="fa fa-refresh fa-spin"></i> Processing</tr></form>';
                    break;
                    
                    case "Submitted to ASIC":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td><i class="fa fa-refresh fa-spin"></i> Processing</tr></form>';
                    break;
                    
                    case "Checks":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td></tr></form>';
                    break;
                    
                    case "Rejected":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td><button class="btn-danger default btn-xs" style="width: 102px; text-align: left; border:none;" onclick="SetHiddenFormSettingsTPO('.$lead->id.', \'update\',\''.get_action_link($lead->form_id, $lead->id, $wpdb).'\')"><i class="fa fa-edit"></i> Amend</button></tr></form>';
                    break;
                    
                    case "Failed ASIC validation":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td><button class="btn-danger default btn-xs" style="width: 102px; text-align: left; border:none;" onclick="SetHiddenFormSettingsTPO('.$lead->id.', \'update\',\''.get_action_link($lead->form_id, $lead->id, $wpdb).'\')"><i class="fa fa-edit"></i> Amend</button></tr></form>';
                    break;
                    
                    case "Incomplete":
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td><button class="btn default btn-xs purple" style="width: 102px; text-align: left; border:none;" onclick="SetHiddenFormSettingsTPO('.$lead->id.', \'update\',\''.get_action_link($lead->form_id, $lead->id, $wpdb).'\')"><i class="fa fa-play"></i> Resume</button></tr></form>';
                    break;
                    
                    default:
                        $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->asic_status.'</td><td></tr></form>';
                
                }
                
                
            }
            
            //New Fund
            elseif($lead->form_id == "6") {
                $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td>
                <div class="btn-group">
                  <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Actions
                    <span class="fa fa-caret-down"></span></a>
                  <ul class="dropdown-menu" style="min-width: 107px;">
                    <li><a class="btn-xs" target="_blank" href="'.$lead->file_url.'"><i class="fa fa-book fa-fw"></i> Get Documents</a></li>
                    <li><a class="btn-xs" href="http://abn.thesmsfacademy.com.au/ABRWeb?uid='.$lead->unique_id.'" target="_blank"><i class="fa fa-laptop fa-fw"></i> Apply for ABN</a></li>

                    <li>   <a href="'.$lead->file_url.'" class="dropbox-saver action-dropbox-options" data-filename="'.$lead->form_id.$lead->id.'.pdf">  </a></li>
                     <li>
                        <div class="action-google-drive-options" >
                            <div
                                class="g-savetodrive"
                                data-filename="'.$lead->id.'.pdf"
                                data-sitename="TSA Campus"

                            </div> &nbsp; <span>To Google Drive</span>
                        </div>
                    </li>
                  </ul></div></tr></form>';
            }
            
             elseif($lead->form_id == "56") {
			 
			 
                $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td>
                <div class="btn-group">
                  <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Actions
                    <span class="fa fa-caret-down"></span></a>
                  <ul class="dropdown-menu" style="min-width: 107px;">
                    <li><a class="btn-xs" target="_blank" href="'.$lead->file_url.'"><i class="fa fa-book fa-fw"></i> Get Documents</a></li>
                    <li>   <a href="'.$lead->file_url.'" class="dropbox-saver action-dropbox-options" data-filename="'.$lead->form_id.$lead->id.'.pdf">  </a></li>
                     <li>
                        <div class="action-google-drive-options" >
                            <div
                                class="g-savetodrive"
                                data-filename="'.$lead->id.'.pdf"
                                data-sitename="TSA Campus"

                            </div> &nbsp; <span>To Google Drive</span>
                        </div>
                    </li>
                  </ul></div></tr></form>';
            }

            //SMSF Pension
            elseif(($lead->form_id == "15")){
			$result_arr = mysqli_fetch_array($result);
			$form_id = $lead->form_id.$lead->id;

			   
					while( $form_id = $result_arr) {
				 
						$output .=   '<tr><td>'.$form_id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td>
							<div class="btn-group">
							  <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Actions
								<span class="fa fa-caret-down"></span></a>
							  <ul class="dropdown-menu" style="min-width: 107px;">
								<li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/?gf_pdf=1&fid='.$lead->form_id.'&lid='.$lead->id.'&download=1&template=inv-strategy.php"><i class="fa fa-book fa-fw"></i> Documents</a></li>
								<li style="display:none" ><a class="btn-xs" href="https://app.thesmsfacademy.com.au/save-time/?fid='.$lead->form_id.'"><i class="fa fa-book fa-fw"></i> Reuse Data</a></li>
								<li>
									<a 

										class="dropbox-saver action-dropbox-options" 
										data-filename="'.$lead->form_id.$lead->id.'.pdf" >  
									</a> 
								</li> 
								 <li>
									<div class="action-google-drive-options" >
										<div
											class="g-savetodrive"
											data-filename="'.$lead->id.'.pdf"
											data-sitename="TSA Campus"

										</div> &nbsp; <span>To Google Drive</span>
									</div>
								</li> 
							  </ul></div></tr></form>';
				 
					}
            }

            //Investment Strategy
            elseif(($lead->form_id == "43")){
			$result_arr = mysqli_fetch_array($result);
			$form_id = $lead->form_id.$lead->id;

			   
					while( $form_id = $result_arr) {
				 
						$output .=   '<tr><td>'.$form_id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td>
							<div class="btn-group">
							  <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Actions
								<span class="fa fa-caret-down"></span></a>
							  <ul class="dropdown-menu" style="min-width: 107px;">
								<li><a class="btn-xs" href="https://app.thesmsfacademy.com.au/?gf_pdf=1&fid='.$lead->form_id.'&lid='.$lead->id.'&download=1&template=inv-strategy.php"><i class="fa fa-book fa-fw"></i> Documents</a></li>
								<li style="display:none" ><a class="btn-xs" href="https://app.thesmsfacademy.com.au/save-time/?fid='.$lead->form_id.'"><i class="fa fa-book fa-fw"></i> Reuse Data</a></li>
								<li>
									<a 

										class="dropbox-saver action-dropbox-options" 
										data-filename="'.$lead->form_id.$lead->id.'.pdf" >  
									</a> 
								</li> 
								 <li>
									<div class="action-google-drive-options" >
										<div
											class="g-savetodrive"
											data-filename="'.$lead->id.'.pdf"
											data-sitename="TSA Campus"

										</div> &nbsp; <span>To Google Drive</span>
									</div>
								</li> 
							  </ul></div></tr></form>';
				 
					}
   
            }

                //            href="https://app.thesmsfacademy.com.au/?gf_pdf=1&fid='.$lead->form_id.'&lid='.$lead->id.'&template='.$gfpdf->get_template($lead->form_id).'"
                //            echo "https://app.thesmsfacademy.com.au/wp-content/uploads/2013/03/numbers-ball_300x300-100x100.jpg";
                            //LRBA

                //            " template ' . $gfpdf->get_template($lead->form_id) . ' lead id = ' .
                //                     $lead->id . ' form id = ' .
                //                    $lead->form_id . '"
                //


            elseif($lead->form_id == "34") {
 
                    // if ( get_pdf_file_url($lead->form_id, $lead->id) != '' ) {  
                    //     $output .=  ' <div class="btn-group"> Processing.. </div>'; 
                    // } else { 
                     $result_arr = mysqli_fetch_array($result);
			$form_id = $lead->form_id.$lead->id;

			   
					while( $form_id = $result_arr) {
				 
						$output .=   '<tr><td>'.$form_id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td>'; 
                        $output .= '  
                        <td>
                        <div class="btn-group">
                          <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Actions
                          

                          <span class="fa fa-caret-down"></span></a> 
                          <ul class="dropdown-menu" style="min-width: 107px;">   
                             <li>
                                <div class="action-google-drive-options" >
                                    <div
                                        class="g-savetodrive"
                                        data-filename="'.$lead->id.'.pdf"
                                        data-sitename="TSA Campus"

                                    </div> &nbsp; <span>To Google Drive</span>
                                </div>
                            </li>
                          </ul> 
                        </div>
                      </tr>
                    </form>';
				 
					}
                   // end if
            } 

            elseif( 
                   ($lead->form_id == "53") || 
                   ($lead->form_id == "65") || 
                   ($lead->form_id == "73") || 
                   ($lead->form_id == "24") || 
                   ($lead->form_id == "34") || 
                   ($lead->form_id == "29") ||
                   //campus doc
                   //($lead->form_id == "6")  || // pointing to gf
                   ($lead->form_id == "55") || 
                   ($lead->form_id == "68") || // pointing to gf
                   ($lead->form_id == "62") || 
                   ($lead->form_id == "72") ||   
                   ($lead->form_id == "81")) { 
                // if ( get_pdf_file_url($lead->form_id, $lead->id) != '' ) {  
                //     $output .=  ' <div class="btn-group"> Processing.. </div>'; 
                // } else { 
                    $output .= '<tr><td>'.$lead->form_id.$lead->id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td>';
 
                     if(get_pdf_file_url($lead->form_id, $lead->id) == null ) { 
                        $output .=  '<td><i class="fa fa-refresh fa-spin"></i> Processing</tr></form>';
                    } else {  
                        $output .= '  
                        <td>
                        <div class="btn-group">
                          <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Actions
                          

                          <span class="fa fa-caret-down"></span></a> 
                          <ul class="dropdown-menu" style="min-width: 107px;">  
                            <li> <a class="btn-xs" href="'.get_pdf_file_url($lead->form_id, $lead->id).'" target="_blank"><i class="fa fa-book fa-fw"></i> Documents</a></li> <li> 
                             <li>
                                <div class="action-google-drive-options" >
                                    <div
                                        class="g-savetodrive"
                                        data-filename="'.$lead->id.'.pdf"
                                        data-sitename="TSA Campus"

                                    </div> &nbsp; <span>To Google Drive</span>
                                </div>
                            </li>
                          </ul> 
                        </div>
                      </tr>
                    </form>'; 
                 } // end if
            } 

            elseif(($lead->form_id == "60")){


				//Do nothing so that we exclude the ABR.GOV.AU Form
            } 


            // https://app.thesmsfacademy.com.au/wp-content/uploads/PDF_EXTENDED_TEMPLATES/pdfs/trustee-declaration.pdf 
            // <a  href="https://cf.dropboxstatic.com/static/images/developers/dropblox.png"  class="dropbox-saver action-dropbox-options dropbox-dropin-btn dropbox-dropin-default"   >  </a>


            elseif(($lead->form_id != "66") && ($lead->form_id != "71")) { 
               $result_arr = mysqli_fetch_array($result);
			$form_id = $lead->form_id.$lead->id;

			   
					while( $form_id = $result_arr) {
				 
						$output .=   '<tr><td>'.$form_id.'</td><td>'.get_reference($lead->form_id, $lead->id, $wpdb).'</td><td>'.get_name($lead->form_id, $lead->id, $wpdb).'</td><td>'.$lead->title.'</td><td>'.date("d/m/Y", strtotime($lead->date_created)).'</td><td>'.$lead->orderStatus.'</td><td>
                <div class="btn-group">
                  <a class="btn-xs btn-primary  dropdown-toggle" style="float: left; background-color: #4b8df8;" data-toggle="dropdown" href="#"><i class="fa fa-download fa-fw"></i> Actions
                    <span class="fa fa-caret-down"></span></a>
                  <ul class="dropdown-menu" style="min-width: 107px;">

                    <li style="display:none" ><a class="btn-xs" href="https://app.thesmsfacademy.com.au/save-time/?fid='.$lead->form_id.'"><i class="fa fa-book fa-fw"></i> Reuse Data</a></li>
                    <li>

                        <a 

                            class="dropbox-saver action-dropbox-options" 
                            data-filename="'.$lead->form_id.$lead->id.'.pdf" >

                        </a> 
                    </li> 
                    <li> 
                        <div class="action-google-drive-options" >
                            <div
                                class="g-savetodrive"
                                data-filename="'.$lead->id.'.pdf"
                                data-sitename="TSA Campus"

                            </div> &nbsp; <span>To Google Drive</span>
                        </div>

                    </li>
                  </ul></div></tr></form>';
				 
					}
            } 

            // dont show if list total displayed is 20
        } 


        $output = '<script src="/scripts/sorttable.js"></script>
		<link href="/wp-content/themes/TPO10/ubspaginate/css/footable.core.css" rel="stylesheet" type="text/css">
		<input style="height: 30px;" type="text" id="filter" placeholder="Search"><br><table class="table table-striped table-bordered table-advance table-hover sortable footable" style="width:95%!important;" data-filter="#filter"><thead><tr><th style="width: 90px;" data-toggle="true">Order ID</th><th data-hide="phone">Reference</th><th data-hide="phone">Entity</th><th data-type="numeric">Type</th><th data-type="numeric">Date</th><th data-hide="phone">Status</th><th data-hide="phone">Actions</th></tr></thead>'.$output.'
				<tfoot class="hide-if-no-paging pagination-centered">
					<tr>
						<td colspan="7">
							<div class="pagination"></div>
						</td>
					</tr>
                </tfoot></table>';
        $output = $output.'<form name="gravitylist" action="'.get_action_link($lead->form_id, $lead->id, $wpdb).'" method="post">
        <input type="hidden" id="gform_edit_id" name="gform_edit_id" value="" />
        <input type="hidden" id="gform_edit_mode" name="gform_edit_mode" value="" /></form>';


        return $output;
        
    }   
    
function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}



function get_sit_doc_link($form_id, $lead_id, $wpdb){
    
    $file_link = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT file_url FROM wp_tpl_docs WHERE form_id = %d AND lead_id = %d", $form_id, $lead_id) );
        
	return $file_link; 
}

    
function get_reference($form_id, $lead_id, $wpdb){
    $meta = RGFormsModel::get_form_meta( $form_id );
    $fields = $meta['fields'];
    $reference = '';
    foreach($fields as $field){
    	if($field->adminLabel == 'Reference'){
    		$id = $field->id;
    		$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
    		
    	} 
    	elseif($field->adminLabel == 'yourRef'){
    		$id = $field->id;
    		$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
    	} 
    }
    
	return $reference;
    
    
}

function get_name($form_id, $lead_id, $wpdb){
    $meta = RGFormsModel::get_form_meta( $form_id );
    $fields = $meta['fields'];
    $reference = '';
    if(($form_id == '11') || ($form_id == '58')){
		foreach($fields as $field){
			if($field->adminLabel == 'companyName'){
				$id = $field->id;
				$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
			
			} 
			elseif($field->adminLabel == 'companySuffix'){
				$id = $field->id;
				$reference = $reference.' '.$wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
			} 
		}
    }
    elseif(($form_id == '52') || ($form_id == '6')){
    	foreach($fields as $field){
			if($field->adminLabel == 'fundName'){
				$id = $field->id;
				$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
			
			} 
			
		}
    
    }
    
    elseif($form_id == '56'){
    	
				$id = '11';
				$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
		
    
    }
    elseif(($form_id == '15') || ($form_id == '24') || ($form_id == '36')){
    	
				$id = '1';
				$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
		
    
    }
    elseif($form_id == '43'){
    	
				$id = '46';
				$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
		
    
    }
    elseif($form_id == '22'){
    	
				$id = '23';
				$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
		
    
    }
    elseif(($form_id == '53') || ($form_id == '65')){
    	
				$id = '9';
				$reference = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT value FROM wp_rg_lead_detail WHERE form_id = %d AND lead_id = %d AND field_number = %d", $form_id, $lead_id, $id ) );
		
    
    }
   
    
	return $reference;
    
    
}

function get_action_link($form_id, $lead_id, $wpdb){
    $meta = RGFormsModel::get_form_meta( $form_id );
    $action_link = get_permalink($meta['spgfle_gfediturl']);
    return $action_link;
}

function solution_category_shortcode(){
        //$articles = new WC_Freshdesk_Tickets( 'https://prepared.paratus.com.au/', '6h7nB5pNw4M6yGqXD4yO', 0 );
        
        $categories = $articles->get_categories();
        foreach ($categories as $category){
            $response = $response.' <li>'.$category['category']['name'].' (ID: '.$category['category']['id'].');</li>'; 
        }
        return print_r($response, true);
    }   
    

function solution_folder_shortcode($category_id){
        //$articles = new WC_Freshdesk_Tickets( 'https://prepared.paratus.com.au/', '6h7nB5pNw4M6yGqXD4yO', 0 );
        $category_id = '1000023244';
        $category = $articles->get_folders($category_id);
        $folders = $category['category']['folders'];
        foreach ($folders as $folder){
            $response = $response.' <li>'.$folder['name'].' (ID: '.$folder['id'].');</li>'; 
            
        }
        
        //return print_r($folders['category']['folders'], true);
        return print_r($response, true);
    }       


function my_enqueue() {

    wp_register_style( 'ezy_custom_wp_admin_css', get_template_directory_uri() . '/tpo10_files/ezy_admin_styles.css', false, '1.0.0' );
    wp_enqueue_style( 'ezy_custom_wp_admin_css' );
}

add_action( 'admin_enqueue_scripts', 'my_enqueue' );

/* Add a custom field to the field editor (See editor screenshot) */
add_action("gform_field_standard_settings", "my_standard_settings", 10, 2);

function my_standard_settings($position, $form_id){

    // Create settings on position 25 (right after Field Label)

    if($position == 0){
    ?>
    <li class="admin_label_setting field_setting ezy_custom_field" style="display: list-item;">
        <label for="field_ezy_custom_attribute">Ezy Custom Attribute

            <!-- Tooltip to help users understand what this field does -->
            <a href="javascript:void(0);" class="tooltip tooltip_form_field_placeholder" tooltip="&lt;h6&gt;Ezy Custom Attribute&lt;/h6&gt;Enter the value/default text for this field.">(?)</a>

        </label>

        <input type="text" id="field_ezy_custom_attribute" class="fieldwidth-3" size="35" onkeyup="SetFieldProperty('ezy_custom_attribute', this.value);">

    </li>
    <li class="admin_label_setting field_setting ezy_custom_field" style="display: list-item;">
        <label for="field_ezy_css_class">Ezy CSS Class

            <!-- Tooltip to help users understand what this field does -->
            <a href="javascript:void(0);" class="tooltip tooltip_form_field_placeholder" tooltip="&lt;h6&gt;Ezy CSS Class&lt;/h6&gt;Enter the value/default text for this field.">(?)</a>

        </label>

        <input type="text" id="field_ezy_css_class" class="fieldwidth-3" size="35" onkeyup="SetFieldProperty('ezy_css_class', this.value);">

    </li>
    <?php
    }
}
/* Now we execute some javascript technicalitites for the field to load correctly */

add_action("gform_editor_js", "my_gform_editor_js");

function my_gform_editor_js(){
?>
    <script>
        //binding to the load field settings event to initialize the checkbox
        jQuery(document).bind("gform_load_field_settings", function(event, field, form){
            jQuery("#field_ezy_custom_attribute").val(field["ezy_custom_attribute"]);
            jQuery("#field_ezy_css_class").val(field["ezy_css_class"]);
        });
    </script>

<?php
}

/* We use jQuery to read the placeholder value and inject it to its field */

add_action('gform_enqueue_scripts',"my_gform_enqueue_scripts", 10, 2);

function my_gform_enqueue_scripts($form, $is_ajax=false){
?>
<script>
    
    jQuery( document ).ready( function(){
    <?php
        
        /* Go through each one of the form fields */
        
        foreach($form['fields'] as $i=>$field){
            
            /* Check if the field has an assigned placeholder */
            
            if(isset($field['ezy_custom_attribute']) && !empty($field['ezy_custom_attribute'])){
                
                /* If a placeholder text exists, inject it as a new property to the field using jQuery */
                
            ?>
            
            jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').attr('ezy_custom_attribute','<?php echo $field['ezy_custom_attribute'] ?>');
            
            <?php
            }
            
            if(isset($field['ezy_css_class']) && !empty($field['ezy_css_class'])){
                
                /* If a placeholder text exists, inject it as a new property to the field using jQuery */
                
            ?>
            
            jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').addClass('<?php echo $field['ezy_css_class'] ?>');
            
            <?php
            }
        }
    ?>
    });
</script>
<?php
}




function guid(){
            
                mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
                $charid = strtoupper(md5(uniqid(rand(), true)));
                $hyphen = chr(45);// "-"
                $uuid = 
                        substr($charid, 0, 8).$hyphen
                        .substr($charid, 8, 4).$hyphen
                        .substr($charid,12, 4).$hyphen
                        .substr($charid,16, 4).$hyphen
                        .substr($charid,20,12);
                return $uuid;
            
        }

/* Change entry orderStatus to complete */
add_action("gform_post_submission", "set_post_content", 10, 2);
function set_post_content($entry, $form){
     //$headers[] = "Content-type: text/html";
    $pending_meta_value = gform_get_meta($entry["id"], "is_pending");
    if($pending_meta_value == "1"){
       // wp_mail('tim@automationlab.com.au', 'Form has been saved', print_r($entry, true), $headers);
        $entry["orderStatus"] = "incomplete";
        $output = GFAPI::update_entry($entry, $entry["id"]);
    }
    else {
        $entry["orderStatus"] = "complete";
        $entry["unique_id"]   = guid();
        //wp_mail('tim@automationlab.com.au', 'Getting the Gravity Form Field IDs', print_r($entry, true), $headers);
        //wp_mail('tim@automationlab.com.au', 'Getting the Gravity Form Data', print_r($form, true), $headers);
        $output = GFAPI::update_entry($entry, $entry["id"]);
        global $wpdb;
        //look up row in lead table, update asic status and update with eCompanies order number.
        $update = $wpdb->query( $wpdb->prepare("UPDATE wp_rg_lead SET unique_id='".$entry["unique_id"]."' WHERE id=".$entry['id']." AND form_id=".$entry['form_id']) );
       // wp_mail('tim@automationlab.com.au', 'Getting the Gravity Form Field IDs', print_r($update, true), $headers);
    }
    
}




function learndash_sidebar() {
    register_sidebar( array(
        'name' => 'LearnDash Sidebar',
        'id' => 'learndash_sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'learndash_sidebar' );



//$body = corp_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
add_action("gform_post_submission_11", "corp_post_Data", 10, 2);
add_action("gform_post_submission_58", "sp_corp_post_Data", 10, 2);
 function send_coy_data($entry, $form){
    $fieldString = '';
    foreach($form['fields'] as $field){
        $fieldString = $fieldString.' Field ID: '.$field['id'].' Label: '.$field['label'].'<br/>';
    }
 //$message = print_r($form, true);
 // In case any of our lines are larger than 70 characters, we should use wordwrap()
// $message = wordwrap($message, 70);
 // Send
 $headers[] = "Content-type: text/html";
 wp_mail('tim@automationlab.com.au', 'Getting the Gravity Form Field IDs', $fieldString, $headers);
 wp_mail('tim@automationlab.com.au', 'Getting the Gravity Form Data', print_r($form, true), $headers);
 
 }


 add_shortcode('integrations', 'integrations_shortcode');
 
function integrations_shortcode(){
        
        $response = '<div class="tiles">
                <div class="tile bg-blue-steel">
                    <a href="/abr-gov-au/">
                    <div class="tile-body">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                             ABR.GOV.AU
                        </div>
                    </div>
                    </a>
                </div>
                <div class="tile bg-red-sunglo">
                    <div class="tile-body">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                             Google Apps
                        </div>
                        <div class="number">
                             
                        </div>
                    </div>
                </div>
                <div class="tile selected bg-yellow-saffron">
                    <div class="corner">
                    </div>
                    <div class="check">
                    </div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                             Infusionsoft
                        </div>
                        <div class="number">
                             
                        </div>
                    </div>
                </div>
                <div class="tile selected bg-purple-studio">
                <div class="corner">
                    </div>
                    <div class="check">
                    </div>
                    <div class="tile-body">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                             Xero Practice Manager
                        </div>
                        <div class="number">
                            
                        </div>
                    </div>
                </div>
                <div class="tile selected bg-green-meadow">
                <div class="corner">
                    </div>
                    <div class="check">
                    </div>
                    <div class="tile-body">
                        <i class="fa fa-comments"></i>
                    </div>
                    
                    <div class="tile-object">
                        <div class="name">
                             Macquarie CMA
                        </div>

                    </div>
                </div>
                <div class="tile bg-red-intense">
                    <div class="tile-body">
                        <i class="fa fa-coffee"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                             BGL360
                        </div>
                    </div>
                </div>
                <div class="tile bg-green">
                    <div class="tile-body">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                             Class Super
                        </div>
                        <div class="number">
                        </div>
                    </div>
                </div>
                <div class="tile bg-blue-steel">
                    <div class="tile-body">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                             XPlan
                        </div>
                    </div>
                </div>
            </div>';
            
            return $response;

}
add_filter('gform_register_init_scripts', 'gform_auto_populate_address');
function gform_auto_populate_address($form) {  
    $script = '(function($){
                var g_addr = [];';
    $script .= '
      $(".p_addr").find("div input[type=text]").blur(function() {
          getAddressFieldValues();
      });
      $(".p_addr").find("div textarea").blur(function() {
          getAddressFieldValues();
      });
      getAddressFieldValues();
      function getAddressFieldValues(){   
         var part_adds = $(".part_addr");
         var add1 = "";
         var options = "";
         var select_opt = "<select class=\'addrs_drop\'><option value=\"\">Choose an address from the list</option>";
         
         /* for first address*/
         $.each(part_adds,function(ky,vl){
             if($(this).find("div input[type=text]").val() && $(this).find("div input[type=text]").val() != "")
                add1 += $(this).find("div input[type=text]").val()+" , ";
             else if($(this).find("div div a span").html() && $(this).find("div div a span").html() != "")
                add1 +=  $(".state").find(".ginput_container .chosen-container-single .chosen-single").text()+" , ";
                
         })
         
         if(add1 !="" && typeof add1 != "undefined")
         {
             add1 = add1.substring(0,add1.length - 2)
             select_opt += "<option value=\""+add1+"\">"+add1+"</option>";
         }

         /* for remaining address (text areas)*/
         var fields = $(".p_addr");
         $.each(fields,function(key,value){
             var k = key+1;
             var adds = "";
             if(!$(this).hasClass("part_addr"))
             {
                 if($(this).find("div input[type=text]").length)
                 {
                     if($(this).find("div input[type=text]").val() != "")
                     {
                         adds = $(this).find("div input[type=text]").val();
                         if(adds !="" && typeof adds != "undefined")
                         {
                            select_opt += "<option value=\""+adds+"\">"+adds+"</option>";
                         } 
                     }
                 }
                 else if($(this).find("div textarea").length)
                 {
                     if($(this).find("div textarea").val() != "")
                     {
                         adds = $(this).find("div textarea").val();
                         if(adds !="" && typeof adds != "undefined")
                         {
                            select_opt += "<option value=\""+adds+"\">"+adds+"</option>";
                         }
                     }
                 }
             }
         });
         select_opt += "</select>";
         var app_add = $(".full_add");
         $.each(app_add,function(keys,vals){
             var contaner = $(this).find(".ginput_container");
             if(contaner.find(".addrs_drop"))
                 contaner.find(".addrs_drop_container").remove()
             contaner.prepend("<div class=\"addrs_drop_container\" style=\"padding:0px 0px 15px 0px\"></div>");
             contaner.find(".addrs_drop_container").html(select_opt);
         });
      }
      
      $(".addrs_drop").live("change",function(){
  
    var txt_bx = $(this).closest(".ginput_container").find("input[type=text]");
    var txt_area = $(this).closest(".ginput_container").find("textarea");
    var address = $(this).val();
    if(txt_bx.length != 0) {
    txt_bx.val($(this).val()); 
   }
    else {
    txt_area.html($(this).val()); // populates textarea va;ue in html
    txt_area.val($(this).val());  // populates textarea value
   }
      
   });
      
      
    })(jQuery);';
    GFFormDisplay::add_init_script($form['id'], 'auto_populate_address', GFFormDisplay::ON_PAGE_RENDER, $script);
    
    return $form;
}

add_filter('gform_register_init_scripts', 'gform_auto_populate_postcode');
function gform_auto_populate_postcode($form) {
    
    $form_id = $form["id"];
    
    $script = '(function($){';
    $script .= ' var form_id = "'.$form_id.'"';
    $script .= '
        var post_code_array = new Array();
        post_code_array = {"New South Wales" : {0:2,1:1} , "Queensland" : {0:4,1:9} ,"South Australia" : {0:5},"The Northern Territory" : {0:0},"Tasmania": {0:7},"Victoria" : {0:3,1:8} ,"Western Australia" : {0:6}, "Australian Capital Territory" : {0:2,1:0} };
        
        $(".post_code").find("div input[type=text]").focus(function() {
            var state = $(".state").find(".ginput_container .chosen-container-single .chosen-single").text();
            var val = $(this).val();
            var post_code = post_code_array[state];
            if(val.length == 0 )
                $(this).val(post_code_array[state][0]);
            else
            {
                var f_ltr = val.charAt(0);
                var is_ex = false;
                $.each(post_code,function(k,v){
                    if(f_ltr == v) { is_ex = true; return false; }
                });         
                if(is_ex == false)
                    $(this).val(post_code_array[state][0]);
            }

        });
        $(".post_code").find("div input[type=text]").bind("keydown", function(e) {
            var maxlen = 4;
            var key = (e.keyCode ? e.keyCode : e.which);
            var val = $(this).val();
            var act_keys = [8,9,35,36,37,38,39,40,46];
            var key_codes = [48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105];
            if(val.length >= maxlen && $.inArray(key, act_keys) == -1)
                e.preventDefault(); 
            else if($.inArray(key, key_codes) == -1 && $.inArray(key, act_keys) == -1)
                e.preventDefault();
        });
        $(".post_code").find("div input[type=text]").blur(function() {
            var val = $(this).val();
            var len = 4;
            var state = $(".state").find(".ginput_container .chosen-container-single .chosen-single").text();
            var post_code = post_code_array[state];
            var f_ltr = val.charAt(0);
            var is_ex = false;
            $.each(post_code,function(k,v){
                if(f_ltr == v) { is_ex = true; return false; }
            });
            if(is_ex == false || val.length != len)
                $(this).val("");
        });
    })(jQuery);';
    GFFormDisplay::add_init_script($form['id'], 'auto_populate_postcode', GFFormDisplay::ON_PAGE_RENDER, $script);
    return $form;
}

function gformList($content){
   if(isset($_GET['foid']) && !empty($_GET['foid']) && is_page('save-time')){

        $content = "[gravitylistcomplete id=".$_GET['foid']." requirelogin=false displayLead=true]";
    }
    return $content;
}
add_filter( 'the_content', 'gformList', 999999999, 1 );


add_filter("gform_field_value_years", "populate_years");

add_filter("gform_field_value_yearsthreecolumns", "populate_yearsthreecolumns");
add_filter("gform_field_value_agebrackets", "populate_agebrackets");
add_filter("gform_field_value_list", "populate_list", 800);

add_filter("gform_column_input_39_56_2", "set_column", 801, 5);
add_filter("gform_column_input_39_56_3", "set_column", 801, 5);
add_filter("gform_column_input_39_56_4", "set_column", 801, 5);

add_filter("gform_column_input_43_67_2", "set_column", 801, 5);
add_filter("gform_column_input_43_67_3", "set_column", 801, 5);
add_filter("gform_column_input_43_67_4", "set_column", 801, 5);




add_filter("gform_column_input_43_65_2", "set_column_members", 801, 5);
add_filter("gform_column_input_43_66_2", "set_column_members", 801, 5);


if(!function_exists('populate_years')){
function populate_years($value){
    return array(
        "Year 1", " ",
        "Year 2", " ",
        "Year 3", " ",
        "Year 4", " ",
        "Year 5", " ",
        "Year 6", " ",
        

    );

}
}


if(!function_exists('populate_yearsthreecolumns')){
function populate_yearsthreecolumns($value){
    return array(
        "Year 1", " "," ",
        "Year 2", " "," ",
        "Year 3", " "," ",
        "Year 4", " "," ",
        "Year 5", " "," ",
        "Year 6", " "," ",
        

    );

}
}


if(!function_exists('populate_agebrackets')){
function populate_agebrackets($value){
    return array(
        "Less than 40 years", "",
        "41-49 years", "",
        "50-59 years", "",
        "60-64 years", "",
        "65-69 years", "",
        "70 years and over", "",
        

    );

}
}

if(!function_exists('set_column')){
function set_column($input_info, $field, $column, $value, $form_id){

    return array("type" => "select", "choices" => "0%,5%,10%,15%,20%,25%,30%,35%,40%,45%,50%,55%,60%,65%,70%,75%,80%,85%,90%,95%,100%");

}
}

if(!function_exists('set_members')){
function set_members($input_info, $field, $column, $value, $form_id){

    return array("type" => "select", "choices" => "1,2,3,4");

}
}

function set_years($input_info, $field, $column, $value, $form_id){

    return array(
        "Year A",
        "Year B",
        "Year C", 
        "Year D", 
        "Year E", 
        "Year F",
    );

}


if(!function_exists('set_column_members')){
function set_column_members($input_info, $field, $column, $value, $form_id){

    return array("type" => "select", "choices" => "0,1,2,3,4");

}
}


if(!function_exists('populate_list')){
function populate_list($value){
    return array(
        "Aust. Shares", " ", " ", " ",
        "Aust. Fixed Interest", " ", " ", " ",
        "Cash", " ", " ", " ",
        "Direct Property", " ", " ", " ",
        "Int. Shares", " ", " ", " ",
        "Int. Fixed Interest", "", " ", " ",
        "Listed Property", " ", " ", " ",
        "Mortgages", " ", " ", " ",
        "Other", " ", " ", " "

    );

}
}

new GWAutoListFieldRows( array(
    'form_id' => 39,
    'list_field_id' => 56,
    'input_html_id' => '#input_39_62'
) );


class GWAutoListFieldRows {

    private static $_is_script_output;

    function __construct( $args ) {

        $this->_args = wp_parse_args( $args, array(
            'form_id'       => false,
            'input_html_id' => false,
            'list_field_id' => false
        ) );

        extract( $this->_args ); // gives us $form_id, $input_html_id, and $list_field_id

        if( ! $form_id || ! $input_html_id || ! $list_field_id )
            return;

        add_filter( 'gform_pre_render_' . $form_id, array( $this, 'pre_render' ) );

    }

    function pre_render( $form ) {
        ?>

        <style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $this->_args['list_field_id']; ?> .gfield_list_icons { display: none; } </style>

        <?php

        add_filter( 'gform_register_init_scripts', array( $this, 'register_init_script' ) );

        if( ! self::$_is_script_output )
            $this->output_script();

        return $form;
    }

    function register_init_script( $form ) {

        // remove this function from the filter otherwise it will be called for every other form on the page
        remove_filter( 'gform_register_init_scripts', array( $this, 'register_init_script' ) );

        $args = array(
            'formId'      => $this->_args['form_id'],
            'listFieldId' => $this->_args['list_field_id'],
            'inputHtmlId' => $this->_args['input_html_id']
        );

        $script = "new gwalfr(" . json_encode( $args ) . ");";
        $key = implode( '_', $args );

        GFFormDisplay::add_init_script( $form['id'], 'gwalfr_' . $key , GFFormDisplay::ON_PAGE_RENDER, $script );

    }

    function output_script() {
        ?>

        <script type="text/javascript">

            window.gwalfr;

            (function($){

                gwalfr = function( args ) {

                    this.formId      = args.formId,
                        this.listFieldId = args.listFieldId,
                        this.inputHtmlId = args.inputHtmlId;

                    this.init = function() {

                        var gwalfr = this,
                            triggerInput = $( this.inputHtmlId );

                        // update rows on page load
                        this.updateListItems( triggerInput, this.listFieldId, this.formId );

                        // update rows when field value changes
                        triggerInput.change(function(){
                            gwalfr.updateListItems( $(this), gwalfr.listFieldId, gwalfr.formId );
                        });

                    }

                    this.updateListItems = function( elem, listFieldId, formId ) {

                        var listField = $( '#field_' + formId + '_' + listFieldId ),
                            count = parseInt( elem.val() );
                        rowCount = listField.find( 'table.gfield_list tbody tr' ).length,
                            diff = count - rowCount;

                        if( diff > 0 ) {
                            for( var i = 0; i < diff; i++ ) {
                                listField.find( '.add_list_item:last' ).click();
                            }
                        } else {

                            // make sure we never delete all rows
                            if( rowCount + diff == 0 )
                                diff++;

                            for( var i = diff; i < 0; i++ ) {
                                listField.find( '.delete_list_item:last' ).click();
                            }

                        }
                    }

                    this.init();

                }

            })(jQuery);

        </script>

    <?php
    }

}


new GWRequireListColumns(39,56);

class GWRequireListColumns {

    private $field_ids;

    public static $fields_with_req_cols = array();

    function __construct($form_id = '', $field_ids = array(), $required_cols = array()) {

        $this->field_ids = ! is_array( $field_ids ) ? array( $field_ids ) : $field_ids;
        $this->required_cols = ! is_array( $required_cols ) ? array( $required_cols ) : $required_cols;

        if( ! empty( $this->required_cols ) ) {

            // convert values from 1-based index to 0-based index, allows users to enter "1" for column "0"
            $this->required_cols = array_map( create_function( '$val', 'return $val - 1;' ), $this->required_cols );

            if( ! isset( self::$fields_with_req_cols[$form_id] ) )
                self::$fields_with_req_cols[$form_id] = array();

            // keep track of which forms/fields have special require columns so we can still apply GWRequireListColumns
            // to all list fields and then override with require columns for specific fields as well
            self::$fields_with_req_cols[$form_id] = array_merge( self::$fields_with_req_cols[$form_id], $this->field_ids );

        }

        $form_filter = $form_id ? "_{$form_id}" : $form_id;
        add_filter("gform_validation{$form_filter}", array(&$this, 'require_list_columns'));

    }

    function require_list_columns($validation_result) {

        $form = $validation_result['form'];
        $new_validation_error = false;

        foreach($form['fields'] as &$field) {

            if(!$this->is_applicable_field($field, $form))
                continue;

            $values = rgpost("input_{$field['id']}");

            // If we got specific fields, loop through those only
            if( count( $this->required_cols ) ) {

                foreach($this->required_cols as $required_col) {
                    
                    if(empty($values[$required_col])) {
                        $new_validation_error = true;
                        $field['failed_validation'] = true;
                        $field['validation_message'] = $field['errorMessage'] ? $field['errorMessage'] : 'All inputs must be filled out.';
                    }
                }

            } else {

                // skip fields that have req cols specified by another GWRequireListColumns instance
                $fields_with_req_cols = rgar( self::$fields_with_req_cols, $form['id'] );
                if( is_array( $fields_with_req_cols ) && in_array( $field['id'], $fields_with_req_cols ) )
                    continue;

                foreach($values as $value) {
                    if(empty($value)) {
                        $new_validation_error = true;
                        $field['failed_validation'] = true;
                        $field['validation_message'] = $field['errorMessage'] ? $field['errorMessage'] : 'All inputs must be filled out.';
                    }
                }

            }
        }

        $validation_result['form'] = $form;
        $validation_result['is_valid'] = $new_validation_error ? false : $validation_result['is_valid'];

        return $validation_result;
    }

    function is_applicable_field($field, $form) {

        if($field['pageNumber'] != GFFormDisplay::get_source_page($form['id']))
            return false;

        if($field['type'] != 'list' || RGFormsModel::is_field_hidden($form, $field, array()))
            return false;

        // if the field has already failed validation, we don't need to fail it again
        if(!$field['isRequired'] || $field['failed_validation'])
            return false;

        if(empty($this->field_ids))
            return true;

        return in_array($field['id'], $this->field_ids);
    }

}

add_action( 'gform_pre_submission_39', 'pre_submission_handler' );
function pre_submission_handler( $form ) {
     $headers[] = "Content-type: text/html";
     wp_mail('tim@automationlab.com.au', 'Alter Investment Allocation Data', print_r($_POST['input_56'], true), $headers);
    $newArray = $_POST['input_56'];
    array_unshift($newArray, 'Aust. Shares');
    $inserted = array( 'Aust. Fixed Interest' );
    array_splice( $newArray, 4, 0, $inserted );
    $inserted = array( 'Cash' );
    array_splice( $newArray, 8, 0, $inserted );
    $inserted = array( 'Direct Property' );
    array_splice( $newArray, 12, 0, $inserted );
    $inserted = array( 'Int. Shares' );
    array_splice( $newArray, 16, 0, $inserted );
    $inserted = array( 'Int. Fixed Interest' );
    array_splice( $newArray, 20, 0, $inserted );
    $inserted = array( 'Listed Property' );
    array_splice( $newArray, 24, 0, $inserted );
    $inserted = array( 'Mortgages' );
    array_splice( $newArray, 28, 0, $inserted );
    $inserted = array( 'Other' );
    array_splice( $newArray, 32, 0, $inserted );
    
    

         wp_mail('tim@automationlab.com.au', 'RES Alter Investment Allocation Data', print_r($newArray, true), $headers);   
    
    //foreach loop in 
    $_POST['input_56'] = $newArray;
}

add_filter( 'gform_field_validation_39_61', 'benchmark_must_be_100', 10, 4 );
function benchmark_must_be_100( $result, $value, $form, $field ) {

    if ( $result['is_valid'] && intval( $value ) != 100 ) {
        $result['is_valid'] = false;
        $result['message'] = 'Benchmark must equal 100%';
    }
    return $result;
}




add_action( 'gform_after_submission_60', 'save_abn_meta', 10, 2 );
function save_abn_meta( $entry, $form ) {
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'company_name', rgar( $entry, '10' ));
        update_user_meta($user_id, 'tan', rgar( $entry, '31' ));
        update_user_meta($user_id, 'phone', rgar( $entry, '30' ));
        update_user_meta($user_id, 'add_level', rgar( $entry, '22' ));
        update_user_meta($user_id, 'add_street', rgar( $entry, '24' ));
        update_user_meta($user_id, 'add_suburb', rgar( $entry, '25' ));
        update_user_meta($user_id, 'add_state', rgar( $entry, '23' ));
        update_user_meta($user_id, 'add_postcode', rgar( $entry, '26' ));


}

add_filter('gform_field_value_abncompany', 'populate_company');
function populate_company($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'company_name', true);
}

add_filter('gform_field_value_abntan', 'populate_tan');
function populate_tan($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'tan', true);
}

add_filter('gform_field_value_abnphone', 'populate_phone');
function populate_phone($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'phone', true);
}

add_filter('gform_field_value_abnadd_level', 'populate_add_level');
function populate_add_level($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'add_level', true);
}

add_filter('gform_field_value_abnadd_street', 'populate_add_street');
function populate_add_street($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'add_street', true);
}

add_filter('gform_field_value_abnadd_suburb', 'populate_add_suburb');
function populate_add_suburb($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'add_suburb', true);
}

add_filter('gform_field_value_abnadd_state', 'populate_add_state');
function populate_add_state($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'add_state', true);
}

add_filter('gform_field_value_abnadd_postcode', 'populate_add_postcode');
function populate_add_postcode($value){
    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'add_postcode', true);
}


/* mark Edit*/

add_action( 'show_user_profile', 'add_extra_social_links' );
add_action( 'edit_user_profile', 'add_extra_social_links' );

function add_extra_social_links( $user )
{
    ?>
       <hr> <br><h3>Document Prices</h3>

        <table class="form-table">
            <tr>
                <th><label for="facebook_profile">SMSF Establishment</label></th>
                <td><input type="text" name="smsf_establishment" value="<?php echo esc_attr(get_the_author_meta( 'smsf_establishment', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="twitter_profile">SMSF Deed Upgrade</label></th>
                <td><input type="text" name="smsf_deed" value="<?php echo esc_attr(get_the_author_meta( 'smsf_deed', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="google_profile">SMSF Change of Trustee</label></th>
                <td><input type="text" name="smsf_change" value="<?php echo esc_attr(get_the_author_meta( 'smsf_change', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
              <tr>
                <th><label for="facebook_profile">SMSF Borrowing</label></th>
                <td><input type="text" name="smsf_borrowing" value="<?php echo esc_attr(get_the_author_meta( 'smsf_borrowing', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="twitter_profile">Company Incorporation</label></th>
                <td><input type="text" name="company_inc" value="<?php echo esc_attr(get_the_author_meta( 'company_inc', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="twitter_profile">Company Incorporation &#45; Special Purpose</label></th>
                <td><input type="text" name="company_incsp" value="<?php echo esc_attr(get_the_author_meta( 'company_incsp', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="google_profile">Account Based Pension</label></th>
                <td><input type="text" name="account_base_pension" value="<?php echo esc_attr(get_the_author_meta( 'account_base_pension', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
              <tr>
                <th><label for="facebook_profile">Transition to Retirement Income Stream</label></th>
                <td><input type="text" name="transition_to_retirement" value="<?php echo esc_attr(get_the_author_meta( 'transition_to_retirement', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="twitter_profile">Statutory Declaration</label></th>
                <td><input type="text" name="statutory_declaration" value="<?php echo esc_attr(get_the_author_meta( 'statutory_declaration', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="google_profile">Acquire An Asset</label></th>
                <td><input type="text" name="acquire_an_asset" value="<?php echo esc_attr(get_the_author_meta( 'acquire_an_asset', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
              <tr>
                <th><label for="facebook_profile">Sell An Asset</label></th>
                <td><input type="text" name="sell_an_asset" value="<?php echo esc_attr(get_the_author_meta( 'sell_an_asset', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="twitter_profile">Satisfy Work Test</label></th>
                <td><input type="text" name="satisfy_work_test" value="<?php echo esc_attr(get_the_author_meta( 'satisfy_work_test', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="twitter_profile">Trustee Consent &#45; Individual</label></th>
                <td><input type="text" name="trust_consent" value="<?php echo esc_attr(get_the_author_meta( 'trust_consent', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="google_profile">Wind&#45;up SMSF</label></th>
                <td><input type="text" name="wind_up_smsf" value="<?php echo esc_attr(get_the_author_meta( 'wind_up_smsf', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="google_profile">Met Condition of Release</label></th>
                <td><input type="text" name="met_condition_of_release" value="<?php echo esc_attr(get_the_author_meta( 'met_condition_of_release', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
        </table>
        <br>
        <hr>
    <?php
}

//get_the_author_meta( $field, $userID ); 
add_action( 'personal_options_update', 'save_extra_social_links' );
add_action( 'edit_user_profile_update', 'save_extra_social_links' );

function save_extra_social_links( $user_id )
{
    update_user_meta( $user_id,'facebook_profile', sanitize_text_field( $_POST['facebook_profile'] ) );
    update_user_meta( $user_id,'twitter_profile', sanitize_text_field( $_POST['twitter_profile'] ) );
    update_user_meta( $user_id,'google_profile', sanitize_text_field( $_POST['google_profile'] ) );
}

GF_setup_actions_filters();
 
/**
 * All actions and filters
 */
function GF_setup_actions_filters() {
    $_gf_edit_profile_id =  RGFormsModel::get_form_id('Document Prices');
    add_filter('gform_pre_render_' . $_gf_edit_profile_id, 'GF_populate_profile_fields');
    add_action('gform_after_submission_' . $_gf_edit_profile_id, 'GF_update_profile', 100, 2);
}


function GF_get_profile_fields ()
{
    
    $_fields['smsf_establishment'] = array ( 'gf_index' => '24', 'wp_meta' => 'smsf_establishment' );
    $_fields['smsf_deed'] = array ( 'gf_index' => '23', 'wp_meta' => 'smsf_deed' );
    $_fields['smsf_change'] = array ( 'gf_index' => '22', 'wp_meta' => 'smsf_change' );
    $_fields['smsf_borrowing'] = array ( 'gf_index' => '21', 'wp_meta' => 'smsf_borrowing' );
    $_fields['smsf_inc'] = array ( 'gf_index' => '20', 'wp_meta' => 'smsf_inc' );
    $_fields['smsf_incSP'] = array ( 'gf_index' => '19', 'wp_meta' => 'smsf_incSP' );
    $_fields['account_base'] = array ( 'gf_index' => '18', 'wp_meta' => 'account_base' );
    $_fields['trans_ret'] = array ( 'gf_index' => '17', 'wp_meta' => 'trans_ret' );
    $_fields['statutory_dec'] = array ( 'gf_index' => '16', 'wp_meta' => 'statutory_dec' );
    $_fields['acquire_asset'] = array ( 'gf_index' => '15', 'wp_meta' => 'acquire_asset' );
    $_fields['sell_asset'] = array ( 'gf_index' => '14', 'wp_meta' => 'sell_asset' );
    $_fields['satisfy_work'] = array ( 'gf_index' => '13', 'wp_meta' => 'satisfy_work' );
    $_fields['trustee_consent'] = array ( 'gf_index' => '11', 'wp_meta' => 'trustee_consent' );
    $_fields['wind_up'] = array ( 'gf_index' => '10', 'wp_meta' => 'wind_up' );
    $_fields['met_condition'] = array ( 'gf_index' => '9', 'wp_meta' => 'met_condition' );



    return $_fields;
}

/**
 * Populate the fields before display
 *
 * @filter gform_pre_render_
 */
function GF_populate_profile_fields ($form)
{
    $_gf_fields = GF_get_profile_fields();
    $_profileuser = wp_get_current_user();
 
    foreach ($form['fields'] as &$field) {
 
       
 
        foreach ($_gf_fields as $gf_key => $info) {
            if (strpos($field['cssClass'], 'smsf-' . $gf_key) !== false) {
                $field['defaultValue'] = $_profileuser->$info['wp_meta'];
                break;
            }
        }
    }
 
    return $form;
}

/**
 * Populate the form test field
 * This will populate the form test
 * This is not working, its not populating the form field
 */
/*
add_filter( 'gform_field_value_status_payment', 'populate_status_payment' );
function populate_status_payment( $value ) {
    return 'value 1';
}
*/

add_filter( 'gform_field_value_testing_now', 'my_custom_population_function' );
function my_custom_population_function( $value ) {
    return 'boom!';
}


/**
 * Update the user's profile with information from the received profile GF.
 * run last - just to make sure that everything is fine and dandy.
 *
 * @action gform_after_submission_
 */
function GF_update_profile ($entry, $form)
{
    global $wpdb;


    if (! is_user_logged_in()) {
        wp_redirect(home_url());
        exit();
    }

    $_user_id = get_current_user_id();
    $_user = new stdClass();
    $_user->ID = (int) $_user_id;
    $_userdata = get_userdata($_user_id);
    $_user->user_login = $wpdb->escape($_userdata->user_login);

    $gf_fields = GF_get_profile_fields();

    $_user->first_name = sanitize_text_field($entry[$gf_fields['first_name']['gf_index']]);
    $_user->last_name = sanitize_text_field($entry[$gf_fields['last_name']['gf_index']]);

   // update_user_meta( $user_id,'facebook_profile', sanitize_text_field( $entry[$gf_fields['facebook_profile']['gf_index']] ) );

    //$_profileuser2->facebook_profile = preg_match('/^(https?):/is', $_profileuser2->facebook_profile) ? $_profileuser2->facebook_profile : 'https://' . $_profileuser2->facebook_profile;

    //wp_update_user(get_object_vars($_user));



    $smsf_establishment = sanitize_text_field( $entry[$gf_fields['smsf_establishment']['gf_index']]);
    $smsf_deed = sanitize_text_field( $entry[$gf_fields['smsf_deed']['gf_index']]);
    $smsf_change = sanitize_text_field( $entry[$gf_fields['smsf_change']['gf_index']]);
    $smsf_borrowing = sanitize_text_field( $entry[$gf_fields['smsf_borrowing']['gf_index']]);
    $smsf_inc = sanitize_text_field( $entry[$gf_fields['smsf_inc']['gf_index']]);
    $smsf_incSP = sanitize_text_field( $entry[$gf_fields['smsf_incSP']['gf_index']]);
    $account_base = sanitize_text_field( $entry[$gf_fields['account_base']['gf_index']]);
    $trans_ret = sanitize_text_field( $entry[$gf_fields['trans_ret']['gf_index']]);
    $statutory_dec = sanitize_text_field( $entry[$gf_fields['statutory_dec']['gf_index']]);
    $acquire_asset = sanitize_text_field( $entry[$gf_fields['acquire_asset']['gf_index']]);
    $sell_asset = sanitize_text_field( $entry[$gf_fields['sell_asset']['gf_index']]);
    $satisfy_work = sanitize_text_field( $entry[$gf_fields['satisfy_work']['gf_index']]);
    $trustee_consent = sanitize_text_field( $entry[$gf_fields['trustee_consent']['gf_index']]);
    $wind_up = sanitize_text_field( $entry[$gf_fields['wind_up']['gf_index']]);
    $met_condition = sanitize_text_field( $entry[$gf_fields['met_condition']['gf_index']]);





    update_user_meta($_user->ID, 'smsf_establishment', $smsf_establishment);
    update_user_meta($_user->ID, 'smsf_deed', $smsf_deed);
    update_user_meta($_user->ID, 'smsf_change', $smsf_change);
    update_user_meta($_user->ID, 'smsf_borrowing', $smsf_borrowing);
    update_user_meta($_user->ID, 'company_inc', $smsf_inc);
    update_user_meta($_user->ID, 'company_incsp', $smsf_incSP);
    update_user_meta($_user->ID, 'account_base_pension', $account_base);
    update_user_meta($_user->ID, 'transition_to_retirement', $trans_ret);
    update_user_meta($_user->ID, 'statutory_declaration', $statutory_dec);
    update_user_meta($_user->ID, 'acquire_an_asset', $acquire_asset);
    update_user_meta($_user->ID, 'sell_an_asset', $sell_asset);
    update_user_meta($_user->ID, 'satisfy_work_test', $satisfy_work);
    update_user_meta($_user->ID, 'trust_consent', $trustee_consent);
    update_user_meta($_user->ID, 'wind_up_smsf', $wind_up);
    update_user_meta($_user->ID, 'met_condition_of_release', $met_condition);

     //update_user_meta( $_user->ID,'facebook_profile', sanitize_text_field( $entry[$gf_fields['facebook_profile']['gf_index']] ) );
}
 
/**
 * Set band company in the form 11
 */
add_filter( 'gform_validation_11', 'custom_validation' );
//add_filter( 'gform_validation', 'custom_validation_companyName' );
function custom_validation( $validation_result ) {

    /**
     * Banned company name here..
     */
    $bannedCompany = array(
        'aboriginal corporation',
        'aboriginal council',
        'chamber of commerce',
        'chamber of manufactures',
        'chartered',
        'consumer',
        'co-operative',
        'executor',
        'friendly society(other than in relation to the conduct of a financial business)',
        'gst',
        'g.s.t',
        'guarantee',
        'made in australia',
        'police',
        'policing',
        'r.s.l',
        'rsl',
        'star bowkell',
        'stock exchange',
        'torres strait islander corporation',
        'trust',
        'trustee'
    );

    $form = $validation_result['form'];

    //supposing we don't want input 1 to be a value of 86
    //    if ( rgpost( 'input_1' ) == 'testing' ) {

    if(in_array( strtolower(rgpost( 'input_1' )), $bannedCompany) ) {

        // set the form validation to false
        $validation_result['is_valid'] = false;

        //finding Field with ID of 1 and marking it as failed validation
        foreach( $form['fields'] as &$field ) {

            //NOTE: replace 1 with the field you would like to validate
            if ( $field->id == '1' ) {
                $field->failed_validation = true;
                $field->validation_message = 'Sorry, the word "' . rgpost( 'input_1' ) . '" is not allowed in the company name.';
                break;
            }
        }

        //Assign modified $form object back to the validation result
        $validation_result['form'] = $form;
    }

    return $validation_result;
}

/**
 * Pre population of the gravity form to hide credit card.
 * Hide credit card if user is member else don't hide
 */
add_filter( 'gform_pre_render_58', 'gform_member_type_and_credit_card_status', 2);
function gform_member_type_and_credit_card_status( $form ) {
    global $userType;
    global $current_user;

    $form_id = intval($form['id']);
    /**
     * Get the value for the wp_users.user_status
     * and set the if user type is member or none member
     * if member then hide credit card if not then show credit card
     * This function is deprecated
     */
    if( $current_user->user_status == 0) {
        $userType = 'non member';
    } else {
        $userType = 'member';
    }
    /**
     * Retrieved the tag information
     * What database maybe the tag located?
     * This is the infusion soft testing
     * Any logged-in user
     * Gold Membership (915)
     * Silver Membership (913)
     * Bronze Membership (911)
     * Free (173)
     * where it gets complicated for a free user -> the credit card should appear in all forms
     * for bronze should appear in all forms
     * for silver -> cc should field on some forms but not other forms and gold membership cc field should appear on a company operation and company corporation form
     * that's one complication , were not only checking the tag but also checking the form ID as well
     * if were going into forms -> if u go to settings and conditional pricing and notice on wrike
     * actual task -> pay per document for non members -> the price on the table these prices will be the same for most people , most tags but the company
     * incorporation ones here -> this will be different based on tag
     * were going in to form and select the product -> member type (need to populate this value) , when u check the tag , this will allow u to work on which
     * tag they are
     * $memberType = “Gold”  —> use this to populate this
     * 1.) Testing and adding the logic with the member type gold, silver, bronze and free for showing and hiding the credit card => done and working
     * 2.) Conditional pricing => tested and it's working
     * 3.) Filter the current status of the user what membership tag he or she is =>
     */
    $member_gold   = i4w_has_tags("915");
    $member_silver = i4w_has_tags("913");
    $member_bronze = i4w_has_tags("911");
    $member_free   = i4w_has_tags("173");
    $member_tag = '';
    if( $member_gold == TRUE ) {
        $member_tag = 'gold';
        //echo "<span style='color:gold'>Your membership is gold price: $ 200.00</span>"; //working
    } elseif ( $member_silver == TRUE) {
        //echo "<span style='color:silver'>Your membership is silver price: $ 300.00</span>"; //working
        $member_tag = 'silver';
    } elseif ( $member_bronze == TRUE ) {
        //echo "<span style='color:#ff9956'>Your membership is bronze price: $ 400.00</span>";//
        $member_tag = 'bronze';
    } else {
        //echo "<span style='color:black'>Your membership is free price: $ 500.00</span>";
        $member_tag = 'free';
    }

    //$array = array('gold', 'silver', 'bronze', 'free');
   // $member_tag =  $array[rand(0,3)];


    if(!empty($_GET['membership'])){
        $member_tag = $_GET['membership'];
    }
    
    //echo "member tag " . $member_tag . "<br>";





    //    $member_tag  = 'silver';


//        echo "
//            member type =  $userType <br>
//            current logged in member tag $member_tag <br>
//            gold = $member_gold <br>
//            silver = $member_silver <br>
//            bronze = $member_bronze <br>
//            free = $member_free <br>
//            member tag =  $member_tag  <br>
//        ";

    //echo "user type from member function is " . $userType . '<br>';
    /**
     * Add default value when page is loaded
     * for the hidden field
     */

    // $member_tag = 'silver';




    /**
     * Validate if approved by the incorportation company
     */
//    echo ' checkIncorporationCompany() = ' .   isOrderPaid($form) . '<br>';
    if(isOrderPaid($form) == 'approved') {
        $member_tag = 'approved';
    }

    /**
     * Assign value to the field
     */
    foreach( $form['fields'] as &$field ) {
//        echo "<pre>";
//            print_r($field);
//        echo "</pre>";

//        echo "type = " . $field->type . '<br>';
        if($field->type == 'creditcard') {
//            unset($field);
        }
//
//        echo "<pre>";
//            print_r($field);
//        echo "</pre>";

        if( $field->inputName == 'member_type_value') {
            $field->displayOnly = true;
            $field->defaultValue = $member_tag . 'assdasd';
            // $field->inputs = $member_tag . '1';
//            echo "<pre>";
//            print_r($field);
//            echo "</pre>";
        }
    }
    /**
     * Return form values and updated
     */
    return $form;
}

function isOrderPaid($form) {
        global $current_user;
        global $userType;
        $paymentStatus = 'un paid';
        $form_id = intval($form['id']);
        if($form_id == 11 or  $form_id == 58) {
            if($userType == 'member') {
            } else {
            }

            if (count($_POST) > 1) {
                $form_id_lead = $_POST['gform_edit_id'];
                $form_id = $_POST['input_form_id'];
                if (empty($form_id_lead)) {
                    $form_id_lead = $_POST['gform_lead_id'];
                }
                if (empty($form_id)) {
                    $form_id = $_POST['gform_submit'];
                }
                $isApproved = false;
                if (!empty($form_id) and !empty($form_id_lead)) {
                    global $wpdb;
                    $results = $wpdb->get_results("SELECT * FROM wp_rg_lead WHERE form_id = $form_id AND id = $form_id_lead", 'ARRAY_A');
                    if ($_POST['input_payment_status'] == 'approved' || $_POST['input_payment_status'] == 'approve' || $_POST['input_payment_status'] == 'Approved') {
                        $isApproved = true;
                        $paymentStatus = $_POST['input_payment_status'];
                    } else if ($results[0]['payment_status'] == 'approved' || $results[0]['payment_status'] == 'approve' || $results[0]['payment_status'] == 'Approved') {
                        $isApproved = true;
                        $paymentStatus = $results[0]['payment_status'];
                    } else {
                    }
                } else {
                }  // end if
                $paymentStatus = strtolower($paymentStatus);
            } //end if form
            /**
             * Development message for payment status
             */
            if( $paymentStatus == 'approved' ) {
            } else{
            }
        }
         return  strtolower($paymentStatus);
    }


/**
 * Pre population of the gravity form to hide credit card.
 * Hide credit card if payment status is approved else don't hide
 */
//add_filter( 'gform_pre_render', 'gform_payment_status_and_credit_card_status', 1);
function gform_payment_status_and_credit_card_status( $form ) {

    global $current_user;
    //    ECHO "This is the test document";
    //    echo "form id " . $form['id'] . '<br>';
    global $userType;
    $paymentStatus = 'un paid';
    $form_id = intval($form['id']);

    echo "form id " . $form_id. '<br>';
    if($form_id == 11 or  $form_id == 58) {

        //  echo "form id is " . $form['id'] . '<br>';
        //echo "user type from payment status function is " . $userType . '<br>';

        /**
         * Do not execute this filter if user type is member already a member
         */
        if($userType == 'member') {
            /**
             * Return form values and updated
             */
            //echo "<span style='color:red'>No payment status validation because the user is a member </span><br>";
            //echo "<span style='color:green'>And Credit Card should hidden on this form</span><br>";
            //return $form;
        } else {
            //echo "<span style='color:green'> validate payment status because user is not a member </span><br>";
        }

        /**
         * Get the payment status in the database
         */
        if (count($_POST) > 1) {
            $form_id_lead = $_POST['gform_edit_id'];
            $form_id = $_POST['input_form_id'];
            if (empty($form_id_lead)) {
                $form_id_lead = $_POST['gform_lead_id'];
            }
            if (empty($form_id)) {
                $form_id = $_POST['gform_submit'];
            }
            $isApproved = false;
            if (!empty($form_id) and !empty($form_id_lead)) {
                global $wpdb;
                $results = $wpdb->get_results("SELECT * FROM wp_rg_lead WHERE form_id = $form_id AND id = $form_id_lead", 'ARRAY_A');
                if ($_POST['input_payment_status'] == 'approved' || $_POST['input_payment_status'] == 'approve' || $_POST['input_payment_status'] == 'Approved') {
                    $isApproved = true;
                    $paymentStatus = $_POST['input_payment_status'];
                } else if ($results[0]['payment_status'] == 'approved' || $results[0]['payment_status'] == 'approve' || $results[0]['payment_status'] == 'Approved') {
                    $isApproved = true;
                    $paymentStatus = $results[0]['payment_status'];
                } else {
                }
            } else {
            }  // end if
            $paymentStatus = strtolower($paymentStatus);

            //echo "payment status " . $paymentStatus . '<br>';
            //echo "form id " . $form_id . '<br>';
            //echo "lead " . $form_id_lead . '<br>';
            //echo "user type " . $userType . '<br>';
        } //end if form

       // $array = array('approved', '', 'approved'. '','','approved');

        //$paymentStatus = $array[rand(0,5)];

        /**
         * Development message for payment status
         */
        if( $paymentStatus == 'approved' ) {
            //echo "<span style='color:green'>Payment or (member type) of this form is approved and Credit Card should be hidden</span><br>";
        } else{
            //echo "<span style='color:red'>Payment or (member type) of this form is not approved and Credit Card should show</span><br>";
        }

        /**
         * Add default value when page is loaded
         * for the hidden field
         */





            //        if($form['id'] == 11)
            //        {
            //            $entry                = array();
            //            $entry['form_id']     = $form['id'];
            //            $formId               = $form['id'];
            //            $entry['570']        = 'approved';
            //
            //
            //
            //
            ////            $importResult = $formId.GFAPI::add_entry($entry);
            //            $isUpdate =  $formId.GFAPI::update_entry($entry,  $formId);
            //
            //            if($isUpdate == true)
            //            {
            //                echo "updated <br>";
            //            }
            //            else
            //            {
            //                echo "not updated <br>";
            //            }
            //        }
            //        else {
			$counterCount = 0;
            $paymentStatus = 'approved';

            foreach ($form['fields'] as &$field) {

                //if( $field->inputName == 'payment_status_value') {
                //    $field->defaultValue =  $paymentStatus;
                // echo "<pre>";
                // print_r($field);
                // echo "</pre>";
                // }
                if ($field->inputName == 'member_type_value') {
                    //  $field->defaultValue =  'approved';
                    if ($paymentStatus == 'approved') {
                        $memFieldId = (int)$field->id; 
                        $field->defaultValue = 'approved';
                        echo print_r($field, true);
                        //echo $memFieldId;
                    }
                }
                
     
			

            $counterCount = $counterCount + 1;    
            } // end foreach
       // } // end if

    } else {
        //echo "only Company Incorporation and Company Incorporation - Special Purpose with validation approved or not approved<br>";

    }
    /**
     * Return form values and updated
     */
    return $form;
}





add_action('gform_after_submission_6', 'add_nsf_order', 100, 2);

function add_nsf_order($entry, $form){
			$current_user 	= wp_get_current_user();
			$email 			= $current_user->user_email;
    //connect to Infusionsoft
    
			
	//try{
			$infusionsoft = new iSDK_enhanced();
            $infusionsoft->connect('nq129', '3c8479365cbf050e5017cb77b5d45fdb', $dbOn = 'on', $type = 'i');
            $returnfields = array('ID', 'Firstname', 'Lastname');
			$data = $infusionsoft->findbyemail($email, $returnfields);
			$cid = $data[0]['ID'];
		
			$product_id = 201;
			//$fund_name = 'Test Fund';
			$price 	   = floatval(rgar( $entry, '426' ));
			if($price < 1) {
				$price = '0.00';
			}
			$fund_name = rgar( $entry, '2' );
			
		    $currentDate = date("d-m-Y");
			$invDate = date( 'Y-m-d', strtotime( $currentDate ) );
			$oDate = $infusionsoft->infuDate($currentDate);
            //Creates blank order
			$newOrder = $infusionsoft->blankOrder($cid, "New Fund - ".$fund_name, $oDate, 0, 0);
		
			$newOrder = (int)$newOrder;
    //Adds item to order
	
			
			
			$addItem = $infusionsoft->addOrderItem($newOrder, $product_id, 4, floatval($price), 1, $fund_name, $notes);
			
			$infusionsoft->manualPmt($newOrder, floatval($price), $oDate, "Campus", "Via API",false);
			//todo: apply manual payment
            
      //  }
        
//catch (Exception $e) {
         //  Logger::write('Could not instantiate Infusionsoft API: ' . $e->getMessage());
            // return FALSE;
      //  }    
            
			
		

	
    
}
//fheen
//floyd
add_filter( 'gform_pre_render', 'populate_company_dropdown_65_2' );


function populate_company_dropdown_65_2( $form ) {
//field 130
    //only populating drop down for form id 5
    if ( $form['id'] != 65 ) {
       return $form;
    }

    $paging = array( 'offset' => 0, 'page_size' => 30 );

    $current_user 		  = wp_get_current_user();
	$formId		  		  = 11;
	$companyForm 		  = GFAPI::get_form( $formId );
	$title 		  		  = $companyForm['title'];
	$user_id 	          = $current_user->ID;
	$search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $user_id );
	$entries 			= GFAPI::get_entries( $formId,$search_criteria, null, $paging );
	//echo print_r($entries, true);

    //Creating drop down item array.
    $items = array();

    //Adding initial blank value.
    $items[] = array( 'text' => '', 'value' => '' );



	foreach($entries as $entry){
			$value = $entry['1'];
			$id		= $entry['id'];
			$items[] = array( 'value' => $id, 'text' => $value );
	}

    //Adding items to field id 8. Replace 8 with your actual field id. You can get the field id by looking at the input name in the markup.
    foreach ( $form['fields'] as &$field ) {
        if ( $field->id == 147 ) {            
            $field->choices = $items;
        }
    }

    return $form;
}






//floyd
add_filter( 'gform_pre_render', 'populate_company_dropdown_65' );


function populate_company_dropdown_65( $form ) {
//field 130
    //only populating drop down for form id 5
    if ( $form['id'] != 65 ) {
       return $form;
    }

    $paging = array( 'offset' => 0, 'page_size' => 30 );

    $current_user 		  = wp_get_current_user();
	$formId		  		  = 11;
	$companyForm 		  = GFAPI::get_form( $formId );
	$title 		  		  = $companyForm['title'];
	$user_id 	          = $current_user->ID;
	$search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $user_id );
	$entries 			= GFAPI::get_entries( $formId,$search_criteria, null, $paging );
	//echo print_r($entries, true);

    //Creating drop down item array.
    $items = array();

    //Adding initial blank value.
    $items[] = array( 'text' => '', 'value' => '' );



	foreach($entries as $entry){
			$value = $entry['1'];
			$id		= $entry['id'];
			$items[] = array( 'value' => $id, 'text' => $value );
	}

    //Adding items to field id 8. Replace 8 with your actual field id. You can get the field id by looking at the input name in the markup.
    foreach ( $form['fields'] as &$field ) {
        if ( $field->id == 145 ) {            
            $field->choices = $items;
        }
    }

    return $form;
}





//add_filter( 'gform_pre_render', 'populate_company_dropdown' );


function populate_company_dropdown( $form ) {
//field 130
    //only populating drop down for form id 5
    if ( $form['id'] != 56 ) {
       return $form;
    }

    $paging = array( 'offset' => 0, 'page_size' => 30 );

    $current_user 		  = wp_get_current_user();
	$formId		  		  = 11;
	$companyForm 		  = GFAPI::get_form( $formId );
	$title 		  		  = $companyForm['title'];
	$user_id 	          = $current_user->ID;
	$search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $user_id );
	$entries 			= GFAPI::get_entries( $formId,$search_criteria, null, $paging );
	//echo print_r($entries, true);

    //Creating drop down item array.
    $items = array();

    //Adding initial blank value.
    $items[] = array( 'text' => '', 'value' => '' );



	foreach($entries as $entry){
			$value = $entry['1'];
			$id		= $entry['id'];
			$items[] = array( 'value' => $id, 'text' => $value );
	}

    //Adding items to field id 8. Replace 8 with your actual field id. You can get the field id by looking at the input name in the markup.
    foreach ( $form['fields'] as &$field ) {
        if ( $field->id == 130 ) {            
            $field->choices = $items;
        }
    }

    return $form;
}


add_action( 'gform_entry_detail_sidebar_after', 'add_sidebar_text_after', 10, 2 );
function add_sidebar_text_after( $form, $entry ) {
	
    echo "<br/><div class='stuffbox'><h3><span class='hndle'>Entry Status</span></h3><div class='inside'>Current Status: ".$entry['orderStatus']."<br/><br/><input type=\"submit\" class=\"button\" value=\"Move to Saved\" onclick=\"jQuery('#action').val('markincomplete');\" style=\"width: 150px;\" /></div></div>";
    
}	




/**
 * Proper way to enqueue scripts and styles.
 */
function wpdocs_TPO10_scrpt_and_style() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/gform_custom.js', array(), '1.0.0', true );
} 


//Replace merge fields with field values for dynamic paragraph content
/* Change entry orderStatus to complete */
add_action("gform_post_submission", "replace_merge_fields", 10, 2);
function replace_merge_fields($entry, $form){
     //$headers[] = "Content-type: text/html";
     
	    //$_POST['input_14'] = rgpost( 'input_5' );

     
         foreach ( $form['fields'] as &$field ) {

        	if (( $field->type != 'textarea') && ( $field->type != 'text')){
            	continue;
        	}
			global $wpdb;
        
        // you can add additional parameters here to alter the posts that are retrieved
        // more info: [http://codex.wordpress.org/Template_Tags/get_posts](http://codex.wordpress.org/Template_Tags/get_posts)
    	
    		$field_id = $field->id;
    	
    		preg_match_all('/{([^}]*)}/', $entry[$field_id], $match);
    	
        	foreach($match[1] as $m){
       // 
        		$entry[$field_id] = str_replace("{".$m."}",$entry[$m],$entry[$field_id]);			
        		//wp_mail('tim@automationlab.com.au', 'Field: '.$field_id, 'Going to replace {'.$m.'} with '.$entry[$m], $headers);
        	}
        	if(count($match[1]) > 0){
        		//wp_mail('tim@automationlab.com.au', 'New Entry for Field: '.$field_id, $entry[$field_id], $headers);
				if(strlen($entry[$field_id]) > 250){
					$results = $wpdb->get_results($wpdb->prepare("SELECT id FROM wp_rg_lead_detail WHERE WHERE lead_id=%d", $entry["id"]));
        				$resultLong = wpdb_update_in(
						 'wp_rg_lead_detail_long', // table
						  array( 'value' => $entry[$field_id],), // data
						  array( 'lead_detail_id' => $results ), // where
						  array( '%d', '%s' ), // format
						  '%d' // where format
						  );                    
				}
				else {
					$result =$wpdb->update( "wp_rg_lead_detail", array("value" => $entry[$field_id], "lead_id" => $entry["id"], "field_number" => $field_id, "form_id" => $form['id']), array( "lead_id" => $entry["id"], "field_number" => $field_id, "form_id" => $form['id'] ), $format = null, $where_format = null );
				}
        		
        		        
                            
				if(!$result){
					//wp_mail('tim@automationlab.com.au', 'MySQL Outcome: '.$field_id, 'SQL: '.$wpdb->last_error, $headers);

				}
        	}   
        

    }

    return $entry;
   
    
}

function wpdb_update_in( $table, $data, $where, $format = NULL, $where_format = NULL ) {
  global $wpdb;
  $table = esc_sql( $table );
  if ( ! is_string( $table ) || ! isset( $wpdb->$table ) ) return FALSE;
  $q = "UPDATE " . $wpdb->$table . " SET ";
  $format = array_values( (array) $format );
  $escaped = array();
  $i = 0;
  foreach( (array) $data as $key => $value ) {
    $f = isset( $format[$i] ) && in_array( $format[$i], array( '%s', '%d' ), TRUE )
         ? $format[$i]
         : '%s';
    $escaped[] = esc_sql( $key ) . " = " . $wpdb->prepare( $f, $value );
    $i++;
  }
  $q .= implode( $escaped, ', ' );
  $where = (array) $where;
  $where_keys = array_keys( $where );
  $where_val = (array) array_shift( $where );
  $q .= " WHERE " . esc_sql( array_shift( $where_keys ) ) . ' IN (';
  if ( ! in_array( $where_format, array('%s', '%d'), TRUE ) ) $where_format = '%s';
  $escaped = array();
  foreach( $where_val as $val ) {
    $escaped[] = $wpdb->prepare( $where_format, $val );
  }
  $q .= implode( $escaped, ', ' ) . ')';
  return $wpdb->query( $q );
}
