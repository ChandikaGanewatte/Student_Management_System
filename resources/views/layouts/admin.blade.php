
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Student Admin')</title>

    {{-- Bootstrap CSS: required for Bootstrap layout and button classes --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Modern font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --admin-primary: #4f46e5;
            --admin-primary-dark: #4338ca;
            --admin-sidebar: #171c35;
            --admin-sidebar-text: #aeb8d0;
            --admin-bg: #f6f7fb;
            --admin-text: #1e293b;
            --admin-muted: #8490a5;
            --admin-border: #e9edf4;
            --sidebar-width: 245px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: 'Inter', Arial, sans-serif;
            font-size: 14px;
        }

        a {
            text-decoration: none;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1030;
            display: flex;
            flex-direction: column;
            width: var(--sidebar-width);
            height: 100vh;
            padding: 25px 16px 18px;
            overflow-y: auto;
            color: white;
            background: var(--admin-sidebar);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 8px 27px;
            border-bottom: 1px solid rgba(255,255,255,.09);
        }

        .admin-brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            color: white;
            background: linear-gradient(135deg, #6366f1, #4338ca);
            border-radius: 13px;
            font-size: 21px;
            box-shadow: 0 5px 15px rgba(79,70,229,.25);
        }

        .admin-brand-name {
            margin: 0;
            color: white;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .3px;
        }

        .admin-brand-caption {
            margin-top: 4px;
            color: #98a4c1;
            font-size: 10px;
        }

        .admin-nav-label {
            padding: 25px 11px 11px;
            color: #7783a1;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 46px;
            padding: 0 13px;
            color: var(--admin-sidebar-text);
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            transition: background .2s, color .2s;
        }

        .admin-nav-link i {
            width: 20px;
            font-size: 17px;
            text-align: center;
        }

        .admin-nav-link:hover {
            color: white;
            background: rgba(255,255,255,.07);
        }

        .admin-nav-link.active {
            color: white;
            background: linear-gradient(100deg, #4f46e5, #5548d9);
            border-color: rgba(255,255,255,.08);
            box-shadow: 0 5px 14px rgba(79,70,229,.19);
        }

        .admin-sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
        }

        .admin-help-card {
            padding: 15px;
            background: rgba(255,255,255,.055);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 12px;
        }

        .admin-help-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            margin-bottom: 12px;
            color: #c7d2fe;
            background: rgba(99,102,241,.2);
            border-radius: 10px;
            font-size: 17px;
        }

        .admin-help-card strong {
            display: block;
            margin-bottom: 5px;
            color: white;
            font-size: 11px;
        }

        .admin-help-card p {
            margin: 0;
            color: #9aa6c2;
            font-size: 10px;
            line-height: 1.7;
        }

        .admin-sidebar-footer {
            padding: 17px 8px 0;
            margin-top: 17px;
            border-top: 1px solid rgba(255,255,255,.09);
            color: #7f8aa5;
            font-size: 10px;
            text-align: center;
        }

        /* Main area */
        .admin-main {
            min-width: 0;
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            min-height: 78px;
            padding: 15px 30px;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid var(--admin-border);
            backdrop-filter: blur(12px);
        }

        .admin-topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .admin-page-title {
            margin: 0;
            color: #1e293b;
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -.4px;
        }

        .admin-page-subtitle {
            margin-top: 5px;
            color: var(--admin-muted);
            font-size: 11px;
        }

        .admin-topbar-right {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-right: 15px;
            border-right: 1px solid var(--admin-border);
        }

        .admin-user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 39px;
            height: 39px;
            color: var(--admin-primary);
            background: #eef2ff;
            border: 1px solid #e0e7ff;
            border-radius: 12px;
            font-size: 17px;
        }

        .admin-user-name {
            display: block;
            max-width: 160px;
            overflow: hidden;
            color: #263247;
            font-size: 12px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-user-role {
            display: block;
            margin-top: 4px;
            color: var(--admin-muted);
            font-size: 10px;
        }

        .admin-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 39px;
            padding: 0 13px;
            color: #dc2626;
            background: #fff;
            border: 1px solid #fee2e2;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 700;
            transition: .2s;
        }

        .admin-logout:hover {
            color: #b91c1c;
            background: #fef2f2;
        }

        .admin-content {
            padding: 27px 30px 35px;
        }

        .admin-alert {
            margin-bottom: 22px;
            border-radius: 10px;
            font-size: 13px;
        }

        .admin-mobile-menu {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            color: #475569;
            background: #f8fafc;
            border: 1px solid var(--admin-border);
            border-radius: 9px;
            font-size: 20px;
        }

        .admin-overlay {
            display: none;
        }

        /* Responsive sidebar */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-mobile-menu {
                display: inline-flex;
            }

            .admin-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1020;
                background: rgba(15,23,42,.45);
            }

            .admin-content {
                padding: 23px 20px 30px;
            }

            .admin-topbar {
                padding: 13px 20px;
            }
        }

        @media (max-width: 575.98px) {
            .admin-topbar {
                min-height: 68px;
                gap: 9px;
                padding: 12px;
            }

            .admin-page-title {
                font-size: 16px;
            }

            .admin-page-subtitle {
                font-size: 10px;
            }

            .admin-user {
                display: none;
            }

            .admin-logout {
                min-height: 36px;
                padding: 0 10px;
            }

            .admin-logout .logout-label {
                display: none;
            }

            .admin-content {
                padding: 19px 12px 25px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

{{-- Mobile sidebar backdrop --}}
<div class="admin-overlay" id="adminOverlay"></div>

{{-- Sidebar --}}
<aside class="admin-sidebar" id="adminSidebar">

    <a href="{{ route('dashboard') }}" class="admin-brand">
        <div class="admin-brand-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>

        <div>
            <h1 class="admin-brand-name">STUDENT ADMIN</h1>
            <div class="admin-brand-caption">Management Portal</div>
        </div>
    </a>

    <div class="admin-nav-label">MAIN MENU</div>

    <nav class="admin-nav">
        <a href="{{ route('dashboard') }}"
           class="admin-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('students.index') }}"
           class="admin-nav-link {{ request()->routeIs('students.index', 'students.show', 'students.edit') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span>Manage Students</span>
        </a>

        <a href="{{ route('students.create') }}"
           class="admin-nav-link {{ request()->routeIs('students.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus-fill"></i>
            <span>Add Student</span>
        </a>
    </nav>

    <div class="admin-sidebar-bottom">
        <div class="admin-help-card">
            <div class="admin-help-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <strong>Student Management</strong>
            <p>Manage student records and keep information organized in one place.</p>
        </div>

        <div class="admin-sidebar-footer">
            Student Management System &copy; {{ now()->year }}
        </div>
    </div>
</aside>

{{-- Main page --}}
<div class="admin-main">

    <header class="admin-topbar">
        <div class="admin-topbar-left">
            <button type="button"
                    class="admin-mobile-menu"
                    id="adminMenuButton"
                    aria-label="Open navigation menu"
                    aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <h2 class="admin-page-title">@yield('heading', 'Dashboard')</h2>
                <div class="admin-page-subtitle">
                    Student Management System / @yield('heading', 'Dashboard')
                </div>
            </div>
        </div>

        <div class="admin-topbar-right">
            @auth
                <div class="admin-user">
                    <div class="admin-user-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div>
                        <span class="admin-user-name">
                            {{ auth()->user()->name }}
                        </span>
                        <span class="admin-user-role">Signed in</span>
                    </div>
                </div>
            @endauth

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf

                <button type="submit" class="admin-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="logout-label">Logout</span>
                </button>
            </form>
        </div>
    </header>

    <main class="admin-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show admin-alert"
                 role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show admin-alert"
                 role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </main>
</div>

{{-- Bootstrap JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    const menuButton = document.getElementById('adminMenuButton');

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        menuButton.setAttribute('aria-expanded', 'false');
    }

    menuButton.addEventListener('click', function () {
        const isOpen = sidebar.classList.toggle('open');

        overlay.classList.toggle('show', isOpen);
        menuButton.setAttribute('aria-expanded', String(isOpen));
    });

    overlay.addEventListener('click', closeSidebar);

    document.querySelectorAll('.admin-nav-link').forEach(function (link) {
        link.addEventListener('click', closeSidebar);
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 991) {
            closeSidebar();
        }
    });
});
</script>

{{-- Child views can add page-specific scripts --}}
@stack('scripts')

</body>
</html>
