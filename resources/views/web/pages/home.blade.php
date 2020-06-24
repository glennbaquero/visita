@extends('web.master')

@section('meta:title', 'Home')
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section id="frame1" class="hm-frm1 gnrl-frm--sldr__container scrllfy-frame">
	<div class="gnrl-frm--sldr gnrl-frm--sldr1">
		@foreach ($home_banners as $home_banner)
		<div class="gnrl-frm--sldr__item">
			<div class="frm-cntnr align-c width--85">
				<div class="vertical-parent">
					<div class="vertical-align align-c">
						<h5 class="frm-title l-margin-b clr--white gnrl-frm--sldr1__animation-title">{{ $home_banner->name }}</h5>
						<div class="gnrl-frm--sldr1__animation-button">
							<a href="{{ $home_banner->link }}" class="frm-btn green">{{ $home_banner->link_label }}</a>
						</div>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('{{ $home_banner->renderImagePath() }}');"></div>
		</div>
		@endforeach
	</div>
</section>
<section id="frame2" class="hm-frm2 scrllfy-frame">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align align-c">
				<p class="frm-header m-margin-b clr--white">{{ $pageItems['frame_2_header'] }}</p>
				<h5 class="frm-title l-margin-b clr--white">{{ $pageItems['frame_2_title'] }}</h5>
				<div class="hm-frm2-fade-up__animation">
					<div class="hm-frm2__tabbing inlineBlock-parent">
						@foreach ($about_infos as $about_info)
						<p class="hm-frm2__tabbing-btn" data-frame2tab-id="frame2tab-{{ $about_info->id }}">{{ $about_info->name }}</p>
						@endforeach
					</div>

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
<section id="frame3" class="hm-frm3 scrllfy-frame">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<div class="inlineBlock-parent hm-frm3__col-holder hm-frm3-fade-up__animation">
					<div class="width--50 align-l">
						<h5 class="frm-title l-margin-b clr--white">{{ $pageItems['frame_3_title'] }}</h5>
						<p class="hm-frm3-fade-up__animation-content frm-header m-margin-b clr--white bold hm-frm3-fade-up__item">{{ $pageItems['frame_3_header'] }}</p>
						<div class="hm-frm3-fade-up__animation-content frm-description m-margin-b clr--white hm-frm3-fade-up__item">
							{!! $pageItems['frame_3_content'] !!}
						</div>
						<div class="inlineBlock-parent hm-frm3-fade-up__animation-button">
							{{-- <a href="#" class="frm-btn green m-margin-r">Discover the Alliance</a> --}}
							<a href="#" class="frm-btn orange" data-remodal-target="hm-frm3--modal-1">{{ $pageItems['frame_3_link_2_label'] }}</a>
						</div>
					</div
					><div class="width--50 align-c">
						<img src="{!! $pageItems['frame_3_image'] !!}" class="hm-frm3__img hm-frm3-fade-up__animation-img">
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
			<h5 class="frm-title l-margin-b clr--green align-l">{{ $pageItems['frame_3_modal_title'] }}</h5>
			<div class="frm-description clr--gray align-l gnrl-scrll">
				{!! $pageItems['frame_3_modal_content'] !!}
			</div>
		</div>
	</div>
	{{--  --}}

</section>
<section id="frame4" class="hm-frm4 scrllfy-frame">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<div class="inlineBlock-parent hm-frm4-fade-up__animation">
					<div class="width--50 align-c">
						<img src="{!! $pageItems['frame_4_image'] !!}" class="hm-frm4__img hm-frm4-fade-up__animation-img">
					</div
					><div class="width--50 align-l">
						<h5 class="frm-title l-margin-b clr--white">{{ $pageItems['frame_4_title'] }}</h5>
						<p class="hm-frm4-fade-up__animation-content frm-header m-margin-b clr--white bold">{{ $pageItems['frame_4_header'] }}</p>
						<div class="hm-frm4-fade-up__animation-content frm-description m-margin-b clr--white hm-frm4-fade-up__item">
							{!! $pageItems['frame_4_content'] !!}
						</div>
						<div class="hm-frm4-fade-up__animation-button inlineBlock-parent">
							<a href="#" class="frm-btn green m-margin-r" data-remodal-target="hm-frm4--modal-1">{{ $pageItems['frame_4_link_1_label'] }}</a>
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
			<h5 class="frm-title l-margin-b clr--green align-l">{{ $pageItems['frame_4_modal_title'] }}</h5>
			<div class="frm-description m-margin-b clr--gray align-l gnrl-scrll">
				{!! $pageItems['frame_4_modal_content'] !!}
			</div>
		</div>
	</div>
	{{--  --}}

</section>
<section id="frame5" class="hm-frm5 gnrl-frm--sldr__container scrllfy-frame">
	<user-destination
		{{-- fetch-url="{{ route('web.fetch.destination') }}" --}}
		:destination="{{ $destination }}"
	></user-destination>
</section>
<section id="frame6" class="hm-frm6 scrllfy-frame">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<user-inquiry
		        	submit-url="{{ route('web.user.inquiry') }}"
		        	fb="{{ $fb->content }}"
		        	twitter="{{ $twitter->content }}"
		        	insta="{{ $insta->content }}"
		        	youtube="{{ $youtube->content }}"
		        ></user-inquiry>
			</div>
		</div>
	</div>
	<div class="frm-bckgrnd size-cover bring-front" style="background-image: url('{!! $pageItems['frame_6_background_image'] !!}');"></div>
</section>
@endsection
