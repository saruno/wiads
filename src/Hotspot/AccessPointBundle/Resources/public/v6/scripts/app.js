jQuery(document).ready(function($){
	//Navigation Scroll
	$('a[href*="#"]:not([href="#"]):not([href*="#step"]):not([role="tab"]):not([data-toggle="pill"])').click(function() {
	    if (document.location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && document.location.hostname === this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
	        	$('html, body').animate({
	          		scrollTop: target.offset().top
	        	}, 1000);
	        	return false;
	      	}
	    }
  	});
	
  	$('.owl-login-n1').owlCarousel({
		loop: true,
		items: 1,
		dots: true,
		// autoplay: true,
		autoplayTimeout: 3000,
	});

	$('.owl-login-n2').owlCarousel({
		loop: true,
		items: 1,
		dots: true,
		// autoplay: true,
		autoplayTimeout: 3000,
	});

	$('.owl-login-n4').owlCarousel({
		loop: true,
		items: 1,
		dots: true,
		// autoplay: true,
		autoplayTimeout: 3000,
	});
	
	
});











