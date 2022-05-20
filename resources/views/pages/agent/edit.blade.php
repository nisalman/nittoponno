@extends('layouts.app')

@section('title', 'Update User')


@section('content')
    <h3>Update User</h3>
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
            <div class="panel-heading">Update User</div>

            <div class="panel-body">

                <form class="form-horizontal" method="post" action="/admin/agent/update"
                      enctype="multipart/form-data">


                    <div class="form-group row">
                        <label class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" class="form-control" name="id" value="{{$result->id}}">
                            <input type="text" placeholder="Full Name" class="form-control" name="name"
                                   value="{{$result->name}}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 control-label">Username</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Username" class="form-control" name="user_name"
                                   value="{{$result->user_name}}" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-2 control-label">Phone</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Phone" class="form-control" name="phone"
                                   value="{{$result->phone}}" required>
                        </div>
                    </div>


                    <div id="not_change">
                        <div class="form-group row" id="not_change">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-lg-10">
                                <button type="button" class="btn btn-sm btn-primary" onclick="changePaswordClicked()">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </div>


                    <div id="pass_change">

                        <div class="form-group row">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-lg-10">
                                <button type="button" class="btn btn-sm btn-primary"
                                        onclick="notChangePaswordClicked()"> Dont want to change
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Password</label>
                            <div class="col-lg-10">
                                <input type="password" placeholder="Password" class="form-control" name="password">
                            </div>
                        </div>


                    </div>


                    <div class="form-group row">
                        <label class="col-lg-2 control-label"></label>
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>

        document.getElementById("pass_change").style.display = "none";
        document.getElementById("not_change").style.display = "block";

        function changePaswordClicked() {

            document.getElementById("pass_change").style.display = "block";
            document.getElementById("not_change").style.display = "none";
        }

        function notChangePaswordClicked() {

            document.getElementById("pass_change").style.display = "none";
            document.getElementById("not_change").style.display = "block";
        }
    </script>
@endsection