jQuery( document ).ready( function() {
	jQuery('a.optional_extras').css('display', 'none');
	jQuery('form.variations_form .variations select').change( function() {
		setTimeout(runChecks, 100);
	});
	
});

function runChecks()
{
	jQuery('form.variations_form .variations select').each( function() {
		jQuery(this).prev('a').css( 'display', jQuery(this).css('display'));
	});	
}