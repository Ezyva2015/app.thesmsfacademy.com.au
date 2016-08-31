	jQuery( document ).ready( function( $ ) {
		
		var ms_one_day = 1000 * 60 * 60 * 24;

		var form_id     = '63';
		var date_format = 'dd-mm-yy';
		var yearCount = 0;
		var monthCount = 0;
		
		
		jQuery("#input_63_70").datepicker({
			dateFormat: 'dd/mm/yy',
			onSelect: function(dateText, inst){
				update_number_days();
				
			}
		});
		
		
		
		jQuery("#input_63_110").datepicker({
			dateFormat: 'dd/mm/yy',
			onSelect: function(dateText, inst){
				
				update_number_days();
				
			}
		});
		
		
		
		var update_number_days = function() {
			var split_birth = jQuery("#input_63_70").val().split("/");
			var split_commence = jQuery("#input_63_110").val().split("/");
			var value_date_birth = new Date(split_birth[2], split_birth[1]-1, split_birth[0]);
			var value_date_commence   = new Date(split_commence[2], split_commence[1]-1, split_commence[0]);
			
 			
			
			
			if ( value_date_birth && value_date_commence ) {
				yearCount = value_date_commence.getFullYear() - value_date_birth.getFullYear();
				
				if(yearCount > 0){
				monthCount = value_date_commence.getMonth() - value_date_birth.getMonth();
					if((monthCount < 0) || (monthCount === 0 && value_date_commence.getDate() < value_date_birth.getDate())){
						yearCount --;
					}
				}
				else {
					yearCount = 0;
				}
					jQuery("#input_63_264").val( yearCount );
					jQuery("#input_63_264").trigger( 'change' );
			}
		};

		jQuery("#input_63_70").change( update_number_days );
		jQuery("#input_63_110").change( update_number_days );

		

		update_number_days();

} );

