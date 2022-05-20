@extends('layouts.app')

@section('title', 'All Active User Report')


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
            <h2>Active User Report</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
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

                        <!--<input type="text" id="myInput" class="form-control pull-right"-->
                        <!--       style="width: 260px;margin-bottom: 10px"-->
                        <!--       onkeyup="tableSearch()" placeholder="Search for phone.." title="Type in a phone">-->


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Last Activity</th>


                                    <!--<th>Transport</th>-->

                                    {{-- <th>From Public</th>--}}


                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr>

                                        <td>
                                            {{$res->name}}
                                        </td>
                                        <td>
                                            {{$res->phone}}
                                        </td>
                                  
                                        <td>
                                            {{getFormattedDate($res->updated_at)}}
                                        </td>
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