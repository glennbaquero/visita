@extends('web.master')

@section('content')

<section class="hm-frm1 gnrl-frm--sldr__container scrllfy-frame" id="frame-1">
	<div class="gnrl-frm--sldr fade-up__trigger">
		@foreach ($home_banners as $home_banner)
		<div class="gnrl-frm--sldr__item">
			<div class="frm-cntnr align-c width--85">
				<div class="vertical-parent">
					<div class="vertical-align align-c">
						<h5 class="frm-title l-margin-b clr--white hm-frm1-fade-up__item">{{ $home_banner->name }}</h5>
						<a href="{{ $home_banner->link }}" class="frm-btn green js-trigger" data-section="frame-6">{{ $home_banner->link_label }}</a>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('{{ $home_banner->renderImagePath() }}');"></div>
		</div>
		@endforeach
	</div>
</section>
<section class="hm-frm2 scrllfy-frame" id="frame-2">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align align-c">
				<p class="frm-header m-margin-b clr--white">{{ $data['pageItems']['frame_2_header'] }}</p>
				<h5 class="frm-title l-margin-b clr--white">{{ $data['pageItems']['frame_2_title'] }}</h5>
				<div class="hm-frm2-fade-up__item1">
					<div class="hm-frm2__tabbing inlineBlock-parent">
						@foreach ($about_infos as $about_info)
						<p class="hm-frm2__tabbing-btn" data-frame2tab-id="frame2tab-{{ $about_info->id }}">{{ $about_info->name }}</p>
						@endforeach
					</div>
				</div>
				<div class="hm-frm2-fade-up__item2">
					@foreach ($about_infos as $about_info)
					<div class="hm-frm2__tabbing-content gnrl-scrll" id="frame2tab-{{ $about_info->id }}">
						<p class="frm-header bold clr--white">{{ $about_info->label }}</p>
						<div class="frm-description clr--white">
							{!! $about_info->description !!}
						</div>
					</div>
					@endforeach
				</div>

			</div>
		</div>
	</div>
</section>
<section class="hm-frm3 scrllfy-frame hm-frm3-fade-up__trigger" id="frame-3">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<div class="inlineBlock-parent hm-frm3__col-holder">
					<div class="width--50 align-l">
						<h5 class="frm-title l-margin-b clr--white">{{ $data['pageItems']['frame_3_title'] }}</h5>
						<p class="frm-header m-margin-b clr--white bold hm-frm3-fade-up__item">{{ $data['pageItems']['frame_3_header'] }}</p>
						<div class="frm-description m-margin-b clr--white hm-frm3-fade-up__item">
							{!! $data['pageItems']['frame_3_content'] !!}
						</div>
						<div class="inlineBlock-parent hm-frm3-fade-up__item">
							{{-- <a href="#" class="frm-btn green m-margin-r">Discover the Alliance</a> --}}
							<a href="#" class="frm-btn orange" data-remodal-target="hm-frm3--modal-1">{{ $data['pageItems']['frame_3_link_2_label'] }}</a>
						</div>
					</div
					><div class="width--50 align-c">
						<img src="{!! $data['pageItems']['frame_3_image'] !!}" class="hm-frm3__img">
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
			<h5 class="frm-title l-margin-b clr--green align-l">{{ $data['pageItems']['frame_3_modal_title'] }}</h5>
			<div class="frm-description clr--gray align-l gnrl-scrll">
				{!! $data['pageItems']['frame_3_modal_content'] !!}
			</div>
		</div>
	</div>
	{{--  --}}

</section>
<section class="hm-frm4 scrllfy-frame hm-frm4-fade-up__trigger" id="frame-4">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<div class="inlineBlock-parent">
					<div class="width--50 align-c">
						<img src="{!! $data['pageItems']['frame_4_image'] !!}" class="hm-frm4__img">
					</div
					><div class="width--50 align-l">
						<h5 class="frm-title l-margin-b clr--white">{{ $data['pageItems']['frame_4_title'] }}</h5>
						<p class="frm-header m-margin-b clr--white bold hm-frm4-fade-up__item">{{ $data['pageItems']['frame_4_header'] }}</p>
						<div class="frm-description m-margin-b clr--white hm-frm4-fade-up__item">
							{!! $data['pageItems']['frame_4_content'] !!}
						</div>
						<div class="inlineBlock-parent hm-frm4-fade-up__item">
							<a href="#" class="frm-btn green m-margin-r" data-remodal-target="hm-frm4--modal-1">{{ $data['pageItems']['frame_4_link_1_label'] }}</a>
							{{-- <a href="" class="frm-btn orange">Learn More</a> --}}
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
			<h5 class="frm-title l-margin-b clr--green align-l">{{ $data['pageItems']['frame_4_modal_title'] }}</h5>
			<div class="frm-description m-margin-b clr--gray align-l gnrl-scrll">
				{!! $data['pageItems']['frame_4_modal_content'] !!}
			</div>
		</div>
	</div>
	{{--  --}}

</section>
<section class="hm-frm5 gnrl-frm--sldr__container scrllfy-frame" id="frame-5">
	<div class="gnrl-frm--sldr">
		{{-- Loop --}}
		<div class="gnrl-frm--sldr__item">
			<div class="frm-cntnr align-c width--85">
				<div class="vertical-parent">
					<div class="vertical-align align-c">
						<p class="frm-header m-margin-b clr--white">Destination Partner</p>
						<h5 class="frm-title l-margin-b clr--white hm-frm5-fade-up__item">Mt. Pulag</h5>
						<a href="#" class="frm-btn green" data-remodal-target="hm-frm5--modal-1">Explore Destination</a>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('http://www.trailadventours.com/dist/images/homepage-first.jpg');"></div>
		</div>
		{{--  --}}
	</div>

	{{-- Modal --}}
	<div id="gnrl-rmdl" class="remodal custom-width" data-remodal-id="hm-frm5--modal-1">
		<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
			<img src="{{ asset('images/close-button.png') }}" class="gnrl-rmdl__close-btn-img">
		</button>
		<div class="frm-cntnr align-c inlineBlock-parent">
			<div class="width--25 align-l gnrl-rmdl__col">
				<h5 class="frm-title l-margin-b clr--green">Mt. Pulag</h5>
				<div class="gnrl-rmdl__btn-holder">
					<p class="gnrl-rmdl__btn">Icons</p>
					<p class="gnrl-rmdl__btn active">Experiences</p>
					<p class="gnrl-rmdl__btn">Fees</p>
					<p class="gnrl-rmdl__btn">Visitor Policies</p>
					<p class="gnrl-rmdl__btn">Terms & Condtions of Visit Request</p>
				</div>
			</div
			><div class="width--70 gnrl-rmdl__col">
				<div class="frm-description custom-description m-margin-b clr--gray align-l gnrl-scrll">
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
<section class="hm-frm6 scrllfy-frame" id="frame-6">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<user-inquiry
		        	submit-url="{{ route('web.user.inquiry') }}"
		        ></user-inquiry>

			</div>
		</div>
	</div>
	<div class="frm-bckgrnd size-cover bring-front" style="background-image: url('{!! $data['pageItems']['frame_6_background_image'] !!}');"></div>
</section>
@endsection