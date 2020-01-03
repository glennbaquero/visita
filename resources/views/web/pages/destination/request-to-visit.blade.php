@extends('web.master')

@section('content')

<section class="rqst-frm1">
	<user-booking :destination="{{ $destination }}">
	</user-booking>
</section>

@endsection