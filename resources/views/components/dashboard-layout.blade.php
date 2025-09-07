<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Automated Tax') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #1e3a8a;
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar-collapsed {
            width: 70px;
        }
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .sidebar-menu {
            padding: 1rem 0;
        }
        .menu-item {
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.2s;
        }
        .menu-item:hover, .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .menu-item i {
            width: 24px;
            margin-right: 0.75rem;
            text-align: center;
        }
        .menu-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #f3f4f6;
            transition: all 0.3s;
        }
        .main-content-expanded {
            margin-left: 70px;
        }
        .content-wrapper {
            padding: 1.5rem;
        }
        .user-menu {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
        }
        .user-menu-btn {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.375rem;
        }
        .user-menu-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .user-info {
            flex: 1;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-name {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
        }
        .toggle-sidebar {
            position: absolute;
            right: -12px;
            top: 20px;
            background: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 10;
            border: none;
            outline: none;
        }
        .toggle-sidebar i {
            transition: transform 0.3s;
        }
        .toggle-sidebar.collapsed i {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <!-- User Info as Header -->
            <div class="p-4 border-b border-gray-700 bg-blue-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="user-avatar bg-white text-blue-600 w-10 h-10 rounded-full flex items-center justify-center font-semibold text-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-blue-100">
                                @foreach(Auth::user()->roles as $role)
                                    {{ ucfirst($role->name) }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button id="toggleSidebar" class="text-white hover:text-blue-200 transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                
                @role('admin')
                    <a href="#" class="menu-item">
                        <i class="fas fa-users"></i>
                        <span class="menu-text">Users</span>
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-user-tag"></i>
                        <span class="menu-text">Roles & Permissions</span>
                    </a>
                @endrole
                
                <a href="#" class="menu-item">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span class="menu-text">Tax Returns</span>
                </a>
                
                <a href="#" class="menu-item">
                    <i class="fas fa-chart-bar"></i>
                    <span class="menu-text">Reports</span>
                </a>
                
                <a href="#" class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </div>
            
            <div class="user-menu absolute bottom-0 w-full">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-white hover:bg-blue-600 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
            
        </div>
        
        <!-- Main Content -->
        <div id="mainContent" class="main-content flex-1 overflow-auto">
            <div class="content-wrapper">
                {{ $slot }}
            </div>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    
    <script>
        // Toggle user dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');
            
            if (userMenuButton) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        });
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('toggleSidebar');
            
            sidebar.classList.toggle('sidebar-collapsed');
            mainContent.classList.toggle('main-content-expanded');
            toggleBtn.classList.toggle('collapsed');
            
            // Save state in localStorage
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }
        
        // Check for saved user preference, if any, on load
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('sidebar').classList.add('sidebar-collapsed');
                document.getElementById('mainContent').classList.add('main-content-expanded');
                document.getElementById('toggleSidebar').classList.add('collapsed');
            }
        });
    </script>
</body>
        </main>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>