@extends('layouts.app')

@section('title', 'Create Shop')


@section('content')

    <h3>Create Shop for: {{$user->name}}</h3>
    <hr>

    <div class="col-sm-12">
        @if(session('success'))

            <div class="alert alert-success">{{session('success')}}!</div>

        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{session('failed')}}!
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel panel-default" ng-controller="supplierController">
            <div class="panel-heading">New Shop</div>

            <div class="panel-body">

                <form class="form-horizontal" method="post" action="/admin/shop/store"
                      enctype="multipart/form-data">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Shop Name</label>
                                <div class="col-lg-9">

                                    <input type="text" class="form-control" name="shop_name" required>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Shop Contact Number</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="shop_phone" maxlength="14"
                                           minlength="10">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Address</label>
                                <div class="col-lg-9">
                                    <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" class="form-control" name="user_id" value="{{$user_id}}">

                                    <textarea class="form-control" name="address"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Service Type</label>
                                <div class="col-lg-9">
                                    <select name="service_type" class="form-control m-b">

                                        @foreach (getServiceType() as $key => $value)
                                            <option value="{{ $key}}">{{$value}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Per Day capacity</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control" name="per_day_capacity" required>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-lg-3 control-label">I serve in</label>
                                <div class="col-lg-9">
                                    <label>
                                        <select name="coverage_depth" class="form-control m-b" ng-model="coverage_depth"
                                                ng-change="coverageDepth(coverage_depth)">

                                            @foreach (getCoverageDepth() as $key => $value)
                                                <option value="{{ $key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-3" id="division_coverage">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Division</label>
                                <div class="col-lg-9">
                                    <select name="division" class="form-control m-b" ng-model="division_id"
                                            ng-change="changeDivision(division_id)">

                                        <option value="" selected>Select Division</option>
                                        <option ng-repeat="division in divisions" value="@{{division.division_id}}">
                                            @{{division.en_name}}
                                        </option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" id="district_coverage" style="display: none;">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">District</label>
                                <div class="col-lg-9">

                                    <select name="district" class="form-control m-b" ng-model="district_id"
                                            ng-change="changeDistrict(district_id)">

                                        <option value="" selected>Select District</option>
                                        <option ng-repeat="district in districts" value="@{{district.district_id}}">
                                            @{{district.en_name}}
                                        </option>

                                    </select>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" id="district_coverage2" style="display: none;">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">District</label>
                                <div class="col-lg-9">

                                    <div class="checkbox checkbox-success" ng-repeat="district in districts">
                                        <input id="checkbox@{{ district.district_id }}" name="district_list[]"
                                               value="@{{ district.district_id }}" type="checkbox">
                                        <label for="checkbox@{{ district.district_id }}">
                                            @{{ district.en_name }}
                                        </label>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" id="upazila_coverage" style="display: none;">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Upazila</label>
                                <div class="col-lg-9">

                                    <select name="upazila" class="form-control m-b" ng-model="upazila_id"
                                            ng-change="changeUpazila(upazila_id)">

                                        <option value="" selected>Select Upazila</option>
                                        <option ng-repeat="upazila in upazilas" value="@{{upazila.upazila_id}}">
                                            @{{upazila.en_name}}
                                        </option>

                                    </select>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" id="upazila_coverage2" style="display: none;">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Upazila</label>
                                <div class="col-lg-9">

                                    <div class="checkbox checkbox-success" ng-repeat="upazila in upazilas">
                                        <input id="checkbox@{{ upazila.upazila_id }}" name="upazila_list[]"
                                               type="checkbox" value="@{{ upazila.upazila_id }}">
                                        <label for="checkbox@{{ upazila.upazila_id }}">
                                            @{{ upazila.en_name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3" id="union_coverage" style="display: none;">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Select Union</label>
                                <div class="col-lg-9">

                                    <div class="checkbox checkbox-success" ng-repeat="union in unions">
                                        <input id="checkbox@{{ union.union_id }}" name="union_list[]"
                                               value="@{{ union.id }}" type="checkbox">
                                        <label for="checkbox@{{ union.union_id }}">
                                            @{{ union.en_name }}
                                        </label>
                                    </div>

                                    {{--
                                                                        <select name="union" class="select2_demo_2 form-control m-b" ng-model="union_id"
                                                                                multiple="multiple">

                                                                            <option value="" selected>Select Union</option>
                                                                            <option ng-repeat="union in unions" value="@{{union.id}}">
                                                                                @{{union.en_name}}
                                                                            </option>

                                                                        </select>--}}


                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" id="union_coverage" style="display: none;">
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Union</label>
                                <div class="col-lg-9">
                                    <div class="checkbox checkbox-success" ng-repeat="union in unions">
                                        <input id="checkbox@{{ union.id }}" name="union_list[]" type="checkbox">
                                        <label for="checkbox@{{ union.id }}">
                                            @{{ union.en_name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">


                            <div class="form-group row">
                                <label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9">

                                    <div class="checkbox checkbox-success">
                                        <input id="kk" name="is_serve_in_depth"
                                               value="1" type="checkbox" checked>
                                        <label for="k">
                                            I only serve here
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-8 control-label"></label>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-block btn-sm btn-primary">Save</button>

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
            $scope.coverage_depth = "Division";
            $scope.division = "";
            $scope.union_id = "";

            $scope.coverageDepth = function (coverage_depth) {

                if (coverage_depth == "Division") {

                    document.getElementById('district_coverage').style.display = 'block';
                    document.getElementById('district_coverage2').style.display = 'none';
                    document.getElementById('upazila_coverage').style.display = 'none';
                    document.getElementById('upazila_coverage2').style.display = 'none';
                    document.getElementById('union_coverage').style.display = 'none';


                } else if (coverage_depth == "District") {
                    document.getElementById('district_coverage').style.display = 'none';
                    document.getElementById('district_coverage2').style.display = 'block';
                    document.getElementById('upazila_coverage').style.display = 'none';
                    document.getElementById('upazila_coverage2').style.display = 'none';
                    document.getElementById('union_coverage').style.display = 'none';

                } else if (coverage_depth == "Upazila") {

                    document.getElementById('district_coverage').style.display = 'block';
                    document.getElementById('district_coverage2').style.display = 'none';
                    document.getElementById('upazila_coverage').style.display = 'none';
                    document.getElementById('upazila_coverage2').style.display = 'block';
                    document.getElementById('union_coverage').style.display = 'none';


                } else if (coverage_depth == "Union") {

                    document.getElementById('district_coverage').style.display = 'block';
                    document.getElementById('district_coverage2').style.display = 'none';
                    document.getElementById('upazila_coverage').style.display = 'block';
                    document.getElementById('upazila_coverage2').style.display = 'none';
                    document.getElementById('union_coverage').style.display = 'block';

                }
            };

            $scope.changeDivision = function (division_id) {


                $http.get("/district/" + division_id)

                    .then(function (response) {


                        $scope.districts = response.data.results;

                        console.log($scope.districts);

                    });
            };

            $scope.changeDistrict = function (district) {
                console.log(district);

                $http.get("/upazila/" + district)

                    .then(function (response) {


                        $scope.upazilas = response.data.results;

                        console.log($scope.upazilas);

                    });
            };

            $scope.changeUpazila = function (upazila) {


                $http.get("/union/" + upazila)

                    .then(function (response) {


                        $scope.unions = response.data.results;

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