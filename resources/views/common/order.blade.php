<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NITTOPONNO</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" rel="stylesheet" type="text/css">

    <script async defer src="https://buttons.github.io/buttons.js"></script>

</head>
<body>
<!-- navbar starts -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark nav-masthead">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/images/logo.png" height="50px"/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link p-2 font-weight-bold text-white" href="#">Home </a>
                </li>


            </ul>

            <a class="nav-link text-white p-2 font-weight-bold" href="/login">Login</a>
            <a class="nav-link text-white p-2 font-weight-bold" href="/registration">Register</a>

        </div>
    </div>
</nav>
<!-- nav bar ends -->


<div class="container mt-5" id="about">
    <div class="col-md-8 mx-auto">
        <br>
        <br>
        <div class="card">
            <div class="card-body">


                <h3>Welcome to NITTOPONNO</h3>
                <h6>Place Your order </h6>

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
                            <button type="submit" class="btn btn-sm btn-block btn-primary">Place Order</button>
                        </div>
                    </div>

                </form>
            </div>


        </div>


    </div>
</div>
{{--
<div class="container mt-5  text-center">
    <p class="pt-5 pb-2 h4 text-monospace">Speed up your development with high quality themes.</p>
    <div class="row">

        <div class="mx-auto" style="width: 800px;">
            <p class="text-center"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
    </div>

</div>
--}}

<!-- footer start -->
<footer class="">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <img id="footer" src="/images/logo-set.png" width="100%" style="padding-top: 50px">
            </div>
            <!--end of col-->

        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</footer>
<!-- footer end -->

</body>
</html>
