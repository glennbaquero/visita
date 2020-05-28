@extends('admin.master')

@section('meta:title', 'Create Experience')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Experience</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.allocations.index') }}">Experiences</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <allocations-view
        fetch-url="{{ route('admin.allocations.fetch-item') }}"
        submit-url="{{ route('admin.allocations.store') }}"
        ></allocations-view>
    </section>
</div>

@endsection