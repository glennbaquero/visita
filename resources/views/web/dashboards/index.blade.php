@extends('web.master')

@section('meta:title', 'Dashboard')

@section('content')

<div class="p-2 bg-light">
    <a class="btn btn-light mr-2 d-block d-sm-inline-block d-md-inline-block" href="{{ route('web.profiles.show') }}">My Account</a>
    <a class="btn btn-light mr-2 d-block d-sm-inline-block d-md-inline-block" href="{{ route('web.sample-items.index') }}">Sample Items</a>
    <a class="btn btn-light mr-2 d-block d-sm-inline-block d-md-inline-block" href="{{ route('web.activity-logs.index') }}">Activity Logs</a>
    <a class="btn btn-light mr-2 d-block d-sm-inline-block d-md-inline-block float-none float-sm-right float-md-right" href="{{ route('web.notifications.index') }}">
        <i class="fa fa-bell mr-2 text-dark"></i>
        <count-listener
        class="badge-warning navbar-badge text-dark"
        fetch-url="{{ route('web.counts.fetch.notifications') }}"
        event="update-notification-count"
        ></count-listener>
    </a>
</div>

<div class="jumbotron">
    <h1 class="display-4">Welcome {{ $self->renderName() }}!</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    <hr class="my-4">
    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
</div>

@endsection