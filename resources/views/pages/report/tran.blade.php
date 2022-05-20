@extends('layouts.app')

@section('title', 'Tran')


@section('content')
    @if($is_paginate)
        <style>
            div.dataTables_wrapper div.dataTables_paginate {
                display: none;
            }

            div.dataTables_wrapper div.dataTables_info {
                padding-top: 8px;
                white-space: nowrap;
                display: none;
            }

            .dataTables_length {
                float: left;
                display: none;
            }
        </style>
    @endif
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Tran</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Tran</strong>
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


                    <div class="ibox-content">

                        <form role="form" action="/admin/tran-report" method="post" class="form-inline"
                              style="margin-bottom: 10px">
                            <div class="form-group">
                                <input type="date" placeholder="From date" class="form-control" name="from" required>
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            </div>
                            {{--  <div class="form-group">
                                  <input type="date" placeholder="To date" class="form-control" name="to" required>
                              </div>--}}

                            <button class="btn btn-white" type="submit">Search</button>
                        </form>
                        @if($is_paginate==true)
                            <p><strong>Total: </strong> {{$total}}</p>
                        @endif
                    <!--<input type="text" id="myInput" class="form-control pull-right"-->
                        <!--       style="width: 260px;margin-bottom: 10px"-->
                        <!--       onkeyup="tableSearch()" placeholder="Search for phone.." title="Type in a phone">-->


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>

                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Time</th>
                                    <th>Service Type</th>
                                    <th>Location</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Union</th>
                                    <th>Status</th>
                                    <th>Date</th>

                                    <!--<th>Transport</th>-->

                                    {{-- <th>From Public</th>--}}


                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr class="gradeU">

                                        <td>{{$res->invoice_number}}</td>
                                        <td>{{$res->name}}</td>
                                        <td>{{$res->phone}}</td>
                                        <td> @if($res->time!='')Called:{{$res->time}}
                                            @endif

                                        </td>
                                        <td> {{getServiceFromId($res->service_type)}}</td>
                                        <td> {{$res->delivery_address}}</td>
                                        <td> {{getDivisionFromId($res->division_id)}}</td>

                                        <td>{{getDistrictFromId($res->district_id)}}</td>
                                        <td>{{getUpazilaFromId($res->upazila_id)}}</td>
                                        <td>{{getunionFromId($res->union_id)}}</td>

                                        <td>{{getStatusName($res->status)}}</td>
                                        <td>{{$res->created_at}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                        </div>

                        @if($is_paginate)
                            {{ $results->links()}}
                        @endif

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