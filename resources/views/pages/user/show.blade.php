@extends('layouts.app')

@section('title', 'Volunteers')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Volunteers</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Volunteers</strong>
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
                <div class="ibox ">
                    <div class="ibox-title">
                    {{--    @if(Auth::user()->user_type!=getModeratorId())--}}
                            <a href="/admin/supplier/create" class="btn btn-sm btn-success">Add Volunteer</a>
                     {{--   @endif--}}
                    </div>
                    <div class="ibox-content">

                       {{-- <input type="text" id="myInput" class="form-control pull-right" style="width: 260px;margin-bottom: 10px"
                               onkeyup="tableSearch()"
                               placeholder="Search for phone.." title="Type in a phone">--}}
                        <form role="form" action="/admin/supplier-search" method="post" class="form-inline float-right"  style="margin-bottom: 10px">
                            <div class="form-group">
                                <input type="text" placeholder="Enter phone no." class="form-control" name="phone">
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            </div>

                            <button class="btn btn-white" type="submit">Search</button>
                        </form>


                        <div class="{{--table-responsive--}}">
                            <table class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                 <?php $i = ($results->currentpage()-1)* $results->perpage();?>
                                @foreach($results as $res)
                                    <tr class="gradeU">
                                        <td>{{$i++}}</td>
                                        <td>{{$res->name}}<br>
                                        <small><strong>Username:</strong> {{$res->user_name}}<br>
                                        <strong>NID:</strong> {{$res->nid}}
                                        </small>
                                        </td>
                                        <td>{{$res->phone}}</td>

                                        <td>

                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-default btn-xs dropdown-toggle">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">

                                                    <li><a class="dropdown-item"
                                                           href="/admin/shops/{{$res->id}}" target="_blank">Shop</a></li>

                                                    <li><a class="dropdown-item"
                                                           href="/admin/supplier-orders/{{$res->id}}" target="_blank">Orders</a></li>

                                                  {{--  @if(Auth::user()->user_type!=getModeratorId())--}}
                                                        <li><a class="dropdown-item"
                                                               href="/admin/supplier/edit/{{$res->id}}" target="_blank">Edit</a></li>
                                                        {{--   <li><a class="dropdown-item" href="/admin/supplier/destroy/{{$res->id}}">Delete</a></li>--}}


                                                        @if($res->is_active)
                                                            <li><a class="dropdown-item"
                                                                   href="/admin/supplier/status-update/{{$res->id}}/0">Inactive</a>
                                                            </li>
                                                        @else
                                                            <li><a class="dropdown-item"
                                                                   href="/admin/supplier/status-update/{{$res->id}}/1">Activate</a>
                                                            </li>
                                                        @endif

                                                {{--    @endif--}}

                                                </ul>
                                            </div>
                                        </td>
                                        <td>@if($res->is_active) <span class="badge badge-success">Active</span> @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                            <br><small>{{getFormattedDate($res->updated_at)}}</small>

                                                </td>

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