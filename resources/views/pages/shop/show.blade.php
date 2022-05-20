@extends('layouts.app')

@section('title', 'Shops')


@section('content')

    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            margin: 0;
            white-space: nowrap;
            text-align: right;
            display: none;
        }

    </style>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Shops</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Shops</strong>
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
              {{--  <div class="ibox ">

                    <div class="ibox-content" ng-controller="supplierController">
                        <form class="form-horizontal" method="post" action="/admin/shops"
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

--}}
                <div class="ibox ">
                    <div class="ibox-title">
                        @if(Auth::user()->user_type==getSupplierId())
                            <a href="/admin/shop/create/{{Auth::user()->id}}" class="btn btn-sm btn-success">Add your
                                own shop</a>
                        @elseif(Auth::user()->user_type==getAdminId() || Auth::user()->user_type==getModeratorId())
                            @if(isset($user_id))
                                <a href="/admin/shop/create/{{$user_id}}" class="btn btn-sm btn-success">Add Shops</a>
                            @endif
                        @endif


                    </div>

                    <div class="ibox-content">
                        {{-- <input type="text" id="myInput" class="form-control pull-right" style="width: 260px;margin-bottom: 10px"
                                onkeyup="tableSearch()"
                                placeholder="Search for phone.." title="Type in a phone">--}}

                        <form role="form" action="/admin/shop-search" method="post" class="form-inline float-right"
                              style="margin-bottom: 10px">
                            <div class="form-group">
                                <input type="text" placeholder="Enter phone no." class="form-control" name="phone">
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            </div>

                            <button class="btn btn-white" type="submit">Search</button>
                        </form>

                        <div class="table-responsive ">
                            <table id="myTable"
                                   class="table table-striped table-bordered table-hover dataTables-example1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Volunteer Info</th>
                                    <!--<th>NID</th>-->
                                    <th>Shop Info</th>
                                    <th>Service Type</th>
                                    <th>Address</th>
                                    <!--<th>Serve Area</th>-->
                                    @if (Auth::user()->user_type != getModeratorId())
                                        <th>Action</th>
                                    @endif
                                    <th>Serve In</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = ($results->currentpage() - 1) * $results->perpage();?>

                                @foreach($results as $res)
                                    <tr class="">
                                        <td>{{$i++}}</td>
                                        <td class=""><a href="/admin/supplier/edit/{{$res->id}}"
                                                        target="_blank">{{$res->name}}</a><br>
                                            <small><strong>Phone:</strong> {{$res->phone}}</small>
                                        </td>
                                    <!--<td>{{$res->nid}}</td>-->
                                        <td>{{$res->shop_name}} <br>{{$res->shop_phone}}</td>
                                        <td>{{getServiceFromId($res->service_type)}}</td>


                                        <td>
                                            @if($res->address !='')
                                                {{$res->address}} |
                                            @endif
                                            {{getDivisionFromId($res->division_id)}}|

                                            @if($res->coverage_depth=="District")

                                                @foreach(explode(',', $res->district_id ) as $district)
                                                    {{getDistrictFromId($district)}},
                                                @endforeach
                                            @elseif($res->coverage_depth=="Upazila")
                                                {{getDistrictFromId($res->district_id)}}|
                                                @foreach(explode(',', $res->upazila_id ) as $upazila)
                                                    {{getUpazilaFromId($upazila)}},
                                                @endforeach
                                            @elseif($res->coverage_depth=="Union")
                                                {{getDistrictFromId($res->district_id)}}|
                                                {{getUpazilaFromId($res->upazila_id)}}|

                                                @foreach(explode(',', $res->union_id ) as $union)
                                                    {{getunionFromId($union)}},
                                                @endforeach

                                            @endif


                                        </td>

                                    <!--<td>@if($res->is_serve_in_depth) <span class="badge badge-success">Serve In Depth Only</span> @else-->
                                    <!--        <span class="badge badge-info">Serve Up to All</span>  @endif</td>-->


                                        {{--  @if (Auth::user()->user_type != getModeratorId())--}}
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-default btn-xs dropdown-toggle">Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                           href="/admin/shop/edit/{{$res->shop_id}}"
                                                           target="_blank">Edit</a>
                                                    </li>
                                                    <li>@if($res->is_active)
                                                            <a class="dropdown-item"
                                                               href="/admin/shop-status/{{$res->shop_id}}/0">Deactivate</a>
                                                        @else
                                                            <a class="dropdown-item"
                                                               href="/admin/shop-status/{{$res->shop_id}}/1">Activate</a>
                                                        @endif

                                                    </li>
                                                </ul>
                                            </div>

                                        </td>
                                        {{--     @endif--}}


                                        <td>{{$res->coverage_depth}}</td>


                                        <td>@if($res->is_active) <span class="badge badge-success">Active</span> @else
                                                <span class="badge badge-danger">Deactive</span>  @endif</td>


                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        {{$results->links()}}

                    </div>
                </div>
            </div>
        </div>
    </div>

{{--

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


    </script>--}}
@endsection