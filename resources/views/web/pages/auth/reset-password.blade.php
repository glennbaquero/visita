@extends('web.master')

@section('meta:title', 'Reset Password')
@section('meta:description', 'Reset Password')
@section('meta:keywords', 'Reset Password')
@section('og:image', '')
@section('og:title', '')
@section('og:description', '')

@section('content')

<section class="lgn-frm1">
	<div class="inlineBlock-parent">
		<div class="lgn-frm1__col width--55">
			<div class="vertical-parent">
				<div class="vertical-align align-b">
					<div class="margin-a width--85">
						<p class="lgn-frm1__col-header frm-header s-margin-b clr--white">{{ $frame_1_title }}</p>
						<h5 class="lgn-frm1__col-label frm-title clr--white">{{ $frame_1_label }}</h5>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('{!! $frame_1_background_image !!}');"></div>
		</div
		><div class="lgn-frm1__col width--45">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="margin-a width--80">
						<div class="l-margin-b align-c">
							<p class="lgn-frm1__form-title frm-header bold clr--orange">Reset Password</p>
						</div>
						<div class="frm-description clr--gray m-margin-b">
							<p>Enter your new password below.</p>
						</div>
						<form method="POST" action="{{ route('web.password.change') }}">
						    @csrf
						    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
						    <input type="hidden" name="token" value="{{ $token }}">
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="password" name="password" placeholder="New Password">
								<p class="error-show">{{ $errors->has('password') ? $errors->first('password') : '' }}</p>
							</div>
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="password" name="password_confirmation" placeholder="Re-type Password">
							</div>
							
							<div class="width--100 align-c">
								<button class="frm-btn green m-margin-b">Reset Password</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
