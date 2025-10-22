(function($) {
	function toggleCategorySelect(widget) {
		var postTypeSelect = widget.find('.post_select select');
		var categorySelect = widget.find('.category_select');

		function update() {
			if (postTypeSelect.val() === 'post') {
				categorySelect.show();
			} else {
				categorySelect.hide();
				categorySelect.find('select').val('0');
			}
		}

		postTypeSelect.on('change', update);
		update();
	}

	function initWidgetToggle(e, widget) {
		toggleCategorySelect($(widget));
	}

	$(document).on('widget-added widget-updated', function(e, widget) {
		initWidgetToggle(e, widget);
	});

	$('.widget').each(function() {
		toggleCategorySelect($(this));
	});
})(jQuery);