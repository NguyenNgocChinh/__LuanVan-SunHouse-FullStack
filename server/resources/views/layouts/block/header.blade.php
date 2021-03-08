<header class="bg-white shadow">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white d-flex justify-content-between ">
        <a class="navbar-brand" href="#">
            <img class="logo ml-0 pl-0" src="{{ asset('./favicon.svg') }}" alt="logo">
        </a>
        <!-- ******************** -->
        @if (Auth::guest())
            <div class="sign-in-up d-none d-sm-block d-m d-lg-none">

                <ul class="navbar-nav">
                    <li class="nav-item d-flex align-items-center ml-5 pl-5 pt-2">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user"></i> Đăng nhập
                        </a>
                        <p class="disable px-0 mb-0" style="opacity: 0.5;">/</p>
                        <a class="nav-link" href="{{ route('register') }}">Đăng ký
                        </a>
                    </li>
                </ul>
            </div>
        @else
            <div class="has-login d-flex justify-content-center">
                <ul class="navbar-nav mt-2">
                    <li class="nav-item text-center">
                        <!-- Settings Dropdown -->
                        <div class=" d-lg-none sm:flex sm:items-center mx-5 mt-1">
                            <x-jet-dropdown align="center" width="48">
                                <x-slot name="trigger">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <button
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none border-gray-300 transition duration-150 ease-in-out pl-2">
                                            <div class="mt-2 mr-1">{{ Auth::user()->name }}
                                            </div>
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="{{ Auth::user()->profile_photo_url }}"
                                                alt="{{ Auth::user()->name }}" />
                                        </button>
                                    @else
                                        <button
                                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <div>{{ Auth::user()->name }}</div>

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    @endif
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>

                                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </x-jet-dropdown-link>

                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                            {{ __('API Tokens') }}
                                        </x-jet-dropdown-link>
                                    @endif

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Management -->
                                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>

                                        <!-- Team Settings -->
                                        <x-jet-dropdown-link
                                            href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-jet-dropdown-link>

                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-jet-dropdown-link>
                                        @endcan

                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-jet-switchable-team :team="$team" />
                                        @endforeach

                                        <div class="border-t border-gray-100"></div>
                                    @endif

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Logout') }}
                                        </x-jet-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </li>
                </ul>
            </div>
        @endif


        <!-- ******************** -->
        <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container-fluid">
            <div class="collapse navbar-collapse d-lg-flex d-xl-flex justify-content-between" id="navbarNav">
                <div></div>
                <div></div>
                <div class="text-center">
                    <ul class="navbar-nav">
                        <li class="nav-item active pr-4">
                            <a class="nav-link" href="{{ route('trangchu_user') }}">Trang chủ<span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item pr-4" style="position: relative;">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">Tài sản</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/search">Tất cả</a>
                                <a class="dropdown-item" href="/search?type=thue">Thuê</a>
                                <a class="dropdown-item" href="/search?type=ban">Bán</a>
                            </div>
                        </li>
                        <li class="nav-item pr-4">
                            <a class="nav-link" href="/daily">Đại lý</a>
                        </li>
                        <li class="nav-item pr-4">
                            <a class="nav-link" href="/lienhe">Liên hệ</a>
                        </li>
                        <li class="nav-item pr-4">
                            <a class="nav-link" href="/hotro">Hỗ trợ</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-right text-center">
                    <ul class="navbar-nav">
                        @if (Auth::guest())
                            <li
                                class="nav-item d-xl-flex d-lg-flex align-items-center d-sm-none d-md-none d-lg-block mr-4">
                                <a class="nav-link d-lg-inline" href="{{ route('login') }}">
                                    <i class="fas fa-user"></i> Đăng nhập
                                </a>
                                <p class="disable d-none d-lg-block d-xl-block px-0 mb-0" style="opacity: 0.5;">
                                    /</p>
                                <a class="nav-link" href="{{ route('register') }}">
                                    Đăng ký
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <!-- Settings Dropdown -->
                                <div class="d-none d-lg-block mr-5 mt-1">
                                    <x-jet-dropdown align="left" width="48">
                                        <x-slot name="trigger">
                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                <button
                                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none border-gray-300 transition duration-150 ease-in-out pl-2">
                                                    <div class="mt-2 mr-1">{{ Auth::user()->name }}
                                                    </div>
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                        src="{{ Auth::user()->profile_photo_url }}"
                                                        alt="{{ Auth::user()->name }}" />
                                                </button>
                                            @else
                                                <button
                                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                                    <div>{{ Auth::user()->name }}</div>

                                                    <div class="ml-1">
                                                        <svg class="fill-current h-4 w-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            @endif
                                        </x-slot>

                                        <x-slot name="content">
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Manage Account') }}
                                            </div>

                                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                                {{ __('Profile') }}
                                            </x-jet-dropdown-link>

                                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                                    {{ __('API Tokens') }}
                                                </x-jet-dropdown-link>
                                            @endif

                                            <div class="border-t border-gray-100"></div>

                                            <!-- Team Management -->
                                            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('Manage Team') }}
                                                </div>

                                                <!-- Team Settings -->
                                                <x-jet-dropdown-link
                                                    href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                                    {{ __('Team Settings') }}
                                                </x-jet-dropdown-link>

                                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                    <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                        {{ __('Create New Team') }}
                                                    </x-jet-dropdown-link>
                                                @endcan

                                                <div class="border-t border-gray-100"></div>

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('Switch Teams') }}
                                                </div>

                                                @foreach (Auth::user()->allTeams() as $team)
                                                    <x-jet-switchable-team :team="$team" />
                                                @endforeach

                                                <div class="border-t border-gray-100"></div>
                                            @endif

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                    {{ __('Logout') }}
                                                </x-jet-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </div>
                            </li>

                        @endif

                        <li class="nav-item d-xl-flex
                        d-lg-flex align-items-center">
                            <button class="btn-gui-tai-san btn
                            btn-outline-danger bg_button text-white rounded-pill px-4 py-2" type="button">
                                <a href="{{ route('thembaidang') }}" class="text-white btn btn-sm p-0">
                                    <i class="fas fa-plus mr-2"></i>
                                    Gửi tài sản
                                </a>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
