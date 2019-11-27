@extends('admin.master')

@section('meta:title', $item->renderName())

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $item->renderName() }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.surveys.index') }}">Surveys</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $item->renderName() }}</a></li>
                </ol>
            </div>
        </div>
    </section>
    
    <page-pagination fetch-url="{{ route('admin.surveys.fetch-pagination', $item->id) }}"></page-pagination>

    <section class="content">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Information</a></li>
                    <li class="nav-item"><a @click="initList('table-2')" class="nav-link" data-target="#tab2" href="javascript:void(0)" data-toggle="tab">Survey Experience</a></li>    
                    <li class="nav-item"><a @click="initList('table-3')" class="nav-link" data-target="#tab3" href="javascript:void(0)" data-toggle="tab">Activity Logs</a></li>    
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                        <surveys-view
                        fetch-url="{{ route('admin.surveys.fetch-item', $item->id) }}"
                        ></surveys-view>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <surveys-answer-table
                        ref="table-2"
                        disabled
                        no-action
                        fetch-url="{{ route('admin.survey_answers.fetch.surveyid', $item->id) }}"
                        ></surveys-answer-table>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <activity-log-table 
                        ref="table-3"
                        disabled
                        no-action
                        fetch-url="{{ route('admin.activity-logs.fetch.surveys', $item->id) }}"
                        ></activity-log-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection