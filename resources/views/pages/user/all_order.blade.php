@extends('layouts.app')

@section('title', 'Orders')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Orders for: {{getSupplierNameFromId($user_id)}}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
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
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>All Orders</h5>


                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Info</th>
                                    <th>Customer Address</th>
                                    <th>Service</th>
                                    <th>Product Note</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Orderd at</th>



                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
     
                                @foreach($results as $res)
                                    <tr class="gradeU">

                                        <td>{{$res->invoice_number}}</td>
                                        <td>{{$res->name}}<br>
                                        {{$res->phone}}</td>
                                        <td>{{$res->delivery_address}}</td>
                                        <td>{{getServiceFromId($res->service_type)}}</td>
                                        <td>
                                            {{  $res->product_list}}
                                        </td>
                                        <td>
                                            {{getDivisionFromId($res->division_id)}}, 
                                        
                                            {{getDistrictFromId($res->district_id)}}, 
                                        
                                            {{getUpazilaFromId($res->upazila_id)}}, 
                                        
                                            {{getunionFromId($res->union_id)}}
                                        </td>
                                        

                                        <td><span class="badge badge-success">{{getStatusName($res->status)}}</span></td>
                                        <td>{{$res->created_at}}</td>

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