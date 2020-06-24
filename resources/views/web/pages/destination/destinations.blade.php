@extends('web.master')

@section('meta:title', 'Destination')
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section class="dstntns-frm1">
	<destinations
	:destinations="{{ json_encode($destinations) }}"
	></destinations>
</section>

@endsection