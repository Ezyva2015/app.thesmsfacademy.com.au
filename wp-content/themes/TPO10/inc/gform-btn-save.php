<?php
add_action('wp_enqueue_scripts', 'gform_add_entry');
if ( !function_exists( 'gform_add_entry' ) ) {
    function gform_add_entry() {
        wp_enqueue_script('bootbox', get_template_directory_uri().'/js/lib/bootbox.min.js', array(), '4.1.0', false);
        wp_enqueue_script('gform_add_entry', get_template_directory_uri().'/js/gform_add_entry.js', array(), null , false);
        wp_enqueue_script('gform_edit_entry', get_template_directory_uri().'/js/gform_edit_entry.js', array(), null , false);
    }
}
function gform_add_entry_override(){ ?>
    <script type="text/javascript">
        (function($){

            if (!$('form[name="gravitylist"]').length) {
                if ($('.gform_wrapper').length) {
                    console.log(<?php echo json_encode($_POST) ?>);
                    <?php if(isset($_POST['gform_edit_id']) && !empty($_POST['gform_edit_id'])){ ?>
                        $('.gform_wrapper').find('.gform_body .gform_next_button').before('<input type="button" class="btn_gform_update button" value="Update"/>');
                        $('.gform_wrapper').find('.gform_body .gform_next_button').after('<input type="hidden" id="gform_edit_id" name"gform_edit_id" value="<?php echo $_POST['gform_edit_id'] ?>"/>');
                        $('.gform_wrapper').find('.gform_body .gform_next_button').after('<input type="hidden" id="gform_form_id" name"gform_form_id" value="<?php echo $_POST['input_form_id'] ?>"/>');
                    <?php }else{ ?>
                        $('.gform_wrapper').find('.gform_body .gform_next_button').before('<input type="button" class="btn_gform_save button" value="Save"/>');

                    <?php } ?>
                }
            }

            /** add entry to all */
            $('.gform_wrapper').gform_add_entry({
                selector    :   'input.btn_gform_save',
                thank_you_page: '<?php echo site_url('/thank-you-page') ?>'
            });

            $('.gform_wrapper').gform_edit_entry({
                selector    :   'input.btn_gform_update',
                post        :   <?php echo json_encode($_POST) ?>
                /*thank_you_page: '<?php echo site_url('/thank-you-page') ?>'*/
            });



        })(jQuery);
    </script>
<?php } add_action('wp_footer','gform_add_entry_override',9999999);


/*add_action("gform_post_submission", "post_submission_handler");
function post_submission_handler($form){
    //$_POST["input_14"] = "new value for field 14";

    $to = 'alexander@greymouse.com.au';
    $subject = 'Content post_submission_handler';
    $message = 'Data: <br/>'.print_r($form, true).'<br/>'.print_r($_POST,true);
    wp_mail( $to, $subject, $message);
}*/