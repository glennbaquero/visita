@extends('web.master')

@section('meta:title', 'Sign In')
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
						<p class="lgn-frm1__col-header frm-header s-margin-b clr--white">Welcome</p>
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
							<p class="lgn-frm1__form-title frm-header bold clr--orange">Sign In</p>
						</div>
						<ul>
						@foreach($errors->all() as $error)
						    <li><p class="">{{$error}}</p></li>
						@endforeach
						</ul>
						<form action="{{ route('web.login') }}" method="POST">
							@csrf
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
							</div>
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="password" name="password" placeholder="Password">
							</div>
							<div class="width--100 m-margin-b">
								<a href="forgot-password" class="lgn-frm1__frgt-psswrd">Forgot Password?</a>
							</div>
							<div class="width--100 align-c">
								<button class="frm-btn green m-margin-b">Sign In</button>
							</div>
						</form>
						<div class="frm-description clr--light-gray align-c m-margin-b">
							<p>or</p>
						</div>
						<div class="inlineBlock-parent align-c">
							<button class="frm-btn lgn-frm1__login-scl-btn facebook m-margin-b"><img src="{{ asset('images/facebook-icon.png') }}">Facebook</button>
							<button class="frm-btn lgn-frm1__login-scl-btn google m-margin-b"><img src="{{ asset('images/google-plus-icon.png') }}">Google</button>
						</div>
						<div class="lgn-frm1__sign-up-holder width--100 inlineBlock-parent">
							<div class="frm-description clr--gray">
								<p>Don't have account?</p>
							</div>
							<a href="sign-up" class="lgn-frm1__sign-up bold">Sign Up</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
