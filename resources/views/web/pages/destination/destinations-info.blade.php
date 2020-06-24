@extends('web.master')

@section('meta:title', 'Destination')
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section class="dstntns-inf-frm1 gnrl-frm--sldr__container">
	<div class="gnrl-frm--sldr">
		<div class="gnrl-frm--sldr__item">
			<div class="frm-cntnr align-c width--85">
				<div class="vertical-parent">
					<div class="vertical-align">
						<div class="dstntns-inf-frm1__container width--50 margin-l-a">
							<div class="frm-cntnr align-c width--85">
								<div class="vertical-parent">
									<div class="vertical-align align-l">
										<p class="frm-header s-margin-b clr--white">Destination</p>
										<h5 class="frm-title small s-margin-b clr--white">{{ $selected_destination->name }}</h5>
										
										<div class="dstntns-inf-frm1__location inlineBlock-parent">
											<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/location-icon.png') }}">	
											<p class="frm-header s-margin-b clr--white">Location: {{ $selected_destination->location }}</p>
										</div>

										<div class="dstntns-inf-frm1__location inlineBlock-parent">
											<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/calendar-icon.png') }}">	
											<p class="frm-header s-margin-b clr--white">Duration: {{ $selected_destination->duration }} </p>
										</div>

										<div class="dstntns-inf-frm1__location inlineBlock-parent">
											<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/recommended-icon.png') }}">	
											<p class="frm-header s-margin-b clr--white">Recommended for: {{ $selected_destination->recommended }}</p>
										</div>

										<div class="dstntns-inf-frm1__location inlineBlock-parent">
											<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/activities-icon.png') }}">	
											<p class="frm-header s-margin-b clr--white">Activities: 
												@foreach($selected_destination->allocations  as $key => $allocation)
													{{ $allocation->name }}
													@if($key+1 < count($selected_destination->allocations)),@endif
												@endforeach
											</p>
										</div>

										<div class="frm-description clr--white l-margin-t m-margin-b dstntns-inf-frm1__location-desc">
											<p>{{ $selected_destination->renderShortOverview() }}</p>
										</div>
										
										@if($selected_destination->is_available_for_request) 
											<a href="{{ $selected_destination->request_url }}" class="frm-btn green">Request to Visit</a>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('{{ $selected_destination->pictures()->first()->renderImagePath() }}');"></div>
		</div>
	</div>
</section>
<div class="mbl-dstntns-inf-frm1 frm-cntnr align-c width--100">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align align-l">
				<p class="frm-header s-margin-b clr--green">Destination</p>
				<h5 class="frm-title small s-margin-b clr--orange">{{ $selected_destination->name }}</h5>
				
				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/location-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Location: {{ $selected_destination->location }}.</p>
				</div>

				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/calendar-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Duration: {{ $selected_destination->duration }} Day/s</p>
				</div>

				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/recommended-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Recommended for: {{ $selected_destination->recommended }}</p>
				</div>

				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/activities-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Activities: 
						@foreach($selected_destination->allocations  as $key => $allocation)
							{{ $allocation->name }}
							@if($key+1 < count($selected_destination->allocations)),@endif
						@endforeach
					</p>
				</div>

				<div class="frm-description clr--gray m-margin-tb dstntns-inf-frm1__location-desc">
					<p>{{ $selected_destination->renderShortOverview() }}</p>
				</div>
				
				@if($selected_destination->is_available_for_request) 
					<a href="{{ $selected_destination->request_url }}" class="frm-btn green">Request to Visit</a>
				@endif
			</div>
		</div>
	</div>
</div>
<destination-info
	:destination="{{ $selected_destination }}"
></destination-info>
@endsection