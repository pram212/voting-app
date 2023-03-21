<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{asset('images/logo.png')}}" class="thumbnail" alt="logo" width="40px">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        pilpres 2024
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(request()->is('home*')) active @endif">
        <a class="nav-link link" href="{{url('home')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Rekapan
    </div>
   
    <li class="nav-item @if(request()->is('rekapitulasi')) active @endif">
        <a class="nav-link link" href="{{url('rekapitulasi')}}">
            <i class="fas fa-cube fa-fw"></i>
            <span>Rekapan Hasil</span></a>
    </li>

    @can('viewAny', App\Models\User::class)
    <li class="nav-item @if(request()->is('rekapan/saksi')) active @endif">
        <a class="nav-link link" href="{{url('rekapan/saksi')}}">
            <i class="fas fa-users fa-fw"></i>
            <span>Rekapan Saksi</span></a>
    </li>
    @endcan
   

    <!-- Divider -->
    @if (auth()->user()->role == 1)
    
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>
    @endif

    @can('viewAny', App\Models\User::class)
    <li class="nav-item @if(request()->is('pengaturan/user*')) active @endif">
        <a class="nav-link link" href="{{url('pengaturan/user')}}">
            <i class="fas fa-user fa-fw"></i>
            <span>Data Admin</span></a>
    </li>
    @endcan

    @can('viewAny', App\Models\User::class)
    <li class="nav-item @if(request()->is('pengaturan/saksi*')) active @endif">
        <a class="nav-link link" href="{{url('pengaturan/saksi')}}">
            <i class="fas fa-user fa-fw"></i>
            <span>Data Saksi</span></a>
    </li>
    @endcan

    {{-- <hr class="sidebar-divider"> --}}

    @can('viewAny', App\Models\Calon::class)
    <li class="nav-item @if(request()->is('pengaturan/calon*')) active @endif">
        <a class="nav-link link" href="{{url('pengaturan/calon')}}">
            <i class="fas fa-id-card fa-fw"></i>
            <span>Data Calon</span></a>
    </li>
    @endcan

    {{-- <hr class="sidebar-divider"> --}}

    @can('viewAny', App\Models\TPS::class)
    <li class="nav-item @if(request()->is('pengaturan/tps*')) active @endif">
        <a class="nav-link link" href="{{url('pengaturan/tps')}}">
            <i class="fas fa-university fa-fw"></i>
            <span>Data TPS</span></a>
    </li>
    @endcan

    <!-- Nav Item - Pages Collapse Menu -->
    @if (auth()->user()->role == 1)
    <li class="nav-item @if(
        request()->is('pengaturan/provinsi') || 
        request()->is('pengaturan/kota') || 
        request()->is('pengaturan/kecamatan') || 
        request()->is('pengaturan/desa')) active @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-map-marker"></i>
            <span>Data Lokasi</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{url('pengaturan/provinsi')}}">Provinsi</a>
                <a class="collapse-item" href="{{url('pengaturan/kota')}}">Kota</a>
                <a class="collapse-item" href="{{url('pengaturan/kecamatan')}}">Kecamatan</a>
                <a class="collapse-item" href="{{url('pengaturan/desa')}}">Desa</a>
            </div>
        </div>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
