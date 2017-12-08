function include(scriptUrl) {
    document.write('<script src="' + scriptUrl + '"></script>');
}

function isIE() {
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
};

/*----------------------------------------------------*/
/*	Scroll To Top Section
/*----------------------------------------------------*/
	jQuery(document).ready(function () {
	
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('.page_scrollup').fadeIn();
			} else {
				jQuery('.page_scrollup').fadeOut();
			}
		});
	
		jQuery('.page_scrollup').click(function () {
			jQuery("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	
	});	
	
	jQuery.browser = {};
	(function () {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();

	// Add swipe for Bootstrap Carousel 
	jQuery(function ($) {
		//Enable swiping...
		$(".carousel-inner").swipe({
			//Generic swipe handler for all directions
			swipeLeft: function (event, direction, distance, duration, fingerCount) {
			    $(this).parent().carousel('next');
			},
			swipeRight: function () {
			    $(this).parent().carousel('prev');
			},
			//Default is 75px, set to 0 for demo so any distance triggers swipe
			threshold: 0
		});
	});