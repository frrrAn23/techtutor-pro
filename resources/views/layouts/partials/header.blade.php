<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
           @if (request()->routeIs('dashboard.student.course.material.show'))
                <div class="navbar-brand-box">
                    <a href="{{ url('/') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('images/logo-techtutor-pro-only.jpg') }}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('images/logo-techtutorpro-horizontal.png') }}" alt="" height="50">
                        </span>
                    </a>

                    <a href="{{ url('/') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('images/logo-techtutor-pro-only.jpg') }}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('images/logo-techtutorpro-horizontal.png') }}" alt="" height="50">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

            @else
                <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                    <div class="btn header-item waves-effect">
                    </div>
                </div>

                <div class="topnav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                            <div class="collapse navbar-collapse" id="topnav-menu-content">
                                <ul class="navbar-nav">

                                    <a class="nav-link" href="{{ route('dashboard.index') }}">
                                        <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboard</span>
                                    </a>

                                    @if (Auth::user()->role->name == App\Enums\RoleEnum::ADMIN)
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                                                <i class="bx bx-user me-2"></i><span key="t-dashboards">Pengguna</span> <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                                <a href="{{ route('dashboard.admin.index') }}" class="dropdown-item" key="t-default">Admin</a>
                                                <a href="{{ route('dashboard.student.index') }}" class="dropdown-item" key="t-saas">Siswa</a>
                                            </div>
                                        </li>

                                        <a class="nav-link" href="{{ route('dashboard.admin.course-category.index') }}">
                                            <i class="bx bx-label me-2"></i><span key="t-dashboards">Kategori kursus</span>
                                        </a>

                                        <a class="nav-link" href="{{ route('dashboard.admin.course.index') }}">
                                            <i class="bx bx-book me-2"></i><span key="t-dashboards">Kursus</span>
                                        </a>

                                        <a class="nav-link" href="{{ route('dashboard.admin.access.index') }}">
                                            <i class="bx bx-key me-2"></i><span key="t-dashboards">User Akses</span>
                                        </a>
                                    @elseif (Auth::user()->role->name == App\Enums\RoleEnum::STUDENT)
                                        <a class="nav-link" href="{{ route('dashboard.student.course.index') }}">
                                            <i class="bx bx-book me-2"></i><span key="t-dashboards">List kursus</span>
                                        </a>

                                        <a class="nav-link" href="{{ route('dashboard.student.course.enrolled') }}">
                                            <i class="bx bx-book-open me-2"></i><span key="t-dashboards">kursus saya</span>
                                        </a>
                                    @endif

                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            @endif
        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ getFile(Auth::user()->avatar_url, asset('images/default-profile.jpg')) }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->username }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <!-- <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a> -->
                    <!-- <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item text-danger" href="#"  onclick="logout()"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>
        </div>
    </div>
</header>
