@extends('admin.master')

@section('meta:title', 'Create Frame Three of About Us Page')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Frame Three of About Us Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.about-us.index') }}">Frame Three of About Us Page</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <frame-three-view
        fetch-url="{{ route('admin.frame-three.fetch-item') }}"
        submit-url="{{ route('admin.frame-three.store') }}"
        ></frame-three-view>
    </section>
</div>

@endsection