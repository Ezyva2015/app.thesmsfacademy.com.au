<?php

function fill_gform_57(){
    if(!empty($_GET['uid']) && (!empty($_GET['pid']) && $_GET['pid']=='NSF')){
        global $current_user;
        global $wpdb;
        $uid = $_GET['uid'];
        $query = "SELECT * FROM service_cnp WHERE unique_code = '".$uid."'";

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
                 * Company Name
                 */
                $('#input_57_1').val('<?php echo $params->companyName?>');

                /**
                 * Trustee Type
                 */
                /*select_val('input_52_111','<?php /*echo $params->chairmanTrustee*/ ?>');*/

                /**
                 * What type of Company do you wish to register?
                 */
				 
                select_val('input_57_2','<?php echo $params->companySuffix ?>');

                /**
                 * Which State or Territory is the company to be registered?
                 */
                select_val('input_57_6','<?php echo $params->companyRegState?>');

                /**
                 * Is the proposed company name identical to a Registered Business Name?
                 */
               select_val('input_57_80','<?php echo $params->companyRegState?>');
			  


                    /**
                     * Registered Business Number
                     */
                    $('#input_57_8').val('<?php echo $params->identicalBusinessNumber ?>');

                    /**
                     * State(s) of issue
                     */
                   select_val('input_57_10','<?php echo $params->identicalBusinessStates?>');

                    /**
                     * Fund Address Suburb
                     */
                    $('#input_57_313').val('<?php echo $params->share_Price ?>');

                    /**
                     * Will the company act only as the trustee of a SMSF?
                     */
					 
                    select_val('input_57_81','<?php echo $params->fundAddressState ?>');

                    /**
                     * Sole Purpose SMSF Company Delcaration
                     */
					 
                    $('#input_57_71').val('<?php echo $params->solePurposeDec ?>');
					
					  /**
                     * Care of (C/-)
                     */
					 
					  $('#input_57_140').val('<?php echo $params->	registeredOfficeCareOf ?>');
				
				  /**
                     * Search for Registered Address
                     */
					  $('#input_57_347').val('<?php echo $params->	registeredOfficeAutocomplete ?>');
				
				  <?php if($params->registeredOfficeLevel|| $params->registeredOfficeStreetName || $params->registeredOfficeSuburbN
                || $params->registeredOfficeStateName|| $params->registeredOfficePostcode){ ?>
				
                    select_val('input_57_389','Manual Address Input');

                <?php } ?>


                <?php if($params->teeMtgAddressLevel || $params->teeMtgAddressStreet || $params->teeMtgAddressSuburb
                || $params->teeMtgAddressState || $params->teeMtgAddressPostcode){ ?>
                    select_val('input_57_337','Other Address');
                    $('#choice_331_1').attr('checked','checked');

                    /**
                     * Trustee Meeting Address Level, Floor, Unit, Office, Suite
                     */
					 
                    $('#input_57_332').val('<?php echo $params->teeMtgAddressLevel ?>');

                    /**
                     * Trustee Meeting Address Street Number and Name
                     */
                    $('#input_57_333').val('<?php echo $params->teeMtgAddressStreet ?>');

                    /**
                     * Trustee Meeting Address Suburb
                     */
                    $('#input_57_334').val('<?php echo $params->teeMtgAddressSuburb ?>');

                    /**
                     * Trustee Meeting Address State
                     */
                    select_val('input_57_335','<?php echo $params->teeMtgAddressState ?>');

                    /**
                     * Trustee Meeting Address Postcode
                     */
					 
                    $('#input_57_336').val('<?php echo $params->teeMtgAddressPostcode ?>');

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
                        'NamePrefix'            =>  'input_57_71',
                        'GivenNames'            =>  'input_57_14',
                        'FamilyName'            =>  'input_57_72',
                        'DOB'                   =>  'input_57_15',
                        'TFN'                   =>  'input_57_81',
                        'ResidentialAddress'    =>  'input_57_17',
                        'AddressOverride'       =>  'choice_281_1',
                        'AddressLevel'          =>  'input_57_282',
                        'AddressStreet'         =>  'input_57_283',
                        'AddressSuburb'         =>  'input_57_285',
                        'AddressState'          =>  'input_57_284',
                        'AddressPostcode'       =>  'input_57_286',
                    ),
                    2   =>  array(
                        'NamePrefix'            =>  'input_57_73',
                        'GivenNames'            =>  'input_57_25',
                        'FamilyName'            =>  'input_57_74',
                        'DOB'                   =>  'input_57_24',
                        'TFN'                   =>  'input_57_82',
                        'ResidentialAddress'    =>  'input_57_169',
                        'AddressOverride'       =>  'choice_287_1',
                        'AddressLevel'          =>  'input_57_288',
                        'AddressStreet'         =>  'input_57_289',
                        'AddressSuburb'         =>  'input_57_290',
                        'AddressState'          =>  'input_57_291',
                        'AddressPostcode'       =>  'input_57_292',
                    ),
                    3   =>  array(
                        'NamePrefix'            =>  'input_57_75',
                        'GivenNames'            =>  'input_57_33',
                        'FamilyName'            =>  'input_57_76',
                        'DOB'                   =>  'input_57_34',
                        'TFN'                   =>  'input_57_83',
                        'ResidentialAddress'    =>  'input_57_170',
                        'AddressOverride'       =>  'choice_293_1',
                        'AddressLevel'          =>  'input_57_294',
                        'AddressStreet'         =>  'input_57_295',
                        'AddressSuburb'         =>  'input_57_296',
                        'AddressState'          =>  'input_57_297',
                        'AddressPostcode'       =>  'input_57_298',
                    ),
                    4   =>  array(
                        'NamePrefix'            =>  'input_57_77',
                        'GivenNames'            =>  'input_57_42',
                        'FamilyName'            =>  'input_57_78',
                        'DOB'                   =>  'input_57_43',
                        'TFN'                   =>  'input_57_84',
                        'ResidentialAddress'    =>  'input_57_184',
                        'AddressOverride'       =>  'choice_299_1',
                        'AddressLevel'          =>  'input_57_301',
                        'AddressStreet'         =>  'input_57_302',
                        'AddressSuburb'         =>  'input_57_303',
                        'AddressState'          =>  'input_57_304',
                        'AddressPostcode'       =>  'input_57_305',
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
                $('#input_57_94').val('<?php echo $params->corpTeeName ?>');

                /**
                 * Corporate Trustee ACN
                 */
                $('#input_57_95').val('<?php echo $params->corpTeeACN ?>');

                /**
                 * Care of
                 */
                $('#input_57_105').val('<?php echo $params->corpTeeAddressCareOf ?>');


                /**
                 * Directors of the Corporate Trustee Company
                 */
                <?php if($params->t2NonMemberNamePrefix || $params->t2NonMemberGivenNames || $params->t2NonMemberFamilyName){ ?>

                    select_val('input_57_96','Yes');

                    /**
                     * Non Member Director Title
                     */
                    select_val('input_57_79', '<?php echo $params->t2NonMemberNamePrefix; ?> ');

                    /**
                     * Non Member Director - Given Names
                     */
                    $('#input_57_63').val('<?php echo $params->t2NonMemberGivenNames ?>');

                    /**
                     * Non Member Director - Family Name
                     */
                    $('#input_57_80').val('<?php echo $params->t2NonMemberFamilyName ?>');

                    /**
                     * Director's Residential Address
                     */
                    <?php if($params->d2NonMemberAddressLevel || $params->d2NonMemberAddressStreet || $params->d2NonMemberAddressSuburb
                    || $params->d2NonMemberAddressState || $params->d2NonMemberAddressPostcode){ ?>

                        select_val('input_57_64','Other Address');

                        /**
                         * Director's Residential Address Level, Floor, Unit, Office, Suite
                         */
                        $('#input_57_66').val('<?php echo $params->d2NonMemberAddressLevel ?>');

                        /**
                         * Director's Residential Address Street Number and Name
                         */
                        $('#input_57_70').val('<?php echo $params->d2NonMemberAddressStreet ?>');

                        /**
                         * Director's Residential Address Suburb
                         */
                        $('#input_57_65').val('<?php echo $params->d2NonMemberAddressSuburb ?>');

                        /**
                         * Director's Residential Address State
                         */
                        select_val('input_57_67','<?php echo $params->d2NonMemberAddressState ?>');

                        /**
                         * Director's Residential Address Postcode
                         */
                        $('#input_57_68').val('<?php echo $params->d2NonMemberAddressPostcode ?>');

                    <?php } ?>

                <?php } ?>

                /**
                 * Chairman
                 */
                select_val('input_57_328','<?php echo $params->chairmanTrustee ?>');

                /*---------------------------------------------------------------------------
                 TrusTee Details end
                 ---------------------------------------------------------------------------*/

                
                /*---------------------------------------------------------------------------
                 Confirmation start
                 ---------------------------------------------------------------------------*/

                /**
                 * Email
                 */
                $('#input_57_313').val('<?php echo $params->user_email ?>');

                /*---------------------------------------------------------------------------
                 Confirmation end
                 ---------------------------------------------------------------------------*/

            })(jQuery);
        </script>
    <?php
    }
}
add_action('wp_footer','fill_gform_57',1000);