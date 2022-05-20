@extends('layouts.app')

@section('title', 'Agent Report')


@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">

            <h2>Order Report <span class="text-danger"></span></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Report</strong>
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

                    </div>


                    <div class="ibox-content">

                        <form role="form" action="/admin/order-report" method="post" class="form-inline"
                              style="margin-bottom: 10px">
                            <div class="form-group">
                                <select name="status" class="form-control m-b">

                                    @foreach (getStatusList() as $key => $value)

                                        @if($key!=11 && $key!=13 && $key!=14)

                                            <option value="{{ $key}}">{{$value}}</option>

                                        @endif

                                    @endforeach

                                </select>

                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            </div>
                            {{--  <div class="form-group">
                                  <input type="date" placeholder="To date" class="form-control" name="to" required>
                              </div>--}}
                            <div class="form-group">
                                <button class=" form-control btn btn-white" type="submit"
                                        style="    margin-top: -14px;">Export
                                </button>
                            </div>
                        </form>

                        <!--<input type="text" id="myInput" class="form-control pull-right"-->
                        <!--       style="width: 260px;margin-bottom: 10px"-->
                        <!--       onkeyup="tableSearch()" placeholder="Search for phone.." title="Type in a phone">-->


                        <div class="table-responsive" style="display: none">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>

                                    <th>Invoice</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Union</th>
                                    <th>Product</th>
                                    <th>Admin Remarks</th>
                                    <th>Supplier Remarks</th>
                                    <th>Shop</th>
                                    <th>DeliveryMan</th>
                                    <th>Update By</th>
                                    <th>Date</th>


                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr>

                                        <td>{{$res->invoice_number}}</td>
                                        <td>{{$res->name}}</td>
                                        <td>{{$res->phone}}</td>
                                        <td>{{$res->delivery_address}}</td>
                                        <td>{{getServiceFromId($res->service_type)}}</td>
                                        <td>{{getStatusName($res->status)}}</td>
                                        <td>{{getDivisionFromId($res->division_id)}}</td>
                                        <td>{{getDistrictFromId($res->district_id)}}</td>
                                        <td>{{getUpazilaFromId($res->upazila_id)}}</td>
                                        <td>{{getunionFromId($res->union_id)}}</td>
                                        <td>{{$res->product_list}}</td>
                                        <td>{{$res->admin_remarks}}</td>
                                        <td>{{$res->supplier_remarks}}</td>
                                        <td>
                                            @if(!is_null(getShopNameFromId($res->shop_id)))
                                                getShopNameFromId($res->shop_id)->shop_name
                                            @endif

                                        </td>
                                        <td>{{gettingDeliveryManFromId($res->delivery_man_id)}}</td>
                                        <td>{{getSupplierNameFromId($res->updated_by)}}</td>
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