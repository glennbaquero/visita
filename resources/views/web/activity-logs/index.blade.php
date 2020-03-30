@extends('web.master')

@section('meta:title', 'Activity Logs')

@section('content')

<nav>
    <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('web.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Activity Logs</li>
    </ol>
</nav>

<div class="container mb-5">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h3>Activity Logs</h3>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-body">
                <activity-log-table 
                fetch-url="{{ route('web.activity-logs.fetch') }}"
                actionable
                hide-causer
                show-subject
                ></activity-log-table>
            </div>
        </div>
    </section>
</div>

@endsection