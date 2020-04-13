@extends('web.master')

@section('meta:title', $item->renderName())

@section('content')

<div class="container my-5">
	<selected-article
	fetch-url="{{ route('web.articles.fetch-item', $item->id) }}"
	></selected-article>
</div>

@endsection