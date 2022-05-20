@extends('layouts.app')

@section('title', 'Update Order')


@section('content')
    <h3>Create Order</h3>
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
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Order</div>

                    <div class="panel-body">

                        <form class="form-horizontal" method="post" action="/admin/order/update"
                              enctype="multipart/form-data">


                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Full Name</label>
                                <div class="col-lg-9">
                                    <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" class="form-control" name="order_id" value="{{$res->order_id}}">
                                    <input type="text" placeholder="Full Name" class="form-control" name="name"
                                           value="{{$res->name}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Service Type</label>
                                <div class="col-lg-9">
                                    <select name="service_type" class="form-control m-b">

                                        @foreach (getServiceType() as $key => $value)
                                            <option value="{{ $key}}" @if($res->service_type==$key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Phone</label>
                                <div class="col-lg-9">
                                    <input type="text" placeholder="Phone" value="{{$res->phone}}" class="form-control" name="phone">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection