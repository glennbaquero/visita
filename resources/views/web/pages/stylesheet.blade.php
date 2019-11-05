@extends('web.master')


@section('content')

<div class="frm-cntnr aling-c width--90">
	<div class="l-margin-tb inlineBlock-parent">
		<div class="width--50 align-t">
			<p class="frm-header bold clr--light-gray" style="font-size: 1.5em;">Color Palette</p>
			<div style="border: 1px solid #A9A9A9; width: 90%;"></div>
			<div class="inlineBlock-parent">

				<div style="margin-top: 20px; margin-right: 20px; text-align: center;">
					<div style="background: #E0AF3C; width: 60px; height: 60px; border-radius: 100%;"></div>
					<p style="margin-top: 20px;">#E0AF3C</p>
				</div>

				<div style="margin-top: 20px; margin-right: 20px; text-align: center;">
					<div style="background: #657008; width: 60px; height: 60px; border-radius: 100%;"></div>
					<p style="margin-top: 20px;">#657008</p>
				</div>

				<div style="margin-top: 20px; margin-right: 20px; text-align: center;">
					<div style="background: #2C4043; width: 60px; height: 60px; border-radius: 100%;"></div>
					<p style="margin-top: 20px;">#2C4043</p>
				</div>

				<div style="margin-top: 20px; margin-right: 20px; text-align: center;">
					<div style="background: #A74424; width: 60px; height: 60px; border-radius: 100%;"></div>
					<p style="margin-top: 20px;">#A74424</p>
				</div>

				<div style="margin-top: 20px; margin-right: 20px; text-align: center;">
					<div style="background: #434244; width: 60px; height: 60px; border-radius: 100%;"></div>
					<p style="margin-top: 20px;">#434244</p>
				</div>

			</div>
		</div
		><div class="width--50 align-t">
			<p class="frm-header bold clr--light-gray" style="font-size: 1.5em;">Typography</p>
			<div style="border: 1px solid #A9A9A9; width: 90%;"></div>
			
			<div style="margin-top: 20px;">
				<h5 class="frm-title m-margin-b clr--black">Text Title</h5>
				<p class="frm-header m-margin-b clr--black">Text Header Regular</p>
				<p class="frm-header bold m-margin-b clr--black">Text Header Bold</p>
				<div class="frm-description m-margin-b clr--black">
					<p>Text Description, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p><strong>Text Description bold</strong>
				</div>
			</div>

		</div>
	</div>

	<div class="l-margin-tb inlineBlock-parent">
		<div class="width--50 align-t">
			<p class="frm-header bold clr--light-gray" style="font-size: 1.5em;">Buttons</p>
			<div style="border: 1px solid #A9A9A9; width: 90%;"></div>
			
			<div style="margin-top: 20px;">
				<a href="" class="frm-btn green">Anchor Tag</a>
				<button class="frm-btn green">Button</button>
			</div>

			<div style="margin-top: 20px;">
				<a href="" class="frm-btn orange">Anchor Tag</a>
				<button class="frm-btn orange">Button</button>
			</div>

		</div
		><div class="width--50 align-t">
			<p class="frm-header bold clr--light-gray" style="font-size: 1.5em;">Forms</p>
			<div style="border: 1px solid #A9A9A9; width: 90%;"></div>
			
			<div style="margin-top: 20px;">
				<div class="frm-inpt m-margin-b">
					<input type="" name="" placeholder="Input text">
				</div>
				<div class="frm-inpt m-margin-b">
					<select>
						<option></option>
					</select>
				</div>
				<div class="frm-inpt m-margin-b">
					<textarea rows="4"></textarea>
				</div>
			</div>

		</div>
	</div>

</div>

@endsection