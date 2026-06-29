<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'KEVALA') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; color: #2c2a25; }
        .font-kevala { font-family: 'Marcellus', serif; letter-spacing: 0.05em; text-transform: lowercase; }
        .sidebar { height: 100vh; background: linear-gradient(rgba(230, 226, 214, 0.88), rgba(230, 226, 214, 0.95)), url('{{ asset("img/kevala_bg.png") }}'); background-size: cover; background-position: center; border-right: none; position: fixed; top: 0; left: 0; width: 280px; overflow-y: auto; z-index: 1000; transition: width 0.3s ease; overflow-x: hidden; white-space: nowrap; }
        .main-content { margin-left: 280px; width: calc(100% - 280px); min-height: 100vh; transition: margin-left 0.3s ease, width 0.3s ease; }
        
        /* Collapsed Sidebar Styles */
        .sidebar.collapsed { width: 80px; }
        .main-content.expanded { margin-left: 80px; width: calc(100% - 80px); }
        .sidebar.collapsed .nav-link { font-size: 0; text-align: center; padding: 12px 0; }
        .sidebar.collapsed .nav-link i { font-size: 1.25rem; margin-right: 0; }
        .sidebar.collapsed .sidebar-heading { justify-content: center !important; margin-top: 1rem !important; padding: 0 !important; }
        .sidebar.collapsed .sidebar-heading span { display: none; }
        .sidebar.collapsed .font-kevala { font-size: 0 !important; text-align: center; }
        .sidebar.collapsed .font-kevala i { font-size: 1.75rem !important; }
        .sidebar .nav-link { color: #3d372e; font-weight: 500; padding: 12px 20px; border-radius: 8px; margin-bottom: 4px; transition: all 0.2s ease; border-left: 4px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #dcd7c9; color: #161c20; border-left: 4px solid #4a473f; }
        .sidebar .nav-link.active { background-color: #d1ccbe; color: #1a1916; border-left: 4px solid #7a7566; }
        .sidebar .nav-link i { margin-right: 12px; }
        .navbar-top { background-color: #ffffff; border-bottom: 1px solid #e6e2d6; z-index: 999; position: sticky; top: 0; }
        .card { border-radius: 16px; border: 1px solid #e6e2d6; box-shadow: 0 4px 24px rgba(0,0,0,0.02); background-color: #ffffff; }
        .card-header { background-color: transparent !important; border-bottom: 1px solid #e6e2d6; color: #161c20; padding: 1.25rem 1.5rem; font-weight: 600; }
        .text-primary-custom { color: #161c20 !important; }
        .bg-primary-custom { background-color: #2c2a25 !important; color: white; }
        .btn-primary-custom { background-color: #3d372e; border-color: #3d372e; color: white; }
        .btn-primary-custom:hover { background-color: #161c20; border-color: #161c20; color: white; }
        .text-muted { color: #5e5645 !important; }
        .table { color: #2c2a25; }
        .card-custom { border: 1px solid #e6e2d6; border-radius: 12px; box-shadow: 0 4px 12px rgba(44, 42, 37, 0.05); }
        #sidebarToggle:hover { background-color: #161c20 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important; transform: translateY(-1px); }
        
        /* Override Bootstrap solid colors with more pastel/white earth tones */
        .bg-primary { background-color: #ffffff !important; border: 1px solid #d5cfba; color: #736952 !important; }
        .bg-info { background-color: #ffffff !important; border: 1px solid #d5cfba; color: #736952 !important; }
        .bg-success { background-color: #ffffff !important; border: 1px solid #a3b18a; color: #5a6644 !important; }
        .bg-danger { background-color: #ffffff !important; border: 1px solid #d5bdaf; color: #9c6644 !important; }
        .text-white { color: inherit !important; }
        .card .card-body h3 { font-weight: 700; margin-top: 10px; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h4 class="text-primary-custom fw-bold mb-4 font-kevala" style="font-size: 2rem;"><i class="bi bi-box-seam" style="font-size: 1.5rem;"></i> kevala</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                
                @if(auth()->user()->hasPermission('qc.upload') || auth()->user()->hasPermission('qc.manual') || auth()->user()->hasPermission('qc.history'))
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Quality Control</span>
                </h6>
                @if(auth()->user()->hasPermission('qc.upload'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('qc.upload') ? 'active' : '' }}" href="{{ route('qc.upload') }}"><i class="bi bi-cloud-upload"></i> Upload Auto QC</a>
                </li>
                @endif
                @if(auth()->user()->hasPermission('qc.manual'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('qc.manual') ? 'active' : '' }}" href="{{ route('qc.manual') }}"><i class="bi bi-pencil-square"></i> Manual QC Input</a>
                </li>
                @endif
                @if(auth()->user()->hasPermission('qc.history'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('qc.history') ? 'active' : '' }}" href="{{ route('qc.history') }}"><i class="bi bi-clock-history"></i> QC History</a>
                </li>
                @endif
                @endif

                @if(auth()->user()->hasPermission('products.index'))
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Master Data</span>
                </h6>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"><i class="bi bi-box"></i> Master Product</a>
                </li>
                @endif
                @if(auth()->user()->hasPermission('inventory.index') || auth()->user()->hasPermission('inventory.mutations'))
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Inventory</span>
                </h6>
                @if(auth()->user()->hasPermission('inventory.index'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}" href="{{ route('inventory.index') }}"><i class="bi bi-layers"></i> Stock</a>
                </li>
                @endif
                @if(auth()->user()->hasPermission('inventory.mutations'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventory.mutations') ? 'active' : '' }}" href="{{ route('inventory.mutations') }}"><i class="bi bi-arrow-left-right"></i> Stock Mutation</a>
                </li>
                @endif
                @endif

                @if(auth()->user()->hasPermission('reports.index'))
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> All Reports</a>
                </li>
                @endif


                <hr>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-flex justify-content-center w-100">
                        @csrf
                        <a class="nav-link text-danger w-100" href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-top px-4 py-3">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <button id="sidebarToggle" class="btn shadow-sm me-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 12px; border: none; background-color: #3d372e; color: white; transition: all 0.2s ease;">
                            <i class="bi bi-chevron-left fs-5"></i>
                        </button>
                        <span class="navbar-brand mb-0 h1 fw-bold">@yield('title')</span>
                    </div>
                    <div class="d-flex align-items-center dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color: #3d372e; font-weight: 500;">
                            <span class="me-2">Hello, {{ Auth::user()->name }}</span>
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="profileDropdown" style="background-color: #fcfbfa; border: 1px solid #e6e2d6 !important;">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Edit Profile</a></li>
                            <li><hr class="dropdown-divider" style="border-color: #e6e2d6;"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Sidebar Toggle
            const sidebar = $('.sidebar');
            const mainContent = $('.main-content');
            const toggleIcon = $('#sidebarToggle i');
            
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.addClass('collapsed');
                mainContent.addClass('expanded');
                toggleIcon.removeClass('bi-chevron-left').addClass('bi-chevron-right');
            }

            $('#sidebarToggle').on('click', function() {
                sidebar.toggleClass('collapsed');
                mainContent.toggleClass('expanded');
                
                const isCollapsed = sidebar.hasClass('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
                
                if (isCollapsed) {
                    toggleIcon.removeClass('bi-chevron-left').addClass('bi-chevron-right');
                } else {
                    toggleIcon.removeClass('bi-chevron-right').addClass('bi-chevron-left');
                }
            });

            @if(session('success'))
                Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
            @endif
            @if(session('error'))
                Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
