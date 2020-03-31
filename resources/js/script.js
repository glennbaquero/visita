$(document).ready(function() {
	app.init();
});

var app = {

	init: function() {
		var setup = this.setup;

		let page_type = document.head.querySelector('meta[name="page-type"]');
		page_type = page_type.content;

		setup.menu();
		setup.loading();
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
			case 'faqs':
                setup.faqs();                
				break;
			case 'login':
                setup.login();                
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

			$(".cntct-frm__number input[name='contact_number']").on("focusin", function(){

				if($(this).val() != '') {
					$(this).parent().addClass('active');
				} else {
					$(this).parent().removeClass('active');
					$(this).parent().toggleClass('focus');
				}
			});

			$(".cntct-frm__number input[name='contact_number']").on("focusout", function(){

				if($(this).val() != '') {
					$(this).parent().addClass('active');
				} else {
					$(this).parent().removeClass('active');
					$(this).parent().toggleClass('focus');
				}
			});

		},

		loading: function() {
			$(document).ready(function() {
				$('.ldng-scrn').fadeOut(500);
				$('body').removeClass('ovrflw-hddn');
			});
		},

		slickSliders: function() {

			var controller = new ScrollMagic.Controller();

			$('.gnrl-frm--sldr').slick({
				infinite: true,
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        fade: true,
		        speed: 1000,
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

			$('.gnrl-frm--sldr1').on('beforeChange', function(event, slick, currentSlide, nextSlide){
				var tl = new TimelineMax()
				.fromTo(
        			$('.gnrl-frm--sldr1__animation-title'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=.35"
	        	).fromTo(
        			$('.gnrl-frm--sldr1__animation-button'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	);
			});

			$('.gnrl-frm--sldr2').on('beforeChange', function(event, slick, currentSlide, nextSlide){
				var tl = new TimelineMax()
				.fromTo(
        			$('.gnrl-frm--sldr2__animation-title'), 
        			.7,
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=.35"
	        	).fromTo(
        			$('.gnrl-frm--sldr2__animation-button'), 
        			.7,
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	);
			});

			$('.slick-prev').html('<img src="images/left-arrow.png">');
			$('.slick-next').html('<img src="images/right-arrow.png">');


		},

		animations: function() {

			var controller = new ScrollMagic.Controller();

			/*
			* Home
			*/
			$('.hm-frm2-fade-up__animation').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$('.hm-frm2__tabbing'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone}
	        	).fromTo(
        			$('.hm-frm2__tabbing-content'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.7,
	        		reverse:false,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			$('.hm-frm3-fade-up__animation').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$('.hm-frm3-fade-up__animation-content'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
	        	).fromTo(
        			$('.hm-frm3-fade-up__animation-button'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	).fromTo(
        			$('.hm-frm3-fade-up__animation-img'), 
        			.7, 
        			{opacity:0, x: '50px', ease:Power4.easeIn}, 
        			{opacity:1, x: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.7,
	        		reverse:false,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			$('.hm-frm4-fade-up__animation').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$('.hm-frm4-fade-up__animation-content'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
	        	).fromTo(
        			$('.hm-frm4-fade-up__animation-button'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	).fromTo(
        			$('.hm-frm4-fade-up__animation-img'), 
        			.7, 
        			{opacity:0, x: '-50px', ease:Power4.easeIn}, 
        			{opacity:1, x: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.7,
	        		reverse:false,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			/*
			* About
			*/
			$('.abt-frm1-fade-up__animation').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$('.abt-frm1-fade-up__animation-title'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone}
	        	).fromTo(
        			$('.abt-frm1-fade-up__animation-description'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.7,
	        		reverse:false,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			$('.abt-frm2-fade-up__animation').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$('.abt-frm2-fade-up__animation-content'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=.35"
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: .8,
	        		reverse:false,
	        	})
	        	.setTween(tl)
	        	.addTo(controller);

        	});

			$('.abt-frm3-fade-up__animation').each(function() {
	            var tl = new TimelineMax({delay:0, repeat:0, repeatDelay:0});
	            tl.staggerFrom('.abt-frm3-fade-up__animation-title', 1, { opacity: 0, y: '50px', ease:Power4.easeIn }, 0.25,)
	              .staggerTo('.abt-frm3-fade-up__animation-title', 1, { opacity: 1, y: '0px', ease:Power4.easeNone }, 0.25,)

	            var fadeScene = new ScrollMagic.Scene({
	                triggerElement: this,
	                triggerHook: .7,
	                reverse:false,
	            })
	            .setTween(tl)
	            .addTo(controller);
        	});

			$('.cntct-frm__animation').each(function() {
				var tl = new TimelineMax()
				.fromTo(
        			$('.cntct-frm__animation-form'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone}
	        	).fromTo(
        			$('.cntct-frm__animation-button'), 
        			.7, 
        			{opacity:0, y: '50px', ease:Power4.easeIn}, 
        			{opacity:1, y: '0px', ease:Power4.easeNone},
        			"=-.35"
	        	);

        		var scene = new ScrollMagic.Scene({
	        		triggerElement: this,
	        		triggerHook: 0.7,
	        		reverse:false,
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
				    scrollSpeed: 1000,
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
				responsive: [
				    {
				      breakpoint: 1025,
				      settings: {
				      	slidesToShow: 1,
				      	dots: true,
				        arrows: false,
				        speed: 500
				      }
				    }
				]
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
		        asNavFor: '.dstntns-frm1__slider-thumbnail',
				responsive: [
				    {
				      breakpoint: 1025,
				      settings: {
				        speed: 500,
				        dots: true
				      }
				    }
				]
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
		        asNavFor: '.dstntns-frm1__slider',
				responsive: [
				    {
				      breakpoint: 1025,
				      settings: {
				      	slidesToShow: 1,
				        arrows: true,
				        speed: 500
				      }
				    }
				]
		    });


		    $('.dstntns-frm1__slider-thumbnail-item[data-slick-index=0]').addClass('active');

		    $('.dstntns-frm1__slider-thumbnail-item-img').on('click', function(){
		    	$('.dstntns-frm1__slider-thumbnail-item').removeClass('active');
		    	$(this).parent().addClass('active');
		    });	


			$('.slick-prev').html('<img src="images/left-arrow.png">');
			$('.slick-next').html('<img src="images/right-arrow.png">');

		},

		faqs: function() {

			$('.fqs-frm1__selection').first().addClass('active');
			$('.fqs-frm1__cards-holder').first().show();
		    
		    $('.fqs-frm1__selection').on('click', function(){

				var id = $(this).data('tab-id');

		    	$('.fqs-frm1__selection').removeClass('active');
		    	$(this).addClass('active');

				$('.fqs-frm1__cards-holder').fadeOut(0);

			    $('#'+id).fadeIn(300);
		    });	

		    $('.fqs-frm1__cards').on('click', function(){
				let selected_content_icon = $(this).find('.fqs-frm1__cards-icon');
				selected_content_icon.toggleClass('show');

				let selected_content = $(this).find('.fqs-frm1__cards-content');

				selected_content.slideToggle(300);

				// Close all open content except selected
				$('.fqs-frm1__cards-content').not(selected_content).slideUp(300);
				$('.fqs-frm1__cards-icon').not(selected_content_icon).removeClass('show');

		    });		
		},

		requestToVisit: function(){
		  
		},

		login: function() {
			$('.hdr-frm').addClass('active');
		}

	}
}

/*
 * @ IF PAGE WAS RELOAD ON THE TOP OF THE PAGE.
 */
window.onbeforeunload = function () {
  window.scrollTo(0, 0);
}
