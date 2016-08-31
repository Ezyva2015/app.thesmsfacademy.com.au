jQuery( document ).ready( function() {
	
				

	/* MESSAGE POPUP FOR CHECKOUT PAGE - START - */
	
		jQuery( 'form.checkout' ).bind( 'submit', function() {
			var msg = bootbox.dialog({
						message: '<style type="text/css">.bootbox-close-button { visibility:hidden; } </style><img src="/wp-content/themes/goodchoice/ezyva_files/loader.gif" style="float: left; padding-right: 10px; margin-top: -4px;" /><h5 id="asd">Confirming payment details. Please stay on this page. This may take up to 60 seconds.</h5>',
						title: "Processing Your Order"
					});
			var tmr = setInterval( function() {
				if (jQuery('form.checkout').hasClass('processing') == true)
				{
		
				}
				else
				{
					jQuery('.bootbox-close-button').trigger('click');
					closeMsg(tmr);
				}
			}, 1000);
		});
		
		function closeMsg(tmr_event)
		{
			clearInterval(tmr_event);
		}
		
	/* MESSAGE POPUP FOR CHECKOUT PAGE - END - */
	
	/* GRAVITY FORMS AUTO ADD ADDRESS ON DROPDOWN */
		jQuery('#field_66_4').append('<div id="json_msg"></div>');
		jQuery('#json_msg').append('<style type="text/css">#json_msg { width: 100%; display: inline-block; background-color: #000; color: #008000; padding: 8px; margin: 10px 0px !important; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; } #events, #changes { float: left; overflow: auto; width: 50%; min-height: 256px; max-height: 256px; border: 1px solid; background-color: #000; color: #008000; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }</style>');
		jQuery('#json_msg').append('<p style="margin-bottom: 10px !important;">For Debugging only. Remove when migrating the code to Live site.</p>');
		jQuery('#json_msg').append('<div id="events"></div><div id="changes"></div>');
		
		jQuery('.ezy_valid_address').css("display", "none");
		
		jQuery('#events').bind("DOMSubtreeModified",function()
		{
			jQuery(this).animate({ scrollTop: jQuery('#events').prop("scrollHeight")}, 0);
		});

		jQuery('#changes').bind("DOMSubtreeModified",function()
		{
			jQuery(this).animate({ scrollTop: jQuery('#changes').prop("scrollHeight")}, 0);
		});
		
		

		jQuery('#events').append('---------------------------<br />');
		jQuery('#events').append('Validating All Address Fields...<br />');
		jQuery('#events').append('---------------------------<br />');
		
		jQuery('.ezy_address_autocomplete_input input[type="text"]').each( function()
		{ 
			validateAddress( jQuery(this) ); 
		});
		/*validateAddress();*/
		/*
		jQuery('.ezy_address_autocomplete_input input[type="text"]').on('input', function() {
			getParsedAddress( jQuery(this) );
		});
		
		jQuery('.ezy_address_autocomplete_input input[type="text"]').keypress(function() {
			getParsedAddress( jQuery(this) );
		});
		
		jQuery('.ezy_address_autocomplete_input input[type="text"]').bind('paste', function() {
			getParsedAddress( jQuery(this) );
		});
		
		*/
     jQuery('.ezy_address_autocomplete_input input[type="text"]').blur(function() {
			getParsedAddress( jQuery(this) );
		});
	
	
	
  	   jQuery('.mdo input[type="checkbox"]').click(function(){
	   
	   
              if (this.checked) 
                {  
				
				
				var text=jQuery('.ezy_address_autocomplete_input input[type="text"]').attr('ezy_custom_attribute');
				     
					 removehidden(text);
				
				}
				
				else
				{
			
				    jQuery('.ezy_address_autocomplete_input input[type="text"]').blur(function() {
					 getParsedAddress( jQuery(this) );
					});
				
				}
				
	           });  
				
		
		jQuery('.ezy_address_dropdown   select').change(function()    {	
		 populatehidden( jQuery(this) );	
		}); 
	
		
		/*
		jQuery('.ezy_address_autocomplete_input input[type="text"]').mousedown(function() {
			getParsedAddress( jQuery(this) );
		});
	
		jQuery('.ezy_address_autocomplete_input input[type="text"]').click(function() {
			getParsedAddress( jQuery(this) );
		});
		*/
		
		jQuery('.ezy_address_autocomplete_input input[type="text"]').autocomplete({
			search: function(event, ui) {
				jQuery(this).addClass("ui-autocomplete-loading");
			},
			select: function(event, ui) {
				jQuery('#events').append('EVENT: DROPDOWN SELECT - This event fires BEFORE the value of the autocomplete address field gets changed. So we might not able to use this event.<br />');
			},
			open: function(event, ui) {
				jQuery(this).removeClass("ui-autocomplete-loading");
				jQuery('#events').append('<br />---------------------------<br />EVENT: DROPDOWN OPEN - This event fires when the drop down selection appears<br />');
			},
			close: function(event, ui) {
				jQuery('#events').append('EVENT: DROPDOWN CLOSE - This event fires when the drop down selection disappears (Either when the user selects an item or click on other part of the page).<br />Not every close event will be accompanied by a change event. So I backed it up with the .blur() event of the field<br />');
				getParsedAddress( jQuery(this) );
			},
			source: '/scripts/addressAutoComplete.php',
			minLength: 1
		});
		
		function getParsedAddress(obj)
		{
			var autocomplete = '';
			var autocomplete_attribute = jQuery(obj).attr('ezy_custom_attribute');
			/* if (addressVal == null) {
				autocomplete = jQuery('.ezy_address_autocomplete_input input[type="text"]').val();
			}*/
			
			autocomplete = obj.val();
			autocomplete = autocomplete.trim();

			jQuery.getJSON('/scripts/getParsedAddress.php?term='+autocomplete, function(data) {
				
				if ((data.UnitType !== null) && (data.UnitNumber !== null)) {
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( data.UnitType + ' ' + data.UnitNumber );
					//document.getElementById("input_54_227").value  = data.UnitType + ' ' + data.UnitNumber;
				}
				else if (data.UnitNumber !== null){
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( data.UnitNumber );
					
					//document.getElementById("input_54_227").value  = data.UnitNumber;
				}
				else {
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( ' ' );
				
					//document.getElementById("input_54_227").value  = ' ' ;
				}
	
			
              jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( data.Number + ' ' + data.Street + ' ' + data.StreetType );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val( data.Suburb );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val( data.State );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val( data.Postcode );
   
             
				jQuery('#changes').append('---------------------------<br />');
				jQuery('#changes').append('Hiddent Text fields:<br />');
				
				jQuery('#changes').append('input[ezy_custom_attribute='+autocomplete_attribute+'_1: '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val()+'<br />');
				jQuery('#changes').append('input[ezy_custom_attribute='+autocomplete_attribute+'_2: '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val()+'<br />');
				jQuery('#changes').append('input[ezy_custom_attribute='+autocomplete_attribute+'_3: '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val()+'<br />');
				jQuery('#changes').append('input[ezy_custom_attribute='+autocomplete_attribute+'_4: '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val()+'<br />');
				jQuery('#changes').append('input[ezy_custom_attribute='+autocomplete_attribute+'_5: '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val()+'<br />');
						
			});
			
			jQuery('#events').append('---------------------------<br />');
			jQuery('#events').append("- Validating Address for: '"+obj.val()+"' <br />");
			
			validateAddress(obj);
		}

		function removehidden(obj)
		{
		
	            jQuery('input[ezy_custom_attribute='+obj+'_2]').val( ' ' );
				jQuery('input[ezy_custom_attribute='+obj+'_3]').val( ' ' );
				jQuery('input[ezy_custom_attribute='+obj+'_4]').val( ' ' );
				jQuery('input[ezy_custom_attribute='+obj+'_5]').val( ' ' );
			
				
		    }
			
	function populatehidden(obj) {
			
			var autocomplete_attribute = jQuery(obj).attr('ezy_custom_attribute');
			/* if (addressVal == null) {
				autocomplete = jQuery('.ezy_address_autocomplete_input input[type="text"]').val();
			}*/
			autocomplete = obj.val();
			autocomplete = autocomplete.trim();
			
			if(!(obj.val()=="Same as Fund Address") ) {
			  jQuery.getJSON('/scripts/getParsedAddress.php?term='+autocomplete, function(data) {
				
				
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( data.Number + ' ' + data.Street + ' ' + data.StreetType );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val( data.Suburb );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val( data.State );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val( data.Postcode );
   
		   		});
 }else {
                jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( ' ' );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val( ' ' );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val( ' ' );
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val( ' ' );
}
}
		function validateAddress(obj){
			var address = obj.val();
			jQuery.getJSON('/scripts/validateAddress.php?term='+address, function(data) {
			
				if (jQuery.parseJSON(data)==true){
					jQuery('.ezy_valid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "block");
					jQuery('.ezy_invalid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "none");
					jQuery('#events').append('- &#39;'+address+'&#39;: Valid Address?: TRUE<br />');
					
					update_dropdown_addresses( obj );
				}
				else {
					jQuery('.ezy_valid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "none");
					jQuery('.ezy_invalid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "block");
					jQuery('#events').append('- &#39;'+address+'&#39;: Valid Address?: FALSE<br />');
				}
				
			});
		}
		
		function update_dropdown_addresses(obj)
		{
			if (obj.val() != '')
			{
				jQuery('.ezy_address_dropdown select').each( function() {
				
					jQuery('#events').append('---------------------------<br />');
					jQuery('#events').append('- Updating Dropdown Fields...<br />');
					jQuery('#events').append('- '+jQuery(this).attr('id')+': option[ezy_selected_address="'+obj.val()+'"]<br />');
					
					/* REMOVE EXISTING ADDRESSES */
					jQuery('option[value="'+obj.val()+'"]', this).remove();
					
					/* ADD NEW SELECTED ADDRESS */
					jQuery('option:first', this).after('<option ezy_selected_address="1" value="'+obj.val()+'">'+obj.val()+'</option>');

				});
			}
		}
});