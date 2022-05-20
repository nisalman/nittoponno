@extends('layouts.app')

@section('title', 'Create User')


@section('content')
    <br>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div href="#" class="media p mt0">
                        <div class="pull-left">
                            <img src="/images/user/{{$result->profile_pic}}" style="width: 100px; height: 100px;"
                                 alt="Image" class="media-object img-circle">
                        </div>
                        <div class="media-body">
                            <div class="media-heading">
                                <h3 class="mt0">{{$result->name}}</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-sm">
                                        <em class="fa fa-user fa-fw"></em> {{$result->user_name}}</li>
                                    <li class="mb-sm"><em class="fa fa-envelope fa-fw"></em> {{$result->email}}</li>
                                    <li class="mb-sm"><em class="fa fa-phone fa-fw"></em> {{$result->phone}}</li>
                                    <li class="mb-sm"><em class="fa fa-id-card fa-fw"></em> {{$result->nid}}</li>
                                </ul>
                            </div>
                            <a href="/admin/profile/edit" class="btn btn-primary btn-sm">Update Profile</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- <div class="col-lg-8">


             <div class="panel panel-primary">
                 <div class="panel-heading portlet-handler">Profile
                 </div>
                 <div class="panel-body">
                     <p>Name: {{$result->name}}</p>
                     <p>Phone: {{$result->phone}}</p>
                 </div>

             </div>


         </div>--}}
    </div>
@endsection