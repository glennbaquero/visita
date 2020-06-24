@extends('web.master')

@section('meta:title', 'Contact Us')
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section class="cntct-frm1 scrllfy-frame">
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
	<div class="frm-bckgrnd size-cover bring-front" style="background-image: url('{!! $pageItems['frame_1_background_image'] !!}');"></div>
</section>

@endsection