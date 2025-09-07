<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Automated Tax') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: #f3f4f6;
        }
        .dashboard-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .dashboard-header {
            background: #1e3a8a;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .dashboard-header a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.25rem;
        }
        .dashboard-content {
            flex: 1;
            padding: 2rem;
            max-width: 100%;
            overflow-x: hidden;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            text-decoration: none;
            color: #374151;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        .quick-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-color: #d1d5db;
        }
        .quick-action-btn i {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            color: #1e40af;
        }
        .quick-action-btn span {
            font-weight: 500;
            font-size: 0.95rem;
        }
        .dashboard-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        .dashboard-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .dashboard-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }
        .user-menu {
            position: relative;
            display: inline-block;
        }
        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }
        .user-menu-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .user-menu-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            min-width: 200px;
            z-index: 50;
            display: none;
        }
        .user-menu:hover .user-menu-dropdown {
            display: block;
        }
        .user-menu-item {
            display: block;
            padding: 0.75rem 1rem;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s;
        }
        .user-menu-item:hover {
            background: #f3f4f6;
            color: #111827;
        }
        .user-menu-item i {
            margin-right: 0.5rem;
            width: 1.25rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <a href="{{ route('dashboard') }}">
                {{ config('app.name', 'Automated Tax') }}
            </a>
            <div class="user-menu">
                <button class="user-menu-btn">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down ml-1"></i>
                </button>
                <div class="user-menu-dropdown">
                    <a href="{{ route('profile.edit') }}" class="user-menu-item">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="user-menu-item w-full text-left">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="dashboard-content">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>
