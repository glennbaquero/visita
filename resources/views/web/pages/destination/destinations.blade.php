@extends('web.master')

@section('content')

<section class="dstntns-frm1">
	<div class="inlineBlock-parent">
		<div class="dstntns-frm1__col width--55">
			<div class="dstntns-frm1__slider">
				
				<div class="dstntns-frm1__slider-item">
					<div class="dstntns-frm1__slider-item-info-holder margin-a width--85">
						<div class="vertical-parent">
							<div class="vertical-align align-b">
								<div class="dstntns-frm1__slider-item-info">
									<h5 class="frm-title l-margin-b clr--white">Mt.	Pulag</h5>
									<div class="frm-description s-margin-b clr--white">
										<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout...</p>
									</div>
									<div class="inlineBlock-parent width--100">
										<a href="destinations-info" class="frm-btn green s-margin-r">View Destination</a>
										<button class="frm-btn orange">Request to Visit</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="frm-bckgrnd size-cover" style="background-image: url('https://visita.org.ph/storage/images/5dedb00ae2944ArVSyajiYq2kOpHI1y3q6kYoH2iEuFBKvNBUXXeK.png');"></div>
				</div>

				<div class="dstntns-frm1__slider-item">
					<div class="dstntns-frm1__slider-item-info-holder margin-a width--85">
						<div class="vertical-parent">
							<div class="vertical-align align-b">
								<div class="dstntns-frm1__slider-item-info">
									<h5 class="frm-title l-margin-b clr--white">Kalanggaman</h5>
									<div class="frm-description s-margin-b clr--white">
										<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout...</p>
									</div>
									<div class="inlineBlock-parent width--100">
										<a href="#" class="frm-btn green s-margin-r">View Destination</a>
										<button class="frm-btn orange">Request to Visit</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="frm-bckgrnd size-cover" style="background-image: url('https://i1.wp.com/outoftownblog.com/wp-content/uploads/2018/06/Kalanggaman-Island-Drone-shots-by-Joseph-Pasalo-of-SEF-TV.jpg?fit=1500%2C843&ssl=1');"></div>
				</div>

				<div class="dstntns-frm1__slider-item">
					<div class="dstntns-frm1__slider-item-info-holder margin-a width--85">
						<div class="vertical-parent">
							<div class="vertical-align align-b">
								<div class="dstntns-frm1__slider-item-info">
									<h5 class="frm-title l-margin-b clr--white">Donsol</h5>
									<div class="frm-description s-margin-b clr--white">
										<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout...</p>
									</div>
									<div class="inlineBlock-parent width--100">
										<a href="#" class="frm-btn green s-margin-r">View Destination</a>
										<button class="frm-btn orange">Request to Visit</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="frm-bckgrnd size-cover" style="background-image: url('https://www.pwc.com/ph/en/gems/assets/2017/ph-donsol.jpg');"></div>
				</div>

			</div>
		</div
		><div class="dstntns-frm1__col width--45">
			<div class="dstntns-frm1__col-inner-holder margin-a width--85">
				<div class="dstntns-frm1__search-holder width--100 align-r">
					<div class="dstntns-frm1__search frm-inpt m-margin-b">
						<input type="" name="" placeholder="Where do you want to go?">
						<button><img src="{{ asset('images/search-button.png') }}"></button>
					</div>
				</div>
				<p class="dstntns-frm1__caption frm-header clr--gray">Choose from stunning destinations committed to sustainable tourism.</p>
				<div class="dstntns-frm1__slider-thumbnail-holder">
					<div class="dstntns-frm1__slider-thumbnail">

						<div class="dstntns-frm1__slider-thumbnail-item">
							<div class="dstntns-frm1__slider-thumbnail-item-img m-margin-b">
								<div class="frm-bckgrnd size-cover" style="background-image: url('https://visita.org.ph/storage/images/5dedb00ae2944ArVSyajiYq2kOpHI1y3q6kYoH2iEuFBKvNBUXXeK.png');"></div>
							</div>
							<div class="align-r">
								<p class="frm-header clr--gray">Mt. Pulag</p>
							</div>
						</div>

						<div class="dstntns-frm1__slider-thumbnail-item">
							<div class="dstntns-frm1__slider-thumbnail-item-img m-margin-b">
								<div class="frm-bckgrnd size-cover" style="background-image: url('https://d36tnp772eyphs.cloudfront.net/blogs/1/2018/09/Kalanggaman-Island.jpeg');"></div>
							</div>
							<div class="align-r">
								<p class="frm-header clr--gray">Kalanggaman</p>
							</div>
						</div>

						<div class="dstntns-frm1__slider-thumbnail-item">
							<div class="dstntns-frm1__slider-thumbnail-item-img m-margin-b">
								<div class="frm-bckgrnd size-cover" style="background-image: url('https://travelphilippines.net/wp-content/uploads/2018/07/Donsol-Whale-Sharks.jpg');"></div>
							</div>
							<div class="align-r">
								<p class="frm-header clr--gray">Donsol</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

</section>

@endsection