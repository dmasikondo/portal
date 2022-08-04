<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="HE-IMS">
    <title>@yield('pageTitle') | Harare Polytechnic College</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
          rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/vendors.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.css">
@stack("pageStyles")
<!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 2-columns fixed-navbar menu-collapsed"
      data-open="click" data-menu="vertical-menu" data-col="2-columns">

<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item"><a class="navbar-brand" href="{{route('staff.home')}}">
                        <img class="brand-logo" alt="Harare Polytechnic College Logo"
                             src="/app-assets/images/logo/logo.png">
                        <h3 class="brand-text">Harare Polytechnic</h3></a></li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                  data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                                              href="#"><i class="ft-menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    @if(auth('staff_user')->check())
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="mr-1">Hello,
                                <span class="user-name text-bold-700">
                                    {{auth('staff_user')->user()->name}}
                                </span>
                            </span>
                                {{--<span class="avatar avatar-online">--}}
                                {{--<img src="/app-assets/images/portrait/small/avatar-s-19.png" alt="avatar">--}}
                                {{--<i></i>--}}
                                {{--</span>--}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{--<a class="dropdown-item" href="#"><i class="ft-user"></i> Edit Profile</a>--}}
                                {{--<a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a>--}}
                                {{--<a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a>--}}
                                {{--<a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                <a class="dropdown-item" href="{{ route('staff.logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"><i class="ft-power"></i> Logout</a>

                            </div>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="nav-link dropdown-user-link" href="{{ route('staff.logout') }}"
                               onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"><i class="ft-power"></i> Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('staff.logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->


<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    @include('layouts.partials.staff-navbar')
</div>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">@yield('headerTitle')</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
            </div>
        </div>
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<footer class="footer fixed-bottom footer-light navbar-border navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span
                class="float-md-left d-block d-md-inline-block">Copyright  &copy; {{date('Y')}} <a
                    class="text-bold-800 grey darken-2"
                    href="http://www.he-ims.com/" target="_blank">HE-IMS </a>, All rights reserved. </span>
        {{--<span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with --}}
        {{--<i class="ft-heart pink"></i></span>--}}
    </p>
</footer>

<!-- BEGIN VENDOR JS-->
<script src="/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<script src="/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js" type="text/javascript"></script>
<script src="/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
<script src="/app-assets/vendors/js/ui/popper.min.js" type="text/javascript"></script>
<script src="/app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
<script src="/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="/app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="/app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="/app-assets/vendors/js/ui/jquery-sliding-menu.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="/app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
@stack('pageJavascript')
<!-- END PAGE LEVEL JS-->
</body>
</html>