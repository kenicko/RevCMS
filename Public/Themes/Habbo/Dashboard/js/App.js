/**
 * RevCMS Housekeeping Application File
 *
 * @author Heaplink
 */

$(function () {

	$.RevModal = function(opts) {
		var fullOpts = $.extend({}, $.RevModal.defaults, opts || {});
		this.each(function() {
			var $el = $(this);

			if ($.RevModal.defaults.buttons.okButton)
			{
				alert("Got OK button");
			}

			if ($RevModal.defaults.buttons.cancelButton)
			{
				alert("Got Cancel Button");
			}
		});

		$.blockUI();
	};

	$.RevModal.defaults = {
		message: 'Another para',

		title: 'Get information',

		buttons: {
			okButton: true,
			cancelButton: true
		},

		onClose: null
	};

})(jQuery);
