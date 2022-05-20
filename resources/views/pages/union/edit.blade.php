@extends('layouts.app')

@section('title', 'Create Union')


@section('content')
    <h3>Union Name</h3>
    <hr>

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
        <div class="col-sm-8">
            <div class="panel panel-default">

                <div class="panel-body">

                    <form class="form-horizontal" method="post" action="/admin/union/update"
                          enctype="multipart/form-data">


                        <div class="form-group row">
                            <label class="col-lg-2 control-label">English Name</label>
                            <div class="col-lg-10">
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" placeholder="Full Name" class="form-control" name="union_id" value="{{$result->id}}">
                                <input type="text" placeholder="" class="form-control" name="en_name" value="{{$result->en_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Bangla Name</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="" class="form-control" name="bn_name" value="{{$result->bn_name}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Upazila</label>
                            <div class="col-lg-10">
                                <select name="upazila_id" class="form-control m-b">

                                    @foreach ($results  as $value)
                                        <option value="{{ $value->upazila_id}}" @if($value->upazila_id==$result->upazila_id) selected @endif>{{$value->en_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>



    </div>


@endsection