/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

(function ($) {

	$.fn.switchLocale = function (ajaxUrl) {

		this.on(
			"click",
			function () {
				window.location.replace(ajaxUrl + "/" + $(this).val());
			}
		);

		return this;
	};

}(jQuery));
