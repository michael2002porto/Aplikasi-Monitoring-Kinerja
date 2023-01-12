<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Monitoring Kinerja</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= strtolower($active_sidebar) == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <!-- Nav Item - Bidang Collapse Menu -->
    <li
        class="nav-item <?= in_array(strtolower($active_sidebar), ['tambah_bidang', 'daftar_bidang']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBidang" aria-expanded="true"
            aria-controls="collapseBidang">
            <i class="fas fa-fw fa-cog"></i>
            <span>Bidang</span>
        </a>
        <div id="collapseBidang"
            class="collapse <?= in_array(strtolower($active_sidebar), ['tambah_bidang', 'daftar_bidang']) ? 'show' : '' ?>"
            aria-labelledby="headingBidang" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Bidang:</h6> -->
                <a class="collapse-item <?= strtolower($active_sidebar) == 'tambah_bidang' ? 'active' : '' ?>"
                    href="create_bidang.php">Tambah Bidang</a>
                <a class="collapse-item <?= strtolower($active_sidebar) == 'daftar_bidang' ? 'active' : '' ?>"
                    href="bidang.php">Daftar Bidang</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Jabatan Collapse Menu -->
    <li
        class="nav-item <?= in_array(strtolower($active_sidebar), ['tambah_jabatan', 'daftar_jabatan']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJabatan"
            aria-expanded="true" aria-controls="collapseJabatan">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Jabatan</span>
        </a>
        <div id="collapseJabatan"
            class="collapse <?= in_array(strtolower($active_sidebar), ['tambah_jabatan', 'daftar_jabatan']) ? 'show' : '' ?>"
            aria-labelledby="headingJabatan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Jabatan:</h6> -->
                <a class="collapse-item <?= strtolower($active_sidebar) == 'tambah_jabatan' ? 'active' : '' ?>"
                    href="create_jabatan.php">Tambah Jabatan</a>
                <a class="collapse-item <?= strtolower($active_sidebar) == 'daftar_jabatan' ? 'active' : '' ?>"
                    href="jabatan.php">Daftar Jabatan</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Karyawan Collapse Menu -->
    <li
        class="nav-item <?= in_array(strtolower($active_sidebar), ['tambah_karyawan', 'daftar_karyawan']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKaryawan"
            aria-expanded="true" aria-controls="collapseKaryawan">
            <i class="fas fa-fw fa-person-booth"></i>
            <span>Karyawan</span>
        </a>
        <div id="collapseKaryawan"
            class="collapse <?= in_array(strtolower($active_sidebar), ['tambah_karyawan', 'daftar_karyawan']) ? 'show' : '' ?>"
            aria-labelledby="headingKaryawan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Karyawan:</h6> -->
                <a class="collapse-item <?= strtolower($active_sidebar) == 'tambah_karyawan' ? 'active' : '' ?>"
                    href="create_pegawai.php">Tambah Karyawan</a>
                <a class="collapse-item <?= strtolower($active_sidebar) == 'daftar_karyawan' ? 'active' : '' ?>"
                    href="daftar_karyawan.php">Daftar Karyawan</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Jabatan Collapse Menu -->
    <li
        class="nav-item <?= in_array(strtolower($active_sidebar), ['tambah_absensi', 'daftar_absensi']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAbsensi"
            aria-expanded="true" aria-controls="collapseAbsensi">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Absensi</span>
        </a>
        <div id="collapseAbsensi"
            class="collapse <?= in_array(strtolower($active_sidebar), ['tambah_absensi', 'daftar_absensi']) ? 'show' : '' ?>"
            aria-labelledby="headingAbsensi" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Absensi:</h6> -->
                <a class="collapse-item <?= strtolower($active_sidebar) == 'tambah_absensi' ? 'active' : '' ?>"
                    href="tambah_absensi.html">Tambah Absensi</a>
                <a class="collapse-item <?= strtolower($active_sidebar) == 'daftar_absensi' ? 'active' : '' ?>"
                    href="daftar_absensi.html">Daftar Absensi</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Kinerja
    </div>

    <!-- Nav Item - Pekerjaan Collapse Menu -->
    <li
        class="nav-item <?= in_array(strtolower($active_sidebar), ['tambah_pekerjaan', 'daftar_pekerjaan']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePekerjaan"
            aria-expanded="true" aria-controls="collapsePekerjaan">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pekerjaan</span>
        </a>
        <div id="collapsePekerjaan"
            class="collapse <?= in_array(strtolower($active_sidebar), ['tambah_pekerjaan', 'daftar_pekerjaan']) ? 'show' : '' ?>"
            aria-labelledby="headingPekerjaan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= strtolower($active_sidebar) == 'tambah_pekerjaan' ? 'active' : '' ?>"
                    href="create_pekerjaan.php">Tambah Pekerjaan</a>
                <a class="collapse-item <?= strtolower($active_sidebar) == 'daftar_pekerjaan' ? 'active' : '' ?>"
                    href="pekerjaan.php">Daftar Pekerjaan</a>
            </div>
        </div>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->