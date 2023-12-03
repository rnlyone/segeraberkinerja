<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="index.html"><span class="brand-logo">
                        <img height="34" width="auto" src="/logokolakautara.png" alt="">
                    </span>
                    <h2 class="brand-text" style="line-height: 1.0;font-size: 1.2rem">SEGERA <br>BERKINERJA</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{$dashboardbar ?? ''}} nav-item mt-2"><a class="d-flex align-items-center"
                    href="{{route('dashboard')}}"><i data-feather="home"></i><span class="menu-title text-truncate"
                        data-i18n="Email">Dashboard</span></a>
            </li>
            @if (auth()->user()->level_user >= 1)
                <li class=" navigation-header"><span data-i18n="Perencanaan">Perencanaan</span><i
                    data-feather="more-horizontal"></i>
                </li>
                <li class="{{$renstrabar ?? ''}} nav-item"><a class="d-flex align-items-center" href="{{route('renstra.index')}}"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Rensta">Rencana Strategis</span></a>
                </li>
                <li class="{{$programbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="{{route('program.index')}}"><i
                    data-feather="archive"></i><span class="menu-title text-truncate"
                    data-i18n="Program">Program</span></a>
                </li>
                {{-- <li class="{{$kegiatanbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="{{route('kegiatan.index')}}"><i
                            data-feather="layers"></i><span class="menu-title text-truncate"
                            data-i18n="Kegiatan">Kegiatan</span></a>
                </li> --}}
            @endif

            @if (auth()->user()->level_user >= 3)
                <li class=" navigation-header"><span data-i18n="Perencanaan">Penganggaran (BPKAD)</span><i
                    data-feather="more-horizontal"></i>
                </li>
                <li class="{{$penganggaranbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="{{route('skpd.index')}}"><i
                            data-feather="layers"></i><span class="menu-title text-truncate"
                            data-i18n="SKPD">Penganggaran</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="menu"></i><span class="menu-title text-truncate" data-i18n="Standar Harga">Standar Harga</span></a>
                    <ul class="menu-content">
                        <li class="{{$sshbar ?? ''}}"><a class="d-flex align-items-center" href="{{route('satuan.index', ['satuan' => 'ssh'])}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="SSH">SSH</span></a></li>
                        <li class="{{$sbubar ?? ''}}"><a class="d-flex align-items-center" href="{{route('satuan.index', ['satuan' => 'sbu'])}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="SBU">SBU</span></a></li>
                        <li class="{{$hspkbar ?? ''}}"><a class="d-flex align-items-center" href="{{route('satuan.index', ['satuan' => 'hspk'])}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="HSPK">HSPK</span></a></li>
                        <li class="{{$asbbar ?? ''}}"><a class="d-flex align-items-center" href="{{route('satuan.index', ['satuan' => 'asb'])}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="ASB">ASB</span></a></li>
                    </ul>
                  </li>
                {{-- <li class="{{$renstrabpkbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="app-chat.html"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Rensta">Rensta</span></a>
                </li>
                <li class="{{$kegiatanbpkbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="app-chat.html"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Kegiatan">Kegiatan</span></a>
                </li>
                <li class=" navigation-header"><span data-i18n="Data Pokok">Data Pokok (Hanya BPKAD)</span><i
                    data-feather="more-horizontal"></i>
                </li>
                <li class="{{$sshbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="app-chat.html"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Rensta">SSH</span></a>
                </li>
                <li class="{{$hspkbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="app-chat.html"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Rensta">HSPK</span></a>
                </li>
                <li class=" navigation-header"><span data-i18n="Pengaturan">Pengaturan</span><i
                        data-feather="more-horizontal"></i>
                </li> --}}
            @endif


            @if (auth()->user()->level_user >= 4)
                <li class="{{$pengaturanbar ?? ''}} nav-item"><a class="d-flex align-items-center" href="app-chat.html"><i
                    data-feather="settings"></i><span class="menu-title text-truncate"
                    data-i18n="Pengaturan">Pengaturan</span></a>
                </li>
            @endif
        </ul>
    </div>
</div>
