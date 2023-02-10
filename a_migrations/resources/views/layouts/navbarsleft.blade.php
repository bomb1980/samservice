@if ( !isset($activePage)   )
$activePage = NULL;

@endif
<div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
        <ul class="site-menu" data-plugin="menu"> {!! show_menu( $activePage ) !!} </ul>
        @php
            // $show_menu = show_menu();
        @endphp
        {{-- @if ($show_menu)
            <ul class="site-menu" data-plugin="menu">
                @foreach ($show_menu as $val_h)
                    <li
                        class="dropdown site-menu-item has-sub {{ $activePage == $val_h['activepage_name'] ? ' active' : '' }}">
                        <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon {{ $val_h['menu_icon'] }}" aria-hidden="true"></i>
                            <span class="site-menu-title">{{ $val_h['menu_name'] }}</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="site-menu-scroll-wrap is-list">
                                <ul class="site-menu-sub site-menu-normal-list">
                                    @foreach ($val_h['submenu'] as $key => $val_sub)
                                        @if ($val_sub['route_name'])
                                            <li class="site-menu-item">
                                                <a class="animsition-link" href="{{ route($val_sub['route_name']) }}">
                                                    <span class="site-menu-title">{{ $val_sub['submenu_name'] }}</span>
                                                </a>
                                            </li>
                                        @else
                                            @if ($val_sub['submenu_id'])
                                                <li class="site-menu-item has-sub">
                                                    <a href="javascript:void(0)" class="">
                                                        <span
                                                            class="site-menu-title">{{ $val_sub['submenu_name'] }}</span>
                                                        <span class="site-menu-arrow"></span>
                                                    </a>
                                                    <ul class="site-menu-sub">
                                                        @foreach ($val_sub['submenu1'] as $submenu1)
                                                            <li class="site-menu-item">
                                                                <a class="animsition-link "
                                                                    href="{{ route($submenu1['route_name1']) }}">
                                                                    <span class="site-menu-title">-
                                                                        {{ $submenu1['submenu1_name'] }}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif --}}
    </div>
</div>
