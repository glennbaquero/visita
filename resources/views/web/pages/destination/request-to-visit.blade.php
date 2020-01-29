@extends('web.master')

@section('meta:title', $page->renderMeta('title'))
@section('meta:description', $page->renderMeta('description'))
@section('meta:keywords', $page->renderMeta('keywords'))
@section('og:image', $page->renderMetaImage())
@section('og:title', $page->renderMeta('og_title'))
@section('og:description', $page->renderMeta('og_description'))

@section('content')

<section class="rqst-frm1">
	<user-booking 
		:destination="{{ $destination }}" 
		:items="{{ $items }}" 
		:genders="{{ $genders }}"
		:countries="{{ $countries }}"
		:visitor-types="{{ $visitor_types }}"
		book-url="{{ route('web.book.store') }}"
	></user-booking>
</section>

@endsection