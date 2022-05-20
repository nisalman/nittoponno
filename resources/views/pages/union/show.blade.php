@extends('layouts.app')

@section('title', 'All Union')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Union Data</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Union Data</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">

        @if(session('success'))

            <div class="alert alert-success">{{session('success')}}!</div>

        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{session('failed')}}!
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5> Union</h5>
                        @if(Auth::user()->user_type==getAdminId())
                            <a href="/admin/union/create" class="btn btn-sm btn-success">+New</a>
                        @endif
                    </div>
                    <div class="ibox-content">

                        <div class="{{--table-responsive--}}">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Eng Name</th>
                                    <th>Bn Name</th>
                                    <th>Upazila</th>
                                    @if(Auth::user()->user_type==getAdminId())
                                        <th>Action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr class="gradeU">
                                        <td>{{$i++}}</td>
                                        <td>{{$res->en_name}}</td>
                                        <td>{{$res->bn_name}}</td>
                                        <td>{{$res->upazila_name}}</td>

                                        @if(Auth::user()->user_type==getAdminId())
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                            class="btn btn-default btn-xs dropdown-toggle">Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                               href="/admin/union/edit/{{$res->id}}" target="_blank">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="/admin/union/delete/{{$res->id}}">Delete</a></li>
                                                    </ul>
                                                </div>

                                            </td>
                                        @endif

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