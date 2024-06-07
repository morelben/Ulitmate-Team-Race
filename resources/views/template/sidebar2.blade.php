<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"  class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">
                            @if(session()->has('idadmin'))
                                <p>{{ session('nameadmin') }}</p>
                            @endif
                        </div></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="features-profile.html" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="post">
                            @method("delete")
                            @csrf
                            <button type="submit" class="btn btn-icon btn-danger" style="width: 200px"><i class="fas fa-sign-out-alt"></i> Logout</button>
                        </form>
                        <a href="{{ route('reinitialisation') }}"><button type="submit" class="btn btn-icon btn-danger mt-1" style="width: 200px"><i class="fas fa-database"></i> Reinitialiser Base</button></a>
                        <form action="{{ route('generateCategory') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-icon btn-success mt-1" style="width: 200px"><i class="fas fa-play-circle"></i> Generate Category</button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('indexAdmin') }}"><img src="{{ asset('assets/img/logo1.jpg') }}" alt="logo" width="75" height="75" class="shadow-light rounded-circle"></a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{ route('indexAdmin') }}">HR</a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Dashboard</li>
                    <li class="dropdown active">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                        <ul class="dropdown-menu">
                            <li class=active><a class="nav-link" href="{{ route('indexAdmin') }}">Home</a></li>
                        </ul>
                    </li>
                    <li class="menu-header">Managment</li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-trophy"></i> <span>RANKING</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('rankingGByStep') }}">By Step</a></li>
                        </ul>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('rankingGByTeam') }}">By Team</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class=" fas fa-exclamation-triangle"></i> <span>PENALITY</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('penalityList') }}">List</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cloud-download-alt"></i> <span>IMPORT</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('import1') }}">Donner</a></li>
                        </ul>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('import2') }}">Points</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                    <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                        <i class="fas fa-rocket"></i> Documentation
                    </a>
                </div>        </aside>
        </div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</div>
