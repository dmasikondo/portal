<div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        @if(auth()->user()->user_type == "admin")
            <li class=" nav-item">
                <a href="{{route("staff.home")}}">
                    <i class="la la-home"></i><span class="menu-title" data-i18n="">Dashboard</span>
                    {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
                </a>
            </li>
            <li class=" nav-item">
                <a href="{{route("staff.registration.index")}}">
                    <i class="la la-clock-o"></i><span class="menu-title" data-i18n="">Registration Sessions</span>
                    {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
                </a>
            </li>

            <li class=" nav-item">
                <a href="{{route("staff.accommodation.index")}}">
                    <i class="la la-hotel"></i><span class="menu-title" data-i18n="">Accommodation</span>
                    {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
                </a>
            </li>
            {{--<li class=" nav-item">--}}
            {{--<a href="{{route("staff.courses")}}">--}}
            {{--<i class="la la-book"></i><span class="menu-title" data-i18n="">Courses</span>--}}
            {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
            {{--</a>--}}
            {{--</li>--}}
        @endif
        <li class=" nav-item">
            <a href="{{route("staff.students")}}">
                <i class="la la-users"></i><span class="menu-title" data-i18n="">Students</span>
                {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
            </a>
        </li>

        <li class=" nav-item">
            <a href="{{route("staff.students.enrolment")}}">
                <i class="la la-user-plus"></i><span class="menu-title" data-i18n="">Enrolments</span>
                {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
            </a>
        </li>


        {{--<li class="nav-item">--}}
        {{--<a href="#">--}}
        {{--<i class="ft-book"></i><span class="menu-title" data-i18n="">Library</span>--}}
        {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
        {{--</a>--}}
        {{--</li>--}}

        <li class="nav-item">
            <a href="{{route("staff.examinations.index")}}">
                <i class="la la-certificate"></i><span class="menu-title" data-i18n="">Examinations</span>
                {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route("staff.data-analytics.index")}}">
                <i class="la la-area-chart"></i><span class="menu-title" data-i18n="">Data Analytics</span>
                {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
            </a>
        </li>

        @if(auth()->user()->user_type == "admin")
            <li class=" nav-item">
                <a href="{{route("staff.users")}}">
                    <i class="la la-user"></i><span class="menu-title" data-i18n="">Users</span>
                    {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
                </a>
            </li>
        @endif

            <li class="nav-item">
                <a href="{{route("staff.change-password")}}">
                    <i class="la la-key"></i><span class="menu-title" data-i18n="">Change Password</span>
                    {{--<span class="badge badge badge-info badge-pill float-right mr-2">5</span>--}}
                </a>
            </li>
        {{--<li class=" nav-item"><a href="#"><i class="la la-rocket"></i><span class="menu-title"--}}
        {{--data-i18n="">Starter kit</span></a>--}}
        {{--<ul class="menu-content">--}}
        {{--<li><a class="menu-item" href="layout-1-column.html" data-i18n="nav.starter_kit.1_column">1--}}
        {{--column</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-2-columns.html" data-i18n="nav.starter_kit.2_columns">2--}}
        {{--columns</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="#" data-i18n="nav.starter_kit.3_columns_detached.main">Content Det.--}}
        {{--Sidebar</a>--}}
        {{--<ul class="menu-content">--}}
        {{--<li><a class="menu-item" href="layout-content-detached-left-sidebar.html"--}}
        {{--data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_left_sidebar">Detached--}}
        {{--left sidebar</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-content-detached-left-sticky-sidebar.html"--}}
        {{--data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_sticky_left_sidebar">Detached--}}
        {{--sticky left sidebar</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-content-detached-right-sidebar.html"--}}
        {{--data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_right_sidebar">Detached--}}
        {{--right sidebar</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-content-detached-right-sticky-sidebar.html"--}}
        {{--data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_sticky_right_sidebar">Detached--}}
        {{--sticky right sidebar</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="navigation-divider"></li>--}}
        {{--<li><a class="menu-item" href="layout-fixed-navbar.html" data-i18n="nav.starter_kit.fixed_navbar">Fixed--}}
        {{--navbar</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-fixed-navigation.html"--}}
        {{--data-i18n="nav.starter_kit.fixed_navigation">Fixed navigation</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-fixed-navbar-navigation.html"--}}
        {{--data-i18n="nav.starter_kit.fixed_navbar_navigation">Fixed navbar &amp; navigation</a>--}}
        {{--</li>--}}
        {{--<li class="active"><a class="menu-item" href="layout-fixed-navbar-footer.html"--}}
        {{--data-i18n="nav.starter_kit.fixed_navbar_footer">Fixed navbar &amp; footer</a>--}}
        {{--</li>--}}
        {{--<li class="navigation-divider"></li>--}}
        {{--<li><a class="menu-item" href="layout-fixed.html" data-i18n="nav.starter_kit.fixed_layout">Fixed--}}
        {{--layout</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-boxed.html" data-i18n="nav.starter_kit.boxed_layout">Boxed--}}
        {{--layout</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-static.html" data-i18n="nav.starter_kit.static_layout">Static--}}
        {{--layout</a>--}}
        {{--</li>--}}
        {{--<li class="navigation-divider"></li>--}}
        {{--<li><a class="menu-item" href="layout-light.html" data-i18n="nav.starter_kit.light_layout">Light--}}
        {{--layout</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-dark.html" data-i18n="nav.starter_kit.dark_layout">Dark--}}
        {{--layout</a>--}}
        {{--</li>--}}
        {{--<li><a class="menu-item" href="layout-semi-dark.html" data-i18n="nav.starter_kit.semi_dark_layout">Semi--}}
        {{--dark layout</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}
    </ul>
</div>