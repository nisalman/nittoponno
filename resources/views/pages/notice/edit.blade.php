@extends('layouts.app')

@section('title', 'Create Notice')


@section('content')
    <h3>Notice Name</h3>
    <hr>

    <div class="col-sm-10 col-md-offset-1">
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
        <div class="panel panel-default">
            <div class="panel-heading">New Notice</div>

            <div class="panel-body">

                <form class="form-horizontal" method="post" action="/admin/notice/update"
                      enctype="multipart/form-data">


                    <div class="form-group row">
                        <label class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" class="form-control" name="image" value="{{$result->image}}">
                            <input type="hidden" class="form-control" name="id" value="{{$result->notice_id}}">
                            <input type="text" placeholder="Title" class="form-control" name="title"
                                   value="{{$result->title}}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 control-label">Details</label>
                        <div class="col-lg-10">
                            <textarea type="text" placeholder="Details" class="form-control"
                                      name="description">{{$result->description}}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-2 control-label">Image</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control" name="notice_image">

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


@endsection