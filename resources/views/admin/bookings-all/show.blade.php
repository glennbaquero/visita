@extends('admin.master')

@section('meta:title', 'Reservation')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $item->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.calendar.index') }}">Calendar</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $item->name }}</a></li>
                </ol>
            </div>
        </div>
    </section>
    
   {{--  <page-pagination fetch-url="{{ route('admin.bookings.fetch-pagination', $item->id) }}"></page-pagination> --}}

    <section class="content">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a @click="initList('table-1')" class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Information</a></li>
                    <li class="nav-item"><a @click="initList('table-2')" class="nav-link" href="#tab2" data-toggle="tab">Remarks</a></li>
                    <li class="nav-item"><a @click="initList('table-3')" class="nav-link" href="#tab3" data-toggle="tab">Violations</a></li>
                    <li class="nav-item"><a @click="initList('table-4')" class="nav-link" href="#tab4" data-toggle="tab">Feedback</a></li>
                    <li class="nav-item"><a @click="initList('table-5')" class="nav-link" href="#tab5" data-toggle="tab">Invoice</a></li>
                    <li class="nav-item"><a @click="initList('table-6')" class="nav-link" data-target="#tab6" href="javascript:void(0)" data-toggle="tab">Activity Logs</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                        <bookings-view
                        ref="table-1"
                        fetch-url="{{ route('admin.bookings.fetch-item', $item->id) }}"
                        submit-url="{{ route('admin.bookings.update', $item->id) }}"
                        ></bookings-view>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <group-remarks-table
                        ref="table-2"
                        disabled
                        no-action
                        fetch-url="{{ route('admin.group-remarks.fetch.bookid', $item->id) }}"
                        ></group-remarks-table>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <group-violation-table
                        ref="table-3"
                        disabled
                        no-action
                        fetch-url="{{ route('admin.group-violations.fetch.bookid', $item->id) }}"
                        ></group-violation-table>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <guest-feedback-table
                        ref="table-4"
                        disabled
                        no-action
                        fetch-url="{{ route('admin.guest-feedbacks.fetch.bookid', $item->id) }}"
                        ></guest-feedback-table>
                    </div>
                    <div class="tab-pane" id="tab5">
                        <invoices-view
                        ref="table-5"
                        fetch-url="{{ route('admin.invoices.fetch-item', $item->invoice->id) }}"
                        submit-url="{{ $submitUrl }}"
                        ></invoices-view>
                    </div>

                    <div class="tab-pane" id="tab6">
                        <activity-log-table 
                        ref="table-6"
                        disabled
                        no-action
                        fetch-url="{{ route('admin.activity-logs.fetch.bookings', $item->id) }}"
                        ></activity-log-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection