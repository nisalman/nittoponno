@extends('layouts.app')

@section('title', 'Orders')


@section('content')
    <h3>Orders</h3>
    <hr>

    <div class="col-sm-12">
        @if(session('success'))

            <div class="alert alert-success">{{session('success')}}!</div>

        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{session('failed')}}!
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            
            <div class="col-md-4 mx-auto" style="margin-top: 50px">
                <a style="font-size:200%; height: 80px;padding-top:20px" href="/admin/latest-order-request" class="btn btn-success btn-rounded btn-block align-middle " type="button"><i class="fa fa-plug "></i>&nbsp;Latest order</a>
            </div>
            <div class="col-md-4 mx-auto" style="margin-top: 50px">
                <a style="font-size:200%; height: 80px;padding-top:20px" href="/admin/order-request" class="btn btn-primary btn-rounded btn-block align-middle " type="button"><i class="fa fa-plug "></i>&nbsp;Request order</a>
            </div>
            <div class="col-md-4 mx-auto " style="margin-top: 50px">
                <a style="font-size:200%; height: 80px;padding-top:20px" href="/admin/older-order-request" class="btn btn-danger btn-rounded btn-block align-middle " type="button"><i class="fa fa-plug "></i>&nbsp;Old order</a>
            </div>
            
            
            <div class="col-md-12 mx-auto">
                <div class="panel panel-default" style="height: 250px;">

                    <div class="panel-body text-center pt-5 hero-button">

                        <a style="font-size:200%; height: 80px;padding-top:20px"  href="/admin/orders/All" class="btn btn-secondary btn-rounded btn-block" type="button"><i class="fa fa-list"></i>&nbsp;View orders</a>



                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection