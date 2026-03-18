<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Panel')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root {
      --sidebar-width: 260px;
    }

    body {
      background: #f4f6f9;
      min-height: 100vh;
      overflow-x: hidden;
    }

    .admin-shell {
      min-height: 100vh;
    }

    .admin-sidebar {
      width: var(--sidebar-width);
      background: #0f172a;
      color: #e2e8f0;
      position: fixed;
      inset: 0 auto 0 0;
      z-index: 1040;
      overflow-y: auto;
      transition: transform 0.3s ease;
      transform: translateX(0);
    }

    .admin-brand {
      font-size: 1.25rem;
      font-weight: 700;
      color: #ffffff;
      padding: 1rem 1.25rem;
      border-bottom: 1px solid rgba(148, 163, 184, 0.2);
    }

    .sidebar-link {
      color: #cbd5e1;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.65rem 0.9rem;
      border-radius: 0.5rem;
      margin-bottom: 0.3rem;
      font-weight: 500;
    }

    .sidebar-link:hover,
    .sidebar-link.active {
      background: #1e293b;
      color: #ffffff;
    }

    .settings-submenu {
      margin-left: 0.5rem;
      border-left: 2px solid rgba(148, 163, 184, 0.25);
      padding-left: 0.65rem;
      margin-bottom: 0.5rem;
    }

    .settings-submenu .sidebar-link {
      font-size: 0.93rem;
      padding: 0.5rem 0.75rem;
    }

    .admin-content {
      margin-left: var(--sidebar-width);
      min-height: 100vh;
    }

    .admin-topbar {
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      position: sticky;
      top: 0;
      z-index: 1030;
    }

    @media (max-width: 991.98px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }

      .admin-shell.sidebar-open .admin-sidebar {
        transform: translateX(0);
      }

      .admin-content {
        margin-left: 0;
      }

      .admin-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        z-index: 1035;
        display: none;
      }

      .admin-shell.sidebar-open .admin-overlay {
        display: block;
      }
    }
  </style>
  @stack('head')
</head>

<body>
  <div class="admin-shell" id="adminShell">
    <aside class="admin-sidebar p-3">
      <div class="admin-brand mb-3">AQ Admin</div>

      <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
        <i class="bi bi-briefcase"></i>
        <span>Services</span>
      </a>
      <a href="{{ route('admin.blogs.index') }}" class="sidebar-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
        <i class="bi bi-journal-richtext"></i>
        <span>Blogs</span>
      </a>
      <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
        <i class="bi bi-envelope"></i>
        <span>Contacts</span>
      </a>
      <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>Users</span>
      </a>

      <a href="#settingsMenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }}" aria-controls="settingsMenu" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
        <i class="bi bi-gear"></i>
        <span>Settings</span>
      </a>
      <div class="collapse {{ request()->routeIs('admin.settings.*') ? 'show' : '' }} settings-submenu" id="settingsMenu">
        <a href="{{ route('admin.settings.general') }}" class="sidebar-link {{ request()->routeIs('admin.settings.general*') ? 'active' : '' }}">General</a>
        <a href="{{ route('admin.settings.account') }}" class="sidebar-link {{ request()->routeIs('admin.settings.account*') ? 'active' : '' }}">Account</a>
        <a href="{{ route('admin.settings.smtp') }}" class="sidebar-link {{ request()->routeIs('admin.settings.smtp*') ? 'active' : '' }}">SMTP</a>
        <a href="{{ route('admin.settings.environment') }}" class="sidebar-link {{ request()->routeIs('admin.settings.environment*') ? 'active' : '' }}">Environment</a>
        <a href="{{ route('admin.settings.migrations') }}" class="sidebar-link {{ request()->routeIs('admin.settings.migrations*') ? 'active' : '' }}">Migrations</a>
        <a href="{{ route('admin.settings.seo-health') }}" class="sidebar-link {{ request()->routeIs('admin.settings.seo-health*') ? 'active' : '' }}">SEO Health</a>
      </div>
    </aside>

    <div class="admin-overlay" id="adminOverlay"></div>

    <div class="admin-content">
      <nav class="navbar navbar-expand admin-topbar px-3 py-2">
        <button class="btn btn-outline-secondary btn-sm me-3 d-lg-none" id="sidebarToggle" type="button">
          <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand mb-0 h1 fs-5">@yield('title', 'Admin Panel')</span>

        <div class="ms-auto">
          <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
          </form>
        </div>
      </nav>

      <main class="p-4">
        @if(session('success'))
        <div class="alert alert-success">{!! nl2br(e(session('success'))) !!}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function() {
      const shell = document.getElementById('adminShell');
      const toggle = document.getElementById('sidebarToggle');
      const overlay = document.getElementById('adminOverlay');

      if (!shell || !toggle || !overlay) {
        return;
      }

      toggle.addEventListener('click', function() {
        shell.classList.toggle('sidebar-open');
      });

      overlay.addEventListener('click', function() {
        shell.classList.remove('sidebar-open');
      });
    })();
  </script>
  @stack('scripts')
</body>

</html>