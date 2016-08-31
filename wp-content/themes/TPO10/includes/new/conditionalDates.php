<?php
/**
 * Use Gravity Forms Conditional Logic with Dates
 * http://gravitywiz.com/use-gravity-forms-conditional-logic-with-dates/
 */
add_filter("gform_field_value_timestamp", "gwiz_populate_timestamp");
function gwiz_populate_timestamp( $value ){
    return time();
}