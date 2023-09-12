<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @if (auth()->user()->role == 'admin')
            <li class="nav-item ">
                <a class="nav-link {{ request()->is('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin', 'admincreate', 'adminedit', 'admindaerah', 'admindaerahcreate', 'admindaerahedit', 'daerahreate','daerah', 'daerahedit', 'supir', 'supircreate', 'supiredit', 'penumpang', 'penumpangcreate', 'penumpangedit','Kota', 'Kotacreate', 'Kotaedit') ? '' : 'collapsed' }}"
                    data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person"></i><span>Akun</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav"
                    class="nav-content collapse {{ request()->is('admin', 'admincreate', 'adminedit', 'admindaerah', 'daerahreate', 'admindaerahedit', 'daerah','daerahedit', 'supir', 'supircreate', 'supiredit', 'penumpang', 'penumpangcreate', 'penumpangedit', 'Kota', 'Kotacreate', 'Kotaedit') ? ' show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.admin.index') }}"
                            class="{{ request()->is('admin', 'admincreate', 'adminedit') ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Admin</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is( 'admindaerah', 'admindaerahcreate', 'daerahreate', 'daerah','admindaerahedit', 'daerahedit','Kota', 'Kotacreate', 'Kotaedit' ) ? '' : 'collapsed' }}"
                            data-bs-target="#daerah-nav" data-bs-toggle="collapse" href="#">
                            <i class="bi bi-circle"></i><span>Akun Admin Daerah</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="daerah-nav"
                            class="nav-content {{ request()->is( 'admindaerah', 'daerah', 'admindaerahcreate', 'daerahreate', 'admindaerahedit', 'daerahedit','Kota', 'Kotacreate', 'Kotaedit' ) ? '' : 'show' }}"
                            data-bs-parent="#sidebar-nav">
                            <li class="ms-4">
                                <a href="{{route('admin.kota.index')}}"
                                    class="{{ request()->is('Kota', 'Kotacreate', 'Kotaedit') ? 'active' : 'collapsed' }}">
                                    <i class="bi bi-circle"></i><span>Kota</span>
                                </a>
                            </li>
                            <li class="ms-4">
                                <a href="{{route('admin.daerah.index')}}"
                                    class="{{ request()->is( 'daerahreate','daerah', 'daerahedit') ? 'active' : 'collapsed' }}">
                                    <i class="bi bi-circle"></i><span>Daerah</span>
                                </a>
                            </li>
                            <li class="ms-4">
                                <a href="{{route('admin.admindaerah.index')}}"
                                    class="{{ request()->is('admindaerah', 'admindaerahcreate', 'admindaerahedit') ? 'active' : 'collapsed' }}">
                                    <i class="bi bi-circle"></i><span>Akun Admin Daerah</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.supir.index') }}"
                            class="{{ request()->is('supir', 'supircreate', 'supiredit') ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Supir</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.penumpang.index') }}"
                            class="{{ request()->is('penumpang', 'penumpangcreate', 'penumpangedit') ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Penumpang</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link {{ request()->is('laporan') ? '' : 'collapsed' }}" href="users-profile.html">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Laporan</span>
                </a>
            </li><!-- End Profile Page Nav -->
        @elseif (auth()->user()->role == 'admindaerah')
            <li class="nav-item ">
                <a class="nav-link {{ request()->is('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item ">
                <a class="nav-link {{ request()->is('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="bi bi-clock"></i>
                    <span>Jadwal Pemberakatan</span>
                </a>
            </li><!-- End Tiket Travel Nav -->
            <li class="nav-item ">
                <a class="nav-link {{ request()->is('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="bi bi-bus-front"></i>
                    <span>Tiket Travel</span>
                </a>
            </li><!-- End Tiket Travel Nav -->
        @elseif (auth()->user()->role == 'supir')

        @elseif (auth()->user()->role == 'penumpang')
        @endif
    </ul>

</aside><!-- End Sidebar-->
