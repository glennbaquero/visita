@extends('admin.master')

@section('meta:title', 'Create Violations')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Violations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.violations.index') }}">Violations</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <violations-view
        fetch-url="{{ route('admin.violations.fetch-item') }}"
        submit-url="{{ route('admin.violations.store') }}"
        ></violations-view>
    </section>
</div>

@endsection