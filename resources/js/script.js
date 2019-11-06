$(document).ready(function() {
	app.init();
});

var app = {

	init: function() {
		var setup = this.setup;

		setup.menu();
		setup.slickSliders();
		setup.animations();
		setup.home();
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


			$('.mbl-hdr-frm__nav-holder').on('click', function() {

				$('.mbl-hdr-frm__nav-links-holder').addClass('show');

			});		

			$('.mbl-hdr-frm__link-holder-btn').on('click', function() {

				$('.mbl-hdr-frm__nav-links-holder').removeClass('show');

			});		

			var section_btn = $('.js-trigger');

			section_btn.on('click', function() {

				var id = $(this).data('section');

				$('.mbl-hdr-frm__nav-links-holder').removeClass('show');

            	TweenMax.to(window, 1, {scrollTo: {y: '#'+id, offsetY: 0, autoKill:false}});

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
		},

		animations: function() {

			var controller = new ScrollMagic.Controller();


			$('.hm-frm1-fade-up__item').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$(this), 
        			1, 
        			{opacity:0, y: '40px', ease:Power2.easeIn}, 
        			{opacity:1, y: '0', ease:Power2.easeNone}
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.5,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			$('.hm-frm2-fade-up__item1').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$(this), 
        			1, 
        			{opacity:0, y: '30%', ease:Power2.easeIn}, 
        			{opacity:1, y: '0%', ease:Power2.easeNone}
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.7,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			$('.hm-frm2-fade-up__item2').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$(this), 
        			1, 
        			{opacity:0, y: '50px', ease:Power2.easeIn}, 
        			{opacity:1, y: '0', ease:Power2.easeNone}
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.8,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			$('.hm-frm3-fade-up__trigger').each(function() {
	            var tl = new TimelineMax();
	            tl.staggerFrom(
	            	".hm-frm3-fade-up__item", 
	            	1, 
	            	{ opacity: 0, y:'50px', ease: Power2.easeNone },
	            	0.2,
	            ).staggerTo(
	           		".hm-frm3-fade-up__item", 
	            	1, 
	            	{ opacity: 1, y:'0', ease: Power2.easeInOut }, 
	            	0.2,
	            )

	            var scene = new ScrollMagic.Scene({
	                triggerElement: this,
	                triggerHook: 0.5,
	                reverse:false,
	            })
	            .setTween(tl)
	            .addTo(controller);

        	});


			$('.hm-frm4-fade-up__trigger').each(function() {
	            var tl = new TimelineMax();
	            tl.staggerFrom(
	            	".hm-frm4-fade-up__item", 
	            	1, 
	            	{ opacity: 0, y:'50px', ease: Power2.easeNone },
	            	0.2,
	            ).staggerTo(
	           		".hm-frm4-fade-up__item", 
	            	1, 
	            	{ opacity: 1, y:'0', ease: Power2.easeInOut }, 
	            	0.2,
	            )

	            var scene = new ScrollMagic.Scene({
	                triggerElement: this,
	                triggerHook: 0.5,
	                reverse:false,
	            })
	            .setTween(tl)
	            .addTo(controller);

        	});

			$('.hm-frm5-fade-up__item').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$(this), 
        			1, 
        			{opacity:0, y: '40px', ease:Power2.easeIn}, 
        			{opacity:1, y: '0', ease:Power2.easeNone}
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.9,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

		},

		home: function() {

			$(window).resize(function() {
			  var width = $(this).width();
			  if(width < 1025) {
			    $.scrollify.disable();
			  } else {
			    $.scrollify.enable();
			  }
			});

			$(function() {
		        $.scrollify({
		        	section : ".scrllfy-frame",
				    interstitialSection : ".ftr-frm",
				    easing: "easeInOutQuad",
				    scrollSpeed: 1100,
				    offset : 0,
				    setHeights: true,
				    updateHash: true,
				    touchScroll: true,
				});
			});

		    $('.hm-frm2__tabbing-content').first().css('display', 'inline-block');
		    $('.hm-frm2__tabbing-btn').first().addClass('active');

			$('.hm-frm2__tabbing-btn').on('click', function(){
				var id = $(this).data('frame2tab-id');

				$('.hm-frm2__tabbing-btn').removeClass('active');
				$(this).addClass('active');
				
				$('.hm-frm2__tabbing-content').fadeOut(0);

			    $('#'+id).fadeIn(300);
		    });

		},

	}

}