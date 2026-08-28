<div id="Top_bar">
    <div class="container">
        <div class="column one">
            <div class="top_bar_left clearfix">
                <!-- Logo-->
                <div class="logo">
                    <h1><a id="logo" href="/" title=""><img class="scale-with-grid" src="{{ asset('assets/frontend/images/logo1.png') }}" /></a></h1>
                </div>

                <!-- Main menu-->
                <div class="menu_wrapper">
                    <nav id="menu">
                        <ul id="menu-main-menu" class="menu">
                            @foreach ($induk as $i => $menu)
                                @php
                                    $isLoginMenu =
                                        Str::contains(strtolower($menu->uri), 'login') ||
                                        Str::contains(strtolower($menu->nama), 'login');
                                @endphp

                                @if ($isLoginMenu)
                                    {{-- Jika user sudah login, ubah menu login jadi Dashboard --}}
                                    @if (auth()->check())
                                        <li>
                                            <a href="{{ url('68b467d9-34c8-4163-8740-e256750ac1eb') }}">
                                                <span><i class="icon-layout themecolor"></i> Dashboard</span>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ url('2a8eb689-e145-4d6c-9bc4-f9e1654f6ad7') }}">
                                                <span><i class="{{ $menu->icon }}"></i> {{ ucwords($menu->nama) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    @php
                                        $uri = trim($menu->uri, '/');
                                        $currentPath = request()->path();
                                        $currentUrl  = url()->current();
                                        $isHomeMenu = ($uri === '');
                                        $onHomePage = ($currentPath === '' || $currentUrl === url('/'));
                                        $isActiveOther = (!$isHomeMenu && Str::startsWith($currentPath, $uri));
                                    @endphp

                                    <li class="{{ $isHomeMenu ? ($onHomePage ? 'current_page_item' : '') : ($isActiveOther ? 'current_page_item' : '') }}">
                                        <a href="{{ url($menu->uri) }}">
                                            <span>
                                                <i class="{{ $menu->icon }}"></i>
                                                {{ ucwords($menu->nama) }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </nav><a class="responsive-menu-toggle" href="#"><i class="icon-menu"></i></a>
                </div>

                <!-- Secondary menu area - only for certain pages -->
                <div class="secondary_menu_wrapper">
                    <!-- #secondary-menu -->
                </div>

                <!-- Banner area - only for certain pages-->
                <div class="banner_wrapper"></div>

                <!-- Header Searchform area-->
                <div class="search_wrapper">
                    <!-- #searchform -->
                    <form method="get" action="">
                        <i class="icon_search icon-search"></i>
                        <a href="#" class="icon_close"><i class="icon-cancel"></i></a>
                        <input type="text" class="field" name="s" placeholder="Enter your search" />
                        <input type="submit" class="submit flv_disp_none" value="" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
