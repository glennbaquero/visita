@extends('web.master')

@section('meta:title', 'Dashboard')
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

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

				<a href="{{ route('web.logout') }}" class="dshbrd-frm1__btn-list inlineBlock-parent">
					<img src="{{ asset('images/log-out-icon.png') }}" class="dshbrd-frm1__btn-icon">
					<p class="dshbrd-frm1__btn">Log Out</p>
				</a>

			</div>
		</div
		><div class="dshbrd-frm1__content-holder width--75 align-t">
			<div class="width--90 margin-a align-l">
				<h5 class="frm-title x-small l-margin-b clr--orange">Hello {{ auth()->user()->first_name }}!</h5>

				<reservation-list-card
					fetch-url="{{ route('web.reservations.show') }}"
					upload-deposit-slip-url="{{ route('web.upload.deposit') }}"
					process-payment-url="{{ route('web.book.generate-form') }}"
				></reservation-list-card>

			</div>
		</div>
	</div>
</section>

@endsection