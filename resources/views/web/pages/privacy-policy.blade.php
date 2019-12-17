@extends('web.master')

@section('content')

<section class="prvcy-plcy-frm">
	<div class="frm-cntnr align-c width--80">
		<div class="vertical-parent">
			<div class="vertical-align">
				<h5 class="frm-title l-margin-b clr--green">{{ $data['pageItems']['frame_1_text'] }}</h5>
				<div class="frm-description clr--black">
					{!! $data['pageItems']['frame_1_content']!!}
				</div>
			</div>
		</div>
	</div>
</section>

@endsection