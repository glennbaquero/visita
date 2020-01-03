@extends('web.master')

{{-- @section('meta:title', $page->renderMeta('title'))
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description')) --}}

@section('content')

<section class="lgn-frm1">
	<div class="inlineBlock-parent">
		<div class="lgn-frm1__col width--55">
			<div class="vertical-parent">
				<div class="vertical-align align-b">
					<div class="margin-a width--85">
						<p class="lgn-frm1__col-header frm-header m-margin-b clr--white">Welcome</p>
						<h5 class="lgn-frm1__col-label frm-title clr--white">Visita</h5>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('https://cdn.getyourguide.com/img/tour_img-1735510-146.jpg');"></div>
		</div
		><div class="lgn-frm1__col width--45">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="margin-a width--80">
						<div class="l-margin-b align-c">
							<p class="lgn-frm1__form-title frm-header bold clr--orange">Forgot Password?</p>
						</div>
						<div class="frm-description clr--gray m-margin-b">
							<p>Enter your email address below, and we'll send you an email allowing you to reset it.</p>
						</div>
						<form method="POST" action="{{ route('web.password.email') }}">
						    @csrf
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="" name="email" placeholder="Email Address" value="{{ old('email') }}">
								<p class="error-show">{{ $errors->has('email') ? $errors->first('email') : '' }}</p>
							</div>
							
							<div class="width--100 align-c">
								<button class="frm-btn green m-margin-b">Reset my password</button>
							</div>
						</form>
						<div class="lgn-frm1__sign-up-holder width--100 inlineBlock-parent">
							<div class="frm-description clr--gray">
								<p>Go back to login?</p>
							</div>
							<a href="login" class="lgn-frm1__sign-up bold">Click here.</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
