jQuery(document).ready(function($) {
	toggleCategory();
});

jQuery( document ).ajaxComplete( function( event, XMLHttpRequest, ajaxOptions ) {
	toggleCategory();
});

function toggleCategory() {
	if(jQuery(".widget-liquid-right .post_select select").val() == 'post') {
		jQuery(".category_select").show();
	}

	jQuery(".post_select select").on('change', function() {
		if(jQuery(this).val() == 'post') {
			jQuery(this).parent().parent().next().show();
		} else {
			jQuery(this).parent().parent().next().hide();
			jQuery(this).parent().parent().next().find('select').val(0);
		}
	});
}