@extends('layouts.common')

@section('title', 'Login')


@section('content')



    <div>

        <img src="/images/logo.png" style="    width: 95px;
    padding-bottom: 19px;"/>
        <h3>Welcome to NITTOPONNO</h3>

        {{--    <p>Login in. To see it in action.</p>--}}
        @if(session('success'))

            <div class="alert alert-success">{{session('success')}}!</div>

        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{session('failed')}}!
            </div>
        @endif
        {{--
                <div class="ibox ">
                    <div class="ibox-title">--}}

        <form class="form-horizontal" method="post" action="/order/store"
              enctype="multipart/form-data">


            <div class="form-group row">

                <div class="col-lg-12">
                    <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                    <input type="text" placeholder="Full Name" class="form-control" name="name">
                </div>
            </div>

            <div class="form-group row">

                <div class="col-lg-12">
                    <select name="service_type" class="form-control m-b">

                        @foreach (getServiceType() as $key => $value)
                            <option value="{{ $key}}">{{$value}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="form-group row">

                <div class="col-lg-12">
                    <input type="text" placeholder="Phone" class="form-control" name="phone" required>
                </div>
            </div>


            {{--    <div class="form-group row">

                    <div class="col-lg-12">
                        <textarea type="text" placeholder="Product List" class="form-control" name="product_list"></textarea>
                    </div>
                </div>


--}}
            <div class="form-group row">

                <div class="col-lg-12">
                    <input type="file" class="form-control" name="product_image">
                </div>
            </div>

            <div class="form-group row">

                <div class="col-lg-12">
                    <button type="submit" class="btn btn-sm btn-block btn-primary">Save</button>
                </div>
            </div>

            <p class="text-muted text-center">
                <small>Do not have an account?</small>
                <a href="/login">Login</a>
            </p>
        </form>

    </div>
    {{--     </div>
     </div>
 --}}

@endsection

