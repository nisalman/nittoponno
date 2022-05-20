@extends('layouts.app')

@section('title', 'All Agent')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Agent Data</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Agent Data</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Agents</h5>

                        <a href="/admin/agent/create" class="btn btn-sm btn-success">+New</a>

                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Active</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr class="gradeU">
                                        <td>{{$i++}}</td>
                                        <td>{{$res->name}}</td>
                                        <td>{{$res->user_name}}</td>
                                        <td>{{$res->phone}}</td>
                                        <td>@if($res->is_active) <span class="badge badge-success">Active</span> @else
                                                <span class="badge badge-warning">Inactive</span> @endif</td>
                                        <td>

                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-default btn-xs dropdown-toggle">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                           href="/admin/agent/edit/{{$res->id}}">Edit</a></li>
                                                    @if($res->is_active)
                                                        <li><a class="dropdown-item"
                                                               href="/admin/agent/status-update/{{$res->id}}/0">Inactive</a>
                                                        </li>
                                                    @else
                                                        <li><a class="dropdown-item"
                                                               href="/admin/agent/status-update/{{$res->id}}/1">Activate</a>
                                                        </li>
                                                    @endif


                                                </ul>
                                            </div>
                                        </td>

                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection