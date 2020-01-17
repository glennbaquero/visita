@extends('web.master')

@section('content')

<section class="dstntns-frm1">
	<destinations
	:destinations="{{ json_encode($destinations) }}"
	></destinations>
</section>

@endsection