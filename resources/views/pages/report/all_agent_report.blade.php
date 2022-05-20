@extends('layouts.app')

@section('title', 'All Agent Report')


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
            <h2>Agent Report for <span class="text-danger"> {{$status}}</span> Status</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Top Agent</strong>
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

                        <form role="form" action="/admin/agent-report" method="post" class="form-inline"
                              style="margin-bottom: 10px">
                            {{-- <div class="form-group">
                                 <select name="month" class="form-control m-b">

                                     <option value="01">January</option>
                                     <option value="02">February</option>
                                     <option value="03">March</option>
                                     <option value="04">April</option>
                                     <option value="05">May</option>
                                     <option value="06">June</option>
                                     <option value="07">July</option>
                                     <option value="08">August</option>
                                     <option value="09">September</option>
                                     <option value="10">October</option>
                                     <option value="11">November</option>
                                     <option value="12">December</option>

                                 </select>

                                 <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                             </div>--}}

                            <div class="form-group">
                                <label style="padding-right: 5px">From</label>
                                <input type="date" placeholder="To date" class="form-control" name="from" required>
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            </div>

                            <div class="form-group">
                                <label style="padding-right: 5px">To</label>
                                <input type="date" placeholder="To date" class="form-control" name="to" required>
                            </div>

                           {{-- <div class="form-group">
                                <select name="status_id" class="form-control">
                                    <option value="">Select Status</option>
                                    @foreach(getStatusListForAgent() as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>

                                    @endforeach

                                </select>


                            </div>--}}

                            <button class="btn btn-white" type="submit">Search</button>
                        </form>

                        <!--<input type="text" id="myInput" class="form-control pull-right"-->
                        <!--       style="width: 260px;margin-bottom: 10px"-->
                        <!--       onkeyup="tableSearch()" placeholder="Search for phone.." title="Type in a phone">-->


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Order Process</th>

                                    <!--<th>Transport</th>-->

                                    {{-- <th>From Public</th>--}}


                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <a href="/supplier/report/{{$res->user_id}}"> {{getSupplierNameFromId($res->user_id)}}</a>
                                        </td>
                                        <td>{{getSupplierPhoneFromId($res->user_id)}}</td>
                                        <td>{{$res->count}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection