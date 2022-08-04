<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Harare Polytechnic registration and login to student portal.">
    <meta name="keywords" content="Harare Polytechnic, Student Portal, Harare eduction, tertiary education, zimbabwe">
    <meta name="author" content="Tapiwanashe Mugoniwa">
    <title>Support | Harare Polytechnic</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
          rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
          rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/icheck/custom.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/app.css">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END Custom CSS-->
</head>
<body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
      data-open="click" data-menu="horizontal-menu" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container" style="height: auto;">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-10 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            <div class="card-header border-0 pb-0">
                                <div class="card-title text-center">
                                    <img src="/app-assets/images/logo/logo-dark.png" alt="Harare Polytechnic"
                                         style="width: 90%;">
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-text">
                                        <h3 class="text-center text-bold-500">Contact Support</h3>
                                        <p class="text-justify">Service is currently unavailable, please try again
                                            later.</p>
                                    </div>

                                    @if(count($errors->all()) > 0)
                                        @foreach($errors->all() as $error)
                                            <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2"
                                                 role="alert">
                                                <span class="alert-icon"><i
                                                            class="la la-exclamation-triangle"></i></span>
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                {{$error}}
                                            </div>
                                        @endforeach
                                    @endif


                                    {{--<form class="form-horizontal" method="post" action="{{route("p.unreg-assistance")}}"--}}
                                    {{--novalidate>--}}
                                    {{--{!! csrf_field() !!}--}}
                                    {{--<fieldset class="form-group form-group-style">--}}
                                    {{--<label for="first_name"><i class="ft-user"></i> Your Firstname(s)</label>--}}
                                    {{--<input name="first_name" type="text" class="form-control" id="first_name"--}}
                                    {{--placeholder="First Name(s)" style="text-transform:uppercase"--}}
                                    {{--value="{{old("first_name")}}">--}}
                                    {{--</fieldset>--}}

                                    {{--<fieldset class="form-group form-group-style">--}}
                                    {{--<label for="surname"><i class="ft-user"></i> Your Surname</label>--}}
                                    {{--<input name="surname" type="text" class="form-control" id="surname"--}}
                                    {{--placeholder="Surname" style="text-transform:uppercase"--}}
                                    {{--value="{{Session::hasOldInput("surname")?Session::getOldInput("surname"):""}}">--}}
                                    {{--</fieldset>--}}

                                    {{--<fieldset class="form-group form-group-style">--}}
                                    {{--<label for="national_id"><i class="la la-slack"></i> Your National--}}
                                    {{--ID</label>--}}
                                    {{--<input name="national_id" type="text" class="form-control" id="national_id"--}}
                                    {{--value="{{old("national_id")}}" style="text-transform:uppercase"--}}
                                    {{--placeholder="99-999999X99" required>--}}
                                    {{--</fieldset>--}}

                                    {{--<fieldset class="form-group form-group-style">--}}
                                    {{--<label for="student_id"><i class="ft-credit-card"></i> Your Student--}}
                                    {{--ID</label>--}}
                                    {{--<input name="student_id" type="text" style="text-transform:uppercase"--}}
                                    {{--class="form-control" id="student_id" value="{{old("student_id")}}"--}}
                                    {{--placeholder="Student ID" required>--}}
                                    {{--</fieldset>--}}

                                    {{--<fieldset class="form-group form-group-style">--}}
                                    {{--<label for="email"><i class="ft-at-sign"></i> Your Email</label>--}}
                                    {{--<input name="email" type="email" class="form-control" id="email"--}}
                                    {{--value="{{old("email")}}" placeholder="me@example.com" required>--}}
                                    {{--</fieldset>--}}

                                    {{--<fieldset class="form-group form-group-style">--}}
                                    {{--<label for="issue"><i class="ft-alert-circle"></i> Type Of Issue</label>--}}
                                    {{--{!! Form::select('issue',--}}
                                    {{--collect(\App\SupportTicket::$issue_types)->where("auth",0)->pluck("student_detail","id"),--}}
                                    {{--null,["class"=>"form-control", "id"=>"issue"]) !!}--}}
                                    {{--</fieldset>--}}

                                    {{--<fieldset class="form-group form-group-style">--}}
                                    {{--<label for="textarea2">Description</label>--}}
                                    {{--<textarea name="description" class="form-control" id="textarea2"--}}
                                    {{--rows="3"></textarea>--}}
                                    {{--</fieldset>--}}

                                    {{--<button type="submit" class="btn btn-outline-info btn-block"><i--}}
                                    {{--class="ft-check"></i> Submit--}}
                                    {{--</button>--}}
                                    {{--</form>--}}
                                </div>
                                <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                    <span>Go Back?</span>
                                </p>
                                <div class="card-body">
                                    <a href="{{route('lhome')}}" class="btn btn-outline-danger btn-block"><i
                                                class="ft-arrow-left"></i>Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- BEGIN VENDOR JS-->
<script src="/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script type="text/javascript" src="/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
        type="text/javascript"></script>
<script src="/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="/app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->

<script src="/app-assets/vendors/js/forms/tags/form-field.js" type="text/javascript"></script>
<script src="/app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->
</body>
</html>