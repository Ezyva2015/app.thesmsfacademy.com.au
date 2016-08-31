<?php

function fill_gform_52(){
    if(!empty($_GET['uid']) && (!empty($_GET['pid']) && $_GET['pid']=='NSF')){
        global $current_user;
        global $wpdb;
        $uid = $_GET['uid'];
        $query = "SELECT * FROM service_nsf WHERE unique_code = '".$uid."'";

        $params = $wpdb->get_row($query);
        ?>
        <script type="text/javascript">
            (function($){

                var select_val = function(form_field, value){
                    var ctr = 0;
                    $('#'+form_field+' option').each(function(){
                        if($(this).val().toLowerCase() === value.toLowerCase()){
                            $(this).attr('selected','selected');
                            return false;
                        }else{
                            $('#'+form_field+' option').eq(0).attr('selected','selected');
                        }
                    });
                };

                /*---------------------------------------------------------------------------
                    Fund Details start
                 ---------------------------------------------------------------------------*/

                /**
                 * Name of the Fund to be Established
                 */
                $('#input_52_2').val('<?php echo $params->fundName ?>');

                /**
                 * Trustee Type
                 */
                select_val('input_52_111','<?php echo $params->chairmanTrustee ?>');

                /**
                 * How many Members will the Fund have?
                 */
                select_val('input_52_12','<?php echo $params->numMembers ?>');

                /**
                 * State Law to govern the Fund
                 */
                select_val('input_52_9','<?php echo $params->stateLaw ?>');

                /**
                 * Fund Address Care Of
                 */
                $('#input_52_265').val('<?php echo $params->fundAddressCareOf ?>');

                <?php if($params->fundAddressLevel || $params->fundAddressStreet || $params->fundAddressSuburb
                || $params->fundAddressState || $params->fundAddressPostcode){ ?>
                    select_val('input_52_345','Manual Address Input');

                    /**
                     * Fund Address Level, Floor, Unit, Office, Suite
                     */
                    $('#input_52_276').val('<?php echo $params->fundAddressLevel ?>');

                    /**
                     * Fund Address Street Number and Name
                     */
                    $('#input_52_278').val('<?php echo $params->fundAddressStreet ?>');

                    /**
                     * Fund Address Suburb
                     */
                    $('#input_52_279').val('<?php echo $params->fundAddressSuburb ?>');

                    /**
                     * Fund Address State
                     */
                    select_val('input_52_277','<?php echo $params->fundAddressState ?>');

                    /**
                     * Fund Address Postcode
                     */
                    $('#input_52_280').val('<?php echo $params->fundAddressPostcode ?>');

                <?php } ?>


                <?php if($params->teeMtgAddressLevel || $params->teeMtgAddressStreet || $params->teeMtgAddressSuburb
                || $params->teeMtgAddressState || $params->teeMtgAddressPostcode){ ?>
                    select_val('input_52_337','Other Address');
                    $('#choice_331_1').attr('checked','checked');

                    /**
                     * Trustee Meeting Address Level, Floor, Unit, Office, Suite
                     */
                    $('#input_52_332').val('<?php echo $params->teeMtgAddressLevel ?>');

                    /**
                     * Trustee Meeting Address Street Number and Name
                     */
                    $('#input_52_333').val('<?php echo $params->teeMtgAddressStreet ?>');

                    /**
                     * Trustee Meeting Address Suburb
                     */
                    $('#input_52_334').val('<?php echo $params->teeMtgAddressSuburb ?>');

                    /**
                     * Trustee Meeting Address State
                     */
                    select_val('input_52_335','<?php echo $params->teeMtgAddressState ?>');

                    /**
                     * Trustee Meeting Address Postcode
                     */
                    $('#input_52_336').val('<?php echo $params->teeMtgAddressPostcode ?>');

                <?php } ?>

                /*---------------------------------------------------------------------------
                 Fund Details end
                 ---------------------------------------------------------------------------*/


                /*---------------------------------------------------------------------------
                 Member Details start
                 ---------------------------------------------------------------------------*/

                <?php
                $memDetails = array(
                    1   =>   array(
                        'NamePrefix'            =>  'input_52_71',
                        'GivenNames'            =>  'input_52_14',
                        'FamilyName'            =>  'input_52_72',
                        'DOB'                   =>  'input_52_15',
                        'TFN'                   =>  'input_52_81',
                        'ResidentialAddress'    =>  'input_52_17',
                        'AddressOverride'       =>  'choice_281_1',
                        'AddressLevel'          =>  'input_52_282',
                        'AddressStreet'         =>  'input_52_283',
                        'AddressSuburb'         =>  'input_52_285',
                        'AddressState'          =>  'input_52_284',
                        'AddressPostcode'       =>  'input_52_286',
                    ),
                    2   =>  array(
                        'NamePrefix'            =>  'input_52_73',
                        'GivenNames'            =>  'input_52_25',
                        'FamilyName'            =>  'input_52_74',
                        'DOB'                   =>  'input_52_24',
                        'TFN'                   =>  'input_52_82',
                        'ResidentialAddress'    =>  'input_52_169',
                        'AddressOverride'       =>  'choice_287_1',
                        'AddressLevel'          =>  'input_52_288',
                        'AddressStreet'         =>  'input_52_289',
                        'AddressSuburb'         =>  'input_52_290',
                        'AddressState'          =>  'input_52_291',
                        'AddressPostcode'       =>  'input_52_292',
                    ),
                    3   =>  array(
                        'NamePrefix'            =>  'input_52_75',
                        'GivenNames'            =>  'input_52_33',
                        'FamilyName'            =>  'input_52_76',
                        'DOB'                   =>  'input_52_34',
                        'TFN'                   =>  'input_52_83',
                        'ResidentialAddress'    =>  'input_52_170',
                        'AddressOverride'       =>  'choice_293_1',
                        'AddressLevel'          =>  'input_52_294',
                        'AddressStreet'         =>  'input_52_295',
                        'AddressSuburb'         =>  'input_52_296',
                        'AddressState'          =>  'input_52_297',
                        'AddressPostcode'       =>  'input_52_298',
                    ),
                    4   =>  array(
                        'NamePrefix'            =>  'input_52_77',
                        'GivenNames'            =>  'input_52_42',
                        'FamilyName'            =>  'input_52_78',
                        'DOB'                   =>  'input_52_43',
                        'TFN'                   =>  'input_52_84',
                        'ResidentialAddress'    =>  'input_52_184',
                        'AddressOverride'       =>  'choice_299_1',
                        'AddressLevel'          =>  'input_52_301',
                        'AddressStreet'         =>  'input_52_302',
                        'AddressSuburb'         =>  'input_52_303',
                        'AddressState'          =>  'input_52_304',
                        'AddressPostcode'       =>  'input_52_305',
                    ),
                );


                $ctr = 1;
                while($ctr <= $params->numMembers){ ?>

                    /*--------------------------------------
                     *  Member <?=$ctr?>
                     --------------------------------------*/
                    /**
                     * Member <?=$ctr?> Details Title
                     */
                    select_val('<?php echo $memDetails[$ctr]['NamePrefix'] ?>','<?php $NamePrefix = 'm'.$ctr.'MemberNamePrefix'; echo $params->$NamePrefix ?>');

                    /**
                     * Member <?=$ctr?> Details Given Names
                     */
                    $('#<?php echo $memDetails[$ctr]['GivenNames'] ?>').val('<?php $GivenNames = 'm'.$ctr.'MemberGivenNames'; echo $params->$GivenNames ?>');

                    /**
                     * Member <?=$ctr?> Details Family Name
                     */
                    $('#<?php echo $memDetails[$ctr]['FamilyName'] ?>').val('<?php $FamilyName = 'm'.$ctr.'MemberFamilyName'; echo $params->$FamilyName ?>');

                    /**
                     * Member <?=$ctr?> Details Date of Birth
                     */
                    $('#<?php echo $memDetails[$ctr]['DOB'] ?>').val('<?php $DOB = 'm'.$ctr.'MemberDOB'; echo $params->$DOB ?>');

                    /**
                     * Member <?=$ctr?> Details TFN
                     */
                    $('#<?php echo $memDetails[$ctr]['TFN'] ?>').val('<?php $TFN = 'm'.$ctr.'MemberTFN'; echo $params->$TFN ?>');


                    <?php
                    $AddressLevel   = 'm'.$ctr.'AddressLevel';
                    $AddressStreet  = 'm'.$ctr.'AddressStreet';
                    $AddressSuburb  = 'm'.$ctr.'AddressSuburb';
                    $AddressState   = 'm'.$ctr.'AddressState';
                    $AddressPostcode= 'm'.$ctr.'AddressPostcode';

                    if($params->$AddressLevel || $params->$AddressStreet || $params->$AddressSuburb
                    || $params->$AddressState || $params->$AddressPostcode){ ?>
                        select_val('<?php echo $memDetails[$ctr]['ResidentialAddress'] ?>','Other Address');
                        $('#<?php echo $memDetails[$ctr]['AddressOverride'] ?>').attr('checked','checked');

                        /**
                         * Member <?=$ctr?> Residential Address Level, Floor, Unit, Office, Suite
                         */
                        $('#<?php echo $memDetails[$ctr]['AddressLevel'] ?>').val('<?php echo $params->$AddressLevel ?>');

                        /**
                         * Member <?=$ctr?> Residential Address Street Number and Name
                         */
                        $('#<?php echo $memDetails[$ctr]['AddressStreet'] ?>').val('<?php echo $params->$AddressStreet ?>');

                        /**
                         * Member <?=$ctr?> Residential Address Suburb
                         */
                        $('#<?php echo $memDetails[$ctr]['AddressSuburb'] ?>').val('<?php echo $params->$AddressSuburb ?>');

                        /**
                         * Member <?=$ctr?> Residential Address State
                         */
                        select_val('<?php echo $memDetails[$ctr]['AddressState'] ?>','<?php echo $params->$AddressState ?>');

                        /**
                         * Member <?=$ctr?> Residential Address Postcode
                         */
                        $('#<?php echo $memDetails[$ctr]['AddressPostcode'] ?>').val('<?php echo $params->$AddressPostcode ?>');

                    <?php }
                    $ctr+=1;
                } ?>

                /*---------------------------------------------------------------------------
                 Member Details end
                 ---------------------------------------------------------------------------*/


                /*---------------------------------------------------------------------------
                 TrusTee Details start
                 ---------------------------------------------------------------------------*/
                /**
                 * Corporate Trustee Name
                 */
                $('#input_52_94').val('<?php echo $params->corpTeeName ?>');

                /**
                 * Corporate Trustee ACN
                 */
                $('#input_52_95').val('<?php echo $params->corpTeeACN ?>');



                /*---------------------------------------------------------------------------
                 TrusTee Details end
                 ---------------------------------------------------------------------------*/

            })(jQuery);
        </script>
    <?php
    }
}
add_action('wp_footer','fill_gform_52',1000);