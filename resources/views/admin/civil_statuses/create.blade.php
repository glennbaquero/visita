@extends('admin.master')

@section('meta:title', 'Create Civil Status')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Civil Status</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.civil_statuses.index') }}">Civil Status</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <civil_statuses-view
        fetch-url="{{ route('admin.civil_statuses.fetch-item') }}"
        submit-url="{{ route('admin.civil_statuses.store') }}"
        ></civil_statuses-view>
    </section>
</div>

@endsection