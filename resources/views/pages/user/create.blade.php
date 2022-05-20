@extends('layouts.app')

@section('title', 'Create Volunteer')


@section('content')
    <h3>Volunteer Name</h3>
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
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">New User</div>

                <div class="panel-body">

                    <form class="form-horizontal" method="post" action="/admin/supplier/store"
                          enctype="multipart/form-data">


                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Name</label>
                            <div class="col-lg-10">
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" class="form-control" name="user_type" value="3">
                                <input type="text" placeholder="Full Name" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Username</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Username" class="form-control" name="user_name"
                                       required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Password</label>
                            <div class="col-lg-10">
                                <input type="password" placeholder="Password" class="form-control" name="password"
                                       required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Phone</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Phone" class="form-control" name="phone" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label">NID</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="nid" class="form-control" name="nid">
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
        @if(Auth::user()->user_type!=getModeratorId())

            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Upload File</div>

                    <div class="panel-body">

                        <form class="form-horizontal" method="post" action="/admin/supplier/csv-store"
                              enctype="multipart/form-data">


                            <div class="form-group row">
                                <label class="col-lg-2 control-label">File</label>
                                <div class="col-lg-10">
                                    <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                                    <input type="file" class="form-control" name="csvfile" required>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-2 control-label"></label>
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        @endif

    </div>


@endsection