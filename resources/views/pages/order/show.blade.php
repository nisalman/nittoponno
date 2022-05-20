@extends('layouts.app')


@section('title', 'Orders')





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

    <div class="wrapper wrapper-content animated fadeInRight" ng-controller="zonePopulateController">

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

                        <div class="ibox-content">


                            <form role="form" action="/admin/order-top-search" method="post" class="form-inline"

                                  style="margin-bottom: 10px">

                                <div class="form-group">

                                    <input type="date" placeholder="From date" class="form-control" name="from"

                                           required>

                                    <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">

                                </div>

                                <div class="form-group">

                                    <input type="date" placeholder="To date" class="form-control" name="to" required>

                                </div>


                                <div class="form-group">

                                    <select name="status" class="form-control">

                                        <option value="" selected>All Status</option>

                                        @foreach (getStatusList() as $key => $value)

                                            @if($key!=11 && $key!=13 && $key!=14)

                                                <option value="{{ $key}}">{{$value}}</option>

                                            @endif

                                        @endforeach

                                    </select>


                                </div>

                                <br>


                                <div class="col-md-3" id="division_coverage">

                                    <div class="form-group">


                                        <div class="col-lg-12">

                                            <input type="hidden" class="form-control" name="_token"

                                                   value="{{csrf_token()}}">


                                            <select name="division" class="form-control m-b"

                                                    ng-model="division_id"

                                                    ng-change="changeDivision(division_id)">


                                                <option value="" selected>All Division</option>

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

                                        <div class="col-lg-12">


                                            <select name="district" class="form-control m-b"

                                                    ng-model="district_id"

                                                    ng-change="changeDistrict(district_id)">


                                                <option value="" selected>All District</option>

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

                                        <div class="col-lg-12">


                                            <select name="upazila" class="form-control m-b"

                                                    ng-model="upazila_id"

                                                    ng-change="changeUpazila(upazila_id)">


                                                <option value="" selected>All Upazila</option>

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


                                <button class="btn btn-white" type="submit">Search</button>

                            </form>

                        </div>

                    </div>

                @endif


                <div class="ibox ">

                    <div class="ibox-title">


                        <p>

                            <a href="/admin/orders/All" class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-check"></i> <span

                                        class="bold">All @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Total")}})@endif </span></a>


                            @if(Auth::user()->user_type==1 )



                                <a href="/admin/orders/Pending" class="btn btn-light btn-xs btn-outline-secondary "

                                   type="button"><i

                                            class="fa fa-info"></i>&nbsp;Pending @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Pending")}})@endif </a>



                            @endif

                            <a href="/admin/orders/Hold" class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-hand-grab-o"></i>&nbsp;&nbsp;<span

                                        class="bold">Hold @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Hold")}}) @endif</span></a>

                            <a href="/admin/orders/Retry" class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-paste"></i> Retry @if(Auth::user()->user_type==getAdminId() )

                                    ({{gettingOrderCountByStatus("Retry")}}) @endif</a>

                            <a href="/admin/orders/Supplier Assigned"

                               class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-check"></i> <span

                                        class="bold">Volunteer Assigned @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Supplier Assigned")}}) @endif </span></a>

                            <a href="/admin/orders/Supplier Not Found"

                               class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-check"></i> <span

                                        class="bold">Volunteer Not Found @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Supplier Not Found")}}) @endif </span></a>


                            <a href="/admin/orders/{{getCantDeliverStatusId('name')}}"

                               class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-warning"></i> <span

                                        class="bold">Can't Deliver @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Can't Deliver")}}) @endif </span>

                            </a>


                            <a href="/admin/orders/Cancel Order"

                               class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-warning"></i> <span

                                        class="bold">Cancelled @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Cancel Order")}})@endif </span>

                            </a>


                            <a href="/admin/orders/Cancel"

                               class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-warning"></i> <span

                                        class="bold">Volunteer Cancelled @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Cancel")}})@endif </span>

                            </a>


                            <a href="/admin/orders/Delivered"

                               class="btn btn-light btn-xs btn-outline-secondary "

                               type="button"><i

                                        class="fa fa-warning"></i> <span

                                        class="bold">Delivered @if(Auth::user()->user_type==getAdminId() )

                                        ({{gettingOrderCountByStatus("Delivered")}}) @endif </span>

                            </a>


                        </p><br>


                        <p>

                            @if(Auth::user()->user_type==1 )



                                <a href="/admin/order-request" class="btn btn-primary " type="button"><i

                                            class="fa fa-check"></i> <span

                                            class="bold">Request data from order queue</span></a>



                            @endif


                            <a href="/admin/complain-orders" class="btn btn-info" type="button"><i

                                        class="fa fa-hand-grab-o"></i> <span

                                        class="bold">Complain ({{gettingOrderCountByStatus("Complain")}})</span></a>

                        </p>


                    </div>


                    <div class="ibox-content">


                        <form role="form" action="/admin/order-search" method="post" class="form-inline float-right"

                              style="margin-bottom: 10px">

                            <div class="form-group">

                                <input type="text" placeholder="Phone / Order ID" class="form-control" name="phone">

                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">

                            </div>


                            <button class="btn btn-white" type="submit">Search</button>

                        </form>


                        <!--<input type="text" id="myInput" class="form-control pull-right"-->

                        <!--       style="width: 260px;margin-bottom: 10px"-->

                        <!--       onkeyup="tableSearch()" placeholder="Search for phone.." title="Type in a phone">-->


                        <div class="table-responsive">

                            <table id="myTable"

                                   class="table  table-striped table-bordered table-hover "

                            >

                                <thead>

                                <tr>


                                    <th>Order ID</th>

                                    <th>Customer info</th>

                                    <th>Assigned volunteer</th>

                                    <th>Location & Product Note</th>

                                    <th>Status</th>

                                    <th>Action</th>


                                    <!--<th>Transport</th>-->


                                    {{-- <th>From Public</th>--}}


                                </tr>

                                </thead>

                                <tbody>

                                <?php $i = 1;?>

                                @foreach($result as $res)

                                    <tr class="gradeU">


                                        <td>{{$res->invoice_number}}</td>

                                        <td>{{$res->phone}}<br>

                                            <small><strong>Name:</strong> {{$res->name}}

                                                @if($res->time!='')

                                                    <br>

                                                    <strong>Called:</strong>{{$res->time}}

                                                @endif

                                                <br>

                                                <strong>Service type:</strong> {{getServiceFromId($res->service_type)}}

                                            </small>


                                        </td>


                                        <td>@if(getStatusName($res->status)=="Supplier Assigned"

                                        || getStatusName($res->status)=="Delivered"

                                        || getStatusName($res->status)=="Hold"

                                        || getStatusName($res->status)=="Retry"

                                        || getStatusName($res->status)=="Cancel Order"

                                        || getStatusName($res->status)=="Supplier Not Found"

                                        || getStatusName($res->status)=="Accept"

                                        || getStatusName($res->status)=="Cancel"

                                        || getStatusName($res->status)=="Can't Deliver")



                                                <a href="/admin/supplier-orders/{{getSupplierIdFromOrderId($res->order_id)}}">{{getSuppliernameFromOrderId($res->order_id)->name}}

                                                    , {{getSuppliernameFromOrderId($res->order_id)->phone}}</a><br>
                                                    
                                                    
                                        <small>

                                                    <strong>Agent: </strong> {{gettingUsernameFromId($res->updated_by)}}
                                                    <br>
                                        </small>            

                                            @endif
                                            
                                            <small><strong>updated at:</strong> {{getFormattedDate($res->updated_at)}} </small>
                                             

                                        </td>


                                        <td><strong> Location:</strong><br>

                                            {{$res->delivery_address}} |

                                            {{getDivisionFromId($res->division_id)}},

                                            {{getDistrictFromId($res->district_id)}},

                                            {{getUpazilaFromId($res->upazila_id)}},

                                            {{getunionFromId($res->union_id)}}

                                            <hr>

                                            <strong> Product:</strong><br>

                                            {{$res->product_list}}

                                            @if($res->admin_remarks !='')

                                                <br>

                                                <small><strong>Remarks:</strong> {{$res->admin_remarks}}</small>

                                            @endif

                                        </td>


                                        <td>

                                            @if(getStatusName($res->status)=="Hold")



                                                <span class="badge badge-warning ">{{getStatusName($res->status)}}</span>

                                                <br>



                                                <a href="/admin/order/release-order/{{$res->order_id}}">Release</a>



                                            @elseif(getStatusName($res->status)=="Pending")



                                                @if(Auth::user()->user_type==getAdminId())

                                                    <a href="/admin/order/{{$res->order_id}}"

                                                       class="badge badge-warning ">{{getStatusName($res->status)}}</a>

                                                @else

                                                    <span class="badge badge-warning ">{{getStatusName($res->status)}}</span>

                                                @endif



                                            @elseif(getStatusName($res->status)=="Retry")



                                                <a href="/admin/order/{{$res->order_id}}"

                                                   class="badge badge-warning ">{{getStatusName($res->status)}}</a>



                                            @elseif(getStatusName($res->status)=="Supplier Not Found")



                                                <a href="/admin/order/{{$res->order_id}}"

                                                   class="badge badge-warning ">Volunteer Not Found</a>



                                            @elseif(getStatusName($res->status)=="Supplier Assigned")



                                                <span class="badge-success badge">Volunteer Assigned</span>

                                                {{--  <br>



                                                  <a href="/admin/supplier-orders/{{getSupplierIdFromOrderId($res->order_id)}}">{{getSuppliernameFromOrderId($res->order_id)}}</a>

  --}}

                                            @elseif(getStatusName($res->status)=="Cancel Order")



                                                <span class="badge-danger badge">Cancelled</span>



                                            @elseif(getStatusName($res->status)=="Cancel")



                                                <span class="badge-danger badge">Cancelled By Volunteer</span>



                                            @else

                                                <span class="badge-success badge">{{getStatusName($res->status)}}</span>

                                            @endif

                                        </td>

                                        <td>

                                            <div class="btn-group">

                                                <button data-toggle="dropdown"

                                                        class="btn btn-default btn-xs dropdown-toggle">Action

                                                </button>

                                                <ul class="dropdown-menu">

                                                    <li><a class="dropdown-item"

                                                           href="/admin/order/edit/{{$res->order_id}}">Edit</a></li>

                                                    {{--   <li><a class="dropdown-item"

                                                              href="/admin/order/delete/{{$res->order_id}}">Delete</a></li>--}}

                                                </ul>

                                            </div>


                                            @if($res->status==getSupplierAssignedId("id"))

                                                <a href="#" class="btn btn-primary btn-xs" data-toggle="modal"

                                                   data-target="#p{{$res->order_id}}">Dispute</a>

                                            @endif

                                            <div class="modal" id="p{{$res->order_id}}">

                                                <div class="modal-dialog">

                                                    <div class="modal-content">


                                                        <!-- Modal body -->

                                                        <div class="modal-body">

                                                            <form class="form-horizontal" method="post"

                                                                  action="/admin/order/dispute"

                                                                  enctype="multipart/form-data">


                                                                <div class="form-group">

                                                                    <label class="col-lg-12 control-label">Remarks</label>

                                                                    <div class="col-lg-12">

                                                                        <input type="hidden" class="form-control"

                                                                               name="_token"

                                                                               value="{{csrf_token()}}">

                                                                        <input type="hidden" class="form-control"

                                                                               name="order_id"

                                                                               value="{{$res->order_id }}">


                                                                        <textarea name="admin_remarks"

                                                                                  class="form-control"

                                                                                  required

                                                                                  rows="5">{{$res->admin_remarks}}</textarea>


                                                                    </div>

                                                                </div>


                                                                <div class="form-group row">

                                                                    <div class="col-lg-12">

                                                                        <button type="submit"

                                                                                class="btn btn-sm btn-primary">Dispute

                                                                        </button>

                                                                    </div>

                                                                </div>


                                                            </form>

                                                        </div>


                                                    </div>

                                                </div>

                                            </div>


                                            @if($res->image!=null)

                                                <a href="/admin/"

                                                   class="btn btn-default btn-xs">Image

                                                </a>

                                            @endif


                                        </td>


                                        <!--<td>-->

                                    <!--    @if($res->delivery_man_id!=null)-->

                                    <!--        {{gettingDeliveryManFromId($res->delivery_man_id)}}-->

                                        <!--    @endif-->



                                        <!--</td>-->









                                        {{--   <td>@if($res->is_duplicate) <span class="badge badge-warning">Yes</span> @else

                                                   <span class="badge badge-success">No</span>@endif </td>

   --}}


                                    </tr>



                                @endforeach

                                </tbody>


                            </table>

                        </div>


                        {{ $result->links()  }}


                    </div>

                </div>

            </div>

        </div>

    </div>





    <script>


        function tableSearch() {

            var input, filter, table, tr, td, i, txtValue;

            input = document.getElementById("myInput");

            filter = input.value.toUpperCase();

            table = document.getElementById("myTable");

            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {

                td = tr[i].getElementsByTagName("td")[1];

                if (td) {

                    txtValue = td.textContent || td.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {

                        tr[i].style.display = "";

                    } else {

                        tr[i].style.display = "none";

                    }

                }

            }

        }


    </script>



    <script>


        app.controller('zonePopulateController', function ($scope, $http) {

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