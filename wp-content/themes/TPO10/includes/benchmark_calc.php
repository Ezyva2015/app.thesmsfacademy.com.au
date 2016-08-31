<?php function benchmark_calc(){ ?>
    <script type="text/javascript">
        (function($){

            

            if($("#gform_39").length){

                $ctr = 0;
                $calc_input = <?php echo (isset($_POST['calc_input'])) ? json_encode($_POST['calc_input']) : json_encode(array()) ?>;
                
                
                $("form#gform_39 li#field_39_56 table.gfield_list tbody td:nth-child(1)").each(function(){
                    $(this).find('input').attr('disabled','disabled');

                    <?php if(isset($_POST['calc_input']) && !empty($_POST['calc_input'])){ ?>
                    if($calc_input){
                        $(this).find('input').val($calc_input[$ctr]);
                        
                    }
                    <?php } ?>

                    $val = $(this).find('input').val();
                    $(this).append('<input type="hidden" name="calc_input[]" value="'+$val+'">');
					
                    $ctr+=1;
                });

                $("form#gform_39 li#field_39_56 td.gfield_list_cell select").on("change", function(){
                    var total = 0;
                    //var val = "";
                    $("form#gform_39 li#field_39_56 table.gfield_list tbody td:nth-child(4)").each(function(){

                        //alert($(this).find('option:selected').text());
                        if($(this).find('option:selected').text().length > 1){
                        	//alert($(this).find('option:selected').val());
                        	total += parseInt($(this).find('option:selected').text().replace('%',''));
                        	//alert(total);
                        }
                    });
                    if(total!==100){
                        $("#input_39_61")
                            .css({'border-color':'#a94442','background-color': '#f2dede'})
                            .val(total);
                    }else if(total==100){
                        $("#input_39_61")
                            .css({'border-color':'#3c763d','background-color': '#dff0d8'})
                            .val(total);
                    }

                });


            }
        })(jQuery);
    </script>

<?php } add_action('wp_footer','benchmark_calc',9999); ?>