@extends('web.master')

{{-- @section('meta:title', $page->renderMeta('title'))
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description')) --}}

@section('content')

<section class="fqs-frm1">
	<div class="frm-cntnr align-c width--85">
		<p class="frm-header m-margin-b clr--orange">Frequently Asked Questions</p>
		<h5 class="frm-title l-margin-b clr--green">How can we help you?</h5>

		<div class="inlineBlock-parent l-margin-b">
			
			<div class="fqs-frm1__selection active">
				<div class="vertical-parent">
					<div class="vertical-align">
						<div class="width--85 margin-a align-c">
							<div class="inlineBlock-parent">
								<img class="fqs-frm1__selection-icon s-margin-r" src="{{ asset('images/visitor-icon.png') }}">
								<h5 class="frm-title x-small m-margin-b clr--green">Visitors</h5>
								<div class="frm-description clr--gray">
									<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="fqs-frm1__selection">
				<div class="vertical-parent">
					<div class="vertical-align">
						<div class="width--85 margin-a align-c">
							<div class="inlineBlock-parent">
								<img class="fqs-frm1__selection-icon s-margin-r" src="{{ asset('images/visitor-icon.png') }}">
								<h5 class="frm-title x-small m-margin-b clr--green">Destination Managers</h5>
								<div class="frm-description clr--gray">
									<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</div>

		<div class="fqs-frm1__cards align-l">
			<div class="fqs-frm1__cards-header">
				<div class="width--90 margin-a inlineBlock-parent">
					<div class="width--95">
						<p class="frm-header bold clr--gray">How do I request for a visit:</p>
					</div
					><div class="width--5 align-r">
						<img class="fqs-frm1__cards-icon" src="{{ asset('images/add-icon.png') }}">
						{{-- <img class="fqs-frm1__cards-icon" src="{{ asset('images/substract-icon.png') }}"> --}}
					</div>
				</div>
			</div>
			<div class="fqs-frm1__cards-content">
				<div class="width--90 margin-a">
					<div class="frm-description clr--gray">
						<p><strong>About the Destination</strong></p>
						<p>The Mount Pulag National Park, famous for its “sea of clouds” and is referred to as the “stairway to heaven” in local folklore is the highest mountain in the north and the third highest in the country at 2, 922 meters above sea level.</p>
						<p><strong>Flora and Fauna</strong></p>
						<p>Recognized by scientists because of its ecological value, one could be mesmerized by the various species, both flora and fauna, that could be found in the area including thirty three (33) bird species and several threatened mammals such as the Philippine Deer, Giant Bushy-tailed Cloud Rat (“bowet”) and the Long-Haired Fruit Bat. Mt. Pulag is also the only place that hosts the four (4) cloud rat species. It is also home to the endemic Dwarf Bamboo (Yushania niitakayamensis) and the Benguet Pine (Pinus insularis) which dominates the areas of Luzon tropical pine forests found on the mountainside.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="fqs-frm1__cards align-l">
			<div class="fqs-frm1__cards-header">
				<div class="width--90 margin-a inlineBlock-parent">
					<div class="width--95">
						<p class="frm-header bold clr--gray">How do I request for a visit:</p>
					</div
					><div class="width--5 align-r">
						<img class="fqs-frm1__cards-icon" src="{{ asset('images/add-icon.png') }}">
						{{-- <img class="fqs-frm1__cards-icon" src="{{ asset('images/substract-icon.png') }}"> --}}
					</div>
				</div>
			</div>
			<div class="fqs-frm1__cards-content">
				<div class="width--90 margin-a">
					<div class="frm-description clr--gray">
						<p><strong>About the Destination</strong></p>
						<p>The Mount Pulag National Park, famous for its “sea of clouds” and is referred to as the “stairway to heaven” in local folklore is the highest mountain in the north and the third highest in the country at 2, 922 meters above sea level.</p>
						<p><strong>Flora and Fauna</strong></p>
						<p>Recognized by scientists because of its ecological value, one could be mesmerized by the various species, both flora and fauna, that could be found in the area including thirty three (33) bird species and several threatened mammals such as the Philippine Deer, Giant Bushy-tailed Cloud Rat (“bowet”) and the Long-Haired Fruit Bat. Mt. Pulag is also the only place that hosts the four (4) cloud rat species. It is also home to the endemic Dwarf Bamboo (Yushania niitakayamensis) and the Benguet Pine (Pinus insularis) which dominates the areas of Luzon tropical pine forests found on the mountainside.</p>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>

@endsection