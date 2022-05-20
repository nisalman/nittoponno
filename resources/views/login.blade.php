@extends('layouts.common')

@section('title', 'Login')


@section('content')



    <div>

        <img src="/images/logo.png" style="    width: 95px;
    padding-bottom: 19px;"/>
        <h3>একশপ - ফোনে নিত্যপন্য</h3>

        {{--    <p>Login in. To see it in action.</p>--}}
        @if(session('success'))

            <div class="alert alert-success">{{session('success')}}!</div>

        @endif
        @if(session('failed'))
            <div class="alert alert-danger">
                {{session('failed')}}!
            </div>
        @endif


        <form class="m-t" role="form" method="post" action="/login-check"
              enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" required="" name="user_name">
                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="" name="password">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            {{--<a href="/">
                <small>Forgot password?</small>
            </a>--}}
            {{-- <p class="text-muted text-center">
                 <small>Do not have an account?</small>
             </p>--}}
          {{--  <a class="btn btn-sm btn-white btn-block" href="/registration">Create an account</a>--}}
        </form>
        {{-- <p class="m-t">
             <small>Inspinia we app framework base on Bootstrap 3 &copy; 2020</small>
         </p>--}}
    </div>


@endsection


