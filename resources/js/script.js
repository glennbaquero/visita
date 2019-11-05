$(document).ready(function() {
	app.init();
});

var app = {

	init: function() {
		var setup = this.setup;

		setup.slickSliders();
		setup.menu();
	},

	setup: {

		menu: function() {

			var $window = $(window);
		    	$window.scroll(function () {
		        if ($window.scrollTop() > 0) {
		          	$('.hdr-frm').addClass('scroll');
		          	
		        } else {
		        	$('.hdr-frm').removeClass('scroll');
		        }
		    });

		},

		slickSliders: function() {

			$('.gnrl-frm--sldr').slick({
				infinite: true,
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        speed: 1500,
		        autoplay: true,
		        autoplaySpeed: 2000,
		        arrows: true,
		        dots: true
		    });

			$('.slick-prev').html('<img src="images/left-arrow.png">');
			$('.slick-next').html('<img src="images/right-arrow.png">');
		}

	}



}