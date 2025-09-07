<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Automated Tax') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .app-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        .btn-primary {
            display: inline-block;
            width: 100%;
            max-width: 20rem;
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
            font-weight: 500;
            color: white;
            background-color: #2563eb;
            border-radius: 0.5rem;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        .btn-secondary {
            display: inline-block;
            width: 100%;
            max-width: 20rem;
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
            font-weight: 500;
            color: #2563eb;
            background-color: white;
            border: 2px solid #2563eb;
            border-radius: 0.5rem;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .btn-secondary:hover {
            background-color: #eff6ff;
        }
    </style>
</head>
<body style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">
    <div style="width: 100%; max-width: 28rem; margin: 0 auto; text-align: center;">
        <div class="app-logo">
            <i class="fas fa-file-invoice-dollar" style="font-size: 3rem; color: #2563eb;"></i>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937;">{{ config('app.name', 'Automated Tax') }}</h1>
        </div>
        
        @if (Route::has('login'))
            <div style="margin-top: 3rem; display: flex; flex-direction: column; gap: 1rem;">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-secondary">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
