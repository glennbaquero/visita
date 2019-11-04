@extends('web.master')

@section('meta:title', $item->renderName())

@section('content')

<nav>
    <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('web.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('web.sample-items.index') }}">Sample Items</a></li>
        <li class="breadcrumb-item active">{{ $item->renderName() }}</li>
    </ol>
</nav>

<!-- Content Wrapper. Contains page content -->
<div class="container mb-5">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-12">
                <h3>{{ $item->renderName() }}</h3>
            </div>
        </div>
    </section>

    <page-pagination fetch-url="{{ route('web.sample-items.fetch-pagination', $item->id) }}"></page-pagination>
    
    <section class="content">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Information</a></li>
                    <li class="nav-item"><a @click="initList('table-1')" class="nav-link" data-target="#tab2" href="javascript:void(0)" data-toggle="tab">Activity Logs</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                        <sample-item-view
                        fetch-url="{{ route('web.sample-items.fetch-item', $item->id) }}"
                        submit-url="{{ route('web.sample-items.update', $item->id) }}"
                        ></sample-item-view>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <activity-log-table 
                        ref="table-1"
                        disabled
                        fetch-url="{{ route('web.activity-logs.fetch.sample-items', $item->id) }}" 
                        hide-causer
                        ></activity-log-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection