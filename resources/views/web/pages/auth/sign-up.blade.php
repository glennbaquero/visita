@extends('web.master')

@section('meta:title', 'Sign Up')
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
			<form method="POST" action="{{ route('web.register') }}">
				@csrf
				<div class="vertical-parent">
					<div class="vertical-align">
						<div class="margin-a width--80">
							<div class="l-margin-b m-margin-t align-c">
								<p class="lgn-frm1__form-title frm-header bold clr--orange">Sign Up</p>
							</div>
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Firstname" >
								<p class="error-show">{{ $errors->has('first_name') ? $errors->first('first_name') : '' }}</p>
							</div>
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Lastname" >
								<p class="error-show">{{ $errors->has('last_name') ? $errors->first('last_name') : '' }}</p>
							</div>
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" >
								<p class="error-show">{{ $errors->has('email') ? $errors->first('email') : '' }}</p>
							</div>
							<div class="inlineBlock-parent">
								<div class="width--50">
									<div class="width--95">
										<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
											<input type="text" name="username" value="{{ old('username') }}" placeholder="Username" >
											<p class="error-show">{{ $errors->has('username') ? $errors->first('username') : '' }}</p>
										</div>
									</div>
								</div
								><div class="width--50">
									<div class="width--95 margin-l-a inlineBlock-parent">
										<div class="width--30">
											<div class="width--90">
												<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
													<input type="text" name="" value="+63" disabled>
												</div>
											</div>
										</div
										><div class="width--70">
											<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
												<input type="number" name="contact_no" value="{{ old('contact_no') }}" placeholder="">
												<p class="error-show">{{ $errors->has('contact_no') ? $errors->first('contact_no') : '' }}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="password" name="password" placeholder="Password">
								<p class="error-show">{{ $errors->has('password') ? $errors->first('password') : '' }}</p>
							</div>
							<div class="lgn-frm1__inpt frm-inpt align-c m-margin-b">
								<input type="password" name="password_confirmation" placeholder="Re-type Password">
							</div>
							<div class="width--100 align-c">
								<button class="frm-btn green m-margin-b">Sign Up</button>
							</div>
							<div class="lgn-frm1__sign-up-holder width--100 inlineBlock-parent">
								<div class="frm-description clr--gray">
									<p>Already have an account?</p>
								</div>
								<a href="sign-in" class="lgn-frm1__sign-up bold">Sign In</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

@endsection
