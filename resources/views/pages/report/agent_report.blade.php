@extends('layouts.app')

@section('title', 'Agent Report')


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
            <?php
            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F'); // March

            ?>
            <h2>Agent Report for <span class="text-danger">{{$monthName}}</span></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Agent Report</strong>
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

                        <form role="form" action="/supplier/report/{{$id}}" method="post" class="form-inline"
                              style="margin-bottom: 10px">
                            <div class="form-group">
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
                            </div>
                            {{--  <div class="form-group">
                                  <input type="date" placeholder="To date" class="form-control" name="to" required>
                              </div>--}}
                            <div class="form-group">
                                <button class=" form-control btn btn-white" type="submit" style="    margin-top: -14px;">Search</button>
                            </div>
                        </form>

                        <!--<input type="text" id="myInput" class="form-control pull-right"-->
                        <!--       style="width: 260px;margin-bottom: 10px"-->
                        <!--       onkeyup="tableSearch()" placeholder="Search for phone.." title="Type in a phone">-->


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    
                                    <th>#</th>

                                    <th>Date</th>
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
                                        <td>{{$res->date}}</td>
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