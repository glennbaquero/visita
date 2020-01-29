@extends('web.master')

@section('meta:title', $page->renderMeta('title'))
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
											<p class="frm-header s-margin-b clr--white">Duration: {{ $selected_destination->duration }} Day(s)</p>
										</div>

										<div class="dstntns-inf-frm1__location inlineBlock-parent">
											<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/recommended-icon.png') }}">	
											<p class="frm-header s-margin-b clr--white">Recommended for: {{ $selected_destination->recommended }}</p>
										</div>

										<div class="dstntns-inf-frm1__location inlineBlock-parent">
											<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/activities-icon.png') }}">	
											<p class="frm-header s-margin-b clr--white">Activities: {{ $selected_destination->experience }}</p>
										</div>

										<div class="frm-description clr--white l-margin-t m-margin-b dstntns-inf-frm1__location-desc">
											<p>{{ $selected_destination->renderShortOverview() }}</p>
										</div>

										<button class="frm-btn green">Request to Visit</button>

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
				<h5 class="frm-title small s-margin-b clr--orange">Mt. Pulag</h5>
				
				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/location-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Location: Baguio, Luzon, Philippines.</p>
				</div>

				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/calendar-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Duration: 1 - 3 Days</p>
				</div>

				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/recommended-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Recommended for: Beginner hikders, nature enthusiasts</p>
				</div>

				<div class="dstntns-inf-frm1__location inlineBlock-parent">
					<img class="dstntns-inf-frm1__location-img" src="{{ asset('images/activities-icon.png') }}">	
					<p class="frm-header s-margin-b clr--gray">Activities: Hiking</p>
				</div>

				<div class="frm-description clr--gray m-margin-tb dstntns-inf-frm1__location-desc">
					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</p>
				</div>

				<button class="frm-btn green">Request to Visit</button>

			</div>
		</div>
	</div>
</div>
<section class="dstntns-inf-frm2">
	<div class="frm-cntnr width--85 align-c">
		<div class="inlineBlock-parent">
			<div class="dstntns-inf-frm2__btn-holder width--30 align-l align-t">
				<p class="dstntns-inf-frm2__btn active">Overview</p>
				<p class="dstntns-inf-frm2__btn">Experiences</p>
				<p class="dstntns-inf-frm2__btn">Fees</p>
				<p class="dstntns-inf-frm2__btn">Visitor Policies</p>
				<p class="dstntns-inf-frm2__btn">Terms & Condtions of Visit Request</p>
				<p class="dstntns-inf-frm2__btn">How to Get Here</p>
				<p class="dstntns-inf-frm2__btn">Contact Us</p>
				<button class="frm-btn green">Request to Visit</button>
			</div
			><div class="width--70 align-l align-t">
				<div class="dstntns-inf-frm2__content-inner">
					<div class="frm-description clr--gray gnrl-scrll">
						<p><strong>About the Destination</strong></p>
						<p>The Mount Pulag National Park, famous for its “sea of clouds” and is referred to as the “stairway to heaven” in local folklore is the highest mountain in the north and the third highest in the country at 2, 922 meters above sea level.</p>
						<p><strong>Flora and Fauna</strong></p>
						<p>Recognized by scientists because of its ecological value, one could be mesmerized by the various species, both flora and fauna, that could be found in the area including thirty three (33) bird species and several threatened mammals such as the Philippine Deer, Giant Bushy-tailed Cloud Rat (“bowet”) and the Long-Haired Fruit Bat. Mt. Pulag is also the only place that hosts the four (4) cloud rat species. It is also home to the endemic Dwarf Bamboo (Yushania niitakayamensis) and the Benguet Pine (Pinus insularis) which dominates the areas of Luzon tropical pine forests found on the mountainside.</p>
						<p><strong>Trail Characteristics</strong></p>
						<p>Hiking in Mount Pulag is like a multi-trip to different beautiful destinations. It has three distinct natural vegetation zone namely: the lower montane (pine forest), the upper montane (mossy forest) and the grassland where the summit lies. The pine forest provides a complete Cordillera experience with its famous Benguet pine trees. At the grassland summit, alpine grass and dwarf bamboos could be seen as well as the ever famous breathtaking view of the sea of clouds. Mount Pulag is also known for its pristine lakes and caves and its historical significance for it is considered sacred by its people and the home of their god “Kabunian”.</p><p><strong>Other things to note:</strong></p>
						<ul>
							<li>Reservation for Saturday schedule is always high hence trekkers are advised to come on week days where it is less congested.</li>
							<li>Camping at Camp 2 is allowed during Monday to Thursday except on holidays.</li>
							<li>Medical Certificate is a must before ascent showing the vital signs</li>
							<li>Dennis Molintas Memorial Hospital (DMMH) / Private Clinic offers medical certificate before climb during office hours (8:00am to 5:00pm).</li>
						</ul>
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30588.6617312151!2d120.88165697435267!3d16.597498967601513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33904accf133372f%3A0xa20b501379e7d400!2sMount%20Pulag!5e0!3m2!1sen!2sph!4v1576566050468!5m2!1sen!2sph" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
						<br>
						<br>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/bKIIdCNOQwY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection