@extends('layouts.app')



@section('title', 'Admin Home')



​



@section('content')



    ​



    <div class="wrapper wrapper-content">



        @if(session('success'))



            ​



            <div class="alert alert-success">{{session('success')}}!</div>



            ​



        @endif



        @if(session('failed'))



            <div class="alert alert-danger">



                {{session('failed')}}!



            </div>



        @endif



        ​



        ​



        <div class="row" ng-controller="supplierController">



            ​



            @if(Auth::user()->user_type!=getModeratorId())



                <div class="col-md-9">



                    {{--



                                        <div class="row">



                                            <div class="col-lg-3">



                                                <div class="widget style1 navy-bg">



                                                    <div class="row vertical-align">



                                                        <div class="col-3">



                                                            <h4>Total</h4>



                                                        </div>



                                                        <div class="col-9 text-right">



                                                            <h2 class="font-bold">{{gettingOrderCountByStatus("Total")}}</h2>



                                                        </div>



                                                    </div>



                                                </div>



                                            </div>







                                            <div class="col-lg-3">



                                                <div class="widget style1 yellow-bg">



                                                    <div class="row vertical-align">



                                                        <div class="col-3">



                                                            <h4>Pending</h4>



                                                        </div>



                                                        <div class="col-9 text-right">



                                                            <h2 class="font-bold">{{gettingOrderCountByStatus("Pending")}}</h2>



                                                        </div>



                                                    </div>



                                                </div>



                                            </div>



                                            <div class="col-lg-3">



                                                <div class="widget style1 lazur-bg">



                                                    <div class="row vertical-align">



                                                        <div class="col-3">



                                                            <h4>Delivered</h4>



                                                        </div>



                                                        <div class="col-9 text-right">



                                                            <h2 class="font-bold">{{gettingOrderCountByStatus("Delivered")}}</h2>



                                                        </div>



                                                    </div>



                                                </div>



                                            </div>











                                            <div class="col-lg-3">



                                                <div class="widget style1 yellow-bg">



                                                    <div class="row vertical-align">



                                                        <div class="col-3">



                                                            <h4>Cancelled</h4>



                                                        </div>



                                                        <div class="col-9 text-right">



                                                            <h2 class="font-bold">{{gettingOrderCountByStatus("Cancel Order")}}</h2>



                                                        </div>



                                                    </div>



                                                </div>



                                            </div>



                                        </div>











                                        <div class="row">







                                            <div class="col-lg-4">



                                                <div class="widget style1 navy-bg">



                                                    <div class="row vertical-align">



                                                        <div class="col-9">



                                                            <h4>Volunteer Assigned</h4>



                                                        </div>



                                                        <div class="col-3 text-right">



                                                            <h2 class="font-bold">{{gettingOrderCountByStatus("Supplier Assigned")}}</h2>



                                                        </div>



                                                    </div>



                                                </div>



                                            </div>



                                            <div class="col-lg-4">



                                                <div class="widget style1 lazur-bg">



                                                    <div class="row vertical-align">



                                                        <div class="col-9">



                                                            <h4>Can't Reach</h4>



                                                        </div>



                                                        <div class="col-3 text-right">



                                                            <h2 class="font-bold">{{gettingOrderCountByStatus("Retry")}}</h2>



                                                        </div>



                                                    </div>



                                                </div>



                                            </div>



                                            <div class="col-lg-4">



                                                <div class="widget style1 lazur-bg">



                                                    <div class="row vertical-align">



                                                        <div class="col-9">



                                                            <h4>Tran</h4>



                                                        </div>



                                                        <div class="col-3 text-right">



                                                            <h2 class="font-bold">{{gettingOrderCountByStatus("Tran")}}</h2>



                                                        </div>



                                                    </div>



                                                </div>



                                            </div>







                                        </div>



                                        <hr>--}}



                    <div class="row">





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--                        <span class="label label-primary float-right">Today</span>--}}



                                    <center><h5 class="text-center">Total Orders</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins" ng-cloak>{{--{{$total_order}}--}}



                                            @{{ total_order }}



                                        </h1></center>



                                    {{--<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>



                                    <small>New visits</small>--}}



                                </div>



                            </div>



                        </div>





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--                        <span class="label label-primary float-right">Today</span>--}}



                                    <center><h5 class="text-center">Processed Orders</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins" ng-cloak>



                                            @{{ processed_order }}





                                        </h1></center>



                                    {{--<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>



                                    <small>New visits</small>--}}



                                </div>



                            </div>



                        </div>



                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--<span class="label label-success float-right">Monthly</span>--}}



                                    <center><h5 class="text-center">Processed (%)</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins" ng-cloak>



                                            {{--   @{{ percentage_value}}--}}





                                            @{{ (percentage_value).toFixed(1) }}%





                                        </h1></center>



                                    ​



                                </div>



                            </div>



                        </div>





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--<span class="label label-success float-right">Monthly</span>--}}



                                    <center><h5 class="text-center">Pending Orders</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins" ng-cloak>



                                            @{{ pending_order }}





                                        </h1>



                                    </center>



                                    ​



                                </div>



                            </div>



                        </div>





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--<span class="label label-success float-right">Monthly</span>--}}



                                    <center><h5 class="text-center">Deliverey reported</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins" ng-cloak>





                                            @{{ delivered_order }}





                                        </h1>



                                    </center>



                                    ​



                                </div>



                            </div>



                        </div>





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--<span class="label label-success float-right">Monthly</span>--}}



                                    <center><h5 class="text-center">Cancelled Order</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins" ng-cloak>





                                            @{{cancelled_order }}





                                        </h1>



                                    </center>



                                    ​



                                </div>



                            </div>



                        </div>





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--<span class="label label-success float-right">Monthly</span>--}}



                                    <center><h5 class="text-center">Volunteer Assigned</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center>



                                        <h1 class="no-margins" ng-cloak>





                                            @{{ volunteer_assigned }}



                                        </h1>



                                    </center>



                                    ​



                                </div>



                            </div>



                        </div>





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-success">



                                    {{--<span class="label label-success float-right">Monthly</span>--}}



                                    <center><h5 class="text-center">Relief request</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins" ng-cloak>



                                            @{{ tran }}





                                        </h1></center>



                                    ​



                                </div>



                            </div>



                        </div>





                        <div class="col-md-4">



                            <div class="ibox ">





                                <form role="form" action="/admin/order-search" method="post"



                                      class="form-inline float-right ng-pristine ng-valid">



                                    <div class="form-group">



                                        <input type="date" placeholder="Phone / Order ID" class="form-control"



                                               name="date" ng-model="date" ng-change="changeDate(date)">



                                        <input type="hidden" class="form-control" name="_token"



                                               value="{{csrf_token()}}">



                                    </div>





                                </form>





                            </div>



                        </div>





                    </div>





                    <hr>



                    <div class="row">



                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-info">



                                    {{--<span class="label label-success float-right">Monthly</span>--}}



                                    <center><h5 class="text-center">Total Shop</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins">{{$total_shop}}</h1></center>



                                    ​



                                </div>



                            </div>



                        </div>



                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-info">



                                    {{--        <span class="label label-info float-right">Annual</span>--}}



                                    <center><h5 class="text-center">Total Volunteer</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins">{{$total_supplier}}</h1></center>



                                    {{--<div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>



                                    <small>New orders</small>--}}



                                </div>



                            </div>



                        </div>





                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-info">



                                    {{--                        <span class="label label-primary float-right">Today</span>--}}



                                    <center><h5 class="text-center">Total Union Covered</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins">{{$total_union_coverage}}</h1></center>



                                    {{--<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>



                                    <small>New visits</small>--}}



                                </div>



                            </div>



                        </div>



                        ​



                        <div class="col-lg-4">



                            <div class="ibox ">



                                <div class="ibox-title bg-info">



                                    {{--                        <span class="label label-primary float-right">Today</span>--}}



                                    <center><h5 class="text-center">volunteer has NID</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <center><h1 class="no-margins">{{$total_supplier_nid}}</h1></center>



                                    {{--<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>



                                    <small>New visits</small>--}}



                                </div>



                            </div>



                        </div>



                        ​



                        <div class="col-lg-4">



                          <a href="/admin/online-user">

                              <div class="ibox ">



                                  <div class="ibox-title bg-info">



                                      {{--                        <span class="label label-primary float-right">Today</span>--}}



                                      <center><h5 class="text-center">Online User <img class="pull-right"



                                                                                       src="/images/Greenlight.gif"/></h5>



                                      </center>



                                  </div>



                                  <div class="ibox-content">



                                      <center><h1 class="no-margins"><span



                                                      class="text-success">{{getTotalOnline()}}</span></h1></center>



                                      {{--<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>



                                      <small>New visits</small>--}}



                                  </div>



                              </div>

                          </a>



                        </div>



                        <div class="col-lg-4">





                              <div class="ibox ">



                                  <div class="ibox-title bg-info">



                                      {{--                        <span class="label label-primary float-right">Today</span>--}}



                                      <center><h5 class="text-center">Today's active user</h5>



                                      </center>



                                  </div>



                                  <div class="ibox-content">



                                      <center><h1 class="no-margins"><span



                                                      class="text-success">{{todaysOnlineUsers()}}</span></h1></center>



                                      {{--<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>



                                      <small>New visits</small>--}}



                                  </div>



                              </div>





                        </div>



                        ​



                        <div class="col-lg-12">



                            <div class="ibox ">



                                <div class="ibox-title bg-info">



                                    <center><h5>Login Analytics</h5></center>



                                </div>



                                <div class="ibox-content">



                                    <canvas id="myChart"></canvas>



                                </div>



                            </div>



                        </div>



                    </div>



                </div>



            @endif



            ​



            @if(Auth::user()->user_type==getModeratorId())



                <div class="col-md-9">



                    <div class="row">



                        Moderator Dashboard



                    </div>



                </div>



                ​



            @endif



            ​



            ​



            <div class="col-lg-3">



                ​



                ​



                <div class="ibox ">



                    <div class="ibox-heading">



                        <p>Login Info</p>



                    </div>



                    <div class="ibox-content">



                        <div class="feed-activity-list">



                            @foreach($histories as $history)



                                <div class="feed-element">



                                    <div>



                                        <small class="float-right"></small>



                                        <strong>{{$history->name}}</strong>



                                        <div class="text-muted">at {{getFormattedDate($history->updated_at)}}</div>



                                        <small class="text-muted">from {{$history->ip_address}}</small>



                                    </div>



                                </div>



                            @endforeach



                            ​



                            {{$histories->links()}}



                            ​



                        </div>



                    </div>



                    ​



                </div>



            </div>



            ​



            <div class="row">



                ​



            </div>



        </div>



    </div>



    <!--Login Data  Charts JS-->



    ​



    @include('includes.dashboard_analytics')







    <script>



        app.controller('supplierController', function ($scope, $http) {





            $scope.changeDate = function (date) {





                console.log(date + " hello");



                $scope.getStatuses(date);



            };





            $scope.getStatuses = function (date) {





                console.log(date + "hello");





                let url = "/admin/get-statuses/" + date;



                console.log(url);





                $http.get(url)



                    .then(function (response) {



                        $scope.total_order = response.data.total_order;



                        $scope.processed_order = response.data.processed_order;



                        $scope.pending_order = response.data.pending_order;



                        $scope.delivered_order = response.data.delivered_order;



                        $scope.tran = response.data.tran;



                        $scope.volunteer_assigned = response.data.volunteer_assigned;



                        $scope.cancelled_order = response.data.cancelled_order;





                        $scope.percentage_value = $scope.processed_order / $scope.total_order * 100;



                        console.log($scope.total_order);





                    });





            };



            $scope.getStatuses(420);





        });



    </script>



@endsection

















