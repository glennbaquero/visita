@extends('admin.master')

@section('meta:title', 'Create Religion')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Religion</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.religions.index') }}">Religions</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <religions-view
        fetch-url="{{ route('admin.religions.fetch-item') }}"
        submit-url="{{ route('admin.religions.store') }}"
        ></religions-view>
    </section>
</div>

@endsection