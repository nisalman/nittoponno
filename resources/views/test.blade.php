@extends('layouts.app')

@section('title', 'All Volunteer')


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

                            <a href="/admin/orders/{{getCantDeliverStatusId('name')}}" class="btn btn-warning "
                               type="button"><i
                                        class="fa fa-warning"></i> <span class="bold">Can't Deliver</span></a>

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

                        <input type="text" id="myInput" class="form-control pull-right" style="width: 260px;margin-bottom: 10px"
                               onkeyup="tableSearch()"
                               placeholder="Search for phone.." title="Type in a phone">


                        <div class="{{--table-responsive--}}">
                            <table id="myTable"
                                   class="display table-responsive responsive nowrap table table-striped table-bordered table-hover "
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>

                                    <th>Order ID</th>
                                    <th>Phone</th>
                                    <th>Service Type</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                    <th>Call time</th>
                                    <th>Customer Name</th>
                                    <th>Product list</th>
                                    <th>Remarks</th>
                                    <th>Address</th>

                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Union</th>

                                    <th>Assigned volunteer</th>
                                    <th>Transport</th>

                                    <th>Changed By</th>
                                    <th>Last change datetime</th>

                                    {{-- <th>From Public</th>--}}


                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($result as $res)
                                    <tr class="gradeU">

                                        <td>{{$res->invoice_number}}</td>
                                        <td>{{$res->phone}}</td>
                                        <td>{{getServiceFromId($res->service_type)}}</td>
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


                                        <td>{{$res->time}}</td>
                                        <td>{{$res->name}}</td>
                                        <td>{{$res->product_list}}</td>
                                        <td>{{$res->admin_remarks}}</td>
                                        <td>{{$res->delivery_address}}</td>

                                        <td>{{getDivisionFromId($res->division_id)}}</td>
                                        <td>{{getDistrictFromId($res->district_id)}}</td>
                                        <td>{{getUpazilaFromId($res->upazila_id)}}</td>
                                        <td>{{getunionFromId($res->union_id)}}</td>
                                        <td>@if(getStatusName($res->status)=="Supplier Assigned")

                                                <a href="/admin/supplier-orders/{{getSupplierIdFromOrderId($res->order_id)}}">{{getSuppliernameFromOrderId($res->order_id)->name}}
                                                    , {{getSuppliernameFromOrderId($res->order_id)->phone}}</a>

                                            @endif
                                        </td>

                                        <td>
                                            @if($res->delivery_man_id!=null)
                                                {{gettingDeliveryManFromId($res->delivery_man_id)}}
                                            @endif

                                        </td>

                                        <td>
                                            @if($res->updated_by!=null)
                                                {{gettingUsernameFromId($res->updated_by)}}
                                            @endif

                                        </td>
                                        <td>{{getFormattedDate($res->updated_at)}}</td>


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
@endsection