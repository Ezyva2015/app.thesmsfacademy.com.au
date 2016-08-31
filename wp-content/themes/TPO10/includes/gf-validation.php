<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//				 Gravity Forms Validation. 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////

//Gravity Forms - Enable Password Field
add_action("gform_enable_password_field", "enable_password");

//Start - Gravity Forms Validation Hook - Tim
 add_filter('gform_custom_merge_tags', 'merge_gf_role', 10, 4);
 add_filter('gform_replace_merge_tags', 'replace_merge_tags', 10, 7);
 add_filter('gform_field_content', 'replace_field_content', 10, 5);




 function merge_gf_role ($merge_tags, $form_id, $fields, $element_id) {



	 $merge_tags[] = array('label' => 'Is ParatusOne', 'tag' => '{is_ParatusOne}');

	 return $merge_tags;

 }

 function replace_merge_tags ($text, $form, $lead, $url_encode, $esc_html, $nl2br, $format){
	global $current_user;
	$rolesText = '';
	$roles = $current_user->roles;
	foreach($roles as $role){
		$rolesText = $rolesText.$role.' ';
	}

	$text = str_replace('{is_ParatusOne}', $rolesText, $text);

	return $text;


 }

 function replace_field_content($field_content, $field, $value, $lead_id, $form_id){
	if(strpos($field_content, '{is_ParatusOne}') !== false) {
		global $current_user;
		$rolesText = '';
		$roles = $current_user->roles;
		foreach($roles as $role){
			$rolesText = $rolesText.$role.' ';
		}

		if(strpos($rolesText, 'ignite_level_53630aed2f698') !== false) {
			$isParatusOne = 'Yes';
		}
		else {
			$isParatusOne = 'No';
		}

		$field_content = str_replace('{is_ParatusOne}', $isParatusOne, $field_content);
	}

	return $field_content;
 }


add_filter("gform_field_validation_57_1", "companyName_validation", 10, 4);
add_filter("gform_field_validation_54_94", "companyName_validation", 10, 4);
function companyName_validation($result, $value, $form, $field){

	$containsSuffix = 0;

	if(strpos(strtolower($value), 'pty ltd') !== false) {
			$containsSuffix = 1;
	}
	elseif(strpos(strtolower($value), 'proprietary') !== false) {
			$containsSuffix = 1;
	}
	elseif(strpos(strtolower($value), ' ltd') !== false) {
			$containsSuffix = 1;
	}
	elseif(strpos(strtolower($value), ' pty') !== false) {
			$containsSuffix = 1;
	}

    if($result["is_valid"] && $containsSuffix == 1){
        $result["is_valid"] = false;
        $result["message"] = "Please do not include a company suffix (i.e. 'Pty Ltd') in the Company Name field.";
    }
    return $result;
}

add_filter("gform_field_validation_53_178", "clauseRule_validation", 10, 4);
add_filter("gform_field_validation_53_180", "clauseRule_validation", 10, 4);
add_filter("gform_field_validation_55_326", "clauseRule_validation", 10, 4);
add_filter("gform_field_validation_55_380", "clauseRule_validation", 10, 4);
add_filter("gform_field_validation_63_323", "clauseRule_validation", 10, 4);
function clauseRule_validation($result, $value, $form, $field){

	$containsClauseRule = 0;

	if(strpos(strtolower($value), 'clause') !== false) {
			$containsClauseRule = 1;
	}
	elseif(strpos(strtolower($value), 'rule') !== false) {
			$containsClauseRule = 1;
	}


    if($result["is_valid"] && $containsClauseRule == 1){
        $result["is_valid"] = false;
        $result["message"] = "Please do not include the words 'Clause' or 'Rule' in this field.";
    }
    return $result;
}


// add_filter("gform_field_validation", "apostrophe_yourRef", 10, 4);
// function apostrophe_yourRef($validation_result)
   // {

    // // retrieve the $form
    // $form = $validation_result['form'];


        // foreach($form['fields'] as  &$field)
		 // {

            // // NOTE: replace 5 with the field you would like to mark invalid

         // if(strpos($field['cssClass'], 'yourRef') === false)
			          // {
				        	// continue;
				       // }
						// else

								// {    //input  reference
						        // $yourRef = rgpost("input_{$field['id']}");


                                  // //check if has apostrophes
								// if (strpos($yourRef, "'") !== FALSE)
								// {
									// $validation_result['is_valid'] = false;
											// $field['failed_validation'] = true;
											// $field['validation_message'] = 'Please do not put apostrophes in this field.';
											// break;
								// }



				               // }

		 // }


    // $validation_result['form'] = $form;
  // return $validation_result;

// }


//End - Gravity Forms Validation Hook - Tim

//Gravity Forms Australian Address

add_filter("gform_address_types", "australian_address", 10, 2);

function australian_address($address_types, $form_id){
    $address_types["australia"] = array(
                                    "label" => "Australia",
                                    "country" => "Australia",
                                    "zip_label" => "Postcode",
                                    "state_label" => "State",
                                    "states" => array("", "Australian Capital Terrirory", "New South Wales", "Northern Territory", "Queensland", "South Australia", "Tasmania", "Victoria", "Western Australia")
    );
    return $address_types;
}


add_filter('gform_validation', 'verify_minimum_age');

function verify_minimum_age($validation_result)
   {

    // retrieve the $form
    $form = $validation_result['form'];


        foreach($form['fields'] as  &$field)
		 {

            // NOTE: replace 5 with the field you would like to mark invalid

         if(strpos($field['cssClass'], '18yrs') === false)
			          {
				        	continue;
				       }
						else

								{    //input  date
						        $dob = rgpost("input_{$field['id']}");

                                   //number of years
									$minimum_age = 18;

                                  //compute date range
								$age = date('Y') - substr($dob, -4);
								if (strtotime(date('Y-m-d')) - strtotime(date('Y') . substr($dob, -4)) < 0)
								{
									$age--;
								}

										 if( $age < $minimum_age )
										{
										$validation_result['is_valid'] = false;

										   $field['failed_validation'] = true;
										   $field['validation_message'] = 'Individual must be 18 years or above';
											break;
										}

				               }

		 }


    $validation_result['form'] = $form;
  return $validation_result;
       }

add_filter('gform_validation', 'validate_all_fields');
function validate_all_fields($validation_result) {

    $form = $validation_result["form"];

    // get the current page being submitted, this only applies
    // for multi-page forms
    $current_page = rgpost('gform_source_page_number_' . $form['id']) ? rgpost('gform_source_page_number_' . $form['id']) : 1;
    $page_count = rgpost('gform_page_count_' . $form['id']) ? rgpost('gform_page_count_' . $form['id']) : 1;

    foreach($form['fields'] as &$field){

        // check the field for our custom validation CSS class, this is just
        // a tidy way of being able to apply this validation to any field
        // right from the GF admin
        //if(strpos($field['cssClass'], 'validate-vin') === false)
        //    continue;

        // get the page number the current field is on in the form
        //$field_page = $field['pageNumber'];

		if ( $current_page == $page_count -1 )
		{
				// check if the field is hidden via GF conditional logic
				$is_hidden = RGFormsModel::is_field_hidden($form, $field, array());
				$is_required = $field["isRequired"];
				$is_checkbox = $field["type"];

				if($is_hidden || !$is_required )
					continue;


				// we now know that the field we are validating is on the current page
				// being submitted and that it is not hidden via conditional logic, so let's
				// include the file that contains our VIN validation function
				//require_once(TEMPLATEPATH . '/includes/is_vin-1.1.4.php');

				// get the submitted value from the $_POST
				if ( $is_checkbox == 'checkbox' )
				{
					foreach ($field['inputs'] as $input)
					{
						$input_post_value = 'input_' . str_replace('.', '_', $input['id']);

						// Validate the value
						if ( !isset( $_POST[$input_post_value] ) )
						{
							$field_value = '';
							break;
						}
						else
						{
							$field_value = $_POST[$input_post_value];
						}
					}

					//wp_mail('mon-carlo@ezyva.com', 'paratus', $input_post_value.' '.$_POST[$input_post_value] );
				}
				else
				{
					$field_value = rgpost("input_{$field['id']}");
				}

				// now we will pass our field value to a separate function that
				// will validate whether a valid VIN was submitted or not
				if ($field_value == '' || $field_value == '- Select One -')
				{
					$is_valid = false;
				}
				else
				{
					$is_valid = true;
				}

				// if it is valid, we don't need fail the validation and can continue
				// on to other fields
				if($is_valid)
					continue;

				// if it is NOT valid, we're going to fail the overal form validation
				// then fail the specific field's validation and add a custom error message
				$validation_result['is_valid'] = false;
				$field['failed_validation'] = true;
				$field['validation_message'] = 'This field is required.';
		}
    }

    // now we'll assign our form object (which will be modified if a validation error
    // is found) back to the validation result
    $validation_result['form'] = $form;

    return $validation_result;
}

add_filter("gform_validation_message", "change_message", 10, 2);
function change_message($message, $form)
{
  return '<div class="validation_error">There are some fields which contain invalid data. Please review all information before re-submitting.</div>';
}
?>