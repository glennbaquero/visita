@extends('web.master')

@section('meta:title', 'Sample Items')

@section('content')

<nav>
    <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('web.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Sample Items</li>
    </ol>
</nav>

<div class="container mb-5">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Sample Items</h3>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="mb-4">
            <a href="{{ route('web.sample-items.create') }}" class="btn btn-primary text-white">
                <i class="fa fa-plus mr-1"></i>
                Create
            </a>
        </div>

        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a @click="initList('table-1')" class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Active</a></li>
                    <li class="nav-item"><a @click="initList('table-2')" class="nav-link" data-target="#tab2" href="javascript:void(0)" data-toggle="tab">Archived</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                        <sample-item-table
                        ref="table-1"
                        fetch-url="{{ route('web.sample-items.fetch') }}"
                        :filter-status="{{ $filterStatus }}"
                        ></sample-item-table>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <sample-item-table
                        ref="table-2"
                        disabled
                        fetch-url="{{ route('web.sample-items.fetch-archive') }}"
                        :filter-status="{{ $filterStatus }}"
                        ></sample-item-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection