@extends('admin.master')

@section('meta:title', 'Export Report')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Export Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Export Report</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a @click="initList('table-1')" class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Active</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                        <export-view 
                        ref="table-1"
                        fetch-url="{{ route('admin.invoices.fetch') }}"
                        :filter-categories="{{ $filterCategories }}"
                        :filter-types="{{ $filterTypes }}"
                        :filter-destinations="{{ $filterDestinations }}"
                        export-url="{{ route('admin.invoices.export') }}"
                        ></export-view>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection