<!doctype html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ระบบบริหารจัดการข้อมูลแผนงาน โครงการ และงบประมาณ (สป.)') }}</title>
    {{-- <title>{{ config('app.name', 'ระบบบริหารจัดการข้อมูลแผนงาน โครงการ และงบประมาณ (สป.)') }}</title> --}}

    <link rel="apple-touch-icon" href="{{ asset('assets') }}/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extend.css') }}">
    {{--
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extend.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets') }}/css/site.css">
    {{--
    <link rel="stylesheet" href="{{ asset('assets') }}/css/site.min.css"> --}}

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/flag-icon-css/flag-icon.css') }}">
    {{--
    <link rel="stylesheet" href="{{ asset('vendor/chartist/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('vendor/aspieprogress/asPieProgress.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-selective/jquery-selective.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets') }}/examples/css/dashboard/team.css">

    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables/datatable.css') }}">

    {{-- sweetalert-css --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-sweetalert/sweetalert.css') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/kanit/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/brand-icons/brand-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/dropify/dropify.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    {{--
    <link href="{{ asset('css/bootstrap_pbms.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extend_pbms.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/site_pbms.min.css') }}" rel="stylesheet"> --}}
    <!--[if lt IE 9]>
        <script src="{{ asset('/vendor/html5shiv/html5shiv.min.js') }}"></script>
        <![endif]-->

    <!--[if lt IE 10]>
        <script src="{{ asset('vendor/media-match/media.match.min.js') }}"></script>
        <script src="{{ asset('vendor/respond/respond.min.js') }}"></script>
        <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/public_function.js') }}"></script>
    <script src="{{ asset('vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
        Breakpoints();
    </script>
    @livewireStyles
</head>

<body
    class="@auth animsition
    site-navbar-small dashboard @endauth

@guest
animsition page-login layout-full page-dark @endguest">
    <div id="app">
        @auth

            {{-- {{ auth()->user()->roles->role_name }} --}}

            @include('layouts.navbars')

            @include('layouts.navbarsleft')

        @endauth

        @yield('content')

        @auth
            @include('layouts.footer')
        @endauth

    </div>

    <script src="{{ asset('vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>

    <script src="{{ asset('vendor/popper-js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/animsition/animsition.js') }}"></script>
    <script src="{{ asset('vendor/mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
    <script src="{{ asset('vendor/asscrollable/jquery-asScrollable.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('vendor/switchery/switchery.js') }}"></script>
    <script src="{{ asset('vendor/intro-js/intro.js') }}"></script>
    <script src="{{ asset('vendor/screenfull/screenfull.js') }}"></script>
    <script src="{{ asset('vendor/slidepanel/jquery-slidePanel.js') }}"></script>
    {{-- <script src="{{ asset('vendor/chartist/chartist.js') }}"></script>
    <script src="{{ asset('vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js') }}"></script> --}}
    <script src="{{ asset('vendor/aspieprogress/jquery-asPieProgress.js') }}"></script>
    <script src="{{ asset('vendor/matchheight/jquery.matchHeight-min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-selective/jquery-selective.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/bootstrap-datepicker.th.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/bootstrap-datepicker-thai.js') }}"></script>

    <script src="{{ asset('vendor/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-fixedheader/dataTables.fixedHeader.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-rowgroup/dataTables.rowGroup.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-scroller/dataTables.scroller.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/buttons.flash.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/buttons.print.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/buttons.colVis.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js') }}"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/Component.js') }}"></script>
    <script src="{{ asset('js/Plugin.js') }}"></script>
    <script src="{{ asset('js/Base.js') }}"></script>
    <script src="{{ asset('js/Config.js') }}"></script>

    <script src="{{ asset('assets') }}/js/Section/Menubar.js"></script>
    <script src="{{ asset('assets') }}/js/Section/Sidebar.js"></script>
    <script src="{{ asset('assets') }}/js/Section/PageAside.js"></script>
    <script src="{{ asset('assets') }}/js/Plugin/menu.js"></script>

    <!-- Config -->
    <script src="{{ asset('js/config/colors.js') }}"></script>
    <script src="{{ asset('assets') }}/js/config/tour.js"></script>
    <script>
        Config.set('assets', '{{ asset('assets') }}');
    </script>

    <!-- Page -->
    <script src="{{ asset('assets') }}/js/Site.js"></script>
    <script src="{{ asset('js/Plugin/asscrollable.js') }}"></script>
    <script src="{{ asset('js/Plugin/slidepanel.js') }}"></script>
    <script src="{{ asset('js/Plugin/switchery.js') }}"></script>
    <script src="{{ asset('js/Plugin/matchheight.js') }}"></script>
    <script src="{{ asset('js/Plugin/aspieprogress.js') }}"></script>
    <script src="{{ asset('js/Plugin/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/Plugin/jt-timepicker.js') }}"></script>
    <script src="{{ asset('js/Plugin/asscrollable.js') }}"></script>

    {{-- <script src="{{ asset('assets') }}/examples/js/dashboard/team.js"></script> --}}

    <script src="{{ asset('js/Plugin/datatables.js') }}"></script>
    <script src="{{ asset('js/tables/datatable.js') }}"></script>

    {{-- sweetalert --}}
    <script src="{{ asset('vendor/bootstrap-sweetalert/sweetalert.js') }}"></script>

    {{-- select2 --}}
    <script src="{{ asset('vendor/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('vendor/dropify/dropify.min.js') }}"></script>

    <script src="{{ asset('js/Plugin/input-group-file.js') }}"></script>

    <script src="{{ asset('js/Plugin/bootbox.js') }}"></script>
    <script src="{{ asset('js/advanced/bootbox-sweetalert.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
    @stack('js')
</body>

</html>
