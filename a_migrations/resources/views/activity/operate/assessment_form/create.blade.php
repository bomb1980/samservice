<!doctype html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ระบบบริหารจัดการข้อมูลแผนงาน โครงการ และงบประมาณ (สป.)') }}</title>

    <link rel="apple-touch-icon" href="{{ asset('assets') }}/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extend.css') }}">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/site_candidate.css">
    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/aspieprogress/asPieProgress.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-selective/jquery-selective.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/timepicker/jquery-timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets') }}/examples/css/dashboard/team.css">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/dropify.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables/datatable.css') }}">

    {{-- private-config --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    {{-- fa icon --}}
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/font-awesome.min.css') }}">

    {{-- sweetalert-css --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-sweetalert/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/examples/css/layouts/headers.css') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/brand-icons/brand-icons.min.css') }}">
    {{-- <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'> --}}
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet'
        type='text/css'>

    <!-- Styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}">
    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/breakpoints/breakpoints.js') }}"></script>

    <style>
        .panel_ {
            border: 2.5px solid #8bd38a;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            border-radius: 1rem;
        }

        .ssdddsfdsdsf {
            margin: auto;
            max-width: 995px;
            position: relative;
        }

        .overflow {
            overflow: auto;
        }

        .my-table {
            min-width: 100%;
        }

        .th50 {
            width: 50%;
        }

        @media (max-width: 980px) {


            .th50 {
                width: 30%;
            }

        }
    </style>


</head>
@livewireStyles
<style>
    body {
        font-family: 'Kanit', sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label,
    span,
    p {
        font-family: 'Kanit', sans-serif;
    }
</style>

<body class=" dashboard">
    <div class="page">
        <livewire:activity.operate.assessment-form.add-component act_id="{{ $act_id }}"
            p_id="{{ $p_id }}" />
    </div>
    <footer class="site-footer">
        <div class="text-center">สงวนลิขสิทธิ์ © 2564 กระทรวงแรงงาน</div>
    </footer>
    @livewireScripts
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
    <script src="{{ asset('vendor/timepicker/jquery.timepicker.min.js') }}"></script>

    <script src="{{ asset('vendor/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
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
    <script src="{{ asset('vendor/bootstrap-sweetalert/sweetalert.js') }}"></script>

    <script src="{{ asset('js/Plugin/bootbox.js') }}"></script>
    <script src="{{ asset('js/advanced/bootbox-sweetalert.js') }}"></script>

    {{-- browse file --}}
    <script src="{{ asset('js/Plugin/input-group-file.js') }}"></script>

    <script src="{{ asset('vendor/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    @stack('js')
</body>

</html>
{{--
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">แบบประเมินความพึงพอใจ</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item active">บันทึกเวลาเข้าร่วมกิจกรรม</li>
            </ol>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <div class="page-content container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            @livewire('activity.operate.assessment-form.add-component', ['act_id' => $act_id, 'p_id' => $p_id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
