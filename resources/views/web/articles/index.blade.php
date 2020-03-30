@extends('web.master')

@section('meta:title', 'Articles')

@section('content')

<div class="container-fluid my-5">
	<article-list
    fetch-url="{{ route('web.articles.fetch') }}"
    >
    	<div class="text-center">
	    	<p>Loading please wait...</p>
    	</div>
    </article-list>
</div>

@endsection