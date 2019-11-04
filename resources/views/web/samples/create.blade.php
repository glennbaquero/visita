@extends('web.master')

@section('meta:title', 'Create Sample Item')

@section('content')

<nav>
    <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('web.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('web.sample-items.index') }}">Sample Items</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</nav>

<!-- Content Wrapper. Contains page content -->
<div class="container mb-5">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Create Sample Item</h3>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <sample-item-view
        fetch-url="{{ route('web.sample-items.fetch-item') }}"
        submit-url="{{ route('web.sample-items.store') }}"
        ></sample-item-view>
    </section>
</div>

@endsection