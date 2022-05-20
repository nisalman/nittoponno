@extends('layouts.supplier')

@section('title', 'Admin Home')


@section('content')


    <div class="wrapper wrapper-content">
        @if(session('success'))

            <div class="alert alert-success">{{session('success')}}!</div>

        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{session('failed')}}!
            </div>
        @endif

        @if($is_complete>0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content bg-danger text-center">
                            <a class="text-white text-center" style="font-size:25px" href="/admin/shops">অনুগ্রহ  করে আপনার প্রোফাইলে এলাকার তথ্য আপডেট করুন</a>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        @if($is_nid_incomplete>0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content bg-danger text-center">
                            <a class="text-white text-center" style="font-size:25px" href="/admin/profile/edit">অনুগ্রহ  করে আপনার প্রোফাইলে এনআইডি'র  তথ্য আপডেট করুন</a>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <div class="row">


            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">

                        <h5>Pending Order</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$pending_order}}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">

                        <h5>Total Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$total_order}}</h1>

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Total Shops</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$shop_count}}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">


                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="feed-activity-list">
                            @foreach($histories as $history)
                                <div class="feed-element">
                                    <div>
                                        <small class="float-right"></small>
                                        <strong>{{$history->name}}</strong>
                                        <div>IP Address: {{$history->ip_address}}</div>
                                        <small class="text-muted">Logged in at {{$history->created_at}}</small>
                                    </div>
                                </div>
                            @endforeach

                            {{$histories->links()}}


                        </div>
                    </div>

                </div>
            </div>


            <div class="row">

            </div>
        </div>


    </div>

@endsection