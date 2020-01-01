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

				<a href="user/profile" class="dshbrd-frm1__btn-list inlineBlock-parent">
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
				<p class="frm-header l-margin-b bold clr--green">Personal Information</p>

				<div class="inlineBlock-parent">
					
					<div class="width--33 m-margin-b">
						<div class="width--95">
							<p class="frm-header s-margin-b bold clr--gray">First Name</p>
		 					<div class="frm-inpt">
		                        <input type="text" name="name">
		                    </div>
	                	</div>
					</div
					><div class="width--33 m-margin-b">
						<div class="width--95 margin-a">
							<p class="frm-header s-margin-b bold clr--gray">Middle Name</p>
		 					<div class="frm-inpt">
		                        <input type="text" name="name">
		                    </div>
		                </div>
					</div
					><div class="width--33 m-margin-b">
						<div class="width--95 margin-l-a">
							<p class="frm-header s-margin-b bold clr--gray">Last Name</p>
		 					<div class="frm-inpt">
		                        <input type="text" name="name">
		                    </div>
		                </div>
					</div>

					<div class="width--33 m-margin-b">
						<div class="width--95">
							<p class="frm-header s-margin-b bold clr--gray">Special Fee</p>
		 					<div class="frm-inpt">
		                        <select>
		                        	<option></option>
		                        </select>
		                    </div>
	                	</div>
					</div
					><div class="width--33 m-margin-b">
						<div class="width--95 margin-a">
							<p class="frm-header s-margin-b bold clr--gray">E-mail Address</p>
		 					<div class="frm-inpt">
		                        <input type="text" name="name">
		                    </div>
		                </div>
					</div
					><div class="width--33 m-margin-b">
						<div class="width--95 margin-l-a">
							<p class="frm-header s-margin-b bold clr--gray">Mobile Phone</p>
							<div class="inlineBlock-parent">
								<div class="width--30">
									<div class="width--90">
										<div class="lgn-frm1__inpt frm-inpt align-c">
											<input type="text" name="" value="+63" disabled>
										</div>
									</div>
								</div
								><div class="width--70">
									<div class="lgn-frm1__inpt frm-inpt align-c">
										<input type="number" name="" placeholder="">
									</div>
								</div>
			                </div>
		                </div>
					</div>

					<div class="width--100 m-margin-b">
						<div class="width--100">
							<p class="frm-header s-margin-b bold clr--gray">Address</p>
		 					<div class="frm-inpt">
		                        <input type="text" name="" placeholder="">
		                    </div>
	                	</div>
					</div>

					<div class="width--33 m-margin-b">
						<div class="width--95">
							<p class="frm-header s-margin-b bold clr--gray">Country</p>
		 					<div class="frm-inpt">
		                        <input type="text" name="" placeholder="">
		                    </div>
	                	</div>
					</div
					><div class="width--33 m-margin-b">
						<div class="width--95 margin-a">
							<p class="frm-header s-margin-b bold clr--gray">Nationality</p>
		 					<div class="frm-inpt">
		                        <input type="text" name="name">
		                    </div>
		                </div>
					</div
					><div class="width--33 m-margin-b">
						<div class="width--95 margin-a">
							<p class="frm-header s-margin-b bold clr--gray">Birthdate</p>
		 					<div class="frm-inpt">
		                        <input type="date" name="name">
		                    </div>
		                </div>	
					</div>

					<div class="l-margin-t align-r width--100 inlineBlock-parent">
						<button class="frm-btn gray s-margin-r">Cancel</button>
						<button class="frm-btn green" data-remodal-target="success-modal">Save</button>
					</div>

					{{-- Modal --}}
					<div id="gnrl-rmdl" class="remodal custom-width__small" data-remodal-id="success-modal">
						<div class="width--90 margin-a">
							<img src="{{ asset('images/success-icon.png') }}" class="gnrl-rmdl__img-icon">
							<div class="frm-description no-height clr--gray m-margin-b">
								<p>Information successfully updated.</p>
							</div>
							<button data-remodal-action="close" class="frm-btn green">Okay, got it.</button>
						</div>
					</div>	
					{{--  --}}

				</div>
			</div>
		</div>
	</div>
</section>

@endsection