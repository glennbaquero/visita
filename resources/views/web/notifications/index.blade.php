@extends('web.master')

@section('meta:title', 'Notifications')

@section('content')

<nav>
    <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('web.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Notifications</li>
    </ol>
</nav>

<div class="container mb-5">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h3>Notifications</h3>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-body">
                <notification-table 
                read-all-url="{{ route('web.notifications.read-all') }}"
                fetch-url="{{ route('web.notifications.fetch') }}"
                ></notification-table>
            </div>
        </div>
    </section>
</div>

@endsection