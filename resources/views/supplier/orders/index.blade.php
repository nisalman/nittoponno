@extends('layouts.supplier')


@section('title', 'Volunteers')





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


                        @if(count($shops)>4)



                            <form class="form-horizontal" method="post" action="/supplier/shop-search"

                                  enctype="multipart/form-data">


                                <div class="form-group row">

                                    <div class="col-lg-5">

                                        <input type="hidden" class="form-control" name="_token"

                                               value="{{csrf_token()}}">


                                        <select name="shop_id" class="form-control m-b">


                                            @foreach($shops as $shop)

                                                <option value="{{$shop->shop_id}}">

                                                    @if($shop->shop_name==null)

                                                        {{getServiceFromId($shop->service_type)}}



                                                    @else

                                                        {{$shop->shop_name}}

                                                    @endif

                                                </option>



                                            @endforeach


                                        </select>


                                    </div>

                                    <label class="col-lg-2 control-label">

                                        <button type="submit" class="btn btn-sm btn-primary">Search</button>

                                    </label>

                                </div>


                            </form>



                        @else

                            <p>

                                @foreach($shops as $shop)

                                    <a href="/supplier/shop/{{$shop->shop_id}}" class="btn btn-success "

                                       type="button">

                                        @if($shop->shop_name==null)

                                            {{getServiceFromId($shop->service_type)}}



                                        @else

                                            {{$shop->shop_name}}

                                        @endif

                                    </a>

                                @endforeach



                                @if(Auth::user()->user_type!=getModeratorId() )

                                    <a href="/supplier/shop/All" class="btn btn-success "

                                       type="button">

                                        All

                                    </a>

                                @endif

                            </p>



                        @endif

                        @if(Auth::user()->user_type==getModeratorId() )

                        <!--

                            <a href="/supplier/orders/Pending" class="btn btn-warning " type="button"><i

                                        class="fa fa-info"></i>&nbsp;Pending</a>



                            <a href="/supplier/orders/Hold" class="btn btn-danger " type="button"><i

                                        class="fa fa-hand-grab-o"></i>&nbsp;&nbsp;<span class="bold">Hold</span></a>

                            <a href="/supplier/orders/Retry" class="btn btn-warning " type="button"><i

                                        class="fa fa-paste"></i> Retry</a>





                            <a href="/supplier/orders/Supplier Assigned" class="btn btn-info " type="button"><i

                                        class="fa fa-check"></i> <span class="bold">Volunteer Assigned</span></a>



                            <a href="/supplier/orders/{{getCantDeliverStatusId('name')}}" class="btn btn-warning "

                               type="button"><i

                                        class="fa fa-warning"></i> <span class="bold">Can't Deliver</span></a>

 -->

                            <a href="/supplier/shop/All" class="btn btn-primary " type="button"><i

                                        class="fa fa-check"></i> <span class="bold">All</span></a>

                        @endif


                    </div>

                    <div class="ibox-content">


                        {{-- <input type="text" id="myInput" class="form-control pull-right" style="width: 260px;margin-bottom: 10px"

                                onkeyup="tableSearch()"

                                placeholder="Search for phone.." title="Type in a phone">--}}


                        <form role="form" action="/supplier/order-search" method="post" class="form-inline float-right"

                              style="margin-bottom: 10px">

                            <div class="form-group">

                                <input type="text" placeholder="search by phone no" class="form-control" name="phone">

                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">

                            </div>


                            <button class="btn btn-white" type="submit">Search</button>

                        </form>


                        <div class="{{--table-responsive--}}">

                            <table class="table table-striped table-bordered table-hover" id="myTable">

                                <thead>

                                <tr>

                                    <th>Order ID</th>

                                    <th>Phone</th>

                                    <th>Service Type</th>

                                    <th>Shop</th>

                                    <th>Status</th>

                                    <th>Date</th>

                        {{--            @if (Auth::user()->user_type != getModeratorId())--}}

                                        <th>Action</th>

                       {{--             @endif--}}


                                    <th>Customer name</th>

                                    <th>Product List</th>

                                    <th>Remarks</th>

                                    <th>Address</th>

                                    <th>Transport</th>

                                    <th>Changed By</th>

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

                                            @if($res->shop_id!=null)

                                                {{getShopNameFromId($res->shop_id)->shop_name}}

                                            @else

                                                Not Assigned

                                            @endif


                                        </td>

                                        <td>

                                            @if(getStatusName($res->status)=="Hold")



                                                <span class="badge badge-warning ">{{getStatusName($res->status)}}</span>

                                                <br>

                                                @if (Auth::user()->user_type != getModeratorId() && Auth::user()->user_type != getSupplierId())

                                                    <a href="/admin/order/release-order/{{$res->order_id}}">Release</a>

                                                @endif



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



                                            @elseif(getStatusName($res->status)=="Supplier Assigned")



                                                <span class="badge-success badge">{{getStatusName($res->status)}}</span>

                                                <br>



                                                <a href="/admin/supplier-orders/{{getSupplierIdFromOrderId($res->order_id)}}">{{getSuppliernameFromOrderId($res->order_id)->name}}</a>



                                            @elseif(getStatusName($res->status)=="Cancel Order")



                                                <span class="badge-danger badge">Cancelled</span>



                                            @else

                                                <span class="badge-success badge">{{getStatusName($res->status)}}</span>

                                            @endif

                                        </td>

                                        <td>{{getFormattedDate($res->updated_at)}}</td>

                                      {{--  @if (Auth::user()->user_type != getModeratorId())
--}}
                                            <td>

                                                <div class="btn-group">

                                                    <button data-toggle="dropdown"

                                                            class="btn btn-default btn-xs dropdown-toggle">Action

                                                    </button>


                                                    <ul class="dropdown-menu">

                                                        <li><a class="dropdown-item"

                                                               href="/supplier/update-order-status/{{$res->order_id}}/{{getStatusIdFromName("Accept")}}">Accept</a>

                                                        </li>


                                                        <li><a class="dropdown-item"

                                                               href="/supplier/update-order-status/{{$res->order_id}}/{{getStatusIdFromName("Cancel")}}">Cancel</a>

                                                        </li>


                                                        <li><a class="dropdown-item"

                                                               href="/supplier/update-order-status/{{$res->order_id}}/{{getStatusIdFromName("Delivered")}}">Delivered</a>

                                                        </li>


                                                        <li><a class="dropdown-item"

                                                               href="/supplier/update-order-status/{{$res->order_id}}/{{getStatusIdFromName("Can't Deliver")}}">Can't

                                                                Deliver</a>

                                                        </li>


                                                    </ul>

                                                </div>

                                            </td>

                                    {{--    @endif--}}

                                        <td>{{$res->name}}</td>

                                        <td>{{$res->product_list}}<br>

                                            @if (Auth::user()->user_type != getModeratorId())

                                                <a href="#" class="" data-toggle="modal"

                                                   data-target="#p{{$res->order_id}}"> <i class="fa fa-edit"></i></a>



                                                <div class="modal" id="p{{$res->order_id}}">

                                                    <div class="modal-dialog">

                                                        <div class="modal-content">


                                                            <!-- Modal Header -->

                                                            <div class="modal-header">

                                                                <h4 class="modal-title">Product List</h4>

                                                                <button type="button" class="close"

                                                                        data-dismiss="modal">&times;

                                                                </button>

                                                            </div>


                                                            <!-- Modal body -->

                                                            <div class="modal-body">

                                                                <form class="form-horizontal" method="post"

                                                                      action="/supplier/order/order-update"

                                                                      enctype="multipart/form-data">


                                                                    <div class="form-group row">

                                                                        <label class="col-lg-3 control-label">Product

                                                                            List</label>

                                                                        <div class="col-lg-9">

                                                                            <input type="hidden" class="form-control"

                                                                                   name="_token"

                                                                                   value="{{csrf_token()}}">

                                                                            <input type="hidden" class="form-control"

                                                                                   name="order_id"

                                                                                   value="{{ $res->order_id  }}">


                                                                            <textarea name="product_list"

                                                                                      class="form-control"

                                                                                      required

                                                                                      rows="5">{{$res->product_list}}</textarea>


                                                                        </div>

                                                                    </div>


                                                                    <div class="form-group row">

                                                                        <label class="col-lg-3 control-label"></label>

                                                                        <div class="col-lg-9">

                                                                            <button type="submit"

                                                                                    class="btn btn-sm btn-primary">

                                                                                Update

                                                                            </button>

                                                                        </div>

                                                                    </div>


                                                                </form>

                                                            </div>


                                                        </div>

                                                    </div>

                                                </div>

                                            @endif

                                            @if($res->image!=null)



                                                <div class="lightBoxGallery">

                                                    <a href="/images/order/{{$res->image}}" title="Image from Unsplash"

                                                       data-gallery="">Image Order</a>

                                                    <!-- The Gallery as lightbox dialog, should be a child element of the document body -->

                                                    <div id="blueimp-gallery" class="blueimp-gallery"

                                                         style="display: none;">

                                                        <div class="slides" style="width: 98352px;"></div>

                                                        <h3 class="title">Image from Unsplash</h3>

                                                        <a class="prev">‹</a>

                                                        <a class="next">›</a>

                                                        <a class="close">×</a>

                                                        <a class="play-pause"></a>

                                                        <ol class="indicator"></ol>

                                                    </div>


                                                </div>



                                            @endif

                                        </td>

                                        <td>{{$res->admin_remarks}}</td>

                                        <td>{{$res->delivery_address}}<br>


                                            @if (Auth::user()->user_type != getModeratorId())

                                                <a href="#" class="" data-toggle="modal"

                                                   data-target="#d{{$res->order_id}}"> <i class="fa fa-edit"></i></a>



                                                <div class="modal" id="d{{$res->order_id}}">

                                                    <div class="modal-dialog">

                                                        <div class="modal-content">


                                                            <!-- Modal Header -->

                                                            <div class="modal-header">

                                                                <h4 class="modal-title">Address Change </h4>

                                                                <button type="button" class="close"

                                                                        data-dismiss="modal">&times;

                                                                </button>

                                                            </div>


                                                            <!-- Modal body -->

                                                            <div class="modal-body">

                                                                <form class="form-horizontal" method="post"

                                                                      action="/supplier/order/order-update"

                                                                      enctype="multipart/form-data">


                                                                    <div class="form-group row">

                                                                        <label class="col-lg-3 control-label">Address</label>

                                                                        <div class="col-lg-9">

                                                                            <input type="hidden" class="form-control"

                                                                                   name="_token"

                                                                                   value="{{csrf_token()}}">

                                                                            <input type="hidden" class="form-control"

                                                                                   name="order_id"

                                                                                   value="{{ $res->order_id  }}">


                                                                            <textarea name="delivery_address"

                                                                                      class="form-control"

                                                                                      required

                                                                                      rows="5">{{$res->delivery_address}}</textarea>


                                                                        </div>

                                                                    </div>


                                                                    <div class="form-group row">

                                                                        <label class="col-lg-3 control-label"></label>

                                                                        <div class="col-lg-9">

                                                                            <button type="submit"

                                                                                    class="btn btn-sm btn-primary">

                                                                                Update

                                                                            </button>

                                                                        </div>

                                                                    </div>


                                                                </form>

                                                            </div>


                                                        </div>

                                                    </div>

                                                </div>



                                            @endif

                                        </td>


                                        <td>

                                            @if($res->delivery_man_id==null)

                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"

                                                        data-target="#{{$res->order_id}}">

                                                    Add Transport

                                                </button>



                                            @else

                                                {{gettingDeliveryManFromId($res->delivery_man_id)}}<br>

                                                @if (Auth::user()->user_type != getModeratorId())

                                                    <a href="#" type="button" class="" data-toggle="modal"

                                                       data-target="#{{$res->order_id}}">

                                                        <i class="fa fa-edit"></i>

                                                    </a>

                                                @endif

                                            @endif


                                            <div class="modal" id="{{$res->order_id}}">

                                                <div class="modal-dialog">

                                                    <div class="modal-content">


                                                        <!-- Modal Header -->

                                                        <div class="modal-header">

                                                            <h4 class="modal-title">Assign DeliveryMan</h4>

                                                            <button type="button" class="close"

                                                                    data-dismiss="modal">&times;

                                                            </button>

                                                        </div>


                                                        <!-- Modal body -->

                                                        <div class="modal-body">

                                                            <form class="form-horizontal" method="post"

                                                                  action="/supplier/order/assign-deliveryman"

                                                                  enctype="multipart/form-data">


                                                                <div class="form-group row" style="display: none">

                                                                    <label class="col-lg-3 control-label">Full

                                                                        Name</label>

                                                                    <div class="col-lg-9">

                                                                        <input type="hidden" class="form-control"

                                                                               name="_token"

                                                                               value="{{csrf_token()}}">

                                                                        <input type="hidden" class="form-control"

                                                                               name="order_id"

                                                                               value="{{ $res->order_id  }}">


                                                                    </div>

                                                                </div>


                                                                <div class="form-group row">

                                                                    <label class="col-lg-3 control-label">Select

                                                                        Delivery Man</label>

                                                                    <div class="col-lg-9">

                                                                        <select name="delivery_man_id"

                                                                                class="form-control m-b">


                                                                            @foreach($delivermans as $deliverman)

                                                                                <option value="{{$deliverman->delivery_man_id}}">

                                                                                    {{$deliverman->name}}

                                                                                    ({{$deliverman->phone}})

                                                                                </option>



                                                                            @endforeach

                                                                        </select>


                                                                    </div>

                                                                </div>


                                                                <div class="form-group row">

                                                                    <label class="col-lg-3 control-label"></label>

                                                                    <div class="col-lg-9">

                                                                        <button type="submit"

                                                                                class="btn btn-sm btn-primary">

                                                                            Assign

                                                                        </button>

                                                                    </div>

                                                                </div>


                                                            </form>

                                                        </div>


                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                        {{-- <td>@if($res->is_from_public==true)Yes @else No @endif </td>--}}



                                        {{-- <td>{{ getFormattedDate($res->updated_at)}}

 --}}

                                        <td>

                                            @if($res->updated_by!=null)

                                                {{gettingUsernameFromId($res->updated_by)}}

                                            @endif


                                        </td>


                                    </tr>



                                @endforeach

                                </tbody>


                            </table>

                        </div>


                        {{$result->links()}}

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- blueimp gallery -->





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