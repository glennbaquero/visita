$(document).ready(function() {
	app.init();
});

var app = {

	init: function() {
		var setup = this.setup;

		let page_type = document.head.querySelector('meta[name="page-type"]');
		page_type = page_type.content;

		setup.menu();
		setup.slickSliders();
		setup.animations();

		switch(page_type) {
			case 'home':
                setup.home();
                break;
			case 'about':
                setup.about();                
				break;
			case 'destinations':
                setup.destinations();                
				break;
			case 'requestToVisit':
                setup.requestToVisit();                
				break;	
		}
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

		},

		slickSliders: function() {

			$('.gnrl-frm--sldr').slick({
				infinite: true,
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        speed: 1500,
		        autoplay: true,
		        autoplaySpeed: 3000,
		        arrows: true,
		        dots: true,
				responsive: [
				    {
				      breakpoint: 1025,
				      settings: {
				        arrows: false,
				        speed: 500
				      }
				    }
				]
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

			$(function() {
		        $.scrollify({
		        	section : ".scrllfy-frame",
				    interstitialSection : ".ftr-frm",
				    easing: "easeInOutQuad",
				    scrollSpeed: 1100,
				    offset : 0,
			        scrollbars: false,			    
				    setHeights: true,
				    updateHash: false,
				    touchScroll: true,
				});
			});

			$(function() {

				var $window = $(window);
				var width = $window.width();

					if (width < 1025) {
			        
			           $(function() {
			  				$.scrollify.disable();
			  			});

			        } else {

			           $(function() {
			  				$.scrollify.enable();
			  			})
			        }


			})

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

		about: function() {
		    $('.abt-frm2__tabbing-content').first().css('display', 'inline-block');
		    $('.abt-frm2__tabbing-btn').first().addClass('active');

			$('.abt-frm2__tabbing-btn').on('click', function(){
				var id = $(this).data('frame2tab-id');
				
				setTimeout(function(){
					$(window).trigger('resize');
					$('.abt-frm2__tabbing-slider').slick("refresh");
					
					$('.slick-prev').html('<img src="images/left-arrow.png">');
					$('.slick-next').html('<img src="images/right-arrow.png">');

				}, 0.25);

				$('.abt-frm2__tabbing-btn').removeClass('active');
				$(this).addClass('active');
				
				$('.abt-frm2__tabbing-content').fadeOut(0);

			    $('#'+id).fadeIn(300);
		    });

			$('.abt-frm2__tabbing-slider').slick({
				infinite: true,
		        slidesToShow: 3,
		        slidesToScroll: 1,
		        speed: 1000,
		        autoplay: true,
		        autoplaySpeed: 3000,
		        arrows: true,
		        dots: false,
		    });

			$('.slick-prev').html('<img src="images/left-arrow.png">');
			$('.slick-next').html('<img src="images/right-arrow.png">');	

		},

		destinations: function() {
			$('.dstntns-frm1__slider').slick({
				infinite: true,
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        speed: 1000,
		        fade: true,
		        autoplay: false,
		        arrows: false,
		        dots: false,
		        focusOnSelect: false,
		        asNavFor: '.dstntns-frm1__slider-thumbnail'
		    });

			$('.dstntns-frm1__slider-thumbnail').slick({
				infinite: true,
		        slidesToShow: 3,
		        slidesToScroll: 1,
		        speed: 1000,
		        autoplay: false,
		        arrows: false,
		        dots: false,
		        focusOnSelect: true,
		        asNavFor: '.dstntns-frm1__slider'
		    });


		    $('.dstntns-frm1__slider-thumbnail-item').first().addClass('active');

		    $('.dstntns-frm1__slider-thumbnail-item-img').on('click', function(){
		    	$('.dstntns-frm1__slider-thumbnail-item').removeClass('active');
		    	$(this).parent().addClass('active');
		    });	

		},

		requestToVisit: function(){
		    $('.rqst-frm1__step-4-content-checkbox-container').on('click', function(){
		    	$('.rqst-frm1__step-4-content-checkbox-container').removeClass('active');
		    	$(this).addClass('active');
		    });	

		    $('.rqst-frm1__step-4-content-select').on('click', function(){
		    	$('.rqst-frm1__step-4-content-select-option').fadeToggle(200);
		    });		

			var information = $('.rqst-frm1__step-4-content-info-icon');

 			information.hover(function(e) {
				$(this).next().fadeIn(200);
			}, function(e) {
				$(this).next().fadeOut(200);
			});

			$('*').not('.rqst-frm1__step-4-content-info-icon').on('touchstart', function(){ 
	            $(this).next().fadeOut(200);
 			})

		}

	}

}