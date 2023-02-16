<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{asset('images/logo.png')}}" class="thumbnail" alt="logo" width="40px">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(request()->is('home*')) active @endif">
        <a class="nav-link" href="{{url('home')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Utama
    </div>
    <li class="nav-item @if(request()->is('rekapitulasi')) active @endif">
        <a class="nav-link" href="{{url('rekapitulasi')}}">
            <i class="fas fa-check fa-fw"></i>
            <span>Hasil Rekapan</span></a>
    </li>

    <li class="nav-item @if(request()->is('rekapitulasi/create')) active @endif">
        <a class="nav-link" href="{{url('rekapitulasi/create')}}">
            <i class="fas fa-plus fa-fw"></i>
            <span>Entry Rekapan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>

    <li class="nav-item @if(request()->is('user*')) active @endif">
        <a class="nav-link" href="{{url('user')}}">
            <i class="fas fa-user fa-fw"></i>
            <span>Data Pengguna</span></a>
    </li>

    <li class="nav-item @if(request()->is('calon*')) active @endif">
        <a class="nav-link" href="{{url('calon')}}">
            <i class="fas fa-id-card fa-fw"></i>
            <span>Data Calon</span></a>
    </li>

    <li class="nav-item @if(request()->is('tps*')) active @endif">
        <a class="nav-link" href="{{url('tps')}}">
            <i class="fas fa-university fa-fw"></i>
            <span>Data TPS</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
