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
                title="OOAP">
            <img class="navbar-brand-logo navbar-brand-logo-special" src="{{ asset('assets') }}/images/logo_ooap.png"
                title="OOAP">
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

                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link"href="#" title="คู่มือการใช้งาน">
                            <a class="nav-link"href="{{ route('manual.index') }}" title="คู่มือการใช้งาน">
                            <i class="site-menu-icon wb-book" aria-hidden="true"></i>
                        </a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        {{-- <a class="nav-link" href="https://e-office.mol.go.th/portal" role="button">
                            <i class="icon wb-layout" aria-hidden="true"></i>
                        </a> --}}
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon wb-layout" aria-hidden="true"></i>
                        </a>
                    </li>

                    @livewire('notification.notification-component')

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
                                @if (getEmployeeImg(auth()->user()->user_card))
                                    <img src="{{ getEmployeeImg(auth()->user()->user_card) }}" alt="...">
                                @else
                                    <img src="{{ asset('assets') }}/images/imgnull.png" alt="...">
                                @endif
                            </span>
                        </a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <i class="icon wb-power" aria-hidden="true"></i> ออกจากระบบ
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
