<!DOCTYPE html>
<html>
<head>

    @include('includes.head')

</head>

<body ng-app="myApp">
<div id="wrapper">

    @include('includes.sidebar')
    <div id="page-wrapper" class="gray-bg">

        @include('includes.notification')
        @yield('content')

        @include('includes.copyright')
    </div>


</div>

<!-- Mainly scripts -->
@include('includes.footer')

</body>
</html>
