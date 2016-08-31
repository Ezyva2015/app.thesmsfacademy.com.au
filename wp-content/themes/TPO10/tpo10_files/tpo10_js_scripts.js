jQuery( document ).ready( function() {


	

	
	var targetBox = jQuery('.product .gform_body').closest('.page_head');
	
	var imgTop = ( ( (jQuery(targetBox).height() - 128) / jQuery(targetBox).height() ) * 100 ) / 2;
	var imgLeft = ( ( (jQuery(targetBox).width() - 128) / jQuery(targetBox).width() ) * 100 ) / 2;

	var opts_3 = {
		lines: 13, // The number of lines to draw
		length: 20, // The length of each line
		width: 10, // The line thickness
		radius: 30, // The radius of the inner circle
		corners: 1, // Corner roundness (0..1)
		rotate: 0, // The rotation offset
		direction: 1, // 1: clockwise, -1: counterclockwise
		color: '#000', // #rgb or #rrggbb or array of colors
		speed: 1.6, // Rounds per second
		trail: 60, // Afterglow percentage
		shadow: true, // Whether to render a shadow
		hwaccel: false, // Whether to use hardware acceleration
		className: 'spinner', // The CSS class to assign to the spinner
		zIndex: 2e9, // The z-index (defaults to 2000000000)
		top: 'auto', // Top position relative to parent in px
		left: 'auto' // Left position relative to parent in px
	};

	var target_3 = document.getElementsByClassName('page_head');
	var spinner_3 = new Spinner(opts_3);

	
	jQuery(targetBox).prepend('<div id="overlayBG" style="display: none; width: 100%; height: 100%; background-color: rgba(255,255,255, 0.5); position: absolute; z-index: 99998; cursor: progress;"></div>');
						
	jQuery('.ezy_valid_address').css("display", "none");
	
	jQuery('.ezy_address_autocomplete_input input[type="text"]').each( function()
	{ 
		
		validateAddress( jQuery(this) ); 
	});
	
	//jQuery('.ezy_address_autocomplete_input textarea').each( function()
	//{
	//
	//	validateAddress( jQuery(this) );
	//});

	
	jQuery('.ezy_given_names input[type="text"]').change( function() {
		if ( jQuery(this).val() !== '' )
		{
			save_member_full_name( jQuery(this), 'given_name' );
			save_memberList_member_full_name( jQuery(this), 'given_name' );
			save_public_officer_full_name( jQuery(this), 'given_name' );
		}
	});
	

	
	/* UPDATE EDITABLE COMBOBOX ITEMS */
	jQuery('.ezy_family_names input[type="text"]').change( function() {
		if ( jQuery(this).val() !== '' )
		{
			save_member_full_name( jQuery(this), 'family_name' );
			save_memberList_member_full_name( jQuery(this), 'family_name' );
			save_public_officer_full_name( jQuery(this), 'family_name' );
		}
	});
	
	/* FUNCTION TO MANIPULATE EDITABLE COMBOBOX ITEM ARRAY */
	function add_cbo_items( arr, find, new_value )
	{
		var index = arr.indexOf(find);

		if (index !== -1)
		{
			/* REPLACE IF EXISTS */
			arr[index] = new_value;
		}
		else
		{
			/* ADD IF NOT EXISTS */
			arr.push( new_value );
		}
	}
	
	/* STORE FULL NAME */
	/*
		handler - 'family_name'
		- 'given_name'
	*/
	function save_member_full_name( obj, handler )
	{
		var full_name = '';
		
		if (handler == 'family_name')
			full_name = jQuery(obj).closest('.gfield').prev('.ezy_given_names').find('input[type="text"]').val() + ' ' + jQuery(obj).val();
		else
			full_name = jQuery(obj).val() + ' ' + jQuery(obj).closest('.gfield').next('.ezy_family_names').find('input[type="text"]').val();
			
		/*console.log(full_name);*/
		
		var hidden_attr = jQuery(obj).attr('ezy_custom_attribute')+'_full_name';
		
		jQuery('input[ezy_custom_attribute="'+hidden_attr+'"]').val( full_name );
		
		var selectedItem = jQuery('.ezy_chairman option:selected').text();
		
		jQuery('.ezy_chairman').empty();
		
		jQuery('.ezy_chairman').append('<option value="- Select One -">- Select One -</option>');
		
		var g_name = '';
		var f_name = '';		
		
		jQuery('.ezy_full_names').each( function() {
		
			g_name = jQuery(this).parent().prev('.ezy_family_names').prev('.ezy_given_names').find('input[type="text"]').val();
			f_name = jQuery(this).parent().prev('.ezy_family_names').find('input[type="text"]').val();

			if ( g_name != '' && f_name != '')
			{
				if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
				{
					if ( jQuery(this).val() != '' )
						jQuery('.ezy_chairman').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
				}
			}
			
		});
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_chairman option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}
		
		if ( hasMatch == 0)
		{
			jQuery('.ezy_chairman option[value="- Select One -"]').attr('selected', 'selected');     
		}
		
	}
	
	function loadFullNames()
	{
		
		var selectedItem = jQuery('.ezy_selected_chairman').val();
		
		jQuery('.ezy_chairman').empty();
		
		jQuery('.ezy_chairman').append('<option value="- Select One -">- Select One -</option>');
		jQuery('.ezy_full_names').each( function() {
			if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
			{
				if ( jQuery(this).val() != '' )
					jQuery('.ezy_chairman').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
			}
		});
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_chairman option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}

		if ( hasMatch == 0)
		{
			jQuery('.ezy_chairman option[value="- Select One -"]').attr('selected', 'selected');     
		}
	}
	
	function loadFullNamesOnChangeMemberCount()
	{
		var selectedItem = jQuery('.ezy_chairman option:selected').text();
		jQuery('.ezy_chairman').empty();
		
		jQuery('.ezy_chairman').append('<option value="- Select One -">- Select One -</option>');
		
		var g_name = '';
		var f_name = '';
				
		jQuery('.ezy_full_names').each( function() {
		
			g_name = jQuery(this).parent().prev('.ezy_family_names').prev('.ezy_given_names').find('input[type="text"]').val();
			f_name = jQuery(this).parent().prev('.ezy_family_names').find('input[type="text"]').val();

			if ( g_name != '' && f_name != '')
			{
				if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
				{
					if ( jQuery(this).val() != '' )
						jQuery('.ezy_chairman').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
				}
			}
		});
		
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_chairman option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}
		
		if ( hasMatch == 0)
		{
			jQuery('.ezy_chairman option[value="- Select One -"]').attr('selected', 'selected');     
		}
	}
	
	
	function save_memberList_member_full_name( obj, handler )
	{
		var full_name = '';
		
		if (handler == 'family_name')
			full_name = jQuery(obj).closest('.gfield').prev('.ezy_given_names').find('input[type="text"]').val() + ' ' + jQuery(obj).val();
		else
			full_name = jQuery(obj).val() + ' ' + jQuery(obj).closest('.gfield').next('.ezy_family_names').find('input[type="text"]').val();
			

		
		var hidden_attr = jQuery(obj).attr('ezy_custom_attribute')+'_full_name';
		
		jQuery('input[ezy_custom_attribute="'+hidden_attr+'"]').val( full_name );
		
		var selectedItem = jQuery('.ezy_memberList option:selected').text();
		
		jQuery('.ezy_memberList').empty();
		
		jQuery('.ezy_memberList').append('<option value="- Select One -">- Select One -</option>');
		
		var g_name = '';
		var f_name = '';		
		
		jQuery('.ezy_full_names').each( function() {
		
			g_name = jQuery(this).parent().prev('.ezy_family_names').prev('.ezy_given_names').find('input[type="text"]').val();
			f_name = jQuery(this).parent().prev('.ezy_family_names').find('input[type="text"]').val();
			
			if ( g_name != '' && f_name != '')
			{
				//if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
				//{
					if ( jQuery(this).val() != '' )
						jQuery('.ezy_memberList').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
				//}
			}
			
		});
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_memberList option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}
		
		if ( hasMatch == 0)
		{
			jQuery('.ezy_memberList option[value="- Select One -"]').attr('selected', 'selected');     
		}
		
		
	}
	
	
	function loadMemberListFullNames()
	{
		
		var selectedItem = jQuery('.ezy_selected_memberList').val();
		
		jQuery('.ezy_memberList').empty();
		
		jQuery('.ezy_memberList').append('<option value="- Select One -">- Select One -</option>');
		jQuery('.ezy_full_names').each( function() {
			if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
			{
				if ( jQuery(this).val() != '' )
					jQuery('.ezy_memberList').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
			}
		});
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_memberList option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}

		if ( hasMatch == 0)
		{
			jQuery('.ezy_memberList option[value="- Select One -"]').attr('selected', 'selected');     
		}
	}
	
	
	function loadMemberListFullNamesOnChangeMemberCount()
	{
		var selectedItem = jQuery('.ezy_memberList option:selected').text();
		jQuery('.ezy_memberList').empty();
		
		jQuery('.ezy_memberList').append('<option value="- Select One -">- Select One -</option>');
		
		var g_name = '';
		var f_name = '';
				
		jQuery('.ezy_full_names').each( function() {
		
			g_name = jQuery(this).parent().prev('.ezy_family_names').prev('.ezy_given_names').find('input[type="text"]').val();
			f_name = jQuery(this).parent().prev('.ezy_family_names').find('input[type="text"]').val();

			if ( g_name != '' && f_name != '')
			{
				if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
				{
					if ( jQuery(this).val() != '' )
						jQuery('.ezy_memberList').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
				}
			}
		});
		
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_memberList option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}
		
		if ( hasMatch == 0)
		{
			jQuery('.ezy_memberList option[value="- Select One -"]').attr('selected', 'selected');     
		}
	}
	
	
	function save_public_officer_full_name( obj, handler )
	{
		var full_name = '';
		
		if (handler == 'family_name')
			full_name = jQuery(obj).closest('.gfield').prev('.ezy_given_names').find('input[type="text"]').val() + ' ' + jQuery(obj).val();
		else
			full_name = jQuery(obj).val() + ' ' + jQuery(obj).closest('.gfield').next('.ezy_family_names').find('input[type="text"]').val();
			
		/*console.log(full_name);*/
		
		var hidden_attr = jQuery(obj).attr('ezy_custom_attribute')+'_full_name';
		
		jQuery('input[ezy_custom_attribute="'+hidden_attr+'"]').val( full_name );
		
		var selectedItem = jQuery('.ezy_public_officer option:selected').text();
		
		jQuery('.ezy_public_officer').empty();
		
		jQuery('.ezy_public_officer').append('<option value="- Select One -">- Select One -</option>');
		
		var g_name = '';
		var f_name = '';		
		
		jQuery('.ezy_full_names').each( function() {
		
			g_name = jQuery(this).parent().prev('.ezy_family_names').prev('.ezy_given_names').find('input[type="text"]').val();
			f_name = jQuery(this).parent().prev('.ezy_family_names').find('input[type="text"]').val();

			if ( g_name != '' && f_name != '')
			{
				if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
				{
					if ( jQuery(this).val() != '' )
						jQuery('.ezy_public_officer').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
				}
			}
			
		});
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_public_officer option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}
		
		if ( hasMatch == 0)
		{
			jQuery('.ezy_public_officer option[value="- Select One -"]').attr('selected', 'selected');     
		}
		
	
	}
	
	
	function loadAddresses(){
	
	}
	
	function loadPublicOfficerFullNames()
	{
		
		var selectedItem = jQuery('.ezy_selected_chairman').val();
		
		jQuery('.ezy_public_officer').empty();
		
		jQuery('.ezy_public_officer').append('<option value="- Select One -">- Select One -</option>');
		jQuery('.ezy_full_names').each( function() {
			if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
			{
				if ( jQuery(this).val() != '' )
					jQuery('.ezy_public_officer').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
			}
		});
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_public_officer option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}

		if ( hasMatch == 0)
		{
			jQuery('.ezy_public_officer option[value="- Select One -"]').attr('selected', 'selected');     
		}
	}
	
	function loadPublicOfficerFullNamesOnChangeMemberCount()
	{
		var selectedItem = jQuery('.ezy_public_officer option:selected').text();
		jQuery('.ezy_public_officer').empty();
		
		jQuery('.ezy_public_officer').append('<option value="- Select One -">- Select One -</option>');
		
		var g_name = '';
		var f_name = '';
				
		jQuery('.ezy_full_names').each( function() {
		
			g_name = jQuery(this).parent().prev('.ezy_family_names').prev('.ezy_given_names').find('input[type="text"]').val();
			f_name = jQuery(this).parent().prev('.ezy_family_names').find('input[type="text"]').val();

			if ( g_name != '' && f_name != '')
			{
				if ( jQuery(this).parent().prev('.ezy_family_names').css('display') != 'none' )
				{
					if ( jQuery(this).val() != '' )
						jQuery('.ezy_public_officer').append('<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>');
				}
			}
		});
		
		
		var hasMatch = 0;
		
		if ( selectedItem != '' )
		{
			jQuery('.ezy_public_officer option').each(function()
			{
				if(jQuery(this).text() == selectedItem)
				{
					jQuery(this).attr('selected', 'selected');            
					hasMatch++;
					return false;
				}                        
			});
		}
		
		if ( hasMatch == 0)
		{
			jQuery('.ezy_public_officer option[value="- Select One -"]').attr('selected', 'selected');     
		}
	}
	
	
	
	
	
		
	setTimeout(
  function() 
  {
    jQuery('.ezy_address_dropdown select').each( function()
			{


				console.log("each 1");
				var currentItem = jQuery(this).attr('ezy_custom_attribute');
				var addressItem = jQuery('input[ezy_custom_attribute='+currentItem+'_complete]').val();
				if(addressItem != ''){
					jQuery('option[value="' + addressItem + '"]', this).prop('selected', true);
					
				}
				
				
				
			
			}); 
  }, 3000);
    
 
			
			
			jQuery('.ezy_family_names input[type="text"]').each( function() {

				save_member_full_name( jQuery(this), 'family_name' );
				save_memberList_member_full_name( jQuery(this), 'family_name' );
				save_public_officer_full_name( jQuery(this), 'family_name' );
								
			});
			
			jQuery('.member_count').bind('change', function() {
				
				setTimeout( function() { loadFullNamesOnChangeMemberCount(); }, 1000 );
				setTimeout( function() { loadMemberListFullNamesOnChangeMemberCount(); }, 1000 );
				setTimeout( function() { loadPublicOfficerFullNamesOnChangeMemberCount(); }, 1000 );
				
			});
			
			
			jQuery('.ezy_chairman').bind('change', function() {
				
				jQuery('.ezy_selected_chairman').val( jQuery(this).val() );
			});
			
			jQuery('.ezy_memberList').bind('change', function() {
				jQuery('.ezy_selected_memberList').val( jQuery(this).val() );
			});
			
			jQuery('.ezy_public_officer').bind('change', function() {
				jQuery('.ezy_selected_public_officer').val( jQuery(this).val() );
			});
						
			loadMemberListFullNames();
			loadFullNames();
			loadPublicOfficerFullNames();
			
			
			
			
			
		
	
	
	function processProgressBar( stat )
	{
		
		
	}
	
	jQuery('.mdo input[type="checkbox"]').click(function(){

		console.log('clicked');
		
		if (this.checked) 
		{  
			
			tindex = parseInt(jQuery(this).attr('tabindex'));
			var sum=tindex-1;
			text=jQuery('input[tabindex='+sum+']').attr('ezy_custom_attribute');
			removehidden(text); 
			
		}
		
		else 
		{
			
			jQuery('.ezy_address_autocomplete_input input[type="text"]').blur(function() {
				getParsedAddress( jQuery(this) );
			});
			
		}
		
	});  
	
	
	jQuery('.ezy_address_dropdown select').change(function()    {	
		populatehidden( jQuery(this) );
		console.log("change");
	}); 

	
	jQuery('.ezy_address_autocomplete_input input[type="text"], .ezy_address_autocomplete_input textarea').autocomplete({
		search: function(event, ui) {

			console.log("Searching");
			jQuery(this).addClass("ui-autocomplete-loading");
		},
		select: function(event, ui) {
			/*jQuery('#events').append('EVENT: DROPDOWN SELECT - This event fires BEFORE the value of the autocomplete address field gets changed. So we might not able to use this event.<br />');*/
			console.log("Select");
		},
		open: function(event, ui) {
			jQuery(this).removeClass("ui-autocomplete-loading");
			/*jQuery('#events').append('<br />---------------------------<br />EVENT: DROPDOWN OPEN - This event fires when the drop down selection appears<br />');*/
			console.log("Open");
		},
		close: function(event, ui) {
			/*jQuery('#events').append('EVENT: DROPDOWN CLOSE - This event fires when the drop down selection disappears (Either when the user selects an item or click on other part of the page).<br />Not every close event will be accompanied by a change event. So I backed it up with the .blur() event of the field<br />');*/
			getParsedAddress( jQuery(this) );
			console.log("Close");
		},
		source: '/scripts/addressAutoComplete.php',
		minLength: 1
	});
	
	function toTitleCase(str)
	{
		return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
	}
	
	function getParsedAddress(obj)
	{
		var autocomplete = '';
		var autocomplete_attribute = jQuery(obj).attr('ezy_custom_attribute');

			
		autocomplete = obj.val();
		autocomplete = autocomplete.trim();
		

		
		jQuery.getJSON('/scripts/getParsedAddress.php?term='+autocomplete, function(data) {
		
	
			
			if ((data.UnitType !== null) && (data.UnitNumber !== null)) {
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( toTitleCase(data.UnitType) + ' ' + data.UnitNumber );
				/*document.getElementById("input_54_227").value  = data.UnitType + ' ' + data.UnitNumber;*/
			}
			else if (data.UnitNumber !== null){
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( data.UnitNumber );
				
				/*document.getElementById("input_54_227").value  = data.UnitNumber;*/
			}
			else {
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( '' );
				
				/*document.getElementById("input_54_227").value  = ' ' ;*/
			}
			
			if(data.StreetType !== null){
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( data.Number + ' ' + toTitleCase(data.Street) + ' ' + toTitleCase(data.StreetType) );
			}
			else {
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( data.Number + ' ' + toTitleCase(data.Street));
			}
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val( toTitleCase(data.Suburb) );
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val( data.State );
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val( data.Postcode );
			if (data.UnitNumber !== null){
			     jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_complete]').val( jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val()+' '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val()+' '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val()+' '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val()+' '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val());
			}
			else {
				jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_complete]').val( jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val()+' '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val()+' '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val()+' '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val());
			}			

		});
		

		validateAddress(obj);
	}
	
	function removehidden(obj)
	{

		jQuery('input[ezy_custom_attribute='+obj+'_2]').val( '' );
		jQuery('input[ezy_custom_attribute='+obj+'_3]').val( '' );
		jQuery('input[ezy_custom_attribute='+obj+'_4]').val( '' );
		jQuery('input[ezy_custom_attribute='+obj+'_5]').val( '' );

	}
	
	function populatehidden(obj) {
		var autocomplete = '';
		var autocomplete_attribute = jQuery(obj).attr('ezy_custom_attribute');
		
		autocomplete = obj.val();
		autocomplete = autocomplete.trim();
		
		
		/* STORE COMPLETE ADDRESS */
		
		jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_complete]').val(obj.val());
		
		console.log('input[ezy_custom_attribute='+autocomplete_attribute+'_complete]: '+jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_complete]').val());
		
		if ( obj.val() != "Same as Fund Address" && obj.val() != "Other Address" && obj.val() != "- Select One -")
		{
			jQuery.getJSON('/scripts/getParsedAddress.php?term='+autocomplete, function(data) {
			

				
				if ( data !== null )
				{
				
					if ((data.UnitType !== null) && (data.UnitNumber !== null)) {
						jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( toTitleCase(data.UnitType) + ' ' + data.UnitNumber );
					}
					else if (data.UnitNumber !== null){
						jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( data.UnitNumber );
					}
					else {
						jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( '' );
					}
					
					if(data.StreetType !== null){
						jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( data.Number + ' ' + toTitleCase(data.Street) + ' ' + toTitleCase(data.StreetType) );
					}
					else {
						jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( data.Number + ' ' + toTitleCase(data.Street));
					}
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val( toTitleCase(data.Suburb) );
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val( data.State );
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val( data.Postcode );
				}
				else
				{
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( '' );
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( '' );
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val( '' );
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val( '' );
					jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val( '' );
				}
				
				
			});
		}
		else
		{
			
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_1]').val( '' );
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_2]').val( '' );
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_3]').val( '' );
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_4]').val( '' );
			jQuery('input[ezy_custom_attribute='+autocomplete_attribute+'_5]').val( '' );
			
		}
	}
	
	function validateAddress(obj)
	{
		var address = obj.val();
		
		
		jQuery.getJSON('/scripts/validateAddress.php?term='+address, function(data) {
			

			if (jQuery.parseJSON(data) === true){
				jQuery('.ezy_valid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "block");
				jQuery('.ezy_invalid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "none");
				/*jQuery('#events').append('- &#39;'+address+'&#39;: Valid Address?: TRUE<br />');*/
				
				update_dropdown_addresses( obj );
			}
			else
			{
				jQuery('.ezy_valid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "none");
				jQuery('.ezy_invalid_address_'+obj.attr('ezy_custom_attribute') ).css("display", "block");
				/*jQuery('#events').append('- &#39;'+address+'&#39;: Valid Address?: FALSE<br />');*/
				
			}
			

			
		});
	}
	
	function update_dropdown_addresses(obj)
	{
		if (obj.val() != '')
		{

			
			jQuery('.ezy_address_dropdown select').each( function() {
				var selectedItem = jQuery( 'option:selected', jQuery(this) ).text();

				/* REMOVE EXISTING ADDRESSES */
				jQuery('option[value="'+obj.val()+'"]', this).remove();
			
				/* ADD NEW SELECTED ADDRESS */
				jQuery('option:first', this).after('<option ezy_selected_address="1" value="'+obj.val()+'">'+obj.val()+'</option>');
				
				var hasMatch = 0;
				
				if ( selectedItem != '' )
				{
					jQuery('option', jQuery( this ) ).each(function()
					{
						if(jQuery(this).text() == selectedItem)
						{
							jQuery(this).attr('selected', 'selected');            
							hasMatch++;
							return false;
						}                        
					});
				}
				
				if ( hasMatch == 0)
				{
					jQuery( 'option[value="- Select One -"]', jQuery( this ) ).attr('selected', 'selected');     
				}
			});

		}
	}
});		