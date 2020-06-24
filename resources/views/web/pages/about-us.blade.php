@extends('web.master')

@section('meta:title', 'About Us')
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section class="abt-frm1">
	<div class="frm-cntnr align-c width--85">
		<div class="vertical-parent">
			<div class="vertical-align">
				<div class="abt-frm1__container width--50 margin-l-a abt-frm1-fade-up__animation">
					<div class="frm-cntnr align-c width--85">
						<div class="vertical-parent">
							<div class="vertical-align align-l">
								<p class="frm-header s-margin-b clr--white">About</p>
								<h5 class="frm-title s-margin-b clr--white abt-frm1-fade-up__animation-title">{{ $pageItems['frame_1_text'] }}</h5>
								<div class="abt-frm1-fade-up__animation-description frm-description clr--white gnrl-scrll">
									{!! $pageItems['frame_1_content'] !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="frm-bckgrnd size-cover bring-back" style="background-image: url('{!! $pageItems['frame_1_image'] !!}');"></div>
</section>
<div class="mbl-abt-frm1 frm-cntnr align-c width--100">
	<div class="width--85 margin-a">
		<p class="frm-header s-margin-b clr--green">About</p>
		<h5 class="frm-title s-margin-b clr--green abt-frm1-fade-up__animation-title">{{ $pageItems['frame_1_text'] }}</h5>
		<div class="abt-frm1-fade-up__animation-description frm-description clr--gray gnrl-scrll">
			{!! $pageItems['frame_1_content'] !!}
		</div>
	</div>
</div>
<section class="abt-frm2">
	<div class="frm-cntnr align-c width--85 abt-frm2-fade-up__animation">
		<div class="abt-frm2-fade-up__item1">
			<div class="abt-frm2__tabbing inlineBlock-parent">
				<p class="abt-frm2__tabbing-btn" data-frame2tab-id="frame2tab-team">Team</p>
				<p class="abt-frm2__tabbing-btn" data-frame2tab-id="frame2tab-collaborators">Collaborators</p>
				<p class="abt-frm2__tabbing-btn" data-frame2tab-id="frame2tab-advisors">Advisors</p>
			</div>
		</div>
		<div class="abt-frm2-fade-up__item2 abt-frm2-fade-up__animation-content">
			<div class="abt-frm2__tabbing-content gnrl-scrll" id="frame2tab-team">
				<div class="abt-frm2__tabbing-slider">
					
					@foreach($teams as $team)
						<div class="abt-frm2__tabbing-slider-items">
							<div class="abt-frm2__tabbing-slider-img">
								<div class="frm-bckgrnd size-cover bring-back" style="background-image: url({{ $team['image_path'] }});"></div>
							</div>
							<p class="frm-header bold clr--white">{{ $team['name'] }}</p>
							<p class="frm-header bold clr--white">{{ $team['role'] }}</p>
							<div class="frm-description bold clr--white gnrl-scrll">
								{!! $team['description'] !!}
							</div>
						</div>
					@endforeach

				</div>
			</div>
			<div class="abt-frm2__tabbing-content gnrl-scrll" id="frame2tab-collaborators">
				<div class="abt-frm2__tabbing-slider">
					@foreach($collaborators as $collaborator)
					<div class="abt-frm2__tabbing-slider-items">
						<div class="abt-frm2__tabbing-slider-img">
							<div class="frm-bckgrnd size-cover bring-back" style="background-image: url({{ $collaborator['image_path'] }});"></div>
						</div>
						<p class="frm-header bold clr--white m-margin-b">{{ $collaborator['name'] }}</p>
						<p class="frm-header bold clr--white m-margin-b">{{ $collaborator['role'] }}</p>
						<div class="frm-description bold clr--white gnrl-scrll">
							{!! $collaborator['description'] !!}
						</div>
					</div>
					@endforeach

				</div>
			</div>
			<div class="abt-frm2__tabbing-content gnrl-scrll" id="frame2tab-advisors">
				<div class="abt-frm2__tabbing-slider">
					
					@foreach($advisors as $advisor)
					<div class="abt-frm2__tabbing-slider-items">
						<div class="abt-frm2__tabbing-slider-img">
							<div class="frm-bckgrnd size-cover bring-back" style="background-image: url({{ $advisor['image_path'] }});"></div>
						</div>
						<p class="frm-header bold clr--white m-margin-b">{{ $advisor['name'] }}</p>
						<p class="frm-header bold clr--white m-margin-b">{{ $advisor['role'] }}</p>
						<div class="frm-description bold clr--white gnrl-scrll">
							{!! $advisor['description'] !!}
						</div>
					</div>
					@endforeach
					
				</div>
			</div>
		</div>
	</div>
</section>
<section class="abt-frm3">
	<div class="abt-frm3-fade-up__animation inlineBlock-parent">
		@foreach($frame_threes as $frame)<div class="abt-frm3__item">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="abt-frm3-fade-up__animation-title"> 
						<h5 class="abt-frm3__item-title frm-title clr--white">{{ $frame['title'] }}</h5>
					</div>
					<div class="abt-frm3__item-overlay">
						<div class="frm-cntnr align-c width--85">
							<div class="vertical-parent">
								<div class="vertical-align">
									<h5 class="abt-frm3__item-title-small frm-title small clr--white m-margin-b">{{ $frame['title'] }}</h5>
									<div class="abt-frm3__item-desc frm-description clr--white gnrl-scrll">
										{!! $frame['description'] !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="frm-bckgrnd size-cover bring-back" style="background-image: url({{ $frame['image_path'] }});"></div>	
		</div
		>@endforeach
	</div>
</section>

@endsection