@extends('web.master')

@section('meta:title', $page->renderMeta('title'))
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section class="hm-frm1 gnrl-frm--sldr__container">
	<div class="gnrl-frm--sldr">
		<div class="gnrl-frm--sldr__item">
			<div class="vertical-parent">
				<div class="vertical-align align-c">
					<h5 class="frm-title l-margin-b clr--white">Discover Vista</h5>
					<a href="" class="frm-btn green">Explore Destination</a>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('http://www.trailadventours.com/dist/images/homepage-first.jpg');"></div>
		</div>
		<div class="gnrl-frm--sldr__item">
			<div class="vertical-parent">
				<div class="vertical-align align-c">
					<h5 class="frm-title l-margin-b clr--white">Digital Visitor Management</h5>
					<a href="" class="frm-btn green">Explore Destination</a>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('http://www.trailadventours.com/dist/images/homepage-first.jpg');"></div>
		</div>
	</div>
</section>
<section class="hm-frm2">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align align-c">
				<p class="frm-header m-margin-b clr--white">About Us</p>
				<h5 class="frm-title l-margin-b clr--white">Visita</h5>
				<div class="hm-frm2__tabbing inlineBlock-parent">
					<p class="hm-frm2__tabbing-btn active">Who we are</p>
					<p class="hm-frm2__tabbing-btn">The Problem</p>
					<p class="hm-frm2__tabbing-btn">Our Solution</p>
				</div>
				<p class="frm-header bold clr--white">A world where nature and tourism thrive togther</p>
				<div class="hm-frm2__tabbing-content frm-description clr--white">
					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="hm-frm3">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<div class="inlineBlock-parent">
					<div class="width--50 align-l">
						<h5 class="frm-title l-margin-b clr--white">Costa</h5>
						<p class="frm-header m-margin-b clr--white bold">Conservation and Sustainable Tourism Alliance</p>
						<div class="frm-description m-margin-b clr--white">
							<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
						</div>
						<div class="inlineBlock-parent">
							<a href="#" class="frm-btn green m-margin-r" data-remodal-target="hm-frm3--modal-1">Discover the Alliance</a>
							<a href="" class="frm-btn orange">Read the Plege</a>
						</div>
					</div
					><div class="width--50 align-c">
						<img src="{{ asset('images/costa-img.png') }}" class="hm-frm3__img">
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- Modal --}}
	<div id="gnrl-rmdl" class="remodal" data-remodal-id="hm-frm3--modal-1">
		<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
			<img src="{{ asset('images/close-button.png') }}" class="gnrl-rmdl__close-btn-img">
		</button>
		<div class="frm-cntnr align-c">
			<h5 class="frm-title l-margin-b clr--green align-l">Costa</h5>
			<div class="frm-description clr--black align-l gnrl-scrll">
				<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
				<ul>
					<li>It is a long established fact</li>
					<li>It is a long established fact</li>
					<li>It is a long established fact</li>
				</ul>
			</div>
		</div>
	</div>
	{{--  --}}

</section>
<section class="hm-frm4">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<div class="inlineBlock-parent">
					<div class="width--50 align-c">
						<img src="{{ asset('images/phone.png') }}" class="hm-frm4__img">
					</div
					><div class="width--50 align-l">
						<h5 class="frm-title l-margin-b clr--white">Vista App</h5>
						<p class="frm-header m-margin-b clr--white bold">A written commitment</p>
						<div class="frm-description m-margin-b clr--white">
							<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
						</div>
						<div class="inlineBlock-parent">
							<a href="#" class="frm-btn green m-margin-r" data-remodal-target="hm-frm4--modal-1">Discover the Alliance</a>
							<a href="" class="frm-btn orange">Read the Plege</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- Modal --}}
	<div id="gnrl-rmdl" class="remodal" data-remodal-id="hm-frm4--modal-1">
		<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
			<img src="{{ asset('images/close-button.png') }}" class="gnrl-rmdl__close-btn-img">
		</button>
		<div class="frm-cntnr align-c">
			<h5 class="frm-title l-margin-b clr--green align-l">Vista App</h5>
			<div class="frm-description m-margin-b clr--black align-l gnrl-scrll">
				<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
				<ul>
					<li>It is a long established fact</li>
					<li>It is a long established fact</li>
					<li>It is a long established fact</li>
				</ul>
			</div>
		</div>
	</div>
	{{--  --}}

</section>
<section class="hm-frm5 gnrl-frm--sldr__container">
	<div class="gnrl-frm--sldr">
		<div class="gnrl-frm--sldr__item">
			<div class="vertical-parent">
				<div class="vertical-align align-c">
					<p class="frm-header m-margin-b clr--white">Destination Partner</p>
					<h5 class="frm-title l-margin-b clr--white">Mt. Pulag</h5>
					<a href="#" class="frm-btn green" data-remodal-target="hm-frm5--modal-1">Explore Destination</a>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('http://www.trailadventours.com/dist/images/homepage-first.jpg');"></div>
		</div>
		<div class="gnrl-frm--sldr__item">
			<div class="vertical-parent">
				<div class="vertical-align align-c">
					<p class="frm-header m-margin-b clr--white">Destination Partner</p>
					<h5 class="frm-title l-margin-b clr--white">Mt. Pulag</h5>
					<a href="#" class="frm-btn green" data-remodal-target="hm-frm5--modal-1">Explore Destination</a>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('http://www.trailadventours.com/dist/images/homepage-first.jpg');"></div>
		</div>
	</div>

	{{-- Modal --}}
	<div id="gnrl-rmdl" class="remodal custom-width" data-remodal-id="hm-frm5--modal-1">
		<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
			<img src="{{ asset('images/close-button.png') }}" class="gnrl-rmdl__close-btn-img">
		</button>
		<div class="frm-cntnr align-c inlineBlock-parent">
			<div class="width--25 align-l">
				<h5 class="frm-title l-margin-b clr--green">Mt. Pulag</h5>
				<div class="gnrl-rmdl__btn-holder">
					<p class="gnrl-rmdl__btn">Icons</p>
					<p class="gnrl-rmdl__btn active">Experiences</p>
					<p class="gnrl-rmdl__btn">Fees</p>
					<p class="gnrl-rmdl__btn">Visitor Policies</p>
					<p class="gnrl-rmdl__btn">Terms & Condtions of Visit Request</p>
				</div>
			</div
			><div class="width--70">
				<div class="frm-description custom-description m-margin-b clr--black align-l gnrl-scrll">
					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
					<ul>
						<li>It is a long established fact</li>
						<li>It is a long established fact</li>
						<li>It is a long established fact</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	{{--  --}}

</section>
<section class="hm-frm6">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<form class="inlineBlock-parent">
					<div class="width--50 align-t m-margin-b">
						<div class="width--95 frm-cntnr align-l">
							<div class="frm-inpt m-margin-b">
								<input type="" name="" placeholder="Full Name">
							</div>
							<div class="frm-inpt m-margin-b">
								<input type="" name="" placeholder="Contact Number">
							</div>
							<div class="frm-inpt m-margin-b">
								<input type="" name="" placeholder="Email Address">
							</div>
						</div>
					</div
					><div class="width--50 align-t m-margin-b">
						<div class="width--95 frm-cntnr align-r">
							<div class="frm-inpt m-margin-b">
								<input type="" name="" placeholder="Purpose">
							</div>
							<div class="frm-inpt m-margin-b">
								<textarea rows="4" placeholder="Message"></textarea>
							</div>
						</div>
					</div>
					<div class="width--100 align-c">
						<button class="frm-btn green">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="frm-bckgrnd size-cover bring-front" style="background-image: url('http://www.trailadventours.com/dist/images/homepage-first.jpg');"></div>
</section>
@endsection