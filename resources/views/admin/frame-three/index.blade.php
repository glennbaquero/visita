@extends('admin.master')

@section('meta:title', 'About Us')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>About Us</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">About Us</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="mb-4">
        @if($show_create)
            <a href="{{ route('admin.about-us.create') }}" class="btn btn-primary text-white">
                <i class="fa fa-plus"></i>
                Create
            </a>
        @endif
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary text-white">
            <i class="fa fa-plus"></i>
            Create Team
        </a>
        </div>

        <div class="col-xs-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a @click="initList('table-1')" class="nav-link active" href="#tab1" data-toggle="tab">About Us Content</a></li>
                        <li class="nav-item"><a @click="initList('table-2')" class="nav-link" href="#tab2" data-toggle="tab">Team</a></li>
                        <li class="nav-item"><a @click="initList('table-3')" class="nav-link" href="#tab3" data-toggle="tab">Archived</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="tab1">
                            <about-us-table 
                            ref="table-1"
                            fetch-url="{{ route('admin.about-us.fetch') }}"
                            ></about-us-table>
                        </div>
                        <div class="tab-pane show" id="tab2">
                            <teams-table 
                            ref="table-2"
                            fetch-url="{{ route('admin.teams.fetch') }}"
                            ></teams-table>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <about-us-table
                            ref="table-3"
                            disabled
                            fetch-url="{{ route('admin.about-us.fetch-archive') }}"
                            ></about-us-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection