@extends('web.master')

@section('meta:title', 'FAQ')
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section class="fqs-frm1">
	<div class="frm-cntnr align-c width--85">
		<p class="frm-header m-margin-b clr--orange">Frequently Asked Questions</p>
		<h5 class="frm-title l-margin-b clr--green">How can we help you?</h5>

		<div class="inlineBlock-parent l-margin-b">
			
			<div class="fqs-frm1__selection" data-tab-id="tab-1">
				<div class="vertical-parent">
					<div class="vertical-align">
						<div class="width--85 margin-a align-c">
							<div class="inlineBlock-parent">
								<img class="fqs-frm1__selection-icon s-margin-r" src="{{ asset('images/visitor-icon.png') }}">
								<h5 class="frm-title x-small m-margin-b clr--green">Visitors</h5>
								<div class="frm-description clr--gray">
									{!! $pageItems['faq_visitor_description'] !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="fqs-frm1__selection" data-tab-id="tab-2">
				<div class="vertical-parent">
					<div class="vertical-align">
						<div class="width--85 margin-a align-c">
							<div class="inlineBlock-parent">
								<img class="fqs-frm1__selection-icon s-margin-r" src="{{ asset('images/visitor-icon.png') }}">
								<h5 class="frm-title x-small m-margin-b clr--green">Destination Managers</h5>
								<div class="frm-description clr--gray">
									{!! $pageItems['faq_dm_description'] !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</div>

		<div class="fqs-frm1__cards-holder" id="tab-1">
			@foreach($visitors as $visitor)
			<div class="fqs-frm1__cards align-l">
				<div class="fqs-frm1__cards-header">
					<div class="width--90 margin-a inlineBlock-parent">
						<div class="width--95">
							<p class="frm-header bold clr--gray">{{ $visitor->question }}</p>
						</div
						><div class="width--5 align-r">
							<div class="fqs-frm1__cards-icon"></div>
						</div>
					</div>
				</div>
				<div class="fqs-frm1__cards-content">
					<div class="width--90 margin-a">
						<div class="frm-description clr--gray">
							{!! $visitor->answer !!}
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>	

		<div class="fqs-frm1__cards-holder" id="tab-2">
			@foreach($managers as $manager)
			<div class="fqs-frm1__cards align-l">
				<div class="fqs-frm1__cards-header">
					<div class="width--90 margin-a inlineBlock-parent">
						<div class="width--95">
							<p class="frm-header bold clr--gray">{{ $manager->question }}</p>
						</div
						><div class="width--5 align-r">
							<div class="fqs-frm1__cards-icon"></div>
						</div>
					</div>
				</div>
				<div class="fqs-frm1__cards-content">
					<div class="width--90 margin-a">
						<div class="frm-description clr--gray">
							{!! $manager->answer !!}
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>	

	</div>
</section>

@endsection