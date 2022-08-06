<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Harare Polytechnic registration and login to student portal.">
    <meta name="keywords" content="Harare Polytechnic, Student Portal, Harare eduction, tertiary education, zimbabwe">
    <meta name="author" content="Tapiwanashe Mugoniwa">
    <title>@yield('pageTitle') | Harare Polytechnic</title>
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
                    <div class="col-md-4 col-10 box-shadow- 2 p-0">
                        @yield("main-card")
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