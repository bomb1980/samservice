<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-inverse" role="navigation">

    <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
            data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
            data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </button>
        <a class="navbar-brand navbar-brand-center" href="{{ url('home') }}">
            <img class="navbar-brand-logo navbar-brand-logo-normal" src="{{ asset('assets') }}/images/logo_ooap.png"
                title="PBMS">
            <img class="navbar-brand-logo navbar-brand-logo-special" src="{{ asset('assets') }}/images/logo_ooap.png"
                title="OOAP">
            {{-- <span class="navbar-brand-text hidden-xs-down"> Remark</span> --}}
            {{-- <div class="navbar-brand-text hidden-xs-down">
                PBMS
            </div>
            <div class="navbar-brand-text hidden-xs-down">
                ระบบบริหารจัดการข้อมูลแผนงาน โครงการ และงบประมาณ (สป.)
            </div> --}}
        </a>
    </div>

    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                <li class="nav-item hidden-float" id="toggleMenubar">
                    <a class="nav-link" data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>
                {{-- <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                    <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li> --}}
                <li class="nav-item hidden-sm-down texttitle">
                    <div class="row">
                        <div class="col txt-sysname">
                            OOAP
                        </div>
                    </div>
                    <div class="row">
                        <div class="col txt-sysname">
                            ระบบบริหารข้อมูลโครงการแก้ไขปัญหาความเดือดร้อนด้านอาชีพ
                        </div>
                    </div>
                </li>
            </ul>
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                @auth
                    <li class="nav-item hidden-float" id="toggleMenubar">
                        <a class="nav-link" data-toggle="menubar" href="#" role="button">
                            <i class="icon hamburger hamburger-arrow-left">
                                <span class="sr-only">Toggle menubar</span>
                                <span class="hamburger-bar"></span>
                            </i>
                        </a>
                    </li>
                </ul>
                <!-- End Navbar Toolbar -->

                <!-- Navbar Toolbar Right -->
                <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right nav_icon">
                    {{-- laug --}}
                    {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
                        aria-expanded="false" role="button">
                        <span class="flag-icon flag-icon-us"></span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                            <span class="flag-icon flag-icon-gb"></span> English</a>
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                            <span class="flag-icon flag-icon-fr"></span> French</a>
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                            <span class="flag-icon flag-icon-cn"></span> Chinese</a>
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                            <span class="flag-icon flag-icon-de"></span> German</a>
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                            <span class="flag-icon flag-icon-nl"></span> Dutch</a>
                    </div>
                </li> --}}
                    {{-- <li class="nav-item dropdown">
                    <a class="nav-link" href="http://eoffice.tcmtapp.com" target="_blank" role="button">
                        <span class="browser">
                            <img src="{{ asset('assets') }}/images/browser1.png" alt="กลับหน้า e-Office">
                        </span>
                    </a>
                </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="http://eoffice.tcmtapp.com)" target="_blank"
                            role="button">
                            <i class="icon wb-layout" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">

                        <a style="position: relative;" class="nav-link my-bell" data-toggle="dropdown"
                            href="javascript:void(0)" title="Notifications" aria-expanded="false" data-animation="scale-up"
                            role="button">
                            <i class="icon wb-bell" aria-hidden="true"></i>
                            {!! $badge !!}
                            {{-- <span class="badge badge-pill badge-danger up">1</span> --}}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">

                            <div class="dropdown-menu-header">
                                <h5>การแจ้งเตือน</h5>
                            </div>

                            <div class="list-group">
                                <div data-role="container">
                                    <div data-role="content">

                                        @foreach ($datas as $kd => $vd)
                                            <a class="list-group-item dropdown-item" href="{{ $vd->noti_link }}"
                                                role="menuitem">
                                                <div class="media">
                                                    <div class="pr-10">
                                                        <i class="icon wb-order bg-red-600 white icon-circle"
                                                            aria-hidden="true"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading">{{ $vd->noti_name }}</h6>
                                                        <span>{{ getTimeAgo($vd->noti_date, now()) }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-menu-footer">
                                <a class="dropdown-item" href="{{route('notifications')}}" role="menuitem">
                                    การแจ้งเตือนทั้งหมด
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link">
                            <div class="row">
                                <small style="font-size: 12px;">{{ show_name() }}</label>
                            </div>
                            <div class="row">
                                <small style="font-size: 12px;">{{ show_dept_name() }}</label>
                            </div>
                        </a>
                    </li>
                    {{-- profile start --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                            data-animation="scale-up" role="button">
                            <span class="avatar avatar-online">
                                {{-- <img src="{{ asset(getProfileImg()) }}" alt="..."> --}}
                                <img src="{{ asset('assets') }}/images/logo_umts.png" alt="...">
                                <i></i>
                            </span>
                        </a>
                        <div class="dropdown-menu" role="menu">
                            {{-- <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user"
                                    aria-hidden="true"></i> Profile</a>
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-payment"
                                    aria-hidden="true"></i> Billing</a>
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-settings"
                                    aria-hidden="true"></i> Settings</a>
                            <div class="dropdown-divider" role="presentation"></div> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                            <i class="icon wb-power" aria-hidden="true"></i> Logout
                        </a> --}}
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon wb-power" aria-hidden="true"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    {{-- profile end --}}
                </ul>
            @endauth
            <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
    </div>
</nav>


<script>
    $(function() {

        $('.my-bell').click(function() {



            $.ajax({
                type: 'POST',
                url: '{{ route('readNoti') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $( '.noti-badg').remove();
                    // $("#msg").html(data.msg);
                }
            });

        });
    });
</script>
