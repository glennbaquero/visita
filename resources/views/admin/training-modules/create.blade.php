@extends('admin.master')

@section('meta:title', 'Create Training Module')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Training Module</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.training-modules.index') }}">Training Modules</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <training-modules-view
        fetch-url="{{ route('admin.training-modules.fetch-item') }}"
        submit-url="{{ route('admin.training-modules.store') }}"
        ></training-modules-view>
    </section>
</div>

@endsection