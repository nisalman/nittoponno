@extends('layouts.app')

@section('title', 'All Upazila')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Upazila Data</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Upazila Data</strong>
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
                        <h5> Upazila</h5>
                        @if(Auth::user()->user_type==getAdminId())
                            <a href="/admin/upazila/create" class="btn btn-sm btn-success">+New</a>
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
                                    <th>District</th>
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
                                        <td>{{$res->district_name}}</td>
                                        @if(Auth::user()->user_type==getAdminId())
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                            class="btn btn-default btn-xs dropdown-toggle">Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                               href="/admin/upazila/edit/{{$res->upazila_id}}"
                                                               target="_blank">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="/admin/upazila/delete/{{$res->upazila_id}}">Delete</a>
                                                        </li>
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