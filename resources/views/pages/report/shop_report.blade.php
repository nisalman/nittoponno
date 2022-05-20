@extends('layouts.app')

@section('title', 'Agent Report')


@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">

            <h2>Shop Report <span class="text-danger"></span></h2>
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


                    <div class="ibox-content" ng-controller="supplierController">

                        <form class="form-horizontal" method="post" action="/admin/shop-report"
                              enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-3" id="division_coverage">
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Division</label>
                                                <div class="col-lg-12">
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

                                        <div class="col-md-3" id="district_coverage" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">District</label>
                                                <div class="col-lg-12">

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


                                        <div class="col-md-2" id="upazila_coverage" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Upazila</label>
                                                <div class="col-lg-12">

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
                                                <label class="col-lg-3 control-label">Union</label>
                                                <div class="col-lg-12">

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

                                        <div class="col-md-1" id="union_coverage">
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">.</label>
                                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
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

                    });
            };

            $scope.changeDistrict = function (district) {
                console.log(district);

                $http.get("/upazila/" + district)

                    .then(function (response) {


                        $scope.upazilas = response.data.results;

                        console.log($scope.upazilas);

                        document.getElementById('upazila_coverage').style.display = 'block';

                    });
            };

            $scope.changeUpazila = function (upazila) {


                $http.get("/union/" + upazila)

                    .then(function (response) {


                        $scope.unions = response.data.results;
                        document.getElementById('union_coverage').style.display = 'block';
                        console.log($scope.unions);

                    });
            };

            $scope.changeUnion = function (union) {


                $http.get("/union/" + union)

                    .then(function (response) {


                        document.getElementById('union_coverage').style.display = 'block';
                        console.log($scope.unions);

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