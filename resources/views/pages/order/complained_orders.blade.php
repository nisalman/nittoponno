@extends('layouts.app')

@section('title', 'Complained Order')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Orders</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Orders</strong>
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
                        <p>
                            @if(Auth::user()->user_type==1 )

                                <a href="/admin/orders/Pending" class="btn btn-warning " type="button"><i
                                            class="fa fa-info"></i>&nbsp;Pending</a>

                            @endif
                            <a href="/admin/orders/Hold" class="btn btn-danger " type="button"><i
                                        class="fa fa-hand-grab-o"></i>&nbsp;&nbsp;<span class="bold">Hold</span></a>
                            <a href="/admin/orders/Retry" class="btn btn-warning " type="button"><i
                                        class="fa fa-paste"></i> Retry</a>
                            <a href="/admin/orders/Supplier Assigned" class="btn btn-info " type="button"><i
                                        class="fa fa-check"></i> <span class="bold">Volunteer Assigned</span></a>
                            <a href="/admin/orders/All" class="btn btn-primary " type="button"><i
                                        class="fa fa-check"></i> <span class="bold">All</span></a>

                        </p>

                        <p>
                            <a href="/admin/complain-orders" class="btn btn-info pull-right" type="button"><i
                                        class="fa fa-hand-grab-o"></i> <span class="bold">Complain</span></a>
                        </p>

                        <p>
                            @if(Auth::user()->user_type==1 )

                                <a href="/admin/order-request" class="btn btn-primary " type="button"><i
                                            class="fa fa-check"></i> <span class="bold">Get New Data</span></a>

                            @endif
                        </p>

                    </div>


                    <div class="ibox-content">

                        <div class="{{--table-responsive--}}">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Service Type</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Updated</th>

                                    {{-- <th>From Public</th>--}}
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($result as $res)
                                    <tr class="gradeU">
                                        <td>{{$i++}}</td>
                                        <td>{{$res->name}}</td>
                                        <td>{{$res->phone}}</td>
                                        <td>{{getServiceFromId($res->service_type)}}</td>
                                        <td>
                                            @if(getStatusName($res->status)=="Complain")

                                                <span class="badge-danger badge">{{getStatusName($res->status)}}</span>
                                            @elseif(getStatusName($res->status)=="Cancel Order")

                                                <span class="badge-warning badge">{{getStatusName($res->status)}}</span>
                                            @else
                                                <span class="badge-info badge">{{getStatusName($res->status)}}</span>
                                            @endif
                                        </td>
                                        <td>{{$res->admin_remarks}}</td>

                                        <td>{{$res->updated_at}}</td>
                                        <td>
                                            <a href="/admin/complain-order/dispute/{{$res->order_id}}"
                                               class="btn btn-primary btn-xs" type="button"><i
                                                        class="fa fa-check"></i>&nbsp;Dispute Order</a>

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