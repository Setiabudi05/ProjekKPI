<nav class="navbar navbar-expand navbar-light pt-4 px-4">
    <div class="container-fluid bg-white shadow-sm rounded-pill px-4 py-2" style="border: 1px solid #e8e8e9;">
        {{-- Burger Button untuk Mobile --}}
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3 text-primary"></i>
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- Search Bar Transparan --}}
            <div class="d-none d-md-flex align-items-center">
                <div class="input-group input-group-sm rounded-pill px-3 py-1" style="width: 300px; background-color: rgba(231, 234, 243, 0.6);">
                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-transparent border-0 shadow-none ps-0" placeholder="Cari data...">
                </div>
            </div>

            <ul class="navbar-nav ms-auto mb-lg-0 align-items-center">
                {{-- Notifikasi --}}
                <li class="nav-item dropdown me-2">
                    <a class="nav-link text-gray-500 position-relative p-2" href="#" data-bs-toggle="dropdown">
                        <i class='bi bi-bell fs-5'></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle border border-white" style="margin-top: 8px; margin-left: -5px;"></span>
                    </a>
                </li>

                <div class="vr mx-3 opacity-25" style="height: 30px; align-self: center;"></div>

                {{-- User Profile --}}
                <li class="nav-item dropdown">
                    <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center gap-2 text-decoration-none py-1">
                        <div class="user-name text-end d-none d-sm-block">
                            <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;">{{ Auth::user()->name }}</h6>
                            <p class="mb-0 text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Admin</p>
                        </div>
                        <div class="avatar avatar-md border border-light shadow-sm">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=435ebe&color=fff" 
                                 class="rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 py-2 px-2" style="min-width: 200px; border-radius: 15px;">
                        <li><h6 class="dropdown-header small text-uppercase text-muted fw-bold">Pengaturan Sesi</h6></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="bi bi-person me-2"></i> Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger fw-bold rounded-3 py-2" href="#" id="logout-btn-navbar">
                            <i class="bi bi-power me-2"></i> Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Form Logout Hidden --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

{{-- Script Konfirmasi Logout --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutActions = ['logout-btn-sidebar', 'logout-btn-navbar'];
        logoutActions.forEach(id => {
            const btn = document.getElementById(id);
            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Keluar dari Sistem?',
                        text: "Sesi Anda akan berakhir setelah ini.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#435ebe',
                        cancelButtonColor: '#ff7976',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        borderRadius: '15px'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    })
                });
            }
        });
    });
</script>