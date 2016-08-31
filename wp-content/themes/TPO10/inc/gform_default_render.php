<?php

function gform_list_fnc($atts){
    extract( shortcode_atts( array(
        'form_id' => ''
    ), $atts, 'gform_list' ));
    $gform_list = array();
    $forms = explode(',',$form_id);
    if(is_array($forms)){
        foreach($forms as $id){
            $gform_list[$id] = RGFormsModel::get_form_meta( $id );
            $gform_list[$id]['form_permalink'] = get_permalink($gform_list[$id]['spgfle_gfediturl']);
        }
    }
//    global $gform_list;
    return json_encode($gform_list);
}
add_shortcode('gform_list', 'gform_list_fnc');


function gform_default_render(){

?>
<script type="text/javascript">
    (function($){


        
        <?php
            $entry_id = '';
            $form_id = '';
            if((isset($_POST['form_id']) && !empty($_POST['form_id']))
                && (isset($_POST['gform_edit_id']) && !empty($_POST['gform_edit_id']))){
                $entry_id = $_POST['gform_edit_id'];
                $form_id = $_POST['form_id'];
            }elseif((isset($_GET['fid']) && !empty($_GET['fid']))
                && (isset($_GET['entry_id']) && !empty($_GET['entry_id']))){
                $entry_id = $_GET['entry_id'];
                $form_id = $_GET['fid'];
            }
            elseif((isset($_GET['form_id']) && !empty($_GET['form_id']))){
                $entry_id = $_GET['gform_edit_id'];
                $form_id = $_GET['form_id'];
                }
                
            $from_fid = (isset($_POST['from_fid']) && !empty($_POST['from_fid'])) ? $_POST['from_fid'] : 52
        ?>

        $(".gform_body form").prepend('<input type="hidden" name="form_id" id="form_id" value="<?php echo $form_id ?>"/>');
        $(".gform_body form").prepend('<input type="hidden" name="from_fid" id="from_fid" value="<?php echo $from_fid ?>"/>');
        if($("#gform_edit_id").length == 0){
            $(".gform_body form").prepend('<input type="hidden" name="gform_edit_id" id="gform_edit_id" value="<?php echo $entry_id ?>"/>');
        }
        
        <?php if($form_id){ ?>

            <?php

                $gform_data = SpGfListEdit::get_form_values($from_fid,$entry_id);
                $form = RGFormsModel::get_form_meta( $form_id );

            ?>

            $gform_data = <?php echo json_encode($gform_data) ?>;
            $form = <?php echo json_encode($form) ?>;

            $form_id = '<?php echo $form_id; ?>';
            

            

            var temp = [];

            var in_temp = function(id, label){
                var $ret = '';
                $.each(temp, function(k, v){
                    if(temp[id] && temp[id]['label']==label){
                        $ret = 1;
                    }else{
                        $ret = 0;
                    }
                });
                return $ret;
            };

            var field_value = function(label,adminLabel){
                $return='';
                ctr = 1;
                $.each($gform_data.meta.fields, function(k,v){
                    if(v['adminLabel']===adminLabel){
                        $return = $gform_data.lead[v['id']];
                        if(in_temp(v['id'],v['adminLabel'])){
                            ctr+=1;
                            temp[v['id']] = {'label':v['adminLabel']+ctr,'value':$return};
                        }else{
                            temp[v['id']] = {'label':v['adminLabel'],'value':$return};
                            return false;
                        }
                    }else if(v['label']===label){
                        $return = $gform_data.lead[v['id']];
                        if(in_temp(v['id'],v['label'])){
                            ctr+=1;
                            temp[v['id']] = {'label':v['label']+ctr,'value':$return};
                        }else{
                            temp[v['id']] = {'label':v['label'],'value':$return};
                            return false;
                        }
                    }
                });
                return $return;
            };

            $.each($form.fields, function(k, v){
                $fieldVal = field_value(v['label'],v['adminLabel']);
                $('#input_'+$form_id+'_'+v['id']).val($fieldVal);
            });


        <?php }else{ ?>
            /*if($("body.page-template-template-gform-render-php").length || $("body.page-id-3240").length){*/
            if($("form[name='gravitylist']").length){

                $('.gform_body tbody tr').each(function(){
                    $(this).find('td').eq(2).after('<td><select class="select_gform">' +
                        '<option value="">- select form -</option>' +
                        '</select></td>');
                });
                $('.gform_wrapper table tr th:nth-child(3)').text("Name of Fund");

                $gform_list = <?php echo do_shortcode('[gform_list form_id="6,53,65,56,55,11,58"]')?>;

                $from_fid = $('.gform_wrapper').attr('id').slice(-2);
                $('#from_fid').val($from_fid);

//                $gform_list.slice(,1);
               // delete $gform_list[$from_fid];

                $.each($gform_list,function(k,v){
                    $(".gform_body select.select_gform").append('<option value="'+k+'">'+v['title']+'</option>');
                });

                $(".gform_body select.select_gform").change(function(){
                    $(".gform_body form").attr('action',$gform_list[$(this).val()]['form_permalink']);
                    $(".gform_body form").find('#form_id').val($(this).val());
                    
                });

            }
        <?php } ?>

        if($('#slidetabs_3010').length){
            $href = $('a.maxbutton-29').attr('href');
            $('a.maxbutton-29').attr('href',$href+"?uid=<?php echo wp_get_current_user()->ID; ?>");
        }

    })(jQuery);
</script>

<?php }


add_action('wp_footer','gform_default_render',9999);


