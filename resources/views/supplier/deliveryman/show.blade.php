@extends('layouts.supplier')

@section('title', 'All Transport')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Transport Data</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/supplier/dashboard">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Transport Data</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))

                    <div class="alert alert-success">{{session('success')}}!</div>

                @endif
                @if(session('failed'))
                    <div class="alert alert-danger">
                        {{session('failed')}}!
                    </div>
                @endif


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Transport</h5>
                       {{-- @if (Auth::user()->user_type != getModeratorId())--}}
                            <a href="/admin/deliveryman/create" class="btn btn-sm btn-success">+New</a>
                      {{--  @endif--}}
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Divison</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Union</th>
                                 {{--   @if(Auth::user()->user_type!=getModeratorId())--}}
                                        <th>Action</th>
                                {{--    @endif--}}

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr class="gradeU">
                                        <td>{{$i++}}</td>
                                        <td>{{$res->delivery_man_name}}</td>
                                        <td>{{$res->deliveryMan_phone}}</td>
                                        <td>{{$res->division_name}}</td>
                                        <td>{{$res->district_name}}</td>
                                        <td>{{$res->upazila_name}}</td>
                                        <td>{{$res->union_name}}</td>
                                      {{--  @if(Auth::user()->user_type!=getModeratorId())--}}

                                            <td>

                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                            class="btn btn-default btn-xs dropdown-toggle">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                               href="/admin/deliveryman/edit/{{$res->delivery_man_id}}">Edit</a>
                                                        </li>
                                                        {{--  <li><a class="dropdown-item" href="/admin/supplier/destroy/{{$res->id}}">Delete</a></li>--}}
                                                    </ul>
                                                </div>
                                            </td>
                                    {{--    @endif--}}

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