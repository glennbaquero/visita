<header class="hdr-frm 
	{{ $checker->route->areOnRoutes(['web.about-us','web.destinations','web.destinations-info','web.faqs','web.contact-us','web.login','web.sign-up','web.forgot-password','web.reset-password','web.request-to-visit','web.dashboard','web.profile','web.privacy-policy']) }}
">
	<div class="frm-cntnr align-c width--90">
		<div class="inlineBlock-parent">
			<div class="hdr-frm__nav-col">
				<a href="#home">
					<img src="{{ asset('images/visita-logo.png') }}" class="hdr-frm__nav-logo">
				</a>
			</div
			><div class="hdr-frm__nav-col mbl-hdr-frm__nav-col">
				<a href="about-us" class="hdr-frm__nav-link {{ $checker->route->areOnRoutes(['web.about-us']) }}">About Us</a>
			</div
			><div class="hdr-frm__nav-col mbl-hdr-frm__nav-col">
				<a href="destinations" class="hdr-frm__nav-link {{ $checker->route->areOnRoutes(['web.destinations','web.destinations-info']) }}">Destinations</a>
			</div
			><div class="hdr-frm__nav-col mbl-hdr-frm__nav-col">
				<a href="faqs" class="hdr-frm__nav-link {{ $checker->route->areOnRoutes(['web.faqs']) }}">FAQs</a>
			</div
			><div class="hdr-frm__nav-col mbl-hdr-frm__nav-col">
				<a href="contact-us" class="hdr-frm__nav-link {{ $checker->route->areOnRoutes(['web.contact-us']) }}">Contact Us</a>
			</div
			><div class="hdr-frm__nav-col mbl-hdr-frm__nav-col inlineBlock-parent">
				<img class="hdr-frm__nav-link-img" src="{{ asset('images/user-icon.png') }}">
				@if(auth()->check()) 
				<a href="sign-in" class="hdr-frm__nav-link {{ $checker->route->areOnRoutes(['web.sign-in','web.sign-up','web.forgot-password','web.reset-password']) }}">{{ auth()->user()->renderName() }}</a>
				@else
				<a href="sign-in" class="hdr-frm__nav-link {{ $checker->route->areOnRoutes(['web.sign-in','web.sign-up','web.forgot-password','web.reset-password']) }}">Log In {{ auth()->user() }}</a>
				@endif
				{{-- Dashboard --}}
				{{-- <a href="" class="hdr-frm__nav-link {{ $checker->route->areOnRoutes(['web.login']) }}">Jethro</a> --}}
			</div
			><div class="hdr-frm__nav-col">
				<a href="request-to-visit" class="frm-btn green">REQUEST A VISIT</a>
			</div>
		</div>
		<div class="mbl-hdr-frm__nav-holder">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="mbl-hdr-frm__nav"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="mbl-hdr-frm__nav-links-holder">
		<div class="frm-cntnr align-c width--85">
			<div class="vertical-parent">
				<div class="vertical-align">
					<img src="{{ asset('images/close-button.png') }}" class="mbl-hdr-frm__link-holder-btn">
					<a href="#home" class="js-trigger" data-section="frame-1">
						<img src="{{ asset('images/visita-logo.png') }}" class="mbl-hdr-frm__nav-logo">
					</a>
					<a href="#about-us" class="mbl-hdr-frm__nav-link js-trigger" data-section="frame-2">About Us</a>
					<a href="#alliance" class="mbl-hdr-frm__nav-link js-trigger" data-section="frame-3">Alliance</a>
					<a href="#visita-app" class="mbl-hdr-frm__nav-link js-trigger" data-section="frame-4">Visita App</a>
					<a href="#destinations" class="mbl-hdr-frm__nav-link js-trigger" data-section="frame-5">Destinations</a>
					<a href="#contact-us" class="mbl-hdr-frm__nav-link js-trigger" data-section="frame-6">Contact Us</a>
				</div>
			</div>		
		</div>
	</div>

</header>