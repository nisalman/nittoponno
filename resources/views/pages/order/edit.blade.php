@extends('layouts.app')

@section('title', 'All Supplier')


@section('content')
    <script src="/multiselect/jquery-1.11.3.min.js"></script>
    <script src="/multiselect/jquery-ui.min.js"></script>
    <script src="/multiselect/jquery.multilineSelectmenu.js"></script>
    <link rel="stylesheet" href="/multiselect/jquery-ui.css">
    <link rel="stylesheet" href="/multiselect/jquery.multilineSelectmenu.css">

    <style>
        .ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
            border-bottom-right-radius: 4px;
            background: #ffff;
            color: black;
        }
    </style>




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


                <div class="ibox">
                    <div class="ibox-content">
                        {{--<p> Name: {{$result->name}}</p>
                        <p> Phone: {{$result->phone}}</p>

                        <p> Service Type: {{getServiceFromId($result->service_type)}}</p>--}}


                        {{--   <button type="submit" class="btn btn-sm btn-primary">
                               Cant Reach
                           </button>
--}}
                        <button type="submit" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#retryModal">
                            Retry
                        </button>
                       {{-- <button type="submit" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#smsModal">
                            Send Sms
                        </button>--}}

                        <div id="retryModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form-horizontal" method="post" action="/admin/order/status-change"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="form-control" name="_token"
                                                   value="{{csrf_token()}}">
                                            <input type="hidden" class="form-control" name="order_id"
                                                   value="{{$order_id}}">
                                            <input type="hidden" class="form-control" name="status"
                                                   value="3">

                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label">Remarks</label>
                                                <div class="col-lg-9">
                                                    <textarea type="text" class="form-control"
                                                              name="admin_remarks"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label"></label>
                                                <div class="col-lg-9">
                                                    <button type="submit" class="btn btn-sm ">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal" id="smsModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">SMS</h4>
                                        <button type="button" class="close"
                                                data-dismiss="modal">&times;
                                        </button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form class="form-horizontal" method="post" action="/admin/order/send-sms"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="form-control" name="_token"
                                                   value="{{csrf_token()}}">
                                            <input type="hidden" class="form-control" name="phone"
                                                   value="{{$result->phone}}">
                                            <input type="hidden" class="form-control" name="order_id"
                                                   value="{{$result->order_id}}">

                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <textarea type="text" class="form-control"
                                                              name="sms">{{getRetryMessage($result->invoice_number)}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-lg-4 pull-right">
                                                    <button type="submit" class="btn btn-sm ">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <form class="form-horizontal" method="post" action="/admin/order/update"
                      enctype="multipart/form-data">


                    <div class="ibox ">
                        <h4>Customer Info</h4>
                        <div class="ibox-content" ng-controller="supplierController">


                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Name</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control" name="name"
                                                           value="{{$result->name}}">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Phone</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control" name="phone"
                                                           value="{{$result->phone}}">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Service Type</label>
                                                <div class="col-lg-12">
                                                    <select name="service_type" ng-model="service_type"
                                                            class="form-control m-b"
                                                            ng-change="serviceChange(service_type)">

                                                        @foreach (getServiceType() as $key => $value)
                                                            <option value="{{ $key}}"
                                                                    @if($result->service_type==$key) checked @endif>{{$value}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox ">
                        <h4>Choose Location</h4>
                        <div class="ibox-content" ng-controller="supplierController">


                            <div class="row">
                                <div class="col-md-12">


                                    <div class="row">

                                        <div class="col-md-3" id="division_coverage">
                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Division</label>
                                                <div class="col-lg-6">
                                                    <input type="hidden" class="form-control" name="_token"
                                                           value="{{csrf_token()}}">
                                                    <input type="hidden" id="is_cancelled" class="form-control"
                                                           name="is_cancelled"
                                                           value="0">
                                                    <input type="hidden" id="is_tran" name="is_tran" value="0">
                                                    <input type="hidden" id="is_supplier_available" class="form-control"
                                                           name="is_supplier_available"
                                                           value="1">

                                                    <input type="hidden" class="form-control" name="order_id"
                                                           value="{{$order_id}}">


                                                    <select name="division" class="form-control m-b"
                                                            ng-model="division_id"
                                                            ng-change="changeDivision(division_id)">

                                                        <option value="" selected>Select Division</option>
                                                        <option ng-repeat="division in divisions"
                                                                value="@{{division.division_id}}">
                                                            @{{division.en_name}}
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" id="district_coverage" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">District</label>
                                                <div class="col-lg-6">

                                                    <select name="district" class="form-control m-b"
                                                            ng-model="district_id"
                                                            ng-change="changeDistrict(district_id)">

                                                        <option value="" selected>Select District</option>
                                                        <option ng-repeat="district in districts"
                                                                value="@{{district.district_id}}">
                                                            @{{district.en_name}}
                                                        </option>

                                                    </select>


                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3" id="upazila_coverage" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Upazila</label>
                                                <div class="col-lg-6">

                                                    <select name="upazila" class="form-control m-b"
                                                            ng-model="upazila_id"
                                                            ng-change="changeUpazila(upazila_id)">

                                                        <option value="" selected>Select Upazila</option>
                                                        <option ng-repeat="upazila in upazilas"
                                                                value="@{{upazila.upazila_id}}">
                                                            @{{upazila.en_name}}
                                                        </option>

                                                    </select>


                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3" id="union_coverage" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Select Union</label>
                                                <div class="col-lg-6">

                                                    <select name="union" class="form-control m-b"
                                                            ng-model="union_id" ng-change="changeUnion(union_id)">

                                                        <option value="" selected>Select Union</option>
                                                        <option ng-repeat="union in unions"
                                                                value="@{{union.id}}">
                                                            @{{union.en_name}}
                                                        </option>

                                                    </select>


                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label">Volunteer</label>
                                                <div class="col-lg-9">

                                                    <select name="supplier_id" class="form-control m-b"
                                                            ng-model="supplier_id"
                                                            ng-change="checkAvailability(supplier_id)" id="select" >

                                                        <option value="" selected>Select Volunteer</option>
                                                        <option ng-repeat="supplier in suppliers"
                                                                value="@{{supplier.shop_id}}">

                                                           @{{supplier.name}}|
                                                            @{{supplier.shop_name}}|
                                                            @{{supplier.phone}} |

                                                            Assigned: @{{supplier.today_assigned}}, 
                                                            Delivered: @{{supplier.today_delivered}}, 
                                                            Cancelled: @{{supplier.today_cancelled}}, 

                                                        </option>

                                                    </select>


                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12" id="division_coverage">
                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label">Product List</label>
                                                <div class="col-lg-9">

                                                    <textarea type="hidden" class="form-control"
                                                              name="product_list"
                                                              rows="7">{{$result->product_list}}</textarea>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="division_coverage">
                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label">Address</label>
                                                <div class="col-lg-9">

                                                    <textarea type="hidden" class="form-control"
                                                              name="address"
                                                              rows="2">{{$result->delivery_address}}</textarea>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="division_coverage">
                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label">Remarks</label>
                                                <div class="col-lg-9">

                                                    <textarea class="form-control"
                                                              name="admin_remarks"
                                                              rows="2">{{$result->admin_remarks}}</textarea>

                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn btn-block btn-sm btn-primary">
                                                        Re Assign Order
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn btn-sm btn-danger btn-xs"
                                                            onclick="cancel()">
                                                        Cancel Order
                                                    </button>
                                                    <button type="submit" class="btn btn-sm btn-info btn-xs"
                                                            onclick="unsetSupplier()">
                                                        Volunteer Not Available
                                                    </button>

                                                    <button type="submit" class="btn btn-sm btn-warning btn-xs"
                                                            onclick="setTran()">
                                                        Relief
                                                    </button>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>

        app.controller('supplierController', function ($scope, $http) {


            $scope.service_type = "<?php echo $result->service_type ?>";

            document.getElementById('district_coverage').style.display = 'block';
            document.getElementById('upazila_coverage').style.display = 'block';
            document.getElementById('union_coverage').style.display = 'block';

            let service_type = $scope.service_type;


            $scope.changeDivision = function (division_id) {



                $http.get("/district/" + division_id)

                    .then(function (response) {


                        $scope.districts = response.data.results;

                        console.log($scope.districts);
                        document.getElementById('district_coverage').style.display = 'block';
                        $scope.getSuppliers("division", division_id);

                    });
            };

            $scope.changeDistrict = function (district) {
                console.log(district);

                $http.get("/upazila/" + district)

                    .then(function (response) {


                        $scope.upazilas = response.data.results;

                        console.log($scope.upazilas);

                        document.getElementById('upazila_coverage').style.display = 'block';
                        $scope.getSuppliers("district", district);

                    });
            };

            $scope.changeUpazila = function (upazila) {


                $http.get("/union/" + upazila)

                    .then(function (response) {


                        $scope.unions = response.data.results;
                        document.getElementById('union_coverage').style.display = 'block';
                        console.log($scope.unions);
                        $scope.getSuppliers("upazila", upazila);

                    });
            };

            $scope.changeUnion = function (union) {


                $http.get("/union/" + union)

                    .then(function (response) {


                        document.getElementById('union_coverage').style.display = 'block';
                        console.log($scope.unions);
                        $scope.getSuppliers("union", union);

                    });
            };

            $scope.serviceChange = function (service_type) {

                // console.log($scope.service_type + "---");
                service_type = $scope.service_type;


                console.log($scope.service_type + "---" + service_type);
            };
            $scope.getSuppliers = function (area_type, area_id) {

                console.log($scope.service_type + "HOHO"+service_type);

                let url = "/get-suppliers/" + area_type + "/" + area_id + "/" + service_type;
                console.log(url);
                $http.get(url)

                    .then(function (response) {
                        $scope.suppliers = response.data.results;
                        console.log($scope.suppliers);

                    });
            };


            $scope.checkAvailability = function (shop_id) {

                let url = "/check-shop-capacity/" + shop_id;
                $http.get(url)

                    .then(function (response) {

                        if (!response.data.is_available) {

                            confirm("This supplier has reached today\'s maximum capacity");
                        }
                        console.log(response.data.is_available);

                    });

            };





            //Getting Divisions

            $http.get("/division")

                .then(function (response) {


                    $scope.divisions = response.data.results;

                    console.log($scope.divisions);

                });


            $scope.division_id = "<?php echo $result->division_id?>";
            if ($scope.division_id) {
                console.log("init");
                $scope.changeDivision(<?php echo $result->division_id?>);
            }


            $scope.district_id = "<?php echo $result->district_id?>";
            if ($scope.district_id) {
                console.log("init");
                $scope.changeDistrict(<?php echo $result->district_id?>);
            }


            $scope.upazila_id = "<?php echo $result->upazila_id?>";
            if ($scope.upazila_id) {
                console.log("init");
                $scope.changeUpazila(<?php echo $result->upazila_id?>);
            }


            $scope.union_id = "<?php echo $result->union_id?>";
            $scope.supplier_id = "<?php echo $result->shop_id?>";


        });


        function cancel() {

            document.getElementById("is_cancelled").value = 1;
        }

        function unsetSupplier() {

            document.getElementById("is_supplier_available").value = 0;
        }

        function setTran() {

            document.getElementById("is_supplier_available").value = 0;
            document.getElementById("is_tran").value = 1
        }


    </script>
    <script>
        // $("#select").multilineSelectmenu();

    </script>
@endsection