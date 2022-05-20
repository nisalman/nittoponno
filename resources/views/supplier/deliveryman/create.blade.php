@extends('layouts.supplier')

@section('title', 'Upload Supplier')


@section('content')
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


                @if(Auth::user()->user_type==getAdminId())
                    <div class="ibox ">
                        <h4>Upload CSV</h4>
                        <div class="ibox-content" ng-controller="supplierController">

                            <form class="form-horizontal" method="post" action="/supplier/deliveryman/csv-store"
                                  enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-6" id="division_coverage">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Division</label>
                                                    <div class="col-lg-9">
                                                        <input type="hidden" class="form-control" name="_token"
                                                               value="{{csrf_token()}}">


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

                                            <div class="col-md-6" id="district_coverage" style="display: none;">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">District</label>
                                                    <div class="col-lg-9">

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


                                            <div class="col-md-6" id="upazila_coverage" style="display: none;">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Upazila</label>
                                                    <div class="col-lg-9">

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


                                            <div class="col-md-6" id="union_coverage" style="display: none;">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Select Union</label>
                                                    <div class="col-lg-9">

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
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">CSV File</label>
                                                    <div class="col-lg-6">
                                                        <input type="hidden" class="form-control" name="_token"
                                                               value="{{csrf_token()}}">
                                                        <input type="file" class="form-control" name="csvfile"
                                                               required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label class="col-lg-8 control-label"></label>
                                                    <div class="col-lg-4">
                                                        <button type="submit" class="btn btn-block btn-sm btn-primary">
                                                            Upload
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                @endif

                @if(Auth::user()->user_type==getSupplierId() || Auth::user()->user_type==getModeratorId())
                    <div class="ibox ">
                        <h4>Add Transport</h4>
                        <div class="ibox-content" ng-controller="supplierController">

                            <form class="form-horizontal" method="post" action="/supplier/deliveryman/store"
                                  enctype="multipart/form-data">


                                <div class="form-group row">
                                    <label class="col-lg-2 control-label">Select Shop</label>
                                    <div class="col-lg-10">

                                        <select name="shop_id" class="form-control m-b">

                                            @foreach ($shops as $shop)
                                                <option value="{{ $shop->shop_id}}">@if($shop->shop_name!=null){{$shop->shop_name}} @else No Name @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-lg-2 control-label">Name</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                        <input type="text" placeholder="Full Name" class="form-control" name="name"
                                               required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-lg-2 control-label">Phone</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Phone" class="form-control" name="phone"
                                               required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-lg-2 control-label"></label>
                                    <div class="col-lg-10">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>


    <script>

        app.controller('supplierController', function ($scope, $http) {
            $scope.coverage_depth = "Division";
            $scope.division = "";
            $scope.union_id = "";


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


            //Getting Divisions

            $http.get("/division")

                .then(function (response) {


                    $scope.divisions = response.data.results;

                    console.log($scope.divisions);

                });


        });


    </script>

@endsection