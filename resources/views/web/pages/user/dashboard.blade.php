@extends('web.master')

{{-- @section('meta:title', $page->renderMeta('title'))
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description')) --}}

@section('content')

<section class="dshbrd-frm1">
	<div class="frm-cntnr align-c width--100 inlineBlock-parent">
		<div class="dshbrd-frm1__btn-holder width--25 align-t">
			<div class="width--65 margin-a align-l">

				<a href="user/dashboard" class="dshbrd-frm1__btn-list inlineBlock-parent">
					<img src="{{ asset('images/dashboard-icon.png') }}" class="dshbrd-frm1__btn-icon {{ $checker->route->areOnRoutes(['web.dashboard']) }}">
					<p class="dshbrd-frm1__btn {{ $checker->route->areOnRoutes(['web.dashboard']) }}">Dashboard</p>
				</a>

				<a href="{{ route('web.profile') }}#" class="dshbrd-frm1__btn-list inlineBlock-parent">
					<img src="{{ asset('images/profile-icon.png') }}" class="dshbrd-frm1__btn-icon {{ $checker->route->areOnRoutes(['web.profile']) }}">
					<p class="dshbrd-frm1__btn {{ $checker->route->areOnRoutes(['web.profile']) }}">Profile</p>
				</a>

				<a href="#" class="dshbrd-frm1__btn-list inlineBlock-parent">
					<img src="{{ asset('images/log-out-icon.png') }}" class="dshbrd-frm1__btn-icon">
					<p class="dshbrd-frm1__btn">Log Out</p>
				</a>

			</div>
		</div
		><div class="dshbrd-frm1__content-holder width--75 align-t">
			<div class="width--90 margin-a align-l">
				<h5 class="frm-title x-small l-margin-b clr--orange">Hello Jethro!</h5>

				<div class="inlineBlock-parent l-margin-b">
					<div class="width--50">
						<p class="frm-header s-margin-b bold clr--green">Booking History</p>
					</div
					><div class="width--50 align-r inlineBlock-parent">
						<p class="frm-header bold clr--gray s-margin-b s-margin-r">Sort by:</p>
						<div class="frm-inpt frm-inpt__filter">
							<select>
								<option>Date</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="inlineBlock-parent">
					
					<div class="dshbrd-frm1__content-card">
						<div class="width--85 margin-a align-l">

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Destination:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">Mt. Pulag</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Date:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">10/10/2019</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Guest #:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">6 persons</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Status:</p>
								</div
								><div class="width--50">
									<p class="frm-header dshbrd-frm1__content-card-book-status pending">Pending</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Payment Total:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">Php 6,000</p>
								</div>
							</div>

							<div class="align-c">
								<button class="frm-btn green" data-remodal-target="view-info-modal">View More</button>
							</div>

						</div>

					</div
					><div class="dshbrd-frm1__content-card">
						<div class="width--85 margin-a align-l">

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Destination:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">Mt. Pulag</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Date:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">10/10/2019</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Guest #:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">6 persons</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Status:</p>
								</div
								><div class="width--50">
									<p class="frm-header dshbrd-frm1__content-card-book-status confirmed">Confirmed</p>
								</div>
							</div>

							<div class="inlineBlock-parent m-margin-b">
								<div class="width--50">
									<p class="frm-header bold clr--gray">Payment Total:</p>
								</div
								><div class="width--50">
									<p class="frm-header clr--gray">Php 6,000</p>
								</div>
							</div>

							<div class="align-c">
								<button class="frm-btn green" data-remodal-target="view-info-modal">View More</button>
							</div>

						</div>

					</div
					>
				</div>

				{{-- Modal --}}
				<div id="gnrl-rmdl" class="remodal" data-remodal-id="view-info-modal">
					<button data-remodal-action="close" class="gnrl-rmdl__close-btn">
						<img src="{{ asset('images/close-button.png') }}" class="gnrl-rmdl__close-btn-img">
					</button>
					<div class="width--100 m-margin-t align-l">
						
						<div class="inlineBlock-parent">
							<p class="frm-header bold clr--gray s-margin-r">Destination:</p>
							<p class="frm-header clr--gray">Mt. Pulag</p>
						</div>

						<div class="inlineBlock-parent">
							<p class="frm-header bold clr--gray s-margin-r">Date:</p>
							<p class="frm-header clr--gray">10/10/2020</p>
						</div>

						<div class="inlineBlock-parent">
							<p class="frm-header bold clr--gray s-margin-r">Guest #:</p>
							<p class="frm-header clr--gray">6 persons</p>
						</div>

						<div class="inlineBlock-parent">
							<p class="frm-header bold clr--gray s-margin-r">Status:</p>
							<p class="frm-header bold clr--green">Confirmed</p>
						</div>

						<div class="inlineBlock-parent">
							<p class="frm-header bold clr--gray s-margin-r">Payment Total:</p>
							<p class="frm-header clr--gray">Php 6,000</p>
						</div>

					</div>
				</div>	
				{{--  --}}

			</div>
		</div>
	</div>
</section>

@endsection