@extends('admin.master')

@section('meta:title', 'Create Home Banner')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Home Banner</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home-banners.index') }}">Home Banner</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <home-banners-view
        fetch-url="{{ route('admin.home-banners.fetch-item') }}"
        submit-url="{{ route('admin.home-banners.store') }}"
        ></home-banners-view>
    </section>
</div>

@endsection