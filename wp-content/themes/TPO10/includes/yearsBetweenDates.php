<?php
/**
 * Calculate Number of Days via Two Date Fields
 * http://gravitywiz.com/calculate-number-of-days-between-two-dates/
 */
class GWYearCount {

    private static $script_output;

    function __construct( $args ) {

        extract( wp_parse_args( $args, array(
            'form_id'          => false,
            'start_field_id'   => false,
            'end_field_id'     => false,
            'count_field_id'   => false,
            'include_end_date' => true,
            ) ) );

        $this->form_id        = $form_id;
        $this->start_field_id = $start_field_id;
        $this->end_field_id   = $end_field_id;
        $this->count_field_id = $count_field_id;
        $this->count_adjust   = $include_end_date ? 1 : 0;


		
		
        add_filter( "gform_pre_render_{$form_id}", array( &$this, 'load_form_script'));
        //add_action( "gform_pre_submission_{$form_id}", array( &$this, 'override_submitted_value') );

    }

    function load_form_script( $form ) {
        
        // workaround to make this work for < 1.7
        $this->form = $form;
        add_filter( 'gform_init_scripts_footer', array( &$this, 'add_init_script' ) );
        
        if( self::$script_output ){
            return $form;
		}
		
		
        ?>

        <script type="text/javascript">

        (function(jQuery){

            window.gwdc = function( options ) {

                this.options = options;
                this.startDateInput = jQuery( '#input_' + this.options.formId + '_' + this.options.startFieldId );
                this.endDateInput = jQuery( '#input_' + this.options.formId + '_' + this.options.endFieldId );
                this.countInput = jQuery( '#input_' + this.options.formId + '_' + this.options.countFieldId );

                this.init = function() {

                    var gwdc = this;

                    // add data for "format" for parsing date
                    gwdc.startDateInput.data( 'format', this.options.startDateFormat );
                    gwdc.endDateInput.data( 'format', this.options.endDateFormat );

                    gwdc.populateDayCount();

                    jQuery(document).on( 'change', '#' + this.startDateInput.attr('id') + ', #' + this.endDateInput.attr('id'), function(){
                        gwdc.populateDayCount();
                    });

                }

                this.getDayCount = function() {

                    var startDate = this.parseDate( this.startDateInput.val(), this.startDateInput.data('format') )
                    var endDate = this.parseDate( this.endDateInput.val(), this.endDateInput.data('format') );
                    var dayCount = 0;

                    if( !this.isValidDate( startDate ) || !this.isValidDate( endDate ) )
                        return '';

                    if( startDate > endDate ) {
                        return 0;
                    } else {

                        var diff = endDate - startDate;
						var age = this.Age(startDate, endDate);
						dayCount = age;		
                        //dayCount = diff / ( 60 * 60 * 24 * 1000 ); // secs * mins * hours * milliseconds
                        //dayCount = Math.round( dayCount ) + this.options.countAdjust;

                        return dayCount;
                    }

                }
				
				this.Age = function getAge(startDate, endDate) {
									var commencementDate = new Date(endDate);
									var birthDate = new Date(startDate);
									var age = commencementDate.getFullYear() - birthDate.getFullYear();
									var m = commencementDate.getMonth() - birthDate.getMonth();
									if (m < 0 || (m === 0 && commencementDate.getDate() < birthDate.getDate())) {
										age--;
									}
									return age;
								}

                this.parseDate = function( value, format ) {

                    if( !value )
                        return false;

                    format = format.split('_');
                    var dateFormat = format[0];
                    var separators = { slash: '/', dash: '-', dot: '.' };
                    var separator = format.length > 1 ? separators[format[1]] : separators.slash;
                    var dateArr = value.split(separator);

                    switch( dateFormat ) {
                    case 'mdy':
                        return new Date( dateArr[2], dateArr[0] - 1, dateArr[1] );
                    case 'dmy':
                        return new Date( dateArr[2], dateArr[1] - 1, dateArr[0] );
                    case 'ymd':
                        return new Date( dateArr[0], dateArr[1] - 1, dateArr[2] );
                    }

                    return false;
                }

                this.populateDayCount = function() {
                    this.countInput.val( this.getDayCount() ).change();
                }

                this.isValidDate = function( date ) {
                    return !isNaN( Date.parse( date ) );
                }

                this.init();

            }

        })(jQuery);

        </script>

        <?php
        self::$script_output = true;
        return $form;
    }
    
    function add_init_script( $return ) {
        
        $start_field_format = false;
        $end_field_format = false;

        foreach( $this->form['fields'] as &$field ) {

            if( $field['id'] == $this->start_field_id )
                $start_field_format = $field['dateFormat'] ? $field['dateFormat'] : 'mdy';

            if( $field['id'] == $this->end_field_id )
                $end_field_format = $field['dateFormat'] ? $field['dateFormat'] : 'mdy';

        }
        
        $script = " 
		
		new gwdc({
                formId:             {$this->form['id']},
                startFieldId:       {$this->start_field_id},
                startDateFormat:    '$start_field_format',
                endFieldId:         {$this->end_field_id},
                endDateFormat:      '$end_field_format',
                countFieldId:       {$this->count_field_id},
                countAdjust:        {$this->count_adjust}
            });
			
			";
		$slug = implode( '_', array( 'gw_display_count', $this->start_field_id, $this->end_field_id, $this->count_field_id ) );
        
       // GFFormDisplay::add_init_script( $this->form['id'], 'gw_display_count_' . $this->count_field_id, GFFormDisplay::ON_PAGE_RENDER, $script );
		GFFormDisplay::add_init_script( $this->form['id'], $slug, GFFormDisplay::ON_PAGE_RENDER, $script );
        
        // remove filter so init script is not output on subsequent forms
        remove_filter( 'gform_init_scripts_footer', array( &$this, 'add_init_script' ) );
        
        return $return;
    }

    function override_submitted_value( $form ) {

        $start_date = false;
        $end_date = false;

        foreach( $form['fields'] as &$field ) {

            if( $field['id'] == $this->start_field_id )
                $start_date = self::parse_field_date( $field );

            if( $field['id'] == $this->end_field_id )
                $end_date = self::parse_field_date( $field );

        }

        if( $start_date > $end_date ) {

            $day_count = 0;

        } else {

            $diff = $end_date - $start_date;
			//$age = getAgeValue($start_Date, $end_Date);
			//$day_count = age;		
            //$day_count = $diff / ( 60 * 60 * 24 ); // secs * mins * hours
            $day_count = round( $day_count ) + $this->count_adjust;
			

        }

        $_POST["input_{$this->count_field_id}"] = $day_count;

    }

	// function getAgeValue($startDate, $endDate) {
		// $commencementDate = new Date($endDate);
		// $birthDate = new Date($startDate);
		// $age = $commencementDate.getFullYear() - $birthDate.getFullYear();
		// $m = $commencementDate.getMonth() - $birthDate.getMonth();
		// if (m < 0 || (m === 0 && $commencementDate.getDate() < $birthDate.getDate())) {
			// $age--;
		// }
		// return $age;
	// }
	
	
    static function parse_field_date( $field ) {

        $date_value = rgpost("input_{$field['id']}");
        $date_format = empty( $field['dateFormat'] ) ? 'mdy' : esc_attr( $field['dateFormat'] );
        $date_info = GFCommon::parse_date( $date_value, $date_format );
		 if( empty( $date_info ) )
            return false;

        return strtotime( "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}" );
    }

}

//Start - Days between two fields

//End - Days between two fields
// new GWDayCount( array(
    // 'form_id'        => 16,
    // 'start_field_id' => 1,
    // 'end_field_id'   => 2,
    // 'count_field_id' => 4
    // ) );