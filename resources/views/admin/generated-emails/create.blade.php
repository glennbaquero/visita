@extends('admin.master')

@section('meta:title', 'Create Generated Email')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Generated Email</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.generated-emails.index') }}">Generated Email</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <generated-emails-view
        fetch-url="{{ route('admin.generated-emails.fetch-item') }}"
        submit-url="{{ route('admin.generated-emails.store') }}"
        ></generated-emails-view>
    </section>
</div>

@endsection