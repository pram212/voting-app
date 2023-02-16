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

    <li class="nav-item @if(request()->is('rekapitulasi*') ) active @endif">
        <a class="nav-link @if(request()->is('rekapitulasi*') ) '' @else collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseRekap"
            aria-expanded="true" aria-controls="collapseRekap">
            <i class="fas fa-fw fa-archive"></i>
            <span>Rekapitulasi</span>
        </a>
        <div id="collapseRekap" class="collapse @if(request()->is('rekapitulasi*') ) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('rekapitulasi') ) active @endif" href="{{url('rekapitulasi')}}">Hasil Perhitungan</a>
                <a class="collapse-item @if(request()->is('rekapitulasi/create') ) active @endif" href="{{url('rekapitulasi/create')}}">Input Hasil</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>

    <li class="nav-item @if(request()->is('calon*') || request()->is('jabatan*') ) active @endif">
        <a class="nav-link @if(request()->is('calon*') || request()->is('jabatan*') ) '' @else collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseDataCalon"
            aria-expanded="true" aria-controls="collapseDataCalon">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data Calon</span>
        </a>
        <div id="collapseDataCalon" class="collapse @if(request()->is('calon*') || request()->is('jabatan*') ) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">sub menu:</h6>
                <a class="collapse-item @if(request()->is('calon*') ) active @endif" href="{{url('calon')}}">Daftar Calon</a>
                <a class="collapse-item @if(request()->is('jabatan*') ) active @endif" href="{{url('jabatan')}}">Daftar Jabatan</a>
            </div>
        </div>
    </li>

    <li class="nav-item @if(request()->is('user*')) active @endif">
        <a class="nav-link" href="{{url('user')}}">
            <i class="fas fa-user fa-fw"></i>
            <span>Data Pengguna</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
