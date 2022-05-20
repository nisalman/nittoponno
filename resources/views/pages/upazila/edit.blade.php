@extends('layouts.app')

@section('title', 'Update Upazila')


@section('content')
    <h3>Upadte Upazila</h3>
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

                    <form class="form-horizontal" method="post" action="/admin/upazila/update"
                          enctype="multipart/form-data">


                        <div class="form-group row">
                            <label class="col-lg-2 control-label">English Name</label>
                            <div class="col-lg-10">
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" class="form-control" name="upazila_id" value="{{$result->upazila_id}}">
                                <input type="text" placeholder="" class="form-control" name="en_name"  value="{{$result->en_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Bangla Name</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="" class="form-control" name="bn_name" value="{{$result->bn_name}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label">District</label>
                            <div class="col-lg-10">
                                <select name="district_id" class="form-control m-b">

                                    @foreach ($results  as $value)
                                        <option value="{{ $value->district_id}}" @if($value->district_id==$result->district_id) selected @endif>{{$value->en_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>



    </div>


@endsection