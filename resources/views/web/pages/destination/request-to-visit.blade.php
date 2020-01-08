@extends('web.master')

@section('content')

<section class="rqst-frm1">
	<user-booking 
		:destination="{{ $destination }}" 
		:items="{{ $items }}" 
		:genders="{{ $genders }}"
		:countries="{{ $countries }}"
		:visitor-types="{{ $visitor_types }}"
	></user-booking>
</section>

@endsection