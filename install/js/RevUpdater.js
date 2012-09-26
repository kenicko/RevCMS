/*!
 * jQuery RevCMS AJAX Updater plugin
 * Version 0.12 (12-JUL-2012)
 * @requires jQuery v1.2.3 or later
 *
 * Copyright (c) 2007-2010 Team Rev
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html 
 *
 * @author Heaplink <me@humanoidism.dk>
 * @website http://humanoidism.dk
 */

;(function() {

	/*function setup($) {
		if (/1\.(0|1|2)\.(0|1|2)/.test($.fn.jquery) || /^1.1/.test($.fn.jquery)) {
			alert('RevUpdater requires jQuery v1.2.3 or later!  You are using v' + $.fn.jquery);
			return;
		}
	}*/

	$.fn.updater = function(opts) {
		var fullOpts = $.extend({}, $.RevUpdater.defaults, opts || {});
		var container = this;

		return this.each(function(index) {
			var field = $("#update").attr('data-field');
			var fieldID = $(this).attr('id');

			var buttonLayer = "<input type=\"button\" id=\"update\" data-field=\""+fieldID+"\">";
			$(buttonLayer).insertAfter(this);

			$(this).keyup(function() {
				if($("#update[data-field="+fieldID+"]").hasClass('done'))
					$("#update[data-field="+fieldID+"]").removeClass('done');
				else if ($("#update[data-field="+fieldID+"]").hasClass('warning'));
					$("#update[data-field="+fieldID+"]").removeClass('warning');

				$("#update[data-field="+fieldID+"]").removeAttr("disabled");
			});

			$("#update[data-field="+fieldID+"]").click(function() {
				$(this).addClass('updating');

				fullOpts.data = "data=" + $(container).val() + "&field=" + $(container).attr('name');
				fullOpts.success = function(data) {
					if(data.message == "OK") {
						console.log("Everything is OK");
						done("#update[data-field="+fieldID+"]");
					} else {
						console.log("Gosh, it failed! " + data.message);
						warning("#update[data-field="+fieldID+"]");
					}
					console.log(data);
				};

				$.ajax(fullOpts);
			});

			console.log("Initialized for " + field + " - " + fieldID);
		});

	};

	function warning(el) {
		$(el).removeClass('updating');
		$(el).addClass('warning');
		$(el).attr("disabled", "disabled");
	}

	function done(el) {
		$(el).removeClass('updating');
		$(el).addClass('done');
		$(el).attr("disabled", "disabled");
	}

	$.RevUpdater = function(opts) { install(window, opts); };

	$.RevUpdater.defaults = {
		url: "update.php",
		type: "POST",
		success: function(data) {  },
		data: null
	};

})();