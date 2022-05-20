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


        <form class="m-t" role="form" method="post" action="/registration/store"
              enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" placeholder="Full Name" class="form-control" name="name" required>
                <input type="hidden" class="form-control" name="user_type" value="3">
                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Username" class="form-control" name="user_name" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="" name="password">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Phone" class="form-control" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Registration</button>

          {{--  <a href="/">
                <small>Forgot password?</small>
            </a>--}}
            <p class="text-muted text-center">
                 <small>Do not have an account?</small>
                <a href="/login">Login</a>
             </p>
            {{--   <a class="btn btn-sm btn-white btn-block" href="/">Create an account</a>--}}
        </form>
        {{-- <p class="m-t">
             <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
         </p>--}}
    </div>


@endsection


