@extends('layouts.app')

@section('title', 'All Notice')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Notice Data</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Notice Data</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Notices</h5>
                        @if(Auth::user()->user_type==getAdminId())

                            <a href="/admin/notice/create" class="btn btn-sm btn-success">+New</a>
                        @endif
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Time</th>
                                    @if(Auth::user()->user_type==getAdminId())
                                        <th>Action</th>
                                    @endif

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($results as $res)
                                    <tr class="gradeU">
                                        <td>{{$i++}}</td>
                                        <td>{{$res->title}}</td>
                                        <td>{{$res->description}}</td>
                                        <td>@if($res->image!=null)

                                                <div class="lightBoxGallery">
                                                    <a href="/images/notice/{{$res->image}}" title="Image from Unsplash"
                                                       data-gallery=""><img src="/images/notice/{{$res->image}}"
                                                                            width="50px"/></a>
                                                    <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                                                    <div id="blueimp-gallery" class="blueimp-gallery"
                                                         style="display: none;">
                                                        <div class="slides" style="width: 98352px;"></div>
                                                        <a class="prev">‹</a>
                                                        <a class="next">›</a>
                                                        <a class="close">×</a>
                                                        <a class="play-pause"></a>
                                                        <ol class="indicator"></ol>
                                                    </div>

                                                </div>


                                                {{--       <img src="/images/notice/{{$res->image}}"width="70px"/> --}}

                                                <center>
                                                    <a href="/images/notice/{{$res->image}}" download="">Download</a>
                                                </center>
                                            @endif
                                        </td>
                                        <td>{{$res->created_at}}</td>
                                        @if(Auth::user()->user_type==getAdminId())
                                            <td>

                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                            class="btn btn-default btn-xs dropdown-toggle">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                               href="/admin/notice/edit/{{$res->notice_id}}">Edit</a>
                                                        </li>

                                                        <li><a class="dropdown-item"
                                                               href="/admin/notice/destroy/{{$res->notice_id}}">Delete</a>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </td>
                                        @endif

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


@endsection